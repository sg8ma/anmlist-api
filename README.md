# AnmList API

This WebAPI provides functionalities related to user, users authentication, anime information, favorites, and "My Anime List".

## Specification

### 1. User
- POST /user - ユーザー作成
- GET /user/{id} - ユーザー情報取得
- PUT /user/{id} - ユーザー情報更新
- DELETE /user/{id} - ユーザー削除
- GET /user - ユーザー一覧取得

### 2. User Authentication
- POST /user/auth/{type} - ユーザー認証情報の作成
- POST /user/login/{type} - ユーザーのログイン
- GET /user/session - ユーザーのログインステータス確認
- DELETE /user/session - ユーザーのログアウト
- DELETE /user/auth/{type} - ユーザー認証情報の削除
- GET /user/auth/mail/otp - ワンタイムパスワードのチェック

### 3. Anime Info
- POST /anime/search - アニメの検索
- GET /anime/{id} - アニメの詳細情報取得

### 4. Favorite
- GET /user/{user_id}/favorite - ユーザーのお気に入り一覧取得
- PUT /user/{user_id}/favorite/{anime_id} - ユーザーのお気に入りにアニメを追加
- DELETE /user/{user_id}/favorite/{anime_id} - ユーザーのお気に入りからアニメを削除

### 5. My Anime List
- GET /user/{user_id}/anime - ユーザーの番組表取得
- POST /user/{user_id}/anime/{anime_id} - ユーザーの番組表更新
- DELETE /user/{id}/anime/{anime_id} - ユーザーの番組表からアニメを削除

### 6. Other
- GET /user/session/data - ユーザーセッションデータの取得
- PUT /user/session/data - ユーザーセッションデータの更新

## License

This repository is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).
