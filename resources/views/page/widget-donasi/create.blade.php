@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    Tambah Slide
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/slider">Slider</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('slider.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone" id="drop-zone"
                                        {{-- onclick="document.getElementById('image-input').click()" --}}
                                        data-target="#exampleModal" data-toggle="modal">
                                            <div class="drop-zone-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop your image here</p>
                                            </div>
                                            {{-- <input type="file" name="photo" id="image-input" accept="image/*" onchange="showPreview(event)" class="hidden" /> --}}
                                            <input type="text" name="picture" id="image-input" class="hidden" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="image-preview" class="hidden bg-light text-center rounded p-2"
                                        {{-- onclick="document.getElementById('image-input').click()" --}}
                                        data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control form-control-sm" id="title" name="title"
                                    value="{{ old('title') }}" rows="5" placeholder="Masukkan Title" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Content</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="content"></textarea>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="url">Target URL</label>
                                <input class="form-control form-control-sm" id="url" name="url"
                                    value="{{ old('url') }}" rows="5" placeholder="Masukkan target url" required>
                            </div>
                        </div>
                        -->
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
    <div class="modal fade" data-backdrop="false" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-body px-0">
            @include('page.media-modal.modal-media')
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    <script>
        // changeTimeZone();

        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function changeTimeZone(){
            var y = document.getElementsByClassName('timepicker');
            var aNode = y[0].datetimepicker({
                use24hours: true,
                format: 'HH:mm'
            });

        }

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
        });
    </script>
@endsection
