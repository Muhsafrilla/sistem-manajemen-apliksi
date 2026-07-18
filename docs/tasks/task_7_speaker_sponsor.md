# Task 7: Profil Pembicara & Manajemen Sponsor

## Deskripsi
Fitur tambahan pada suatu event untuk menginformasikan narasumber/pengisi acara dan para pihak sponsor.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - `speakers` (id, event_id, name, bio, photo_url, timestamps).
   - `sponsors` (id, event_id, name, tier (string: Platinum, Gold, dll), logo_url, timestamps).

2. **Model**:
   - Model `Speaker` dan `Sponsor`. Relasi `belongsTo` ke `Event`.

3. **Seeder**:
   - Hasilkan dummy data minimal 3 speaker dan 3 sponsor untuk event tertentu menggunakan seeder.

4. **Controller & Upload Logic**:
   - Implementasikan upload file untuk *photo* dan *logo* menggunakan `Storage` (sama seperti fitur upload *avatar* pada `UserController`).
   - Gunakan try-catch dan fitur delete file saat record di-destroy/di-update.
