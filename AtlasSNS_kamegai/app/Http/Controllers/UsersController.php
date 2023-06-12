<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Follow;
use App\Post;

class UsersController extends Controller
{

    public function profile(Request $request)
    {
        // 現在ログイン中のユーザーIDを取得します。
        $userId = auth()->user()->id;

        // 現在ログイン中のユーザープロフィール情報を取得します。
        $user = User::find($userId);

        if ($request->isMethod('post')) {
            // フォームから送信されたデータを取得します。
            $username = $request->input('username');
            $mail = $request->input('mail');
            $newPassword = $request->input('new_password');
            $bio = $request->input('bio');

            // ユーザープロフィールを更新します。
            $user->username = $username;
            $user->mail = $mail;
            $user->bio = $bio;

            if (!empty($newPassword)) {
                $user->password = bcrypt($newPassword);
            }

            // 画像アップロードとシンボリックリンク
            if ($request->hasFile('image')) {
                //$request->file('image') はアップロードされたファイルを表します。
                // getClientOriginalName() メソッドは、アップロードされたファイルの元の名前を取得します。
                $profileImage = $request->file('image')->getClientOriginalName();

                // storageフォルダ内のpublicディレクトリに保存する。
                // storeAs() メソッドは、アップロードされたファイルを指定のディレクトリに保存します。ここでは public/images/icons ディレクトリに保存されます。
                $publicImagePath = $request->file('image')->storeAs('public/images/icons', $profileImage);

                // str_replace() 関数は、文字列内の特定の部分を別の文字列で置換します。ここでは 'public/' を空文字列に置換しています。
                $publicImagePath = str_replace('public/', '', $publicImagePath);

                // $user->images には、プロフィール画像のファイル名が代入されます。
                $user->images = $profileImage;
            }

            // プロフィールを保存します。
            $user->save();

            return redirect('/top');
        }

        // 現在ログイン中のフォロー数とフォロワー数を表示します。
        $followCount = Follow::where('following_id', $userId)->count();
        $followerCount = Follow::where('followed_id', $userId)->count();

        // 現在ログイン中のユーザー情報を取得します。
        $specifiedUser = User::find($_GET['id']);

        // 現在ログイン中のユーザー投稿を表示します。
        $posts = Post::whereIn('user_id', $specifiedUser)->latest()->get();

        return view('users.profile', compact('followCount', 'followerCount', 'user', 'specifiedUser', 'posts'));
    }

    public function search(Request $request)
    {
        // 検索キーワードを取得します。
        $keyword = $request->input('keyword');
        $userId = auth()->user()->id;

        // フォロー数とフォロワー数を表示します。
        $followCount = Follow::where('following_id', $userId)->count();
        $followerCount = Follow::where('followed_id', $userId)->count();

        // 検索フォームで、あいまいに入力されたユーザー名に一致するユーザーを取得します。
        $users = User::where('username', 'like', '%' . $keyword . '%')
            ->where('id', '!=', $userId)
            ->get();

        return view('users.search', compact('users', 'keyword', 'followCount', 'followerCount'));
    }
}
