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
                <form method="post" action="{{ route('promo.store') }}" enctype="multipart/form-data">
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
                                                <input id="timepicker" class="form-control" type="text"
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
                                        value="{{ old('promo_min_beli') }}" placeholder="Masukkan Minimal Pembelian">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped table-md" id="table-detail">
                                    <thead>
                                        <tr class="bg-primary text-light">
                                            <td width="5%" rowspan="2" class="text-center vertical-align-middle"><i
                                                    class="fa fa-plus" onclick="addRow('table-detail')"></i></td>
                                            <td colspan="4" class="text-center">Produk</td>
                                        </tr>
                                        <tr class="bg-primary text-light">
                                            <td>Nama</td>
                                            <td width="15%">Harga</td>
                                            <td width="10%">Jumlah</td>
                                            <td width="5%">Sisa</td>
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
                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="fa fa-save"></i> &nbsp; Simpan
                        </button>
                    </div>
                </form>
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

            $('select').selectize({
                sortField: 'text'
            });
        });

        let selectedProduk = [];

        function addRow(tableID) {
            // Get a reference to the table
            let tableRef = document.getElementById(tableID);
            // Insert a row at the end of the table
            let newRow = tableRef.insertRow(-1);
            const rowId = tableRef.rows.length - 2;
            newRow.id = rowId;

            // tombol hapus
            let iconDelete = newRow.insertCell(0);
            let newIcon = document.createElement('div');
            newIcon.setAttribute("id", "delete-" + newRow.id);
            newIcon.className = "text-center vertical-align-middle";
            var adding_new1 = "<i class='fa fa-trash color-red'></i>";
            $(newIcon).html(adding_new1);
            iconDelete.appendChild(newIcon);

            // select produk
            let produk = newRow.insertCell(1);
            let produkComp = document.createElement('div');
            produkComp.setAttribute("id", "select-produk-" + newRow.id);
            // produkComp.className = "text-center vertical-align-middle";
            var adding_new2 = '<div class="form-group"><div class="form-group"><select id="detail-produk-' + newRow.id +
                '" name="listPromoProduk[]" onchange="search(' + newRow.id +
                ')"><option value="">Pilih Produk</option>@foreach ($listProduk as $item)<option value="{{ $item->id }}">{{ $item->nama }}</option>@endforeach</select></div></div>';
            $(produkComp).html(adding_new2);
            produk.appendChild(produkComp);

            // harga produk
            let harga = newRow.insertCell(2);
            let hargaComp = document.createElement('div');
            hargaComp.setAttribute("id", "harga-produk-" + newRow.id);

            // jumlah produk
            let jumlah = newRow.insertCell(3);
            let jumlahComp = document.createElement('div');
            jumlahComp.setAttribute("id", "jumlah-produk-" + newRow.id);

            // sisa produk
            let sisa = newRow.insertCell(4);
            let sisaComp = document.createElement('div');
            sisaComp.setAttribute("id", "sisa-produk-" + newRow.id);
        }

        function search(id) {
            var compSelectProduk = document.getElementById("detail-produk-" + id);
            var id_produk = compSelectProduk.value;
            axios.get(`/produk/getProdukById/` + id_produk).then(res => {
                if (res.data.success) {
                    let data = res.data.data;
                    let harga = document.getElementById("harga-produk-" + id);
                    let jumlah = document.getElementById("jumlah-produk-" + id);
                    let sisa = document.getElementById("sisa-produk-" + id);

                    console.log(harga);
                    console.log(data.harga);
                    $(harga).html('<span>Rp. ' + data.harga + '</span>');
                }
            });
        }

        function selectProduct(data) {
            
        }
    </script>
@endsection
