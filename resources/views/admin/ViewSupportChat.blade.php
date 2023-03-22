@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('js')


<script>
    





function showFileName(){
    let research_input =document.querySelector('#research-file')
    let research_file = research_input.files[0];
    let research_label = document.querySelector('label[for="research-file"]')
    // let currentContent = research_label.innerHTML;
    //animation
    research_input.disabled=true;
    research_label.innerHTML='<span class="spinner-grow spinner-grow-sm mr-2" role="status" aria-hidden="true" style="    vertical-align: -0.325em;"></span>'
    setTimeout(() => {
      research_input.disabled = false
       // research_label.innerHTML = currentContent;
      document.querySelector('textarea[name="message"]').scrollIntoView()
    }, 2000);
   

    document.querySelector('#file-name').innerText=research_file.name
    document.querySelector('#file-size').innerText=  Math.round(research_file.size/1000) < 1000 
                                     ? Math.round(research_file.size/1000)+" KB"
                                     : Math.round(research_file.size/1000)+" MB"

    document.querySelector('#file-box').classList.remove('d-none')
    const reader = new FileReader()

reader.addEventListener('load', function(event) {
    let research_label = document.querySelector('label[for="research-file"]')
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
    document.querySelector('#research-file').value = '';
    document.querySelector('#file-box').classList.add('d-none')
    document.querySelector('#upload-progress .progress-bar').style.width="0%"
    document.querySelector('#file-name').innerText=''
    document.querySelector('#file-size').innerText=''
    let research_label = document.querySelector('label[for="research-file"]')
    research_label.innerHTML =`<i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>`
    
  }
  function changeTextDirection(event){

    event.preventDefault();

    let inputMessage = document.querySelector('textarea[name="message"]')

    if(event.target.classList.contains('fa-align-right')){
        inputMessage.classList.remove('text-right')
        inputMessage.classList.add('text-left')

        event.target.classList.remove('fa-align-right')
         event.target.classList.add('fa-align-left')
       
    }else{
        inputMessage.classList.remove('text-left')
        inputMessage.classList.add('text-right')

        event.target.classList.remove('fa-align-left')
         event.target.classList.add('fa-align-right')
    }
  }
  function replaceURLWithHTMLLinks(text)
    {
      var exp = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
      return text.toString().replace(exp,`<a href="$1">$1</a>`);
    }
    function isRTL(s){           
    var ltrChars    = 'A-Za-z\u00C0-\u00D6\u00D8-\u00F6\u00F8-\u02B8\u0300-\u0590\u0800-\u1FFF'+'\u2C00-\uFB1C\uFDFE-\uFE6F\uFEFD-\uFFFF',
        rtlChars    = '\u0591-\u07FF\uFB1D-\uFDFD\uFE70-\uFEFC',
        rtlDirCheck = new RegExp('^[^'+ltrChars+']*['+rtlChars+']');

    return rtlDirCheck.test(s);
}
</script>

@endsection
@section('content')

<style>
    
    /*#journals-researches{*/
    /*    color: #007bff;*/
    /*    font-size: 18px !important;*/
    /*}*/
    
    /*#journals-researches .title {*/
    /*    color: #007bff;*/
    /*    font-size: 20px !important;*/
    /*}*/
    
    .status{
        padding: 0 20px;
        font-size: 17px !important;
    }
    .bolld{
        font-weight: 600 !important;
    }
    .ico{
        font-size:12px !important;
    }
    
    .message-s {
        display: flex;
        justify-content: flex-start;
        flex-diretion: column;
    }
    
.message-r {
  display: flex;
  justify-content: flex-end;
}
.left-side-boxes{
    margin-top: 1rem;
}
@media(min-width:992px){
    /*
    .roww{
        width:50% !important
    }
    */ 
    .left-side-boxes{
        margin-top: 0;
    }
    
}
.bg-primary.text-white a{
    color: #fff;
}
#actions-dropdown .dropdown-menu.show  {
    margin: 0
}
.left-side-boxes .card-body button{
    min-width: 52px;
}
.left-side-boxes hr{
    width: 110%;
    margin-right: -5%;
    margin-bottom: 2rem;
}
#chat-container .bg-primary a{
  color: #fff
}
#chat-container .bg-primary a:hover{
  color: #fff;    font-weight: 600;
}
.chat-item{
  padding: 0 5px;
  overflow: hidden;
  margin-top: 15px;
}
.p-1.5{padding: .45rem!important;}
.user-img img{
  /* position: relative;
    top: -3px; */
    width: 45px; 
}
.date .fa-clock{
  position:relative; top: 1px;width: auto !important;
}
.user-name{
    font-size: 14px;
    margin: 6px;
    font-weight: bold;
}
.chat {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    z-index: 2;
    box-sizing: border-box;
    border-radius: 1rem;
    background: white;
}
.chat .messages {
    padding: 1rem;
    flex-shrink: 2;
    overflow-y: auto;
}
.messages .time {
    font-size: 0.8rem;
    background: #EEE;
    padding: 0.25rem 1rem;
    border-radius: 2rem;
    color: #999;
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    margin: 0 auto;
}
.messages .message {
    box-sizing: border-box;
    padding: 0.5rem 1rem;
    margin: 1rem auto 1rem 1rem;
    background: #FFF;
    border-radius: 1.125rem 1.125rem 1.125rem 0;
    min-height: 2.25rem;
    width: -webkit-fit-content;
    width: -moz-fit-content;
    width: fit-content;
    max-width: 66%;
    box-shadow: 0 0 2rem rgba(0, 0, 0, 0.075), 0rem 1rem 1rem -1rem rgba(0, 0, 0, 0.1);
}
    .messages .message.sender {
    margin: 1rem 1rem 1rem auto;
    border-radius: 1.125rem 1.125rem 0 1.125rem;
    background: #333;
    color: white !important;
}
.messages .message.file{
    font-size: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}
