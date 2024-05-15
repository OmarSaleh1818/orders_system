@extends('main_master')
@section('title')
    تعديل فاتورة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إصدار الفواتير </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل فاتورة </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('invoices.update', $invoices->id) }}" enctype="multipart/form-data">
        @csrf
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> إصدار فاتورة </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="project_id">اختيار المشروع </label><span style="color: red;">  *</span>
                    <select name="project_id" class="form-control" id="project_name">
                        <option value="" selected="" disabled="">اختيار المشروع</option>
                        @foreach ($projects as $project)
                            <option value="{{ $project->id }}" {{ $project->id == $invoices->project_id
                                    ? 'selected' : ''}}>{{ $project->project_name }}</option>
                        @endforeach
                    </select>
                    @error('project_id')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> تاريخ الاستحقاق</label>
                    <input type="date" class="form-control" name="due_date" value="{{ $invoices->due_date }}" id="dateInput1">
                    @error('due_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">البيان</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="البيان ...">{{ $invoices->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> المنتجات </h2>
            </div>
        </div>
        <br>
        @foreach($multi_invoices as $invoice)
            <input type="hidden" name="multi[]" value="{{$invoice->id }}">
            <div class="main-form mt-3 border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label> المنتج </label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="product[]" required value="{{ $invoice->product }}" placeholder="المنتج ...">
                            @error('product')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label> العدد </label><span style="color: red;">  *</span>
                            <input type="number" class="form-control number" name="number[]" placeholder=" العدد ..."
                                   value="{{ $invoice->number }}" oninput="calculateTotalPrice()">
                            @error('number')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label> سعر فردي شامل الضريبة </label><span style="color: red;">  *</span>
                            <input type="number" class="form-control individual_price" name="individual_price[]"
                                   value="{{ $invoice->individual_price }}" placeholder=" السعر الفردي شامل الضريبة ..." oninput="calculateTotalPrice()">
                            @error('individual_price')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label> الإجمالي </label><span style="color: red;">  *</span>
                            <input type="number" class="form-control total_price" name="total_price[]"
                                   placeholder=" الإجمالي ..." value="{{ $invoice->total_price }}" readonly>
                            @error('total_price')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        <div class="paste-new-forms"></div>
        <br>
        <div class="d-flex justify-content-center">
            <a href="javascript:void(0)" class="add-more-form float-left btn btn-primary">إضافة منتجات</a>
        </div>
        <br>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label><span style="color: red;">*</span>
                    <input type="text" class="form-control" required name="total" id="total" value="{{ $invoices->total }}" placeholder="المجموع..." readonly>
                    @error('total')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> إرفاق الإيصال </label><span style="color: red;">  *</span>
                    <a href="{{ asset($invoices->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                    <input type="file" class="form-control" name="attachment"
                           placeholder=" إرفاق الإيصال ...">
                    @error('attachment')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <br>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <input type="submit" class="btn btn-info" value=" حفظ وإرسال">
        </div>
        <br>
    </form>

    <script src="{{ asset('assets/js/add_invoices.js') }}"></script>

@endsection
