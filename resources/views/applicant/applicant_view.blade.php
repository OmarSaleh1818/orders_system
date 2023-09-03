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
                            <td>{{ $item->section_name }}</td>
                            <td>{{ $item->price }}</td>
                            <td>{{ $item->priority_level }}</td>
                            <td>
                                @if($item->status_id == 1)
                                    <button class="btn btn-primary" disabled>تم الارسال</button>
                                @elseif($item->status_id == 2)
                                    <button class="btn btn-warning" disabled>تم رفض الطلب</button>
                                    <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-info"> تعديل <i class="fa fa-pen"></i>  </a>
                                @elseif($item->status_id == 3)
                                <button class="btn btn-secondary" disabled>تم اعتماد الطلب</button>

{{--                                <a href="{{ route('applicant.delete', $item->id) }}" class="btn btn-danger" id="delete"> حذف <i class="fa fa-trash"></i>  </a>--}}
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
