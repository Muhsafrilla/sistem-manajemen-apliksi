# Task 2: Manajemen Kategori Event

## Deskripsi
Membuat modul master data untuk mengelola kategori event (misal: Teknologi, Bisnis, Hiburan, Olahraga).

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - Buat migration untuk tabel `event_categories`.
   - Kolom: `id`, `name` (string), `description` (text, nullable), `created_at`, `updated_at`.

2. **Model**:
   - Buat model `EventCategory`. Tambahkan properti `$fillable`.

3. **Seeder**:
   - Buat `EventCategorySeeder` untuk menyuntikkan minimal 5 data dummy (misal: "Teknologi", "Kesehatan", "Bisnis", dsb).

4. **Controller & Routes**:
   - Buat `EventCategoryController` dengan fungsi CRUD (`index`, `create`, `store`, `edit`, `update`, `destroy`).
   - Terapkan standar validasi dalam fungsi dan gunakan `DB::beginTransaction()` di fungsi store, update, destroy.

5. **Views**:
   - Implementasikan *blade views* (`index`, `create`, `edit`) dengan *style* desain yang sudah terpasang dari template NiceAdmin.
