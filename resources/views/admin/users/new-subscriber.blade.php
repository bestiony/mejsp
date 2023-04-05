@extends('admin.layouts.master')
@section('title', 'إضافة مشتركين')
@section('css')
<style>
.alert-box.message{
    background-color: #fff;
	display:none;}
</style>
@endsection
@section('content')
  <div class="links-bar my-4">
      <h4>إضافة مشتركين</h4>
  </div>

    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="form-group">@csrf
                    <label for="emails">اكتب بريد إلكتروني واحد في كل سطر</label>
                    <!-- <input class="form-control" name="emails" type="text"> -->
                    <textarea class="form-control" id="emails" name="emails" rows="10"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" role="button" class="btn btn-primary add">إضافة </button>
                </div>
            </div>
        </div>
    </div>
  <div class="alert-box message">
	<h2 class="swal2-title" id="swal2-title" style="display: block;">تم الاضافة بنجاح</h2>
	<div class="swal2-html-container" id="swal2-html-container" style="display: block;">
		<h4>
			<span class="successful">
				الإضافات الناجحة:
				<span></span>
			</span>
			<span class="failed">الإضافات الفاشلة: 
				<span></span>
			</span>			
        </h4>
		
        <table class="table res">
			
		</table>
    </div>
  </div>
  @endsection
  @section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  $('.add').click(function(){

		var emails = $('#emails').val().split('\n');
		$.ajax({
			url:"{{ Route('add.subscribers') }}",
			type:"post",
			data:{
				'emails':emails
			},
			success:function(response){
				$('span.successful span').html(response.successful.length);
				$('span.failed span').html(response.failed.length);
				$.each(response.successful, function(index, value) {
					
					$('table.res').append(
						'<tr><td>' + value + '</td><td>' +
						'<svg class="svg-inline--fa fa-check" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""><path fill="currentColor" d="M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z"></path></svg>' + 
						'</td></tr>'
					);
				});
				
				$.each(response.failed, function(index, value) {
					
					$('table.res').append(
						'<tr><td>' + value + '</td><td>' +
						'<svg class="svg-inline--fa fa-xmark" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg=""><path fill="currentColor" d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"></path></svg>' + 
						'</td></tr>'
					);
				});
				$('.alert-box.message').toggle();
				//$('div.message').html("<p>" + " تم إضافة " + response.successful + " بنجاح " + "</p><p>" + " فشل إضافة " + response.failed + "</p>");
			}
		});
	});
	</script>
@endsection
