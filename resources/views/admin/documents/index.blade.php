@extends('admin.layouts.master')
@section('title', 'المستندات')
@section('css')
{{-- select picker for admin adding research page --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="{{ asset('assets/css/simple-lightbox.min.css') }}" />

@endsection
@section('content')
<style>
    .dropdown-menu {
        margin-left: 0px;
        max-width: 100% !important;
    }

    select {
        width: 100%;
        text-overflow: ellipsis !important;
    }

    option {
        max-width: 300px;
        text-overflow: ellipsis !important;
    }
</style>

<div class="links-bar my-4 ">
    <h4>المستندات</h4>
</div><!-- End Bar Links -->

{{-- <div class="result"></div> --}}

<div id="freelancers">
    <div class="row">

        <div class="col-12 mb-3">
            <div class="box-white">
                <form action="{{route('admin.documents')}}" method="GET">
                    <div class="row align-items-center">
                        <div class="col-lg-8">

                            <select assets_base_url="{{asset('assets/uploads/users-documents/')}}"
                                delete_link="{{route('admin.delete_document')}}"
                                search-link="{{route('admin.get_documents')}}" id="search_by_mail" data-width="100%"
                                name="search" class="selectpicker form-control search_select" data-live-search="true"
                                required>
                                <option>ابحث بواسطة البريد الالكتروني</option>
                                @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->email}}</option>
                                @endforeach
                                {{-- <option value="1">مقيد الوصول</option>
                                <option value="0">مفتوح المصدر</option> --}}
                            </select>

                        </div><!-- type -->
                        {{-- <div class="col-lg-8">
                            <input type="email" name="search" class="form-control form-control-sm"
                                placeholder="ابحث بواسطة البريد الالكتروني" value='@isset($_GET[' search']) {{
                                $_GET['search'] }} @endisset' />
                        </div> --}}

                        <div class=" col-lg-2 mt-2 mt-lg-0">
                            <a href="{{route('admin.documents')}}" class="btn btn-light btn-block border">إعادة
                                تعيين</a>
                        </div>
                        <div class=" col-lg-2 mt-2 mt-lg-0">
                            <a data-toggle="modal" data-target="#add-document-modal" href="#"
                                class="btn btn-primary btn-block border">اضافة وثيقة</a>
                        </div>


                    </div>
                </form>
                <div class="modal fade" id="add-document-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title" id="exampleModalLabel">اضافة مستند جديد</h5>
                            </div>
                            <div class="modal-body">
                                <div class="box-white" style="border: none; padding: 0px;">

                                    <form class="form" action="{{ route('admin.store_documents') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="result"></div>
                                        <div class="form-group">
                                            <label class="required">البريد الالكتروني للعميل</label>
                                            <div class="form-group col-12-sm ">

                                                <select get_researches_link="{{route('admin.get_user_researches')}}"
                                                    id="user_id_form" data-width="100%" name="user_id"
                                                    class="selectpicker form-control search_select"
                                                    data-live-search="true" required>
                                                    <option>اختر</option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                                    @endforeach
                                                    {{-- <option value="1">مقيد الوصول</option>
                                                    <option value="0">مفتوح المصدر</option> --}}
                                                </select>
                                            </div>

                                        </div><!-- type -->
                                        <div class="form-group">
                                            <label class="required">البحث الخاص بالعميل</label>
                                            <div class="form-group col-12-sm ">

                                                <select id="user_researches" data-width="100%" name="user_research"
                                                    class="selectpicker form-control search_select"
                                                    data-live-search="true" required>
                                                    <option>اختر</option>
                                                </select>
                                            </div>

                                        </div><!-- type -->

                                        <div class="form-group">
                                            <label class="required">اسم الوثيقة</label>
                                            <input type="text" name="document_name" class="form-control" required>
                                        </div><!-- title -->
                                        <div class="form-group">
                                            <label class="required">PDF</label>
                                            <input accept=".pdf" type="file" name="document_pdf" class="form-control"
                                                required>
                                        </div><!-- title -->
                                        <div class="form-group">
                                            <label class="required">الصورة</label>
                                            <input accept=".png,.jpeg,.jpg" type="file" name="document_photo"
                                                class="form-control" required>
                                        </div><!-- title -->
                                        <hr>
                                        <button type="submit" class="btn-main btn-block">اضافة الوثيقة</button>

                                    </form><!-- End Form -->
                                </div>


                            </div>
                            {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-primary">حفظ</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                {{-- update modal form --}}
                <div class="modal fade" id="edit-document-modal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات المستند </h5>
                            </div>
                            <div class="modal-body">
                                <div class="box-white" style="border: none; padding: 0px;">
                                    <div class="result"></div>
                                    <form class="form" action="{{route('admin.update_document')}}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <label class="required">البريد الالكتروني للعميل</label>
                                            <div class="form-group col-12-sm ">

                                                <select get_researches_link="{{route('admin.get_user_researches')}}"
                                                    id="edit_user_id_form" data-width="100%" name="user_id"
                                                    class="selectpicker form-control search_select"
                                                    data-live-search="true" required>
                                                    <option>اختر</option>
                                                    @foreach($users as $user)
                                                    <option value="{{$user->id}}">{{$user->email}}</option>
                                                    @endforeach
                                                    {{-- <option value="1">مقيد الوصول</option>
                                                    <option value="0">مفتوح المصدر</option> --}}
                                                </select>
                                            </div>

                                        </div><!-- type -->
                                        <div class="form-group">
                                            <label class="required">البحث الخاص بالعميل</label>
                                            <div class="form-group col-12-sm ">

                                                <select id="edit_user_researches" name="new_user_research"
                                                    class="form-group" required>

                                                </select>
                                            </div>

                                        </div><!-- type -->

                                        <div class="form-group">
                                            <label class="required">اسم الوثيقة</label>
                                            <input id="edit_document_name" type="text" name="edit_document_name"
                                                class="form-control" required>
                                        </div><!-- title -->
                                        <div class="form-group">
                                            <label class="required">PDF</label>
                                            <input accept=".pdf" type="file" name="document_pdf" class="form-control">
                                        </div><!-- title -->
                                        <div class="form-group">
                                            <label class="required">الصورة</label>
                                            <input accept=".png,.jpeg,.jpg" type="file" name="document_photo"
                                                class="form-control">
                                        </div><!-- title -->
                                        <hr>
                                        <input value="" id="current_document_id" type="hidden"
                                            name="current_document_id">
                                        <button type="submit" class="btn-main btn-block">تحديث الوثيقة</button>

                                    </form><!-- End Form -->
                                </div>


                            </div>
                            {{-- <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                                <button type="button" class="btn btn-primary">حفظ</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (count($documents) == 0)
        <div class="col-12">
            <div class="box-white py-5">
                <h5 class="mb-0 text-center">لا يوجد وثائق !</h5>
            </div>
        </div>
        @else
        <div class="col-12 mb-4">
            <div class="box-white table-responsive">
                <table class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                    <thead class="thead-inverse">
                        <tr>
                            <th>الاسم</th>
                            <th class="d-none d-sm-table-cell">اسم المستخدم</th>
                            <th>عنوان البحث</th>
                            <th class="d-none d-sm-table-cell">pdf</th>
                            <th>png</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td class="d-none d-sm-table-cell">{{ $row->user->name }}</td>
                            <td>{{ $row->research->title }}</td>
                            <td class="d-none d-sm-table-cell">
                                <a target="_blank" class="btn btn-success"
                                    href="{{asset('assets/uploads/users-documents/'.$row->pdf)}}" role="button">PDF</a>
                            </td>
                            <td>
                                <a target="_blank" class="btn btn-success d-bloc d-sm-none"
                                    href="{{asset('assets/uploads/users-documents/'.$row->pdf)}}" role="button">PDF</a>
                                <a class="image-{{$row->id}} gallery btn btn-success"
                                    href="{{asset('assets/uploads/users-documents/'.$row->photo)}}" role="button">
                                    <img class="d-none" src="{{asset('assets/uploads/users-documents/'.$row->photo)}}"
                                        alt="">
                                    الصورة</a>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-dark  dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-lg"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a data-toggle="modal" data-target="#edit-document-modal"
                                            onclick="editDocument(event,this)" document_name="{{$row->name}}"
                                            user_id="{{$row->user->id}}" document_id="{{$row->id}}"
                                            research_id="{{$row->research->id}}" class="dropdown-item"
                                            href="#">تعديل</a>
                                        <a document_id="{{$row->id}}" delete_link="{{route('admin.delete_document')}}"
                                            onclick="confirmDelete(event,this)" class="dropdown-item" href="#">حذف</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
       

    </div><!-- row -->
</div><!-- freelancers -->




@endsection
@section('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
{{-- <script src="{{ asset('assets/js/simple-lightbox.js') }}"></script> --}}
<script src="{{ asset('assets/js/simple-lightbox.jquery.js') }}"></script>
{{-- <script src="{{ asset('assets/js/jquery-plugin-wrap.js') }}"></script> --}}

<script>
    var wasLoaded = false;
    var images = document.querySelectorAll('.gallery');
    $(function () {
        // bind image <a> with lightbox library
        for (const image of images){
            console.log(image.classList[0])
            $('.'+image.classList[0]).simpleLightbox()
        }
        // $('.gallery ').simpleLightbox()
        $('.search_select').selectpicker();
        $('#user_researches').selectpicker();
        $('#edit_user_id_form').selectpicker();
        // $('#edit_user_researches').selectpicker();
        // get user researches
        $('#user_id_form').on('change', function(){
            let user_id = $(this).val();
            let link = $(this).attr("get_researches_link");

            $.ajax({
                type: "POST",
                url: link,
                data: {user_id: user_id},
                dataType:"json",

                success: function (response) {
                    let researchesList = response.researches;
                    $("#user_researches").empty();
                    $("#user_researches").append(new Option('اختر', ''));
                    $('#user_researches').selectpicker('refresh');
                    for ( const research_id in researchesList){
                        $("#user_researches").append(new Option(researchesList[research_id], research_id));
                    }
                    $('#user_researches').selectpicker('refresh');

                }
            });
        });
        // getting user researches in the edit form
        $('#edit_user_id_form').on('change', function(){
            if(wasLoaded){

            let user_id = $(this).val();
            let link = $(this).attr("get_researches_link");

            $.ajax({
                type: "POST",
                url: link,
                data: {user_id: user_id},
                dataType:"json",

                success: function (response) {
                    let researchesList = response.researches;
                    $("#edit_user_researches").empty();
                    $("#edit_user_researches").append(new Option('اختر', ''));
                    // $('#user_researches').selectpicker('refresh');
                    for ( const research_id in researchesList){
                        $("#edit_user_researches").append(new Option(researchesList[research_id], research_id));
                    }
                    // $('#user_researches').selectpicker('refresh');

                }
            });
        }

        });



        // search users
        $('#search_by_mail').on('change', function(){
            let user_id = $(this).val();
            let link = $(this).attr("search-link");
            let delete_link = $(this).attr("delete_link");
            let assets_base_url = $(this).attr("assets_base_url");

            $.ajax({
                type: "POST",
                url: link,
                data: {user_id: user_id},
                dataType:"json",

                success: function (response) {
                    let documentsList = response.documents;
                    console.log(documentsList);
                    $("tbody").empty();

                    for ( const document_id in documentsList){
                        console.log(documentsList[document_id]['name'])
                        // console.log(`research number ${research_id} is ${documentsList[research_id]}` )
                        // $("tbody").append(new Option(documentsList[document_id], document_id));
                        // $('.table tr:last').after(`<tr>${documentsList[document_id]['name']}</tr>`);
                        $("tbody").append(`<tr><td>${documentsList[document_id]['name']}</td>
                                            <td>${documentsList[document_id]['user_name']}</td>
                                            <td>${documentsList[document_id]['research_name']}</td>
                                            <td>
                                                <a target="_blank" class="btn btn-success" href="${assets_base_url}/${documentsList[document_id]['pdf']}" role="button">PDF</a>
                                            </td>
                                            <td>
                                                    <a  class="image-${document_id} gallery btn btn-success" href="${assets_base_url}/${documentsList[document_id]['photo']}" role="button">
                                                        <img class="d-none" src="${assets_base_url}/${documentsList[document_id]['photo']}" alt="">
                                                        الصورة</a>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-outline-dark  dropdown-toggle"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v fa-lg"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a data-toggle="modal" data-target="#edit-document-modal"
                                                            onclick="editDocument(event,this)" document_name="${documentsList[document_id]['name']}"
                                                            user_id="${documentsList[document_id]['user_id']}" document_id="${document_id}"
                                                            research_id="${documentsList[document_id]['research_id']}" class="dropdown-item"
                                                            href="#">تعديل</a>
                                                        <a document_id="${document_id}" delete_link="${delete_link}"
                                                            onclick="confirmDelete(event,this)" class="dropdown-item" href="#">حذف</a>
                                                    </div>
                                                </div>
                                            </td>
                                            </tr>`
                            );

                    }

                    for (const image of images){
                        console.log(image.classList[0])
                        $('.'+image.classList[0]).simpleLightbox()
                    }
                }
            });
        });


    });


        function confirmDelete(event,data){
            event.preventDefault();
            let document_id = data.getAttribute('document_id')
            let link = data.getAttribute('delete_link')
            console.log(document_id)
            swal({
                title: "هل أنت متأكد من حذف المستند",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type:"POST",
                        url: link ,
                        data: {document_id:document_id},
                        daraType:"json",
                        success: function(){
                            swal("تم حذف الملف بنجاح", {
                            icon: "success",
                            });
                            setTimeout(function () {
                                location.reload();
                            },1000);
                        },
                        error: function(){
                            swal("هذا الملف غير موجود", {
                            icon: "error",
                            });
                        }
                    })
                }
            })

    }

    function editDocument(event, data){
        wasLoaded = false;
        let document_id = data.getAttribute('document_id');
        let document_name = data.getAttribute('document_name');
        let current_user_id = data.getAttribute('user_id');
        let current_research_id = data.getAttribute('research_id');
        console.log([document_id,document_name,current_user_id,current_research_id])

        $('#current_document_id').val(document_id);




            let link = $('#edit_user_id_form').attr("get_researches_link");

            $.ajax({
                type: "POST",
                url: link,
                data: {user_id: current_user_id},
                dataType:"json",

                success: function (response) {
                    let researchesList = response.researches;
                    $("#edit_user_researches").empty();
                    $("#edit_user_researches").append(new Option('اختر', ''));
                    // $('#edit_user_researches').selectpicker('refresh');
                    for ( const research_id in researchesList){
                        let selected = research_id == current_research_id ? true : false;
                        $("#edit_user_researches").append(new Option(researchesList[research_id], research_id, selected, selected));
                    }
                    // $('#edit_user_researches').selectpicker('refresh');

                }
            });

            $("#edit_document_name").val(document_name);

        // $(`#edit_user_id_form option[value=${user_id}]`).prop('selected',true);
        $("#edit_user_id_form").val(current_user_id).change();
        $('#edit_user_id_form').selectpicker('refresh');


        // $(`#edit_user_researches option[value=${current_research_id}]`).prop('selected',true);
        $("#edit_user_researches").val(current_research_id).change();
        // $('#edit_user_researches').selectpicker('refresh');
        // $('select[name=new_user_research]').val(current_research_id);
        // let example = document.getElementById('edit_user_researches')
        // example.value = current_research_id
        // console.log(example);
        // $('#edit_user_researches').selectpicker('refresh');

        wasLoaded = true;

    }

    $('.box-error').on('load',function(){
        setTimeout(function () {
            location.reload();
        },1000);
    })

    document.addEventListener('reloadingError', function(){
        setTimeout(function () {
            location.reload();
        },1000);
    })
</script>

@endsection
