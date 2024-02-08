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

            'مقدم الطلب',
            'مدير المشروع',
            'اعتماد الطلبات',
            'المشاريع',
            'إضافة مشروع',
            'المدير المالي',
            'معتمد الصرف' ,
            'معتمد المشروع',
            'المحاسب',
            'منفذ الطلب',
            'الإعدادات' ,
            'الأقسام' ,
            'إضافة مستخدم',
            'قائمة المستخدمين',
            'صلاحيات المستخدمين',

        ];



        foreach ($permissions as $permission) {

            Permission::create(['name' => $permission]);
        }

    }
}
