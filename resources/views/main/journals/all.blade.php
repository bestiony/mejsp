@extends('main.layouts.master')@section('title', 'مجلات مؤسسة الشرق الأوسط للنشر العلمي')@section('content') <header id="journals-header" class=" d-flex justify-content-center align-items-center"> <div class="container"> <div class="row justify-content-center"> <div class="col-lg-12"> <h1 class=" text-center"> المجلات </h1> </div></div></div></header> <section id="journals"> <div class="container"> <div class="row justify-content-center my-5"> <div class="col-lg-9"> <div class="row"> <div class="col-lg-12 text-center"> <div class="box-white text-center mb-3"> <form id="form-search-journal" action="" method="GET"> <span>يمكنك البحث عن مجلات @isset($_GET['name']) <a href="{{url('journals')}}" class=" text-danger"> - حذف نتائج البحث</a> @endisset </span> <input type="text" name="name" class="form-control mt-3" value="@isset($_GET['name']){{trim($_GET['name'])}}@endisset"/> <button type="submit" class="btn-search-journal"><i class="fa-solid fa-magnifying-glass"></i></button> </form> </div></div><div class="col-lg-12"> @isset($_GET['name']) <h3 class="text-center mb-0">نتائج البحث ({{$count}})</h3> @endisset </div>@foreach ($journals as $jour) <div class="col-lg-112 col-md-12 my-3"> <div class="box-white "> <div class="row"> <div class="col-lg-4 col-md-5"> @if (checkFile('assets/uploads/journals/' . $jour->cover)) <img src="{{asset('assets/uploads/journals/' . $jour->cover)}}" alt="{{$jour->name}}" title="{{$jour->name}}"> @else <img src="{{asset('assets/images/notfound.png')}}" alt="{{$jour->name}}" title="{{$jour->name}}"> @endif </div><div class="col-lg-8 col-md-7 pb-3"> <h2 class="jorunal-name mb-4" @if(strlen($jour->name) == strlen(utf8_decode($jour->name))) style="text-align:left !important" @endif><strong>{{$jour->name}}</strong></h2> <p class=" text-secondary mb-4">{{Str::limit($jour->meta_desc, 300)}}</p><a href="{{url('journal/' . $jour->slug)}}" class="btn-main">اقرأ المزيد</a> </div></div></div></div>@endforeach <div class="col-lg-12">{{$journals->links()}}</div></div></div><div class="col-lg-3"> <div class="row"> <div class="col-12 mb-4"> <x-blog/> </div><div class="col-12"> <x-services :details="$services" list="true"/> </div></div></div></div></div></section> @endsection