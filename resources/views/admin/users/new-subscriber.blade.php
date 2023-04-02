@extends('admin.layouts.master')
@section('title', 'إضافة مشتركين')

@section('content')
  <div class="links-bar my-4">
      <h4>إضافة مشتركين</h4>
  </div>

  <form action="{{ route('add.subscribers') }}" method="post" enctype="multipart/form-data"> @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="form-group">
                    <label for="emails">اكتب بريد إلكتروني واحد في كل سطر</label>
                    <!-- <input class="form-control" name="emails" type="text"> -->
                    <textarea class="form-control" name="emails" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" role="button" class="btn btn-primary">إضافة </button>
                </div>
            </div>
        </div>
    </div>
  </form>
@endsection