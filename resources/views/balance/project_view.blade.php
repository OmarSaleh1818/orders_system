@extends('main_master')
@section('title')
     موازنة المشاريع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الموازنات </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ موازنة المشاريع </span>
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
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2">اسم المشروع</th>
                                <th colspan="3" style="text-align: center">الموازنة</th>
                                <th colspan="3" style="text-align: center">الفعلي</th>
                            </tr>
                            <tr>
                                <th>الإيرادات</th>
                                <th>المصروفات</th>
                                <th>الأرباح</th>
                                <th>الإيرادات</th>
                                <th>المصروفات</th>
                                <th>الأرباح</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($projectData as $key => $item)
                            <tr>
                                <td>{{ $item['project_name'] }}</td>
                                <td>{{ $item['total'] }}</td>
                                <td>{{ $item['total_costs'] }}</td>
                                <td>{{ $item['earn_balance'] }}</td>
                                <td>{{ $item['invoices'] }}</td>
                                <td>{{ $item['applicants'] }}</td>
                                <td>{{ $item['sure_balance'] }}</td>
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
