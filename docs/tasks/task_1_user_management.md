# Task 1: Manajemen Pengguna & Autentikasi (User Management)

## Deskripsi
Menyesuaikan modul autentikasi dan manajemen user yang sudah ada di Laravel agar selaras dengan peran pengguna baru sesuai PRD.

## Kebutuhan (Requirements)

1. **Modifikasi Role User**:
   - Saat ini kolom `role` di tabel `users` menerima tipe `string`. Sesuaikan validasi dan logika agar memproses role: `Superadmin`, `Organizer`, `Attendee`, `Speaker`, `Sponsor`.

2. **Update Seeder**:
   - Perbarui `UserSeeder` atau buat seeder baru untuk menghasilkan data dummy minimal 1 user untuk setiap role di atas (terutama Superadmin, Organizer, dan Attendee).

3. **Logika CRUD User (`UserController.php`)**:
   - Sesuaikan fungsi `store` dan `update` agar mengenali kelima role tersebut pada saat validasi (`Rule::in` atau opsi manual).
   - Tetap pertahankan validasi berbahasa Indonesia (existing style) dan format blok *try-catch* dengan `DB::beginTransaction()`.
   - Pastikan penghapusan user juga menghapus data terkait jika diperlukan, namun untuk saat ini pastikan existing `destroy` method berjalan lancar dengan role baru.

4. **Penyesuaian Visual (Views)**:
   - Sesuaikan halaman form `create.blade.php`, `edit.blade.php`, dan daftar `index.blade.php` pada folder `resources/views/user/` agar tag `<select>` dropdown menampilkan pilihan `Superadmin`, `Organizer`, `Attendee`, `Speaker`, `Sponsor`.

## Aturan Ketat
- Jangan membuat tabel *roles* terpisah. Gunakan kolom string `role` yang sudah ada di migration `0001_01_01_000000_create_users_table.php`.
- Gunakan gaya penulisan standar, *response redirect* (seperti `to_route()->withSuccess()`), dan pengelompokan *route* yang sudah diterapkan di kode existing.
