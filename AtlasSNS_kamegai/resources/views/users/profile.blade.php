@extends('layouts.login')

@section('content')

{{-- プロフィール編集 --}}
@if ($_GET['id'] == Auth::user()->id)
    <figure class="p_icon">
    <img src="{{ asset('storage/images/icons/' . Auth::user()->images)}}" alt="icon" width="50px">
    </figure>
    <div class="p_from_cnt">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="item_cnt">
            <label for="username">user name</label>
            <input type="text" id="username" name="username" required minlength="2" maxlength="12" value="{{ Auth::user()->username }}">
        </div>

        <div class="item_cnt">
            <label for="email">mail adress</label>
            <input type="email" id="mail" name="mail" required minlength="5" maxlength="40" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="{{ Auth::user()->mail ?? 0}}">
        </div>

        <div class="item_cnt">
            <label for="new_password">password:</label>
            <input type="password" id="new_password" name="new_password" pattern="[a-zA-Z0-9]+" required minlength="8" maxlength="20">
        </div>

        <div class="item_cnt">
            <label for="new_password_confirmation">password confirm</label>
            <input type="password" id="new_password_confirmation" name="new_password_confirmation" pattern="[a-zA-Z0-9]+" required minlength="8" maxlength="20">
        </div>

        <div class="item_cnt">
            <label for="bio">bio</label>
            <textarea class="bio_text" id="bio" name="bio" maxlength="150">{{ Auth::user()->bio }}</textarea>
        </div>

        <div class="item_cnt">
            <label for="image">icon image</label>
            <input type="file" id="image" name="image"  accept=".jpg,.png,.bmp,.gif,.svg">
        </div>
        <div class="item_cnt">
        <button id="update_btn" type="submit">更新</button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('profile_form');
        const updateButton = document.getElementById('update_btn');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // デフォルトのフォーム送信をキャンセル

            // フォームデータを取得
            const formData = new FormData(form);

            // フォームデータを非同期で送信
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.ok) {
                    // 更新が成功した場合は/topにリダイレクト
                    window.location.href = '/top';
                } else {
                    // エラーの場合はエラーメッセージを表示
                    alert('更新に失敗しました。');
                }
            })
            .catch(error => {
                console.error('更新エラー:', error);
                alert('更新に失敗しました。');
            });
        });
    });
</script>




{{-- 相手のプロフィール --}}
@else
    <div class="p_cnt">
    <img src="{{ asset('storage/images/icons/' .$specifiedUser->images) }}" width="50px" alt="icon">
    <p>name:　　　{{ $specifiedUser->username }}</p>
    <p>bio:　　　　{{ $specifiedUser->bio }}</p>

    <div class="p_btn">
    {{-- フォローボタン --}}
    @if(auth()->user()->isFollowing($specifiedUser->id))
        <form class="follow-form" action="{{ route('unfollow') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $specifiedUser->id }}">
            <button type="submit" class="btn-unfollow">フォロー解除</button>
        </form>
    @else
        <form class="follow-form" action="{{ route('follow') }}" method="POST">
            @csrf
            <input type="hidden" name="user_id" value="{{ $specifiedUser->id }}">
            <button type="submit" class="btn-follow">フォローする</button>
        </form>
    @endif
    </div>
</div>

{{-- JavaScript --}}
<script>
    // フォローフォームの送信イベントを監視する
    document.querySelectorAll('.follow-form').forEach(function(form) {
        // ボタン要素を取得
        var button = form.querySelector('button');

        // ボタンがクリックされたらページをリロードする
        button.addEventListener('click', function() {
            location.reload();
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // フォームのデフォルトの送信動作をキャンセル

            var url = this.action;
            var method = this.method;
            var formData = new FormData(this);

            // 非同期リクエストを送信
            fetch(url, {
                method: method,
                body: formData
            })
            .then(function(response) {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Network response was not ok.');
                }
            })
            .then(function(data) {
                // レスポンスを受け取った後の処理
                if (data.followed) {
                    button.textContent = 'フォロー解除';
                } else {
                    button.textContent = 'フォローする';
                }

                // レスポンスのステータスメッセージなどを表示する場合は、data.statusを使って表示することもできます
                // 例: alert(data.status);
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
        });
    });
</script>


    {{-- ユーザーの投稿 --}}
    @foreach ($posts as $post)
            <div class="media">
                <span class="time_at">{{ date('Y-m-d H:i', strtotime($post->created_at)) }}</span>
                <h5 class="users">
                    <img src="{{ asset('storage/images/icons/' .$specifiedUser->images) }}"  width="50px" alt="icon">
                    {{ $specifiedUser->username }}
                </h5>
                <div class="media-body">
                    {!! nl2br(e($post->post)) !!}
                </div>
            </div>
        @endforeach

@endif
@endsection
