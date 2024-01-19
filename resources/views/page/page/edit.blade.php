@extends('layout.main')

@section('content')
    <div class="section-body">
        <div class="card">
            <div class="card-header justify-content-between d-flex">
                <h3>Edit Page</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/page">Page</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('page.update', $model->id) }}" enctype="multipart/form-data">
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
                    <input type="hidden" id="hidden-to" value="{{ $model->to }}">
                    <div class="row">
                        <div class="col-8">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tampil di</label>
                                        <select class="form-control select2 select2-hidden-accessible" tabindex="-1"
                                            aria-hidden="true" style="width: 200px !important;" id="to"
                                            name="to" disabled>
                                            <option value="1" @if ($model->to == 1) selected @endif>
                                                Ringkasan</option>
                                            <option value="2" @if ($model->to == 2) selected @endif>
                                                Gallery</option>
                                            <option value="4" @if ($model->to == 4) selected @endif>FAQ
                                            </option>
                                            <option value="5" @if ($model->to == 5) selected @endif>Sponsor
                                                Anak
                                            </option>
                                            <option value="6" @if ($model->to == 6) selected @endif>Donasi
                                                Sekali
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            @if ($model->to == 1)
                            <!-- ringkasan -->
                            <div class="row page-ringkasan">
                                <div class="col-md-12 page-judul bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title">Judul Section 1</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ $model->title }}" rows="5" placeholder="Masukkan Judul"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 page-judul-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="title_en">Title Section 1</label>
                                        <input class="form-control form-control-sm" id="title_en" name="title_en"
                                            value="{{ $model->title_en }}" rows="5"
                                            placeholder="Input Title Section 1">
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-short bhs-indonesia">
                                    <div class="form-group">
                                        <label for="short_content">Content Section 1</label>
                                        <textarea class="summernote" name="short_content">{{ $model->short_content }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-short-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="short_content">Content Section 1 EN</label>
                                        <textarea class="summernote" name="short_content_en">{{ $model->short_content_en }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 page-deskripsi bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title">Judul Section 2</label>
                                        <input class="form-control form-control-sm" id="short_description"
                                            name="short_description" value="{{ $model->short_description }}" rows="5"
                                            placeholder="Masukkan judul">
                                    </div>
                                </div>
                                <div class="col-md-12 page-deskripsi bhs-english hidden">
                                    <div class="form-group">
                                        <label for="title">Title Section 2</label>
                                        <input class="form-control form-control-sm" id="short_description_en"
                                            name="short_description_en" value="{{ $model->short_description_en }}"
                                            rows="5" placeholder="Input Title Section 2">
                                    </div>
                                </div>
                                <div class="col-md-12 page-content bhs-indonesia">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content Section 2</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content">{{ $model->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-en bhs-english hidden">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content Section 2 EN</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content_en"{{ $model->content_en }}></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 page-youtube">
                                    <div class="form-group">
                                        <label for="link_youtube">Link Youtube</label>
                                        <input class="form-control form-control-sm" id="link_youtube" name="link_youtube"
                                            value="{{ $model->link_youtube }}" rows="5"
                                            placeholder="Masukkan Link Youtube">
                                    </div>
                                </div>

                            </div>
                            @elseif ($model->to == 2)
                            <!-- galeri -->
                            <div class="row page-galeri">
                                <div class="col-md-12 page-gambar">
                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        @if ($model->to == 2)
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="drop-zone  @if (count($model->galeri) > 0) hidden @endif"
                                                        id="drop-zone" data-target="#exampleModal" data-toggle="modal">
                                                        <div class="drop-zone-text">
                                                            <i class="fas fa-cloud-upload-alt"></i>
                                                            <p>Drag and drop your image here</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row px-4 col-12">
                                                    <div class="section-image row pl-3" id="section-image">
                                                        @foreach ($model->galeri as $key => $val_galeri)
                                                            <div id="image-preview-{{ $key }}"
                                                                class="image-preview-container m-1 bg-light text-center rounded p-2 col-2 d-flex"
                                                                style="max-width: 124px;">
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][id]"id="image-id-{{ $key }}"
                                                                    value="{{ $val_galeri->id }}" class="hidden" />
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][link]"id="image-input-{{ $key }}"
                                                                    value="{{ $val_galeri->photo }}" class="hidden" />
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][title]"
                                                                    id="image-title-{{ $key }}"
                                                                    value="{{ $val_galeri->title }}" class="hidden" />
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][title_en]"
                                                                    id="image-title-en-{{ $key }}"
                                                                    value="{{ $val_galeri->title_en }}" class="hidden" />
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][content]"
                                                                    id="image-content-{{ $key }}"
                                                                    value="{{ $val_galeri->content }}" class="hidden" />
                                                                <input type="text"
                                                                    name="picture[{{ $key }}][content_en]"
                                                                    id="image-content-en-{{ $key }}"
                                                                    value="{{ $val_galeri->content_en }}"
                                                                    class="hidden" />
                                                                <img id="preview-image-{{ $key }}"
                                                                    src="{{ $val_galeri->photo }}"
                                                                    class="image-thumbnail" height="108.43px"
                                                                    style="width: 108.43px !important;height: 108.43px !important;object-fit: cover;width: 100%;"
                                                                    onclick="openModalImg({{ $key }})"
                                                                    loading="lazy" />
                                                                <a class="remove-image mr-2" href="#"
                                                                    onclick="hapusElement({{ $key }}, {{ $val_galeri->id }});"
                                                                    style="display: inline;">
                                                                    <svg style="width: 30px; height: 30px;"
                                                                        onclick="hapusElement({{ $key }}, {{ $val_galeri->id }});"
                                                                        width="44" height="44" viewBox="0 0 44 44"
                                                                        fill="none" class="delete-icon"
                                                                        xmlns="http://www.w3.org/2000/svg">
                                                                        <rect width="44" height="44"
                                                                            fill="#F04438" />
                                                                        <path
                                                                            d="M16 29C16 30.1 16.9 31 18 31H26C27.1 31 28 30.1 28 29V19C28 17.9 27.1 17 26 17H18C16.9 17 16 17.9 16 19V29ZM28 14H25.5L24.79 13.29C24.61 13.11 24.35 13 24.09 13H19.91C19.65 13 19.39 13.11 19.21 13.29L18.5 14H16C15.45 14 15 14.45 15 15C15 15.55 15.45 16 16 16H28C28.55 16 29 15.55 29 15C29 14.45 28.55 14 28 14Z"
                                                                            fill="white" />
                                                                    </svg>
                                                                </a>
                                                                <a class="mr-2 d-flex delete-icon" href="#"
                                                                    onclick="openDetailImage({{ $key }})"
                                                                    style="display: inline;position:absolute;background-color: #F04438;width: 30px; height: 30px;">
                                                                    <i class="fa fa-pencil-alt m-auto"
                                                                        style="color: white;"></i>
                                                                </a>
                                                            </div>
                                                        @endforeach
                                                        <div id="btn-add-img"
                                                            class="bg-light text-center rounded p-2 col-2 m-1"
                                                            data-target="#exampleModal" data-toggle="modal"
                                                            style="width: 124px;height: 124px;max-width: 124px !important;"
                                                            onclick="addSlotImage()">
                                                            <div class="add my-3" style="width: 108px;">
                                                                <i class="fa fa-plus my-auto" style="font-size: 50px"></i>
                                                                <div style="text-align: center;" class="my-auto">add image
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="drop-zone @if ($model->picture != null) hidden @endif"
                                                        id="drop-zone" {{--
                                                    onclick="document.getElementById('image-input').click()" --}} data-target="#exampleModal"
                                                        data-toggle="modal">
                                                        <div class="drop-zone-text">
                                                            <i class="fas fa-cloud-upload-alt"></i>
                                                            <p>Drag and drop your image here</p>
                                                        </div>
                                                        {{-- <input type="file" name="picture" id="image-input" accept="image/*"
                                                        onchange="showPreview(event)" class="hidden" /> --}}
                                                        <input type="text" name="picture" id="image-input"
                                                            class="hidden" />
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-center">
                                                    <div id="image-preview"
                                                        class="@if ($model->picture == null) hidden @endif bg-light text-center rounded p-2"
                                                        {{--
                                                    onclick="document.getElementById('image-input').click()" --}} data-target="#exampleModal"
                                                        data-toggle="modal">
                                                        <img id="preview-image" class="image-thumbnail"
                                                            src="{{ 'https://s3.' . env('AWS_DEFAULT_REGION') . '.amazonaws.com/' . env('AWS_BUCKET') . '/' . $model->picture }}"
                                                            loading="lazy" />
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 page-judul bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title" class="umum">Judul</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ $model->title }}" rows="5" placeholder="Masukkan Judul"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 page-judul-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="title_en">Title</label>
                                        <input class="form-control form-control-sm" id="title_en" name="title_en"
                                            value="{{ $model->title_en }}" rows="5" placeholder="Input Title">
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-short bhs-indonesia">
                                    <div class="form-group">
                                        <label for="content">Content Short</label>
                                        <textarea class="summernote" name="content">{{ $model->content }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-short-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="content">Content Short EN</label>
                                        <textarea class="summernote" name="content_en">{{ $model->content_en }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @elseif ($model->to == 4)
                            <!-- faq -->
                            <div class="row page-faq">
                                <div class="col-md-12 page-judul bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title">Judul</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ $model->title }}" rows="5" placeholder="Masukkan Judul"
                                            required>
                                    </div>
                                </div>
                                <div class="col-md-12 page-judul-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="title_en">Title</label>
                                        <input class="form-control form-control-sm" id="title_en" name="title_en"
                                            value="{{ $model->title_en }}" rows="5" placeholder="Input Title">
                                    </div>
                                </div>
                                <div class="col-md-12 page-content bhs-indonesia">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content">{{ $model->content }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-en bhs-english hidden">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content EN</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content_en">{{ $model->content_en }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 page-email">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input class="form-control form-control-sm" id="email" name="email"
                                            value="{{ $model->email }}" rows="5" placeholder="Masukkan Email">
                                    </div>
                                </div>
                                <div class="col-md-12 page-telepon">
                                    <div class="form-group">
                                        <label for="phone_number">Nomor Telepon</label>
                                        <input class="form-control form-control-sm" id="phone_number" name="phone_number"
                                            value="{{ $model->phone_number }}" rows="5"
                                            placeholder="Masukkan Nomor Telepone">
                                    </div>
                                </div>
                            </div>
                            @elseif ($model->to == 5 || $model->to == 6)
                            <div class="row page-sponsor ">
                                <div class="col-md-12 page-gambar">
                                    <div class="form-group">
                                        <label for="image">Gambar</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="drop-zone @if($model->picture != null) hidden @endif" id="drop-zone" {{-- onclick="document.getElementById('image-input').click()" --}}
                                                    data-target="#exampleModal" data-toggle="modal">
                                                    <div class="drop-zone-text">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <p>Drag and drop your image here</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row px-4 col-12">
                                                <div class="section-image row pl-3" id="section-image">
                                                    <div id="image-preview-0" class="image-preview-container m-1 bg-light text-center rounded p-2 col-2 d-flex @if($model->picture == null) hidden @endif" style="max-width: 124px;">
                                                        <input type="text" name="photo" id="image-input-0" value="{{$model->picture}}" class="hidden" />
                                                        {{-- <input type="text" name="picture[0][title]" id="image-title-0" class="hidden" />
                                                        <input type="text" name="picture[0][content]" id="image-content-0" class="hidden" />
                                                        <input type="text" name="picture[0][title_en]" id="image-title-en-0" class="hidden" />
                                                        <input type="text" name="picture[0][content_en]" id="image-content-en-0" class="hidden" /> --}}
                                                        <img id="preview-image-0" src="{{$model->picture}}" class="image-thumbnail" height="108.43px" style="width: 108.43px !important;height: 108.43px !important;object-fit: cover;width: 100%;" onclick="openModalImg(0)" loading="lazy"/>
                                                        <a class="remove-image mr-2" href="#" onclick="hapusElement(0);"
                                                            style="display: inline;">
                                                            <svg style="width: 30px; height: 30px;" onclick="hapusElement(0);"
                                                                width="44" height="44" viewBox="0 0 44 44" fill="none"
                                                                class="delete-icon" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="44" height="44" fill="#F04438" />
                                                                <path
                                                                    d="M16 29C16 30.1 16.9 31 18 31H26C27.1 31 28 30.1 28 29V19C28 17.9 27.1 17 26 17H18C16.9 17 16 17.9 16 19V29ZM28 14H25.5L24.79 13.29C24.61 13.11 24.35 13 24.09 13H19.91C19.65 13 19.39 13.11 19.21 13.29L18.5 14H16C15.45 14 15 14.45 15 15C15 15.55 15.45 16 16 16H28C28.55 16 29 15.55 29 15C29 14.45 28.55 14 28 14Z"
                                                                    fill="white" />
                                                            </svg>
                                                        </a>
                                                        {{-- <a class="mr-2 d-flex delete-icon" href="#"
                                                            onclick="openDetailImage(0)"
                                                            style="display: inline;position:absolute;background-color: #F04438;width: 30px; height: 30px;">
                                                            <i class="fa fa-pencil-alt m-auto" style="color: white;"></i>
                                                        </a> --}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 page-judul bhs-indonesia">
                                    <div class="form-group">
                                        <label for="title">Judul</label>
                                        <input class="form-control form-control-sm" id="title" name="title"
                                            value="{{ $model->title }}" rows="5" placeholder="Masukkan Judul">
                                    </div>
                                </div>
                                <div class="col-md-12 page-judul-en bhs-english hidden">
                                    <div class="form-group">
                                        <label for="title_en">Title</label>
                                        <input class="form-control form-control-sm" id="title_en" name="title_en"
                                            value="{{ $model->title_en }}" rows="5" placeholder="Input Title">
                                    </div>
                                </div>
                                <!--

                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label for="image">Picture</label>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="drop-zone" id="drop-zone" {{-- onclick="document.getElementById('image-input').click()" --}}
                                                    data-target="#exampleModal" data-toggle="modal" style="max-width: 350px !important;">
                                                    <div class="drop-zone-text">
                                                        <i class="fas fa-cloud-upload-alt"></i>
                                                        <p>Drag and drop your image here</p>
                                                    </div>
                                                    <input type="text" name="photo" id="image-input" class="hidden" />
                                                </div>
                                            </div>
                                            <div class="col-md-12 text-center">
                                                <div id="image-preview-sponsor" class="hidden bg-light text-center rounded p-2" data-target="#exampleModal" data-toggle="modal">
                                                    <img id="preview-image-sponsor" class="image-thumbnail" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="col-md-12 page-content bhs-indonesia">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content">{{$model->content}} </textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 page-content-en bhs-english hidden">
                                    <div class="form-group">
                                        <div class="d-flex justify-content-between mb-2">
                                            <label class="my-auto">Content EN</label>
                                        </div>
                                        <div class="col-sm-12 p-0">
                                            <textarea class="summernote" name="content_en">{{$model->content_en}} </textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif



                        </div>
                        <div class="col-4">
                            <div class="row">
                                <div class="wrapper center-block">
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                        <div class="panel panel-default" style="padding: 25px;">
                                            <div class="panel-heading active" role="tab" id="headingOne">
                                                <h4 class="panel-title">
                                                    <a role="button" data-toggle="collapse" data-parent="#accordion"
                                                        href="#collapseOne" aria-expanded="true"
                                                        aria-controls="collapseOne">
                                                        Status
                                                    </a>
                                                </h4>
                                            </div>
                                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                                                aria-labelledby="headingOne">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="title">Publish At</label>
                                                                <input type="datetime-local"
                                                                    class="form-control form-control-sm" name="publish_at"
                                                                    id="publish_at" value="{{ $model->publish_at }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row pt-2">
                                                        <div class="col-12">
                                                            <div class="form-group">
                                                                <label for="is_status">Status</label>
                                                                <select
                                                                    class="form-control select2 select2-hidden-accessible"
                                                                    tabindex="-1" aria-hidden="true"
                                                                    style="width: 200px !important;" id="is_status"
                                                                    name="is_status">
                                                                    <option value="2"
                                                                        @if ($model->is_status == 2) selected @endif>
                                                                        Publish</option>
                                                                    <option value="0"
                                                                        @if ($model->is_status == 0) selected @endif>
                                                                        Draft</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-end">
                        <a href="{{ route('page.index') }}" class="btn btn-sm btn-light mr-2">
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


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-0">
                    @include('page.media-modal.modal-media')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImage" tabindex="-1" role="dialog" aria-labelledby="modalImageLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-right">
                            <div class="form-group">
                                <label class="custom-switch" style="cursor: pointer">
                                    IDN &nbsp;&nbsp;
                                    <input type="checkbox" name="language-galeri" id="language-galeri"
                                        class="custom-switch-input" onchange="switchLangGaleri()">
                                    <span class="custom-switch-indicator"></span>
                                    &nbsp;&nbsp;
                                    EN
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group bhs-indo">
                        <label for="title_image">Judul</label>
                        <input type="text" name="title_image" id="title_image" class="form-control form-control-sm">

                    </div>
                    <div class="form-group bhs-eng hidden">
                        <label for="title_image_en">Title</label>
                        <input type="text" name="title_image_en" id="title_image_en"
                            class="form-control form-control-sm">

                    </div>
                    <div class="form-group bhs-indo">
                        <label for="content_image">Content</label>
                        <div class="col-sm-12 p-0">
                            <textarea class="summernote" id="content_image" name="content_image"></textarea>
                        </div>
                    </div>
                    <div class="form-group bhs-eng hidden">
                        <label for="content_image_en">Content EN</label>
                        <div class="col-sm-12 p-0">
                            <textarea class="summernote" id="content_image_en" name="content_image_en"></textarea>
                        </div>
                    </div>
                    <div class="button-group" style="float: right">
                        <button class="btn btn-outline-primary btn-sm mr-1" data-dismiss="modal">Batal</button>
                        <button class="btn btn-primary btn-sm" onclick="setValueImage()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .wrapper {
            width: 100%;
            border: 0.5px solid #EAECF0;
        }

        /* .panel-default {
                                padding: 25px;
                            } */

        .panel-heading {
            padding: 0;
            border: 0;
        }

        .panel-title>a,
        .panel-title>a:active {
            display: block;
            color: #555;
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            word-spacing: 3px;
            text-decoration: none;
        }

        .panel-heading a:before {
            font-family: 'Glyphicons Halflings';
            /* content: "\e114"; */
            content: ">";
            float: right;
            transition: all 0.5s;
        }

        .panel-heading.active a:before {
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            transform: rotate(180deg);
        }

        .bootstrap-tagsinput {
            display: block;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

    <script>
        @if (session('error'))
            Swal.fire('Oopss', '{{ session('error') }}', 'error');
        @endif

        // var hid = document.getElementById("hidden-to").value;
        // var pageRingkasan = document.querySelector(".page-ringkasan");
        // var pageGaleri = document.querySelector(".page-galeri");
        // var pageFaq = document.querySelector(".page-faq");

        // if (hid == '1') {
        //     pageGaleri.remove();
        //     pageFaq.remove();
        // } else if (hid == '2') {
        //     pageRingkasan.remove();
        //     pageFaq.remove();
        // } else if (hid == '4') {
        //     pageGaleri.remove();
        //     pageRingkasan.remove();
        // }

        function switchLang() {
            const lang = document.getElementById('language').checked;
            const to = document.getElementById('to').value;

            var eng = document.querySelectorAll(".bhs-english");
            var indo = document.querySelectorAll(".bhs-indonesia");
            if (lang === true) {
                eng.forEach((element) => {
                    element.classList.remove('hidden');
                });
                indo.forEach((element) => {
                    element.classList.add('hidden');
                });
            } else {
                eng.forEach((element) => {
                    element.classList.add('hidden');
                });
                indo.forEach((element) => {
                    element.classList.remove('hidden');
                });
            }
        }

        function switchLangGaleri() {
            const lang = document.getElementById('language-galeri').checked;

            var eng = document.querySelectorAll(".bhs-eng");
            var indo = document.querySelectorAll(".bhs-indo");
            if (lang === true) {
                eng.forEach((element) => {
                    element.classList.remove('hidden');
                });
                indo.forEach((element) => {
                    element.classList.add('hidden');
                });
            } else {
                eng.forEach((element) => {
                    element.classList.add('hidden');
                });
                indo.forEach((element) => {
                    element.classList.remove('hidden');
                });
            }
        }

        function showPreview(event) {
            const input = event.target;
            const previewContainer = document.getElementById('image-preview');
            const previewImage = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById("drop-zone").style.display = 'none';
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }

                reader.readAsDataURL(input.files[0]);
            } else {
                previewImage.src = '';
                document.getElementById("drop-zone").style.display = 'block';
                previewContainer.classList.add('hidden');
            }
        }

        // for single image
        // $(document).on('click', '.imgPersonal', function() {
        //     const input = event.target;
        //     const previewContainer = document.getElementById('image-preview');
        //     const previewImage = document.getElementById('preview-image');

        //     let imgSrc = $(this).attr('src');

        //     document.getElementById("drop-zone").style.display = 'none';
        //     $('#image-input').val(imgSrc)
        //     previewImage.src = imgSrc; //e.target.result;
        //     previewContainer.classList.remove('hidden');
        //     $('#exampleModal').modal('hide');
        // });
        // end single image

        // just for single image not for multiple

        // $(document).on('click', '.imgPersonal', function() {
        //     const input = event.target;
        //     const previewContainer = document.getElementById('image-preview');
        //     const previewImage = document.getElementById('preview-image');

        //     let imgSrc = $(this).attr('src');

        //     document.getElementById("drop-zone").style.display = 'none';
        //     $('#image-input').val(imgSrc)
        //     previewImage.src = imgSrc; //e.target.result;
        //     previewContainer.classList.remove('hidden');
        //     $('#exampleModal').modal('hide');
        // });

        // end single image

        function changeTags(event) {
            var $element = $(event.target);
            var $container = $element.closest('.example');

            if (!$element.data('tagsinput')) return;

            var val = $element.val();
            if (val === null) val = 'null';
            var items = $element.tagsinput('items');

            $('code', $('pre.val', $container)).html(
                $.isArray(val) ?
                JSON.stringify(val) :
                '"' + val.replace('"', '\\"') + '"'
            );
            $('code', $('pre.items', $container)).html(
                JSON.stringify($element.tagsinput('items'))
            );
        }

        $(document).ready(function() {
            $('#exampleModal').appendTo("body");
            $('#modalImage').appendTo("body");
        });

        $(document).on('click', '.imgPersonal', function() {

            if (its_new) {
                $('#section-image').append(template_preview);
            }

            const input = event.target;
            const previewContainer = document.getElementById('image-preview-' + selected_preview);
            const previewImage = document.getElementById('preview-image-' + selected_preview);
            const btnImg = document.getElementById('btn-add-img');


            let imgSrc = $(this).attr('src');

            document.getElementById("drop-zone").style.display = 'none';
            $('#image-input-' + selected_preview).val(imgSrc)
            previewImage.src = imgSrc; //e.target.result;
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('d-flex');
            $('#btn-add-img').remove();

            if ($('#to').val() != 5 && $('#to').val() != 6) {
                $('#section-image').append(btn_add_img);
            }

            $('#exampleModal').modal('hide');
        });

        var selected_preview = 0;
        var its_new = false;
        var template_preview = "";
        var btn_add_img =
            '<div id="btn-add-img" class="bg-light text-center rounded p-2 col-2 m-1" data-target="#exampleModal" data-toggle="modal" style="width: 124px;height: 124px;max-width: 124px !important;"onclick="addSlotImage()">';
        btn_add_img += '<div class="add my-3" style="width: 108px;">';
        btn_add_img += '<i class="fa fa-plus my-auto" style="font-size: 50px"></i>';
        btn_add_img += '<div style="text-align: center;" class="my-auto">add image</div></div></div>';

        function hapusElement(idElmt, id) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to delete this image?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {

                    if (id == undefined) {

                        const previewContainer = document.getElementById('image-preview-0');
                        const previewImage = document.getElementById('preview-image-0');
                        previewImage.src = ''; //e.target.result;
                        previewContainer.classList.add('hidden');
                        previewContainer.classList.remove('d-flex');
                        document.getElementById("drop-zone").style.display = 'block';

                    }else{
                        axios.delete(`/page/deleteDetail/${id}`).then(res => {
                            if (res.data.success) {
                                Swal.fire('Success', 'Deleted successfully', 'success').then(() => {});
                            } else {
                                Swal.fire('Ops..', 'There is an error.', 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Ops..', 'There is an error.', 'error');
                        });

                        $('#image-preview-' + idElmt).remove();
                    }

                }
            });
        }


        function openModalImg(idx) {
            its_new = false;
            selected_preview = idx;
            $('#exampleModal').modal('toggle');
        }

        function addSlotImage() {
            its_new = true;
            selected_preview = document.querySelectorAll('.image-preview-container').length;

            template_preview = '<div id="image-preview-' + selected_preview +
                '" class="image-preview-container m-1 hidden bg-light text-center rounded p-2 col-2" style="max-width: 124px;">';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][id]" id="image-id-' +
                selected_preview + '" value="0" class="hidden" />';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][link]" id="image-input-' +
                selected_preview + '" class="hidden" />';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][title]" id="image-title-' +
                selected_preview + '" class="hidden" />';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][title_en]" id="image-title-en-' +
                selected_preview + '" class="hidden" />';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][content]" id="image-content-' +
                selected_preview + '" class="hidden" />';
            template_preview += '<input type="text" name="picture[' + selected_preview + '][content_en]" id="image-content_en-' +
                selected_preview + '" class="hidden" />';
            template_preview += '<img id="preview-image-' + selected_preview +
                '" loading="lazy" class="image-thumbnail" height="108.43px" style="width: 108.43px !important;height: 108.43px !important;object-fit: cover;width: 100%;" onclick="openModalImg(' +
                selected_preview + ')"/>';
            template_preview += '<a class="remove-image mr-2" href="#" onclick="hapusElement(' + selected_preview +
                ');" style="display: inline;">';
            template_preview += '<svg style="width: 30px; height: 30px;" onclick="hapusElement(' + selected_preview +
                ');" width="44" height="44" viewBox="0 0 44 44" fill="none" class="delete-icon" xmlns="http://www.w3.org/2000/svg">';
            template_preview += '<rect width="44" height="44" fill="#F04438" />';
            template_preview +=
                '<path d="M16 29C16 30.1 16.9 31 18 31H26C27.1 31 28 30.1 28 29V19C28 17.9 27.1 17 26 17H18C16.9 17 16 17.9 16 19V29ZM28 14H25.5L24.79 13.29C24.61 13.11 24.35 13 24.09 13H19.91C19.65 13 19.39 13.11 19.21 13.29L18.5 14H16C15.45 14 15 14.45 15 15C15 15.55 15.45 16 16 16H28C28.55 16 29 15.55 29 15C29 14.45 28.55 14 28 14Z" fill="white" />';
            template_preview += '</svg></a>';
            // template_preview += ' <a class="mr-2" href="#" onclick="openDetailImage(' + selected_preview + ')" style="display: inline;position:absolute">';
            // template_preview += '<svg style="width: 30px; height: 30px;" width="44" height="44" viewBox="0 0 44 44" fill="none" class="delete-icon" xmlns="http://www.w3.org/2000/svg">';
                // template_preview += '<rect width="44" height="44" fill="#F04438" />';
                // template_preview += '<path d="M16 29C16 30.1 16.9 31 18 31H26C27.1 31 28 30.1 28 29V19C28 17.9 27.1 17 26 17H18C16.9 17 16 17.9 16 19V29ZM28 14H25.5L24.79 13.29C24.61 13.11 24.35 13 24.09 13H19.91C19.65 13 19.39 13.11 19.21 13.29L18.5 14H16C15.45 14 15 14.45 15 15C15 15.55 15.45 16 16 16H28C28.55 16 29 15.55 29 15C29 14.45 28.55 14 28 14Z" fill="white" />';
            template_preview += ' <a class="mr-2 d-flex delete-icon" href="#" onclick="openDetailImage((' + selected_preview + '))" style="display: inline;position:absolute;background-color: #F04438;width: 30px; height: 30px;">';
            template_preview += ' <i class="fa fa-pencil-alt m-auto" style="color: white;"></i></a>';
            template_preview += '</div>';
        }

        var selectedImageDetail = 0;

        function openDetailImage(idx) {
            selectedImageDetail = idx;
            $('#title_image').val($('#image-title-' + selectedImageDetail).val());
            $('#title_image_en').val($('#image-title-en-' + selectedImageDetail).val());
            var template = $('#image-content-' + selectedImageDetail).val();
            var template_en = $('#image-content-en-' + selectedImageDetail).val();
            $('#content_image').summernote('code', template);
            $('#content_image_en').summernote('code', template_en);
            $('#modalImage').modal('toggle');
        }


        function setValueImage() {
            var title = $('#title_image').val();
            var title_en = $('#title_image_en').val();
            var content = $('#content_image').summernote('code');
            var content_en = $('#content_image_en').summernote('code');

            $('#image-title-' + selectedImageDetail).val(title);
            $('#image-title-en-' + selectedImageDetail).val(title_en);
            $('#image-content-' + selectedImageDetail).val(content);
            $('#image-content-en-' + selectedImageDetail).val(content_en);
            $('#modalImage').modal('hide');
        }
    </script>
@endsection
