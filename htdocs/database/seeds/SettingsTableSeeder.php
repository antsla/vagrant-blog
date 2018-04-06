<?php

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('settings')->insert([
            [
                'name' => 'site_name',
                'value' => 'blankApp'
            ],
            [
                'name' => 'site_author',
                'value' => 'vyacheslav.a'
            ],
            [
                'name' => 'site_author_email',
                'value' => 'slavka20082008@yandex.ru'
            ],
            [
                'name' => 'sit_eurl',
                'value' => 'http://blog-portal.test'
            ],
            [
                'name' => 'env',
                'value' => 'dev'
            ]
        ]);
        DB::commit();
    }
}
