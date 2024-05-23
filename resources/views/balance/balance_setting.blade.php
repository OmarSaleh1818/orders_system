@extends('main_master')
@section('title')
    إعدادات الموازنة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الموازنات </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إعدادات الموازنة </span>
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
{{--                    @can('إضافة تسعيرة')--}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('add.year') }}" class="btn btn-primary">إضافة سنة مالية</a>
                        </div>
{{--                    @endcan--}}
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم السنة</th>
                            <th>تاريخ البداية</th>
                            <th>تاريخ النهاية</th>
                            <th>مجموع الإيراد</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($balance as $key => $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->year_name }}</td>
                                    <td>{{ $item->start_date }}</td>
                                    <td>{{ $item->end_date }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        <a href="{{ route('balance.year.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                        <a href="{{ route('balance.year.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>                                    </td>
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
