@extends('main_master')
@section('title')
    تعديل المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">مدير المشروع</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" value="{{ $project->date }}" required name="date" readonly>
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_name" value="{{ $project->project_name }}" readonly>
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        @foreach($multi_project as $key => $multi)
            <input type="hidden" name="multi[]" value="{{$multi->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>بند الصرف</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="item_name[]"  value="{{ $multi->item_name }}" readonly>
                        @error('item_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>قيمة البند</label><span class="text-danger">*</span>
                        <input type="text" class="form-control item-value" name="item_value[]" value="{{ $multi->item_value }}" readonly>
                        @error('item_value')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        @endforeach
        <hr>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="total" id="total" value="{{ $project->total }}" readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="section_name" class="form-control">
                            <option value="" selected="" disabled="">اختيار القسم </option>
                            @foreach($sections as $item)
                                <option value="{{ $item->section_name }}" {{ $item->section_name == $project->section_name
                                         ? 'selected' : ''}} disabled="">{{ $item->section_name }}</option>
                            @endforeach

                        </select>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="d-flex" style="text-align: center; gap: 1rem;">
            @if($project->status_id == 1)
                <a href="{{ route('project.sure', $project->id) }}" class="btn btn-success" id="sure"> معتمد </a>
                <a href="{{ route('project.reject', $project->id) }}" class="btn btn-danger" id="reject"> غير معتمد </a>
            @elseif($project->status_id == 2)
                <td> <button class="btn btn-danger" disabled> غير معتمد</button></td>
                <a href="{{ route('project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @elseif($project->status_id == 6)
                <td> <button class="btn btn-success" disabled> تم الاعتماد</button></td>
                <a href="{{ route('project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
            @endif
        </div>
        <br>

    <script>

        // Calculate total when an item_value input changes
        $(document).on('input', '.item-value', function () {
            updateTotal();
        });

        // Calculate total initially
        updateTotal();

        function updateTotal() {
            var total = 0;
            $('.item-value').each(function () {
                var value = parseFloat($(this).val()) || 0;
                total += value;
            });
            $('#total').val(total);
        }
    </script>

@endsection