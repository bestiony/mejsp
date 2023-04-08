<header id="header-show-journal" class="d-flex justify-content-center align-items-center"> <div class="container"> <div class="row justify-content-center"> <div class="col-12"> <div class="title"> <h1 class=" text-center font-weight-bold mb-3"> <strong>{{$row->name}}</strong> </h1> @if ($row->issn !=null) <h6 class=" text-center"><span class="mr-1">ISSN</span>[<span class="mx-1">{{$row->issn}}</span>]</h6> @endif @if ($row->impact !=null) <h6 class=" text-center"><span class="mr-1 text-uppercase">Impact Factor</span>[<span class="mx-1">{{$row->impact}}</span>]</h6> @endif @if ($row->next_version !=null) <h6 class=" text-center"><span class="mr-1 text-uppercase">موعد الإصدار التالي : </span>[<span class="mx-1">{{$row->next_version}}</span>]</h6> @endif </div></div></div></div><div class="overlay"></div></header>

<button class="chat-toggler d-flex align-items-center justify-content-center" id="chat-toggler">
    <i class="fa-solid fa-paper-plane"></i>
    <span>تواصل معنا</span>
</button>
<div class="chat card" id="chat1" style="border-radius: 15px;">
<form action="" class="login-form">
    <label for="email" class="form-label mb-3">من فضلك قم بإدخال البريد الإلكتروني </label>
    <input type="email" class="form-control" id="email" placeholder="عنوان البريد الإلكتروني">
    <button id="confirm_email" class="btn my-2 btn-outline-primary"type="submit">تأكيد</button>
</form>
  <div
    class="card-header d-flex justify-content-between align-items-center p-3 bg-info text-white border-bottom-0"
    style="border-top-left-radius: 15px; border-top-right-radius: 15px;">
    <div class="d-flex flex-column">
        <p class="mb-0 fw-bold mb-2">مؤسسة الشرق الأوسط للنشر العلمي</p>
        <p class="mb-0" style="font-size: 12px;color: #eaea00;font-weight: 400;">عادةً ما يتم الرد في غضون خمس دقائق</p>
    </div>
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
            </button>
        </div>
        <div class="progress mx-3" id="upload-progress">
            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
    </div>
</div>
</div>
