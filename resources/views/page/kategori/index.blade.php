@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Kategori</h3>
                <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> &nbsp;
                    Tambah Data
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md" id="table-kategori">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th width="20%">Kategori</th>
                                <th width="10%">Ikon</th>
                                <th width="20%">Slug</th>
                                <th>Keterangan</th>
                                <th width="5%">Action</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ $val->kategori }}</td>
                                    <td class="align-middle"><img src="{{ url('img/media/originals/' . $val->icon) }}"
                                            alt="icon {{ $val->kategori }}" width="50px"></td>
                                    <td class="align-middle">{{ $val->slug }}</td>
                                    <td class="align-middle">{{ $val->keterangan }}</td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('kategori.edit', $val->id) }}"
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

    <script>
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(function() {
            $("#table-kategori").treeFy({
                treeColumn: 1
            });
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
                    axios.delete(`/kategori/delete/${id}`).then(res => {
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
