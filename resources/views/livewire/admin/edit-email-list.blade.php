<div class="modal-content">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModal1Label">تحديث قائمة بريدية</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

        {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
    </div>
    <div class="modal-body">
        <form action="#" wire:submit.prevent='updateList' method="post">
            @csrf

            <div class="form-group">
                <div class="d-flex justify-content-between align-items-center">
                    <label for="name">اسم القائمة</label>
                    <a href="#" wire:click.prevent='createListAtomatically' type="button"
                        class="btn btn-primary m-2">ملأ القائمة اتوماتيكيا </a>
                </div>
                <input wire:model='name' id="name" type="text" name="name"
                    class="form-control form-control-sm" />
                @error('name')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="search">اضافة عناوين بريدية يدويا
                    @if ($count = count($emails))
                        ، تمت اضافة {{ $count }} بريدا
                        <a href="#" wire:click.prevernt='emptyList' type="button"
                            class="btn btn-danger mx-2">إلغاء</a>
                    @endif
                </label>
                <input wire:model='search' id="search" type="text" name="search"
                    class="form-control form-control-sm" placeholder=" ابحث بالبريدالالكتروني" />


            </div>
            <div class=" p-2">
                <div>
                    <label for="show_all">إظهار الجميع</label>
                    <input wire:model='show_all' type="checkbox" name="show_all" id="show_all">
                </div>
                <table class="table table-hover">

                    <tbody>
                        @foreach ($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->email }}</td>
                                <td>
                                    @if(in_array($subscriber->email , $emails))
                                    <a href="#" wire:click.prevent="removeFromList('{{ $subscriber->email }}')"
                                        type="button" class="btn btn-danger ">إزالة</a>
                                    @else
                                    <a href="#" wire:click.prevent="addToList('{{ $subscriber->email }}')"
                                        type="button" class="btn btn-success ">إضافة</a>
                                    @endif
                                </td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @error('emails')
                    <div class="alert alert-danger text-right">{{ $message }}</div>
                @enderror
            </div>
    </div>
    <div class="d-flex justify-content-center">
        {{ $subscribers->onEachSide(1)->links() }}
    </div>




    <div class="modal-footer">
        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">غلق</button> --}}

        <button wire:click.prevent='updateList' type="submit" class="btn btn-primary">تحديث</button>
    </div>
    </form>
</div>
