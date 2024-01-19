@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Draft Jadwal Kegiatan</h3>
            </div>
            <div class="section-filter card-body d-flex">
                <div class="col-2 p-0">
                    <select class="form-control select2 select2-hidden-accessible" tabindex="-1" aria-hidden="true"
                        id="place" name="place">
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
                            <input type="text" class="form-control" placeholder="Cari">
                        </div>
                    </div>
                </div>
                <div class="col-2 p-0 text-right">
                    <a href="{{ route('kegiatandraft.create') }}" class="btn btn-primary btn-md">
                        <i class="fa fa-plus"></i> &nbsp;
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md" width="100%">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="12%">Tanggal & Waktu</th>
                                <th width="12%">Foto Event</th>
                                <th>Intro</th>
                                <th width="15%">Nama WNSM</th>
                                <th width="15%">Alamat WNSM</th>
                                <th width="5%">Action</th>
                            </tr>
                            @foreach ($model as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ $val->date }}</td>
                                    <td class="align-middle">
                                        <div class="wrap-image text-center p-1">
                                            @if ($val->photo)
                                                <img src="{{ Storage::url('kegiatan/' . $val->photo) }}" class="image"
                                                    width="100" alt="image-preview">
                                            @endif
                                        </div>
                                    </td>
                                    <td class="align-middle intro"><span class="limited">{!! $val->intro !!}</span></td>
                                    <td class="align-middle">{{ $val->event }}</td>
                                    <td class="align-middle">{{ $val->city }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('kegiatandraft.edit', $val->id) }}"
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
                    {!! $model->links() !!}
                </nav>
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
                    axios.delete(`/kegiatandraft/delete/${id}`).then(res => {
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
