@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <div class="col">
                    {{ $model->name }} &nbsp;
                    @if ($model->type === '0')
                        <span class="badge badge-danger">
                            One Time
                        </span>
                    @else
                        <span class="badge badge-success">
                            Sponsorship
                        </span>
                    @endif
                    <p> {{ $model->email }} </p>
                </div>
                <div class="col-2">
                    @if ($model->transaction_status === 'Paid')
                        <span class="badge badge-success">
                            Done
                        </span>
                    @elseif ($model->transaction_status === 'Unpaid' || $model->transaction_status === 'Pending')
                        <span class="badge badge-warning">
                            Pending
                        </span>
                    @else
                        <span class="badge badge-danger">
                            Cancel
                        </span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jumlah Donasi</label>
                                <br>
                                <p>Rp. {{ number_format($model->total_donation) }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Alamat</label>
                                <br>
                                <p> {{ $model->address }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="url">Lokasi Asal Gereja</label>
                                <br>
                                <p> {{ $model->wnsm }} </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Jumlah
                                    @if ($model->type === '0')
                                        Onetime
                                    @else
                                        Sponsorship Anak
                                    @endif
                                </label>
                                <br>
                                <p> {{ $model->qty }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>No Telepon/WA</label>
                                <br>
                                <p> {{ $model->phone_code }}{{ $model->phone_number }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="url">Tanggal</label>
                                <br>
                                <p> 
                                    @if($model->transaction_time !== null)
                                        {{ date('d F Y H:i', strtotime($model->transaction_time)) }}
                                    @else
                                        {{ date('d F Y H:i', strtotime($model->created_at)) }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nama Kota</label>
                                <br>
                                <p> {{ $model->city }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="url">Metode Pembayaran</label>
                                <br>
                                <p> {{ ucfirst($model->metode_pembayaran) }} </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a class="btn btn-sm btn-light mr-2" onclick="back()">
                            <i class="fa fa-chevron-left"></i> &nbsp; Kembali
                        </a>
                        {{-- href="{{ route('donasi.index') }}"  --}}
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function back(){
            var pathActive = localStorage.getItem("activeDonasi");

            var url = '{!! url()->current() !!}';
            var splitList = url.split('/');
            splitList.splice(4, 1);
            splitList.splice(4, 1);
            window.location.replace(splitList.join("/")+pathActive);
        }
    </script>
@endsection
