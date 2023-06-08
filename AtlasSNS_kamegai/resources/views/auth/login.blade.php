@extends('layouts.logout')

@section('content')
<!-- 適切なURLをここに入力してください -->
{!! Form::open(['url' => 'login']) !!}
<!-- ログインフォームのURLを指定して開始する -->

<p>AtlasSNSへようこそ</p>
<!-- ウェルカムメッセージ -->

<div id="login_items_list">
<!-- ログインアイテムをグループ化するためのdiv要素 -->

{{ Form::label('mailaddres') }}
<!-- メールアドレス入力フィールドのラベル -->

{{ Form::text('mail',null,['class' => 'input']) }}
<!-- メールアドレスのテキスト入力フィールド、'mail'がname属性となる -->

{{ Form::label('password') }}
<!-- パスワード入力フィールドのラベル -->

{{ Form::password('password',['class' => 'input']) }}
<!-- パスワードの入力フィールド、'password'がname属性となる -->

</div>

<div class="btn">
{{ Form::submit('LOGIN') }}
<!-- 'LOGIN'というラベルの送信ボタン -->
</div>

<p><a href="/register">新規ユーザーの方はこちら</a></p>
<!-- 登録ページへのリンク -->

{!! Form::close() !!}
<!-- ログインフォームの終了 -->

@endsection
