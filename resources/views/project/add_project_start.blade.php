@extends('main_master')
@section('title')
    بدء مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ بدء مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.start.store', $openProject->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden"  name="project_id" value="{{ $openProject['project']['id'] }}">
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>بدء مشروع </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="project_name" value="{{ $openProject['project']['project_name'] }}">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> القسم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="section_name"
                           value="{{ $openProject['project']['section_name'] }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> العرض الفني الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="art_show"
                           placeholder=" إرفاق عرض فني...">
                    @error('art_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>  العرض المالي الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" required name="finance_show" >
                    @error('finance_show')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> العقد الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="draft_show" required>
                    @error('draft_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الدفعات </h2>
            </div>
        </div>
        <br>
        <div class="main-form mt-3 border-bottom">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label>رقم الدفعة</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" name="batch_number[]" required placeholder="رقم الدفعة...">
                        @error('batch_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label>قيمة الدفعة</label><span style="color: red;">  *</span>
                        <input type="number" class="form-control batch_value" name="batch_value[]" placeholder="قيمة الدفعة..." step="any">
                        @error('batch_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-2">
                        <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>
                        <input type="date" class="form-control" name="due_date[]" placeholder="تاريخ الاستحقاق...">
                        @error('due_date')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="paste-new-forms"></div>
        <br>
        <div class="d-flex justify-content-center">
            <a href="javascript:void(0)" class="add-more-form float-left btn btn-primary">إضافة دفعات</a>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مجموع الدفعات</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total" id="total"
                           placeholder="مجموع الدفعات ..." readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات..."></textarea>
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


    <script src="{{ asset('assets/js/project_start.js') }}"></script>

@endsection
