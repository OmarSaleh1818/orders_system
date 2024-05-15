@extends('main_master')
@section('title')
    إضافة مستخدم
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ إضافة مستخدم </span>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <!-- row -->
    <div class="row">


        <div class="col-lg-12 col-md-12">

            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <button aria-label="Close" class="close" data-dismiss="alert" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <strong>خطا</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12 margin-tb">
                        <div class="pull-right">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.index') }}">رجوع</a>
                        </div>
                    </div>
                    <br>
                    <br>
                    <form class="parsley-style-1" id="selectForm2" autocomplete="off" name="selectForm2"
                          action="{{route('users.store','test')}}" method="post">
                        {{csrf_field()}}

                        <div class="row">
                                <div class="col-md-6" id="fnWrapper">
                                    <label>اسم المستخدم: <span style="color: red;">  *</span></label>
                                    <input class="form-control"
                                           data-parsley-class-handler="#lnWrapper" name="name" required="" type="text">
                                </div>

                                <div class="col-md-6" id="lnWrapper">
                                    <label>البريد الالكتروني: <span style="color: red;">  *</span></label>
                                    <input class="form-control"
                                           data-parsley-class-handler="#lnWrapper" name="email" required="" type="email">
                                </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-6" id="lnWrapper">
                                <label>كلمة المرور:  <span style="color: red;">  *</span></label>
                                <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                       name="password" required="" type="password">
                            </div>

                            <div class="col-md-6" id="lnWrapper">
                                <label> تأكيد كلمة المرور: <span style="color: red;">  *</span></label>
                                <input class="form-control" data-parsley-class-handler="#lnWrapper"
                                       name="confirm-password" required="" type="password">
                            </div>
                        </div>
<br>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">حالة المستخدم</label>
                                <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                    <option value="مفعل">مفعل</option>
                                    <option value="غير مفعل">غير مفعل</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5>اختيار القسم <span class="text-danger">*</span></h5>
                                    <div class="controls">
                                        <select name="section_name[]" multiple="multiple" class="form-control">
                                            <option value="" selected="" disabled="">اختيار القسم</option>
                                            @foreach($section as $item)
                                                <option value="{{ $item->section_name }}">{{ $item->section_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('section_name')
                                        <span class="text-danger"> {{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mg-b-20">
                            <div class="col-xs-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label"> صلاحية المستخدم</label>
                                    {!! Form::select('roles_name[]', $roles,[], array('class' => 'form-control','multiple')) !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                            <button class="btn btn-primary" type="submit">تأكيد</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection

