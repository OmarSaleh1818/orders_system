@extends('main_master')
@section('title')
    عرض المشروع
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">  المدير المالي</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ عرض المشروع </span>
            </div>
        </div>

    </div>
@endsection

@section('content')
    @if(Session()->has('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ Session()->get('status') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
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
    @foreach($steps as $step)
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>اسم المرحلة</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="step_name[]" value="{{ $step->step_name }}" readonly>
                    @error('step_name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        @foreach($multi_project as $multi)
            @if($multi->step_id == $step->id)
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
            @endif

        @endforeach
        <hr>
    @endforeach


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
                <label> القسم </label><span class="text-danger">*</span>
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
    <div class="row">
        @php
            $project_user = App\Models\projects::groupBy('user_id')->pluck('user_id');
        @endphp
        <div class="col-md-6">
            <form method="post" action="{{ route('project.update.manager', $project->id) }}">
                @csrf
                <div class="form-group">
                    <label for="project_name">مدير المشروع </label><span style="color: red;"> *</span>
                    <select name="user_id" class="form-control">
                        <option value="" selected="" disabled="">مدير المشروع</option>
                        @foreach ($project_user as $user_id)
                            @php
                                $user = App\Models\User::find($user_id);
                            @endphp
                            <option value="{{ $user->id }}" {{ $user->id == $project->user_id ? 'selected' : ''}}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
                <input type="submit" class="btn btn-primary" value=" إسناد المشروع">
            </form>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label> الموظفين </label><span class="text-danger">*</span>
                <div class="controls">
                    <select name="user_name[]" multiple="multiple" class="form-control">
                        @foreach($project_users as $users)
                            <option value="{{ $users->user_name }}" disabled>{{ $users->user_name }}</option>
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
        @if($project->status_id == 1)
            <a href="{{ route('project.sure', $project->id) }}" class="btn btn-success" id="sure"> معتمد </a>
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#m_modal_1">
                غير معتمد
            </button>
            <a href="{{ route('project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 2)
            <td> <button class="btn btn-danger" disabled> غير معتمد</button></td>
            <a href="{{ route('project.back') }}" class="btn btn-info">الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @elseif($project->status_id == 6)
            <td> <button class="btn btn-success" disabled> تم الاعتماد</button></td>
            <a href="{{ route('project.back') }}" class="btn btn-info"> الرجوع <i class="fa fa-arrow-left" aria-hidden="true"></i></a>
        @endif
    </div>
    <br>
    <div class="modal fade" id="m_modal_1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLabel"><strong> سبب عدم الاعتماد</strong></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('project.reject', $project->id) }}">
                    @csrf

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
