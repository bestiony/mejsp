@extends('main.layouts.master')
@section('title', $pageTitle)
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/simple-lightbox.min.css') }}" />

@endsection
@section('content')

    <style>
        .status {
            padding: 0 10px !important;
            font-size: 14px !important;
        }

        #image_downlaod_button {
            left: 10%;
            top: 50% ;
            transform: translateX(-50%);
            z-index: 1041;
        }

        @media only screen and (max-width: 600px) {
            #image_downlaod_button {
            left: 50%;
            bottom: 10%;
            top: 85%;

            }
        }
    </style>

    <section id="section" class="py-5 mt-5">
        <div class="container">
            <div class="row">

                <div class="col-12 mb-4">
                    <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
                </div>

                <!-- Include Aside -->
                @include('main.user.aside')


                <div class="col-lg-9">



                    <div class="row">


                        @if (count($documents) > 0)
                            @foreach ($documents as $row)
                                <div class="col-12 mb-4">
                                    <div class="box-white pl-4">
                                        <div class="mb-2 mt-3 d-flex  align-items-center">
                                            <i class="fa-solid fa-book-open-reader bg-success rounded mx-1"
                                                style="padding: 0.7rem;"> </i>
                                            <span class=" font-weight-bold user-name" style="min-width: 120px;"> عنوان الدراسة
                                                : </span>
                                            <span class=" font-weight-bold user-name">{{ $row->research->title }}</span>
                                            <span
                                                class="ml-2 research-date d-none d-sm-block mr-auto">{{ date('Y-m-d', strtotime($row->created_at)) }}</span>
                                        </div>

                                        <div class="mr-5 mb-1 my-4  d-flex justify-content-start">
                                            <span class="bolld float-right text-secondary" style="min-width: 120px;">عنوان
                                                المستند
                                                :</span>
                                            <p
                                                class=" font-weight-bold
                                    @if (preg_match(" /^[\w\d\s.,-]*$/", $row->name)) text-left @endif
                                    ">
                                                {{ $row->name }}</p>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class=" mb-1 my-4  d-flex justify-content-start d-sm-none">
                                            <span class="mr-5 bolld float-right text-secondary"
                                                style="min-width: 120px;">تاريخ الإرسال
                                                :</span>
                                            <span class="">2023-02-08</span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="d-flex justify-content-center justify-content-md-end">
                                            <a target="_blank" class="btn btn-outline-success btn-sm bg-default m-2"
                                                href="{{ asset('assets/uploads/users-documents/' . $row->pdf) }}"
                                                role="button">PDF</a>
                                            <a onclick="update_link(event, this)"
                                                class="image-{{ $row->id }} gallery btn btn-outline-info btn-sm bg-default m-2"
                                                href="{{ asset('assets/uploads/users-documents/' . $row->photo) }}"
                                                role="button">
                                                <img class="d-none"
                                                    src="{{ asset('assets/uploads/users-documents/' . $row->photo) }}"
                                                    alt="">
                                                الصورة</a>

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-12 mb-4">
                                <div class="box-white py-5">
                                    <h5 class=" text-center">لا توجد مستندات</h5>
                                </div>
                            </div>
                        @endif
                    </div>
                    <a download href="" id="image_downlaod_button" type="button"
                        class="btn btn-primary d-none position-fixed  h-4" style=" ">
                        تحميل
                    </a>


                </div>

            </div>

        </div>

    </section>

@endsection
@section('js')
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/simple-lightbox.jquery.js') }}"></script>
    <script>
        var images = document.querySelectorAll('.gallery');

        $(function() {
            for (const image of images) {
                console.log(image.classList[0])
                let element = $('.' + image.classList[0]).simpleLightbox({})
                element.on('close.simplelightbox', function() {
                    $("#image_downlaod_button").addClass('d-none');
                    console.log('inside');

                })
            }

            $('#image_downlaod_button').on('click', function() {
                console.log('hease');
            })
            document.addEventListener('shown.simplelightbox', function() {
                console.log('yes');

            })
        })

        function update_link(event, element) {


            $('#image_downlaod_button').attr("href", element.getAttribute('href'));
            // $('#image_downlaod_button').add("href", element.getAttribute('href'));
            if ($("#image_downlaod_button").hasClass('d-none')) {
                $("#image_downlaod_button").removeClass('d-none');
            } else {
                $("#image_downlaod_button").addClass('d-none');
            }
        }
    </script>
@endsection
