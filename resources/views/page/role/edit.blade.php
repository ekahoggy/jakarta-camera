@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Role</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/role">Role</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('role.update', $model->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input class="form-control form-control-sm" id="name" name="name"
                                    value="{{ $model->name }}" placeholder="Masukkan Nama Role" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="access">Permission</label>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="15%" rowspan="2">Menu</th>
                                            <th colspan="5" class="text-center">Permission</th>
                                        </tr>
                                        <tr class="text-center">
                                            <th>Access</th>
                                            <th>Create</th>
                                            <th>Update</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Dashboard</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="dashboard_index" name="dashboard_index"
                                                    value="1" @if ($model->access->dashboard_index == 1) checked @endif>
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>Donasi</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="donasi_index" name="donasi_index" value="1"
                                                    @if ($model->access->donasi_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="donasi_create" name="donasi_create"
                                                    value="1" @if ($model->access->donasi_create == 1) checked @endif onchange="checkInduk('donasi_index', 'donasi_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="donasi_update" name="donasi_update"
                                                    value="1" @if ($model->access->donasi_update == 1) checked @endif onchange="checkInduk('donasi_index', 'donasi_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="donasi_delete" name="donasi_delete"
                                                    value="1" @if ($model->access->donasi_delete == 1) checked @endif onchange="checkInduk('donasi_index', 'donasi_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Page</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="page_index" name="page_index" value="1"
                                                    @if ($model->access->page_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="page_create" name="page_create" value="1"
                                                    @if ($model->access->page_create == 1) checked @endif onchange="checkInduk('page_index', 'page_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="page_update" name="page_update" value="1"
                                                    @if ($model->access->page_update == 1) checked @endif onchange="checkInduk('page_index', 'page_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="page_delete" name="page_delete" value="1"
                                                    @if ($model->access->page_delete == 1) checked @endif onchange="checkInduk('page_index', 'page_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Widget</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="widget_index" name="widget_index" value="1"
                                                    @if ($model->access->widget_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="widget_create" name="widget_create"
                                                    value="1" @if ($model->access->widget_create == 1) checked @endif onchange="checkInduk('widget_index', 'widget_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="widget_update" name="widget_update"
                                                    value="1" @if ($model->access->widget_update == 1) checked @endif onchange="checkInduk('widget_index', 'widget_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="widget_delete" name="widget_delete"
                                                    value="1" @if ($model->access->widget_delete == 1) checked @endif onchange="checkInduk('widget_index', 'widget_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Event</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="event_index" name="event_index" value="1"
                                                    @if ($model->access->event_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="event_create" name="event_create"
                                                    value="1" @if ($model->access->event_create == 1) checked @endif onchange="checkInduk('event_index', 'event_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="event_update" name="event_update"
                                                    value="1" @if ($model->access->event_update == 1) checked @endif onchange="checkInduk('event_index', 'event_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="event_delete" name="event_delete"
                                                    value="1" @if ($model->access->event_delete == 1) checked @endif onchange="checkInduk('event_index', 'event_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Media</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="media_index" name="media_index"
                                                    value="1" @if ($model->access->media_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="media_create" name="media_create"
                                                    value="1" @if ($model->access->media_create == 1) checked @endif onchange="checkInduk('media_index', 'media_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="media_update" name="media_update"
                                                    value="1" @if ($model->access->media_update == 1) checked @endif onchange="checkInduk('media_index', 'media_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="media_delete" name="media_delete"
                                                    value="1" @if ($model->access->media_delete == 1) checked @endif onchange="checkInduk('media_index', 'media_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Testimoni</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="testimoni_index" name="testimoni_index"
                                                    value="1" @if ($model->access->testimoni_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="testimoni_create" name="testimoni_create"
                                                    value="1" @if ($model->access->testimoni_create == 1) checked @endif onchange="checkInduk('testimoni_index', 'testimoni_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="testimoni_update" name="testimoni_update"
                                                    value="1" @if ($model->access->testimoni_update == 1) checked @endif onchange="checkInduk('testimoni_index', 'testimoni_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="testimoni_delete" name="testimoni_delete"
                                                    value="1" @if ($model->access->testimoni_delete == 1) checked @endif onchange="checkInduk('testimoni_index', 'testimoni_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Other</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="other_index" name="other_index"
                                                    value="1" @if ($model->access->other_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="other_create" name="other_create"
                                                    value="1" @if ($model->access->other_create == 1) checked @endif onchange="checkInduk('other_index', 'other_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="other_update" name="other_update"
                                                    value="1" @if ($model->access->other_update == 1) checked @endif onchange="checkInduk('other_index', 'other_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="other_delete" name="other_delete"
                                                    value="1" @if ($model->access->other_delete == 1) checked @endif onchange="checkInduk('other_index', 'other_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>User</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="user_index" name="user_index" value="1"
                                                    @if ($model->access->user_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="user_create" name="user_create"
                                                    value="1" @if ($model->access->user_create == 1) checked @endif onchange="checkInduk('user_index', 'user_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="user_update" name="user_update"
                                                    value="1" @if ($model->access->user_update == 1) checked @endif onchange="checkInduk('user_index', 'user_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="user_delete" name="user_delete"
                                                    value="1" @if ($model->access->user_delete == 1) checked @endif onchange="checkInduk('user_index', 'user_delete')">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Role</td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_index" name="role_index" value="1"
                                                    @if ($model->access->role_index == 1) checked @endif>
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_create" name="role_create"
                                                    value="1" @if ($model->access->role_create == 1) checked @endif onchange="checkInduk('role_index', 'role_create')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_update" name="role_update"
                                                    value="1" @if ($model->access->role_update == 1) checked @endif onchange="checkInduk('role_index', 'role_update')">
                                            </td>
                                            <td class="text-center">
                                                <input type="checkbox" id="role_delete" name="role_delete"
                                                    value="1" @if ($model->access->role_delete == 1) checked @endif onchange="checkInduk('role_index', 'role_delete')">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('role.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fa fa-chevron-left"></i> &nbsp; Kembali
                        </a>
                        @if (session('roles')->role_update === 1)
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fa fa-save"></i> &nbsp; Simpan
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function checkInduk(induk, anak){
            const head = document.getElementById(induk);
            const child = document.getElementById(anak);
            
            if(child.checked){
                head.checked = true;
            }
        }
    </script>
@endsection
