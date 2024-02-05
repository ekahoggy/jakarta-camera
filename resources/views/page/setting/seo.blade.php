@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    SEO
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">SEO</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('seo.save') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 bhs-indonesia">
                            <div class="form-group">
                                <label for="image">Ikon</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone @if ($model['icon'] != '') hidden @endif"
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
                                            class="@if ($model['icon'] == '') hidden @endif bg-light text-center rounded p-2"
                                            data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" src="{{ url('img/media/originals/' . $model['icon']) }}" loading="lazy"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 row">
                            <div class="col-md-6 p-0">
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ $model['title'] }}" rows="5" placeholder="Masukkan Title"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <input class="form-control form-control-sm" id="deskripsi" name="deskripsi"
                                            value="{{ $model['deskripsi'] }}" rows="5" placeholder="Masukkan Deskripsi"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="author">Author</label>
                                        <input class="form-control form-control-sm" id="author" name="author"
                                            value="{{ $model['author'] }}" rows="5" placeholder="Masukkan Author"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="tags">Keyword</label><p></p>
                                        <div class="tags-input">
                                            <ul id="tags"></ul>
                                            <input class="form-control form-control-sm" type="text" id="input-tag"
                                                placeholder="Masukkan keyword produk" value="{{ $model['keyword'] }}"/>
                                            <input type="hidden" id="tags_value" name="keyword">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
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
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif
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

        $(document).ready(function() {
            $('#exampleModal').appendTo("body")
            $('select').selectize({
                sortField: 'text'
            });
        });

        // Get the tags and input elements from the DOM
        const tags = document.getElementById('tags');
        const value_tags = document.getElementById('tags_value');
        const input = document.getElementById('input-tag');

        // Add an event listener for keydown on the input element
        input.addEventListener('keydown', function(event) {

            // Check if the key pressed is 'Enter'
            if (event.key === 'Enter') {

                // Prevent the default action of the keypress
                // event (submitting the form)
                event.preventDefault();

                // Create a new list item element for the tag
                const tag = document.createElement('li');

                // Get the trimmed value of the input element
                const tagContent = input.value.trim();

                // If the trimmed value is not an empty string
                if (tagContent !== '') {

                    // Set the text content of the tag to
                    // the trimmed value
                    tag.innerText = tagContent;

                    // Add a delete button to the tag
                    tag.innerHTML += '<button class="delete-button">X</button>';

                    // Append the tag to the tags list
                    tags.appendChild(tag);

                    // Clear the input element's value
                    input.value = '';
                    value_tags.value += tagContent + ', ';
                }
            }
        });

        // Add an event listener for click on the tags list
        tags.addEventListener('click', function(event) {

            // If the clicked element has the class 'delete-button'
            if (event.target.classList.contains('delete-button')) {

                // Remove the parent element (the tag)
                event.target.parentNode.remove();
            }
        });
    </script>
@endsection
