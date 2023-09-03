@extends('main_master')
@section('title')
    تعديل طلب صرف
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل طلب </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('applicant.update', $applicant->id) }}">
        @csrf

        <div class="row">

            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" value="{{ $applicant->date }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="section_name" class="form-control">
                            <option value="" selected="" disabled="">اختيار القسم </option>
                            @foreach($sections as $item)
                                <option value="{{ $item->section_name }}" {{ $item->section_name == $applicant->section_name
                                         ? 'selected' : ''}}>{{ $item->section_name }}</option>
                            @endforeach

                        </select>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>المبلغ</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="price" value="{{ $applicant->price }}" placeholder="المبلغ...">
                    @error('price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار مستوى الاولوية </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="priority_level" class="form-control">
                            <option value="" selected="" disabled="">اختيار مستوى الأولوية </option>
                            <option value="مهم" @if($applicant->priority_level === 'مهم') selected @endif>مهم</option>
                            <option value="منخفض" @if($applicant->priority_level === 'منخفض') selected @endif>منخفض</option>
                            <option value="عاجل" @if($applicant->priority_level === 'عاجل') selected @endif>عاجل</option>
                        </select>
                        @error('priority_level')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم الحساب</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="account_number" value="{{ $applicant->account_number }}" placeholder="رقم الحساب...">
                    @error('account_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم البنك</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="bank_name" value="{{ $applicant->bank_name }}" placeholder="اسم البك...">
                    @error('bank_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم صاحب الحساب البنكي</label><span class="text-danger">*</span>
                    <input type="text" class="form-control" name="bank_name_account" value="{{ $applicant->bank_name_account }}" placeholder="اسم صاحب الحساب البنكي...">
                    @error('bank_name_account')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم العقد</label>
                    <input type="text" class="form-control" name="contract_number" value="{{ $applicant->contract_number }}" placeholder="رقم العقد...">
                    @error('contract_number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label>
                    <input type="text" class="form-control" name="project_name" value="{{ $applicant->project_name }}" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ استحقاق الدفعة</label><span class="text-danger">*</span>
                    <input type="date" class="form-control" name="payment_date"
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" value="{{ $applicant->payment_date }}" required>
                    @error('payment_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>رقم أو اسم المرحلة</label>
                    <input type="text" class="form-control" name="stage_name" value="{{ $applicant->stage_name }}" placeholder="رقم او اسم المرحلة...">
                    @error('stage_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">البيان</label><span class="text-danger">*</span>
                        <textarea id="description" name="order_name"  class="form-control" placeholder="البيان...">{{ $applicant->order_name }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value="تأكيد">
        </div>
        <br>
    </form>

@endsection