.messages .message.file svg{
    width: unset !important;
    font-size: unset !important;
}
</style>


   
    <div class="clearfix"></div>
    <div class="result"></div><!-- Result Box -->


    <section id="journals-researches" class="mb-5 mt-3">
        <div class="row justify-content-center">

            <div class="col-12">
                @if (session()->has('deleteMessage'))
                    <div class="alert  box-success alert-dismissible fade show" role="alert">
                        {{ session()->get('deleteMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
            
            
            <div class="container p-1.5">
                <div class="row justify-content-center">
                    <div class="col-sm-12  col-lg-7">
                        <div class="card" id="chat2">
                            <div class="card-header d-flex justify-content-between align-items-center p-3">
                              <h5 class="mb-0">الرسائل</h5>
                             
                            </div>
                            <div class="card-body p-0" id="chat-container" data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px;overflow-y:scroll">
                                <div class="chat">
                                    <div class="messages" id="chats">
                                        {{-- <div class="time">
                                            Today at 11:41
                                        </div> --}}

                                        @foreach ($messages as $message)
                                            @if ($message->sender=='admin')
                                                <div class="message sender">
                                                    {{ $message->message }}
                                                </div>
                                            @elseif ($message->sender=='user')
                                                <div class="message receved">
                                                    {{ $message->message }}
                                                </div>
                                            @endif
                                        @endforeach
                                        
                                        {{-- <div class="message receved">
                                            وعليكم السلام ورحمة الله وبركاته
                                        </div>
                                        <div class="message sender">
                                            رمضان كريم وكل عام وانتم بخير
                                        </div>
                                        <div class="message sender">
                                            ينعاد عليكم بالفرح
                                        </div>
                                        <div class="message receved">
                                            وانتم بخير بارك الله فيكم
                                        </div> --}}


                                        {{-- <div class="message sender file">
                                            <i class="fa-solid fa-folder-closed"></i>
                                        </div> --}}


                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-muted d-flex justify-content-end align-items-center p-3">
            
                              <textarea type="text" name="message" required minlength="2" class="form-control form-control-lg" id="exampleFormControlInput1"
                                placeholder="ادخل الرسالة"></textarea>
                                {{-- upload file --}}
                                
                                 <label for="research-file" class="m-0"  data-mdb-ripple-color="dark">
                                    <i class="fa fa-file-upload mr-3" id="file-uploader" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;    position: relative;top: 4px;"></i>
                                   
                                  </label>
                                  <input id="research-file" type="file" name="file" onchange="showFileName()" class="d-none" accept="*">

                                {{-- direction --}}
                                <i class="fa fa-align-right mr-3" id="direction-btn" onclick="changeTextDirection(event)" style="font-size: 23px;cursor:pointer;
                                margin: 0 2px;"></i>
                                {{-- submit message --}}
                              <a class="" href="#!" id="submit-msg-btn"><i class="fas fa-paper-plane" style="font-size: 23px;position: relative;
                                top: 4px;
                                margin: 0 9px;"></i></a>
                                <div class="spinner-border text-primary mr-2 d-none" role="status" id="spin-loader">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="card-footer p-3 d-none" id="file-box">
                                <div class="d-flex justify-content-between mx-3 mb-2 align-items-center" style="font-size: 13px;">
                                    <span class="d-block d-md-flex" style="flex: 1">
                                        <span id="file-name" class="mx-2 font-weight-bold">ملف.ييخؤس</span>
                                        <span class="mx-2 mx-md-0">حجم الملف : <strong id="file-size">25kb</strong></span>
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
            </div>
            </div>

        </div>
    </section>
<script>
    window.scrollTo(0, document.body.scrollHeight || document.documentElement.scrollHeight);

</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>

<script>
    $('#submit-msg-btn').on('click',function(){
      var message=$('#exampleFormControlInput1').val();
      var html=`<div class="message sender">
                        ${message}
                </div>`;
                
        $('#chats').append(html);
        $.ajax({
            "url":"{{ Route('adminSendMessage') }}",
            "type":"post",
            "data":{
                "_token": "{{ csrf_token() }}",
                "message":message,
                "email":"{{ $message_email->user_email }}"
            },
            success:function(response){
                
            }

        });

    });
</script>
<script src="https://js.pusher.com/7.2/pusher.min.js"></script>

<script>
    Pusher.logToConsole = false;

var pusher = new Pusher("{{env('PUSHER_APP_KEY')}}", {
  cluster: 'eu'
});

let userId = "{{ auth('admin')->user()->id }}";
var channel = pusher.subscribe('research-chat.'+userId);
channel.bind('research-chat-message', function(data) {
  let message = data.message
  var push_html=` <div class="message receved">
                        ${message}
                    </div>`
    $('#chats').append(push_html);
    // document.querySelector("#chats").scrollTo(0, document.querySelector("#chats").scrollHeight);
});
</script>


@endsection
