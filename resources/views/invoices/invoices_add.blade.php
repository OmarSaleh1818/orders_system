@extends('main_master')
@section('title')
     إصدار فاتورة
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إصدار الفواتير </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إصدار فاتورة </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('invoices.store') }}" enctype="multipart/form-data">
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
                            @php
                                $user = Auth::user()->name;
                                $user_name = App\Models\project_users::where('user_name', $user)->where('project_id', $project->id)->first();
                            @endphp
                            @if($user_name)
                                <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @error('project_id')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="section_name_div">
                    <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                    <input type="text" name="section_name" class="form-control" id="section_name" readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> تاريخ الاستحقاق</label>
                    <input type="date" class="form-control" name="due_date" id="dateInput1">
                    @error('due_date')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">البيان</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="البيان ..."></textarea>
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
        <div class="main-form mt-3 border-bottom">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-2">
                        <label> المنتج </label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" name="product[]" required placeholder="المنتج ...">
                        @error('product')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-2">
                        <label> العدد </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control number" name="number[]" placeholder=" العدد ..." oninput="calculateTotalPrice()">
                        @error('number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-2">
                        <label>  السعر الفردي</label><span style="color: red;">  *</span>
                        <input type="number" class="form-control individual_price" name="individual_price[]" placeholder=" السعر الفردي شامل الضريبة ..." oninput="calculateTotalPrice()">
                        @error('individual_price')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                    <label>  (شامل الضريبة) </label>
                </div>
                <div class="col-md-2">
                    <div class="form-group mb-2">
                        <label> الإجمالي </label><span style="color: red;">  *</span>
                        <input type="number" class="form-control total_price" name="total_price[]"
                                placeholder=" الإجمالي ..." readonly>
                        @error('total_price')
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
            <a href="javascript:void(0)" class="add-more-form float-left btn btn-primary">إضافة منتجات</a>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label><span style="color: red;">*</span>
                    <input type="text" class="form-control" required name="total" id="total" placeholder="المجموع..." readonly>
                    @error('total')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label> إرفاق الإيصال </label><span style="color: red;">  *</span>
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
