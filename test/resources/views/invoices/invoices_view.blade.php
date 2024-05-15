@extends('main_master')
@section('title')
     إصدار الفواتير
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إصدار الفواتير </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0"> الفواتير </span>
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
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('invoices.add') }}" class="btn btn-primary"> إصدار فاتورة <i class="fa fa-archive"></i></a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>المشروع</th>
                            <th>المجموع</th>
                            <th>الإيصال</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoices as $key => $item)
                            @php
                                $canApprove = Gate::check('اعتماد المدير المالي للتسعيرة') || Gate::check('اعتماد المدير للتسعيرة')
                                || Gate::check('تنفيذ طلب الصرف');
                                $user_id = Auth::user()->id;
                                $invoice = App\Models\Invoices::where('user_id', $user_id)->where('id', $item->id)->first();
                                $projectManager = App\Models\projects::where('user_id', $user_id)->first();
                            @endphp
                            @if($invoice)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>{{ $item['project']['project_name'] }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        <a href="{{ asset($item->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download"></i></a>
                                    </td>
                                    <td>
                                        @if($item->status_id == 1)
                                        <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                        <button class="btn btn-secondary"> في الانتظار <i class="far fa-clock"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <a href="{{ route('invoices.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-info" disabled>  تم اعتماد مدير المشروع  <i class="fa fa-check-circle"></i></button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير المالي  <i class="fa fa-check-circle"></i></button>
                                        @elseif($item->status_id == 5)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم إرفاق الفاتورة <i class="fa fa-check-circle"></i></button>
                                            <a href="{{ asset($item->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($canApprove || $projectManager)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->due_date }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        <a href="{{ asset($item->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download"></i></a>
                                    </td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary"> في الانتظار <i class="far fa-clock"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-info" disabled>  تم اعتماد مدير المشروع  <i class="fa fa-check-circle"></i></button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير المالي  <i class="fa fa-check-circle"></i></button>
                                        @elseif($item->status_id == 5)
                                            <a href="{{ route('invoices.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم إرفاق الفاتورة <i class="fa fa-check-circle"></i></button>
                                            <a href="{{ asset($item->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download"></i></a>
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
