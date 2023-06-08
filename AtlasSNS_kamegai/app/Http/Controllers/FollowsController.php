<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Follow;
use App\Post;

class FollowsController extends Controller
{


    public function followList()
    {
        // ログインしているユーザーのIDを取得
        $userId = auth()->user()->id;

        // フォロー数とフォロワー数を表示する
        $followCount = Follow::where('following_id', $userId)->count();
        $followerCount = Follow::where('followed_id', $userId)->count();

        // フォローしているユーザーのアイコンを取得
        $followedUserIds = Follow::where('following_id', $userId)->pluck('followed_id');
        $posts = Post::whereIn('user_id', $followedUserIds)->latest()->get();

        return view('follows.followList', compact('followCount', 'followerCount', 'followedUserIds', 'posts'));
    }



    public function followerList()
    {
        // ログインしているユーザーのIDを取得
        $userId = auth()->user()->id;

        // フォロー数とフォロワー数を表示する
        $followCount = Follow::where('following_id', $userId)->count();
        $followerCount = Follow::where('followed_id', $userId)->count();

        $followerUserIds = Follow::where('followed_id', $userId)->pluck('following_id');
        // フォロワーの投稿のみを取得
        $posts = Post::whereIn('user_id', $followerUserIds)->latest()->get();

        return view('follows.followerList', compact('followCount', 'followerCount', 'followerUserIds', 'posts'));
    }




    public function follow(Request $request)
    {
        // フォローするユーザーのIDを取得
        $followingId = auth()->user()->id;

        // リクエストからフォローされるユーザーのIDを取得
        $followedId = $request->input('user_id');

        // Followモデルの新しいインスタンスを作成
        $follow = new Follow();

        // フォローしているユーザーのIDを設定
        $follow->following_id = $followingId;

        // フォローされるユーザーのIDを設定
        $follow->followed_id = $followedId;

        // Followモデルを保存
        $follow->save();

        // フォローされた状態を示す変数を設定
        $followed = true;

        // JSONレスポンスとしてフォローされた状態を返す
        return response()->json(['followed' => $followed]);
    }

    public function unfollow(Request $request)
    {
        // フォローを解除するユーザーのIDを取得
        $followingId = auth()->user()->id;

        // リクエストからフォロー解除されるユーザーのIDを取得
        $followedId = $request->input('user_id');

        // following_idとfollowed_idの両方が一致するFollowモデルを取得
        $follow = Follow::where('following_id', $followingId)->where('followed_id', $followedId)->first();

        // Followモデルを削除
        $follow->delete();

        // フォロー解除された状態を示す変数を設定
        $followed = false;

        // JSONレスポンスとしてフォロー解除された状態を返す
        return response()->json(['followed' => $followed]);
    }
}
