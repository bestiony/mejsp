@extends('admin.layouts.master')
@section('title', 'تعديل الأسئلة الشائعة')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/summernote/summernote-bs4.min.css') }}" />
@endsection
@section('content')

    <div class="links-bar">
        <a href="{{ admin_url('faqs') }}">الأسئلة الشائعة</a>
        <a>تعديل الأسئلة الشائعة</a>
    </div><!-- End Bar Links -->

    <div class="row justify-content-center">

        <div class="col-lg-8">
            <div class="result"></div>
            <div class="box-white">
                <form id="form-add-service" class="form" action="{{ adminUrl('faqs/update') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="id" value="{{ $row->id }}">
                    <div class="form-group">
                        <label class="required">عنوان السؤال</label>
                        <input type="text" name="title" class="form-control" value="{{ $row->title }}" required />
                    </div><!-- End -->



                    <div class="form-group">
                        <label class="required">محتوى السؤال</label>
                        <textarea name="content" class=" form-control editor" cols="30" rows="10">{{ $row->content }}</textarea>
                    </div><!-- End -->

                    <button type="submit" class="btn-main btn-block">اضافة</button>

                </form><!-- End Form -->
            </div>
        </div><!-- End Col -->
    </div>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/summernote/summernote-bs4.min.js') }}"></script>
@endsection
