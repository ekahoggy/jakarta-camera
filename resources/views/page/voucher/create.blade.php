@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    Tambah Voucher
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/voucher">Voucher</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('voucher.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 row">
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <h5>Data Voucher</h5>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="redeem_code">Kode Redeem</label>
                                        <input class="form-control form-control-sm" id="redeem_code" name="redeem_code"
                                            value="{{ old('redeem_code') }}" rows="5" placeholder="Masukkan kode redeem">
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="voucher">Nama</label>
                                        <input class="form-control form-control-sm" id="voucher" name="voucher"
                                            value="{{ old('voucher') }}" rows="5" placeholder="Masukkan Nama Voucher"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tanggal Mulai</label>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control datepicker" name="tanggal_mulai">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                    </div>
                                                    <input id="timepicker" class="form-control" type="text" name="jam_mulai">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tanggal Selesai</label>
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="form-control datepicker"
                                                        name="tanggal_selesai">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="fas fa-clock"></i>
                                                        </div>
                                                    </div>
                                                    <input id="timepicker2" class="form-control" type="text"
                                                        name="jam_selesai">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="qty">Jumlah</label>
                                        <input class="form-control form-control-sm" type="number" id="qty" name="qty"
                                            value="{{ old('qty') }}" placeholder="Jumlah Voucher"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label>Deskripsi Voucher</label>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="deskripsi"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-12">
                                    <h5>Detail Voucher</h5>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label class="required">Jenis Voucher</label>
                                        <div class="col-sm-12 p-0">
                                            <label class="custom-switch p-0" style="cursor: pointer">
                                                Transaksi &nbsp;&nbsp;
                                                <input type="checkbox" name="kategori" id="kategori" class="custom-switch-input">
                                                <span class="custom-switch-indicator"></span>
                                                &nbsp;&nbsp;
                                                Ongkir
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label class="required">Tipe Voucher</label>
                                        <div class="col-sm-12 p-0">
                                            <label class="custom-switch p-0" style="cursor: pointer">
                                                Persen &nbsp;&nbsp;
                                                <input type="checkbox" name="type" id="type" class="custom-switch-input" onchange="changeTipe()">
                                                <span class="custom-switch-indicator"></span>
                                                &nbsp;&nbsp;
                                                Nominal
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 nominal hidden">
                                    <div class="form-group">
                                        <label for="voucher_value">Nominal</label>
                                        <div class="input-container">
                                            <i class="icon">Rp</i>
                                            <input class="form-control form-control-sm input-field" type="text"
                                                placeholder="Masukkan Nominal" name="voucher_value" id="voucher_value"
                                                value="{{ old('voucher_value') }}" onkeyup="changeVal(this)">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 persen">
                                    <div class="form-group">
                                        <label for="voucher_value">Persen</label>
                                        <div class="input-container">
                                            <input class="form-control form-control-sm input-field" type="text"
                                                placeholder="Masukkan Persen" name="voucher_value" id="voucher_value"
                                                value="{{ old('voucher_value') }}">
                                            <i class="icon icon-right">%</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 bhs-indonesia">
                                    <div class="form-group">
                                        <label for="voucher_min_beli">Min. Pembelian</label>
                                        <div class="input-container">
                                            <i class="icon">Rp</i>
                                            <input class="form-control form-control-sm input-field" type="text"
                                                placeholder="Masukkan Minimal Pembelian" name="voucher_min_beli" id="voucher_min_beli"
                                                value="{{ old('voucher_min_beli') }}" onkeyup="changeVal(this)" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 persen">
                                    <div class="form-group">
                                        <label for="voucher_max">Max Potongan Voucher</label>
                                        <div class="input-container">
                                            <i class="icon">Rp</i>
                                            <input class="form-control form-control-sm input-field" type="text"
                                                placeholder="Masukkan Maksimal Potongan Voucher" name="voucher_max" id="voucher_max"
                                                value="{{ old('voucher_max') }}" onkeyup="changeVal(this)" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 bhs-indonesia ml-3">
                            <div class="form-group">
                                <label for="image">Gambar</label>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="drop-zone" id="drop-zone" data-target="#exampleModal"
                                            data-toggle="modal">
                                            <div class="drop-zone-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p>Drag and drop your image here</p>
                                            </div>
                                            <input type="text" name="gambar" id="image-input" class="hidden" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div id="image-preview" class="hidden bg-light text-center rounded p-2"
                                            data-target="#exampleModal" data-toggle="modal">
                                            <img id="preview-image" class="image-thumbnail" loading="lazy" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('produk.index') }}" class="btn btn-sm btn-light mr-2">
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
                <div class="modal-body px-0 pb-0">
                    @include('page.media-modal.modal-media')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

    <script>
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(function() {
            $('#timepicker').timepicker({
                showMeridian: false,
                showInputs: true
            });
            $('#timepicker2').timepicker({
                showMeridian: false,
                showInputs: true
            });

            $('select').selectize({
                sortField: 'text'
            });
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

        function changeVal(e) {
            const val = $(e).val();
            const updateVal = formatRupiah(val);
            $(e).val(updateVal);
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

        function changeTipe() {
            const tipe = document.getElementById('type').checked;
            var nominal = document.querySelectorAll(".nominal");
            var persen = document.querySelectorAll(".persen");
            if (tipe === true) {
                nominal.forEach((element) => {
                    element.classList.remove('hidden');
                });
                persen.forEach((element) => {
                    element.classList.add('hidden');
                });
            } else {
                nominal.forEach((element) => {
                    element.classList.add('hidden');
                });
                persen.forEach((element) => {
                    element.classList.remove('hidden');
                });
            }
        }
    </script>
@endsection
