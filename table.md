# テーブル定義書

| テーブル論理名   | テーブル物理名      |
| ---------------- | ------------------- |
| メンバーマスター | HOLOLIVE_MEMBER_MST |

| NO. | PK  | UK  | カラム論理名           | カラム物理名     | データ型     | 桁  | NULL | DEFAULT | 備考                                      |
| --- | --- | --- | ---------------------- | ---------------- | ------------ | --- | ---- | ------- | ----------------------------------------- |
| 1   | ◯   | N/A | メンバー ID            | id               | INT unsigned | N/A | NO   | N/A     | auto_increment                            |
| 2   | N/A | N/A | 名前                   | name             | STRING       | 30  | NO   | N/A     |                                           |
| 3   | N/A | ◯   | チャンネル ID          | channel_id       | STRING       | 255 | NO   | N/A     | 各チャンネルページの channel/以降の文字列 |
| 4   | N/A | N/A | 期生 ID                | graduate_id      | INT unsigned | N/A | NO   | N/A     | ゲーマーズ:99、IRys:98                    |
| 5   | N/A | N/A | チャンネルアイコン URL | channel_icon_url | STRING       | 255 | NO   | N/A     |                                           |
| 6   | N/A | N/A | 出身国                 | country          | STRING       | 10  | NO   | N/A     | JP(日本)/EN(英語圏)/ID（インドネシア）    |
| 7   | N/A | N/A | 作成日時               | created_at       | TIMESTAMP    | N/A | YES  | N/A     |                                           |
| 8   | N/A | N/A | 更新日時               | updated_at       | TIMESTAMP    | N/A | YES  | N/A     |                                           |

| テーブル論理名   | テーブル物理名     |
| ---------------- | ------------------ |
| グループマスター | HOLOLIVE_GROUP_MST |

| NO. | PK  | UK  | カラム論理名 | カラム物理名 | データ型  | 桁  | NULL | DEFAULT | 備考 |
| --- | --- | --- | ------------ | ------------ | --------- | --- | ---- | ------- | ---- |
| 1   | ◯   | N/A | グループ ID  | id           | INT       | N/A | NO   | N/A     |      |
| 2   | N/A | ◯   | グループ名   | name         | STRING    | 10  | NO   | N/A     |      |
| 3   | N/A | N/A | 作成日時     | created_at   | TIMESTAMP | N/A | YES  | N/A     |      |
| 4   | N/A | N/A | 更新日時     | updated_at   | TIMESTAMP | N/A | YES  | N/A     |      |

| テーブル論理名 | テーブル物理名        |
| -------------- | --------------------- |
| 配信予定動画   | daily_upcoming_videos |

| NO. | PK  | UK  | カラム論理名   | カラム物理名         | データ型  | 桁  | NULL | DEFAULT | 備考                                      |
| --- | --- | --- | -------------- | -------------------- | --------- | --- | ---- | ------- | ----------------------------------------- |
| 1   | N/A | MUL | チャンネル ID  | channel_id           | STRING    | 255 | NO   | N/A     | 各チャンネルページの channel/以降の文字列 |
| 2   | N/A | N/A | 出身国         | country              | STRING    | 2   | NO   | N/A     | JP(日本)/EN(英語圏)/ID（インドネシア）    |
| 3   | N/A | N/A | 動画 ID        | video_id             | STRING    | 255 | NO   | N/A     |                                           |
| 4   | N/A | N/A | タイトル       | title                | STRING    | 255 | NO   | N/A     |                                           |
| 5   | N/A | N/A | サムネイル URL | thumbnails_url       | STRING    | 255 | NO   | N/A     |                                           |
| 6   | N/A | N/A | 配信開始時間   | scheduled_start_time | STRING    | 255 | NO   | N/A     |                                           |
| 7   | N/A | N/A | 作成日時       | created_at           | TIMESTAMP | N/A | YES  | N/A     |                                           |
| 8   | N/A | N/A | 更新日時       | updated_at           | TIMESTAMP | N/A | YES  | N/A     |                                           |
