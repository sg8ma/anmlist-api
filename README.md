# AnmList API

This API provides functionalities related to user, authentication, anime information, favorites, and "My Anime List".

## Specification

### 1. User
- POST /user - ユーザー作成
- GET /user/{id} - ユーザー情報取得
- PUT /user/{id} - ユーザー情報更新
- DELETE /user/{id} - ユーザー削除
- GET /user - ユーザー一覧取得

### 2. Authentication
- POST /user/auth/{type} - 認証情報の作成
- POST /user/login/{type} - ログイン
- GET /user/session - ログインステータス確認
- DELETE /user/session - ログアウト
- DELETE /user/auth/{type} - 認証情報の削除
- GET /user/auth/mail/otp - ワンタイムパスワードのチェック

### 3. Anime Info
- POST /anime/search - アニメの検索
- GET /anime/{id} - アニメの詳細情報取得

### 4. Favorite
- GET /user/{user_id}/favorite - お気に入り一覧取得
- PUT /user/{user_id}/favorite/{anime_id} - お気に入りにアニメを追加
- DELETE /user/{user_id}/favorite/{anime_id} - お気に入りからアニメを削除

### 5. My Anime List
- GET /user/{user_id}/anime - 番組表取得
- POST /user/{user_id}/anime/{anime_id} - 番組表更新
- DELETE /user/{id}/anime/{anime_id} - 番組表からアニメを削除

### 6. Other
- GET /user/session/data - セッションデータの取得
- PUT /user/session/data - セッションデータの更新

## License

This repository is licensed under the [MIT License](https://choosealicense.com/licenses/mit/).
