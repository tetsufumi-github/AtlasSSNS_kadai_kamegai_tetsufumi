@extends('layouts.login')

@section('content')
    <div class="search_cnt">
        <form action="{{ route('search') }}" method="GET">
                <input type="text" name="keyword" placeholder="ユーザー名">
                <button type="submit"><img src="../images/search.png" alt="検索"></button>
        </form>
        {{-- 検索したワードを表示する --}}
        <div class="res">検索ワード : {{ $keyword }}</div>
    </div>

    {{-- 検索したユーザー名を表示する --}}
    <div class="user_list_res">
        @forelse($users as $user)
            @if($user->id !== auth()->user()->id)
                <div class="user">
                    <img src="{{ asset('storage/images/icons/'. $user->images) }}" alt="ユーザーアイコン" width="50px">
                    <span>{{ $user->username }}</span>

                   @if(auth()->user()->isFollowing($user->id))
    <form class="follow-form" action="{{ route('unfollow') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <button type="submit" class="btn-unfollow">フォロー解除</button>
    </form>
@else
    <form class="follow-form" action="{{ route('follow') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <button type="submit" class="btn-follow">フォローする</button>
    </form>
@endif

                </div>
            @endif
        @empty
            <div class="no_results">該当するユーザーは見つかりませんでした。</div>
        @endforelse
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

// 検索ワードを取得して表示する
var keyword = "{{ $keyword }}";
if (keyword.trim() !== '') {
    document.querySelector('.res').textContent = '検索ワード: ' + keyword;
    document.querySelector('.res').style.display = 'block';
}


</script>


@endsection
