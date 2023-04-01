@extends('admin.layouts.master')
@section('title', $pageTitle)
@section('content')
<style>
    .chip {
        display: inline-block;

        border-radius: 19px;
        background-color: #f1f1f1;
    }

    .chip i,
    .chip .svg-inline--fa {
        cursor: pointer;
    }
</style>
<section id="section" class="py-5 mt-5">
    <div class="container">
        <div class="row ">

            <div class="col-12 mb-4">
                <h5 class="page-name">{{ $pageTitle }}</h5><!-- Page Name -->
            </div>
            <div class="col-lg-9 mx-auto">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box-white p-3">
                            <div class="result"></div><!-- Result Box-->
                            @if (session()->has('successMsg'))
                            <div class=" alert alert-success text-center">{{ session()->get('successMsg') }}
                            </div>
                            @endif
                            <form class="form" id="form-create-users-researches"
                                action="{{ route('admin_update_research',['id'=>$research->id]) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <label class="required">عنوان البحث</label>
                                    <input value="{{$research->title}}" type="text" name="title" class="form-control"
                                        required>
                                </div><!-- title -->
                                <div id="title-error" class="alert alert-danger d-none" role="alert">

                                </div>


                                <div class="form-group">
                                    <label class="required" id="keywords-notice">الكلمات المفتاحية ( يرجى كتابة الكلمة
                                        والضغط على زر Enter )</label>
                                    <textarea name="keywords" class="form-control" cols="30" rows="3"
                                        id="keywords-input"></textarea>
                                    <div class="mt-2" id="keywords-list">
                                        @forelse($keywords as $word)
                                        <div class="chip mx-1 p-1 px-2 mt-1 keyword-element">
                                            <span>
                                                {{$word}}
                                            </span>
                                            <span class=" mx-1 ml-2 font-weight-bold" style="    font-size: 15px;
                                                 cursor: pointer;">X</span>
                                        </div>
                                        @empty
                                        @endforelse

                                    </div>
                                </div><!-- keywords -->
                                <input value="{{$research->keywords}}" type="hidden" name="keywords_final"
                                    id="keywords_final">



                                <div class="form-group">
                                    <label class="required">ملخص البحث</label>
                                    <textarea id="abstract" name="abstract" class="form-control" cols="30" rows="10"
                                        required></textarea>
                                </div><!-- abstract -->



                                <div class="form-group">
                                    <label class="required">نوع البحث</label>
                                    <select value="{{$research->type}}" name="type" class="form-control" required>
                                        <option {{$research->type ? '' : 'selected'}} disabled>اختر</option>
                                        @foreach($types as $key => $type)
                                        <option {{$research->type == $key ? 'selected' : ''}} value="{{$key}}">{{$type}}
                                        </option>
                                        @endforeach
                                        {{-- <option value="1">مقيد الوصول</option>
                                        <option value="0">مفتوح المصدر</option> --}}
                                    </select>
                                </div><!-- type -->



                                <div class="form-group">
                                    <label class=" required">اختر مجلة للنشر</label>
                                    <select name="journal" class="form-control" required>
                                        <option selected disabled>اختر</option>
                                        @foreach ($journals as $jour)
                                        <option {{$research->journal_id == $jour->id ? 'selected' : ''}} value="{{
                                            $jour->id }}">{{ $jour->name }}</option>
                                        @endforeach
                                    </select>
                                </div><!-- journal -->



                                <div class="form-group mb-4">
                                    <label class="required">ملف البحث</label>
                                    <input type="file" name="file" accept=".doc,.docx" class="form-control">
                                    <small class="d-block text-left text-muted">انواع الملفات (doc/docx) فقط هي التي يتم
                                        قبولها</small>
                                </div><!-- file -->


                                <div class="form-group mb-2">
                                    {{-- <button onclick="submitOrder(event)" class="btn-main btn-block">ارسال</button>
                                    --}}
                                    <button id="submit_button" type="submit" class="btn-main btn-block" onclick="setKeywordsVal()"
                                        onmouseover="validateKeywords(event)">ارسال</button>
                                </div>

                            </form>
                        </div>
                    </div><!-- End Content -->

                </div>



            </div>






        </div>
    </div>
</section>
@endsection
@section('js')
<script>
    document.getElementById('abstract').value = {{Js::from($research->abstract)}};

    var keywords = {{ Js::from($keywords) }}
    
    
 var keywords_final = document.querySelector('#keywords_final')
 var keywordslist  = document.querySelector('#keywords-list')

 if(keywords.length == 0){
     $(':input[type="submit"]').prop('disabled', true);
     document.querySelector('#keywords-input').style.border="1px solid red";
    }
    $('#keywords-input').keydown(function(e) {
        if (e.keyCode === 13) {


            let value = event.target.value.trim()
            if(value.length && value != " " && value != ""){
                console.log('here');
                keywords.push(value);

            keywordslist.innerHTML+=
            `<div class="chip mx-1 p-1 px-2 mt-1 keyword-element" >
                <span>
                ${value}
                </span>
                <span class=" mx-1 ml-2 font-weight-bold" style="    font-size: 15px;
                     cursor: pointer;">X</span>
            </div>`
             keywords_final.value =keywords.join(',')
            }
            $(this).val('').focus()


        }
        console.log(keywords.length)
        if(keywords.length > 0 ){
            document.querySelector('#keywords-input').style.border="1px solid #ced4da";
            $(':input[type="submit"]').prop('disabled', false);
        }
    });

$(document).on('click','.keyword-element span',function(event){
    let content = event.target.parentNode.children[0]
    console.log(content);
    for (let word of keywords){
        if(content.innerText.trim() == word){
            console.log(word)
            keywords.splice(keywords.indexOf(word),1)
            break;
        }
    }

        keywords_final.value =keywords.join(',')
        event.target.parentNode.parentNode.removeChild(event.target.parentNode)
        if(keywords.length == 0){
            $(':input[type="submit"]').prop('disabled', true);
            document.querySelector('#keywords-input').style.border="1px solid red";
        }
})
function setKeywordsVal(){
    keywordslist.innerHTML=''
}
function validateKeywords(event){
    console.log('yes I am here');
    if(keywords_final.value ==''){
        event.target.disabled =true
        document.querySelector('#keywords-input').style.border="1px solid red";

    }else{
        event.target.disabled = false
         document.querySelector('#keywords-input').style.border="1px solid #ced4da";
    }
}
//if small media or mobile app
var isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);
if (isMobile) {
  document.querySelector('#keywords-notice').innerText=">الكلمات المفتاحية ( يرجى كتابة الكلمة والضغط مرتين على زر Enter )"
}



</script>

@endsection
