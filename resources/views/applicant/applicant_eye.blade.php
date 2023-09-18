@extends('main_master')
@section('title')
    عرض الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الموظف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض الطلب </span>
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
                    <label> مستوى الاولوية </label><span class="text-danger">*</span>
                    <input type="text" class="form-control" required name="priority_level" readonly value="{{ $applicant->priority_level }}" placeholder="مستوى الاولوية...">
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
            @if($applicant->status_id == 1)
                <td> <button class="btn btn-secondary" disabled> في الانتظار <i class="far fa-clock" aria-hidden="true"></i> </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 2)
                <td> <button class="btn btn-danger" disabled> غير معتمد</button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 3)
                <td> <button class="btn btn-success" disabled> تم اعتماد الطلب</button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 4)
                <td> <button class="btn btn-success" disabled> تم اعتماد الصرف </button></td>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 8)
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#m_modal_1">
                    رد على الاستفسار     <i class="fa fa-pencil-square-o"></i>
                </button>
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
                        </div>
                    </div>
                </div>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 9)
                <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 10)
                <form method="post" action="{{ route('applicant.return.date', $applicant->id) }}">
                    @csrf
                    <input type="hidden" name="payment_date" id="dateInput">
                    <button type="submit" class="btn btn-secondary"> إعادة الإرسال <i class="fa fa-retweet"></i></button>
                </form>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 11)
                <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($applicant->status_id == 12)
                <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                <a href="{{ route('applicant.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @endif
        </div>
        <br>
<script>
    var input = document.getElementById('dateInput');

    // Create a new Date object for the current date
    var currentDate = new Date();

    // Format the date as YYYY-MM-DD for the input value
    var formattedDate = currentDate.toISOString().split('T')[0];

    // Set the initial value of the input field to the current date
    input.value = formattedDate;

    // Add an event listener to allow the user to change the date
    input.addEventListener('input', function(event) {
        var selectedDate = event.target.value;
        console.log(selectedDate); // Output the selected date
    });
</script>
@endsection