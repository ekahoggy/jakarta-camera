@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Widget Donasi</h3>
            </div>
            <div class="card-body" style="padding-top: 0 !important;">
                <div class="card">
                    <div class="row px-3">
                        <div class="section-menu-left col-2 border-right px-0">
                            <div class="container-menu">
                                @foreach ($list as $key => $val)
                                    <div id="menu-{{ $key }}" data-id="{{ $val->id }}"
                                        class="list-menu d-flex justify-content-center border"
                                        onclick="getDataDetail({{ $val->id }}, {{ $key }}, {{ $val->is_status }})">
                                        <span class="my-auto">{{ $val->name }}</span>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="section-content-right col-10 border py-3">
                            <div class="title">
                                <label class="mt-2 mb-0" for="nominal"
                                    style="color: #475261; font-size: 14px; font-style: normal; font-weight: 500;">Nominal
                                    Pilihan Donasi</label>
                            </div>

                            <div class="section-nominal pb-3" id="container-list">
                                <div class="list-nominal-first d-flex justify-content-between my-1">
                                    <div class="input-group col pr-1 pl-0">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                Rp.
                                            </div>
                                        </div>
                                        <input type="text" id="tanpa_rupiah" class="form-control first-input list-nominal-input" onblur="save(this)" onkeyup="changeVal(this)">
                                    </div>

                                    <button class="btn btn-primary" onclick="addItem()" id="add_detail">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="section-publish mt-2 d-flex justify-content-between" id="publish">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .tab {
            float: left;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
            width: 30%;
            height: 300px;
        }

        /* Style the buttons inside the tab */
        .tab button {
            display: block;
            background-color: inherit;
            color: black;
            padding: 22px 16px;
            width: 100%;
            border: none;
            outline: none;
            text-align: left;
            cursor: pointer;
            transition: 0.3s;
            font-size: 17px;
        }

        /* Change background color of buttons on hover */
        .tab button:hover {
            background-color: #ddd;
        }

        /* Create an active/current "tab button" class */
        .tab button.active {
            background-color: #ccc;
        }

        /* Style the tab content */
        .tabcontent {
            float: left;
            padding: 0px 12px;
            border: 1px solid #ccc;
            width: 70%;
            border-left: none;
            height: 300px;
        }

        .list-menu {
            height: 40px;
            cursor: pointer;
        }

        .active-menu {
            background-color: #e2e2e2;
        }
    </style>

    <script>
        @if (session('success'))
            Swal.fire('Success', '{{ session('success') }}', 'success');
        @endif
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        $(document).ready(function() {
            var elementExists = document.getElementById("menu-0");
            if (elementExists) {
                $('#menu-0').click();
            }

            /* Tanpa Rupiah */
            // var tanpa_rupiah = document.getElementById('tanpa-rupiah');
            // tanpa_rupiah.addEventListener('keyup', function(e) {
            //     tanpa_rupiah.value = formatRupiah(this.value);
            // });

            /* Dengan Rupiah */
            // var dengan_rupiah = document.getElementById('dengan-rupiah');
            // dengan_rupiah.addEventListener('keyup', function(e) {
            //     dengan_rupiah.value = formatRupiah(this.value, 'Rp. ');
            // });

        });
        /* Fungsi */
        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
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
        }

        function getDataDetail(id_widget, id_el, status) {
            $('.list-menu').removeClass("active-menu");
            $('#menu-' + id_el).addClass('active-menu');
            $('.list-nominal').remove();
            $('.publish-area').remove();
            // $('#add_detail').style.display = id_widget == 1 ? 'none' : 'auto';
            document.getElementById('add_detail').style.display = id_widget == 1 ? 'none' : 'block';

            var is_checked = status == 1 ? 'checked' : '';
            var publish_el =
                '<div class="publish-area"><label for="is_Publish">Publish</label><br><label style="cursor: pointer;"><input type="checkbox" name="option" id="publish' +
                id_widget + '"class="custom-switch-input" ' + is_checked + ' onchange="updateStatus(' + id_widget +
                ')"><span class="custom-switch-indicator"></span></label></div>';
            var button_save = '<div class="mt-auto publish-area"><button class="btn btn-outline-primary mx-2">Batal</button><button class="btn btn-primary" onclick="saveAll()">Simpan</button></div>';
            $('#publish').append(publish_el);
            $('#publish').append(button_save);
            axios.get(`/widget-donation-detail/${id_widget}`).then(res => {
                    if (res.data.success) {
                        const parentEl = Array.from(document.querySelectorAll('.list-nominal-first'));
                        if (res.data.data.length == 0) {
                            parentEl.forEach(box => {
                                box.setAttribute('data-id', 0);

                            });
                            $('.first-input').val(0);
                        } else {
                            res.data.data.forEach((elm_, idx_) => {
                                if (idx_ == 0) {
                                    // $('.list-nominal-first').setAttribute('data-id', elm_.id);
                                    parentEl.forEach(box => {
                                        box.setAttribute('data-id', elm_.id);
                                    });
                                    $('#tanpa_rupiah').attr('data-id', elm_.id)
                                    $('.first-input').val(formatRupiah(elm_.nominal));
                                } else {
                                    let el = document.createElement('div');
                                    var adding_new = '<div data-id="' + elm_.id +
                                        '" class="list-nominal d-flex justify-content-between my-1"><div class="input-group col pr-1 pl-0"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input data-id="'+elm_.id+'" type="number" value="' +
                                        formatRupiah(elm_.nominal) +
                                        '" class="form-control list-nominal-input" onkeydown="focus(this)" onblur="save(this)" onkeyup="changeVal(this)"></div><button class="btn btn-danger" onclick="removeItem(this)"><i class="fa fa-trash"></i></button></div>';
                                    $(el).html(adding_new);
                                    $('#container-list').append(el);
                                }
                            });
                        }
                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    console.log(error);
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
        }

        function addItem() {
            let el = document.createElement('div');
            var adding_new =
                '<div data-id="0" class="list-nominal d-flex justify-content-between my-1"><div class="input-group col pr-1 pl-0"><div class="input-group-prepend"><div class="input-group-text">Rp.</div></div><input data-id="0" type="number" class="form-control list-nominal-input" onblur="save(this)" onkeyup="changeVal(this)"></div><button class="btn btn-danger" onclick="removeItem(this)"><i class="fa fa-trash"></i></button></div>';
            $(el).html(adding_new);
            $('#container-list').append(el);
        }

        function removeItem(e) {
            var id = $(e).parent()[0].getAttribute('data-id');
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this data?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/widget-donation-detail/delete/${id}`).then(res => {
                            if (res.data.success) {
                                Swal.fire('Success', 'Deleted successfully', 'success').then(() => {
                                    // location.reload();
                                    $(e).parent().remove();
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

        function save(e) {
            const active_menu = Array.from(document.querySelectorAll('.active-menu'));
            var value = $(e).val();
            var id = $(e).parent().parent()[0].getAttribute('data-id');
            var widget_id = active_menu[0].getAttribute('data-id');
            var regex = /[.,\s]/g;

            const payload = {
                id: id,
                widget_id: widget_id,
                nominal: value.replace(regex, '')
            };
            var url = id == 0 ? `/widget-donation-detail/store` : `/widget-donation-detail/update/${id}`;

            axios.post(url, payload).then(res => {
                if (id == 0) {
                    $(e).parent().parent()[0].setAttribute('data-id', res.data.data.id);
                    $(e).attr('data-id', res.data.data.id);
                }
            }).catch(error => {
                console.log(error);
                Swal.fire('Ops..', 'There is an error.', 'error');
            });
        }

        function updateStatus(id) {
            var checked = $('#publish' + id).is(":checked");

            axios.post(`/widget-donation/updateStatus/${id}`, {
                    is_status: checked ? 1 : 0
                }).then(res => {
                    if (res.data.success) {

                    } else {
                        Swal.fire('Ops..', 'There is an error.', 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Ops..', 'There is an error.', 'error');
                });
        }

        function saveAll(){
            // const list_input = document.querySelectorAll('.list-nominal-input');
            // list_input.forEach(elm_ => {
            //     console.log($(elm_).val(), $(elm_).attr('data-id'));
            // });
            // console.log(list_input);
            Swal.fire('Success', 'Data berhasil disimpan', 'success')
        }

        function changeVal(e){
            const val = $(e).val();
            const updateVal = formatRupiah(val);
            $(e).val(updateVal);
        }
    </script>
@endsection
