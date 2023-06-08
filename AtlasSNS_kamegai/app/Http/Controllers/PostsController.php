<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Follow;

class PostsController extends Controller
{
    // 投稿一覧表示
    public function index()
    {
        // 現在のユーザーのIDを取得します。
        $userId = auth()->user()->id;

        // フォロー数とフォロワー数を表示するために、データベースから対応するレコードの数を取得します。
        $followCount = Follow::where('following_id', $userId)->count();
        $followerCount = Follow::where('followed_id', $userId)->count();

        // 最新の投稿を取得します。
        $posts = Post::latest()->get();

        // 取得したデータをビューに渡して、投稿一覧ページを表示します。
        return view('posts.index', compact('posts', 'followCount', 'followerCount'));
    }

    // 投稿作成
    public function store(Request $request)
    {
        // バリデーションを行います。postフィールドは必須で、最大150文字まで許可されています。
        $request->validate([
            'post' => 'required|string|max:150',
        ]);

        // 新しい投稿モデルを作成し、データベースに保存します。
        $post = new Post;
        $post->user_id = auth()->user()->id;
        $post->post = $request->post;
        $post->save();

        // 投稿一覧ページにリダイレクトします。
        return redirect()->route('posts.index');
    }

    // 投稿更新
    public function update(Request $request, Post $post)
    {
        // バリデーションを行います。postフィールドは必須で、1文字以上150文字以下である必要があります。
        $request->validate([
            'post' => 'required|string|min:1|max:150',
        ]);

        // 投稿モデルの内容を更新し、データベースに保存します。
        $post->post = $request->post;
        $post->save();

        // 投稿一覧ページにリダイレクトします。
        return redirect()->route('posts.index');
    }

    // 投稿削除
    public function destroy(Post $post)
    {
        // 投稿の所有者と現在のユーザーが一致するか確認します。
        // 一致する場合、投稿を削除します。
        if ($post->user_id === auth()->user()->id) {
            $post->delete();
        }

        // 投稿一覧ページにリダイレクトします。
        return redirect()->route('posts.index');
    }
}
