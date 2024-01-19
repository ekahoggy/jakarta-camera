@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Integration Payment Gateway</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/setting">Setting</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Payment Gateway</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body p-0">
                <div class="row px-5 pb-5" style="gap: 20px">
                    @foreach ($list as $item)
                        <div class="card card-payment">
                            <div class="card-header payment">
                                <img class="card-img-top img-payment" src="{{ asset('img/payment/'.$item->icon) }}" alt="icon setting">
                            </div>
                            <div class="card-body p-0">
                                <h5 class="card-title payment-name m-0 px-3">{{ $item->name }}</h5>
                                <p class="card-text payment-note mt-2 px-3">{{ $item->note }}</p>
                                <a href="/setting/view/{{ $item->id }}" class="btn btn-primary btn-payment-detail">Lihat Detail</a>
                            </div>
                        </div>
                    @endforeach
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
    </script>
@endsection
