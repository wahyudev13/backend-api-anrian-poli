# Migrasi POLI_DIGUNAKAN dari Environment Variable ke Database

## Ringkasan Perubahan
Sistem telah diubah dari menggunakan `env('POLI_DIGUNAKAN')` menjadi mengambil data dari tabel `antrian_setting` dengan field `poli_digunakan`.

## File yang Diubah

### 1. `app/Http/Controllers/RegisteredController.php`
**Sebelum:**
```php
public function Poliklinik()
{
    $kode_poli = explode(',', env('POLI_DIGUNAKAN'));
    // ... rest of the code
}
```

**Sesudah:**
```php
public function Poliklinik()
{
    // Get poli_digunakan from antrian_setting table instead of env
    $setting = DB::connection('mysql2')
        ->table('antrian_setting')
        ->where('module', 'general')
        ->where('field', 'poli_digunakan')
        ->value('value');
    
    // Default fallback if no setting found
    $kode_poli = $setting ? explode(',', $setting) : ['U0005', 'INT'];
    // ... rest of the code
}
```

### 2. `app/Http/Controllers/SettingController.php`
**Sebelum:**
```php
use App\Models\Setting;

$setting = Setting::query()
    ->where('module', 'general')
    ->where('field', 'poli_digunakan')
    ->first();

Setting::updateOrCreate(
    ['module' => 'general', 'field' => 'poli_digunakan'],
    ['value' => $validated['value']]
);
```

**Sesudah:**
```php
use Illuminate\Support\Facades\DB;

$setting = DB::connection('mysql2')
    ->table('antrian_setting')
    ->where('module', 'general')
    ->where('field', 'poli_digunakan')
    ->first();

DB::connection('mysql2')
    ->table('antrian_setting')
    ->updateOrInsert(
        ['module' => 'general', 'field' => 'poli_digunakan'],
        ['value' => $validated['value']]
    );
```

### 3. `app/Models/PoliSik.php`
Model ini sudah dikonfigurasi untuk menggunakan `mysql2` connection dan tabel `antrian_setting`.

## Struktur Database yang Diharapkan

### Tabel: `antrian_setting` (di database mysql2)
```sql
CREATE TABLE antrian_setting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    module VARCHAR(50) NOT NULL,
    field VARCHAR(100) NOT NULL,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Data yang diharapkan:
INSERT INTO antrian_setting (module, field, value) VALUES 
('general', 'poli_digunakan', 'U0005,INT');
```

### Tabel: `poliklinik` (di database sik_new_141023)
```sql
-- Struktur yang diharapkan:
-- kd_poli: VARCHAR (kode poliklinik)
-- nm_poli: VARCHAR (nama poliklinik)
```

## Keuntungan Perubahan

1. **Fleksibilitas**: Pengaturan dapat diubah melalui web interface tanpa restart aplikasi
2. **Konsistensi**: Semua pengaturan tersimpan di database yang sama
3. **Maintenance**: Lebih mudah untuk backup dan restore pengaturan
4. **Real-time**: Perubahan langsung aktif tanpa perlu deploy ulang

## Cara Kerja Baru

1. **Saat aplikasi dimulai**: Sistem membaca pengaturan dari tabel `antrian_setting`
2. **Saat ada request**: Controller mengambil data terbaru dari database
3. **Saat pengaturan diubah**: Admin dapat mengubah melalui web interface
4. **Fallback**: Jika tidak ada pengaturan di database, menggunakan default `['U0005', 'INT']`

## Testing

Untuk memastikan perubahan berfungsi:

1. **Test API Poliklinik**: `/api/poliklinik` (atau route yang sesuai)
2. **Test Settings Page**: `/settings/poli`
3. **Test Database Connection**: Pastikan `mysql2` connection berfungsi
4. **Test Data Flow**: Ubah pengaturan dan lihat apakah API mengembalikan data yang benar

## Troubleshooting

1. **Database Connection Error**: Periksa konfigurasi `mysql2` di `.env`
2. **Table Not Found**: Pastikan tabel `antrian_setting` ada di database
3. **Data Not Loading**: Periksa apakah ada data di tabel dengan `module='general'` dan `field='poli_digunakan'`
4. **Fallback Not Working**: Pastikan default value `['U0005', 'INT']` sesuai kebutuhan
