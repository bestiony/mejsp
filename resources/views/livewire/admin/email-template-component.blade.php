<div id="freelancers">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="row">
                    <div class="col-lg-10">
                        <form action="{{ admin_url('users') }}" method="GET">
                            <input wire:model='searchTerm' {{-- type="email"
                                    name="search"
                                    id="search" --}} class="form-control form-control-sm"
                                placeholder="ابحث بواسطة الاسم" />
                        </form>
                    </div>
                    {{-- <div class="col-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('new-subscriber-form') }}" class="btn btn-light btn-block border">
							<i class="fa fa-add"></i>
                                إضافة
                            </a>
                        </div> --}}

                    <div class="col-lg-2 mt-2 mt-lg-0">
                        <a href="#" data-toggle="modal" data-target="#create_template_model"
                            class="btn btn-light btn-block border">
                            <i class="fa fa-paper-plane"></i>
                            إنشاء قالب
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="create_template_model" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModal1Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                @livewire('admin.create-email-template')
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-light btn-block border">
                            <i class="fa fa-folder"></i>
                                المسودات
                            </a>
                        </div> --}}
                </div>
            </div>
        </div>

        @if (count($templates) == 0)
            <div class="col-12">
                <div class="box-white py-5">
                    <h5 class="mb-0 text-center">لا يوجد قوالب !</h5>
                </div>
            </div>
        @else
            <div class="col-12 mb-4">
                <div class="box-white table-responsive">
                    <table id="customFields"
                        class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                        <thead class="thead-inverse">
                            <tr>

                                <th>الاسم</th>
                                <th>العنوان</th>
                                {{-- <th>الملف</th> --}}
                                <th>التعديل</th>
                                <th>الحذف</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($templates as $row)
                                <tr>

                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->subject }}</td>
                                    {{-- <td>{{ $row->template }}</td> --}}
                                    <td><button data-email="{{ $row->email }}" data-id="{{ $row->id }}"
                                            class="btn btn-info edit customFields"><i class="fa fa-edit"></i>
                                            تعديل</button></td>
                                    <td><button
                                            wire:click.prevent='deleteConfirm({{ $row->id }},"هل أنت متأكد من حذف هذا القالب")'
                                            data-id="{{ $row->id }}" class="btn btn-danger delete"><i
                                                class="fa fa-trash"></i> حذف</button></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

    </div><!-- row -->
    <div class="d-flex justify-content-center">
        {{ $templates->onEachSide(0)->links() }}
    </div>
    @push('script')
        <script>
            window.addEventListener('alert_message', event => {
                swal({
                    title: event.detail.title,
                    icon: event.detail.type,
                    text: event.detail.text,
                });
                if (event.detail.type != 'error') {

                    location.reload();
                }
            })
            window.addEventListener('confirmDelete', event => {
                swal({
                    title: event.detail.title,
                    icon: event.detail.type,
                    text: event.detail.text,
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
                        window.livewire.emit('delete', event.detail.id)
                    }
                })
            })
        </script>
    @endpush

</div><!-- freelancers -->
