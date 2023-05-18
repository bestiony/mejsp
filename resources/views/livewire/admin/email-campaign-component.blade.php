<div id="freelancers">
    <div class="row">
        <div class="col-12 mb-3">
            <div class="box-white">
                <div class="row">
                    <div class="col-lg-8">
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

                    <div wire:ignore class="col-lg-2 mt-2 mt-lg-0">
                        <a href="#" data-toggle="modal" data-target="#create_list_model"
                            class="btn btn-light btn-block border">
                            <i class="fa fa-paper-plane"></i>
                            إنشاء حملة
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="create_list_model" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModal1Label" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                @livewire('admin.create-email-campaign')
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-lg-2 mt-2 mt-lg-0">
                        <a href="#" class="btn btn-light btn-block border" wire:click.prevnet='createManyLists'>
                            <i class="fa fa-folder"></i>
                            انشاء قوائم تلقائيا
                        </a>
                    </div> --}}
                </div>
            </div>
        </div>

        @if (count($campaigns) == 0)
            <div class="col-12">
                <div class="box-white py-5">
                    <h5 class="mb-0 text-center">لا يوجد حملات !</h5>
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
                                <th>القالب المستخدم</th>
                                <th>موعد الانطلاق</th>
                                <th>الجمهور المستهدف</th>
                                <th>التقدم</th>
                                <th>الحالة</th>
                                <th></th>
                                <th></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($campaigns as $row)
                                <tr>

                                    <td>{{ $row->name }}</td>
                                    <td>{{ $row->template ? $row->template->name : '#غير معروف#'  }}</td>
                                    <td>{{ $row->launch_at }}</td>
                                    @php
                                        $count = count($row->emails);
                                    @endphp
                                    <td>{{ $count }}</td>
                                    <td wire:poll.visible >{{ $row->progress }}/{{ $count }}</td>
                                    <td>{{ CAMPAIN_STATUSES[$row->status] }}</td>

                                    <td>
                                        @if (!in_array($row->status,[ CANCELED_CAMPAIGN, FINISHED_CAMPAIGN]))
                                            <button {{-- data-toggle="modal" data-target="#edit_list_model-{{ $row->id }}" --}} {{-- wire:key="{{ $row->id }}" --}} {{-- wire:click='selectEmailList({{ $row->id }})' --}}
                                                wire:click='cancelCampaign({{ $row->id }})'
                                                class="btn btn-info edit customFields"><i class="fa fa-edit"></i>
                                                إلغاء</button>
                                        @endif

                                    </td>

                                    <td><button
                                            wire:click.prevent='deleteConfirm({{ $row->id }},"هل أنت متأكد من حذف هذه القائمة البريدية")'
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
        {{ $campaigns->onEachSide(0)->links() }}
    </div>
    {{-- <button id="edit" data-toggle="modal" data-target="#edit_list_model" class="d-none"></button> --}}
    <div>
        {{-- @foreach ($campaigns as $campaign)
            <div class="modal fade" id="edit_campaign_model-{{ $campaign->id }}" tabindex="-1" role="dialog"
                aria-labelledby="edit_campaign_model" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    @if ($show == $campaign->id)
                        @livewire('admin.edit-email-list', ['email_list_id' => $list->id], key($list->id))
                        <livewire:admin.edit-email-list :email_list_id="$email_list_id">
                    @endif
                </div>
            </div>
        @endforeach --}}
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
            window.addEventListener('show_model', event => {
                // $('document').ready(function(){
                // $('#customFields').on('click', '.edit', function() {
                // $('#email_btn').val($(this).data('email'));
                // $('#id_btn').val($(this).data('id'));
                // $('#edit').click();
                console.log('asdasd')
                $(event.detail.class).modal('show');
                // });
                // });
            });
        </script>
    @endpush

</div><!-- freelancers -->
