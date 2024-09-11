@extends('main_master')
@section('title')
     تسعير المشاريع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> تسعير المشاريع  </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تسعير المشاريع </span>
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
                    @can('إضافة تسعيرة')
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('add.project') }}" class="btn btn-primary">إضافة تسعيرة</a>
                        </div>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="section_filter">ابحث بالقسم</label>
                            <select id="section_filter" class="form-control">
                                <option value='' >جميع الأقسام</option>
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
                            <th>التاريخ</th>
                            <th>اسم المشروع</th>
                            <th>اسم القسم</th>
                            <th>المجموع</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody id="projects-tbody">
                        @foreach($projects as $key => $item)
                            @php
                                $canApprove = Gate::check('اعتماد المدير المالي للتسعيرة') || Gate::check('اعتماد المدير للتسعيرة');
                                   $user_id = Auth::user()->id;
                                   $manager = App\Models\projects::where('user_id', $user_id)->where('id', $item->id)->first();
                            @endphp
                            @if($manager)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->project_name }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> في انتظار المدير المالي <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير المالي  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 7)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>  تم فتح مشروع  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 13)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المشروع  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <a href="{{ route('project.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($canApprove)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->project_name }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->total }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> في انتظار المدير المالي <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير المالي  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 7)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير لفتح المشروع <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>  تم فتح مشروع  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 13)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المشروع  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('project.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
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

        $(document).ready(function() {
            $('#section_filter').on('change', function() {
                var sectionName = $(this).val();

                $.ajax({
                    url: "{{ route('projects.filter') }}", // Set up a route for this
                    type: "GET",
                    data: { section_name: sectionName },
                    success: function(response) {
                        var projectsTable = $('#projects-tbody');
                        projectsTable.empty(); // Clear the current table rows

                        if(response.projects.length > 0) {
                            $.each(response.projects, function(index, project) {
                                var buttons = '';
                                // Check the status of each project to append the correct buttons
                                if(project.status_id == 1) {
                                    buttons = `
                                        <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                        <button class="btn btn-secondary" disabled>في انتظار المدير المالي <i class="far fa-clock"></i></button>
                                    `;
                                    } else if(project.status_id == 6) {
                                        buttons = `
                                            <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>تم اعتماد المدير المالي <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if(project.status_id == 7) {
                                        buttons = `
                                            <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>تم اعتماد المدير <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if(project.status_id == 3) {
                                        buttons = `
                                            <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم فتح مشروع <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if(project.status_id == 13) {
                                        buttons = `
                                            <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>تم اعتماد المشروع <i class="fa fa-check-circle"></i></button>
                                        `;
                                    } else if(project.status_id == 2) {
                                        buttons = `
                                            <a href="/manager/project/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>غير معتمد <i class="fa fa-times-circle"></i></button>
                                        `;
                                    }

                                // Append the new row to the table
                                projectsTable.append(`
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${project.date}</td>
                                        <td>${project.project_name}</td>
                                        <td>${project.section_name}</td>
                                        <td>${project.total}</td>
                                        <td>${buttons}</td>
                                    </tr>
                                `);
                            });
                        } else {
                            projectsTable.append('<tr><td colspan="6">لا توجد تسعيرة في هذا القسم</td></tr>');
                        }
                    }
                });
            });
        });
    </script>

@endsection
