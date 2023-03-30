@extends('main.layouts.master')
@section('title', 'لوحة التحكم')
@section('content')
    <section id="section" class="py-5 mt-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">لوحة التحكم</h5><!-- Page Name -->
                </div>


                <!-- Include Aside -->
                @include('main.user.aside')


                <div class="col-lg-9 col-md-8">
                    <div class="row">
                        @if($front_sections['international_conference'] == 1)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                              
                                <a href="{{ userUrl('conference/create') }}" class=" text-dark ">
                                    <i class="fa-solid fa-file-circle-plus fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0"> المؤتمرات الدولية  </h6>
                                </a>
                             
                            </div>
                        </div><!-- Col -->
                        @endif
                        @if($front_sections['international_publishing'] == 1) 
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('international-publishing/create') }}" class=" text-dark">
                                    <i class="fa-solid fa-bullhorn fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">SCOPUS   </h6>
                                </a>
                            </div>
                        </div><!-- Col -->
                        @endif
                        @if($front_sections['international_publishing'] == 1) 
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('international-publishing/create') }}" class=" text-dark">
                                    <i class="fa-solid fa-bullhorn fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">WOS (ISI)   </h6>
                                </a>
                            </div>
                        </div><!-- Col -->
                        @endif

                        @if($front_sections['add_research'] == 1) 
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('researches') }}" class=" text-dark">
                                    <i class="fa-solid fa-file-word fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">تقديم دراسة </h6>
                                </a>
                            </div>
                        </div><!-- Col -->
                        @endif

                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('settings') }}" class=" text-dark">
                                    <i class="fa-solid fa-user-gear fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">الإعدادات</h6>
                                </a>
                            </div>
                        </div><!-- Col -->
                        
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{route('user_documents')}}" class=" text-dark">
                                    <i class="fa-solid fa-file-lines fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">مستنداتك</h6>
                                </a>
                            </div>
                        </div><!-- Col -->
                        
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('researches/all') }}" class=" text-dark">
                                    <i class="fa-solid fa-file-word fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0"> طلباتك</h6>
                                </a>
                            </div>
                        </div><!-- Col -->


                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="box-white text-center">
                                <a href="{{ userUrl('logout') }}" class=" text-dark">
                                    <i class="fa-solid fa-arrow-right-from-bracket fa-2x"></i>
                                    <h6 class=" text-center mt-3 mb-0">تسجيل الخروج</h6>
                                </a>
                            </div>
                        </div><!-- Col -->


                        @if (count($researches) > 0)
                            @if ($researches[0]->research != null)

                                <div class="col-12">
                                    <h6>الابحاث</h6>
                                    <div class="box-white table-responsive">
                                        <table class="table table-striped table-inverse  table-bordered text-center mb-0">
                                            <thead class="thead-inverse">
                                                <tr>
                                                    <th>عنوان البحث</th>
                                                    <th>تم شراء النسخة منذ</th>
                                                    <th>البحث</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($researches as $row)
                                                    @if (!empty($row->research))
                                                        <tr>
                                                            <td>

                                                                {{ $row->research->title }}

                                                            </td>
                                                            <td>{{ parseTime($row->created_at) }}</td>
                                                            <td>
                                                                @if (checkFile('assets/uploads/journals-researches/' . $row->research->file))
                                                                    <a download
                                                                        href="{{ asset('assets/uploads/journals-researches/' . $row->research->file) }}"
                                                                        class="btn btn-primary btn-sm"><i
                                                                            class="fa-solid fa-download"></i> تحميل</a>
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            @endif
                        @endif


                    </div>
                </div><!-- End Content -->

            </div>
        </div>
    </section>
@endsection
