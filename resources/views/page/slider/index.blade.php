@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between">
                <h3>Slide</h3>
                <a href="{{ route('slider.create') }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> &nbsp;
                    Tambah Data
                </a>
            </div>
            <div class="card-body p-0">

                <div class="row px-5 pb-5" id="draggable">
                    @foreach ($list as $key => $val)
                        <div class="col-2 px-0 shadow py-0 my-2 mx-3 card drag-item" style="height: 525px;"
                            data-id="{{ $val->id }}">
                            <div class="open-new-tab d-flex justify-content-end m-2"
                                onclick="window.open('demo.getstisla.com/components-gallery.html', '_blank')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 12 12"
                                    fill="none">
                                    <path
                                        d="M2.5 1C2.10218 1 1.72064 1.15804 1.43934 1.43934C1.15804 1.72064 1 2.10218 1 2.5V9.5C1 9.89782 1.15804 10.2794 1.43934 10.5607C1.72064 10.842 2.10218 11 2.5 11H9.5C9.89782 11 10.2794 10.842 10.5607 10.5607C10.842 10.2794 11 9.89782 11 9.5V7.27C11 7.13739 11.0527 7.01021 11.1464 6.91645C11.2402 6.82268 11.3674 6.77 11.5 6.77C11.6326 6.77 11.7598 6.82268 11.8536 6.91645C11.9473 7.01021 12 7.13739 12 7.27V9.5C12 10.163 11.7366 10.7989 11.2678 11.2678C10.7989 11.7366 10.163 12 9.5 12H2.5C1.83696 12 1.20107 11.7366 0.732233 11.2678C0.263392 10.7989 0 10.163 0 9.5V2.5C0 1.83696 0.263392 1.20107 0.732233 0.732233C1.20107 0.263392 1.83696 0 2.5 0H4.73C4.86261 0 4.98979 0.0526785 5.08355 0.146447C5.17732 0.240215 5.23 0.367392 5.23 0.5C5.23 0.632608 5.17732 0.759785 5.08355 0.853553C4.98979 0.947321 4.86261 1 4.73 1H2.5ZM6.77 0.5C6.77 0.367392 6.82268 0.240215 6.91645 0.146447C7.01021 0.0526785 7.13739 0 7.27 0H11.5C11.6326 0 11.7598 0.0526785 11.8536 0.146447C11.9473 0.240215 12 0.367392 12 0.5V4.73C12 4.86261 11.9473 4.98979 11.8536 5.08355C11.7598 5.17732 11.6326 5.23 11.5 5.23C11.3674 5.23 11.2402 5.17732 11.1464 5.08355C11.0527 4.98979 11 4.86261 11 4.73V1.708L7.623 5.084C7.57688 5.13176 7.5217 5.16985 7.4607 5.19605C7.3997 5.22226 7.33409 5.23605 7.2677 5.23663C7.20131 5.2372 7.13547 5.22455 7.07402 5.19941C7.01258 5.17427 6.95675 5.13714 6.9098 5.0902C6.86286 5.04325 6.82573 4.98743 6.80059 4.92598C6.77545 4.86453 6.7628 4.79869 6.76337 4.7323C6.76395 4.66591 6.77774 4.6003 6.80395 4.5393C6.83015 4.4783 6.86825 4.42312 6.916 4.377L10.293 1H7.269C7.13639 1 7.00921 0.947321 6.91545 0.853553C6.82168 0.759785 6.769 0.632608 6.769 0.5H6.77Z"
                                        fill="#667085" />
                                </svg>
                            </div>
                            <div class="img-section rounded d-flex justify-content-center px-1">
                                <img class="rounded" src="{{ $val->link_image }}" alt="" width="100%"
                                    style="height: 280px;object-fit: cover;">
                            </div>
                            <div class="section-content px-3 pt-2"
                                style="
                        text-align: left;
                        max-height: 18rem;
                        text-overflow: ellipsis;
                        overflow: hidden;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;"">
                                <h5>{!! $val->title !!}</h5>
                            </div>
                            <div class="section-content px-3 pt-2"
                                style="
                        text-align: left;
                        max-height: 80px;
                        text-overflow: ellipsis;
                        overflow: hidden;
                        display: -webkit-box;
                        -webkit-line-clamp: 10;
                        -webkit-box-orient: vertical;">
                                {!! $val->content !!}
                            </div>

                            <div class="action-icon d-flex justify-content-end py-2 border-top col px-1"
                                style="position: absolute;bottom:0;right:0;">
                                <a href="{{ route('slider.edit', $val->id) }}">
                                    <div class="edit p-1 mx-1" style="background-color: #F9FAFB;"
                                        href="{{ route('slider.edit', $val->id) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                            viewBox="0 0 18 18" fill="none">
                                            <g clip-path="url(#clip0_596_13093)">
                                                <path
                                                    d="M2.25 13.0949V15.3749C2.25 15.5849 2.415 15.7499 2.625 15.7499H4.905C5.0025 15.7499 5.1 15.7124 5.1675 15.6374L13.3575 7.45492L10.545 4.64242L2.3625 12.8249C2.2875 12.8999 2.25 12.9899 2.25 13.0949ZM15.5325 5.27992C15.825 4.98742 15.825 4.51492 15.5325 4.22242L13.7775 2.46742C13.485 2.17492 13.0125 2.17492 12.72 2.46742L11.3475 3.83992L14.16 6.65242L15.5325 5.27992Z"
                                                    fill="#98A2B3" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_596_13093">
                                                    <rect width="18" height="18" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                </a>
                                <div class="delete p-1 mx-1" style="background-color: #F9FAFB;cursor: pointer;"
                                    onclick="hapus({{ $val->id }})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 18 18" fill="none">
                                        <g clip-path="url(#clip0_596_13101)">
                                            <path
                                                d="M4.5 14.25C4.5 15.075 5.175 15.75 6 15.75H12C12.825 15.75 13.5 15.075 13.5 14.25V6.75C13.5 5.925 12.825 5.25 12 5.25H6C5.175 5.25 4.5 5.925 4.5 6.75V14.25ZM13.5 3H11.625L11.0925 2.4675C10.9575 2.3325 10.7625 2.25 10.5675 2.25H7.4325C7.2375 2.25 7.0425 2.3325 6.9075 2.4675L6.375 3H4.5C4.0875 3 3.75 3.3375 3.75 3.75C3.75 4.1625 4.0875 4.5 4.5 4.5H13.5C13.9125 4.5 14.25 4.1625 14.25 3.75C14.25 3.3375 13.9125 3 13.5 3Z"
                                                fill="#98A2B3" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_596_13101">
                                                <rect width="18" height="18" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <style>
        .elipsis {
            max-width: 300px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            display: inline-block;
        }
    </style>

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
                    axios.delete(`/slider/delete/${id}`).then(res => {
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

        function openNewTab(url) {
            window.open(url, '_blank');
        }

        $(function() {
            $("#draggable").sortable({
                update: function(event, ui) {
                    const tempDiv = document.createElement("div");
                    const idx_dt = ui.item.index();
                    const id_dt = ui.item[0].getAttribute('data-id');

                    updatePosition(id_dt, idx_dt);
                },
                start: function(event, ui) {
                    console.log('start: ' + ui.item.index())
                }
            });
            $("#draggable").disableSelection();
        });

        function updatePosition(id, idx) {

            axios.post(`/update-position/${id}`, {
                index: idx + 1
            }).then(res => {
                console.log(res);

            }).catch(error => {
                Swal.fire('Ops..', 'There is an error.', 'error');
            });

        }
    </script>
@endsection
