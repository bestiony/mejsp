@php $journal=''; @endphp
@extends('main.layouts.master')
@section('title', 'إصدارات ' . $row->name)
{{-- @extends('main.layouts.master') --}}
@section('title', $row->title)
@section('keywords', str_replace(' ', ',', filter_var(Str::limit($row->abstract, 100), FILTER_SANITIZE_STRING)))
@section('description', filter_var(Str::limit($row->abstract, 150), FILTER_SANITIZE_STRING))
@section('type', 'Research')
@section('url', urldecode(Request::url()))
@section('content')

    @include('main.journals.header') <section id="">
        <div class="container py-5 ">
            <div class="row">
                <div class="col-12 mb-4">
                    <h3 class=" mb-4">تواصل معنا</h3>
                    <div class="row">
                        <x-journal-contact address="{{ $row->address }}" email="{{ $row->email }}"
                            phone="{{ $row->phone }}" />
                    </div>
                </div>
                <div class="col-12">
                    <h1>
                        <h3 class="mb-4">إصدارات المجلة</h3>
                    </h1>
                </div>
                @if (count($versions) > 0)
                    @foreach ($versions as $ver)
                        <div
                            class="col-xl-6 col-lg-12 col-md-12 mb-4 @if ($loop->last) {{ 'mb-5' }} @endif">
                            <a class=" text-dark"
                                href="@if ($ver->old_version != null) {{ url('researches/' . $row->slug . '/version' . '/' . $ver->id) }}@else{{ url('researches/' . $row->slug . '/version' . '/' . $ver->id) }} @endif">
                                <div style="padding: 30px 18px !important;" class="box-white">
                                    @if ($ver->old_version != null)
                                        <span class=" ">{{ $ver->old_version }}</span>
                                    @else
                                        <span class=""> <span>الإصدار</span> <span>{{ $ver->version . ' : ' }}</span>
                                            <span>{{ $ver->day }}</span> <span>
                                                @if (intval($ver->month) != 0)
                                                    {{ $months_names[intval($ver->month) - 1] }}
                                                @else
                                                    {{ $ver->month }}
                                                @endif
                                            </span> <span>{{ $ver->year }}م</span> </span>
                                    @endif <small
                                        class=" float-sm-left float-none d-sm-inline-block d-block mt-sm-0 mt-2 text-primary">عدد
                                        الأوراق ({{ count($ver->research) }})</small>
                                    <div class="clearfix"></div>
                                    @if ($loop->index == 0)
                                        <small class="latest-version badge badge-primary mr-3">أحدث إصدار</small>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="box-white py-5">
                            <h5 class=" text-center">قريباً سوف يتم إضافة إصدارات من المجلة </h5>
                        </div>
                    </div>
                @endif
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-4">
                            <x-services list="true" />
                        </div>
                        <div class="col-lg-4">
                            <x-journals />
                        </div>
                        <div class="col-lg-4">
                            <x-blog />
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>@endsection
