@extends('admin.layouts.master')
@section('title', 'إرسال إيميل')

@section('content')
  <div class="links-bar my-4">
      <h4>إرسال إيميل</h4>
  </div>

  <form action="{{ route('subscribers.send.email') }}" method="post" enctype="multipart/form-data"> @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="logo">اللوجو</label>
                        <input class="form-control" type="file" name="logo" >
                    </div>

                    <div class="form-group col-6">
                        <label for="name_of_email">اسم الاميل</label>
                        <input class="form-control" name="name_of_email" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="subject"> subject</label>
                        <input class="form-control" name="subject" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="publication_terms"> شروط النشر</label>
                        <input class="form-control" name="publication_terms" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="judgement_comity">لجنة التحكيم</label>
                        <input class="form-control" name="judgement_comity" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="journal_name">اسم المجلة</label>
                        <input class="form-control" name="journal_name" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="text_one">النص الاول</label>
                        <input class="form-control" type="text" name="text_one">
                    </div>

                    <div class="form-group col-6">
                        <label for="text_two">النص الثاني</label>
                        <input class="form-control" type="text" name="text_two" >
                    </div>

                    <div class="form-group col-6">
                        <label for="text_three">النص الثالث</label>
                        <input class="form-control" type="text" name="text_three" >
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" role="button" class="btn btn-primary">إرسال الإيميل</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </form>
@endsection