@extends('admin.layouts.master')
@section('title', 'إرسال بريد ')
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
      <h4>إرسال بريد للقائمة البريدية</h4>
						
  </div>

  <form action="{{ route('subscribers.send.email') }}" method="post" enctype="multipart/form-data"> @csrf
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="row">
                    <div class="form-group col-6">
                        <label for="logo">logo</label>
                        <input class="form-control" type="file" name="logo" >
                    </div>

                    <div class="form-group col-6">
                        <label for="name_of_email">اسم البريد الإلكتروني</label>
                        <input class="form-control" name="name_of_email" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="subject">subject</label>
                        <input class="form-control" name="subject" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="publication_terms"> رابط شروط النشر</label>
                        <input class="form-control" name="publication_terms" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="judgement_comity">رابط لجنة التحكيم</label>
                        <input class="form-control" name="judgement_comity" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="journal_name">اسم المجلة</label>
                        <input class="form-control" name="journal_name" type="text">
                    </div>

                    <div class="form-group col-6">
                        <label for="text_one">النص تحت اسم المجلة</label>
                        <input class="form-control" type="text" name="text_one">
                    </div>

                    <div class="form-group col-6">
                        <label for="text_two">ISSN</label>
                        <input class="form-control" type="text" name="text_two" >
                    </div>

                    <div class="form-group col-6">
                        <label for="text_three">النص تحت ISSN</label>
                        <input class="form-control" type="text" name="text_three" >
                    </div>

                    <div class="form-group col-12">
                      <button type="submit" role="button" class="btn btn-primary main">إرسال للقائمة البريدية</button>
					  <button type="button" role="button" class="btn btn-primary test"> إرسال بريد تجريبي </button>
					  <input type="hidden" name="testormain" value="0" />
					  <div class="form-group col-6 info-msg main">
		
						</div>
					</div>
					
                    <div class="form-group col-12 hidden">
						<div class="flexable">
							<div class="form-group col-6">
								<label for="emails">إضافة المستلمين</label>
								<textarea class="form-control" name="emails" rows="3"></textarea>
								<small id="emailsHelpBlock" class="form-text text-muted">
									للإرسال لأكثر من حساب قم بإضافة بريد إلكتروني واحد في كل سطر
								</small>
							</div>
							<div class="form-group col-6 info-msg">
		
							</div>
						</div>
						<div class="form-group col-6 modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
							<button type="submit" class="btn btn-primary send-mail">إرسال</button>
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
		$('button.test').click(function(){$('div.hidden').toggle('slow');});
		$('button.send-mail').on('click', function (e) {
			$(this).parents("form").ajaxForm({ 
				complete: function(response) 
				{
					if(response.status == 200){
						$('div.info-msg').html("تم إرسال بريد تجريبي بنجاح");
						$('div.info-msg').removeClass("red");
						$('div.info-msg').addClass("green");
					}else{
						$('div.info-msg').html("فشل في إرسال البريد التجريبي");
						$('div.info-msg').removeClass("green");
						$('div.info-msg').addClass("red");
					}
					$("textarea[name='emails']").val("");
				}
			});
		});
		
		$('button.main').on('click', function (e) {
			$('div.hidden').toggle('slow');
			$('div.info-msg.main').toggle('slow');
			$("input[name='testormain']").val("0");
			$(this).parents("form").ajaxForm({ 
				complete: function(response) 
				{
					if(response.status == 200){
						$('div.info-msg.main').html("تمت المهمة بنجاح");
						$('div.info-msg.main').removeClass("red");
						$('div.info-msg.main').addClass("green");
					}else{
						$('div.info-msg.main').html("فشلت المهمة");
						$('div.info-msg.main').removeClass("green");
						$('div.info-msg.main').addClass("red");
					}
				}
			});
		});
    });
</script>
@endsection
