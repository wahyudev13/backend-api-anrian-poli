# Konfigurasi Database sik_new_141023

## Langkah 1: Konfigurasi .env
Tambahkan konfigurasi berikut ke file `.env` Anda:

```env
# Database connection untuk sik_new_141023
DB_CONNECTION_2=mysql
DB_HOST_2=127.0.0.1
DB_PORT_2=3306
DB_DATABASE_2=sik_new_141023
DB_USERNAME_2=username_anda
DB_PASSWORD_2=password_anda
```

## Langkah 2: Verifikasi Koneksi
Setelah menambahkan konfigurasi, test koneksi dengan mengakses:
```
http://your-domain/test-polyclinics
```

Jika berhasil, Anda akan melihat JSON response dengan data poliklinik.

## Langkah 3: Struktur Tabel yang Diharapkan
Model `PoliSik` mengharapkan tabel dengan struktur:
- `poliklinik` (nama tabel)
- `kd_poli` (kode poliklinik)
- `nm_poli` (nama poliklinik)

## Langkah 4: Hapus Route Test (Setelah Verifikasi)
Setelah memastikan koneksi berfungsi, hapus route test dari `routes/web.php`:
```php
// Hapus route ini
Route::get('/test-polyclinics', function() { ... });
```

## Troubleshooting
1. **Error Connection**: Pastikan database `sik_new_141023` dapat diakses
2. **Table Not Found**: Pastikan tabel `poliklinik` ada di database
3. **Permission Denied**: Pastikan user database memiliki akses read ke tabel

## Fitur yang Telah Ditambahkan
- Dropdown poliklinik dari database sik_new_141023
- Search/filter poliklinik
- Multi-select poliklinik
- Auto-add ke input kode poli
- Fallback ke input manual jika database tidak tersedia
