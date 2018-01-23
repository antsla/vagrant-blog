<?php

use Illuminate\Database\Seeder;

class SliderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::beginTransaction();
        DB::table('slider')->insert([
            [
                'img' => 'bQunSrDDA6bLdPhlp8uv.jpg',
                'text' => 'Тестовый слайд 1',
                'sort' => 1
            ],
            [
                'img' => 'S5uJhpABhVwE3V812wUt.jpg',
                'text' => '',
                'sort' => 2
            ],
            [
                'img' => 'WJr4zC3RSZ7HASXOgxhm.jpg',
                'text' => 'Тестовый слайд 3',
                'sort' => 3
            ],
        ]);
        DB::commit();
    }
}
