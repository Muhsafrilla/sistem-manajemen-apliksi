# Task 5: Pembuatan & Manajemen Event Utama

## Deskripsi
Modul sentral dari aplikasi. Berfungsi untuk membuat data Event yang merelasikan Organizer, Category, dan Venue.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - Tabel `events` (id, organizer_id, category_id, venue_id, title, description, start_date (datetime), end_date (datetime), status (string: Draft/Published), timestamps).

2. **Model**:
   - Buat `Event` model.
   - Tentukan relasi `belongsTo` ke `Organizer`, `EventCategory`, dan `Venue`.

3. **Seeder**:
   - Buat `EventSeeder`. Pastikan tabel lain (organizers, event_categories, venues) sudah dipanggil (seeded) sebelum event dibuat.
   - Bikin minimal 3 event dengan status "Published".

4. **Controller & Routes**:
   - `EventController`. Pada form penambahan event, gunakan `<select>` dropdown untuk menampilkan daftar Venue dan Kategori yang ada di sistem. Gunakan transaksi DB seperti biasa.

5. **Views**:
   - Daftar event, serta halaman Form *Create* & *Edit* Event lengkap dengan validasi tanggal (end_date tidak boleh kurang dari start_date).
