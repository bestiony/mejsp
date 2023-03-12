@php $row=DB::table('settings')->first(); @endphp
<footer dir="rtl" id="footer" class=" text-right"> <div id="top"> <div class="container"> <div class="row"> <div class="col-lg-4 col-md-6 col-12"> <h4 class="col-title">روابط مفيدة</h4> <ul> <li><a href="{{url('faqs')}}"><i class="fa-solid fa-caret-left"></i> الأسئلة الشائعة</a></li><li><a href="{{url('services')}}"><i class="fa-solid fa-caret-left"></i> خدمات المجلة</a> </li>@if($front_sections['blog_en'] == 1) <li><a  href="{{url('en/blog')}}"><i class="fa-solid fa-caret-left"></i> Blog</a></li>@endif<li>@if($front_sections['blog'] == 1) <a href="{{url('blog')}}"><i class="fa-solid fa-caret-left"></i> المدونة</a></li>@endif @if($front_sections['journals'] == 1) <li><a  href="{{url('journals')}}"><i class="fa-solid fa-caret-left"></i> المجلات</a></li>@endif</ul> </div><div class="col-lg-4 col-md-6 col-12"> <h4 class="col-title">تواصل معنا</h4> <ul class="be-in-touch"> @if (!empty($row)) <li><a target="_blank" href="https://api.whatsapp.com/send/?phone=2{{$row->phone}}&text&app_absent=0"><i class="fab fa-whatsapp"></i><span dir="ltr">{{$row->phone}}</span></a></li><li><a target="_blank" href="mailto:{{$row->mail}}"><i class="fa-solid fa-envelope"></i>{{$row->mail}}</a></li>@endif @if (!empty($row)) @if ($row->facebook !=null) <li> <a target="_blank" href="{{$row->facebook}}"> <i class="fab fa-facebook-f"></i>فيسبوك </a> </li>@endif @if ($row->youtube !=null) <li> <a target="_blank" href="{{$row->youtube}}"> <i class="fab fa-youtube"></i>يوتيوب</a> </a> </li>@endif @if ($row->whatsapp !=null) <li> <a target="_blank" href="{{$row->whatsapp}}"> <i class="fab fa-whatsapp"></i> واتس اب </a> </li>@endif @if ($row->twitter !=null) <li> <a target="_blank" href="{{$row->twitter}}"> <i class="fab fa-twitter"></i>تويتر </a> </li>@endif @if ($row->linkedin !=null) <li> <a target="_blank" href="{{$row->linkedin}}"> <i class="fab fa-linkedin-in"></i> لينكد ان </a> </li>@endif @endif </ul> </div><div class="col-lg-4 col-md-6 col-12"> <h4 class="col-title">تابعنا</h4> <form class="form" id="form-subscribe" action="{{url('subscribe')}}" method="POST"> <input type="email" name="email" class=" form-control" placeholder="البريد الالكتروني" required/> <small class=" text-white">احصل دائما علي اخر الاخبار من المجلة العلمية كن دائما علي اتصال معنا</small> <button type="submit" id="btn-subscribe"><i class="fa-solid fa-location-arrow"></i></button> </form> </div></div></div></div><div id="bottom"> <div class="col-12"> <h6 class=" text-white text-center">&copy; {{date('Y')}} Mejsp.com جميع الحقوق محفوظة</h6> </div></div></footer>