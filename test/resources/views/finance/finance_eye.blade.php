@extends('main_master')
@section('title')
    عرض الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المحاسب</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض الطلب </span>
            </div>
        </div>

    </div>
@endsection

@section('content')

    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="project_name">اسم المشروع </label><span style="color: red;">  *</span>
                <input type="text" name="project_name" class="form-control" value="{{ $applicant['project']['project_name'] }}" readonly>
                @error('project_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" id="section_name_div">
                <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                <input type="text" name="section_name" class="form-control" value="{{ $applicant->section_name }}" readonly>
                @error('section_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="step_name"> المرحلة</label><span style="color: red;">  *</span>
                <input type="text" name="step_name" class="form-control" value="{{ $applicant->step_name }}" readonly>
                @error('step_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="item_name"> البند</label><span style="color: red;">  *</span>
                <input type="text" name="item_name" class="form-control" value="{{ $applicant->item_name }}" readonly>
                @error('item_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="item_value">قيمة البند</label>
                <input type="text" class="form-control" name="item_value"  value="{{ $applicant->item_value }}" readonly>
                @error('item_value')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="remaining_value"> المتبقي من قيمة البند</label>
                <input type="text" class="form-control" name="remaining_value" value="{{ $applicant->remaining_value }}" readonly>
                @error('remaining_value')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>التاريخ</label><span style="color: red;">  *</span>
                <input type="date" class="form-control" value="{{ $applicant->date }}" readonly required name="date">
                @error('date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>المبلغ</label><span style="color: red;">  *</span>
                <input type="text" class="form-control" required name="price" readonly value="{{ $applicant->price }}" placeholder="المبلغ...">
                @error('price')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label> مستوى الأولوية </label><span class="text-danger">*</span>
                <input type="text" class="form-control" required name="priority_level" readonly value="{{ $applicant->priority_level }}" placeholder="مستوى الأولوية...">
                @error('priority_level')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>اسم البنك</label><span class="text-danger">*</span>
                <input type="text" class="form-control" name="bank_name" value="{{ $applicant->bank_name }}" readonly placeholder="اسم البك...">
                @error('bank_name')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>اسم صاحب الحساب البنكي</label><span class="text-danger">*</span>
                <input type="text" class="form-control" name="bank_name_account" value="{{ $applicant->bank_name_account }}" readonly placeholder="اسم صاحب الحساب البنكي...">
                @error('bank_name_account')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>رقم الحساب</label><span class="text-danger">*</span>
                <input type="text" class="form-control" name="account_number" value="{{ $applicant->account_number }}" placeholder="رقم الحساب..." readonly>
                @error('account_number')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>رقم العقد</label>
                <input type="text" class="form-control" name="contract_number" value="{{ $applicant->contract_number }}" placeholder="رقم العقد..." readonly>
                @error('contract_number')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>تاريخ استحقاق الدفعة</label><span class="text-danger">*</span>
                <input type="date" class="form-control" name="payment_date"
                       value="{{ $applicant->payment_date }}" dir="rtl" readonly>
                @error('payment_date')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label for="order_name">البيان</label>
                    <textarea id="description" name="description"  class="form-control" placeholder="البيان..." readonly>{{ $applicant->description }}</textarea>
                </div>
            </div>
        </div>
    </div>
    <br>

    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($applicant->status_id == 4)
            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_modal_1">
                تم الصرف ؟
            </button>
            <a href="{{ route('finance.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($applicant->status_id == 5)
            <button class="btn btn-success" disabled> تم تنفيذ الطلب </button>
            <a href="{{ route('finance.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
    </div>
    <br>
    <div class="modal fade" id="m_modal_9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><strong>إرفاق الإيصال</strong></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('finance.attachment', $applicant->id) }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="project_id" value="{{ $applicant->project_name }}">
                    <input type="hidden" name="price" value="{{ $applicant->price }}">
                    <input type="hidden" name="value" value="{{ $applicant->value }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="file" name="attachment" class="form-control" >
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary"> حفظ وإرسال</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
