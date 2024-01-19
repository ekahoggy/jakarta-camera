@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    Tambah Page
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/page">Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('page.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Judul</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ old('title') }}" rows="5" placeholder="Masukkan Judul"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="title">Deskripsi Singkat</label>
                                        <textarea class="form-control form-control-sm" id="short_description" name="short_description">{{ old('short_description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="drop-zone" id="drop-zone"
                                                    onclick="document.getElementById('image-input').click()">
                                                    <div class="drop-zone-text">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <p>Drag and drop your image here</p>
                                                    </div>
                                                    <input type="file" name="picture" id="image-input" accept="image/*"
                                                        onchange="showPreview(event)" class="hidden" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <div id="image-preview" class="hidden bg-light text-center rounded p-2" onclick="document.getElementById('image-input').click()">
                                                    <img id="preview-image" class="image-thumbnail" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="tags">Tags</label>
                                        <input class="form-control form-control-sm col" id="tags" name="tags"
                                            value="{{ old('tags') }}" rows="5" placeholder="Masukkan Tags"
                                            required data-role="tagsinput" onchange="changeTags(event)">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="short_content">Content Short</label>
                                        <input class="form-control form-control-sm" id="short_content" name="short_content"
                                            value="{{ old('short_content') }}" rows="5" placeholder="Masukkan Content Short"
                                            required>
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
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="wrapper center-block">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default">
                                            <div class="panel-heading active" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseOne" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        Status
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                                aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="title">Publish At</label>
                                                                <input type="datetime-local" class="form-control form-control-sm" name="publish_at" id="publish_at" value="{{ old('publish_at') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="title">Status</label>
                                                                <select
                                                                    class="form-control select2 select2-hidden-accessible"
                                                                    tabindex="-1" aria-hidden="true"
                                                                    style="width: 200px !important;" id="is_status"
                                                                    name="is_status">
                                                                    <option value="2">Publish</option>
                                                                    <option value="0">Draft</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('page.index') }}" class="btn btn-sm btn-light mr-2">
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

    <style>
        .wrapper {
            width: 100%;
            border: 0.5px solid #EAECF0;
        }

        .panel-default {
            padding: 25px;
        }

        .panel-heading {
            padding: 0;
            border: 0;
        }

        .panel-title>a,
        .panel-title>a:active {
            display: block;
            color: #555;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            word-spacing: 3px;
            text-decoration: none;
        }

        .panel-heading a:before {
            font-family: 'Glyphicons Halflings';
            content: "\e114";
            float: right;
            transition: all 0.5s;
        }

        .panel-heading.active a:before {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .bootstrap-tagsinput{
            display: block;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $('.panel-collapse').on('show.bs.collapse', function() {
            $(this).siblings('.panel-heading').addClass('active');
        });

        $('.panel-collapse').on('hide.bs.collapse', function() {
            $(this).siblings('.panel-heading').removeClass('active');
        });

        changeTimeZone();
        $(document).ready(function(){
            // $("#publish_at").datepicker();
        });

        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function changeTimeZone() {
            // var y = document.getElementsByClassName('timepicker');
            // var aNode = y[0].datetimepicker({
            //     use24hours: true,
            //     format: 'HH:mm'
            // });
            // var datetime = document.getElementById('publish_at');
            // datetime.datepicket
            // $('#publish_at').datetimepicker({
            //     format: 'hh:mm:ss a'
            // });

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

        function changeTags(event) {
          var $element = $(event.target);
          var $container = $element.closest('.example');

          if (!$element.data('tagsinput')) return;

          var val = $element.val();
          if (val === null) val = 'null';
          var items = $element.tagsinput('items');

          $('code', $('pre.val', $container)).html(
            $.isArray(val)
              ? JSON.stringify(val)
              : '"' + val.replace('"', '\\"') + '"'
          );
          $('code', $('pre.items', $container)).html(
            JSON.stringify($element.tagsinput('items'))
          );
        }
        // .trigger('change');
    </script>
@endsection
