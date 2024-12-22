<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateRolePermission extends Command
{
    // Название и описание команды
    protected $signature = 'permission:create {role} {permission?*}';
    protected $description = 'Create a role with optional permission';

    public function handle()
    {
        // Получение аргументов
        $roleName = $this->argument('role');
        $permissions = $this->argument('permission');

        // Создание роли
        $role = Role::firstOrCreate(['name' => $roleName]);
        $this->info("Role '{$roleName}' created or already exists.");

        // Создание разрешений и привязка их к роли (если есть)
        if (!empty($permissions)) {
            foreach ($permissions as $permissionName) {
                $permission = Permission::firstOrCreate(['name' => $permissionName]);
                $role->givePermissionTo($permission);
                $this->info("Permission '{$permissionName}' created and assigned to role '{$roleName}'.");
            }
        }

        $this->info('Operation completed successfully.');
    }
}
