@extends('main_master')
@section('title')
    تعديل القسم
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ تعديل القسم </span>
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
        <div class="col-6">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="{{ route('section.update', $section->id) }}">
                        @csrf
                        <div class="form-group">
                            <label>اسم القسم</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="section_name" value="{{ $section->section_name }}" placeholder="اسم القسم...">
                            @error('section_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <input type="submit" class="btn btn-info" value="تعديل القسم">
                        </div>
                        <br>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
@endsection
