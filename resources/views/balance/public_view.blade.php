@extends('main_master')
@section('title')
     الموازنة العامة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> الموازنات </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ الموازنة العامة </span>
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
        @foreach($balance_year as $item)
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align: center; color: #0c525d">{{ $item->year_name }}</th>
                                    <th rowspan="2" style="text-align: center">المستهدف</th>
                                    <th colspan="2" style="text-align: center">الموازنة</th>
                                    <th colspan="2" style="text-align: center">الفعلي</th>
                                </tr>
                                <tr>
                                    <th>القيمة</th>
                                    <th>المتبقي</th>
                                    <th>القيمة</th>
                                    <th>المتبقي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td style="font-size: 19px">الإيرادات</td>
                                    <td>{{ $item->total }}</td>
                                    <td>{{ $total }}</td>
                                    <td>{{ $item->total - $total }}</td>
                                    <td>{{ $actualTotal }}</td>
                                    <td>{{ $total - $actualTotal }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 19px">المصروفات</td>
                                    <td>{{ $item->total_cash }}</td>
                                    <td>{{ $totalCosts }}</td>
                                    <td>{{ $item->total_cash - $totalCosts }}</td>
                                    <td>{{ $applicants }}</td>
                                    <td>{{ $totalCosts - $applicants }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 19px">الأرباح</td>
                                    <td>{{ $item->total_earn }}</td>
                                    <td>{{ $earnTotal }}</td>
                                    <td>{{ $item->total_earn - $earnTotal }}</td>
                                    <td>{{ $earnActual }}</td>
                                    <td>{{ $earnTotal - $earnActual }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        <!-- /.col -->
        @endforeach
    </div>
    <!-- /.row -->

@endsection
