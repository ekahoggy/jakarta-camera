@extends('layout.main')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            <h3>Edit Service</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/service">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('service.update', $model->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="content">Title</label>
                            <input class="form-control form-control-sm" id="content" name="content" value="{{ $model->content }}" rows="5" required>
                            <input class="form-control form-control-sm" id="img_bash" name="img_bash" value="{{ $model->image }}" rows="5" hidden>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="image">Image</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="drop-zone" onclick="document.getElementById('image-input').click()">
                                        <div class="drop-zone-text">
                                          <i class="fas fa-cloud-upload-alt"></i>
                                          <p>Drag and drop your image here</p>
                                        </div>
                                        <input type="file" name="image" id="image-input" accept="image/*" onchange="showPreview(event)" class="hidden" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="image-preview" class="hidden bg-light text-center rounded p-2">
                                        <img id="preview-image" src="{{ Storage::url('images/'. $model->image) }}" class="image-thumbnail" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('service.index') }}" class="btn btn-sm btn-light mr-2">
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

<style>
    .drop-zone {
        border: 2px dashed #ccc;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        max-width: 350px
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
</style>

<script>

    @if(session('error'))
        Swal.fire('Oopss', '{{ session('error') }}', 'error');
    @endif

    window.addEventListener('DOMContentLoaded', (event) => {
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');

        if (previewImage && previewImage.src) {
            previewContainer.classList.remove('hidden');
        }
    });

    function showPreview(event) {
        const input = event.target;
        const previewContainer = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
            previewImage.src = e.target.result;
            previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.src = '';
            previewContainer.classList.add('hidden');
        }
    }

</script>

@endsection
