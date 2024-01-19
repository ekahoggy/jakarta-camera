@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Users</h3>
            </div>
            <div class="section-filter card-body d-flex">
                <div class="col-2 p-0">
                    <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"
                        id="status_filter" name="roles_name" onchange="search()">
                        <option value="">-- Pilih Role --</option>
                        @foreach ($listRole as $item)
                            <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col p-0 pl-2">
                    <div class="search-section d-flex">
                        <div class="input-group col px-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Cari" id="search_filter">
                        </div>
                    </div>
                </div>
                <div class="col-2 p-0 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary btn-md">
                        <i class="fa fa-plus"></i> &nbsp;
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="15%">Username</th>
                                <th width="25%">Nama Lengkap</th>
                                <th width="25%">Email</th>
                                <th width="10%">Role</th>
                                <th>Tanggal Bergabung</th>
                                <th width="5%">Action</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr class="">
                                    <td class="d-flex align-middle">
                                        <div class="wrap-image bg-light text-center p-1 rounded user-picture-list">
                                            @if ($val->photo)
                                                <img src="{{ 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/'. $val->photo }}" class="image"
                                                    width="100" alt="image-preview">
                                            @endif
                                        </div>
                                        &nbsp;&nbsp;&nbsp;
                                        {{ $val->username }}
                                    </td>
                                    <td class="align-middle">{{ $val->name }}</td>
                                    <td class="align-middle">{{ $val->email }}</td>
                                    <td class="align-middle">{{ $val->roles_name }}</td>
                                    <td class="align-middle">{{ date('d F Y H:i:s', strtotime($val->created_at)) }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('user.edit', $val->id) }}"
                                                class="btn btn-primary btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger fa fa-trash"
                                                onclick="hapus({{ $val->id }})"></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    {!! $list->links() !!}
                </nav>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .image {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            margin-left: -3px;
            margin-top: -5px;
        }

        .wrap-image {
            width: 112px;
            height: 112px;
        }
    </style>

    <script>
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                $('#search_filter').val(urlParams.get('search'));
            }

            if(urlParams.has('status')){
                $("#status_filter").val(urlParams.get('status'));
            }
        });

        document.querySelector('#search_filter').addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                search();
            }
        });

        function search(){
            var comp_status = document.getElementById("status_filter");
            var comp_search = document.getElementById("search_filter");
            var value_status = comp_status.value;
            var value_search = comp_search.value;

            var param = value_status.length > 0 || value_search.length > 0 ? "?" : "";
            param += value_status.length > 0 ? "status="+value_status : '';
            param += value_status.length > 0 && value_search.length > 0 ? "&" : "";
            param += value_search.length > 0 ? "search="+encodeURI(value_search) : "";

            var reload_url = window.location.href.split("?")[0];

            window.location.href = reload_url+param;
        }

        function hapus(id) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/user/delete/${id}`).then(res => {
                            if (res.data.success) {
                                Swal.fire('Success', 'Deleted successfully', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Ops..', 'There is an error.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Ops..', 'There is an error.', 'error');
                        });
                }
            });
        }
    </script>
@endsection
