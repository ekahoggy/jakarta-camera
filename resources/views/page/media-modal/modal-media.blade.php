<div class="card">
    <div class="card-body">
        <div class="section-action d-flex justify-content-between">
            <button class="btn btn-warning" style="cursor: pointer;" onclick="document.getElementById('image-input-modal').click()">Upload File Local</button>
            <input type="file" name="file" id="image-input-modal" accept="image/*" onchange="saveImg(event)" class="hidden" />

            <div class="col-4">
                <div class="search-section d-flex">
                    <div class="input-group col px-0">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control" placeholder="cari" id="seacrh_media">
                    </div>
                </div>
            </div>
        </div>

        <div class="list-img mt-2">
            <div class="row" id=list-image></div>
            <div class="paginate mt-4 d-flex justify-content-end" id="section-img"></div>
        </div>

    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        getImg();
    });

    function getImg(page=1, search='') {
        axios.get(`/get-item-img`, {
            params: {
                page: page,
                search: search
            }
        }).then(res => {
            if (res.data.success) {
                var html = '';
                res.data.data.data.forEach((elm, idx) => {

                    html +=' <div class="col-3 mt-2"><img class="imgPersonal" style="cursor: pointer;height: 187.5px;object-fit: cover;" src="'+elm.link_image+'" width="100%" style="max-height: 187px;object-fit: cover;" alt="" loading="lazy"></div>';
                });

                var paginate = '<nav> <ul class="pagination">';
                res.data.data.links.forEach((element,idx) => {
                    paginate += '<li style="cursor: pointer;" class="page-item'+ (element.active ? 'active' : '')+'" onclick="getImg('+(idx == 0 ? page - 1 : idx == (res.data.data.links.length - 1) ? page + 1 : element.label )+')"><span class="page-link" aria-label="'+element.label+'">'+ (idx == 0 ? '&laquo;' : idx == (res.data.data.links.length - 1) ? '&raquo;' : element.label) +'</span></li>';
                });
                paginate += '</ul> </nav>';

                $('#list-image').html(html);
                $('#section-img').html(paginate);
            } else {
                Swal.fire('Ops..', 'There is an error.', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Ops..', 'There is an error.', 'error');
        });
    }

    function saveImg() {
        var file = document.getElementById('image-input-modal');

        var formData = new FormData();
        formData.append("file", file.files[0]);

        axios.post(`/save-item-img`, formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(res => {
            if (res.data.success) {
                Swal.fire('success', 'image has been upload.', 'success');
                getImg(1);
            } else {
                Swal.fire('Ops..', 'There is an error.', 'error');
            }
        })
        .catch(error => {
            Swal.fire('Ops..', 'There is an error.', 'error');
        });
    }

    var typingTimer;                //timer identifier
    var doneTypingInterval = 500;  //time in ms, 5 seconds for example
    var $input = $('#seacrh_media');

    //on keyup, start the countdown
    $input.on('keyup', function () {
        clearTimeout(typingTimer);
        // $('#')
        typingTimer = setTimeout(search, doneTypingInterval);
    });

    //on keydown, clear the countdown
    $input.on('keydown', function () {
        clearTimeout(typingTimer);
    });

    function search(){
        getImg(1, $input.val());
    }

</script>
