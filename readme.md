<p align="center">
    <img src="https://img.shields.io/badge/Laravel-v6.20.32-orange?style=plastic&logo=laravel" alt="Laravel Version">
    <img src="https://img.shields.io/badge/PHP-v7.4.1-informational?style=plastic&logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/Vue.js-v3.2.31-success?style=plastic&logo=vue.js" alt="Vue.js Version">
    <img src="https://img.shields.io/badge/Tailwind CSS-v3.0.8-9cf?style=plastic&logo=tailwindcss" alt="Tailwind CSS Version">
</p>

# HoloMemory

## 概要
- VTuber事務所 ホロライブに所属しているメンバーの配信情報を取得するアプリ

## 背景
- VTuberの配信が好きでよく視聴しているのだが、自分のように箱推しになるとチャンネル登録が多くなってしまい、どのメンバーが現在配信しているのかパッと見わかりづらい。<br>
そのため配信情報を可視化できるようなアプリを開発したいと考えた。<br>
ホロライブを運営しているカバー株式会社が「ホロジュール」というメンバーのスケジュール管理アプリを既にリリースしているのだが、そこと差別化を図れるような取り組みを今後行っていく。(2022年2月21日現在)<br>

## 事前準備
- Google Cloud PlatformでYoutube Data APIを有効化したAPIキーが作成済みであること（1つでも可能だが、クォータ制限にすぐ引っかかってしまうため2つあると良い）

## 環境構築
1. envファイルを作成
```shell
copy .env.example .env
```

2. envファイル内で環境変数の値を設定
```shell
WEB_PORT=
DB_PORT=

DB_NAME=
DB_USER=
DB_PASSWORD=
DB_ROOT_PASSWORD=

API_KEY=
# 2つプロジェクトを作成している場合
SUB_API_KEY=
```

3. build
```shell
docker compose build

docker compose up -d
```

4. composer インストール確認
```shell
composer -V
Composer version 2.0.14 2021-05-21 17:03:37
```

5. Vue.js Install
```
npm install -D vue
```

## 開発言語
### フロントエンド
| 言語         | バージョン |
| ------------ | ---------- |
| HTML5        |            |
| Sass         | 1.15.2     |
| Tailwind CSS | 3.0.8      |
| Vue.js       | 3.2.31     |

### バックエンド
| 言語    | バージョン |
| ------- | ---------- |
| PHP     | 7.4.1      |
| Laravel | 6.20.32    |

### 開発環境
| 名称 | バージョン |
| ------------ | ---------- |
| Docker         | 20.10.6    |
| docker-compose | 1.29.1     |
| MySQL          | 8.0.28     |

### 各種パッケージ
| 名称 | バージョン |
| ------------ | ---------- |
| npm         | 8.1.2 |
| webpack     | 5.9.0 |
| laravel-mix | 6.0.18 |
| vue-router | 4.0.12 |

## 機能一覧
- 配信情報一覧
- YouTube Data APIを叩いた配信情報取得
- ソート機能（JP, EN, ID）

## ER図
![HoloMemory](https://user-images.githubusercontent.com/56289802/154892094-dfcef436-0dac-4816-b433-436b92c047f3.jpg)

