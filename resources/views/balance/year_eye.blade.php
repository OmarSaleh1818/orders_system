@extends('main_master')
@section('title')
    عرض سنة مالية
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إعدادات الموازنة</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض سنة مالية </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> عرض سنة مالية </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم السنة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="year_name" value="{{ $balance->year_name }}">
                    @error('year_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" readonly
                           value="{{ $balance->date }}" name="date">
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
                    <input type="date" class="form-control" readonly
                           value="{{ $balance->start_date }}" name="start_date">
                    @error('start_date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>تاريخ النهاية </label><span style="color: red;"> *</span>
                    <input type="date" class="form-control" value="{{ $balance->end_date }}"
                           readonly name="end_date">
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
        @foreach($balance_section as $item)
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>الشركة</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" readonly name="section_name[]" value="{{ $item->section_name }}">
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>المستهدف إيراده </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section-price" readonly name="section_price[]" value="{{ $item->section_price }}">
                        @error('section_price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label> المستهدف مصروفه </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section_cash" readonly name="section_cash[]"  value="{{ $item->section_cash }}">
                        @error('section_cash')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label> المستهدف ربحه </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section_earn" readonly name="section_earn[]"  value="{{ $item->section_earn }}">
                        @error('section_price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>مجموع الإيراد</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" name="total" id="total" value="{{ $balance->total }}" readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>مجموع المصروف</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" value="{{ $balance->total_cash }}" name="total_cash" id="total_cash"  readonly>
                    @error('total_cash')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>مجموع الربح</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" value="{{ $balance->total_earn }}" name="total_earn" id="total_earn" readonly>
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
                        <textarea id="description" name="description" readonly class="form-control" placeholder="ملاحظات...">{{ $balance->description }}</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <a href="{{ route('balance.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>


        <br>
    <script src="{{ asset('assets/js/add_year.js') }}"></script>

@endsection
