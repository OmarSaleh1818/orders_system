@extends('main_master')
@section('title')
    المشاريع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">   المشاريع </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ فتح فشروع </span>
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
                            <th>التاريخ</th>
                            <th>اسم المشروع</th>
                            <th>القسم</th>
                            <th>نوع العميل</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody id="projectTableBody">
                        @foreach($openProject as $key => $item)
                            @php
                                $canApprove = Gate::check('اعتماد المدير المالي لبدء المشروع') || Gate::check('اعتماد المدير لبدء المشروع')
                                                            || Gate::check('اعتماد القانونية للمشروع');
                                $user_id = Auth::user()->id;
                                $manager = App\Models\OpenProject::where('user_id', $user_id)->where('id', $item->id)->first();
                            @endphp
                            @if($manager)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item['project']['project_name']}}</td>
                                    <td>{{ $item['project']['section_name']}}</td>
                                    <td>{{ $item->customer_type }}</td>
                                    <td>
                                        @if($item->status_id == 1 )
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled>  في انتظار القانونية <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد القانونية <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد المدير لبدء المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير المالي <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('open.project.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            <a href="{{ route('project.approved.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 5)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 13)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($canApprove)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item['project']['project_name']}}</td>
                                    <td>{{ $item['project']['section_name']}}</td>
                                    <td>{{ $item->customer_type }}</td>
                                    <td>
                                        @if($item->status_id == 1 )
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled>  في انتظار القانونية <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد القانونية <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد المدير لبدء المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير المالي <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 5)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        @elseif($item->status_id == 13)
                                            <a href="{{ route('project.approved.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-success" disabled> تم اعتماد المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
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
                    url: "{{ route('filter.open.project') }}", // Update this with your correct route
                    type: "GET",
                    data: { section_filter: section },
                    success: function(response) {
                        var tableBody = $('#projectTableBody');
                        tableBody.empty(); // Clear the table body

                        // Loop through the returned openProjects and append rows to the table
                        if(response.openProjects.length > 0) {
                            $.each(response.openProjects, function(index, project) {
                                var buttons = '';
                                    // Check the status of each project to append the correct buttons
                                    if (project.status_id === 1) {
                                        buttons = `
                                            <a href="/project/manager/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled>في انتظار القانونية <i class="far fa-clock"></i></button>
                                        `;
                                    } else if (project.status_id === 3) {
                                        buttons = `
                                            <a href="/project/manager/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled> تم اعتماد القانونية <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        `;
                                    } else if (project.status_id === 6) {
                                        buttons = `
                                            <a href="/project/manager/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled> تم اعتماد المدير لبدء المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>

                                        `;
                                    } else if (project.status_id === 4) {
                                        buttons = `
                                            <a href="/project/approved/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير المالي <i class="fa fa-check-circle" aria-hidden="true"></i> </button>

                                        `;
                                    } else if (project.status_id === 2) {
                                        buttons = `
                                            <a href="/project/manager/eye/${project.id}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        `;
                                    } else if (project.status_id === 12) {
                                        buttons = `
                                            <a href="/project/manager/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        `;
                                    } else if (project.status_id === 5) {
                                        buttons = `
                                            <a href="/project/approved/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> جاري مراجعة المدير <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        `;
                                    } else if (project.status_id === 13) {
                                        buttons = `
                                            <a href="/project/approved/eye/${project.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                             <button class="btn btn-success" disabled> تم اعتماد المشروع <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
                                        `;
                                    }
                                var row = `<tr>
                                    <td>${index+1}</td>
                                    <td>${project.date}</td>
                                    <td>${project.project.project_name}</td>
                                    <td>${project.project.section_name}</td>
                                    <td>${project.customer_type}</td> 
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
