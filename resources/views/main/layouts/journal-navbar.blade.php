<nav dir="rtl" id="navbar" class="navbar navbar-expand-sm navbar-light fixed-top">
    <div class="header w-100 fixed-top justify-content-between">
        <div class="d-flex align-items-center mb-2">
            <a href="#">المدونة</a>
            <a href="#">اتصل بنا</a>
            <a href="#">من نحن</a>
            <a href="#">شروط الاستخدام</a>
        </div>
        
        <div class="d-flex mr-5">
            <a href="#" >
                <span>(671) 555-0110</span>
                <i class="fa-solid fa-mobile"></i>
            </a>
            <a href="#" >
                <span>youremail@gmail.com</span>
                <i class="fa-solid fa-envelope-open-text"></i>
            </a>
        </div>
    </div>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <div class="row pt-5">
            <div class="col-12">
                <div class="img-container">
                    <img src="{{asset('assets/images/logo.png')}}" alt="">
                </div>
            </div>
            <a href="#" class="col-4">
                <i class="fa-solid fa-house"></i>
                <span>.header</span>
            </a>
            <a href="#" class="col-4">
                <i class="fa-solid fa-users"></i>
                <span>المدربين</span>
            </a>
            <a href="#" class="col-4"> 
                <i class="fa-solid fa-book-open"></i>
                <span>النشر الدولي</span>
            </a>
            <a href="#" class="col-4">
                <i class="fa-solid fa-paper-plane"></i>
                <span>اتصل بنا</span>
            </a>
            <div class="col-12 d-flex align-items-center justify-content-center gap-2 icons">
                <a href="#">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
            <div class="col-12">
                <p class=" text-gray text-center">&copy; {{date('Y')}} Mejsp.com جميع الحقوق محفوظة</p>
            </div>
        </div>
    </div>
    <span class="mySidebarButton" onclick="openNav()">&#9776;</span>


     <a class="navbar-brand navbar-brand" href="{{url('journal/' . $row->slug)}}">
        @if (checkFile('assets/uploads/journals/' . $row->logo)) <img width="120" height="40"
				src="{{asset('assets/uploads/journals/' . $row->logo)}}"> @else <img width="120" height="40"
				src="{{asset('assets/images/404-icon.png')}}"> @endif 
         </a> 
     <button class="navbar-toggler d-lg-none mr-auto" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i class="fa-solid fa-list-ul"></i></button>
        <div id="div-mobile" class="mr-4 mr-lg-1">
            @if(Auth::guard('user')->check())

            <span class="badge badge-notify badge-notify-journal">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <i class="fa-sharp fa-solid fa-bell"></i>
            </button>
            <ul class="dropdown-menu not-body">
                <div style="overflow-y: scroll;max-height:300px;" class="noti">
                    @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                    @if ($notification->read_at == null)
                    <li class="dropdown-item">
                        <a  href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                            <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                                <span>{!! $notification->data['body'] !!}</span>
                            </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @else
                    <li class="dropdown-item">
                        <a  href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                            <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                                <span>{!! $notification->data['body'] !!}</span>
                            </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @endif
                    <li role="separator" class="dropdown-divider"></li>

                    @endforeach
                </div>
                <li class="text-right mr-3 bg-white py-2">
                    <a href="{{userUrl('notification')}}" class="small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small"></i>
                        جميع الإشعارات
                        </a>
                </li>
            </ul>

            @endif
        </div>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item"> <button title="بحث" class="nav-link btn-search"><i class="fa-solid fa-magnifying-glass"></i></button> </li>
				<li class="nav-item"> <a class="nav-link {{activeSingleLink('versions')}}"
						href="{{url('versions/' . $row->slug)}}" title="الإصدارات">الإصدارات</a> </li>
				<li class="nav-item"> <a class="nav-link {{activeSingleLink('team')}}"
						href="{{url('team/' . $row->slug)}}" title="فريق التحرير">فريق التحرير</a> </li>
				<li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" id="dropdownId"
						data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">التعليمات</a>
					<div class="dropdown-menu text-right" aria-labelledby="dropdownId"> <a title="تعليمات للمراجعين "
							class="dropdown-item {{activeSingleLink('reviewers-instructions')}}"
							href="{{url('reviewers-instructions/' . $row->slug)}}">تعليمات للمراجعين</a> <a
							title="تعليمات المؤلفين " class="dropdown-item {{activeSingleLink('authors-instructions')}}"
							href="{{url('authors-instructions/' . $row->slug)}}">تعليمات المؤلفين</a> <a
							class="dropdown-item {{activeSingleLink('publication-ethics')}}"
							href="{{url('publication-ethics/' . $row->slug)}}">شروط وأخلاقيات النشر</a> <a
							class="dropdown-item {{activeSingleLink('how-to-submit-the-article')}}"
							href="{{url('how-to-submit-the-article/' . $row->slug)}}">كيفية تقديم المقال</a> <a
							class="dropdown-item {{activeSingleLink('publication-price')}}"
							href="{{url('publication-price/' . $row->slug)}}">رسوم النشر</a> </div>
				</li>
				<li class="nav-item"> <a class="nav-link {{activeSingleLink('international-credits')}}"
						href="{{url('international-credits/' . $row->slug)}}" title="تعليمات للمراجعين ">الاعتمادات
						الدولية</a> </li>
				<li class="nav-item"> <a class="nav-link" href="{{url('services')}}" title="الخدمات">الخدمات</a> </li>
				<li class="nav-item @if($front_sections['journals'] != 1) d-none @endif""> <a class="nav-link" href="{{url('journals')}}" title="المجلات">المجلات</a> </li>
				<li class="nav-item"> <a class="nav-link" href="{{url('')}}" title="الرئيسية">{{env('APP_NAME')}}.com <i
							class="fa-solid fa-house-chimney"></i></a> </li>
				<li class="nav-item"> <a class="nav-link btn-second" href="{{userUrl('researches')}}"
						title="قم بإرسال بحثك">
						قم بإرسال بحثك</a> </li>

                <style>
                    #div-desktop {
                        display: none;
                    }

                    @media screen and (min-width: 500px) {
                        #div-mobile {
                            display: none;
                        }

                        #div-desktop {
                            display: block;
                        }
                    }

                    .badge-notify {
                        background: red;
                        /* position: absolute;
                        top: 18px;
                        left: 77px; */
                        margin-right: 1%;
                        border-radius: 50%;
                        color: white;

                    }

                    .dropdown-menu {
                        max-width: 25rem !important;
                        line-height: 24px;
                        text-align: right;
                        margin-left: 2rem;
                        border-bottom: 3px solid darkred;
                    }

                    .dropdown-item {
                        width: 100% !important;
                        white-space: normal !important;
                        display: inherit !important;
                    }
                </style>
                @if (Auth::guard('user')->check())
                <li class="nav-item ml-4"> 
                <a class="nav-link btn-second" href="{{userUrl('dashboard')}}">لوحه التحكم</a> </li>
                @else
                <li class="nav-item ml-4"> <a class="nav-link btn-second" href="{{url('login')}}" title="المجلات">دخول</a> </li>
                @endif
            </ul>
        </div>
        <div id="div-desktop">
            @if(Auth::guard('user')->check())
            <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                <span class="badge badge-notify badge-notify-journal">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>

                <i class="fa-sharp fa-solid fa-bell"></i>

            </button>

            <ul class="dropdown-menu not-body">
                <div style="overflow-y: scroll;max-height:300px;" class="noti">
                    @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                    @if ($notification->read_at == null)
                    <li class="dropdown-item">
                         <a class="d-flex small text-dark" href="{{userUrl('notification')}}"><i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                            {!! $notification->data['body'] !!}
                        </a>
                        <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @else
                    <li class="dropdown-item">
                    <div class=" d-flex small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                        <div>
                            <span>{!! $notification->data['body'] !!}</span>
                            <a href="/u/researches/all" class="small">
                                  الاطلاع على حاله طلبك
                              </a>
                        </div>
                    </div>
                    <span class="text-muted small ml-2"><i class="fa-regular fa-clock"></i> {{$notification->created_at->diffforhumans()}}</span>
                    </li>

                    @endif
                    <li role="separator" class="dropdown-divider"></li>

                    @endforeach

                </div>
                <li class="text-right mr-3 bg-white py-2">
                    <a href="{{userUrl('notification')}}" class="small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small"></i>
                        جميع الإشعارات
                        </a>
                </li>
            </ul>

            @endif
        </div>
    </div>
</nav>