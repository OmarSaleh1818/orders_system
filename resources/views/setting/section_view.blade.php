@extends('main_master')
@section('title')
    الأقسام
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/  الاقسام </span>
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
        <div class="col-8">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>اسم القسم</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->section_name }}</td>
                            <td>
                                <a href="{{ route('section.edit', $item->id) }}" class="btn btn-info"> تعديل <i class="fa fa-pen"></i>  </a>
                                <a href="{{ route('section.delete', $item->id) }}" class="btn btn-danger" id="delete"> حذف <i class="fa fa-trash"></i>  </a>
                            </td>
                        </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-4">
            <div class="card">

                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" action="{{ route('section.store') }}">
                        @csrf
                        <div class="form-group">
                            <label>اسم القسم</label><span style="color: red;">  *</span>
                            <input type="text" class="form-control" name="section_name" placeholder="اسم القسم..." required>
                            @error('section_name')
                            <span class="text-danger"> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <input type="submit" class="btn btn-info" value="اضافة القسم">
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
