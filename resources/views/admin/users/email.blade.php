@extends('admin.layouts.master')
@section('title', 'إنشاء حملة ')
@section('css')
<style>
div.hidden{display:none;}
div.info-msg{
	color: #ffffff;
    max-height: 84px;
    margin-top: 33px;
    padding-top: 25px;}
.green{background:#05e7a8;}
.red{background:#e70505;}
.flexable{display:flex;}
div.info-msg.main{display:none}
</style>
@endsection
@section('content')
  <div class="links-bar my-4">
      <h4>إنشاء حملة</h4>
						
  </div>

  <form action="{{ route('subscribers.send.email') }}" method="post" enctype="multipart/form-data"> @csrf
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8">
            <div class="box-white">
                <div class="form">
                    <div class="form-group">
                        <label class="required" for="logo">logo</label>
                        <input class="form-control" type="file" name="logo" >
                    </div>

                    <div class="form-group">
                        <label class="required" for="name_of_email">اسم البريد الإلكتروني</label>
                        <input class="form-control" name="name_of_email" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="subject">subject</label>
                        <input class="form-control" name="subject" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="publication_terms"> رابط شروط النشر</label>
                        <input class="form-control" name="publication_terms" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="judgement_comity">رابط لجنة التحكيم</label>
                        <input class="form-control" name="judgement_comity" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="journal_name">اسم المجلة</label>
                        <input class="form-control" name="journal_name" type="text">
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_one">النص تحت اسم المجلة</label>
                        <input class="form-control" type="text" name="text_one">
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_two">ISSN</label>
                        <input class="form-control" type="text" name="text_two" >
                    </div>

                    <div class="form-group">
                        <label class="required" for="text_three">النص تحت ISSN</label>
                        <input class="form-control" type="text" name="text_three" >
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" role="button" class="btn-main btn-block main">إطلاق الحملة</button>
					  <button type="button" role="button" class="btn-main btn-block test"> إرسال بريد تجريبي </button>
					  <input type="hidden" name="testormain" value="0" />
					  <div class="form-group info-msg main">
		
						</div>
					</div>
					
                    <div class="form-group col-12 hidden">
						<div >
							<div class="form-group">
								<label for="emails">إضافة المستلمين</label>
								<textarea class="form-control" name="emails" rows="3"></textarea>
								<small id="emailsHelpBlock" class="form-text text-muted">
									للإرسال لأكثر من حساب قم بإضافة بريد إلكتروني واحد في كل سطر
								</small>
							</div>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
							<button type="submit" class="btn btn-primary send-mail">إرسال</button>
							
							<div class="form-group info-msg">
		                    
							</div>
						</div>
						
                    </div>
					
                </div>
            </div>
        </div>
    </div>
  </form>
  
@endsection
@section('js')

<script>
	$('document').ready(function(){
		$('button.test').click(function(){$('div.hidden').show('slow'); $('div.info-msg.main').hide('slow');});
		$('button.send-mail').on('click', function (e) {
			
			$(this).parents("form").ajaxForm({ 
				complete: function(response) 
				{
					if(response.status == 200){
						$('div.info-msg').html("تم إرسال بريد تجريبي بنجاح");
						$('div.info-msg').removeClass("red");
						$('div.info-msg').addClass("green");
					}else{
						$('div.info-msg').html("فشل إرسال البريد التجريبي");
						$('div.info-msg').removeClass("green");
						$('div.info-msg').addClass("red");
					}
					$("textarea[name='emails']").val("");
				}
			});
		});
		
		$('button.main').on('click', function (e) {
			$('div.hidden').hide('slow');
			
			$("input[name='testormain']").val("0");
			$(this).parents("form").ajaxForm({ 
				complete: function(response) 
				{
					$('div.info-msg.main').show('slow');
					if(response.status == 200){
						$('div.info-msg.main').html("تم الإرسال");
						$('div.info-msg.main').removeClass("red");
						$('div.info-msg.main').addClass("green");
					}else{
						$('div.info-msg.main').html("فشل الإرسال");
						$('div.info-msg.main').removeClass("green");
						$('div.info-msg.main').addClass("red");
					}
				}
			});
		});
    });
</script>
@endsection
