<?php

use Illuminate\Database\Seeder;

class ArticlesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        DB::beginTransaction();

        DB::table('articles_categories')->insert([
            'title' => 'WEB-дизайн',
            'parent_id' => '0',
            'level' => '1',
            'path' => '1'
        ]);

        $iId1 = DB::table('articles_categories')->insertGetId([
            'title' => 'Back-end',
            'parent_id' => '0',
            'level' => '1',
            'path' => '2'
        ]);

        $iId2 = DB::table('articles_categories')->insertGetId([
            'title' => 'PHP',
            'parent_id' => $iId1,
            'level' => '2',
            'path' => '2.1'
        ]);

        DB::table('articles_categories')->insert([
            [
                'title' => 'Laravel',
                'parent_id' => $iId2,
                'level' => '3',
                'path' => '2.1.1'
            ],
            [
                'title' => 'Yii',
                'parent_id' => $iId2,
                'level' => '3',
                'path' => '2.1.2'
            ],
        ]);

        DB::table('articles_categories')->insert([
            [
                'title' => 'Python',
                'parent_id' => $iId1,
                'level' => '2',
                'path' => '2.2'
            ],
            [
                'title' => 'Ruby',
                'parent_id' => $iId1,
                'level' => '2',
                'path' => '2.3'
            ],
        ]);

        $iId3 = DB::table('articles_categories')->insertGetId([
            'title' => 'Front-end',
            'parent_id' => '0',
            'level' => '1',
            'path' => '3'
        ]);

        DB::table('articles_categories')->insert([
            'title' => 'HTML',
            'parent_id' => $iId3,
            'level' => '2',
            'path' => '3.1'
        ]);

        DB::commit();
    }
}
