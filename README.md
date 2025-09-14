<h1 align="center">Selamat datang di Sistem Informasi Manajemen Stok! 👋</h1>

## Default Account for testing

**Admin Default Account**

- email: admin
- Password: password

---

## Install

1. **Clone Repository**

```bash
git clone https://github.com/rezakurniasetiawan/sistem-informasi-manajemen-stok.git
cd sistem-informasi-manajemen-stok
git checkout development
composer install
cp .env.example .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi website**

```bash
php artisan key:generate
php artisan migrate --seed
```

4. **Jalankan website**

```bash
php artisan serve
```

## Contributing

Contributions, issues and feature requests di persilahkan.
Jangan ragu untuk memeriksa halaman masalah jika Anda ingin berkontribusi. **Berhubung Project ini saya sudah selesaikan sendiri, namun banyak fitur yang kalian dapat tambahkan silahkan berkontribusi yaa!**

## License

- Copyright © 2025 Reza Kurnia Setiawan.
- **Sistem Informasi Manajemen Stok is open-sourced software licensed under the MIT license.**
