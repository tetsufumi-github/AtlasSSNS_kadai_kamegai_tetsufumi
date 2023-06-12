@extends('layouts.login')

@section('content')
    {{-- フォローしているユーザーのアイコンを表示する。 --}}
    <div class="f_list_cnt">
        <span>Follow List</span>
        <div class="f_list_icons">
        @foreach ($followedUserIds as $userId)
        @php
            $user = App\User::find($userId);
        @endphp
        <a href="/profile?id={{ $user->id }}">
            <img src="{{asset('storage/images/icons/' . $user->images) }}" width="50px" alt="icon">
        </a>
        @endforeach
        </div>
    </div>

    <div class="card-body">
        {{-- フォローの投稿リスト表示 --}}
        @foreach ($posts as $post)
            <div class="media">
                <span class="time_at">{{ date('Y-m-d H:i', strtotime($post->created_at)) }}</span>
                <h5 class="users">
                  <a href="/profile?id={{ $post->user->id }}">
                    <img src="{{asset('storage/images/icons/' . $post->user->images) }}" width="50px" alt="icon"></a>
                    {{ $post->user->username }}
                </h5>
                <div class="media-body">
                    {!! nl2br(e($post->post)) !!}
                </div>
            </div>
        @endforeach
    </div>
@endsection
