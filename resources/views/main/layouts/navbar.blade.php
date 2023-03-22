<nav dir="rtl" id="navbar" class="navbar navbar-expand-sm navbar-light fixed-top">
    <div class="header w-100 fixed-top">
        <a href="#">المدونة</a>
        <a href="#">اتصل بنا</a>
        <a href="#">من نحن</a>
        <a href="#">شروط الاستخدام</a>
        <select name="languages" id="languages">
            <option value="ar">العربية</option>
            <option value="en">english</option>
        </select>
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
    <a class="navbar-brand" href="{{url('')}}">
    <img src="{{asset('assets/images/notfound-sad.png')}}" alt="" class="abs-img">    
    <img src="{{asset('assets/images/logo.png')}}"
            alt="مؤسسة الشرق الأوسط للنشر العلمي" title="مؤسسة الشرق الأوسط للنشر العلمي"></a>
    <button class="navbar-toggler d-lg-none mr-auto" type="button" data-toggle="collapse" data-target="#collapsibleNavId"
        aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation"><i
            class="fa-solid fa-list-ul"></i></button>
    <div id="div-mobile">
        @if(Auth::guard('user')->check())

        <span class="badge badge-notify">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>
        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <i class="fa-sharp fa-solid fa-bell"></i>
        </button>
        <ul class="dropdown-menu not-body">
            <div style="overflow-y: scroll;max-height:300px;" class="noti">
                @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                @if ($notification->read_at == null)
                <li class="dropdown-item">
                    <a href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                        <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                        <span>{!! $notification->data['body'] !!}</span>
                    </a>
                    <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i>
                        {{$notification->created_at->diffforhumans()}}</span>
                </li>

                @else
                <li class="dropdown-item">
                    <a href="{{userUrl('notification')}}" class="d-flex small text-dark p-2">
                        <i class="fa-sharp fa-solid fa-bell ml-2 d-none"></i>
                        <span>{!! $notification->data['body'] !!}</span>
                    </a>
                    <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i>
                        {{$notification->created_at->diffforhumans()}}</span>
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
            
            @if($front_sections['blog'] == 1) <li class="nav-item"> <a class="nav-link" href="{{url('blog')}}"
                    title="المدونة">المدونة</a> </li>@endif
            @if($front_sections['blog_en'] == 1) <li class="nav-item"> <a class="nav-link" href="{{url('en/blog')}}"
                    title="Blog">Blog</a> </li>@endif
            @if($front_sections['journals'] == 1)
            <li class="nav-item @if($front_sections['journals'] != 1) d-none @endif"> <a class="nav-link "
                    href="{{url('journals')}}" title="المجلات">المجلات</a> </li>
            @endif
            @if($front_sections['international_conference'] == 1)
            <li class="nav-item @if($front_sections['international_conference'] != 1) d-none @endif"> <a
                    class="nav-link btn-second" href="{{userUrl('conference/create')}}"
                    title="طلب الانضمام لمؤتمر دولي">طلب الانضمام لمؤتمر دولي</a> </li>
            @endif
            @if($front_sections['international_publishing'] == 1)
            <li class="nav-item @if($front_sections['international_publishing'] != 1) d-none @endif"> <a
                    class="nav-link btn-second" href="{{userUrl('international-publishing/create')}}"
                    title="النشر الدولي">النشر الدولي</a> </li>
            @endif
            @if($front_sections['add_research'] == 1)
            <li class="nav-item">
                <a class="nav-link btn-second @if($front_sections['add_research'] != 1) d-none @endif"
                    href="{{userUrl('researches')}}" title="تقديم دراسة">تقديم دراسة</a>
            </li>
            @endif


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
            <li class="nav-item ml-3">
                <a class="nav-link btn-second" href="{{userUrl('dashboard')}}">لوحه التحكم</a>
            </li>
            @else
            <li class="nav-item ml-3"> <a class="nav-link btn-second" href="{{url('login')}}" title="المجلات">دخول</a>
            </li>
            @endif
            <li class="nav-item"> <button title="بحث" class="nav-link btn-search"><i
                        class="fa-solid fa-magnifying-glass"></i></button> </li>
        </ul>
    </div>
    <div id="div-desktop">
        @if(Auth::guard('user')->check())
        <button class="dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
            <span class="badge badge-notify">{{Auth::guard('user')->user()->unreadNotifications ->count()}}</span>

            <i class="fa-sharp fa-solid fa-bell"></i>

        </button>

        <ul class="dropdown-menu not-body">
            <div style="overflow-y: scroll;max-height:300px;" class="noti">
                @foreach(Auth::guard('user')->user()->notifications->slice(0, 5) as $notification)
                @if ($notification->read_at == null)
                <li class="dropdown-item">
                    <a class="d-flex small text-dark" href="{{userUrl('notification')}}"><i
                            class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                        {!! $notification->data['body'] !!}
                    </a>
                    <span class="text-muted mt-0 small"><i class="fa-regular fa-clock" style="margin-right: 20px;"></i>
                        {{$notification->created_at->diffforhumans()}}</span>
                </li>

                @else
                <li class="dropdown-item">
                    <div class=" d-flex small text-dark">
                        <i class="fa-sharp fa-solid mt-2 fa-bell ml-2 small text-dark"></i>
                        <div>
                            <span>{!! $notification->data['body'] !!}</span>
                            @if ($notification->data['type'] != 'email_confirmation' )
                            <a href="/u/researches/all" class="small">
                                الاطلاع على حاله طلبك
                            </a>
                            @else
                            <a href="{{route('submit_new_study')}}" class="small">
                                تقديم دراسة للنشر
                            </a>
                            @endif
                        </div>
                    </div>
                    <span class="text-muted small ml-2"><i class="fa-regular fa-clock"></i>
                        {{$notification->created_at->diffforhumans()}}</span>
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


        <button class="chat-toggler d-flex align-items-center justify-content-center" id="chat-toggler">
            <i class="fa-solid fa-paper-plane"></i>
            <span>تواصل معنا</span>
        </button>
        <div class="chat card" id="chat1" style="border-radius: 15px;">
        <form action="" class="login-form">
            <label for="email" class="form-label mb-3">من فضلك قم بإدخال البريد الالكتروني اولا</label>
            <input type="email" class="form-control" id="email" placeholder="عنوان البريد الإلكتروني">
            <button id="confirm_email" class="btn my-2 btn-outline-primary"type="submit">تأكيد</button>
        </form>
          <div
            class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
            style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
            <p class="mb-0 fw-bold">Live chat</p>
            <button type="button" id="close-chat" class="text-white">
                <i class="fas fa-times"></i>
            </button>
          </div>
          {{-- chat body --}}
        <div class="card-body" id="CardBody">
            @if (isset($user_messages))
                @foreach ($user_messages as $user_message)
                    @if ($user_message->sender=='user')
                        @if ($user_message->document==NULL)
                            <div class="d-flex flex-row justify-content-start mb-4">
                            
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <p class="small mb-0">{{ $user_message->message }}</p>
                                </div>
                            </div>
                        @elseif ($user_message->document!==NULL)
                            <div class="d-flex flex-row justify-content-start mb-4">
                                <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                                    <a download href="{{ asset('email/'.$user_message->document.'') }}"><p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p></a> 
                                </div>
                            </div>
                        @endif
                    @endif
                   
                    @if ($user_message->sender=='admin')
                    
                            @if ($user_message->document==NULL)
                                <div class="d-flex flex-row justify-content-end mb-4">
                                    <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                        <p class="small mb-0">{{ $user_message->message }}</p>
                                    </div>
                                </div>
                            @elseif ($user_message->document!==NULL)
                                <div class="d-flex flex-row justify-content-end mb-4">
                                    <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                        <a download href="{{ asset('email/'.$user_message->document.'') }}"><p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p></a> 
                                    </div>
                                </div>
                            @endif
                       


                    @endif
                    {{-- <div class="d-flex flex-row justify-content-end mb-4">
                        <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                            <p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p>
                        </div>
                    </div> --}}
                    {{-- <div class="d-flex flex-row justify-content-start mb-4">
                    
                        <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                            <p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p>
                        </div>
                    </div> --}}
                
                @endforeach
            @endif
           
            


            


            {{-- <div class="d-flex flex-row justify-content-start mb-4">
                <div class="ms-3" style="border-radius: 15px;">
                    <div class="bg-image">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/screenshot1.webp"
                        style="border-radius: 15px;" alt="video">
                        <a href="#!">
                            <div class="mask"></div>
                        </a>
                    </div>
                </div>
            </div> --}}

          

            
        </div>


        <div class="card-footer">
            <div class="form-outline d-flex align-items-center justify-content-bertween">
                <input class="form-control" id="textAreaExample" placeholder="اكتب رسالتك هنا"/>
                <label for="upload-research-file" class="m-0"  data-mdb-ripple-color="dark">
                    <i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 18px;cursor:pointer;
                    margin: 0 2px 6px;position: relative;top: 4px;"></i>           
                </label>
                <input id="upload-research-file" type="file" name="file" onchange="showUploadedFileName()" class="d-none" accept="*">
                <button type="button" href="#" id="submit" class="send mx-2">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </div>
            <div class="card-footer p-3 d-none" id="file-box">
                <div class="d-flex justify-content-between mx-3 mb-2 align-items-center" style="font-size: 13px;">
                    <span class="d-block d-md-flex" style="flex: 1">
                        <span id="file-name" class="mx-2 font-weight-bold">ملف.ييخؤس</span>
                    </span>
                    <button id="remove-file" onclick="removeCurrentFile()" class="btn btn-danger btn-sm p-1">
                        X 
                        حذف
                    </button>
                </div>
                <div class="progress mx-3" id="upload-progress">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
        </div>
    </div>
