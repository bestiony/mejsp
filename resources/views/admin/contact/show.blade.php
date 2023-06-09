@extends('admin.layouts.master')
@section('title', 'عرض الرسالة')
@section('content')

    <div class="links-bar my-4 ">
        <h4>عرض الرسالة</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>
    <div id="contacts">
        <div class="row justify-content-center">

            <div class="col-xl-3 mb-4">
                <div class="box-white p-0">
                    @foreach ($contact as $row)
                        <div class=" senders">
                            <a href="{{ admin_url('contact/show/' . $row->id) }}">


                                <div class="info mt-1">
                                    <h6>{{ $row->f_name . ' ' . $row->l_name }}</h6>
                                    <h6>{{ $row->email }}</h6>
                                </div>

                                @if ($row->status == 1)
                                    <div class=" badge badge-primary mt-2 float-left">غير مقروء</div>
                                @endif

                                <div class="clearfix"></div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div><!-- Sender -->


            <div class="col-xl-6">
                <div class="box-white p-0">
                    <h5 class="mb-0 border-bottom pb-3 pt-3 px-3">محتوى الرسالة</h5>
                    <div class="p-3">
                        <p>{{ $msg->message }}</p>
                    </div>
                </div>
            </div><!-- Sender -->


        </div>
    </div>

@endsection
