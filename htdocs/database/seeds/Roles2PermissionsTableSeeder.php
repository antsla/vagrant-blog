<?php

use Illuminate\Database\Seeder;

class Roles2PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aRoles = DB::table('roles')->get();
        $aPermissions = DB::table('permissions')->get();

        DB::beginTransaction();
        foreach ($aRoles as $aRole) {
            if ($aRole->name === 'Администратор') {
                foreach ($aPermissions as $aPermission) {
                    DB::table('roles2permissions')->insert([
                        'role_id' => $aRole->id,
                        'permission_id' => $aPermission->id
                    ]);
                }
            } else if ($aRole->name === 'Модератор') {
                foreach ($aPermissions as $aPermission) {
                    if (in_array($aPermission->name, ['EDIT_ARTICLES', 'EDIT_ARTICLES_GROUPS', 'EDIT_SLIDER', 'PARSING_FILES'])) {
                        DB::table('roles2permissions')->insert([
                            'role_id' => $aRole->id,
                            'permission_id' => $aPermission->id
                        ]);
                    }
                }
            }
        }
        DB::commit();
    }
}
