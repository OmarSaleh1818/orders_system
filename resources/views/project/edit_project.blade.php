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
    <form method="post" action="{{ route('project.update', $project->id) }}">
        @csrf
        <div class="row">
            @if($project->status_id == 2)
                <div class="col-md-12">
                    <div class="form-group">
                        <div class="form-group">
                            <label for="order_name">السبب من عدم اعتماد المدير</label>
                            <textarea id="description" name="manager_reason"  class="form-control"  readonly>{{ $projectManager->manager_reason }}</textarea>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>التاريخ</label><span style="color: red;">  *</span>
                    <input type="date" class="form-control" value="{{ $project->date }}" required name="date">
                    @error('date')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المشروع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="project_name" value="{{ $project->project_name }}" placeholder="اسم المشروع...">
                    @error('project_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <hr>
        @foreach($steps as $key => $step)
            <input type="hidden" name="step[]" value="{{$step->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>اسم المرحلة</label><span style="color: red;">  *</span>
                        <input type="text" class="form-control" required name="step_name[]" value="{{ $step->step_name }}">
                        @error('step_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            @foreach($multi_project as $key => $multi)
                @if($multi->step_id == $step->id)
                    <input type="hidden" name="multi[]" value="{{$multi->id }}">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>بند الصرف</label><span style="color: red;">  *</span>
                                <input type="text" class="form-control" required name="item_name[]"  value="{{ $multi->item_name }}">
                                @error('item_name')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>قيمة البند</label><span class="text-danger">*</span>
                                <input type="text" class="form-control item-value" name="item_value[]" value="{{ $multi->item_value }}">
                                @error('item_value')
                                <span class="text-danger"> {{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif

            @endforeach
            <hr>
        @endforeach
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>المجموع</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="total" id="total" value="{{ $project->total }}" placeholder="المجموع..." readonly>
                    @error('total')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار القسم </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="section_name" class="form-control" id="section_name">
                            <option value="" selected="" disabled="">اختيار القسم </option>
                            @foreach($sections as $item)
                                <option value="{{ $item->section_name }}" {{ $item->section_name == $project->section_name
                                         ? 'selected' : ''}}>{{ $item->section_name }}</option>
                            @endforeach

                        </select>
                        @error('section_name')
                        <span class="text-danger"> {{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اختيار الموظفين </label><span class="text-danger">*</span>
                    <div class="controls">
                        <select name="user_name[]" multiple="multiple" class="form-control">
                            <option value="" selected="" disabled="">اختيار الموظفين </option>
                            @foreach($project_users as $users)
                                <option value="{{ $users->user_name }}" selected>{{ $users->user_name }}</option>
                            @endforeach
                            @php
                                $users = App\Models\MultiSections::where('section_name', $project->section_name)->get();
                            @endphp
                            @foreach($users as $item)
                                <option value="{{ $item['sections']['name'] }}">{{ $item['sections']['name'] }}</option>
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

        <div class="d-flex justify-content-center" style="gap: 1rem;">
            <input type="submit" class="btn btn-success" value=" حفظ و إرسال">
            <a href="{{ route('back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        </div>
        <br>
    </form>

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
    <script>
        $(document).ready(function() {
            $('select[name="section_name"]').on('change', function() {
                var selectedSection = $(this).val();
                var usersDropdown = $('select[name="user_name[]"]');

                // Make an AJAX request to fetch related user names
                $.ajax({
                    url: '/get-users-by-section',
                    type: 'GET',
                    data: { section_name: selectedSection },
                    success: function(data) {
                        // Clear existing options
                        usersDropdown.empty();

                        // Add new options based on the response
                        $.each(data, function(index, username) {
                            usersDropdown.append($('<option>', {
                                value: username,
                                text: username
                            }));
                        });
                    },
                    error: function() {
                        console.log('Error fetching data.');
                    }
                });
            });
        });
    </script>


@endsection
