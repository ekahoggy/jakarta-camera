@extends('layout.main')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-wrap">
                        <div class="card-header d-flex" style="padding-left: 10px;">
                            <div class="col">
                                <h4>Total Donasi</h4>
                            </div>
                            <div class="col-1">
                                <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.333496" width="36" height="36" rx="8" fill="#FFF8F3" />
                                    <path
                                        d="M21.6667 18C23.9667 18 25.8333 16.1333 25.8333 13.8333C25.8333 11.5333 23.9667 9.66667 21.6667 9.66667C19.3667 9.66667 17.5 11.5333 17.5 13.8333C17.5 16.1333 19.3667 18 21.6667 18ZM26.2083 22.6667C25.8833 22.3333 25.475 22.1667 25 22.1667H19.1667L17.4333 21.5583L17.7083 20.775L19.1667 21.3333H21.5C21.7917 21.3333 22.025 21.2167 22.2167 21.025C22.4083 20.8333 22.5 20.6 22.5 20.3417C22.5 19.8917 22.2833 19.5833 21.85 19.4083L15.7917 17.1667H14.1667V24.6667L20 26.3333L26.6917 23.8333C26.7 23.3917 26.5333 23 26.2083 22.6667ZM12.5 17.1667H9.15332V26.3333H12.5V17.1667Z"
                                        fill="#F98341" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-body txt-dashboard">
                            Rp {{ number_format($total_nominal['total_nominal'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-wrap">
                        <div class="card-header d-flex" style="padding-left: 10px;">
                            <div class="col">
                                <h4>Total Onetime Donasi</h4>
                            </div>
                            <div class="col-1">
                                <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.333496" width="36" height="36" rx="8" fill="#FFF8F3" />
                                    <path
                                        d="M21.6667 18C23.9667 18 25.8333 16.1333 25.8333 13.8333C25.8333 11.5333 23.9667 9.66667 21.6667 9.66667C19.3667 9.66667 17.5 11.5333 17.5 13.8333C17.5 16.1333 19.3667 18 21.6667 18ZM26.2083 22.6667C25.8833 22.3333 25.475 22.1667 25 22.1667H19.1667L17.4333 21.5583L17.7083 20.775L19.1667 21.3333H21.5C21.7917 21.3333 22.025 21.2167 22.2167 21.025C22.4083 20.8333 22.5 20.6 22.5 20.3417C22.5 19.8917 22.2833 19.5833 21.85 19.4083L15.7917 17.1667H14.1667V24.6667L20 26.3333L26.6917 23.8333C26.7 23.3917 26.5333 23 26.2083 22.6667ZM12.5 17.1667H9.15332V26.3333H12.5V17.1667Z"
                                        fill="#F98341" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-body txt-dashboard">
                            Rp {{ number_format($total_nominal['total_onetime'], 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card card-statistic-2">
                    <div class="card-wrap">
                        <div class="card-header d-flex" style="padding-left: 10px;">
                            <div class="col">
                                <h4>Total Donasi Sponsorship Anak </h4>
                            </div>
                            <div class="col-1">
                                <svg width="37" height="36" viewBox="0 0 37 36" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.333496" width="36" height="36" rx="8" fill="#FFF8F3" />
                                    <path
                                        d="M21.6667 18C23.9667 18 25.8333 16.1333 25.8333 13.8333C25.8333 11.5333 23.9667 9.66667 21.6667 9.66667C19.3667 9.66667 17.5 11.5333 17.5 13.8333C17.5 16.1333 19.3667 18 21.6667 18ZM26.2083 22.6667C25.8833 22.3333 25.475 22.1667 25 22.1667H19.1667L17.4333 21.5583L17.7083 20.775L19.1667 21.3333H21.5C21.7917 21.3333 22.025 21.2167 22.2167 21.025C22.4083 20.8333 22.5 20.6 22.5 20.3417C22.5 19.8917 22.2833 19.5833 21.85 19.4083L15.7917 17.1667H14.1667V24.6667L20 26.3333L26.6917 23.8333C26.7 23.3917 26.5333 23 26.2083 22.6667ZM12.5 17.1667H9.15332V26.3333H12.5V17.1667Z"
                                        fill="#F98341" />
                                </svg>
                            </div>
                        </div>
                        <div class="card-body txt-dashboard">
                            Rp {{ number_format($total_nominal['total_sponsorship'], 0, ',', '.') }} <span class="dashboard-child">{{ $total_nominal['total_anak_terdonasi'] }} Anak terdonasi</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom-none row">
                        <div class="col-4 d-flex px-1">
                            <span class="my-auto">Search Event : </span>
                            <div class="ml-2 col">
                                <select class="form-control" name="vendor_id" required="required" id="filter_event" style="border-radius: 0;" onchange="getDetailEvent()">
                                    @foreach ($event_list as $key => $item)
                                    <option id="event_{{$item->id}}" class="filter_event_detail" value="{{$item->id}}">{{$item->event}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-8 d-flex justify-content-end px-1">
                            <span class="my-auto">Search : </span>
                            <div class="input-group col-5 ml-2 pr-0">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                                <input type="text" class="form-control" placeholder="Ketik untuk mencari" id="search_filter" style="border-radius: 0;height: unset;">
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 col-sm-4 col-lg-4">
                                <div class="card h-100 donation-recap">

                                    <div class="card-header border-bottom-none">
                                        <h4 class="dashboard-title">Donation Recap</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6 recap-title">
                                                <span>Tanggal Pelaksanaan</span>
                                            </div>
                                            <div class="col-6 recap-title">
                                                <span>Jumlah Partisipan Donasi</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="tgl_detail_event">-</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="total_participant">66 Partisipan</span>
                                            </div>

                                            <div class="col-6 recap-title" style="padding-top: 25px;">
                                                <span>Waktu Pelaksanaan</span>
                                            </div>
                                            <div class="col-6 recap-title" style="padding-top: 25px;">
                                                <span>Jumlah Berhasil</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="time_event">10.00 - 14.00</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="paid_success">59 Orang</span>
                                            </div>

                                            <div class="col-6 recap-title" style="padding-top: 25px;">
                                                <span>Jenis Donasi</span>
                                            </div>
                                            <div class="col-6 recap-title" style="padding-top: 25px;">
                                                <span>Jumlah Gagal</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="type_donation">One Time Donation</span>
                                            </div>
                                            <div class="col-6 recap-values">
                                                <span id="paid_fail">7 Orang</span>
                                            </div>

                                            <div class="col-6 recap-title" style="padding-top: 25px;">
                                                <span>Total Donasi yang Didapatkan</span>
                                            </div>
                                            <div class="col-6 recap-title" style="padding-top: 25px;"></div>
                                            <div class="col-6 recap-values">
                                                <span id="total_donation">10.980.000</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 col-sm-8 col-lg-8">
                                <div class="card h-100 donation-recap">
                                    <div class="card-header border-bottom-none">
                                        <h4 class="dashboard-title">Statistical Total Donation</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="chartjs-size-monitor"
                                            style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;">
                                            <div class="chartjs-size-monitor-expand"
                                                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div
                                                    style="position:absolute;width:1000000px;height:1000000px;left:0;top:0">
                                                </div>
                                            </div>
                                            <div class="chartjs-size-monitor-shrink"
                                                style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;">
                                                <div style="position:absolute;width:200%;height:200%;left:0; top:0"></div>
                                            </div>
                                        </div>
                                        <canvas id="myChart2" height="439" width="733"
                                            style="display: block; width: 733px; height: 439px;"
                                            class="chartjs-render-monitor"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-7 col-md-12 col-12 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="dashboard-title">Donasi Terbaru</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Di Event</th>
                                        <th>Jumlah Donasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donasi_terbaru as $item)
                                    {{-- {{$item}} --}}
                                    <tr>
                                        <td>
                                            <a href="/donasi/edit/{{$item->id}}" class="font-weight-600"><img
                                                    src="{{ asset('img/default-user.png') }}" alt="avatar"
                                                    width="30" class="rounded-circle mr-1"> {{ $item->name }}</a>
                                        </td>
                                        <td>
                                            {{ $item->wnsm }}
                                        </td>
                                        <td>
                                            Rp, {{ number_format($item->total_donation, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="dashboard-title">Activity Log</h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="row log-activity">
                            <div class="col-12">
                                <span class="loguser"> Recently Published </span>
                            </div>
                            <div class="col-12 pt-2">
                                <ul class="bar">
                                    @foreach ($log_user as $item)
                                        <li class="d-flex">
                                            <div class="row p-0 m-0 col-12">
                                                <div class="col-4 p-0">
                                                    <span class="txt-log" style="font-size: 12px;">{{ $item->date_convert }}</span>
                                                </div>
                                                <div class="col-8 p-0">
                                                    <span class="txt-log" style="font-size: 12px;">{{ $item->log }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>

    <script>

        $(function(){
            var list_option = document.querySelectorAll('.filter_event_detail');
            if (list_option.length > 0) {
                // set selected first loaded
                $('#filter_event').val($(list_option).val());
                getDetailEvent();
            }

            getStatisic();
        });

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                $('#search_filter').val(urlParams.get('search'));
            }
        });

        document.querySelector('#search_filter').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                search();
            }
        });

        function search() {
            var comp_search = document.getElementById("search_filter");
            var value_search = comp_search.value;

            var param = value_search.length > 0 ? "?" : "";
            // param += value_search.length > 0 ? "&" : "";
            param += value_search.length > 0 ? "search=" + encodeURI(value_search) : "";

            // var reload_url = window.location.href.split("?")[0];

            // window.location.href = reload_url + param;
            getStatisic(param);
        }

        function getDetailEvent(params) {
            var id = params != undefined && params > 0 ? params : $('#filter_event').val();
            axios.get(`/detail-event/${id}`).then(res => {
                    if (res.data.success) {
                        var data = res.data.data;
                        let type = data.get_type;
                        let type_tampil = '';
                        type.forEach(val => {
                            if(val.type === "0"){
                                val.jenis = 'One Time Donation';
                            }
                            else{
                                val.jenis = 'Sponsorship Donation';
                            }

                            type_tampil += val.jenis + ' ';
                        });

                        $('#tgl_detail_event').text(formatDate(data.date) ?? "-");
                        $('#total_participant').text(data.all_donation_count == 0 ? "-" : data.all_donation_count +' Partisipan');

                        $('#time_event').text(data.time + ' ' + data.zona ?? "-");
                        $('#paid_success').text(data.donation_paid_count == 0 ? "-" : data.donation_paid_count +' Orang');

                        $('#type_donation').text(type.length == 0 ? "-" : type_tampil);
                        $('#paid_fail').text(data.donation_unpaid_count == 0 ? "-" : data.donation_unpaid_count + ' Orang');

                        $('#total_donation').text(formatRupiah(data.get_total_donation_count, true));

                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error. \n'+error, 'error');
            });
        }

        function formatDate(date) {
            var d = new Date(date),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                monthhName = date.toLocaleString('default', { month: 'long' }),
                year = d.getFullYear();

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];


            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [day, monthNames[parseInt(month)], year].join(' ');
        }

        function formatTime(date){
            var d = new Date(date),
            minutes = d.getMinutes(),
            hour = d.getHours();

            return [hour, minutes].join(':');
        }

        function formatRupiah(angka, prefix) {
            if (angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, '').toString(),
                    split = number_string.split('.'),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + '.' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }else{
                return 'Rp. -'
            }
        }

        function getStatisic(param='') {
            axios.get(`/statistic${param}`).then(res => {
                    if (res.data.success) {
                        var data = res.data.data;
                        var xValues = data.label;
                        var yValues = data.dataRealita;
                        var yValues2 = data.dataTarget;

                        new Chart("myChart2", {
                            type: "bar",
                            data: {
                                labels: xValues,
                                datasets: [
                                // {
                                //     label: "realita",
                                //     backgroundColor: '#D48CB3',
                                //     data: yValues
                                // },
                                {
                                    label: "Donasi",
                                    backgroundColor: '#82BCFC',
                                    data: yValues2
                                }]
                            },

                        });

                        // if (data.idEvent > 0) {
                            getDetailEvent(data.idEvent);
                        // }
                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error. \n'+error, 'error');
            });
        }

    </script>
@endsection

