@extends('main_master')
@section('title')
    تعديل مستخدم
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل مستخدم </span>
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
                    </div><br>
                    <br>
                    {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

                    <div class="row">
                        <div class="col-md-6" id="fnWrapper">
                            <label>اسم المستخدم: <span style="color:red">*</span></label>
                            {!! Form::text('name', null, array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="col-md-6" id="lnWrapper">
                            <label>البريد الالكتروني: <span style="color:red">*</span></label>
                            {!! Form::text('email', null, array('class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6" id="lnWrapper">
                            <label>كلمة المرور: <span style="color:red">*</span></label>
                            {!! Form::password('password', array('class' => 'form-control','required')) !!}
                        </div>

                        <div class="col-md-6" id="lnWrapper">
                            <label> تاكيد كلمة المرور: <span style="color:red">*</span></label>
                            {!! Form::password('confirm-password', array('class' => 'form-control','required')) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label">حالة المستخدم</label>
                            <select name="Status" id="select-beast" class="form-control  nice-select  custom-select">
                                <option value="{{ $user->Status}}">{{ $user->Status}}</option>
                                <option value="مفعل">مفعل</option>
                                <option value="غير مفعل">غير مفعل</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>نوع المستخدم</strong>
                                {!! Form::select('roles[]', $roles,$userRole, array('class' => 'form-control','multiple'))
                                !!}
                            </div>
                        </div>
                    </div>
                    <div class="mg-t-30">
                        <button class="btn btn-primary" type="submit">تحديث</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <!-- row closed -->
@endsection

