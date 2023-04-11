<div id="freelancers">
        <div class="row">

            <div class="col-12 mb-3">
                <div class="box-white">
                    <div class="row">
                        <div class="col-lg-6">
                            <form action="{{ admin_url('users') }}" method="GET">
                                <input
                                    wire:model='searchTerm'
                                    {{-- type="email"
                                    name="search"
                                    id="search" --}}
                                    class="form-control form-control-sm"
                                    placeholder="ابحث بواسطة البريد الإلكتروني"
                                />
                            </form>
                        </div>
                        <div class="col-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('new-subscriber-form') }}" class="btn btn-light btn-block border">
							<i class="fa fa-add"></i>
                                إضافة
                            </a>
                        </div>

                        <div class="col-lg-2 mt-2 mt-lg-0">
                            <a href="{{ route('email-form') }}" class="btn btn-light btn-block border">
                            <i class="fa fa-paper-plane"></i>
                                إنشاء حملة
                            </a>
                        </div>
                        <div class="col-lg-2 mt-2 mt-lg-0">
                            <a href="#" class="btn btn-light btn-block border">
                            <i class="fa fa-folder"></i>
                                المسودات
                            </a>
                        </div>
                    </div>
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
                        <table id="customFields" class="table table-striped table-inverse table-bordered mb-0 text-center table-with-avatar">
                            <thead class="thead-inverse">
                                <tr>

                                    <th>البريد الإلكتروني</th>
                                    <th>التعديل</th>
                                    <th>الحذف</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subscribers as $row)
                                    <tr>

                                        <td>{{ $row->email }}</td>
                                        <td><button data-email="{{ $row->email }}" data-id="{{ $row->id }}" class="btn btn-info edit customFields"><i class="fa fa-edit"></i> تعديل</button></td>
                                        <td><button data-id="{{ $row->id }}" class="btn btn-danger delete"><i class="fa fa-trash"></i> حذف</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div><!-- row -->
        <div class="d-flex justify-content-center">
            {{$subscribers->onEachSide(0)->links()}}
        </div>
    </div><!-- freelancers -->