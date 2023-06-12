<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
    <!--IEブラウザ対策-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="ページの内容を表す文章" />
    <title>AtlasSNS課題</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }} ">
    <link rel="stylesheet" href="{{ asset('css/style.css') }} ">
    <!--スマホ,タブレット対応-->
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <!--サイトのアイコン指定-->
    <link rel="icon" href="画像URL" sizes="16x16" type="image/png" />
    <link rel="icon" href="画像URL" sizes="32x32" type="image/png" />
    <link rel="icon" href="画像URL" sizes="48x48" type="image/png" />
    <link rel="icon" href="画像URL" sizes="62x62" type="image/png" />
    <!--iphoneのアプリアイコン指定-->
    <link rel="apple-touch-icon-precomposed" href="画像のURL" />
    <!--OGPタグ/twitterカード-->
    <script src="../js/jquery-3.6.4.min.js"></script>
    <script src="../js/script.js"></script>
</head>
<body>
<header>
    <!-- ヘッダーのロゴとメニュー -->
    <h1><a href="/top"><img src="images/logo.png" alt="ロゴ" width="115px"></a></h1>
    <ul id="user_list">
        <!-- ユーザー情報とアイコン -->
        <li><p>{{ Auth::user()->username }} 　さん</p></li>
        <li>
            <div class="d_arrow">
                <span class="dropdown-toggle_left"></span>
                <span class="dropdown-toggle_right"></span>
            </div>
            <nav id="d_menu">
                <ul>
                    <li><a href="/top">HOME</a></li>
                    <li><a href="/profile?id={{ Auth::user()->id }}">プロフィール</a></li>
                    <li><a href="{{ route('logout') }}">ログアウト</a></li>
                </ul>
            </nav>
        </li>
        <li>
            {{-- 画像が更新される。 --}}
            <img src="{{ asset('storage/images/icons/' . Auth::user()->images) }}" alt="ユーザーアイコン" width="50px">
        </li>
    </ul>
</header>

<script>
  var menu = document.getElementById("d_menu");
  var toggleButton = document.querySelector(".d_arrow");

  // 初期状態でドロップダウンメニューを非表示にする
  menu.style.display = "none";

  function toggleMenu() {
    menu.style.display = menu.style.display === "none" ? "block" : "none";
    toggleButton.classList.toggle("rotate");
  }

  toggleButton.addEventListener("click", toggleMenu);
</script>



    <div id="row">
        <div id="container">
            <!-- コンテンツの表示部分 -->
            @yield('content')
        </div>
        {{-- 共有サイドバー --}}
       <div id="side-bar">
            <p class="username">{{ Auth::user()->username }}さんの</p>

            <div id="f_cnt">
                <!-- フォロー数の表示 -->
                <p class="section-title">フォロー数  {{ $followCount ?? 0}} 名</p>

                <div class="btn_cnt_f">
                    <a href="/followList" class="sb_btn f_btn btn-primary">フォローリスト</a>
                </div>

                <!-- フォロワー数の表示 -->
                <p class="section-title">フォロワー数 {{ $followerCount ?? 0}} 名</p>

                <div class="btn_cnt_f">
                    <a href="/followerList" class="sb_btn f_btn btn-primary">フォロワーリスト</a>
                </div>
            </div>

            <!-- ユーザー検索のボタン -->
            <div class="btn_cnt_sah">
                <a href="/search" class="sb_btn sah_btn btn-primary">ユーザー検索</a>
            </div>
        </div>
    </div>
</body>
</html>
