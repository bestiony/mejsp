@extends('admin.layouts.master')
@section('title', 'إنشاء حملة')

@section('content')
  <div class="links-bar my-4">
      <h4>إنشاء حملة</h4>
  </div>

  <form action="{{ route('subscribers.send.email') }}" method="post" enctype="multipart/form-data"> @csrf
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="box-white">
                <div class="form">
                    <div class="form-group">
                        <label class="required" for="logo">logo</label>
                        <input class="form-control" type="file" name="logo" >
                    </div>

                    <div class="form-group">
                        <label class="required" for="name_of_email">اسم البريد الإلكتروني</label>
                        <input class="form-control" name="name_of_email" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="subject">subject</label>
                        <input class="form-control" name="subject" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="publication_terms"> رابط شروط النشر</label>
                        <input class="form-control" name="publication_terms" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="judgement_comity">رابط لجنة التحكيم</label>
                        <input class="form-control" name="judgement_comity" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="journal_name">اسم المجلة</label>
                        <input class="form-control" name="journal_name" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_one">النص تحت اسم المجلة</label>
                        <input class="form-control" type="text" name="text_one">
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_two">ISSN</label>
                        <input class="form-control" type="text" name="text_two" >
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_three">النص تحت ISSN</label>
                        <input class="form-control" type="text" name="text_three" >
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" role="button" class="btn btn-primary">إرسال للقائمة البريدية</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
@endsection
