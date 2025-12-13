# LaraGold - Gold Price Scraper & API

Aplikasi Laravel untuk scraping harga emas real-time dari [Galeri24](https://galeri24.co.id) dan menyimpannya ke database, serta menyediakan API untuk akses data harga emas.

## 📋 Daftar Isi

- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Konfigurasi](#konfigurasi)
- [Database](#database)
- [Menjalankan Scraper](#menjalankan-scraper)
- [Struktur Proyek](#struktur-proyek)
- [API Endpoints](#api-endpoints)

## 💻 Persyaratan

- **PHP** >= 8.2
- **Composer**
- **MySQL/MariaDB** 8.0 atau lebih tinggi
- **Node.js** >= 18 (opsional, untuk frontend)

## 🚀 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd laragold
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node dependencies (opsional)
npm install
```

### 3. Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laragold
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migrasi

```bash
# Migrate database
php artisan migrate

# (Opsional) Seed data awal
php artisan db:seed
```

## ⚙️ Konfigurasi

### Variabel Environment Penting

```env
APP_NAME=LaraGold
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laragold
DB_USERNAME=root
DB_PASSWORD=

# Scraper
# Konfigurasi otomatis di app/Providers/AppServiceProvider.php
# URL scraper: https://galeri24.co.id/harga-emas
```

## 🗄️ Database

### Struktur Database

Aplikasi ini menggunakan beberapa tabel utama:

#### `brands` - Data Brand Emas
```sql
- id (primary key)
- name (nama brand)
- metal_type (jenis logam, default: 'Gold')
- timestamps
```

#### `products` - Data Produk/Komoditas Emas
```sql
- id (primary key)
- brand_id (foreign key ke brands)
- name (nama produk)
- purity_pct (kemurnian dalam persentase)
- weight_g (berat dalam gram)
- is_physical (apakah fisik/lingot)
- is_active (status aktif)
- timestamps
```

#### `prices` - Data Harga Emas
```sql
- id (primary key)
- product_id (foreign key ke products)
- price_type (ENUM: 'buy', 'sell')
- price_per_gram (harga per gram dalam IDR)
- recorded_at (waktu pencatatan)
- timestamps
```

### Migrasi Database

Untuk menjalankan migrasi ulang dari awal:

```bash
# Fresh migrate (hapus semua data dan migrate ulang)
php artisan migrate:fresh

# Fresh migrate dengan seeder
php artisan migrate:fresh --seed
```

## 🕷️ Menjalankan Scraper

### Command Line

Jalankan scraper menggunakan Artisan command:

```bash
# Scrape harga terbaru
php artisan scrape:galeri-gold

# Output:
# Starting Galeri24 gold price scraping...
# Scraping completed successfully
# Total records saved: 80
```

### Scheduling (Cron Job)

Untuk menjalankan scraper secara berkala, tambahkan ke `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Jalankan setiap jam
    $schedule->command('scrape:galeri-gold')->hourly();
    
    // Atau setiap 30 menit
    $schedule->command('scrape:galeri-gold')->everyThirtyMinutes();
}
```

Kemudian setup cron job di server:

```bash
* * * * * cd /path/to/laragold && php artisan schedule:run >> /dev/null 2>&1
```

### Response Example

```
✓ Scraping completed successfully
✓ Total records saved: 80
  - Brands: 4 (Galeri24, UBS, Antam, Lotus Archi)
  - Products: 40 (masing-masing brand punya 10 varian berat)
  - Prices: 80 (setiap produk punya harga buy & sell)
```

## 📊 Data yang Di-Scrape

Scraper mengambil data dari halaman harga Galeri24 dengan struktur:

### Brands yang Discrape:
- **Galeri24** - Brand utama dari website
- **UBS** - Unit Buy/Sell
- **Antam** - PT Antam Tbk
- **Lotus Archi** - Brand khusus

### Varian Berat:
0.5g, 1g, 2g, 5g, 10g, 25g, 50g, 100g, 500g, 1000g

### Informasi Harga:
- **Harga Jual (Sell)** - Harga ketika pembeli membeli dari website
- **Harga Buyback (Buy)** - Harga ketika pembeli menjual kembali ke website

## 🏗️ Struktur Proyek

```
laragold/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── ScrapeGaleriGold.php       # Command scraper
│   ├── Http/
│   │   ├── Controllers/
│   │   │   └── GoldPriceController.php    # API controller
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   │   ├── Brand.php                      # Model brand
│   │   ├── Product.php                    # Model produk
│   │   ├── Price.php                      # Model harga
│   │   └── User.php
│   ├── Providers/
│   │   └── AppServiceProvider.php         # Service binding
│   └── Services/
│       ├── GaleriGoldScraper.php          # Orchestrator
│       └── GaleriGold/
│           ├── Contracts/
│           │   ├── PriceFetcherInterface.php
│           │   ├── PriceParserInterface.php
│           │   └── PricePersisterInterface.php
│           ├── DTO/
│           │   └── PriceSnapshot.php
│           ├── GaleriGoldFetcher.php      # HTTP fetcher
│           ├── GaleriGoldParser.php       # HTML parser
│           └── GoldPricePersister.php     # DB persister
├── database/
│   ├── migrations/
│   │   ├── create_brands_table.php
│   │   ├── create_products_table.php
│   │   └── create_prices_table.php
│   └── seeders/
├── routes/
│   ├── web.php
│   └── api.php
├── .env.example
├── composer.json
└── README.md
```

## 🔌 API Endpoints

### Get All Brands

```http
GET /api/brands
```

**Response:**
```json
[
  {
    "id": 1,
    "name": "Galeri24",
    "metal_type": "Gold",
    "products_count": 10
  }
]
```

### Get Brand with Products & Prices

```http
GET /api/brands/{id}
```

**Response:**
```json
{
  "id": 1,
  "name": "Galeri24",
  "metal_type": "Gold",
  "products": [
    {
      "id": 1,
      "name": "Galeri24 - 0.5 gram",
      "weight_g": 0.5,
      "purity_pct": 99.99,
      "latest_buy": {
        "price_per_gram": 850000,
        "recorded_at": "2025-12-13"
      },
      "latest_sell": {
        "price_per_gram": 870000,
        "recorded_at": "2025-12-13"
      }
    }
  ]
}
```

### Get All Products with Latest Prices

```http
GET /api/products
```

### Get Single Product with Price History

```http
GET /api/products/{id}
```

## 🔧 Development

### Running Development Server

```bash
# Start development server
php artisan serve

# Server akan berjalan di http://localhost:8000
```

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/ScrapeTest.php
```

### Debugging Scraper

```bash
# Dengan output verbos
php artisan scrape:galeri-gold --verbose

# Check logs
tail -f storage/logs/laravel.log
```

## 📝 Catatan Penting

### Modular Architecture

Scraper dibangun dengan arsitektur modular yang memisahkan concerns:

- **GaleriGoldFetcher** - Bertanggung jawab fetch HTML dari website
- **GaleriGoldParser** - Parse HTML menggunakan DomCrawler menjadi PriceSnapshot DTO
- **GoldPricePersister** - Simpan/update data ke database
- **GaleriGoldScraper** - Orchestrator yang mengatur aliran data

Benefit:
- ✅ Easy to test (unit testing per module)
- ✅ Easy to maintain (separation of concerns)
- ✅ Easy to extend (tambah handler baru tanpa merubah existing)

### Error Handling

Scraper memiliki error handling yang robust:
- Timeout handling pada HTTP request (30 detik)
- Try-catch pada setiap tahap (fetch, parse, persist)
- Logging ke `storage/logs/laravel.log`
- Graceful failure (lanjut ke produk berikutnya jika ada error)

## 🐛 Troubleshooting

### Error: "Failed to fetch webpage"

Kemungkinan penyebab:
- Website Galeri24 sedang offline atau diblokir
- Timeout terlalu pendek (ubah di `GaleriGoldFetcher.php`)
- Network/internet tidak stabil

**Solusi:**
```bash
# Test koneksi ke website
curl https://galeri24.co.id/harga-emas

# Check logs
tail -f storage/logs/laravel.log | grep GaleriGold
```

### Error: "No prices parsed from page"

Kemungkinan penyebab:
- HTML structure website berubah
- CSS selector tidak match

**Solusi:**
```bash
# Debug parser
php artisan tinker
$fetcher = app(\App\Services\GaleriGold\GaleriGoldFetcher::class);
$html = $fetcher->fetch();
// Inspect HTML structure
echo strlen($html);
```

### Database Connection Error

Pastikan:
```bash
# Database service running
sudo service mysql status

# Check .env configuration
cat .env | grep DB_

# Try manual connection
mysql -h 127.0.0.1 -u root -p laragold
```

## 📚 Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Symfony DomCrawler](https://symfony.com/doc/current/components/dom_crawler.html)
- [Galeri24 Website](https://galeri24.co.id/harga-emas)

## 📄 License

Proprietary - All rights reserved

## 👨‍💻 Author

Created for gold price tracking and API service.

---

**Last Updated:** December 13, 2025
