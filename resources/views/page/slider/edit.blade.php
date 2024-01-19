@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Slide</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/slider">Slide</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('slider.update', $model->id) }}" enctype="multipart/form-data">
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
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone @if($model->picture != null) hidden @endif" id="drop-zone"
                                            data-target="#exampleModal" data-toggle="modal">
                                            <div class="drop-zone-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop your image here</p>
                                            </div>
                                            <input type="text" name="picture" id="image-input"  class="hidden" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="image-preview" class="@if($model->picture == null) hidden @endif bg-light text-center rounded p-2"
                                            data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" src="{{$model->picture}}" loading="lazy"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-indonesia">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control form-control-sm" id="title" name="title"
                                    value="{{ $model->title }}" rows="5" placeholder="Masukkan Title">
                            </div>
                        </div>
                        <div class="col-md-12 bhs-english hidden">
                            <div class="form-group">
                                <label for="title_en">Title EN</label>
                                <input class="form-control form-control-sm" id="title_en" name="title_en"
                                    value="{{ $model->title_en }}" rows="5" placeholder="Input Title">
                            </div>
                        </div>
                        <div class="col-md-12 bhs-indonesia">
                            <div class="form-group">
                                <label>Content</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="content">{{ $model->content }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-english hidden">
                            <div class="form-group">
                                <label>Content EN</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="content_en">{{ $model->content_en }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('slider.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fa fa-chevron-left"></i> &nbsp; Kembali
                        </a>
                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="fa fa-save"></i> &nbsp; Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body px-0">
            @include('page.media-modal.modal-media')
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
            </div>
        </div>
        </div>
    </div>

    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $( document ).ready(function (){
            // console.log($model);
        });

        function showPreview(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("drop-zone").style.display = 'none';
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewImage.src = '';
                document.getElementById("drop-zone").style.display = 'block';
                previewContainer.classList.add('hidden');
            }
        }

        $(document).on('click', '.imgPersonal', function () {
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


        $(document).ready(function(){
            $('#exampleModal').appendTo("body")
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
            }
            else{
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
