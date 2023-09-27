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


    @if (session()->has('Add'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم اضافة الصلاحية بنجاح",
                    type: "success"
                });
            }
        </script>
    @endif

    @if (session()->has('edit'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم تحديث بيانات الصلاحية بنجاح",
                    type: "success"
                });
            }
        </script>
    @endif

    @if (session()->has('delete'))
        <script>
            window.onload = function() {
                notif({
                    msg: " تم حذف الصلاحية بنجاح",
                    type: "error"
                });
            }
        </script>
    @endif

    <!-- row -->
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header pb-lg-3">
                    <div class="d-flex justify-content-between">
                        <a class="btn btn-primary btn-sm" href="{{ route('roles.create') }}">إضافة صلاحية </a>
                    </div>
                </div>
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>العمليات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($roles as $key => $role)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm"
                                           href="{{ route('roles.show', $role->id) }}">عرض</a>
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('roles.edit', $role->id) }}">تعديل</a>
                                        @if ($role->name !== 'admin')
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy',
                                                $role->id], 'style' => 'display:inline']) !!}
                                                {!! Form::submit('حذف', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        </div><!--/div-->
    </div><!-- main-content closed -->
@endsection

