@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Kegiatan</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/kegiatan">Kegiatan</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('kegiatan.update', $model->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <div class="form-group">
                                <label class="custom-switch" style="cursor: pointer">
                                    IDN &nbsp;&nbsp;
                                    <input type="checkbox" name="language" id="language" class="custom-switch-input"
                                        onchange="switchLang()">
                                    <span class="custom-switch-indicator"></span>
                                    &nbsp;&nbsp;
                                    EN
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </div>
                                    </div>
                                    <input type="text" class="form-control datepicker" name="date"
                                        value="{{ $model->date }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu</label>
                                <div class="row">
                                    <div class="col-3 pr-0">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input id="timepicker" class="form-control" type="text" name="time" value="{{ $model->time }}">
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <select class="form-control select2 select2-hidden-accessible"
                                            aria-hidden="true" id="zona"
                                            name="zona">
                                            <option value="WIB" @if ($model->zona === 'WIB') selected @endif>WIB</option>
                                            <option value="WITA" @if ($model->zona === 'WITA') selected @endif>WITA</option>
                                            <option value="WIT" @if ($model->zona === 'WIT') selected @endif>WIT</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="place">Lokasi Gereja</label>
                                <input class="form-control form-control-sm" id="place" name="place"
                                    value="{{ $model->place }}" rows="5" placeholder="Masukkan Lokasi Gereja" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="city">Nama Kota</label>
                                <input class="form-control form-control-sm" id="city" name="city" rows="5"
                                    placeholder="Masukkan Alamat Gereja" value="{{ $model->city }}" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="event">Nama Gereja</label>
                                <input class="form-control form-control-sm" id="event" name="event"
                                    value="{{ $model->event }}" rows="5" placeholder="Masukkan Nama Gereja" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Foto Event</label>
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
                                            <img id="preview-image" class="image-thumbnail" src="{{ $model->photo }}" loading="lazy"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-indonesia">
                            <div class="form-group">
                                <label>Intro</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="intro">{{ $model->intro }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-english hidden">
                            <div class="form-group">
                                <label>Intro EN</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="intro_en">{{ $model->intro_en }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('kegiatan.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fa fa-chevron-left"></i> &nbsp; Kembali
                        </a>
                        @if (session('roles')->event_update === 1)
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="fa fa-save"></i> &nbsp; Simpan
                            </button>
                        @endif
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
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(function() {
            $('#timepicker').timepicker({
                showMeridian: false,
                showInputs: true
            });
        });

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

        function switchLang() {
            const lang = document.getElementById('language').checked;
            var eng = document.querySelectorAll(".bhs-english");
            var indo = document.querySelectorAll(".bhs-indonesia");
            if (lang === true) {
                eng.forEach((element) => {
                    element.classList.remove('hidden');
                });
                indo.forEach((element) => {
                    element.classList.add('hidden');
                });
            } else {
                eng.forEach((element) => {
                    element.classList.add('hidden');
                });
                indo.forEach((element) => {
                    element.classList.remove('hidden');
                });
            }
        }
    </script>
@endsection
