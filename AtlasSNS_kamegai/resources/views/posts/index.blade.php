@extends('layouts.login')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- ログインフォーム用のカード -->
                    <div class="post-body">
                        <img class="login_user_icon" src="../images/icons/{{Auth::user()->images}}" alt="ユーザーアイコン" width="50px">
                        <form method="POST" action="{{ route('posts.store') }}">

                            @csrf
                            {{-- 投稿テキスト（必須：1文字以上、150文字以下） --}}
                            <div class="form-group">
                                <textarea name="post" class="form-control" required minlength="1" maxlength="150" placeholder="投稿内容を入力してください。" wrap="soft"></textarea>
                            </div>

                            {{-- 投稿ボタン --}}
                            <button type="submit" class="btn post-button">
                                <img src="../images/post.png" alt="投稿">
                            </button>
                        </form>
                    </div>

                <!-- 投稿の一覧表示 -->
                <div class="post-body">
                    @foreach ($posts as $post)
                        <div class="media">
                            <span class="time_at">{{ date('Y-m-d H:i', strtotime($post->created_at)) }}</span>
                            <h5 class="users">
                                <img src="../images/icons/{{$post->user->images}}" width="50px" alt="icon">
                                {{ $post->user->username }}
                            </h5>
                            <div class="media-body">
                                {!! nl2br(e($post->post)) !!}

                                {{-- 編集ボタン --}}
                                @if ($post->user_id === auth()->user()->id)
                                    <a class="js-modal-open-edit" href="#" data-post="{{ $post->post }}" data-post-id="{{ $post->id }}">
                                        <img class="edit" src="../images/edit.png" alt="編集実行ボタン">
                                    </a>
                                @endif

                                {{-- 削除ボタン --}}
                                @if ($post->user_id === auth()->user()->id)
                                    <a class="js-modal-open-delete" href="#" data-post-id="{{ $post->id }}">
                                        <img class="trash" src="../images/trash.png" alt="削除実行ボタン">
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- 投稿編集用モーダル -->
                <div class="modal js-modal-edit">
                    <div class="modal__bg js-modal-close"></div>
                    <div class="modal__content_edit">
                        <form action="" method="POST" id="edit-post-form">
                            @method('PUT')
                            @csrf
                            <textarea name="post" class="modal_post" required minlength="1" maxlength="150"></textarea>
                            <button type="submit" class="update-button">
                                <span class="button-text">
                                    <img src="../images/edit.png" alt="編集ボタン">
                                </span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- 投稿削除用モーダル -->
                <div class="modal js-modal-delete">
                    <div class="modal__content_delete">
                        <form action="" method="POST" id="delete-post-form">
                            @method('DELETE')
                            @csrf
                            <p>この投稿を削除します。よろしいでしょうか?</p>
                            <div class="delete_btn-cnt">
                                <button type="submit" class="d_btn" href="/top">ＯＫ</button>
                                <button type="submit" class="js-modal-close d_btn" href="/top">キャンセル</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        $(function() {
            // 投稿の編集モーダル
            $('.js-modal-open-edit').on('click', function() {
                var post = $(this).data('post');
                var postId = $(this).data('post-id');
                var modalForm = $('#edit-post-form');
                var modalTextarea = modalForm.find('.modal_post');

                modalTextarea.val(post);
                modalForm.attr('action', "{{ route('posts.update', '') }}" + "/" + postId);

                $('.js-modal-edit').fadeIn();
                return false;
            });

            // 投稿の削除モーダル
            $('.js-modal-open-delete').on('click', function() {
                var postId = $(this).data('post-id');
                var modalForm = $('#delete-post-form');
                modalForm.attr('action', "{{ route('posts.destroy', '') }}" + "/" + postId);

                $('.js-modal-delete').fadeIn();
                return false;
            });

            // ゴミ箱アイコンのホバーエフェクト
            $('.trash').hover(
                function() {
                    $(this).attr('src', '../images/trash-h.png');
                },
                function() {
                    $(this).attr('src', '../images/trash.png');
                }
            );

            // 削除モーダルを閉じてトップページに移動
            $('.js-modal-close').on('click', function() {
                $('.js-modal-delete').fadeOut();
                location.href = '/top'; // トップページにリダイレクト
                return false;
            });
        });
    </script>
@endsection
