<!DOCTYPE html>
<html lang="{{str_replace('_', '-', app()->getLocale())}}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{csrf_token()}}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="{{asset('assets/images/logo-icon-16x16.webp')}}" sizes="16x16">
    <title>سداد فاتورة</title>
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome/all.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}?v<?php echo time(); ?>" />
    <link rel="stylesheet" href="{{asset('assets/css/global.css')}}?v<?php echo time(); ?>" />
</head>

<body>
    <div class="container pt-5">
        <div class="row justify-content-center">
            <div id="checkout-box" class="col-lg-6">
                <div class="box-white px-0 border-0 shadow pb-2">
                    <div class="text-left px-3"> <img width="45px"
                            src="{{asset('assets/images/payments/mastercard_logo.png')}}" alt=""> <img width="55px"
                            class="mx-2" src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png"
                            alt=""> <img width="45px" src="{{asset('assets/images/payments/visa.jpg')}}" alt=""> </div>
                    <hr>
                    <h5 class=" text-right pr-3 mb-3 font-weight-bold">تفاصيل الفاتورة</h5> @php $prices=0; @endphp
                    @foreach ($row->items as $item)
                    @if($item->price == 0)
                    @continue
                    @endif
                    <div class="px-3 mb-3">
                        <span
                            class="float-right">{{$item->service_name}}</span> <span
                            class="float-left">${{$item->price}}</span>
                        <div class="clearfix"></div>
                    </div>@php $prices +=$item->price; @endphp @endforeach <div class="px-3 mb-3"> <span
                            class="float-right">الضريبة</span> <span class="float-left">%5</span>
                        <div class="clearfix"></div>
                    </div>

                    <div class="px-3"> <span class="float-right">الاجمالي</span> <span
                            class="float-left font-weight-bold">{{number_format(tax($prices),2,'.','')}}</span>
                        <div class="clearfix"></div>
                    </div>
                    <hr>
                    <div id="smart-button-container" class="px-3 pt-4">
                        <div style="text-align: center;">
                            <div id="paypal-button-container"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <div class="">
                <div class="">
                    <div class="">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <div class="">
                                        <div class="">
                                            <div class="">
                                                <div class="">
                                                    <div class="">
                                                        <div class="">
                                                            <div class="">
                                                                <div class="">
                                                                    <div class="">
                                                                        <div class="">
                                                                            <div class="">. <div class="">
                                                                                    <div class="">
                                                                                        <div class="">
                                                                                            <div class="">
                                                                                                <div class="">
                                                                                                    <div class="">
                                                                                                        <div class="">
                                                                                                            <div
                                                                                                                class="">
                                                                                                                <div
                                                                                                                    class="">
                                                                                                                    <div
                                                                                                                        class="">
                                                                                                                        <div
                                                                                                                            class="">
                                                                                                                            <input
                                                                                                                                type="hidden"
                                                                                                                                value="{{number_format(tax($prices),2,'.','')}}"
                                                                                                                                id="price">
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/plugins/fontawesome/all.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/plugins/popper/popper.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/plugins/jquery/jquery.form.min.js')}}"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id={{config('paypal.client_id')}}&enable-funding=venmo&currency={{config('paypal.currency')}}"
        data-sdk-integration-source="button-factory"></script>
    <script src="{{asset('assets/js/paypal.js')}}"></script>
</body>

</html>
