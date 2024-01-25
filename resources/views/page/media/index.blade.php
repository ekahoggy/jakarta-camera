@extends('layout.main')

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Media Library</h3>
                <div class="col-4 text-right">
                    *Max Upload 2 Mb &nbsp;
                    <a href="{{ route('media.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> &nbsp;
                        Tambah Data
                    </a>
                </div>
            </div>
            <div class="section-filter card-body d-flex">
                <div class="col-8 d-flex px-1 justify-content-start align-items-center">
                    <div class="col-3">
                        <input type="text" class="form-control" name="date" id="date" placeholder="Semua Bulan"
                            onchange="search()">
                    </div>
                    <div class="col-2">
                        <button id="delete-all" class="btn btn-outline-warning hidden" onclick="deleteAll()">Hapus
                            Semua</button>
                    </div>
                </div>
                <div class="col-4">
                    <div class="search-section d-flex">
                        <label for="search" class="my-auto mr-2">Search :</label>
                        <div class="input-group col px-0">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Ketik untuk mencari" id="search_filter">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            @if($list->links() == null)
                            <div class="gallery gallery-md empty-data">
                                <img src="{{url('/img/images/empty_data.png')}}" alt="Empty Data">
                                <p>Data Kosong</p>
                            </div>
                            @else
                            <div class="gallery gallery-md row d-flex">
                                @foreach ($list as $item)
                                    <div id="divAllCheckbox" class="col-md-2" style="max-width: 200px;">
                                        <div class="custom-control custom-checkbox remove-image checkbox-galery">
                                            <input type="checkbox" class="custom-control-input" name="itemcheckbox"
                                                id="checkdelete-{{ $item->id }}" value="{{ $item->id }}">
                                        </div>
                                        <div class="gallery-item" data-image="{{ url('img/media/originals/'.$item->file)}}"
                                            data-title="{{ $item->file }}" href="{{ url('img/media/originals/'.$item->file)}}"
                                            title="{{ $item->file }}"
                                            style="background-image: url(&quot;{{ url('img/media/originals/'.$item->file)}}&quot;);">
                                        </div>
                                        <a class="remove-image" href="#" onclick="hapus('{{ $item->id }}')"
                                            style="display: inline;">
                                            <svg style="width: 30px; height: 30px;" onclick="hapus({{ $item->id }});"
                                                width="44" height="44" viewBox="0 0 44 44" fill="none"
                                                class="delete-icon" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="44" height="44" fill="#F04438" />
                                                <path
                                                    d="M16 29C16 30.1 16.9 31 18 31H26C27.1 31 28 30.1 28 29V19C28 17.9 27.1 17 26 17H18C16.9 17 16 17.9 16 19V29ZM28 14H25.5L24.79 13.29C24.61 13.11 24.35 13 24.09 13H19.91C19.65 13 19.39 13.11 19.21 13.29L18.5 14H16C15.45 14 15 14.45 15 15C15 15.55 15.45 16 16 16H28C28.55 16 29 15.55 29 15C29 14.45 28.55 14 28 14Z"
                                                    fill="white" />
                                            </svg>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <nav class="d-inline-block">
                    {!! $list->links() !!}
                </nav>
            </div>
        </div>
    </div>

    <style>
        .gallery-item .hover {
            visibility: hidden;
        }

        .gallery-item:hover .hover {
            visibility: visible;
        }

        .checkbox-galery {
            display: flex !important;
            left: 16px;
            right: unset !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .custom-control-input {
            position: absolute;
            left: -7px;
            z-index: 0;
            width: 2rem !important;
            height: 1.25rem;
            opacity: 100%;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>

    <script>
        let arr = [];
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $("#date").datepicker({
            format: "mm-yyyy",
            startView: "months",
            minViewMode: "months",
            autoclose: true,
            orientation: 'bottom'
        });

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                $('#search_filter').val(urlParams.get('search'));
            }
            if (urlParams.has('date')) {
                $('#date').val(urlParams.get('date'));
            }
        });

        document.querySelector('#search_filter').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                search();
            }
        });

        function search() {
            var comp_date = document.getElementById("date");
            var comp_search = document.getElementById("search_filter");
            var value_search = comp_search.value;
            var value_date = comp_date.value;

            console.log(value_date)

            var param = comp_date.value != '' || value_search.length > 0 ? "?" : "";
            param += comp_date.value != '' ? "date=" + value_date : '';
            param += comp_date.value != '' && value_search.length > 0 ? "&" : "";
            param += value_search.length > 0 ? "search=" + encodeURI(value_search) : "";

            var reload_url = window.location.href.split("?")[0];

            window.location.href = reload_url + param;
        }

        function hapus(id = '') {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/media/delete/${id}`).then(res => {
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

        function deleteAll() {
            var checkboxes = document.getElementsByName('itemcheckbox');
            var vals = "";
            for (var i = 0, n = checkboxes.length; i < n; i++) {
                if (checkboxes[i].checked) {
                    vals += "," + checkboxes[i].value;
                }
            }
            if (vals) vals = vals.substring(1);

            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete selected data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/media/deleteAll/${vals}`).then(res => {
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

        function checkedItem() {
            $("#delete-all").toggle($(this).find(".custom-control-input:checked").length > 0);
        }

        $(function() {
            $(".custom-checkbox").on("click", function() {
                $("#delete-all").toggle($(this).find(".custom-control-input:checked").length > 0);
            })
        });
    </script>
@endsection
