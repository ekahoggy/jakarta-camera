@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <h3>Jadwal Kegiatan</h3>
            </div>
            <div class="section-filter card-body d-flex">
                <div class="col-2 p-0">
                    <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"
                        id="city" name="city" onchange="search()">
                        <option value="">-- Pilih Kota --</option>
                        @foreach ($listKota as $item)
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
                    @if (session('roles')->event_create === 1)
                        <a href="{{ route('kegiatan.create') }}" class="btn btn-primary btn-md">
                            <i class="fa fa-plus"></i> &nbsp;
                            Tambah Data
                        </a>
                    @endif
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md" width="100%">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="12%">Tanggal & Waktu</th>
                                <th width="12%">Lokasi Gereja</th>
                                <th width="15%">Nama Gereja</th>
                                <th width="15%">Kota</th>
                                <th width="10%" class="text-center">Status</th>
                                <th width="10%" class="text-center">Publish</th>
                                <th width="5%">Action</th>
                            </tr>
                            @foreach ($model as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ date('d F Y H:i', strtotime($val->date)) }}</td>
                                    <td class="align-middle">{{ $val->place }}</td>
                                    <td class="align-middle">{{ $val->event }}</td>
                                    <td class="align-middle">{{ $val->city }}</td>
                                    <td class="align-middle text-center">
                                        @if ($val->status === 1)
                                            <div class="badge badge-success">Ongoing</div>
                                        @elseif($val->status === 2)
                                            <div class="badge badge-primary">Upcoming</div>
                                        @else
                                            <div class="badge badge-warning">Ended</div>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <label class="custom-switch" style="cursor: ">
                                            <input type="checkbox" name="option" id="publish{{ $val->id }}"
                                                class="custom-switch-input" @if ($val->is_status == 1) checked @endif
                                                onchange="updateStatus({{ $val->id }})">
                                            <span class="custom-switch-indicator"></span>
                                        </label>
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            @if (session('roles')->event_update === 1)
                                                <a href="{{ route('kegiatan.edit', $val->id) }}"
                                                    class="btn btn-primary btn-sm mr-2">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif
                                            @if (session('roles')->event_delete === 1)
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
                    {!! $model->links() !!}
                </nav>
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

            if (urlParams.has('city')) {
                $("#city").val(urlParams.get('city'));
            }
        });

        document.querySelector('#search_filter').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                search();
            }
        });

        function search() {
            var comp_city = document.getElementById("city");
            var comp_search = document.getElementById("search_filter");
            var value_city = comp_city.value;
            var value_search = comp_search.value;

            var param = value_city.length > 0 || value_search.length > 0 ? "?" : "";
            param += value_city.length > 0 ? "city=" + value_city : '';
            param += value_city.length > 0 && value_search.length > 0 ? "&" : "";
            param += value_search.length > 0 ? "search=" + encodeURI(value_search) : "";

            var reload_url = window.location.href.split("?")[0];

            window.location.href = reload_url + param;
        }

        function updateStatus(id) {
            var checked = $('#publish' + id).is(":checked");

            axios.post(`/kegiatan/updateStatus/${id}`, {
                    is_status: checked ? 1 : 0
                }).then(res => {
                    if (res.data.success) {
                        window.location.reload();
                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
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
                    axios.delete(`/kegiatan/delete/${id}`).then(res => {
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
