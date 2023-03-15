@extends('admin.layouts.master')
@section('title', 'الاعدادات')
@section('css')
<style>
    label{display: block}
</style>
@endsection
@section('content')

    <div class="links-bar my-4 ">
        <h4>الاعدادات</h4>
    </div><!-- End Bar Links -->

    <div class="result"></div>

    <div class="setting">
        <div class="row">

            <div class="col-md-4 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">إظهار/إخفاء عناصر الواجهة</h5>
                            <form action="{{ admin_url('settings/front_sections/update') }} " method="POST">
                                @csrf
                                <label class="">صفحة التسجيل </label>

                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="signup_phone" class="custom-control-input" id="customSwitch3"
                                    @if($front_sections['signup_phone'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch3">رقم الهاتف</label>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="blog" class="custom-control-input" id="customSwitch30"
                                    @if($front_sections['blog'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch30">المدونة</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="blog_en" class="custom-control-input" id="customSwitch33"
                                    @if($front_sections['blog_en'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch33">المدونة بالإنجليزية</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="journals" class="custom-control-input" id="customSwitch331"
                                    @if($front_sections['journals'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch331">زر المجلات</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="add_research" class="custom-control-input" id="customSwitch333"
                                    @if($front_sections['add_research'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch333">زر تقديم دراسة</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="international_publishing" class="custom-control-input" id="customSwitch3333"
                                    @if($front_sections['international_publishing'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch3333">زر النشر الدولي</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="international_conference" class="custom-control-input" id="customSwitch33333"
                                    @if($front_sections['international_conference'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch33333">زر طلب الانضمام لمؤتمر دولي</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->
            <div class="col-md-4 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">إظهار/إخفاء عناصر صفحة ارسال بحث</h5>
                            <form action="{{ admin_url('settings/study_submition_sections/update') }} " method="POST">
                                @csrf

                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="title" class="custom-control-input" id="customSwitch21"
                                    @if($study_submition_sections['title'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch21">عنوان البحث</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="keywords-list" class="custom-control-input" id="customSwitch22"
                                    @if($study_submition_sections['keywords-list'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch22">الكلمات المفتاحية</label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="abstract" class="custom-control-input" id="customSwitch23"
                                    @if($study_submition_sections['abstract'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch23">ملخص البحث</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="type" class="custom-control-input" id="customSwitch24"
                                    @if($study_submition_sections['type'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch24">نوع البحث</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="journal" class="custom-control-input" id="customSwitch25"
                                    @if($study_submition_sections['journal'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch25">مجلة النشر</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="file" class="custom-control-input" id="customSwitch26"
                                    @if($study_submition_sections['file'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch26">ملف البحث</label>
                                    </div>
                                </div>




                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->
            <div class="col-md-4 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                        <h5 class=" mb-3">إظهار/إخفاء المجلات من صفحة اضافة دراسة</h5>
                            <form action="{{ admin_url('settings/journals_statuses/update') }} " method="POST">
                                @csrf
                                @foreach($journals as $index => $journal)
                                <div class="form-group">
                                    <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                                    <input type="checkbox" name="journals_statuses[]" value="{{$journal['id']}}" class="custom-control-input" id="customSwitch-{{$index}}"
                                    @if($journal['is_enabled'] == 1) checked @endif>
                                    <label class="custom-control-label" for="customSwitch-{{$index}}">{{$journal['name']}}</label>
                                    </div>
                                </div>
                                @endforeach




                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->
            <div class="col-md-4 mb-4">
                <div class="row">

                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">روابط التواصل الاجتماعي</h5>
                            <form
                                action="@if ($setting != null) {{ admin_url('settings/social/update') }} @else {{ admin_url('settings/social/create') }} @endif"
                                method="POST">
                                @csrf
                                @foreach ($social_websites as $website)
                                    <div class="form-group left-dir">
                                        <input type="url" name="{{ $website }}" class="form-control text-left"
                                            placeholder="{{ Str::ucfirst($website) }}"
                                            @if ($setting != null) value="{{ $setting[$website] }}" @endif />
                                        @error($website)
                                            <div class=" alert alert-error">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endforeach
                                <button type="submit" class=" btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col Social -->

                </div><!-- Row -->
            </div><!-- Grid 1 -->


            <div class="col-md-4 mb-4">
                <div class="row">

                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">حسابات المنصة لاستلام الرسائل عبر البريد</h5>
                            <form action="{{ adminUrl('settings/emails/create') }}" method="POST">
                                @csrf
                                <div class="form-group left-dir">
                                    <input type="email" name="email" class="form-control text-left" placeholder="Email"
                                        required />
                                    @error('email')
                                        <div class=" alert alert-error">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class=" btn-main mb-3">اضافة</button>
                            </form>


                            <table
                                class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                                <thead class="thead-inverse">
                                    <tr>
                                        <th>البريد</th>
                                        <th>الحذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($emails as $email_row)
                                        <tr>
                                            <td>{{ $email_row->email }}</td>
                                            <td>
                                                <form class="delete"
                                                    action="{{ adminUrl('settings/emails/destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $email_row->id }}" required>
                                                    <button type="submit" class="btn btn-danger pb-0 btn-sm"><i
                                                            class="fa-solid fa-trash-can"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div><!-- box-white -->
                    </div><!-- col Social -->

                </div><!-- Row -->
            </div><!-- Grid 1 -->


            <div class="col-md-4 mb-4">
                <div class="row">

                    <div class="col-12 mb-4">
                        <div class="box-white">
                            <h5 class=" mb-3">البريد الإلكتروني</h5>
                            <form action="@if ($setting != null) {{ admin_url('settings/mail/update') }} @else {{ admin_url('settings/mail/create') }} @endif" method="POST">
                                @csrf

                                    <div class="form-group left-dir">
                                        <input type="email" name="mail" class="form-control text-left" placeholder="Email" @if ($setting != null) value="{{ $setting->mail }}" @endif />
                                        @error("mail")
                                            <div class=" alert alert-error">{{ $message }}</div>
                                        @enderror
                                        <small class=" text-muted">يستخدم ذلك البريد في  استقبال الرسائل المرسلة من العملاء</small>
                                    </div>

                                <button type="submit" class=" btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->






                </div><!-- Row -->
            </div><!-- Grid 1 -->




            <div class="col-md-4 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">رقم حساب الواتس</h5>
                            <form action="@if ($setting != null) {{ admin_url('settings/phone/update') }} @else {{ admin_url('settings/phone/create') }} @endif" method="POST">
                                @csrf

                                    <div class="form-group">
                                        <input type="number" step="any" name="phone" class="form-control " placeholder="Phone" @if ($setting != null) value="{{ $setting->phone }}" @endif />
                                        @error("phone")
                                            <div class=" alert alert-error">{{ $message }}</div>
                                        @enderror
                                        <small class=" text-muted">قم باضافة رقم الواتس اب كما هو مثال : 01010101010 </small>
                                    </div>

                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->
            <div class="col-md-4 mb-4">
                <div class="row">


                    <div class="col-12">
                        <div class="box-white">
                            <h5 class=" mb-3">التنبيه في صفحة المحادثة</h5>
                            <form action="{{ admin_url('settings/alert_in_chat/update') }} " method="POST">
                                @csrf

                                    <div class="form-group">

                                        <textarea name="alert_in_chat" class="form-control " placeholder="Alert In Chat" id="" cols="30" rows="3">@if ($setting != null) {{ $setting->alert_in_chat}}" @endif</textarea>
                                        @error("alert_in_chat")
                                            <div class=" alert alert-error">{{ $message }}</div>
                                        @enderror
                                    </div>

                                <button type="submit" class="btn-main">حفظ</button>
                            </form>
                        </div><!-- box-white -->
                    </div><!-- col-->


                </div><!-- Row -->
            </div><!-- Grid 1 -->


        </div>
    </div>


@endsection
@section('js')
    @if (session()->has('success'))
        <script>
            toastr.options.timeOut = 2000;
            toastr.options.progressBar = true;
            toastr.success("{{ session()->get('success') }}");
        </script>
    @endif
@endsection
