<?php

// php artisan make:seeder UsersTableSeederでシードファイル作成コマンド入力
// （usersテーブルに初期ユーザーのデータを登録する。）



use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'username' => 'kihon taro',
                'mail' => 'taro_mail@example.com',
                'password' => Hash::make('password123'),
                'bio' => 'たろうです。よろしくお願いいたします。',
                'images' => 'icon1.png',
            ]
        ]);
    }
}
?>
