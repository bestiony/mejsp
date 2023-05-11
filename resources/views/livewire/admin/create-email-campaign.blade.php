<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModal1Label">اضافة محلة</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
    </div>
    <div class="modal-body">
        <form action="#" wire:submit.prevent='createCampaign' method="post">
            @csrf

            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="name">اسم الحملة</label>
                    <a href="#" wire:click.prevent='createCampaignAtomatically'  type="button" class="btn btn-primary m-2">ملأ الحملة اتوماتيكيا </a>
                </div>
                <input wire:model='name' id="name" type="text" name="name"
                    class="form-control form-control-sm" />
                @error('name')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                    <label for="name">الفاصل الزمني بين كل إرسال</label>
                <input wire:model='time_gap' id="time_gap" type="number" min="5" name="time_gap"
                    class="form-control form-control-sm" />
                @error('time_gap')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror

            </div>
            <div class="form-group">
                    <label for="name">وقت وتاريخ الانطلاق</label>
                <input wire:model='launch_at' id="launch_at" type="datetime-local" min="5" name="launch_at"
                    class="form-control form-control-sm" />
                @error('launch_at')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <select wire:model='template_id' name="template_id" id="template_id" class="form-control form-control-sm">
                    <option value="">اختر قالب الرسالة</option>
                    @foreach ($email_templates as $template)
                    <option value="{{ $template->id }}">{{ $template->name }}</option>
                    @endforeach
                </select>
                @error('template_id')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="search">اضافة القوائم بريدية يدويا
                    @if ($count = count($emails))
                        ، تمت اضافة {{$count}} بريدا
                        <a  href="#" wire:click.prevernt='emptyList' type="button" class="btn btn-danger mx-2">إلغاء</a>
                    @endif
                </label>
                <input wire:model='search' id="search" type="text" name="search"
                    class="form-control form-control-sm" placeholder=" ابحث باسم القائمة" />

                @error('emails')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>
            <div class=" p-2">

            <table class="table table-hover">

                <tbody>
                    @foreach ($email_lists as $list)
                        <tr>
                            <td>{{ $list->name }}</td>
                            <td >{{ $list->subscribers->count() }}</td>
                            <td ><a href="#" wire:click.prevent="addToList('{{ $list->id }}')"
                                    type="button" class="btn btn-success ">إضافة</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
                {{-- @if($subscribers_without_list  == 0)
                    <div class="alert alert-danger text-right">لا يوجد بريد آخر لاضافته</div>
                @endif --}}
            </div>

            </div>
            <div class="d-flex justify-content-center">
                {{ $email_lists->onEachSide(1)->links() }}
            </div>




            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button> --}}

                <button type="submit" class="btn btn-primary">انشاء</button>
            </div>
        </form>
</div>
