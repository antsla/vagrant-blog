<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ArticleComment::class, function(Faker $faker) {
    $iRandomArticleID = DB::table('articles')->take(1)->inRandomOrder()->get()->first()->id;

    return [
        'article_id' => (int) $iRandomArticleID,
        'username' => $faker->name,
        'text' => $faker->paragraph()
    ];
});