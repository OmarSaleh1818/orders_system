@extends('main_master')
@section('title')
    مقدم الطلب
@endsection
@section('page-header')
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto p-4">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">طلبات الصرف</h4><span class="text-muted mt-1 tx-13 mr-3 mb-0">/  الطلبات </span>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @if(Session()->has('status'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <strong>{{ Session()->get('status') }}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">

            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-lg-3">
                    @can('إضافة طلب صرف')
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('add.order') }}" class="btn btn-primary">إضافة طلب صرف</a>
                    </div>
                    @endcan
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="section_filter">ابحث بالقسم</label>
                            <select id="section_filter" class="form-control">
                                <option value='' >جميع الأقسام</option>
                                @foreach($sections as $section)
                                    <option value="{{ $section->section_name }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>التاريخ</th>
                            <th>القسم</th>
                            <th>المبلغ</th>
                            <th>مستوى الأولوية</th>
                            <th>الحالة</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applicants as $key => $item)
                            @php
                                $canApprove = Gate::check('اعتماد مدير المشروع لطلب الصرف') || Gate::check('اعتماد المدير المالي لطلب الصرف')
                                || Gate::check('تنفيذ طلب الصرف') || Gate::check('اعتماد المدير لطلب الصرف');

                                $user_id = Auth::user()->id;
                                $employee = App\Models\Applicant::where('user_id', $user_id)->where('id', $item->id)->first();
                            @endphp
                            @if($canApprove)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->priority_level }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> في انتظار مدير المشروع <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد مدير المشروع <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد الصرف <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 5)
                                            @php
                                                $attachment = App\Models\Finance::where('applicant_id',$item->id)->first();
                                            @endphp
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم تنفيذ الطلب <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                            @can('تحميل طلب صرف')
                                            <a href="{{ asset($attachment->attachment) }}" class="btn btn-primary">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                                            @endcan
                                        @elseif($item->status_id == 8)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled>  تم إرسال الاستفسار <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 9)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 10)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم التأجيل   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 11)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @elseif($employee)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->section_name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->priority_level }}</td>
                                    <td>
                                        @if($item->status_id == 1)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled> في انتظار مدير المشروع <i class="far fa-clock" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 2)
                                            <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" disabled>  غير معتمد <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 3)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد الطلب <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 6)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد المدير  <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 4)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم اعتماد الصرف <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 5)
                                            @php
                                                $attachment = App\Models\Finance::where('applicant_id',$item->id)->first();
                                            @endphp
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-success" disabled>  تم تنفيذ الطلب <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                            <a href="{{ asset($attachment->attachment) }}" class="btn btn-primary">تحميل  <i class="fa fa-download" aria-hidden="true"></i></a>
                                        @elseif($item->status_id == 8)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-secondary" disabled>  تم إرسال الاستفسار <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 9)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إرسال الرد   <i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 10)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم التأجيل   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 11)
                                            <a href="{{ route('applicant.eye', $item->id) }}" class="btn btn-info"> عرض <i class="fa fa-eye"></i></a>
                                            <button class="btn btn-dark" disabled>تم إعادة الإرسال   <i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                                        @elseif($item->status_id == 12)
                                            <a href="{{ route('applicant.edit', $item->id) }}" class="btn btn-warning"> تعديل <i class="fa fa-pencil"></i></a>
                                            <button class="btn btn-danger" disabled>  لم يتم اعتماد الصرف <i class="fa fa-times-circle" aria-hidden="true"></i></button>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

<script>
    $(document).ready(function() {
        $('#section_filter').on('change', function() {
            var sectionName = $(this).val();

            $.ajax({
                url: "{{ route('applicants.filter') }}", // Ensure you have this route set up
                type: "GET",
                data: { section_name: sectionName },
                success: function(response) {
                    var applicantsTable = $('#example1 tbody');
                    applicantsTable.empty(); // Clear the current table rows

                    if(response.applicants.length > 0) {
                        $.each(response.applicants, function(index, applicant) {
                            var buttons = '';

                            // Check the status of each applicant to append the correct buttons
                            if (applicant.status_id == 1) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-secondary" disabled>في انتظار مدير المشروع <i class="far fa-clock"></i></button>
                                `;
                            } else if (applicant.status_id == 2) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger" disabled>غير معتمد <i class="fa fa-times-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 3) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>تم اعتماد مدير المشروع <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 4) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>تم اعتماد الصرف <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 5) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>تم تنفيذ الطلب <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 6) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-success" disabled>تم اعتماد المدير <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 8) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-secondary" disabled>تم إرسال الاستفسار <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 9) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم إرسال الرد <i class="fa fa-check-circle"></i></button>
                                `;
                            } else if (applicant.status_id == 10) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم التأجيل <i class="fa fa-dot-circle-o"></i></button>
                                `;
                            } else if (applicant.status_id == 11) {
                                buttons = `
                                    <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-dark" disabled>تم إعادة الإرسال <i class="fa fa-dot-circle-o"></i></button>
                                `;
                            } else if (applicant.status_id == 12) {
                                buttons = `
                                     <a href="/applicant/applicant/eye/${applicant.id}" class="btn btn-info">عرض <i class="fa fa-eye"></i></a>
                                    <button class="btn btn-danger" disabled>غير معتمد <i class="fa fa-times-circle"></i></button>
                                `;
                            }

                            // Append the new row to the table
                            applicantsTable.append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${applicant.date}</td>
                                    <td>${applicant.section_name}</td>
                                    <td>${applicant.price}</td>
                                    <td>${applicant.priority_level}</td>
                                    <td>${buttons}</td>
                                </tr>
                            `);
                        });
                    } else {
                        applicantsTable.append('<tr><td colspan="6">لا توجد بيانات لهذا القسم</td></tr>');
                    }
                }
            });
        });
    });

</script>

@endsection
