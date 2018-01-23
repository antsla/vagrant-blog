<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\Models\User::class, function (Faker $faker) {
    $iUserRole = DB::table('roles')->max('id');

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password = bcrypt($faker->word),
        'role_id' => $iUserRole,
        'flag_banned' => $faker->numberBetween(0, 1),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Article::class, function (Faker $faker) {
    static $iNumArticle = 0;

    $iMinArticleCat = DB::table('articles_categories')->min('id');
    $iMaxArticleCat = DB::table('articles_categories')->max('id');

    $iNumber = $faker->unique()->numberBetween(1, 100);

    return [
        'title' => 'Статья ' . $faker->word . ' ' . $iNumArticle++,
        'text' => $faker->paragraph(),
        'group_id' => random_int($iMinArticleCat, $iMaxArticleCat),
        'created_at' => \Carbon\Carbon::now()->subDays($iNumber),
        'updated_at' => \Carbon\Carbon::now()->subDays($iNumber)
    ];
});
