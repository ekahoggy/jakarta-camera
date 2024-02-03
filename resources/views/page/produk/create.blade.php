@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    Tambah Produk
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/produk">Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('produk.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="sku">Kode SKU</label>
                                        <input class="form-control form-control-sm" id="sku" name="sku"
                                            value="{{ old('sku') }}" rows="5" placeholder="Generate Otomatis"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="nama">Nama Produk</label>
                                        <input class="form-control form-control-sm" id="nama" name="nama"
                                            value="{{ old('nama') }}" rows="5" placeholder="Masukkan Nama Produk"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <div class="input-container">
                                            <i class="fa fa-envelope icon"></i>
                                            <input class="input-field" type="number" placeholder="Masukkan Harga Produk"
                                                name="harga" id="harga" value="{{ old('harga') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label>Keterangan Produk</label>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label class="required">Deskripsi Produk</label>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote required" name="content"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label for="kategori">Kategori</label>
                                            <select id="induk_id" name="m_kategori_id" placeholder="Pilih kategori">
                                                <option value="">Pilih induk kategori</option>
                                                @foreach ($listKategori as $item)
                                                    <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="link_shopee">Link Shopee</label>
                                        <input class="form-control form-control-sm" id="link_shopee" name="link_shopee"
                                            value="{{ old('link_shopee') }}" rows="5"
                                            placeholder="Masukkan Link Shopee" required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="link_tokped">Link Tokopedia</label>
                                        <input class="form-control form-control-sm" id="link_tokped" name="link_tokped"
                                            value="{{ old('link_tokped') }}" rows="5"
                                            placeholder="Masukkan Link Tokopedia" required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="link_bukalapak">Link Bukalapak</label>
                                        <input class="form-control form-control-sm" id="link_bukalapak"
                                            name="link_bukalapak" value="{{ old('link_bukalapak') }}" rows="5"
                                            placeholder="Masukkan Link Bukalapak" required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="link_lazada">Link Lazada</label>
                                        <input class="form-control form-control-sm" id="link_lazada" name="link_lazada"
                                            value="{{ old('link_lazada') }}" rows="5"
                                            placeholder="Masukkan Link Lazada" required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="link_blibli">Link Lazada</label>
                                        <input class="form-control form-control-sm" id="link_blibli" name="link_blibli"
                                            value="{{ old('link_blibli') }}" rows="5"
                                            placeholder="Masukkan Link Lazada" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 px-4 bhs-indonesia">
                            <div class="form-group">
                                <label for="image">Gambar Produk</label>

                                <div class="upload__box">
                                    <div class="upload__btn-box">
                                        <label class="upload__btn">
                                            <i class="fa fa-plus"> Upload Foto Produk</i>
                                            <input type="file" multiple="" data-max_length="20"
                                                class="upload__inputfile">
                                        </label>
                                    </div>
                                    <div class="upload__img-wrap"></div>
                                </div>
                                {{-- <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone" id="drop-zone" data-target="#exampleModal"
                                            data-toggle="modal">
                                            <div class="drop-zone-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop your image here</p>
                                            </div>
                                            <input type="text" name="icon" id="image-input" class="hidden" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="image-preview" class="hidden bg-light text-center rounded p-2"
                                            data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" loading="lazy" />
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('faq.index') }}" class="btn btn-sm btn-light mr-2">
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

        jQuery(document).ready(function() {
            ImgUpload();
        });

        function ImgUpload() {
            var imgWrap = "";
            var imgArray = [];

            $('.upload__inputfile').each(function() {
                $(this).on('change', function(e) {
                    imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
                    var maxLength = $(this).attr('data-max_length');

                    var files = e.target.files;
                    var filesArr = Array.prototype.slice.call(files);
                    var iterator = 0;
                    filesArr.forEach(function(f, index) {

                        if (!f.type.match('image.*')) {
                            return;
                        }

                        if (imgArray.length > maxLength) {
                            return false
                        } else {
                            var len = 0;
                            for (var i = 0; i < imgArray.length; i++) {
                                if (imgArray[i] !== undefined) {
                                    len++;
                                }
                            }
                            if (len > maxLength) {
                                return false;
                            } else {
                                imgArray.push(f);

                                var reader = new FileReader();
                                reader.onload = function(e) {
                                    var html =
                                        "<div class='upload__img-box'><div style='background-image: url(" +
                                        e.target.result + ")' data-number='" + $(
                                            ".upload__img-close").length + "' data-file='" + f
                                        .name +
                                        "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    iterator++;
                                }
                                reader.readAsDataURL(f);
                            }
                        }
                    });
                });
            });

            $('body').on('click', ".upload__img-close", function(e) {
                var file = $(this).parent().data("file");
                for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i].name === file) {
                        imgArray.splice(i, 1);
                        break;
                    }
                }
                $(this).parent().parent().remove();
            });
        }
    </script>
@endsection
