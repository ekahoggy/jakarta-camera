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
                                <th rowspan="2" class="align-middle">Status</th>
                                <th rowspan="2" class="align-middle">Kode Redeem</th>
                                <th rowspan="2" class="align-middle">Voucher</th>
                                <th rowspan="2" class="align-middle">Jenis</th>
                                <th colspan="2" class="align-middle text-center">Periode</th>
                                <th colspan="2" class="align-middle text-center">Nilai Voucher</th>
                                <th rowspan="2" class="align-middle text-center">Terpakai</th>
                                <th rowspan="2" class="align-middle">Action</th>
                            </tr>
                            <tr class="bg-primary text-light">
                                <th class="text-center">Mulai</th>
                                <th class="text-center">Selesai</th>
                                <th class="text-center">Persen</th>
                                <th class="text-center">Rupiah</th>
                            </tr>
                            @foreach ($list as $key => $val)
                                <tr>
                                    <td class="align-middle">
                                        @if ($val->is_status == 1)
                                            <span class="label success">Aktif</span>
                                        @else
                                            <span class="label warning">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="align-middle">{{ $val->redeem_code }}</td>
                                    <td class="align-middle">{{ $val->voucher }}</td>
                                    <td class="align-middle">
                                        @if ($val->kategori == 'T')
                                            <span>Transaksi</span>
                                        @else
                                            <span>Ongkir</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">{{ date('l', strtotime($val->tanggal_mulai)) }}, {{ date('d-m-Y', strtotime($val->tanggal_mulai)) }} <br>{{ date('H:i', strtotime($val->jam_mulai)) }}</td>
                                    <td class="align-middle text-center">{{ date('l', strtotime($val->tanggal_selesai)) }}, {{ date('d-m-Y', strtotime($val->tanggal_selesai)) }} <br>{{ date('H:i', strtotime($val->jam_selesai)) }}</td>
                                    <td class="align-middle text-center">
                                        @if ($val->type == 'P')
                                            {{ $val->voucher_value }}%
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        @if ($val->type == 'N')
                                            <span class="currency">{{ $val->voucher_value }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">{{ $val->voucher_used }}</td>
                                    <td class="align-middle text-right">
                                        <div class="d-flex align-items-center">
                                            <a href="{{ route('voucher.edit', $val->id) }}"
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
                    axios.delete(`/voucher/delete/${id}`).then(res => {
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
