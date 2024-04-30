@extends('main_master')
@section('title')
    عرض الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبات الصرف </h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض الطلب </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
        @if($applicant->transformation == 1)
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2>  تحويل محلي</h2>
                </div>
            </div>
            <br>
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
                        <label>رقم طلب الصرف </label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="order_number" readonly value="{{ $applicant->order_number }}">
                        @error('order_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_name">اسم المشروع </label><span style="color: red;">  *</span>
                        <input type="text" name="project_id" class="form-control" value="{{ $applicant['project']['project_name'] }}" readonly>
                        @error('project_id')
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
                        <label for="remaining_value"> المتبقي من قيمة البند بعد الصرف</label>
                        <input type="text" class="form-control" name="remaining_value_after" value="{{ $applicant->remaining_value_after }}" readonly>
                        @error('remaining_value_after')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>المبلغ بالريال السعودي </label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="price" readonly value="{{ $applicant->price }}" >
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
                        <input type="text" class="form-control" name="priority_level" readonly value="{{ $applicant->priority_level }}">
                            @error('priority_level')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالعربي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_name" readonly value="{{ $applicant->benefit_name }}">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المصرف</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="bank_name" readonly value="{{ $applicant->bank_name }}">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الحساب البنكي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="account_number" readonly value="{{ $applicant->account_number }}">
                        @error('account_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تاريخ نهاية العقد </label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="payment_date"
                               value="{{ $applicant->payment_date }}" readonly>
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
        @else
            <hr>
            <div class="row">
                <div class="col text-center">
                    <h2>  تحويل دولي</h2>
                </div>
            </div>
            <br>
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
                        <label>رقم طلب الصرف </label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="order_number" readonly value="{{ $applicant->order_number }}">
                        @error('order_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_name">اسم المشروع </label><span style="color: red;">  *</span>
                        <input type="text" name="project_id" class="form-control" value="{{ $applicant['project']['project_name'] }}" readonly>
                        @error('project_id')
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
                        <label for="remaining_value"> المتبقي من قيمة البند بعد الصرف</label>
                        <input type="text" class="form-control" name="remaining_value_after" value="{{ $applicant->remaining_value_after }}" readonly>
                        @error('remaining_value_after')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>المبلغ بالريال السعودي </label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="price" readonly value="{{ $applicant->price }}" >
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
                        <input type="text" class="form-control" required name="priority_level" readonly value="{{ $applicant->priority_level }}">
                        @error('priority_level')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالعربي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_name" readonly value="{{ $applicant->benefit_name }}">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المستفيد بالانجليزي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="en_benefit_name" readonly value="{{ $applicant->en_benefit_name }}">
                        @error('en_benefit_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label> جنسية المستفيد </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="benefit_nationality" readonly value="{{ $applicant->benefit_nationality }}">
                        @error('benefit_nationality')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label> الدولة </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="country" readonly value="{{ $applicant->country }}">
                        @error('country')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>عملة التحويل  </label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="conversion_currency" readonly value="{{ $applicant->conversion_currency }}">
                        @error('conversion_currency')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المصرف</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="bank_name" readonly value="{{ $applicant->bank_name }}">
                        @error('bank_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>رقم الحساب البنكي</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="account_number" readonly value="{{ $applicant->account_number }}">
                        @error('account_number')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>تاريخ نهاية العقد </label><span class="text-danger">*</span>
                        <input type="date" class="form-control" name="payment_date"
                               value="{{ $applicant->payment_date }}" readonly>
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


        @endif
        @php
            $user_id = Auth::user()->id;
            $employee = App\Models\Applicant::where('user_id', $user_id)->where('id', $applicant->id)->first();
        @endphp
        <div class="d-flex justify-content-center" style="gap: 1rem;">
            @if($applicant->status_id == 1)
                @php
                    $projectManager = App\Models\projects::where('user_id', $user_id)->first();
                @endphp
                @if($projectManager)
                    <a href="{{ route('applicant.manager.sure', $applicant->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_2">
                        غير معتمد
                    </button>
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
                            <form method="post" action="{{ route('applicant.manager.reject', $applicant->id) }}">
                                @csrf
                                <input type="hidden" name="value" value="{{ $applicant->value }}">
                                <input type="hidden" name="project_name" value="{{ $applicant->project_name }}">
                                <input type="hidden" name="item_name" value="{{ $applicant->item_name }}">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <textarea id="description" name="manager_reason" required class="form-control" placeholder="السبب..."></textarea>
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
                <td> <button class="btn btn-secondary" disabled> في انتظار اعتماد مدير المشروع <i class="far fa-clock" aria-hidden="true"></i> </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 2)
                <td> <button class="btn btn-danger" disabled> غير معتمد</button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 3)
                @can('اعتماد المدير لطلب الصرف')
                    <a href="{{ route('finance.manager.sure', $applicant->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_3">
                        غير معتمد
                    </button>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_modal_6">
                        تأجيل
                    </button>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#m_modal_5">
                        استفسار
                    </button>
                @endcan
                <td> <button class="btn btn-secondary" disabled> في انتظار اعتماد المدير </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 6)
                @can('اعتماد المدير المالي لطلب الصرف')
                    <a href="{{ route('finance.order.sure', $applicant->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_7">
                        غير معتمد
                    </button>
                    <div class="modal fade" id="m_modal_7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form method="post" action="{{ route('applicant.manager.reject', $applicant->id) }}">
                                    @csrf
                                    <input type="hidden" name="value" value="{{ $applicant->value }}">
                                    <input type="hidden" name="project_name" value="{{ $applicant->project_name }}">
                                    <input type="hidden" name="item_name" value="{{ $applicant->item_name }}">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <textarea id="description" name="manager_reason" required class="form-control" placeholder="السبب..."></textarea>
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
                @endcan
                <td> <button class="btn btn-secondary" disabled> في انتظار اعتماد المدير المالي <i class="far fa-clock" aria-hidden="true"></i> </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 4)
                @can('تنفيذ طلب الصرف')
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_modal_9">
                        تم الصرف ؟
                    </button>
                @endcan
                <td> <button class="btn btn-success" disabled> تم اعتماد الصرف </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 5)
                @php
                    $attachment = App\Models\Finance::where('applicant_id',$applicant->id)->first();
                @endphp
                <td> <button class="btn btn-success" disabled> تم تنفيذ الطلب </button></td>
                @can('تحميل طلب صرف')
                    <a href="{{ asset($attachment->attachment) }}" class="btn btn-primary">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                @endcan
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 8)
                <button class="btn btn-dark" disabled> تم إرسال الاستفسار</button>
                @can('اعتماد المدير لطلب الصرف')
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#m_modal_4" data-inquiry-id="{{ $applicant->id }}">
                        عرض الاستفسار     <i class="fa fa-eye-slash"></i>
                    </button>
                @endcan
                @if($employee)
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_1">
                        رد على الاستفسار     <i class="fa fa-pencil-square-o"></i>
                    </button>
                @endif
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 9)
                @can('اعتماد المدير لطلب الصرف')
                    <a href="{{ route('finance.manager.sure', $applicant->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_3">
                        غير معتمد
                    </button>
                    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#m_modal_6">
                        تأجيل
                    </button>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_4" data-inquiry-id="{{ $applicant->id }}">
                        عرض الاستفسار     <i class="fa fa-eye-slash"></i>
                    </button>
                @endcan
                <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 10)
                <button class="btn btn-secondary" disabled>تم التأجيل   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                @if($employee)
                    <form method="post" action="{{ route('applicant.return.date', $applicant->id) }}">
                        @csrf
                        <input type="hidden" name="payment_date" value="{{ $applicant->payment_date }}" id="dateInput">
                        <button type="submit" class="btn btn-secondary"> إعادة الإرسال <i class="fa fa-retweet"></i></button>
                    </form>
                @endif
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 11)
                @can('اعتماد المدير لطلب الصرف')
                    <a href="{{ route('finance.manager.sure', $applicant->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_3">
                        غير معتمد
                    </button>
                    <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#m_modal_5">
                        استفسار
                    </button>
                @endcan
                <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 12)
                <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @endif
        </div>
        {{--                                    <a href="{{ route('applicant.reply.inquiry', $item->id) }}" class="btn btn-primary"> رد على الاستفسار <i class="fa fa-pencil-square-o"></i></a>--}}
        <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> الرد على الاستفسار</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @php
                        $reply = App\Models\FinanceManager::where('applicant_id',$applicant->id)->first();
                    @endphp
                    @if($reply)
                    <form method="post" action="{{ route('applicant.reply.inquiry', $applicant->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label>الاستفسار</label><span style="color: red;">  *</span>
                                <textarea id="description" name="inquiry" required class="form-control" readonly>{{$reply->inquiry}}</textarea>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>الرد على الاستفسار</label><span style="color: red;">  *</span>
                                <textarea id="description" name="reply_inquiry" required class="form-control" placeholder="الرد..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إرسال</button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> عرض الاستفسار</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @php
                        $reply = App\Models\FinanceManager::where('applicant_id',$applicant->id)->first();
                    @endphp
                    @if($reply)
                        <form method="post" action="{{ route('applicant.reply.inquiry', $applicant->id) }}">
                            @csrf

                            <div class="modal-body">
                                <div class="form-group">
                                    <label>الاستفسار</label><span style="color: red;">  *</span>
                                    <textarea id="description" name="inquiry" required class="form-control" readonly>{{$reply->inquiry}}</textarea>
                                </div>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>الرد على الاستفسار</label><span style="color: red;">  *</span>
                                    <textarea id="description" name="reply_inquiry" required class="form-control"readonly>{{$reply->reply_inquiry}}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                {{--                                                            <button type="submit" class="btn btn-primary">ارسال</button>--}}
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        <div class="modal fade" id="m_modal_5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong>إضافة استفسار</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('finance.manager.inquiry', $applicant->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea id="description" name="inquiry"  class="form-control" placeholder="الاستفسار..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">إرسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="m_modal_6" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> التاريخ المقترح</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('proposed.date', $applicant->id) }}">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="date" class="form-control" name="payment_date" min="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                            <button type="submit" class="btn btn-primary">تأجيل</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
        <div class="modal fade" id="m_modal_3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form method="post" action="{{ route('finance.manager.reject', $applicant->id) }}">
                        @csrf
                        <input type="hidden" name="value" value="{{ $applicant->value }}">
                        <input type="hidden" name="project_name" value="{{ $applicant->project_name }}">
                        <input type="hidden" name="item_name" value="{{ $applicant->item_name }}">
                        <div class="modal-body">
                            <div class="form-group">
                                <textarea id="description" name="finance_reason" required class="form-control" placeholder="السبب..."></textarea>
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
        <br>
@endsection
