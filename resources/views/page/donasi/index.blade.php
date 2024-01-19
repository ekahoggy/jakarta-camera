@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>List Donasi</h3>
                <div class="col-4 justify-content-between text-right">
                    <a href="/donasi/export" class="btn btn-primary btn-sm">
                        Export Data
                    </a>
                    <a href="/donasi/updateAll" class="btn btn-success btn-sm">
                        Batch Donasi
                    </a>
                </div>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('donasi') ? 'active show' : ''}}" id="semua-tab" data-toggle="tab" href="donasi" role="tab" onclick="updateUrl( '{{ url()->current() }}', '')"
                            aria-controls="semua" aria-selected="true">Semua</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('donasi/one-time-donation') ? 'active show' : ''}}" id="onetime-tab" data-toggle="tab" href="donasi/one-time-donation" role="tab" onclick="updateUrl( '{{ url()->current() }}', '/one-time-donation')"
                            aria-controls="onetime" aria-selected="false">One Time Donation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{Request::is('donasi/sponsorship-anak') ? 'active show' : ''}}" id="sponsor-tab" data-toggle="tab" href="donasi/sponsorship-anak" role="tab" onclick="updateUrl( '{{ url()->current() }}', '/sponsorship-anak')"
                            aria-controls="sponsor" aria-selected="false">Sponsorship Anak</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade {{Request::is('donasi') ? 'active show' : ''}}" id="semua" role="tabpanel" aria-labelledby="semua-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" width="100%">
                                        <thead>
                                            <tr class="bg-primary text-white">
                                                <th width="12%" class="text-white">Tanggal</th>
                                                <th width="20%" class="text-white">Nama</th>
                                                <th class="text-white">Lokasi Asal Gereja</th>
                                                <th width="12%" class="text-white">Jumlah Donasi</th>
                                                <th width="12%" class="text-white text-center">IDN Anak</th>
                                                <th width="10%" class="text-white">Payment Status</th>
                                                <th width="10%" class="text-white">Donation Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($all as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->transaction_time !== null)
                                                            {{ date('d F Y', strtotime($item->transaction_time)) }}
                                                        @else
                                                            {{ date('d F Y', strtotime($item->created_at)) }}
                                                        @endif
                                                    </td>
                                                    <td><a href="/donasi/edit/{{ $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->wnsm }}</td>
                                                    <td>Rp, {{ number_format($item->total_donation) }}</td>
                                                    <td class="text-center">
                                                        @if ($item->type === '1')
                                                            {{ $item->idn_anak }}
                                                        @else
                                                            <span> - </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->transaction_status === 'Paid')
                                                            <span class="badge badge-success">
                                                                Done
                                                            </span>
                                                        @elseif ($item->transaction_status === 'Unpaid' || $item->transaction_status === 'Pending')
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                Cancel
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->type === '0')
                                                            <span class="badge badge-danger">
                                                                One Time
                                                            </span>
                                                        @else
                                                            <span class="badge badge-success">
                                                                Sponsorship
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    {!! $all->links() !!}
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{Request::is('donasi/one-time-donation') ? 'active show' : ''}}" id="onetime" role="tabpanel" aria-labelledby="onetime-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" width="100%">
                                        <thead>
                                            <tr class="bg-primary text-white">
                                                <th width="12%" class="text-white">Tanggal</th>
                                                <th class="text-white">Nama</th>
                                                <th class="text-white">Lokasi Asal Gereja</th>
                                                <th width="12%" class="text-white">Jumlah Donasi</th>
                                                <th width="10%" class="text-white">Payment Status</th>
                                                <th width="10%" class="text-white">Donation Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($onetime as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->transaction_time !== null)
                                                            {{ date('d F Y', strtotime($item->transaction_time)) }}
                                                        @else
                                                            {{ date('d F Y', strtotime($item->created_at)) }}
                                                        @endif
                                                    </td>
                                                    <td><a href="/donasi/edit/{{ $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->wnsm }}</td>
                                                    <td>Rp, {{ number_format($item->total_donation) }}</td>
                                                    <td>
                                                        @if ($item->transaction_status === 'Paid')
                                                            <span class="badge badge-success">
                                                                Done
                                                            </span>
                                                        @elseif ($item->transaction_status === 'Unpaid' || $item->transaction_status === 'Pending')
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                Cancel
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->type === '0')
                                                            <span class="badge badge-danger">
                                                                One Time
                                                            </span>
                                                        @else
                                                            <span class="badge badge-success">
                                                                Sponsorship
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    {!! $onetime->links() !!}
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade {{Request::is('donasi/sponsorship-anak') ? 'active show' : ''}}" id="sponsor" role="tabpanel" aria-labelledby="sponsor-tab">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-striped table-md" width="100%">
                                        <thead>
                                            <tr class="bg-primary text-white">
                                                <th width="12%" class="text-white">Tanggal</th>
                                                <th width="12%" class="text-white">Nama</th>
                                                <th class="text-white">Lokasi Asal Gereja</th>
                                                <th width="12%" class="text-white">Jumlah Donasi</th>
                                                <th width="12%" class="text-white">IDN Anak</th>
                                                <th width="10%" class="text-white">Payment Status</th>
                                                <th width="10%" class="text-white">Donation Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sponsor as $item)
                                                <tr>
                                                    <td>
                                                        @if($item->transaction_time !== null)
                                                            {{ date('d F Y', strtotime($item->transaction_time)) }}
                                                        @else
                                                            {{ date('d F Y', strtotime($item->created_at)) }}
                                                        @endif
                                                    </td>
                                                    <td><a
                                                            href="/donasi/edit/{{ $item->id }}">{{ $item->name }}</a>
                                                    </td>
                                                    <td>{{ $item->wnsm }}</td>
                                                    <td>Rp, {{ number_format($item->total_donation) }}</td>
                                                    <td class="text-center">
                                                        <div class="row justify-content-middle">
                                                            <div class="col pr-0">
                                                                <input class="form-control form-control-sm text-center"
                                                                    id="idn_anak_{{ $item->id }}" name="idn_anak"
                                                                    value="{{ $item->idn_anak }}" rows="5"
                                                                    placeholder="Masukkan IDN anak">
                                                            </div>
                                                            <div class="col-2 p-0">
                                                                <button id="btnUpdate"
                                                                    onclick="updateidn({{ $item->id }}, 'idn_anak_'+{{ $item->id }})"
                                                                    class="btn btn-sm btn-primary" type="button">
                                                                    <i class="fa fa-save"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($item->transaction_status === 'Paid')
                                                            <span class="badge badge-success">
                                                                Done
                                                            </span>
                                                        @elseif ($item->transaction_status === 'Unpaid' || $item->transaction_status === 'Pending')
                                                            <span class="badge badge-warning">
                                                                Pending
                                                            </span>
                                                        @else
                                                            <span class="badge badge-danger">
                                                                Cancel
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($item->type === '0')
                                                            <span class="badge badge-danger">
                                                                One Time
                                                            </span>
                                                        @else
                                                            <span class="badge badge-success">
                                                                Sponsorship
                                                            </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <nav class="d-inline-block">
                                    {!! $sponsor->links() !!}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function updateidn(id, key) {
            const idn = document.getElementById(key).value;
            axios.post(`/donasi/updateIDN/${id}`, {
                    idn_anak: idn
                }).then(res => {
                    if (res.data.success) {
                        Swal.fire('Success', 'IDN successfully Saved', 'success').then(() => {
                            // location.reload();
                        });
                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
        }

        function updateUrl(url, path){
            var splitList = url.split('/');
            splitList.splice(4, 1);
            localStorage.setItem("activeDonasi", path);
            // windows.location.reload();

            window.location.replace(splitList.join("/")+path);

        }
    </script>
@endsection
