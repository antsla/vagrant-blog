<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new App\Models\User();
        $user->name = 'admin';
        $user->password = Hash::make('123456');
        $user->email = 'slavka20082008@yandex.ru';
        $user->role_id = DB::table('roles')->min('id');
        $user->save();

        $user = new App\Models\User();
        $user->name = 'moderator';
        $user->password = Hash::make('123456');
        $user->email = 'slavka20082008@gmail.com';
        $user->role_id = DB::table('roles')->take(1)->skip(1)->get()->first()->id;
        $user->save();

        factory(App\Models\User::class, 14)->create();
    }
}
