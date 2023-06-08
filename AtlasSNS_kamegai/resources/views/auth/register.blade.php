@extends('layouts.logout')

@section('content')
<!-- 適切なURLを入力してください -->
{{-- ↓これでデータベースに新規ユーザー登録できる。--}}
{!! Form::open(['url' => '/register']) !!}
<!-- 新規ユーザー登録フォームを指定したURLで開始する -->

<h2>新規ユーザー登録</h2>
<!-- 新規ユーザー登録の見出し -->

<div id="login_items_list">
<!-- ログインアイテムをグループ化するためのdiv要素 -->

{{ Form::label('user name') }}
<!-- ユーザー名の入力フィールドのラベル -->

{{ Form::text('username',null,['class' => 'input', 'required' => 'required', 'minlength' => 2, 'maxlength' => 12]) }}
<!-- ユーザー名のテキスト入力フィールド -->
<!-- 必須入力フィールド、最小長2、最大長12として設定 -->
@if ($errors->has('username'))
    <p>{{ $errors->first('username') }}</p>
@endif

{{ Form::label('mail addres') }}
<!-- メールアドレスの入力フィールドのラベル -->

{{ Form::email('mail',null,['class' => 'input', 'required' => 'required', 'minlength' => 5, 'maxlength' => 40]) }}
<!-- メールアドレスの入力フィールド -->
<!-- 必須入力フィールド、最小長5、最大長40として設定 -->
@if ($errors->has('mail'))
    <p>{{ $errors->first('mail') }}</p>
@endif

{{ Form::label('password') }}
<!-- パスワードの入力フィールドのラベル -->

{{ Form::password('password',['class' => 'input', 'required' => 'required', 'pattern' => '^[0-9a-zA-Z]{8,20}$']) }}
<!-- パスワードの入力フィールド -->
<!-- 必須入力フィールド、8〜20文字の英数字として設定 -->
@if ($errors->has('password'))
    <p>{{ $errors->first('password') }}</p>
@endif

{{ Form::label('password confirm') }}
<!-- パスワード確認の入力フィールドのラベル -->

{{ Form::password('password_confirmation',['class' => 'input', 'required' => 'required', 'pattern' => '^[0-9a-zA-Z]{8,20}$']) }}
<!-- パスワード確認の入力フィールド -->
<!-- 必須入力フィールド、8〜20文字の英数字として設定 -->
@if ($errors->has('password_confirmation'))
    <p>{{ $errors->first('password_confirmation') }}</p>
@endif
</div>

<div class="btn">
{{ Form::submit('REGISTER') }}
<!-- 'REGISTER'というラベルの送信ボタン -->
</div>

<p><a href="/login">ログイン画面へ戻る</a></p>
<!-- ログイン画面へのリンク -->

{!! Form::close() !!}
<!-- 新規ユーザー登録フォームの終了 -->

@endsection
