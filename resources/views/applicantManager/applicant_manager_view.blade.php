@extends('main_master')
@section('title')
    معتمد الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ معتمد الطلب </span>
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

                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>القسم</th>
                            <th>المبلغ</th>
                            <th>مستوى الأولوية</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $key => $item)
                            @php
                                $user_id = Auth::user()->id;
                                $manager = App\Models\projects::where('id', $item->project_name)->where('user_id', $user_id)->first();
                            @endphp
                            @if($manager)
                                <tr>
                                    <td>{{ $key+0 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->priority_level }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد الطلب <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>تم اعتماد الصرف  <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 5)
                                            @php
                                                $attachment = App\Models\Finance::where('applicant_id',$item->id)->first();
                                            @endphp
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>تم تنفيذ الطلب  <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                            <a href="{{ asset($attachment->attachment) }}" class="btn btn-primary">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                                        @elseif($item->status_id == 8)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled> تم إرسال استفسار <i class="fa fa-check-circle" aria-hidden="true"></i>  </button>
                                        @elseif($item->status_id == 9)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 10)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم التأجيل   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 11)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            <a href="{{ route('applicant.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
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
