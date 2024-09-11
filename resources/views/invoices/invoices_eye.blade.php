@extends('main_master')
@section('title')
    عرض المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> إصدار الفواتير </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض فاتورة  </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
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
                <label for="project_id"> المشروع </label><span style="color: red;">  *</span>
                <input type="text" name="project_id" class="form-control" value="{{ $invoices['project']['project_name'] }}" readonly>
                @error('project_id')
                <span class="text-danger"> {{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" id="section_name_div">
                <label for="section_name">اسم القسم</label><span style="color: red;">  *</span>
                <input type="text" name="section_name" class="form-control" value="{{ $invoices['project']['section_name'] }}" readonly>
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
                <input type="date" class="form-control" readonly name="due_date" value="{{ $invoices->due_date }}">
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
                    <textarea id="description" name="description"  class="form-control" readonly placeholder="البيان ...">{{ $invoices->description }}</textarea>
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
        <div class="row">
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label> المنتج </label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="product[]" readonly value="{{ $invoice->product }}">
                    @error('product')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label> العدد </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control number" name="number[]" readonly value="{{ $invoice->number }}">
                    @error('number')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group mb-2">
                    <label> سعر فردي شامل الضريبة </label><span style="color: red;">  *</span>
                    <input type="number" class="form-control individual_price" name="individual_price[]"
                           readonly value="{{ $invoice->individual_price }}">
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
                           value="{{ $invoice->total_price }}" readonly>
                    @error('total_price')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
    @endforeach

    <br>

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>المجموع</label><span style="color: red;">*</span>
                <input type="text" class="form-control" required name="total" id="total" value="{{ $invoices->total }}" readonly>
                @error('total')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> الإيصال </label><span style="color: red;">  *</span>
                <a href="{{ asset($invoices->attachment) }}" class="btn btn-primary btn-sm">تحميل  <i class="fa fa-download"></i></a>
            </div>
        </div>
    </div>
    <br>

    <div class="d-flex justify-content-center" style="gap: 1rem;">
        @if($invoices->status_id == 1)
            @php
                $user_id = Auth::user()->id;
                $projectManager = App\Models\projects::where('user_id', $user_id)->first();
            @endphp
            @if($projectManager)
                <a href="{{ route('invoices.sure', $invoices->id) }}" class="btn btn-success" id="sure"> اعتماد مدير المشروع </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_2">
                    عدم الاعتماد
                </button>
            @endif
            <button class="btn btn-secondary" disabled> في انتظار اعتماد مدير المشروع <i class="far fa-clock" aria-hidden="true"></i> </button>
            <a href="{{ route('invoices.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($invoices->status_id == 2)
            <button class="btn btn-danger" disabled> غير معتمد</button>
            <a href="{{ route('invoices.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($invoices->status_id == 3)
            @can('اعتماد المدير المالي لطلب الصرف')
                <a href="{{ route('invoices.manager.sure', $invoices->id) }}" class="btn btn-success" id="sure"> اعتماد المدير المالي </a>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_2">
                    عدم الاعتماد
                </button>
            @endcan
            <button class="btn btn-success" disabled> تم اعتماد مدير المشروع </button>
            <a href="{{ route('invoices.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($invoices->status_id == 4)
            @can('تنفيذ طلب الصرف')
                <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#m_modal_9">
                    تم التنفيذ ؟
                </button>
            @endcan
            <button class="btn btn-secondary" disabled> في انتظار التنفيذ <i class="far fa-clock" aria-hidden="true"></i> </button>
            <a href="{{ route('invoices.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($invoices->status_id == 5)
            <button class="btn btn-success" disabled>  تم إرفاق الفاتورة <i class="fa fa-check-circle"></i></button>
            <a href="{{ route('invoices.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
        <div class="modal fade" id="m_modal_2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('invoices.reject', $invoices->id) }}">
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
        <div class="modal fade" id="m_modal_9" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong>إرفاق الفاتورة</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('invoices.attachment', $invoices->id) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="file" name="invoice_attachment" class="form-control" >
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
    </div>
    <br>

@endsection
