@extends('main_master')
@section('title')
    عرض مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>فتح مشروع </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label>
                    <input type="date" class="form-control" id="dateInput" value="{{ $openProject->date }}" readonly name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label>
                    <input type="text" class="form-control" readonly name="project_name" value="{{ $openProject['project']['project_name'] }}" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ بداية المشروع</label>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           id="startDateInput" value="{{ $openProject->start_date }}" readonly name="start_date">
                    @error('start_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ نهاية المشروع</label>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           readonly name="end_date" value="{{ $openProject->end_date }}" id="endDateInput" onchange="validateEndDate()">
                    @error('end_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مدة المشروع بالأيام</label>
                    <input type="text" class="form-control" required name="project_days" value="{{ $openProject->project_days }}"
                           id="daysInput" placeholder="مدة المشروع بالأيام ..."
                           readonly>
                    @error('project_days')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>نوع العميل</label>
                    <input type="text" class="form-control" name="customer_type" id="customerTypeSelect" readonly
                            value="{{ $openProject->customer_type }}">
                    @error('customer_type')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم العميل</label>
                    <input type="text" class="form-control" name="customer_name" id="customerNameInput" readonly
                            value="{{ $openProject->customer_name }}">
                    @error('customer_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الجهة المستفيدة</label>
                    <input type="text" class="form-control" name="benefit" id="benefitInput" readonly
                            value="{{ $openProject->benefit }}" placeholder="الجهة المستفيدة...">
                    @error('benefit')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> القسم</label>
                    <input type="text" class="form-control" readonly name="section_name" value="{{ $openProject['project']['section_name'] }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> كود المشروع</label>
                    <input type="text" class="form-control" readonly name="project_code"
                            value="{{ $openProject->project_code }}" placeholder=" كود المشروع...">
                    @error('project_code')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label style="margin-top: 30px; margin-left: 30px">مسودة العرض فني</label>
                    <a href="{{ asset($openProject->art_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5> الموظفين </h5>
                    <div class="controls">
                        @foreach($project_users as $item)
                            <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                <label>
                                    <input type="checkbox" name="user_name[]" value="{{ $item->user_name }}" checked disabled>
                                    {{ $item->user_name }}
                                </label>
                            </div>
                        @endforeach
                        @error('user_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label style="margin-top: 30px; margin-left: 30px">مسودة العرض مالي</label>
                    <a href="{{ asset($openProject->finance_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label style="margin-top: 30px; margin-left: 30px"> مسودة العقد</label>
                    <a href="{{ asset($openProject->draft_show) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات..." readonly>{{ $openProject->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="d-flex justify-content-center" style="gap: 1rem;">
            @if($openProject->status_id == 1)
                @can('اعتماد القانونية للمشروع')
                    <a href="{{ route('open.project.sure', $openProject->id) }}" class="btn btn-success" id="sure"> اعتماد القانونية </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                        عدم الاعتماد
                    </button>
                @endcan
                <button class="btn btn-secondary" disabled> في انتظار القانونية <i class="far fa-clock" aria-hidden="true"></i></button>
                <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($openProject->status_id == 2)
                <button class="btn btn-danger" disabled> غير معتمد</button>
                <a href="{{ route('open.project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($openProject->status_id == 3)
                @can('اعتماد المدير لبدء المشروع')
                    <a href="{{ route('open.projectManager.sure', $openProject->id) }}" class="btn btn-success" id="sure"> اعتماد المدير لبدء المشروع </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                        عدم الاعتماد
                    </button>
                @endcan
                <button class="btn btn-success" disabled> تم اعتماد القانونية </button>
                <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($openProject->status_id == 6)
                @php
                    $user_id = Auth::user()->id;
                    $manager = App\Models\OpenProject::where('user_id', $user_id)->where('id', $openProject->id)->first();
                @endphp
                @if($manager)
                    <a href="{{ route('add.project.start', $openProject->id) }}" class="btn btn-secondary">  بدء مشروع  </a>
                @endif
                <button class="btn btn-success" disabled> تم اعتماد المدير لبدء المشروع </button>
                <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($openProject->status_id == 7)
                <a href="{{ route('add.project.open', $openProject->id) }}" class="btn btn-secondary">  فتح مشروع  </a>
                <button class="btn btn-success" disabled> تم اعتماد المدير </button>
                <a href="{{ route('open.project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @endif
        </div>
        <br>
        <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('open.project.reject', $openProject->id) }}">
                        @csrf

                        <div class="modal-body">
                            <div class="form-group">
                                <textarea id="description" name="reject_reason" required class="form-control" placeholder="السبب..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">عدم الاعتماد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    <script src="{{ asset('assets/js/project_open.js') }}"></script>

@endsection
