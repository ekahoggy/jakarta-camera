@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit User</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/user">User</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('user.update', $model->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Foto</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone @if ($model->photo != null) hidden @endif"
                                            id="drop-zone" {{-- onclick="document.getElementById('image-input').click()" --}} data-target="#exampleModal"
                                            data-toggle="modal">
                                            <div class="drop-zone-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop your image here</p>
                                            </div>
                                            {{-- <input type="file" name="photo" id="image-input" accept="image/*"
                                                onchange="showPreview(event)" class="hidden" /> --}}
                                            <input type="text" name="photo" id="image-input" class="hidden" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="image-preview"
                                            class="@if ($model->photo == null) hidden @endif bg-light text-center rounded p-2"
                                            {{-- onclick="document.getElementById('image-input').click()" --}} data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" src="{{ $model->photo }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input class="form-control form-control-sm" id="name" name="name"
                                    value="{{ $model->name }}" rows="5" placeholder="Masukkan Nama Lengkap" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input class="form-control form-control-sm" id="username" name="username"
                                    value="{{ $model->username }}" rows="5" placeholder="Masukkan Username" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email"
                                    value="{{ $model->email }}" rows="5" placeholder="Masukkan Email" required>
                            </div>
                        </div>


                        <!-- password -->
                        <div class="col-md-10">
                            <div class="form-group">
                                <label class="col-md-4 p-0 control-label">Kata Sandi</label>
                                <div class="col-md-12 p-0">
                                    <input id="password-field" type="password" class="form-control" name="password">
                                    <span toggle="#password-field"
                                        class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-md btn-light mr-2" style="margin-top: 30px;" type="button"
                                onclick="document.getElementById('password-field').value = generateRandomPassword(16)">
                                Generate Kata Sandi
                            </button>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="phone_number">Nomor Telepon</label>
                                <input type="phone_number" class="form-control form-control-sm" id="phone_number"
                                    name="phone_number" value="{{ $model->phone_number }}" rows="5"
                                    placeholder="Masukkan Nomor Telepon" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="address">Alamat</label>
                                <input type="address" class="form-control form-control-sm" id="address" name="address"
                                    value="{{ $model->address }}" rows="5" placeholder="Masukkan Alamat Lengkap"
                                    required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="roles">Peran</label>
                                <select class="form-control select2 select2-hidden-accessible" tabindex="-1"
                                    aria-hidden="true" style="width: 200px !important;" id="roles" name="roles">
                                    @foreach ($roles as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('user.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fa fa-chevron-left"></i> &nbsp; Cancel
                        </a>
                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="fa fa-save"></i> &nbsp; Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-0">
                    @include('page.media-modal.modal-media')
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <style>
        .drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            max-width: 350px;
            width: 100%;
        }

        .drop-zone-text {
            color: #777;
        }

        .image-thumbnail {
            max-width: 350px;
            width: 100%;
            height: auto;
        }

        .hidden {
            display: none;
        }

        .field-icon {
            float: right;
            right: 12px;
            margin-top: -29px;
            position: relative;
            z-index: 2;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(".toggle-password").click(function() {
            $(this).toggleClass("fa-eye fa-eye-slash");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        function generateRandomPassword(length = 12) {
            const uppercaseChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const lowercaseChars = 'abcdefghijklmnopqrstuvwxyz';
            const numberChars = '0123456789';
            const specialChars = '!@#$%^&*()_-+=<>?/{}~|';

            const allChars = uppercaseChars + lowercaseChars + numberChars + specialChars;

            let password = '';
            for (let i = 0; i < length; i++) {
                const randomIndex = Math.floor(Math.random() * allChars.length);
                password += allChars.charAt(randomIndex);
            }

            return password;
        }

        $(document).ready(function() {
            $('#exampleModal').appendTo("body")
        });

        function openModal() {
            $('#exampleModal').modal({
                keyboard: true
            });
        }

        function showPreview(link) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("drop-zone").style.display = 'none';
                    previewImage.src = link; //e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewImage.src = '';
                document.getElementById("drop-zone").style.display = 'block';
                previewContainer.classList.add('hidden');
            }
        }

        $(document).on('click', '.imgPersonal', function() {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');

            let imgSrc = $(this).attr('src');

            document.getElementById("drop-zone").style.display = 'none';
            $('#image-input').val(imgSrc)
            previewImage.src = imgSrc; //e.target.result;
            previewContainer.classList.remove('hidden');
            $('#exampleModal').modal('hide');
        });
    </script>
@endsection
