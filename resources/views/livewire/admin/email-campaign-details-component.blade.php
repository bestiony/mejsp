<div>
    <div class="links-bar my-4 ">
        <h4>بيانات الحملة</h4>

    </div><!-- End Bar Links -->

    @if (session()->has('success'))
        <div class="alert  box-success alert-dismissible fade show mb-3" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="result"></div>

    <div class="row">

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

                        <tr>

                            <td>{{ $campaign->name }}</td>
                            <td>{{ $campaign->template ? $campaign->template->name : '#غير معروف#' }}</td>
                            <td>{{ $campaign->launch_at }}</td>
                            @php
                                $count = count($campaign->emails);
                            @endphp
                            <td>{{ $count }}</td>
                            <td wire:poll.visible>{{ $campaign->progress }}/{{ $count }}</td>
                            <td>{{ CAMPAIN_STATUSES[$campaign->status] }}</td>

                            <td>
                                @if (!in_array($campaign->status, [CANCELED_CAMPAIGN, FINISHED_CAMPAIGN]))
                                    <button {{-- data-toggle="modal" data-target="#edit_list_model-{{ $campaign->id }}" --}} {{-- wire:key="{{ $campaign->id }}" --}} {{-- wire:click='selectEmailList({{ $campaign->id }})' --}}
                                        wire:click='cancelCampaign({{ $campaign->id }})'
                                        class="btn btn-info edit customFields"><i class="fa fa-edit"></i>
                                        إلغاء</button>
                                @elseif($campaign->status == FAILED_CAMPAIGN || $emails_count > $campaign->progress)
                                    <button {{-- data-toggle="modal" data-target="#edit_list_model-{{ $campaign->id }}" --}} {{-- wire:key="{{ $campaign->id }}" --}} {{-- wire:click='selectEmailList({{ $campaign->id }})' --}}
                                        wire:click='reactivateCampaign({{ $campaign->id }})'
                                        class="btn btn-info edit customFields"><i class="fa fa-edit"></i>
                                        اعادة تنشيط الحملة</button>
                                @endif

                            </td>

                            <td><button
                                    wire:click.prevent='deleteConfirm({{ $campaign->id }},"هل أنت متأكد من حذف هذه الحملة")'
                                    data-id="{{ $campaign->id }}" class="btn btn-danger delete"><i
                                        class="fa fa-trash"></i> حذف</button></td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-12 ">
            <div class="row justify-content-center">
                @if($campaign->status == FAILED_CAMPAIGN)
                <div class="alert alert-danger" role="alert">
فشلت هذه الحملة ، اطلع على السبب في الجدول الموالي ، واعد تنشيطها بعد اصلاح الخطأ ، سنراسل العناوين المتبقية فقط</div>
                @elseif($campaign->progress != $emails_count)
                <div class="alert alert-warning" role="alert">
لم تنجح الحملة في مراسلة جميع المشتركين ، ارسلت فقط  {{$campaign->progress}}   من أصل {{$emails_count}} <br> قم تنشيطها بعد اصلاح الخطأ ، سنراسل العناوين المتبقية فقط </div>
                @elseif($campaign->status == FINISHED_CAMPAIGN)
<div class="alert alert-success" role="alert">
    انتهت هذه الحملة بنجاح
</div>
                @endif
            </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="row">

                <div class="col-12">
                    <h6 class="mb-3">تاريخ النشاط </h6>
                    <div class="box-white table-responsive">
                        <table class="table table-striped table-inverse mb-0 table-bordered text-center">
                            <thead class="thead-inverse">
                                <tr>
                                    <th>التاريخ والوقت</th>
                                    <th>رسالة الخطأ أو النشاط</th>
                                    <th>الايمايل</th>
                                </tr>
                            </thead>
                            <tbody wire:poll.visible>
                                @foreach ($history_log as $log)
                                    <tr>

                                        <td>{{ Carbon\Carbon::parse($log['updated_at']) }}</td>
                                        <td>{{ $log['message'] }}</td>
                                        <td>{{ isset($log['email']) ? $log['email'] : '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- <div class=" mt-3">
                            {{ $researches->links() }}
                        </div> --}}

                    </div>

                </div><!-- User Orders -->

            </div><!-- Row -->
        </div><!-- Grid 3 -->
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






    </div><!-- row -->
</div>
