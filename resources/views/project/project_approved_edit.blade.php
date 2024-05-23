@extends('main_master')
@section('title')
    تعديل بَدْء مشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> المشاريع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل بَدْء مشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    <form method="post" action="{{ route('project.approved.update', $openProject->id) }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden"  name="project_id" value="{{ $openProject['project']['id'] }}">
        <div class="row">
            @if($openProject->status_id == 12)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">السبب من عدم اعتماد </label>
                            <textarea id="description" name="reject_reason"  class="form-control"  readonly>{{ $projectApprovedReject->reject_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2>بدء مشروع </h2>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" value="{{ $start_project->date }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" readonly name="project_name" value="{{ $openProject['project']['project_name'] }}">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> القسم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" name="section_name"
                           value="{{ $openProject['project']['section_name'] }}" placeholder=" القسم..." readonly>
                    @error('section_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>العرض الفني الموقع</label><span style="color: red;"> *</span>
                    <input type="file" class="form-control" name="art_show" placeholder="إرفاق عرض فني...">
                    @if($start_project->art_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->art_show) }}">{{ $start_project->art_show }}</a></p>
                    @endif
                    @error('art_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>  العرض المالي الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control"  name="finance_show">
                    @if($start_project->finance_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->finance_show) }}">{{ $start_project->finance_show }}</a></p>
                    @endif
                    @error('finance_show')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>  العقد الموقع</label><span style="color: red;">  *</span>
                    <input type="file" class="form-control" name="draft_show">
                    @if($start_project->draft_show)
                        <p>الملف الحالي: <a href="{{ asset($start_project->draft_show) }}">{{ $start_project->draft_show }}</a></p>
                    @endif
                    @error('draft_show')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col text-center">
                <h2> الدفعات </h2>
            </div>
        </div>
        <br>
        @foreach($multi_batch as $multi)
            <input type="hidden" name="multi[]" value="{{$multi->id }}">
            <div class="main-form mt-3 border-bottom">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>رقم الدفعة</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="batch_number[]" value="{{ $multi->batch_number }}">
                            @error('batch_number')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>قيمة الدفعة</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control batch_value" name="batch_value[]" value="{{ $multi->batch_value }}">
                            @error('batch_value')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label>تاريخ الاستحقاق</label><span style="color: red;">  *</span>
                            <input type="date" class="form-control" name="due_date[]" value="{{ $multi->due_date }}">
                            @error('due_date')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <br>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>مجموع الدفعات</label><span style="color: red;">  *</span>
                    <input type="number" class="form-control" required name="total" id="total"
                           value="{{ $start_project->total }}" readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="form-group">
                        <label for="order_name">ملاحظات</label>
                        <textarea id="description" name="description"  class="form-control" placeholder="ملاحظات...">
                            {{ $start_project->description }}
                        </textarea>
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
        $(document).ready(function () {
            // Recalculate total when any batch_value input changes
            $(document).on('input', '.batch_value', function () {
                updateTotal();
            });

            // Calculate total initially
            updateTotal();

            function updateTotal() {
                var total = 0;
                $('.batch_value').each(function () {
                    var value = parseFloat($(this).val()) || 0;
                    total += value;
                });
                $('#total').val(total);
            }
        });
    </script>

@endsection
