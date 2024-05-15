<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $permissions = [

            'طلبات الصرف',
            'إضافة طلب صرف',
            'تعديل طلب صرف' ,
            'عرض طلب صرف',
            'تحميل طلب صرف',
            'اعتماد مدير المشروع لطلب الصرف',
            'اعتماد المدير المالي لطلب الصرف' ,
            'تنفيذ طلب الصرف' ,
            'تسعير المشاريع',
            'إضافة تسعيرة',
            'تعديل تسعيرة',
            'عرض تسعيرة',
            'اعتماد المدير المالي للتسعيرة',
            'اعتماد المدير للتسعيرة',
            'المشاريع',
            'فتح مشروع',
            'إضافة فتح مشروع',
            'تعديل فتح مشروع',
            'عرض المشروع',
            'اعتماد القانونية للمشروع',
            'اعتماد المدير لفتح المشروع',
            'اعتماد المدير المالي لفتح المشروع',
            'بدء مشروع',
            'إضافة بدء مشروع',
            'تعديل بدء مشروع',
            'اعتماد المدير المالي لبدء المشروع',
            'اعتماد المدير لبدء المشروع',
            'الإعدادات',
            'إضافة مستخدم',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',
        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }

    }
}
