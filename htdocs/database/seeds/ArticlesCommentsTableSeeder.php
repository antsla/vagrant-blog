<?php

use Illuminate\Database\Seeder;

class ArticlesCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Добавляются комментарии для последней статьи
        $iIdArticle = DB::table('articles')->max('id');

        DB::beginTransaction();

        DB::table('articles_comments')->insert([
            'article_id' => $iIdArticle,
            'parent_id' => 0,
            'username' => 'Случайный пользователь 1',
            'text' => 'Комментарий от случайного пользователя 1',
            'left_key' => 1,
            'right_key' => 2,
            'level' => 1,
            'created_at' => \Carbon\Carbon::now()->subMinutes(11),
            'updated_at' => \Carbon\Carbon::now()->subMinutes(11)
        ]);

        $iId1 = DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => 0,
            'username' => 'Случайный пользователь 2',
            'text' => 'Комментарий от случайного пользователя 2',
            'left_key' => 3,
            'right_key' => 10,
            'level' => 1,
            'created_at' => \Carbon\Carbon::now()->subMinutes(7),
            'updated_at' => \Carbon\Carbon::now()->subMinutes(7)
        ]);

        $iId2 = DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => 0,
            'username' => 'Случайный пользователь 3',
            'text' => 'Комментарий от случайного пользователя 3',
            'left_key' => 11,
            'right_key' => 14,
            'level' => 1,
            'created_at' => \Carbon\Carbon::now()->subMinutes(5),
            'updated_at' => \Carbon\Carbon::now()->subMinutes(5)
        ]);

        $iId3 = DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => $iId1,
            'username' => 'Случайный пользователь 4',
            'text' => 'Комментарий от случайного пользователя 4',
            'left_key' => 4,
            'right_key' => 9,
            'level' => 2,
            'created_at' => \Carbon\Carbon::now()->subMinutes(4),
            'updated_at' => \Carbon\Carbon::now()->subMinutes(4)
        ]);

        $iId4 = DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => $iId3,
            'username' => 'Случайный пользователь 2',
            'text' => 'Еще один комментарий от случайного пользователя 2',
            'left_key' => 5,
            'right_key' => 8,
            'level' => 3,
            'created_at' => \Carbon\Carbon::now()->subMinutes(2),
            'updated_at' => \Carbon\Carbon::now()->subMinutes(2)
        ]);

        DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => $iId4,
            'username' => 'Случайный пользователь 5',
            'text' => 'Комментарий от случайного пользователя 5',
            'left_key' => 6,
            'right_key' => 7,
            'level' => 4,
            'created_at' => \Carbon\Carbon::now()->subMinute(),
            'updated_at' => \Carbon\Carbon::now()->subMinute()
        ]);

        DB::table('articles_comments')->insertGetId([
            'article_id' => $iIdArticle,
            'parent_id' => $iId2,
            'username' => 'Случайный пользователь 6',
            'text' => 'Комментарий от случайного пользователя 6',
            'left_key' => 12,
            'right_key' => 13,
            'level' => 2,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        DB::commit();

    }
}
