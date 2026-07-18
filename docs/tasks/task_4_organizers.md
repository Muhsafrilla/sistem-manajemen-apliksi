# Task 4: Manajemen Profil Organizer

## Deskripsi
Mengelola data penyelenggara (Organizer). Fitur ini merelasikan akun User (role Organizer) dengan detail perusahaan atau institusinya.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - Buat migration tabel `organizers`.
   - Kolom: `id`, `user_id` (foreign key ke users), `company_name` (string), `contact_email` (string), `phone` (string), `created_at`, `updated_at`.

2. **Model**:
   - Buat `Organizer` model.
   - Tambahkan relasi `belongsTo` ke model `User`. Di sisi lain, pada `User` model, tambahkan `hasOne` (opsional) ke `Organizer`.

3. **Seeder**:
   - Buat `OrganizerSeeder`. Pasangkan dengan data User dummy ber-role `Organizer` dari Task 1. Buat minimal 2 data.

4. **Controller & Views**:
   - `OrganizerController` (CRUD).
   - Tampilan antarmuka untuk melihat list organizer, serta form pengisian profil organizer.
