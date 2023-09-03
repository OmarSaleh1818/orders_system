@extends('main_master')
@section('title')
    المستخدمين
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/  المستخدمين </span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <form method="post" action="{{ route('users.store') }}">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> اسم المستخدم</label><span style="color: red;">  *</span>
                    <input type="text" class="form-control" required name="name" placeholder=" اسم المستخدم...">
                    @error('name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>البريد الالكتروني</label><span style="color: red;">  *</span>
                    <input type="email" class="form-control" required name="email" placeholder=" البريد الالكتروني ...">
                    @error('name')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
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
            <div class="col-md-6">
                <div class="form-group">
                    <label>كلمة المرور</label><span style="color: red;">  *</span>
                    <input type="password" class="form-control" required name="password" placeholder="كلمة المرور...">
                    @error('password')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label> تـأكيد كلمة المرور</label><span class="text-danger">*</span>
                    <input type="password" class="form-control" name="confirm-password" placeholder=" تأكيد كلمة المرور...">
                    @error('confirm-password')
                    <span class="text-danger"> {{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <br>

        <div class="d-flex justify-content-between">
            <input type="submit" class="btn btn-info" value=" تأكيد">
        </div>
        <br>
    </form>

@endsection
