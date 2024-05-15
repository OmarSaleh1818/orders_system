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
                        <tbody>
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
                                            <button class="btn btn-success" disabled> تم اعتماد المدير <i class="fa fa-check-circle" aria-hidden="true"></i> </button>
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
                                            @if($manager)
                                                <a href="{{ route('open.project.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            @endif
                                            <a href="{{ route('project.manager.eye', $item->id) }}" class="btn btn-info"> عرض  <i class="fa fa-eye"></i>  </a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            @if($manager)
                                                <a href="{{ route('project.approved.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            @endif
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
@endsection
