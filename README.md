# survey-app
LIVEアンケートフォーム

## 初期設定
### git clone
必要な場所にgit cloneする
```bash
$ git clone git@github.com:kanami93/survey-app.git
```

### 必要なベンダーファイルのインストール
```bash
$ cd /path/to/app
$ cd composer install
```

### app_local.php の変更
composer install で `/path/to/app/config` に`app_local.php`ファイルが作成されているため、
そちらのファイルの下記の点を環境に合わせて変更
事前にDBの作成やS3にバケットの準備をしておく

```php
 .
 .
 .
    'Datasources' => [
        'default' => [
            'host' => '',
            /*
             * CakePHP will use the default DB port based on the driver selected
             * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
             * the following line and set the port accordingly
             */
            //'port' => 'non_standard_port_number',

            'username' => '',
            'password' => '',

            'database' => '',
            /*
             * If not using the default 'public' schema with the PostgreSQL driver
             * set it here.
             */
            //'schema' => 'myapp',

            /*
             * You can use a DSN string to set the entire configuration
             */
            'url' => env('DATABASE_URL', null),
        ],
 .
 .
 .
    'S3' => [
        'config' => [
            'credentials' => [
                'key' => '',
                'secret' => '',
            ],
            'region' => '',
            'version' => '',
        ],
        'bucket' => ''
    ]
```

### db migrateの実行
```bash
$ cd /path/to/app
$ bin/cake migrations migrate
```
