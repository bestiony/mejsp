<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="icon" href="{{ asset('assets/images/logo-icon-16x16.webp') }}" sizes="16x16">
    <title>@yield('title', 'Default Tilte')</title>
    <meta name="language" content="Arabic" />
    <meta name="title" content="@yield('title', 'العنوان الافتراضي')" />
    <meta name="description" content="@yield('description', 'مؤسسة الشرق الأوسط للنشر العلمي')" />
    <meta name="keywords" content="@yield('keywords', 'مؤسسة, الشرق, الأوسط, للنشر, العلمي')" />
    <meta name="application-name" content="{{ env('APP_NAME') }}">
    <meta property="og:title" content="@yield('title', 'Default Tilte')">
    <meta property="og:site_name" content="{{ env('APP_NAME') }}">
    <meta property="og:url" content="@yield('url', env('APP_URL'))">
    <meta property="og:locale" content="ar_AR">
    <meta property="og:locale:alternate" content="ar_AR">
    <meta property="og:description" content="@yield('description', '')">
    <meta property="og:type" content="@yield('type', 'website')">
    <meta property="og:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))">
    <meta property="og:image:alt" content="@yield('title', 'Default Tilte')" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:data1" content="{{ env('APP_NAME') }}" />
    <meta property="twitter:image" content="@yield('image', asset('assets/images/meta-image-defualt.jpg'))" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl_carousel/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/owl_carousel/owl.theme.default.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css') }}" />
    @yield('css')
    <style>
        @media(max-width:768px){
            #menu{display: none}
        }
    </style>
    @if (!isset($enTemplate))
        <link rel="stylesheet" href="{{ asset('assets/css/rtl/rtl.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/navbar/navbar.css') }}" />

    @if (isset($ads))
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-8640427261089579"
                crossorigin="anonymous"></script>
    @endif
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-137036977-2"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-137036977-2');
    </script>
</head>

<body>
    @if (isset($journal))
        @include('main.layouts.journal-navbar')
    @else
        @include('main.layouts.navbar')
    @endif @yield('content')@include('main.layouts.footer')
    <script src="{{ asset('assets/plugins/fontawesome/all.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/owl_carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/popper/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.fittext.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery-validate-message-ar.js') }}"></script>
    <script src="{{ asset('assets/plugins/jquery/jquery.form.min.js') }}"></script>@yield('js')
    <script src="{{ asset('assets/js/validation.js') }}"></script>
    <script src="{{ asset('assets/js/file-input.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    <script src="{{ asset('assets/js/plugin.js') }}"></script>
    @if (session()->has('success_email_verification'))
        <script>
            toastr.options.timeOut = 4000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success_email_verification') }}");
        </script>
        @endif @if (session()->has('deleteMessage'))
            <script>
                toastr.options.timeOut = 1500;
                toastr.options.progressBar = true;
                toastr.success("{{ session()->get('deleteMessage') }}");
            </script>
        @endif
        <script>
            function openNav() {
            document.getElementById("mySidenav").style.width = "300px";
            }

            function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            }
            $('#chat-toggler').on("click", function () {
                $(".chat.card").toggleClass("show")
            });
            $('#close-chat').on("click", function () {
                $(".chat.card").removeClass("show")
            });
            $(".login-form").on("submit", function (e) {
                e.preventDefault();
                $(this).hide();
            });
            </script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
        $('#confirm_email').on('click',function(){
            var email=$('#email').val();
            document.cookie = "chat_email="+email+"";
            location.reload();
        });
        
        $('#textAreaExample').on('keypress',function(e){
            var file=$("#upload-research-file")[0].files;
            console.log(file);
            if (e.which == 13) {
                if(text!==''|| !file){
                var text=$(this).val();
               var html=`<div class="d-flex flex-row justify-content-start mb-4">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                            <p class="small mb-0">${text}</p>
                            </div>
                        </div>`

                var file_div=`<div class="d-flex flex-row justify-content-start mb-4">
                    
                    <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                        <p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p>
                    </div>`;
                if(file.length>0){
                    $('#CardBody').append(file_div);
                }
                if(text!==''){
                    $('#CardBody').append(html);
                }
              
                $('#textAreaExample').val("");  // <=============================================================================================
                $("#textAreaExample").attr("disabled","");
                $("#submit").attr("disabled","");
                $("#submit svg").removeClass("fa-paper-plane");
                $("#submit svg").addClass("fa-spinner fa-spin");
                var formData = new FormData();
                formData.append('email', getCookie('chat_email'));
                formData.append('message', text);
                formData.append('file', file[0]);
                $.ajax({
                    "url":"{{ Route('userSendMessage') }}",
                    "type":"post",
                    "data":formData,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        $('#textAreaExample').val('');
                        $("#textAreaExample").removeAttr("disabled");
                        $("#submit").removeAttr("disabled");
                        $("#submit svg").removeClass("fa-spinner fa-spin");
                        $("#submit svg").addClass("fa-paper-plane");
                        $('#file-box').addClass("d-none");
                    }
                });
                document.querySelector("#CardBody").scrollTo(0, document.querySelector("#CardBody").scrollHeight);
            }
            }
        });

        $('#submit').on('click',function(e){
            var file=$("#upload-research-file")[0].files;
            console.log(file);
            var text=$('#textAreaExample').val();
            if(text!==''|| !file){
                
               var html=`<div class="d-flex flex-row justify-content-start mb-4">
                            <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                            <p class="small mb-0">${text}</p>
                            </div>
                        </div>`;
                var file_div=`<div class="d-flex flex-row justify-content-start mb-4">
                    
                    <div class="p-3 ms-3" style="border-radius: 15px; background-color: rgba(57, 192, 237,.2);">
                        <p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p>
                    </div>`;
                if(file.length>0){
                    $('#CardBody').append(file_div);
                }
                if(text!==''){
                    $('#CardBody').append(html);
                }
                $("#textAreaExample").attr("disabled","");
                $("#submit").attr("disabled","");
                $("#submit svg").removeClass("fa-paper-plane");
                $("#submit svg").addClass("fa-spinner fa-spin");
                var formData = new FormData();
                formData.append('email', getCookie('chat_email'));
                formData.append('message', text);
                formData.append('file', file[0]);
                $.ajax({
                    "url":"{{ Route('userSendMessage') }}",
                    "type":"post",
                    "data":formData,
                    processData: false,
                    contentType: false,
                    success:function(response){
                        $('#textAreaExample').val('');
                        $("#textAreaExample").removeAttr("disabled");
                        $("#submit").removeAttr("disabled");
                        $("#submit svg").removeClass("fa-spinner fa-spin");
                        $("#submit svg").addClass("fa-paper-plane");
                        $('#file-box').addClass("d-none");
                    }
                });
                document.querySelector("#CardBody").scrollTo(0, document.querySelector("#CardBody").scrollHeight);
            }
        });
    </script>


