@php $journal=''; @endphp @extends('main.layouts.master')@section('title', 'تعليمات المؤلفين - ' . $row->name)@section('content') @include('main.journals.header') <section id="ethics"> <div class="container py-5 "> <div class="row"> <div class="col-xl-3 col-lg-12"> <div class="row"> <div class="col-xl-12 col-lg-6 col-md-6"> <x-services list="true"/> </div><div class="col-xl-12 col-lg-6 col-md-6"> <x-journals/> </div></div></div><div class="col-xl-9 col-lg-12 mb-5"> <div class="row"> <div class="col-12 mb-4"> <h2 class="mb-4">تواصل معنا</h2> <div class="row"> <x-journal-contact address="{{$row->address}}" email="{{$row->email}}" phone="{{$row->phone}}"/> </div></div><div class="col-12"> <h1> <h3 class="mb-4">تعليمات المؤلفين</h3> </h1> </div>@if ($row->authors_instructions !=null) <div class="col-12 mb-4"> <div class="box-white team-box">{!! $row->authors_instructions !!}</div></div>@else <div class="col-12"> <div class="box-white py-5"> <h5 class=" text-center">لا توجد بيانات حتى الآن ابقوا متابعين</h5> </div></div>@endif </div></div></div></div></section>@endsection