@extends('main_master')
@section('title')
    المدير المالي
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">   المدير المالي </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ اعتماد المشروع </span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(Session()->has('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>{{ Session()->get('status') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>
    </div>

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
                            <th>اسم المشروع</th>
                            <th>اسم القسم</th>
                            <th>المجموع</th>
                            <th>المتبقي</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($projects as $key => $item)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->project_name }}</td>
                                <td>{{ $item->section_name }}</td>
                                <td>{{ $item->total }}</td>
                                <td>{{ $item->remaining_value }}</td>
                                <td>
                                    @if($item->status_id == 1 )
                                         <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                         <button class="btn btn-secondary" disabled>  في الانتظار <i class="far fa-clock" aria-hidden="true"></i></button>
                                    @elseif($item->status_id == 6)
                                         <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                         <button class="btn btn-success" disabled> معتمد <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                    @elseif($item->status_id == 2)
                                        <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                        <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
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
