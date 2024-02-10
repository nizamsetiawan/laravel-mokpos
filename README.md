
![Logo](https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEheTli2GLufxBSotmFiceRgmsSd0WvFVHE4KLzsxa0JLa5oPQlmOCAbFbXf4auGLDcUNeqSEYNYrau9Qg0ArfMSxJpeg8eTrdLchgY93iLI2wKQ2uC8d--KZ1_zibhaYc6YH363irv-6PrYqILjh8gVl7Gsfijn70Lvp2d2OxQ37EGZXj6zMDfia6GJ/w400-h116/laravel-logo.png)


# mokPOS Backend use laravel 10

Sistem Informasi Kasir menggunakan framework laravel 


## Installation
1. Buka Terminal/Console/PowerShell/CMD

2. Clone repositori ini ke dalam direktori lokal:

```bash
  git clone <url-repositori> nama-proyek
```
3. Jalankan perintah berikut untuk menginstal dependensi PHP menggunakan Composer:

```bash
  composer install
```
4. Perbarui dependensi PHP (jika ada) menggunakan perintah berikut:

```bash
  composer update
```
5. Instal dan atur dependensi JavaScript menggunakan npm:

```bash
  npm install
```
6. Kompilasi sumber daya JavaScript dan CSS:

```bash
  npm run dev
```
7. Salin file .env.example menjadi .env:

```bash
  cp .env.example .env
```
8. Generate kunci aplikasi Laravel:

```bash
  php artisan key:generate
```
9. Jalankan server pengembangan menggunakan perintah:

```bash
  php artisan serve
```
Buka browser dan akses http://localhost:8000/. 
## API Reference

#### Get all items

```http
  GET /api/items
```

| Parameter | Type     | Description                |
| :-------- | :------- | :------------------------- |
| `api_key` | `string` | **Required**. Your API key |

#### Get item

```http
  GET /api/items/${id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `string` | **Required**. Id of item to fetch |



