@extends('admin.layouts.master')
@section('title', 'المستخدمين')
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
                            <div class="col-lg-8">
                                <input type="email" name="search" class="form-control form-control-sm"
                                    placeholder="ابحث بواسطة البريد الالكتروني"
                                    value='@isset($_GET['search']) {{ $_GET['search'] }} @endisset' />
                            </div>

                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                <a href="{{ route('subscriber.restore') }}" class="btn btn-light btn-block border">إعادة تعيين</a>
                            </div>
                            <div class=" col-lg-2 mt-2 mt-lg-0">
                                <a href="{{ route('subscribers.send.email') }}" class="btn btn-light btn-block border">ارسال</a>
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
@endsection
