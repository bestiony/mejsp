@extends('main.layouts.master') @section('title', 'الأسئلة الشائعة') @section('content') <header id="faqs-header" class="mb-4 mt-5"> <div class="container"> <h1 class=" section-title"> الأسئلة الشائعة </h1> </div></header> <section id="faqs"> <div class="container mb-5 pb-4"> <div class="accordion mb-5" id="all-faqs"> @foreach ($faqs as $row) <div class="card"> <div class="card-header" id="headingOne-{{$row->id}}"> <h2 class="mb-0 faq-title"> <button class=" btn-block text-primary" type="button" data-toggle="collapse" data-target="#collapseOne-{{$row->id}}" aria-expanded="true" aria-controls="collapseOne-{{$row->id}}">{{$row->title}}</button> </h2> </div><div id="collapseOne-{{$row->id}}" class="collapse" aria-labelledby="headingOne-{{$row->id}}" data-parent="#all-faqs"> <div class="card-body ">{!! $row->content !!}<hr> <small class=" text-muted float-left"><i class="fa-solid fa-clock"></i> اخر تحديث {{parseTime($row->updated_at)}}</small> <div class="clearfix"></div></div></div></div>@endforeach </div><div class="row"> <div class="col-lg-4"> <x-services list="true"/> </div><div class="col-lg-4"> <x-journals/> </div><div class="col-lg-4"> <x-blog/> </div></div></div></section> @endsection