@extends('layout.main')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header">
            <h3>Resource</h3>
            <a href="{{ route('resource.create') }}" class="btn btn-primary btn-sm ml-auto">
                <i class="fa fa-plus"></i> &nbsp;
                Create Data
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr class="bg-primary text-light">
                            <th width="5%">No</th>
                            <th width="15%">Image</th>
                            <th>Title</th>
                            <th>Content</th>
                            <th width="5%">Action</th>
                        </tr>
                        @foreach ( $list as $key => $val )
                        <tr>
                            <td class="align-middle">{{ $key + 1 }}</td>
                            <td class="align-middle">
                                <img src="{{ Storage::url('images/'. $val->image) }}" class="image" width="100" alt="image-preview">
                            </td>
                            <td class="align-middle">{{ $val->title }}</td>
                            <td class="align-middle">{!! $val->content !!}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('resource.edit', $val->id) }}" class="btn btn-primary btn-sm mr-2">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-danger fa fa-trash" onclick="hapus({{ $val->id }})"></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="card-footer d-flex justify-content-end">
            <nav class="d-inline-block">
                <ul class="pagination mb-0">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1"><i class="fas fa-chevron-left"></i></a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1 <span class="sr-only">(current)</span></a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a>
                    </li>
                </ul>
            </nav>
        </div> --}}
    </div>
</div>

<style>
    .image {
        width: 120px;
        height: 80px;
        object-fit: cover;
    }
</style>

<script>
    @if(session('success'))
        Swal.fire('Success', '{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
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
                axios.delete(`/resource/delete/${id}`).then(response => {
                    if (response.data.success) {
                        Swal.fire('Success', 'Deleted successfully', 'success').then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire('Ops..', 'There is an error', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error', 'error');
                });
            }
        });
    }
</script>
@endsection
