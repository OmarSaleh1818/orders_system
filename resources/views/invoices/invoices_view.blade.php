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
                    <div class="row">
                        <div class="col-md-3">
                            <label for="section_filter">ابحث بالقسم</label>
                            <select id="section_filter" class="form-control">
                                <option value="">جميع الأقسام</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->section_name }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>تاريخ الاستحقاق</th>
                            <th>المشروع</th>
                            <th>القسم</th>
                            <th>المجموع</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody id="invoiceTableBody">
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
                                    <td>{{ $item['project']['section_name'] }}</td>
                                    <td>{{ $item->total }}</td>
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
                                    <td>{{ $item['project']['project_name'] }}</td>
                                    <td>{{ $item['project']['section_name'] }}</td>
                                    <td>{{ $item->total }}</td>
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

    <script>
        $(document).ready(function(){
            $('#section_filter').change(function() {
                var section = $(this).val();

                $.ajax({
                    url: "{{ route('filter.invoices') }}", // Update this with your correct route
                    type: "GET",
                    data: { section_filter: section },
                    success: function(response) {
                        var tableBody = $('#invoiceTableBody');
                        tableBody.empty(); // Clear the table body

                        // Loop through the returned openProjects and append rows to the table
                        if(response.invoices.length > 0) {
                            $.each(response.invoices, function(index, project) {
                                var buttons = '';
                                    // Check the status of each project to append the correct buttons
                                    if (project.status_id === 1) {
                                        buttons = `
                                            <a href="/invoices/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary"> في الانتظار <i class="far fa-clock"></i></button>
                                        `;
                                    } else if (project.status_id === 2) {
                                        buttons = `
                                            <a href="/invoices/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        `;
                                    } else if (project.status_id === 3) {
                                        buttons = `
                                            <a href="/invoices/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-info" disabled>  تم اعتماد مدير المشروع  <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if (project.status_id === 4) {
                                        buttons = `
                                            <a href="/invoices/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                             <button class="btn btn-success" disabled>  تم اعتماد المدير المالي  <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if (project.status_id === 5) {
                                        buttons = `
                                            <a href="/invoices/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم إرفاق الفاتورة <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } 
                                var row = `<tr>
                                    <td>${index+1}</td>
                                    <td>${project.due_date}</td>
                                    <td>${project.project.project_name}</td>
                                    <td>${project.project.section_name}</td>
                                    <td>${project.total}</td> 
                                    <td>${buttons}</td>
                                </tr>`;
                                tableBody.append(row);
                            });
                        } else {
                            tableBody.append('<tr><td colspan="6">لا يوجد مشروع  في هذا القسم</td></tr>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log("Error:", error);
                    }
                });
            });
        });
    </script>
@endsection
