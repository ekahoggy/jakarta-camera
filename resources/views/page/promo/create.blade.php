@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>
                    Tambah Promo
                </h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/promo">Promo</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Create</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form>
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="col-md-12 bhs-indonesia">
                                <div class="form-group">
                                    <label for="kode">Kode Promo</label>
                                    <input class="form-control form-control-sm" id="kode" name="kode"
                                        value="{{ old('kode') }}" placeholder="Kode Generate Otomatis" disabled>
                                </div>
                            </div>
                            <div class="col-md-12 bhs-indonesia">
                                <div class="form-group">
                                    <label for="promo">Nama Promo</label>
                                    <input class="form-control form-control-sm" id="promo" name="promo"
                                        value="{{ old('promo') }}" placeholder="Masukkan Nama Promo" required>
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
                                                <input type="text" class="form-control datepicker" id="tanggal_mulai"
                                                    name="tanggal_mulai">
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
                                                <input type="text" class="form-control datepicker" id="tanggal_selesai"
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
                                    <label for="promo_min_beli">Minimal Pembelian</label>
                                    <input class="form-control form-control-sm" id="promo_min_beli" name="promo_min_beli"
                                        value="{{ old('promo_min_beli') }}" placeholder="Masukkan Minimal Pembelian"
                                        style="max-width: 150px;">
                                </div>
                            </div>
                            <div class="col-md-12 bhs-indonesia">
                                <div class="form-group">
                                    <label class="required">Flashsale</label>
                                    <div class="col-sm-12 p-0">
                                        <label class="custom-switch p-0" style="cursor: pointer">
                                            Tidak &nbsp;&nbsp;
                                            <input type="checkbox" name="is_flashsale" id="is_flashsale"
                                                class="custom-switch-input">
                                            <span class="custom-switch-indicator"></span>
                                            &nbsp;&nbsp;
                                            Ya
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="table-detail">
                                    <thead>
                                        <tr class="bg-primary text-light">
                                            <td width="5%" rowspan="2" class="text-center vertical-align-middle"><i
                                                    class="fa fa-plus" onclick="addRow()"></i></td>
                                            <td colspan="5" class="text-center">Produk</td>
                                        </tr>
                                        <tr class="bg-primary text-light">
                                            <td>Nama</td>
                                            <td width="15%">Harga</td>
                                            <td width="10%">Jumlah</td>
                                            <td width="5%">Sisa</td>
                                            <td width="15%">Diskon</td>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('promo.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="fa fa-chevron-left"></i> &nbsp; Kembali
                        </a>
                        <button class="btn btn-sm btn-primary" type="button" onclick="save()">
                            <i class="fa fa-save"></i> &nbsp; Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalProduk" tabindex="-1" role="dialog" aria-labelledby="modalProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    @include('page.produk.modal-produk')
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
            $('#modalProduk').appendTo("body")
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

        function openModalProduk() {
            $('#modalProduk').modal('show');
            addRow();
        }

        let idx = 1;
        let selectedProduk = [];

        function addRow() {
            // Get a reference to the table
            let tableRef = document.getElementById('table-detail');
            // Insert a row at the end of the table
            let newRow = tableRef.insertRow(-1);
            const rowId = tableRef.rows.length - 2;
            newRow.id = rowId;
            idx = parseInt(newRow.id);

            // tombol hapus
            let iconDelete = newRow.insertCell(0);
            let newIcon = document.createElement('div');
            newIcon.setAttribute("id", "delete-" + newRow.id);
            newIcon.className = "text-center vertical-align-middle";
            var adding_new1 = "<i class='fa fa-trash color-red' onclick='deleteRow(" + newRow.id + ")'></i>";
            $(newIcon).html(adding_new1);
            iconDelete.appendChild(newIcon);

            // produk
            let produk = newRow.insertCell(1);
            let produkComp = document.createElement('div');
            produkComp.setAttribute("id", "produk-" + newRow.id);
            $(produkComp).html(
                '<select id="selectProdukId" name="selectProdukId" placeholder="Pilih Produk" onchange="selectProduk()">' +
                '<option value="">Pilih Produk</option>' +
                '@foreach ($listProduk as $item)' +
                '<option value="{{ $item->id }}">{{ $item->nama }}</option>' +
                '@endforeach' +
                '</select>');
            produk.appendChild(produkComp);

            // harga produk
            let harga = newRow.insertCell(2);
            let hargaComp = document.createElement('div');
            hargaComp.setAttribute("id", "harga-produk-" + newRow.id);
            $(hargaComp).html('');
            harga.appendChild(hargaComp);

            // jumlah produk
            let jumlah = newRow.insertCell(3);
            let jumlahComp = document.createElement('div');
            jumlahComp.setAttribute("id", "jumlah-produk-" + newRow.id);
            $(jumlahComp).html(
                '<input class="form-control form-control-sm" id="jumlah-' + newRow.id + '" name="jumlah-' + newRow.id +
                '" value="1" placeholder="Jumlah Promo" onkeyup="changeJumlah(' + newRow.id + ')">'
            );
            jumlah.appendChild(jumlahComp);

            // sisa produk
            let sisa = newRow.insertCell(4);
            let sisaComp = document.createElement('div');
            sisaComp.setAttribute("id", "sisa-produk-" + newRow.id);
            $(sisaComp).html('<span>-</span>');
            sisa.appendChild(sisaComp);

            // diskon produk
            let diskon = newRow.insertCell(5);
            let diskonComp = document.createElement('div');
            diskonComp.setAttribute("id", "diskon-produk-" + newRow.id);
            $(diskonComp).html('<input class="form-control form-control-sm" id="diskon-' + newRow.id + '" name="diskon-' + newRow.id +
                '" value="0" placeholder="Jumlah Diskon" onkeyup="changeDiskon(' + newRow.id + ')">');
            diskon.appendChild(diskonComp);

        }

        function save() {
            const data = {
                'promo': document.getElementById('promo').value,
                'tanggal_mulai': document.getElementById('tanggal_mulai').value,
                'tanggal_selesai': document.getElementById('tanggal_selesai').value,
                'jam_mulai': document.getElementById('timepicker').value,
                'jam_selesai': document.getElementById('timepicker2').value,
                'promo_min_beli': document.getElementById('promo_min_beli').value,
                'is_flashsale': document.getElementById('is_flashsale').checked,
                'detail_promo': selectedProduk
            };
            axios.post('/promo/store', data);
        }

        function deleteRow(id) {
            console.log(id);
        }

        function changeJumlah(id) {
            if(selectedProduk.length > 0) {
                selectedProduk.forEach((val, k) => {
                    if(val.idx == id) {
                        val.jumlah = parseInt(document.getElementById('jumlah-'+id).value)
                    }
                });
            }
        }

        function changeDiskon(id) {
            if(selectedProduk.length > 0) {
                selectedProduk.forEach((val, k) => {
                    if(val.idx == id) {
                        val.diskon = parseInt(document.getElementById('diskon-'+id).value)
                    }
                });
            }
        }

        function selectProduk() {
            var e = document.getElementById("selectProdukId");
            var value = e.value;

            axios.get(`/produk/getProdukById/` + value).then(res => {
                if (res.data.success) {
                    let data = res.data.data;
                    let produk = document.getElementById("produk-" + idx);
                    let harga = document.getElementById("harga-produk-" + idx);
                    let jumlah = document.getElementById("jumlah-produk-" + idx);

                    $(produk).html('<span>' + data.nama + '</span>');
                    $(harga).html('<span class="currency">' + rupiah(data.harga) + '</span>');

                    let arr = {
                        "idx": idx,
                        "id": data.id,
                        "nama": data.nama,
                        "harga": data.harga,
                        "jumlah": 1,
                        "diskon": 1,
                    };
                    selectedProduk.push(arr);
                    $('#modalProduk').modal('hide');
                }
            });
        }

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(number);
        }
    </script>
@endsection
