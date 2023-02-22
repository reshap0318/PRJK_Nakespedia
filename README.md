## System Requirements

- PHP : ^8.0
- Laravel 9.19
- Mysql : 5.7
- Composer
- NPM

## Installation

1. Instalasi Manual

### Installasi Manual

Sebelum melakukan instalasi, pastikan composer dan npm telah terinstall.

1. Download source code dalam bentuk zip atau menggunakan git

   `git clone https://github.com/reshap0318/PRJK_Nakespedia.git nakespedia`

2. Buka file nakespedia atau bisa dengan perintah

    `cd nakespedia`

3. Copy file .env.example menjadi .env atau bisa dengan perintah

    `cp .env.example .env`

4. Install php package dengan perintah

   `composer install`

5. Install Component JavaSciprt dengan Perintah

    `npm Install && npm run dev`

6. Konfigurasi file `.env` terutama untuk database dan email

7. Buat key untuk aplikasi melalui perintah

   `php artisan key:generate`

8. Jalankan aplikasi dengan perintah

    `php artisan serve`

9. Open [http://127.0.0.1:8000/](http://127.0.0.1:8000/)

## user
- username : su@dmin
- password : su@dmin