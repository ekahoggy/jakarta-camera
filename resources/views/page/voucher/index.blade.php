@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Voucher</h3>
                <a href="{{ route('voucher.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> &nbsp;
                    Tambah Data
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-md" id="table-voucher">
                        <tbody>
                            <tr class="bg-primary text-light">
                                <th rowspan="2">Status</th>
                                <th rowspan="2">Kode Redeem</th>
                                <th rowspan="2">Voucher</th>
                                <th rowspan="2">Jenis</th>
                                <th colspan="2" class="text-center">Periode</th>
                                <th colspan="2" class="text-center">Nilai Voucher</th>
                                <th rowspan="2">Terpakai</th>
                                <th rowspan="2">Action</th>
                            </tr>
                            <tr class="bg-primary text-light">
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Persen</th>
                                <th>Rupiah</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr>
                                    <td class="align-middle">{{ $val->nama }} [{{ $val->sku }}]</td>
                                    <td class="align-middle"><span class="label info">{{ $val->kategori }}</span></td>
                                    <td class="align-middle"><img src="{{ url('img/media/product/' . $val->foto) }}"
                                            alt="icon {{ $val->slug }}" width="50px"></td>
                                    <td class="align-middle"><span class="currency">{{ $val->harga }}</span></td>
                                    <td class="align-middle">
                                        @if ($val->type == 'J')
                                            <span class="label info">Jual</span>
                                        @else
                                            <span class="label warning">Titip</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @foreach ($val->arr_tags as $tag)
                                            @if ($tag !== '')
                                                <span class="label success">{{ $tag }}</span>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('produk.edit', $val->id) }}"
                                                class="btn btn-primary btn-sm mr-2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-danger fa fa-trash"
                                                onclick="hapus({{ $val->id }})"></button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    {!! $list->links() !!}
                </nav>
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

        function hapus(id) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/produk/delete/${id}`).then(res => {
                            if (res.data.success) {
                                Swal.fire('Success', 'Deleted successfully', 'success').then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Ops..', 'There is an error.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Ops..', 'There is an error.', 'error');
                        });
                }
            });
        }

        let x = document.querySelectorAll(".currency");
        for (let i = 0, len = x.length; i < len; i++) {
            let num = Number(x[i].innerHTML)
                .toLocaleString('en');
            x[i].innerHTML = num;
            x[i].classList.add("currSign");
        }
    </script>
@endsection
