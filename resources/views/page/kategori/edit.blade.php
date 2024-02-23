@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Kategori</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/kategori">Kategori</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('kategori.update', $model->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="col-md-3 bhs-indonesia">
                                <div class="form-group">
                                    <label for="image">Ikon</label>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="drop-zone @if ($model->icon != null) hidden @endif"
                                                id="drop-zone" data-target="#exampleModal"
                                                data-toggle="modal">
                                                <div class="drop-zone-text">
                                                    <i class="fas fa-cloud-upload-alt"></i>
                                                    <p>Drag and drop your image here</p>
                                                </div>
                                                <input type="text" name="icon" id="image-input" class="hidden" />
                                            </div>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <div id="image-preview"
                                                class="@if ($model->icon == null) hidden @endif bg-light text-center rounded p-2"
                                                data-target="#exampleModal" data-toggle="modal">
                                                <img id="preview-image" class="image-thumbnail" src="{{ url('img/media/originals/' . $model->icon) }}" loading="lazy"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="kategori">Induk Kategori</label>
                                            {{-- <select id="induk_id" name="induk_id" placeholder="Pilih induk kategori">
                                                <option value="">Pilih induk kategori</option>
                                                @foreach ($listInduk as $item)
                                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                                @endforeach
                                            </select> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="kategori">Kategori</label>
                                        <input class="form-control form-control-sm" id="kategori" name="kategori"
                                            value="{{ $model->kategori }}" rows="5" placeholder="Masukkan Kategori"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input class="form-control form-control-sm" id="slug" name="slug"
                                            value="{{ $model->slug }}" rows="5" placeholder="Masukkan Slug" disabled>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="keterangan">Keterangan</label>
                                        <input class="form-control form-control-sm" id="keterangan" name="keterangan"
                                            value="{{ $model->keterangan }}" rows="5" placeholder="Masukkan Keterangan"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-light mr-2">
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

    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

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
