<div class="box-white mb-3">

    <div class="mb-3">
        <span class="float-right text-secondary">SCOPUS/WOS(ISI) </span>
        <span class="float-left">{{ $details['journal_name'] }}</span>
        <div class="clearfix"></div>
    </div><!-- name -->

    <div class="mb-3">
        <span class="float-right text-secondary"> رسوم النشر</span>
        <span class="float-left">${{ $details['journal_price'] }}</span>
        <div class="clearfix"></div>
    </div><!-- price -->


    <div class="mb-3">
        <span class="float-right text-secondary">حالة الدفع</span>
        @if ($details['payment_response'] > 0)
            <span class="float-left text-success"> مدفوع </span>
        @else
            <span class="float-left">غير مدفوع</span>
        @endif
        <div class="clearfix"></div>
    </div><!-- ReSearch Title -->



    <div class="mb-3">
        <span class="float-right text-secondary">الملف</span>
        <span class="float-left">
            @if (file_exists(public_path('assets/uploads/international-publication-orders/' . $details['file'])))
                <a class=""
                    href="{{ asset('assets/uploads/international-publication-orders/' . $details['file']) }}"
                    download>
                    تحميل
                </a>
            @else
                {{ 'لا يوجد !' }}
            @endif
        </span>
        <div class="clearfix"></div>
    </div><!-- price -->


    @if ($details['desc'] != null)
        <div class="mb-3">
            <span class="float-right text-dark">ملاحظات:</span>
            @if (isset($details['show_desc']) && $details['show_desc'] == true)
                <div class="float-right">
                    {{ $details['desc'] }}
                </div>
            @else
                <span class="float-left"><a
                        href="{{ adminUrl('international-publishing/orders/show/' . $details['id']) }}">عرض
                        الملاحظات</a></span>
            @endif
            <div class="clearfix"></div>
        </div><!-- price -->
    @endif


    <div class="mb-3">
        <span class="float-right text-secondary">تاريخ الحجز</span>
        <span class="float-left">{{ parseTime($details['created_at']) }}</span>
        <div class="clearfix"></div>
    </div><!-- created_at -->

    
    <div class="">
        <span class="float-right text-secondary">حالة الطلب</span>
        @if ($details['status']=='1')
            <span class="float-left mr-2"><button class="btn btn-success disabled" id="accept" href="#">قبول</button> </span>
        @elseif ($details['status']=='0')
            <span class="float-left"><button class="btn btn-danger disabled" id="refuse" href="#">رفض</button> </span>
        @else
        <span class="float-left mr-2"><button data-toggle="modal" data-target="#exampleModal1" class="btn btn-success" id="accept" href="#">قبول</button> </span>
        <span class="float-left"><button data-toggle="modal" data-target="#exampleModal" class="btn btn-danger" id="refuse" href="#">رفض</button> </span>

        @endif
        <div class="clearfix"></div>
    </div><!-- created_at -->

</div>
