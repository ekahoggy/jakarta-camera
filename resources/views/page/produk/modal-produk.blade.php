<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 row">
                <div class="col-md-12 bhs-indonesia">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="produk">Produk</label>
                            <select id="selectProdukId" name="selectProdukId" placeholder="Pilih Produk"
                                onchange="selectProduk()">
                                <option value="">Pilih Produk</option>
                                @foreach ($listProduk as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} - <span
                                            class="currency">{{ $item->harga }}</span></option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
