<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModal1Label">اضافة قالب</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
    </div>
    <div class="modal-body">
        <form action="#" wire:submit.prevent='createTemplate' method="post">
            @csrf

            <div class="form-group">
                <label for="name">الاسم</label>
                <input wire:model='name' id="name" type="text" name="name"
                    class="form-control form-control-sm" />
                @error('name')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="subject">الموضوع</label>
                <input wire:model='subject' id="subject" type="text" name="subject"
                    class="form-control form-control-sm" />
                @error('subject')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">القالب</label>
                {{-- <textarea rows="6" wire:model='body' id="body" type="text" name="body"></textarea> --}}
                <input type="file" name="template" wire:model='template' id="template" class="form-control form-control-sm">
                @error('template')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">المرسل</label>
                {{-- <textarea rows="6" wire:model='body' id="body" type="text" name="body"></textarea> --}}
                <input type="text" name="sender" wire:model='sender' id="sender" class="form-control form-control-sm">
                @error('sender')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">الحالة</label>

                <select class="form-control form-control-sm" name="status" wire:model='status' id="status">
                    <option value="0"> معطل</option>
                    <option value="1"> نشط</option>
                </select>
                @error('status')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>


            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button> --}}

                <button type="submit" class="btn btn-primary">انشاء</button>
            </div>
        </form>
    </div>
</div>
