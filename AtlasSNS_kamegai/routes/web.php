<?php
// 名前空間。
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();


# ログアウト中のページ
# ログイン画面表示
Route::get('/login', 'Auth\LoginController@login');
# ログイン処理
Route::post('/login', 'Auth\LoginController@login');

# 新規登録画面表示
Route::get('/register', 'Auth\RegisterController@register');
# 新規登録処理
Route::post('/register', 'Auth\RegisterController@register');

# 登録完了画面表示
Route::get('/added', 'Auth\RegisterController@added');
# 登録完了処理
Route::post('/added', 'Auth\RegisterController@added');

# ログイン中のページ
# 認証を要求するミドルウェアを適用したルートグループ
Route::middleware(['auth'])->group(function () {

    # トップページ表示
    Route::get('/top', 'PostsController@index');

    # ユーザー投稿の処理
    # 投稿一覧表示
    Route::get('/', 'PostsController@index')->name('posts.index');
    # 投稿作成処理
    Route::post('/store', 'PostsController@store')->name('posts.store');

    # 投稿編集処理
    Route::put('/posts/{post}', 'PostsController@update')->name('posts.update');

    # 投稿削除処理
    # 削除以外のリソースルートを生成
    Route::resource('posts', 'PostsController')->except(['destroy']);
    # 投稿削除処理
    Route::delete('posts/{post}', 'PostsController@destroy')->name('posts.destroy');

    # 検索画面表示
    Route::get('/search', 'UsersController@search')->name('search');

    # フォローリスト表示
    Route::get('/followList', 'FollowsController@followList');
    # フォロワーリスト表示
    Route::get('/followerList', 'FollowsController@followerList');

    # フォロー処理
    Route::post('/follow', 'FollowsController@follow')->name('follow');
    # フォロー解除処理
    Route::post('/unfollow', 'FollowsController@unfollow')->name('unfollow');

    # プロフィール表示
    Route::get('/profile', 'UsersController@profile')->name('profile');
    # プロフィール更新処理
    Route::post('/profile', 'UsersController@profile')->name('profile.update');

    # ログアウト処理
    Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
});
