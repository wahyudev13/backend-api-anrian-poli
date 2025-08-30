# Panduan Pengaturan Text Marquee Loket

## Deskripsi
Fitur ini memungkinkan administrator untuk mengubah text yang ditampilkan sebagai marquee berjalan di layar loket antrian. Text marquee akan ditampilkan secara real-time tanpa perlu restart sistem.

## Fitur Utama
- **Pengaturan Text**: Mengubah text marquee melalui interface web yang user-friendly
- **Preview Real-time**: Melihat preview text marquee sebelum disimpan
- **Validasi Input**: Maksimal 500 karakter dengan validasi server-side
- **Penyimpanan Database**: Text disimpan di tabel `antrian_setting` dengan module `loket`
- **Update Real-time**: Perubahan langsung terlihat di layar loket

## Struktur Database
Text marquee disimpan di tabel `antrian_setting` dengan struktur:
- **module**: `loket`
- **field**: `text_marquee`
- **value**: Text yang akan ditampilkan

## Cara Menggunakan

### 1. Akses Menu
- Login ke sistem
- Pilih menu "Text Marquee Loket" dari menu utama

### 2. Edit Text
- Masukkan text baru di textarea
- Text akan otomatis di-preview sebagai marquee berjalan
- Maksimal 500 karakter

### 3. Simpan Pengaturan
- Klik tombol "Simpan Pengaturan"
- Sistem akan menyimpan ke database
- Pesan sukses akan ditampilkan

### 4. Verifikasi
- Text baru akan langsung aktif di layar loket
- API endpoint `/api/loket/text_marquee` akan mengembalikan text terbaru

## API Endpoint
```
GET /api/loket/text_marquee
```
Response:
```json
{
    "message": "success",
    "data": "Text marquee yang aktif"
}
```

## File yang Terlibat

### Controller
- `app/Http/Controllers/SettingController.php` - Menambah method `showTextMarquee()` dan `saveTextMarquee()`

### Routes
- `routes/web.php` - Menambah route untuk web interface
- `routes/api.php` - Route API untuk mengambil text marquee (sudah ada)

### Views
- `resources/views/settings/text_marquee.blade.php` - Interface pengaturan text marquee

### Database
- Tabel `antrian_setting` dengan module `loket` dan field `text_marquee`

## Keamanan
- Hanya user yang sudah login yang dapat mengakses
- Validasi input server-side
- CSRF protection pada form
- Middleware `webauth` untuk autentikasi

## Default Value
Jika belum ada pengaturan, sistem akan menggunakan default text:
"Selamat datang di Rumah Sakit PKU Sekapuk"

## Troubleshooting

### Text tidak berubah
1. Pastikan sudah klik "Simpan Pengaturan"
2. Cek apakah ada pesan error
3. Verifikasi di database tabel `antrian_setting`

### Error database
1. Pastikan koneksi `mysql2` aktif
2. Cek apakah tabel `antrian_setting` ada
3. Verifikasi struktur tabel

### Preview tidak berfungsi
1. Pastikan JavaScript aktif di browser
2. Cek console browser untuk error
3. Refresh halaman jika diperlukan

## Pengembangan Selanjutnya
- Multiple text marquee untuk loket berbeda
- Scheduling text marquee (jam tertentu)
- Rich text editor dengan formatting
- Log perubahan text marquee
- Backup/restore pengaturan
