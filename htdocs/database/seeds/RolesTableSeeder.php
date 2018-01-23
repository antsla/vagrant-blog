<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('roles')->insert([
            [
                'name' => 'Администратор'
            ],
            [
                'name' => 'Модератор'
            ],
            [
                'name' => 'Пользователь'
            ]
        ]);
        DB::commit();
    }
}
