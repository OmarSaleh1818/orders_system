@extends('main_master')
@section('title')
    معتمد الصرف
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المدير المالي</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ معتمد الصرف </span>
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
                            <th>البند</th>
                            <th>القسم</th>
                            <th>المبلغ</th>
                            <th>المبلغ كتابة</th>
                            <th>مستوى الأولوية</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $key => $item)
                            @if($item->status_id == 3)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->item_name }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->price_name }}</td>
                                    <td>{{ $item->priority_level }}</td>
                                    <td>
                                        <a href="{{ route('finance.manager.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                        <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
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
