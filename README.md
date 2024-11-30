## Panduan Instalasi

### Persyaratan Sistem

-   **PHP 8.2 atau lebih baru**

### Langkah-Langkah

1. **Clone Repositori**  
   Jalankan perintah berikut:

    ```bash
    git clone https://github.com/Luthfiahmad12/inowtech-asseessment.git

    ```

2. **Instal dependensi**

    ```bash
    cd inowtech-asseessment
    composer Install
    npm Install
    npm run build
    php artisan key:generate

    ```

3. **setup database**

````base
cp .env.example .env
php artisan migrate

4. **jalankan aplikasi**
```bash
php artisan serve




````
