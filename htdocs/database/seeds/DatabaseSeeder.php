<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ArticlesCategoriesTableSeeder::class,
            ArticlesTableSeeder::class,
            ArticlesCommentsTableSeeder::class,
            SliderTableSeeder::class,
            PermissionsTableSeeder::class,
            Roles2PermissionsTableSeeder::class,
            SettingsTableSeeder::class,
        ]);
    }
}
