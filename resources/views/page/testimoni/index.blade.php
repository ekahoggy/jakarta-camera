@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Testimoni</h3>
                <a href="{{ route('testimoni.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> &nbsp;
                    Tambah Data
                </a>
            </div>
            <div class="card-body p-0">
                <div class="section-filter d-flex justify-content-start mb-2">
                    <div class="col-3">
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
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-md" width="100%">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="25%">Tanggal</th>
                                <th>Nama</th>
                                <th>Testimoni</th>
                                <th class="text-center" width="5%">Action</th>
                                <th class="text-center" width="10%">Status</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ date('d F Y', strtotime($val->created_at)) }}</td>
                                    <td class="align-middle">{{ $val->name }}</td>
                                    <td class="align-middle">{{ $val->testimoni }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('testimoni.edit', $val->id) }}"
                                                class="btn btn-primary btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger fa fa-trash"
                                                onclick="hapus({{ $val->id }})"></button>
                                        </div>
                                    </td>
                                    <td>
                                        <label class="custom-switch" style="cursor: ">
                                            <input type="checkbox" name="option" id="publish{{ $val->id }}"
                                                class="custom-switch-input" @if ($val->is_status == '1') checked @endif
                                                onchange="updateStatus({{ $val->id }})">
                                            <span class="custom-switch-indicator"></span>
                                            <span class="pl-2">
                                                @if ($val->is_status == '1')
                                                    Show
                                                @else
                                                    Draft
                                                @endif
                                            </span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end">
                    {{ $list->appends(request()->input())->links() }}
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
                    axios.delete(`/testimoni/delete/${id}`).then(res => {
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

        function updateStatus(id) {
            var checked = $('#publish' + id).is(":checked");

            axios.post(`/testimoni/updateStatus/${id}`, {
                    is_status: checked ? 1 : 0
                }).then(res => {
                    if (res.data.success) {
                        console.log(res);
                        window.location.reload();
                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
        }
    </script>
@endsection
