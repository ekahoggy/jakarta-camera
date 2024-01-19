@extends('layout.main')

@section('content')
<div class="section-body">
    <div class="card">
        <div class="card-header justify-content-between d-flex">
            <h3>Upload Pdf</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="/service">Service</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Upload Pdf</li>
                </ol>
            </nav>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('service.upload') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="">Upload File</label>
                            <div id="dropArea">
                                <input type="text" id="tempFile" name="tempFile" value="{{ Storage::url('pdf/'. $model->file) }}" style="display: none;">
                                <input type="file" id="fileInput" name="file" accept="application/pdf" style="display: none;">
                                <button id="uploadButton" class="btn btn-primary mb-3" type="button">
                                    <i class="fa fa-upload mr-1"></i>
                                    Pilih File PDF
                                </button>
                                <p>Drag and drop your file here</p>
                            </div>
                        </div>
                    </div>

                    {{-- @if ($model->download == true) --}}
                    {{-- <div class="col-6">
                        <div class="form-group">
                            <label for="file">File</label>
                            <div class="text-center">
                                <div class="bg-info bg-light mx-auto p-3 mb-3" style="width: 200px; height: 234px">
                                    <i class="fa fa-file text-secondary" style="font-size: 200px"></i>
                                </div>
                                <div type="button" class="btn btn-primary btn-sm" onclick="download()">
                                    <i class="fa fa-download mr-1"></i>
                                    Download
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- @else --}}
                        <div class="col-6">
                            <label for="image">Preview</label>
                            <div id="previewContainer"></div>
                        </div>

                    {{-- @endif --}}

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
   #dropArea {
        border: 2px dashed #ccc;
        padding: 30px;
        text-align: center;
        background-color: #f2f2f2;
        transition: border-color 0.3s ease;
        position: relative;
    }

    #dropArea.highlight {
        border-color: #666;
    }

    #dropArea p {
        font-size: 18px;
        color: #666;
    }

    #dropArea:hover {
        cursor: pointer;
    }

    #uploadButton:focus {
        outline: none;
    }

    #fileInput {
        display: none;
    }
</style>

<script>
    @if(session('success'))
        Swal.fire('Success', '{{ session('success') }}', 'success');
    @endif
    @if(session('error'))
        Swal.fire('Oopss', '{{ session('error') }}', 'error');
    @endif

    function download() {
        var tempFile = document.getElementById('tempFile');
        var pdfUrl = tempFile.value;
        var fileName = 'file_service.pdf';

        var link = document.createElement('a');
        link.href = pdfUrl;
        link.download = fileName;
        link.target = '_blank';
        link.style.display = 'none';

        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }

    var dropArea = document.getElementById('dropArea');
    var fileInput = document.getElementById('fileInput');
    var uploadButton = document.getElementById('uploadButton');
    var previewContainer = document.getElementById('previewContainer');

    dropArea.addEventListener('dragenter', function(event) {
        event.preventDefault();
        event.stopPropagation();
        dropArea.classList.add('highlight');
    });

    dropArea.addEventListener('dragover', function(event) {
        event.preventDefault();
        event.stopPropagation();
    });

    dropArea.addEventListener('dragleave', function(event) {
        event.preventDefault();
        event.stopPropagation();
        dropArea.classList.remove('highlight');
    });

    dropArea.addEventListener('drop', function(event) {
        event.preventDefault();
        event.stopPropagation();
        dropArea.classList.remove('highlight');

        fileInput.files = event.dataTransfer.files;
        previewFile();
    });

    uploadButton.addEventListener('click', function() {
        fileInput.click();
    });

    fileInput.addEventListener('change', function() {
        previewFile();
    });

    function previewFile() {
        var file = fileInput.files[0];

        if (file.type === 'application/pdf') {
            var reader = new FileReader();

            reader.onload = function(event) {
                var pdfUrl = event.target.result;

                // Tampilkan pratinjau PDF di elemen <iframe>
                var iframe = document.createElement('iframe');
                iframe.src = pdfUrl;
                iframe.style.width = '100%';
                iframe.style.height = '700px';

                // Hapus pratinjau sebelumnya jika ada
                while (previewContainer.firstChild) {
                    previewContainer.firstChild.remove();
                }

                // Tambahkan elemen <iframe> ke dalam container pratinjau
                previewContainer.appendChild(iframe);
            };

            reader.readAsDataURL(file);
        } else {
            alert('Please choose file PDF!');
        }
    }

</script>


@endsection