<script>
    Pusher.logToConsole = false;

var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
  cluster: 'eu'
});
var email=getCookie('chat_email');
    email?$(".login-form").hide():null;
let userId = email
var channel = pusher.subscribe('research-chat.'+userId);
channel.bind('research-chat-message', function(data) {
  let message = data.message
  let document_file = data.document
  console.log(document_file);
  console.log(message);
    var push_html=`<div class="d-flex flex-row justify-content-end mb-4">
                            <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                                <p class="small mb-0">${message}</p>
                            </div>
                        </div>`
    if(message!==null){
        $('#CardBody').append(push_html);
        document.querySelector("#CardBody").scrollTo(0, document.querySelector("#CardBody").scrollHeight);
    }
    var push_file_div=`<div class="d-flex flex-row justify-content-end mb-4">
                        <div class="p-3 me-3 border" style="border-radius: 15px; background-color: #fbfbfb;">
                            <a download href="{{ asset('email/${document_file}') }}"><p class="small mb-0"><i class="fa-solid fa-folder-closed" style="cursor:pointer;font-size:22px"></i></p></a>
                        </div>
                    </div>`;
                    

    if(document_file){
        $('#CardBody').append(push_file_div);
        document.querySelector("#CardBody").scrollTo(0, document.querySelector("#CardBody").scrollHeight);
    }
});
</script>
<script>
    
        
// <----------------------------------------------------------- upload file to the chat ------------------------------------------------------------------------->

function showUploadedFileName(){
    let research_input =document.querySelector('#upload-research-file')
    let research_file = research_input.files[0];
    let research_label = document.querySelector('label[for="upload-research-file"]')
    // let currentContent = research_label.innerHTML;
    //animation
    research_input.disabled=true;
    research_label.innerHTML='<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true" style="    vertical-align: -0.325em;"></span>'
    setTimeout(() => {
    research_input.disabled = false
    // research_label.innerHTML = currentContent;
    // document.querySelector('textarea[name="message"]').scrollIntoView()
    }, 2000);


    document.querySelector('#file-name').innerText=research_file.name
    
    document.querySelector('#file-box').classList.remove('d-none')
    const reader = new FileReader()

    reader.addEventListener('load', function(event) {
        let research_label = document.querySelector('label[for="upload-research-file"]')
        research_label.innerHTML =`<i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                    margin: 0 2px;    position: relative;top: 4px;"></i>`
    })

    // Files can be read with the readAs[ArrayBuffer|BinaryString|DataURL|Text] methods
    reader.readAsArrayBuffer(research_file)
    reader.addEventListener('progress', event => {
    
        const percent = Math.round((event.loaded / event.total) * 100)
            const loadingBar = Array(10)
                .fill('▒')
                .map(function(item, index) {
                    document.querySelector('#upload-progress .progress-bar').style.width=Math.round(percent)+"%"
                
                return Math.round(percent / 10) > index ? '█'
                    : '▒'   
                } )
                .join('')

            // document.location.hash = `${loadingBar}(${percent}%)`
            

    })
    // reader.readAsBinaryString(research_file)
    // reader.readAsDataURL(research_file)
    // reader.readAsText(research_file)
}
function removeCurrentFile(){
    document.querySelector('#upload-research-file').value = '';
    document.querySelector('#file-box').classList.add('d-none')
    document.querySelector('#upload-progress .progress-bar').style.width="0%"
    document.querySelector('#file-name').innerText=''
    let research_label = document.querySelector('label[for="upload-research-file"]')
    research_label.innerHTML =`<i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>`
    
}

// <----------------------------------------------------------- upload file to the chat ------------------------------------------------------------------------->

</script>
</body>

</html>
