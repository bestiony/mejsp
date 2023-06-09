@extends('admin.layouts.master')
@section('title', 'إضافة مقال')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('articles') }}">المقالات</a>
        <a href="{{ admin_url('article/create') }}">إضافة مقالة</a>
    </div><!-- End Bar Links -->

    <div id="all-articles" class="row">
        
        <div class="col-12">
            <div class="result"></div>
            <form id="form-add-article" action="{{ adminUrl('article/store') }}" method="POST"
                enctype="multipart/form-data" autocomplete="off">
                @csrf
                <div class="row">

                  
                    <div class="col-lg-9">
                        <div class="box-white">

                            <div class="form-group">
                                <label class="required">الصورة</label>
                                <input type="file" name="image" accept="image/*" class="form-control" required>
                            </div><!-- image -->

                            
                            <div class="form-group">
                                <label class="required">عنوان المقالة</label>
                                <input type="text" name="title" class="form-control" required>
                            </div><!-- image -->

                            <div class="form-group">
                                <input type="checkbox" name="show_in_chat" class=""  />
                                <label>الإظهار في صفحة المحادثة</label>
                            </div><!-- End -->

                            <div class="form-group">
                                <label class=" required">محتوي المقالة</label>
                                <textarea name="content" cols="30" rows="10" class="form-control editor" required></textarea>
                            </div><!-- content -->

                            <button type="submit" class=" btn-main">نشر</button>

                        </div>
                    </div>

                    <div class="col-lg-3">
                        <div class="box-white px-0">

                            <h5 class="px-3">إعدادات الSEO للمقالة</h5>
                            <hr>
                            <div class="px-3">

                                <div class="form-group">
                                    <input type="text" name="slug" class="form-control" placeholder="رابط المقالة">
                                    @error('slug')
                                        <div class="alert-error">{{ $message }}</div>
                                    @enderror
                                </div><!-- slug -->

                                <div class="form-group mb-0">
                                    <textarea name="meta_desc" name="meta_desc" class="form-control" id="" cols="30"
                                        rows="5" placeholder="وصف المقالة"></textarea>
                                    <small class=" text-muted">وصف صغير ودقيق للمقالة</small>
                                    @error('meta_desc')
                                        <div class="alert-error">{{ $message }}</div>
                                    @enderror
                                </div><!-- meta_desc -->


                            </div>

                        </div>
                    </div><!-- END SEO BOX -->


                </div><!-- End Row -->
            </form><!-- End Form -->
        </div><!-- End Col -->
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
