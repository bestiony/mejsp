@extends('admin.layouts.master')
@section('title', 'المستخدمين')
@section('css')
<style>
    .tags-input-wrapper{
    background: transparent;
    padding: 10px;
    border-radius: 4px;
    max-width: 400px;
    border: 1px solid #ccc
}
.tags-input-wrapper input{
    border: none;
    background: transparent;
    outline: none;
    width: 140px;
    margin-left: 8px;
}
.tags-input-wrapper .tag{
    display: inline-block;
    background-color: #138496;
    color: white;
    border-radius: 40px;
    padding: 0px 3px 0px 7px;
    margin-right: 5px;
    margin-bottom:5px;
    box-shadow: 0 5px 15px -2px  #dee2e6
}
.tags-input-wrapper .tag a {
    margin: 0 7px 3px;
    display: inline-block;
    cursor: pointer;
}
</style>
@endsection
@section('content')

    <div class="links-bar my-4 ">
        <h4>المشتركين</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div id="freelancers">
        <div class="row">

            <div class="col-12 mb-3">
                <div class="box-white">
                    <form action="{{ admin_url('users') }}" method="GET">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="email" name="search" class="form-control form-control-sm"
                                    placeholder="ابحث بواسطة البريد الالكتروني"
                                    value='@isset($_GET['search']) {{ $_GET['search'] }} @endisset' />
                            </div>

                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                <a href="{{ route('subscriber.restore') }}" class="btn btn-light btn-block border">إعادة تعيين</a>
                            </div>
                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                <button  type="button" data-toggle="modal" data-target="#exampleModal3" class="btn btn-light btn-block border">اضافة مشتركين</button>
                            </div>
                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                {{-- href="{{ route('subscribers.send.email') }}" --}}
                                <button type="button" class="btn btn-light btn-block border" data-toggle="modal" data-target="#exampleModal">ارسال</button>
                                {{-- <button data-toggle="modal" data-target="#exampleModal" class="btn btn-light" >ارسال</button> --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @if (count($subscribers) == 0)
                <div class="col-12">
                    <div class="box-white py-5">
                        <h5 class="mb-0 text-center">لا يوجد مشتركين !</h5>
                    </div>
                </div>
            @else
                <div class="col-12 mb-4">
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>البريد الالكتروني</th>
                                    <th>التعديل</th>
                                    <th>الحذف</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $row)
                                    <tr>
                                        <td>{{ $row->email }}</td>
                                        <td><button data-email="{{ $row->email }}" data-id="{{ $row->id }}" class="btn btn-info edit"><i class="fa fa-edit"></i> تعديل</button></td>
                                        <td><button data-id="{{ $row->id }}" class="btn btn-danger delete"><i class="fa fa-trash"></i> حذف</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div><!-- row -->
    </div><!-- freelancers -->

    <button id="edit" data-toggle="modal" data-target="#exampleModal1" class="d-none"></button>
    <button id="delete" data-toggle="modal" data-target="#exampleModal2" class="d-none"></button>

<form action="{{ route('subscribers.send.email') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">المشتركين</h5>
           
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="">اللوجو</label>
                    <input class="form-control" type="file" name="logo" >
                </div>
                <div class="form-group">
                    <label for="">اسم المجلة</label>
                    <input class="form-control" name="journal_name" type="text">
                    
                </div>

                <div class="form-group">
                    <label for="">النص الاول</label>
                    <input class="form-control" type="text" name="text_one">
                </div>
                <div class="form-group">
                    <label for="">النص الثاني</label>
                    <input class="form-control" type="text" name="text_two" >
                </div>
                <div class="form-group">
                    <label for="">النص الثالث</label>
                    <input class="form-control" type="text" name="text_three" >
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
        </div>
    </div>
</form>

<form action="{{ Route('add.subscribers') }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">المشتركين</h5>
           
            </div>
            <div class="modal-body">
                

                <div class="form-group">
                    <label for=""> اضافة المشتركين</label>
                    <input type="text" name="emails" id="tag-input1">
                </div>
                
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
            <button type="submit" class="btn btn-primary">حفظ</button>
            </div>
        </div>
        </div>
    </div>
</form>
<form action="{{ Route('subscriber.edit') }}" method="post">
<!-- Modal -->
    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModal1Label" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModal1Label">الاشتراكات</h5>
            {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            </div>
            <div class="modal-body">
                    @csrf
                    <input id="email_btn" type="email" name="email" class="form-control form-control-sm" />
                    <input id="id_btn" name="id" type="hidden">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
            <button type="submit" class="btn btn-primary">تعديل</button>
            </div>
        </div>
        </div>
    </div>
</form>



<form action="{{ Route('subscriber.destroy') }}" method="post">
    @csrf
    <!-- Modal -->
        <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModal2Label" aria-hidden="true">
            <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModal2Label">الاشتراكات</h5>
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
                </div>
                <div class="modal-body">
                        <h3>هل انت متاكد من الحذف</h3>
                        <input id="id_delete_btn" name="id" type="hidden">
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button>
                <button type="submit" class="btn btn-primary">حذف</button>
                </div>
            </div>
            </div>
        </div>
    </form>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
@if (Session::has('message'))
        Swal.fire('{{ Session::get("message") }}')
@endif
</script>
<script>
    $('document').ready(function(){
        $('.edit').on('click',function(){
            $('#email_btn').val($(this).data('email'));
            $('#id_btn').val($(this).data('id'));
            $('#edit').click();
        });
    });

    $('document').ready(function(){
        $('.delete').on('click',function(){
            $('#id_delete_btn').val($(this).data('id'));
            $('#delete').click();
        });
    });
</script>

<script>
    (function(){

"use strict"


// Plugin Constructor
var TagsInput = function(opts){
    this.options = Object.assign(TagsInput.defaults , opts);
    this.init();
}

// Initialize the plugin
TagsInput.prototype.init = function(opts){
    this.options = opts ? Object.assign(this.options, opts) : this.options;

    if(this.initialized)
        this.destroy();
        
    if(!(this.orignal_input = document.getElementById(this.options.selector)) ){
        console.error("tags-input couldn't find an element with the specified ID");
        return this;
    }

    this.arr = [];
    this.wrapper = document.createElement('div');
    this.input = document.createElement('input');
    init(this);
    initEvents(this);

    this.initialized =  true;
    return this;
}

// Add Tags
TagsInput.prototype.addTag = function(string){

    if(this.anyErrors(string))
        return ;

    this.arr.push(string);
    var tagInput = this;

    var tag = document.createElement('span');
    tag.className = this.options.tagClass;
    tag.innerText = string;

    var closeIcon = document.createElement('a');
    closeIcon.innerHTML = '&times;';
    
    // delete the tag when icon is clicked
    closeIcon.addEventListener('click' , function(e){
        e.preventDefault();
        var tag = this.parentNode;

        for(var i =0 ;i < tagInput.wrapper.childNodes.length ; i++){
            if(tagInput.wrapper.childNodes[i] == tag)
                tagInput.deleteTag(tag , i);
        }
    })


    tag.appendChild(closeIcon);
    this.wrapper.insertBefore(tag , this.input);
    this.orignal_input.value = this.arr.join(',');

    return this;
}

// Delete Tags
TagsInput.prototype.deleteTag = function(tag , i){
    tag.remove();
    this.arr.splice( i , 1);
    this.orignal_input.value =  this.arr.join(',');
    return this;
}

// Make sure input string have no error with the plugin
TagsInput.prototype.anyErrors = function(string){
    if( this.options.max != null && this.arr.length >= this.options.max ){
        console.log('max tags limit reached');
        return true;
    }
    
    if(!this.options.duplicate && this.arr.indexOf(string) != -1 ){
        console.log('duplicate found " '+string+' " ')
        return true;
    }

    return false;
}

// Add tags programmatically 
TagsInput.prototype.addData = function(array){
    var plugin = this;
    
    array.forEach(function(string){
        plugin.addTag(string);
    })
    return this;
}

// Get the Input String
TagsInput.prototype.getInputString = function(){
    return this.arr.join(',');
}


// destroy the plugin
TagsInput.prototype.destroy = function(){
    this.orignal_input.removeAttribute('hidden');

    delete this.orignal_input;
    var self = this;
    
    Object.keys(this).forEach(function(key){
        if(self[key] instanceof HTMLElement)
            self[key].remove();
        
        if(key != 'options')
            delete self[key];
    });

    this.initialized = false;
}

// Private function to initialize the tag input plugin
function init(tags){
    tags.wrapper.append(tags.input);
    tags.wrapper.classList.add(tags.options.wrapperClass);
    tags.orignal_input.setAttribute('hidden' , 'true');
    tags.orignal_input.parentNode.insertBefore(tags.wrapper , tags.orignal_input);
}

// initialize the Events
function initEvents(tags){
    tags.wrapper.addEventListener('click' ,function(){
        tags.input.focus();           
    });
    

    tags.input.addEventListener('keydown' , function(e){
        var str = tags.input.value.trim(); 

        if( !!(~[9 , 13 , 188].indexOf( e.keyCode ))  )
        {
            e.preventDefault();
            tags.input.value = "";
            if(str != "")
                tags.addTag(str);
        }

    });
}


// Set All the Default Values
TagsInput.defaults = {
    selector : '',
    wrapperClass : 'tags-input-wrapper',
    tagClass : 'tag',
    max : null,
    duplicate: false
}

window.TagsInput = TagsInput;

})();

var tagInput1 = new TagsInput({
        selector: 'tag-input1',
        duplicate : false,
        max : 10
    });
    tagInput1.addData()

</script>
@endsection
