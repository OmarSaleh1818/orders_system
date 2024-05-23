@extends('main_master')
@section('title')
    تعديل سنة مالية
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إعدادات الموازنة</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل سنة مالية </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('balance.year.update', $balance->id) }}">
        @csrf
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> تعديل سنة مالية </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم السنة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="year_name"
                           placeholder="اسم السنة ..." value="{{ $balance->year_name }}">
                    @error('year_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" required value="{{ $balance->date }}"
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
                    <input type="date" class="form-control"  required value="{{ $balance->start_date }}"
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
                           value="{{ $balance->end_date }}" required name="end_date">
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
        @foreach($balance_section as $key => $item)
            <input type="hidden" name="id[]" value="{{ $item->id }}">
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
                        <label> المستهدف إيراده </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section-price" required name="section_price[]"
                               value="{{ $item->section_price }}" placeholder="المبلغ المستهدف ...">
                        @error('section_price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label> المستهدف مصروفه </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section_cash" required name="section_cash[]"
                               value="{{ $item->section_cash }}" placeholder="المبلغ ...">
                        @error('section_cash')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label> المستهدف ربحه </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control section_earn" required name="section_earn[]"
                               value="{{ $item->section_earn }}" placeholder="المبلغ ...">
                        @error('section_earn')
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
                    <input type="number" class="form-control" required name="total" id="total"
                           value="{{ $balance->total }}" placeholder="مجموع المبالغ..." readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>مجموع المصروف</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total_cash"
                           value="{{ $balance->total_cash }}" id="total_cash"  readonly>
                    @error('total_cash')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>مجموع الربح</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total_earn"
                           value="{{ $balance->total_earn }}" id="total_earn" readonly>
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
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات...">{{ $balance->description }}</textarea>
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

    <script>
        // Calculate total when a section_price input changes
        document.addEventListener('DOMContentLoaded', function() {
            const sectionPriceInputs = document.querySelectorAll('.section-price');
            const totalInput = document.getElementById('total');

            function calculateTotal() {
                let total = 0;
                sectionPriceInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                totalInput.value = total;
            }

            sectionPriceInputs.forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

            // Initial calculation
            calculateTotal();
        });

        // Calculate total Cash when a section_price input changes
        document.addEventListener('DOMContentLoaded', function() {
            const sectionPriceInputs = document.querySelectorAll('.section_cash');
            const totalInput = document.getElementById('total_cash');

            function calculateTotalCash() {
                let total = 0;
                sectionPriceInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                totalInput.value = total;
            }

            sectionPriceInputs.forEach(input => {
                input.addEventListener('input', calculateTotalCash);
            });

            // Initial calculation
            calculateTotalCash();
        });

        document.addEventListener('DOMContentLoaded', function() {
            const sectionPriceInputs = document.querySelectorAll('.section_earn');
            const totalInput = document.getElementById('total_earn');

            function calculateTotalEarn() {
                let total = 0;
                sectionPriceInputs.forEach(input => {
                    const value = parseFloat(input.value) || 0;
                    total += value;
                });
                totalInput.value = total;
            }

            sectionPriceInputs.forEach(input => {
                input.addEventListener('input', calculateTotalEarn);
            });

            // Initial calculation
            calculateTotalEarn();
        });
    </script>

@endsection
