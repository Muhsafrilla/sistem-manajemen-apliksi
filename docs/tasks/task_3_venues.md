# Task 3: Manajemen Venue (Lokasi Acara)

## Deskripsi
Membuat modul data master untuk mengelola lokasi penyelenggaraan acara (Venue).

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - Buat migration tabel `venues`.
   - Kolom: `id`, `name` (string), `address` (text), `capacity` (integer), `created_at`, `updated_at`.

2. **Model**:
   - Buat model `Venue`.

3. **Seeder**:
   - Buat `VenueSeeder` yang membuat data minimal 5 venue dummy dengan informasi kapasitas yang bervariasi.

4. **Controller & Routes**:
   - Buat `VenueController` (CRUD) menggunakan standar arsitektur dan konvensi modul User existing.

5. **Views**:
   - Sediakan tampilan untuk tabel list venue, serta form tambah/edit venue.
