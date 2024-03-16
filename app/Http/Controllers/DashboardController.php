<?php

namespace App\Http\Controllers;

use App\Models\Donations;
use App\Models\Kegiatan;
use App\Models\LogUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        if(Session::get('roles_name') === null){
            Auth::logout();

            return redirect('/login');
        }

        $log = LogUser::take(10)->orderBy('created_at', 'DESC')->get();

        foreach ($log as $key => $value) {
            $user = User::find($value->created_by);
            $tbl = DB::table($value->ref_name)->find($value->ref_id);
            $value->date_convert = date('F d, Y', strtotime($value->created_at));
            // $value->log = 'User ' . $user->name . ' ' . $value->notes;
            $value->log = 'User ' . $value->notes;
        }

        $total_nominal = Donations::query()->where('transaction_status', 'Paid')->sum('total_donation');
        $total_onetime = Donations::query()->where('type', '0')->where('transaction_status', 'Paid')->sum('total_donation');
        $total_sponsorship = Donations::query()->where('type', '1')->where('transaction_status', 'Paid')->sum('total_donation');
        $total_anak_sponsorship = Donations::query()->where('type', '1')->where('transaction_status', 'Paid')->sum('qty');

        $history_donation = Donations::take(5)->where('transaction_status', 'Paid')->orderBy('created_at', 'DESC')->get();

        foreach ($history_donation as $key => $value) {
            $event = Kegiatan::where('id', $value->m_events_id)->first();
            if($event){
                $value->wnsm = $event->place;
            }
        }

        $event = Kegiatan::orderBy('date', 'DESC')->select('id', 'event')->get();

        return view('page.dashboard.index',
        [
            'log_user' => $log,
            'total_nominal' => [
                'total_nominal' => $total_nominal,
                'total_onetime' => $total_onetime,
                'total_sponsorship' => $total_sponsorship,
                'total_anak_terdonasi' => $total_anak_sponsorship
            ],
            "donasi_terbaru" => $history_donation,
            "event_list"     => $event
        ]);
    }

    public function getDetailHistoryEvent($id, Request $request) {
        $event = Kegiatan::query()->select('*');
        $event->with(['getType']);
        $event->withCount(['donationPaid', 'donationUnpaid', 'allDonation',
        'getTotalDonation' => function($query) {
            $query->select(DB::raw('SUM(total_donation)'));
        }]);
        $event->where('m_events.id', $id);
        $result = $event->first();
        $result->time = date('H:i', strtotime($result->date));
        $result->zona = $result->zona == null ? 'WIB' : $result->zona;

        return response()->json(['success' => true, 'data' => $result]);
    }

    public function getStatic(Request $request){
        $param = [
            'search' => $request->search
        ];
        $eventId = 0;
        if(isset($param['search'])){
            $event = Kegiatan::query()->select('id', 'event');
            $event->where('event', 'LIKE', '%'.$param['search'].'%');
            $event->orWhere('event_en', 'LIKE', '%'.$param['search'].'%');
            $event->orWhere('city', 'LIKE', '%'.$param['search'].'%');
            $event->orWhere('place', 'LIKE', '%'.$param['search'].'%');

            $resultEvent = $event->first();
            $eventId = $resultEvent == null ? 0 : $resultEvent->id;
        }
        // get realita (where paid status)
        $model_realita = Donations::query();
        $model_realita->select(DB::raw(DB::raw('SUM(total_donation) as `total_bulan_ini`'), "DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'));
        $model_realita->where('transaction_status', 'Paid');
        if ($eventId > 0) {
            $model_realita->where('m_events_id', $eventId);
        }
        $model_realita->groupBy('year','month');

        $data_realita = $model_realita->get();

        // get realita (where unpaid + paid status)
        $model_target = Donations::query();
        $model_target->select(DB::raw(DB::raw('SUM(total_donation) as `total_bulan_ini`'), "DATE_FORMAT(created_at, '%m-%Y') new_date"),  DB::raw('YEAR(created_at) year, MONTH(created_at) month'));
        if ($eventId > 0) {
            $model_realita->where('m_events_id', $eventId);
        }
        $model_target->where('transaction_status', 'Paid');
        $model_target->groupBy('year','month');

        $data_target = $model_target->get();

        $result = [];
        $monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // prepare data for chart.js
        $result = [
            "label" => $monthNames,
            "dataRealita" => [],
            "dataTarget" => [],
            "idEvent"    => $eventId
        ];
        for ($i=1; $i <= 12 ; $i++) {
            $result['dataRealita'][$i-1] = 0;
            $result['dataTarget'][$i-1] = 0;
            foreach ($data_realita as $key => $val_reality) {
                if($val_reality->month == $i){
                    $result['dataRealita'][$i-1] = $val_reality->total_bulan_ini;
                };
            }

            foreach ($data_target as $key => $val_target) {
                if($val_target->month == $i){
                    $result['dataTarget'][$i-1] = $val_target->total_bulan_ini;
                };
            }
        }

        return response()->json(['success' => true, 'data' => $result]);
    }
}
