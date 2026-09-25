<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions definitions
        $permissions = [
            // Master Data
            'view_master_data',
            'manage_master_data',

            // Layanan & Pengajuan
            'view_service_requests',
            'create_service_requests',
            'verify_service_requests',
            'approve_service_requests',

            // DTSEN & PBI
            'verify_dtsen_certificates',
            'sign_dtsen_certificates',
            'verify_pbi_reactivations',
            'sign_pbi_reactivations',

            // Rehsos
            'view_rehabilitation_cases',
            'manage_rehabilitation_cases',
            'view_clients',
            'manage_clients',

            // Pengaduan
            'view_complaints',
            'create_complaints',
            'handle_complaints',

            // Informasi Layanan & Konten
            'manage_information_pages',

            // Dashboard & Laporan
            'view_dashboard',
            'view_reports',
            'export_reports',

            // User Management
            'manage_users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles definitions
        $adminRole = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        $petugasRole = Role::firstOrCreate(['name' => 'petugas_dinsos', 'guard_name' => 'web']);
        $petugasRole->syncPermissions([
            'view_master_data',
            'view_service_requests',
            'create_service_requests',
            'verify_service_requests',
            'verify_dtsen_certificates',
            'verify_pbi_reactivations',
            'view_rehabilitation_cases',
            'manage_rehabilitation_cases',
            'view_clients',
            'manage_clients',
            'view_complaints',
            'handle_complaints',
            'manage_information_pages',
            'view_dashboard',
            'view_reports',
            'export_reports',
        ]);

        $pejabatRole = Role::firstOrCreate(['name' => 'pejabat_penandatangan', 'guard_name' => 'web']);
        $pejabatRole->syncPermissions([
            'view_service_requests',
            'approve_service_requests',
            'sign_dtsen_certificates',
            'sign_pbi_reactivations',
            'view_dashboard',
            'view_reports',
        ]);

        $pimpinanRole = Role::firstOrCreate(['name' => 'pimpinan', 'guard_name' => 'web']);
        $pimpinanRole->syncPermissions([
            'view_service_requests',
            'view_rehabilitation_cases',
            'view_complaints',
            'view_dashboard',
            'view_reports',
            'export_reports',
        ]);

        $operatorRole = Role::firstOrCreate(['name' => 'operator_daerah', 'guard_name' => 'web']);
        $operatorRole->syncPermissions([
            'view_service_requests',
            'create_service_requests',
            'view_complaints',
            'create_complaints',
            'view_dashboard',
        ]);

        $masyarakatRole = Role::firstOrCreate(['name' => 'masyarakat', 'guard_name' => 'web']);
        $masyarakatRole->syncPermissions([
            'create_service_requests',
            'create_complaints',
        ]);
    }
}
