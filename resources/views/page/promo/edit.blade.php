@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Faq</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/faq">Faq</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('faq.update', $model->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <div class="form-group">
                                <label class="custom-switch" style="cursor: pointer">
                                    IDN &nbsp;&nbsp;
                                    <input type="checkbox" name="language" id="language" class="custom-switch-input"
                                        onchange="switchLang()">
                                    <span class="custom-switch-indicator"></span>
                                    &nbsp;&nbsp;
                                    EN
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 bhs-indonesia">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input class="form-control form-control-sm" id="title" name="title"
                                    value="{{ $model->title }}" rows="5" placeholder="Masukkan Title" required>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-english hidden">
                            <div class="form-group">
                                <label for="title">Title EN</label>
                                <input class="form-control form-control-sm" id="title_en" name="title_en"
                                    value="{{ $model->title_en }}" rows="5" placeholder="Masukkan Title" required>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-indonesia">
                            <div class="form-group">
                                <label>Content</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="content">{{ $model->content }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 bhs-english hidden">
                            <div class="form-group">
                                <label>Content EN</label>
                                <div class="col-sm-12 p-0">
                                    <textarea class="summernote" name="content_en">{{ $model->content_en }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('faq.index') }}" class="btn btn-sm btn-light mr-2">
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

    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        function switchLang() {
            const lang = document.getElementById('language').checked;
            var eng = document.querySelectorAll(".bhs-english");
            var indo = document.querySelectorAll(".bhs-indonesia");
            if (lang === true) {
                eng.forEach((element) => {
                    element.classList.remove('hidden');
                });
                indo.forEach((element) => {
                    element.classList.add('hidden');
                });
            }
            else{
                eng.forEach((element) => {
                    element.classList.add('hidden');
                });
                indo.forEach((element) => {
                    element.classList.remove('hidden');
                });
            }
        }
    </script>
@endsection
