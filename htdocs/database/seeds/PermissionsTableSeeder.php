<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('permissions')->insert([
            [
                'name' => 'EDIT_ARTICLES',
                'alias' => 'Редактирвоание статей'
            ],
            [
                'name' => 'EDIT_ARTICLES_CATEGORIES',
                'alias' => 'Редактирвоание категорий статей'
            ],
            [
                'name' => 'EDIT_SLIDER',
                'alias' => 'Редактирвоание слайдера'
            ],
            [
                'name' => 'PARSING_FILES',
                'alias' => 'Парсинг файлов'
            ],
            [
                'name' => 'EDIT_SETTINGS',
                'alias' => 'Редактирвоание настроек'
            ],
            [
                'name' => 'EDIT_USERS',
                'alias' => 'Редактирвоание пользователей'
            ],
            [
                'name' => 'FEEDBACK_RESPONSE',
                'alias' => 'Ответ на отзывы'
            ],
        ]);
        DB::commit();
    }
}
