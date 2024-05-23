@extends('main_master')
@section('title')
     إضافة سنة مالية
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إعدادات الموازنة</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إضافة سنة مالية </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('balance.year.store') }}">
        @csrf
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> إضافة سنة مالية </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم السنة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="year_name" placeholder="اسم السنة ...">
                    @error('year_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="dateInput" required
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ البداية </label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" id="startDateInput" required
                           min="{{ Carbon\Carbon::now()->format('Y-m-d') }}" name="start_date">
                    @error('start_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ النهاية </label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           id="endDateInput" required name="end_date">
                    @error('end_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الشركات </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3" style="border-left: 1px solid #444444">
                <div class="form-group">
                    <label>الشركات</label><span style="color: red;">  *</span>
                </div>
            </div>
            <div class="col-md-3" style="border-left: 1px solid #444444">
                <div class="form-group">
                    <label> الإيرادات المستهدفة </label><span style="color: red;">  *</span>
                </div>
            </div>
            <div class="col-md-3" style="border-left: 1px solid #444444">
                <div class="form-group">
                    <label> المصروفات المستهدفة </label><span style="color: red;">  *</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label> الأرباح المستهدفة </label><span style="color: red;">  *</span>
                </div>
            </div>
        </div>
        @foreach($sections as $item)
            <div class="row">
                <div class="col-md-3" style="border-left: 1px solid #444444">
                    <div class="form-group">
                        <input type="text" class="form-control" readonly name="section_name[]" value="{{ $item->section_name }}">
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3" style="border-left: 1px solid #444444">
                    <div class="form-group">
                        <input type="number" class="form-control section-price" required name="section_price[]"  placeholder="المبلغ ...">
                        @error('section_price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3" style="border-left: 1px solid #444444">
                    <div class="form-group">
                        <input type="number" class="form-control section_cash" required name="section_cash[]"  placeholder="المبلغ ...">
                        @error('section_cash')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <input type="number" class="form-control section_earn" required name="section_earn[]"  placeholder="المبلغ ...">
                        @error('section_earn')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        <div class="row">
            <div class="col-md-3">

            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>مجموع الإيرادات</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total" id="total" readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>مجموع المصروفات</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total_cash" id="total_cash"  readonly>
                    @error('total_cash')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>مجموع الأرباح</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total_earn" id="total_earn" readonly>
                    @error('total_earn')
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

    <script src="{{ asset('assets/js/add_year.js') }}"></script>

@endsection
