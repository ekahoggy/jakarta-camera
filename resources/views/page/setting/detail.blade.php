@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h4><img style="max-width: 40px;" src="{{ asset('img/payment/' . $model->icon) }}">{{ $model->name }}</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/setting">Setting</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $model->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body p-0">
                <div class="row px-5 pb-5" style="gap: 20px">
                    @foreach ($detail as $item)
                        <div class="card card-payment">
                            <div class="card-header p-3 d-flex"
                                style="min-height: 20px; border: none !important; justify-content: space-between;">
                                <h5 class="m-0" style="font-size: 18px;">{{ $item->name }}</h5>
                                <label class="custom-switch" style="cursor: ">
                                    <input type="checkbox" name="option" id="activate-{{ $item->id }}"
                                        class="custom-switch-input" @if ($item->is_status == '1') checked @endif
                                        onchange="updateStatus({{ $item->id }})">
                                    <span class="custom-switch-indicator"></span>
                                </label>
                            </div>
                            <div class="card-body text-center">
                                <img class="card-img-top img-payment pb-4"
                                    src="{{ asset('img/payment/' . $folder . '/' . $item->icon) }}" alt="icon setting">
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

        function updateStatus(id) {
            var checked = $('#activate-' + id).is(":checked");

            axios.post(`/setting/updateStatus/${id}`, {
                    is_status: checked ? "1" : "0"
                }).then(res => {
                    if (res.data.success) {} else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
        }
    </script>
@endsection
