@extends('main_master')
@section('title')
    مقدم الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ مقدم الطلب </span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if(Session()->has('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ Session()->get('status') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-lg-3">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('add.order') }}" class="btn btn-primary">اضافة طلب صرف</a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>البند</th>
                            <th>القسم</th>
                            <th>المبلغ</th>
                            <th>مستوى الأولوية</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->date }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->section_name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->priority_level }}</td>
                            <td>
                                @if($item->status_id == 1)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 2)
                                    <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 3)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>  تم اعتماد الطلب <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 4)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>  تم اعتماد الصرف <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 8)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_1" data-inquiry-id="{{ $item->id }}">
                                     رد على الاستفسار     <i class="fa fa-pencil-square-o"></i>
                                    </button>
{{--                                    <a href="{{ route('applicant.reply.inquiry', $item->id) }}" class="btn btn-primary"> رد على الاستفسار <i class="fa fa-pencil-square-o"></i></a>--}}
                                    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel"><strong> الرد على الاستفسار</strong></h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                @php
                                                    $reply = App\Models\FinanceManager::where('applicant_id',$item->id)->first();
                                                @endphp
                                                <form method="post" action="{{ route('applicant.reply.inquiry', $item->id) }}">
                                                    @csrf

                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>الاستفسار</label><span style="color: red;">  *</span>
                                                            <textarea id="description" name="inquiry" required class="form-control" readonly>{{$reply->inquiry}}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>الرد على الاستفسار</label><span style="color: red;">  *</span>
                                                            <textarea id="description" name="reply_inquiry" required class="form-control" placeholder="الرد..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                                        <button type="submit" class="btn btn-primary">ارسال</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($item->status_id == 9)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 10)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم التأجيل   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 11)
                                    <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                @elseif($item->status_id == 12)
                                    <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                    <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
