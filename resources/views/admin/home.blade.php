@extends('admin.layouts.master')
@section('title', 'لوحة التحكم')
@section('content')

    <div class="links-bar">
        <h4>لوحة التحكم</h4>
    </div><!-- End Bar Links -->

    <div class="links-bar">
        <h5>إحصاءات </h5>
    </div><!-- End Bar Links -->
    
    <section id="home-dashboard">
        <div class="row">


            <!-- Start Counts --->
            
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark p-3 rounded">

                    <h5>المدفوعات</h5><!-- Name -->
                    <h3>{{ DB::table('payments')->SUM('amount') }} دولار</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-dollar"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Doctors -->
            
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark p-3 rounded">

                    <h5>الفواتير</h5><!-- Name -->
                    <h3>{{ DB::table('invoices')->count('payment_response') }} </h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-dollar"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Doctors -->
            
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark p-3 rounded">

                    <h5>المجلات</h5><!-- Name -->
                    <h3>{{ DB::table('journals')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-book-open"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Doctors -->


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark  p-3 rounded">

                    <h5>المحررون</h5><!-- Name -->
                    <h3>{{ DB::table('team')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-people-group"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Sick -->

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark  p-3 rounded">

                    <h5>المشتركون</h5><!-- Name -->
                    <h3>{{ DB::table('subscribers')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-people-group"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Sick -->

            {{--<div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics bg-dark p-3 rounded">

                    <h5>التصنيف الدولي</h5><!-- Name -->
                    <h3>{{ DB::table('international_credits')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-circle-check"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Subs -->--}}


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5>الخدمات</h5><!-- Name -->
                    <h3>{{ DB::table('services')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-layer-group"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->


            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5>الأوراق المنشورة</h5><!-- Name -->
                    <h3>{{ DB::table('journals_researches')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-file-pen"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->



                 

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5>الإصدارات</h5><!-- Name -->
                    <h3>{{ DB::table('versions')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->



                 

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5>المستخدمون</h5><!-- Name -->
                    <h3>{{ DB::table('users')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-users"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->



                      

            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5>المقالات العربية</h5><!-- Name -->
                    <h3>{{ DB::table('articles_ar')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->


            
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-4">
                <div class="statistics  bg-dark p-3 rounded">

                    <h5> المقالات الإنجليزية</h5><!-- Name -->
                    <h3>{{ DB::table('articles_en')->count('id') }}</h3><!-- Count -->
                    <div class="box-icon">
                        <i class="fa-solid fa-newspaper"></i>
                    </div><!-- Icon -->

                </div><!-- statistics -->
            </div><!-- Col Ads -->


        </div>
    </section>
@endsection
