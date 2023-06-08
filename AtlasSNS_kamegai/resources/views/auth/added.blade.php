@extends('layouts.logout')

@section('content')

<div id="clear">
  {{-- セッションした新規ユーザー名を表示する。 --}}
  <div id="new_registrant">
  <p>{{ $username }}さん</p>
  <p>ようこそ！AtlasSNSへ！</p>
  </div>
  <p>ユーザー登録が完了しました。</p>
  <p>早速ログインをしてみましょう。</p>

  <p class="btn"><a id="login_btn" href="/login">ログイン画面へ</a></p>
</div>

@endsection
