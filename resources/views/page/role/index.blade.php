@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>User Role</h3>
                @if (session('roles')->role_create === 1)
                    <a href="{{ route('role.create') }}" class="btn btn-primary btn-md">
                        <i class="fa fa-plus"></i> &nbsp;
                        Tambah Data
                    </a>
                @endif
            </div>
            <div class="section-filter d-flex justify-content-start mb-2">
                <div class="col-3">
                    <div class="search-section d-flex">
                        <div class="input-group col px-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Ketik untuk mencari" id="search_filter"
                                on>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md w-100">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="15%">Nama</th>
                                <th>Permision</th>
                                <th width="5%">Action</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ $val->name }}</td>
                                    <td class="align-middle">
                                        <div class="row">
                                            @foreach ($val->access as $k => $item)
                                                @if ($item === 1)
                                                    <div class="col roles_access_index">
                                                        {{ ucwords(str_replace('_', ' ', $k)) }}
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if (session('roles')->role_update === 1)
                                                <a href="{{ route('role.edit', $val->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (session('roles')->role_delete === 1)
                                                <button class="btn btn-sm btn-danger fa fa-trash"
                                                    onclick="hapus({{ $val->id }})"></button>
                                            @endif
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
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

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
        });


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
                    axios.delete(`/role/delete/${id}`).then(res => {
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

        document.querySelector('#search_filter').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                search();
            }
        });

        function search() {
            var comp_search = document.getElementById("search_filter");
            var value_search = comp_search.value;

            var param = value_search.length > 0 ? "?" : "";
            param += value_search.length > 0 ? "&" : "";
            param += value_search.length > 0 ? "search=" + encodeURI(value_search) : "";

            var reload_url = window.location.href.split("?")[0];

            window.location.href = reload_url + param;
        }
    </script>
@endsection
