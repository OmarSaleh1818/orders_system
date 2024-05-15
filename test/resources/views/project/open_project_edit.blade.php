@extends('main_master')
@section('title')
    تعديل فتح مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل فتح مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.open.update', $openProject->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="project_id" value="{{ $openProject['project']['id'] }}">
        <div class="row">
            @if($openProject->status_id == 2)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">السبب من عدم اعتماد </label>
                            <textarea id="description" name="reject_reason"  class="form-control"  readonly>{{ $openProjectReject->reject_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
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
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required name="date" value="{{ $openProject->date }}">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
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
                    <label>تاريخ بداية المشروع</label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" value="{{ $openProject->start_date }}"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" id="startDateInput" required name="start_date">
                    @error('start_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ نهاية المشروع</label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           required name="end_date" id="endDateInput" value="{{ $openProject->end_date }}" onchange="validateEndDate()">
                    @error('end_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مدة المشروع بالأيام</label><span style="color: red;"> *</span>
                    <input type="text" class="form-control" required name="project_days" id="daysInput" placeholder="مدة المشروع بالأيام ..."
                           value="{{ $openProject->project_days }}" readonly>
                    @error('project_days')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>نوع العميل</label><span style="color: red;">*</span>
                    <div class="controls">
                        <select name="customer_type" class="form-control" id="customerTypeSelect">
                            <option value="{{ $openProject->customer_type }}" selected >{{ $openProject->customer_type }}</option>
                            <option value="مانح">مانح</option>
                            <option value="حكومي">حكومي</option>
                            <option value="أهلي">أهلي</option>
                            <option value="أفراد">أفراد</option>
                        </select>
                        @error('customer_type')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم العميل</label>
                    <input type="text" class="form-control" name="customer_name" id="customerNameInput"
                           value="{{ $openProject->customer_name }}" placeholder="اسم العميل...">
                    @error('customer_name')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>الجهة المستفيدة</label>
                    <input type="text" class="form-control" name="benefit" id="benefitInput"
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
                    <label> القسم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="section_name"
                           value="{{ $openProject['project']['section_name'] }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> كود المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_code"
                           value="{{ $openProject->project_code }}" placeholder=" كود المشروع..." readonly>
                    @error('project_code')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مسودة العرض فني</label><span style="color: red;"> *</span>
                    <input type="file" class="form-control" name="art_show" placeholder="إرفاق عرض فني...">
                    @if($openProject->art_show)
                        <p>الملف الحالي: <a href="{{ asset($openProject->art_show) }}">{{ $openProject->art_show }}</a></p>
                    @endif
                    @error('art_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <h5>اختيار الموظفين </h5>
                    <div class="controls">
                        @php
                            $project_users = App\Models\project_users::where('openProject_id', $openProject->id)->get();
                            $checkedUserNames = $project_users->pluck('user_name')->toArray();
                            $users = App\Models\User::whereNotIn('name', $checkedUserNames)->get();
                        @endphp
                        @foreach($project_users as $item)
                            <div class="checkbox" style="display: inline-block; margin-right: 10px;margin-bottom: 10px">
                                <label>
                                    <input type="checkbox" name="user_name[]" value="{{ $item->user_name }}" checked>
                                    {{ $item->user_name }}
                                </label>
                            </div>
                        @endforeach
                        @foreach($users as $item)
                            <div class="checkbox" style="display: inline-block; margin-right: 10px;">
                                <label>
                                    <input type="checkbox" name="user_name[]" value="{{ $item->name }}">
                                    {{ $item->name }}
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
                    <label> مسودة العرض مالي</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control"  name="finance_show">
                    @if($openProject->finance_show)
                        <p>الملف الحالي: <a href="{{ asset($openProject->finance_show) }}">{{ $openProject->finance_show }}</a></p>
                    @endif
                    @error('finance_show')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> مسودة العقد</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="draft_show">
                    @if($openProject->draft_show)
                        <p>الملف الحالي: <a href="{{ asset($openProject->draft_show) }}">{{ $openProject->draft_show }}</a></p>
                    @endif
                    @error('draft_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات...">{{ $openProject->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="submit" class="btn btn-info" value=" حفظ وإرسال">
        </div>
        <br>
    </form>


    <script src="{{ asset('assets/js/project_open.js') }}"></script>

@endsection
