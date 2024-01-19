<?php

namespace App\Exports;

use App\Models\Donations;
use App\Models\Kegiatan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportDonations implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $model = Donations::select(
            'm_events_id',
            'no_donation',
            'type',
            'qty',
            'nominal',
            'total_donation',
            'name',
            'email',
            'phone_code',
            'phone_number',
            'address',
            'gender',
            'wnsm',
            'idn_anak',
            'transaction_status',
            'bank',
            'card_type',
            'finish_redirect_url',
            'masked_card',
            'payment_type',
            'transaction_id',
            'transaction_time'
        )->get();
        
        foreach ($model as $key => $value) {
            $value->type = $value->type == "1" ? 'Sponsorships' : 'Donasi Sekali';
            if($value->m_events_id !== null){
                $event = Kegiatan::where('id', $value->m_events_id)->first();
                if($event){
                    $value->m_events_id = $event->place;
                }
            }
        }

        return $model;
    }
    
    public function headings(): array
    {
        return [
            'm_events_id',
            'no_donation',
            'type',
            'qty',
            'nominal',
            'total_donation',
            'name',
            'email',
            'phone_code',
            'phone_number',
            'address',
            'gender',
            'wnsm',
            'idn_anak',
            'transaction_status',
            'bank',
            'card_type',
            'finish_redirect_url',
            'masked_card',
            'payment_type',
            'transaction_id',
            'transaction_time'
        ];
    }
}
