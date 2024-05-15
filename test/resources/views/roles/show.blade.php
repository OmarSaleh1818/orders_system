@extends('main_master')
@section('title')
    عرض الصلاحيات
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">الإعدادات</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/ صلاحيات المستخدمين </span>
            </div>
        </div>
    </div>
@endsection
@section('content')

    <!-- row -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-lg-3">
                    <div class="d-flex justify-content-between">
                            <a class="btn btn-primary" href="{{ route('roles.index') }}">رجوع</a>
                    </div>
                </div>
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-4">
                        <ul id="treeview1">
                            <li><a href="#">{{ $role->name }}</a>
                                <ul>
                                    @if(!empty($rolePermissions))
                                        @foreach($rolePermissions as $v)
                                            <li>{{ $v->name }}</li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <!-- /col -->
                </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->

@endsection

