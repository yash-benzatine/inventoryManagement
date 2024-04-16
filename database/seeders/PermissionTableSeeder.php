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
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'customer-list',
           'customer-create',
           'customer-edit',
           'customer-delete',
           'supplier-list',
           'supplier-create',
           'supplier-edit',
           'supplier-delete',
           'tax-list',
           'tax-create',
           'tax-edit',
           'tax-delete',
           'profile-list',
           'profile-create',
           'profile-edit',
           'profile-delete',
           'category-list',
           'category-create',
           'category-edit',
           'category-delete',
           'product-list',
           'product-create',
           'product-edit',
           'product-delete',
           'manage-purchase-list',
           'purchase-history',
           'manage-sales-list',
           'sales-history',
           'setting-list',
           'purchase-report',
        ];

        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
