# Task 8: Registrasi & Pendaftaran Peserta

## Deskripsi
Fungsi esensial di mana seorang *Attendee* dapat melakukan transaksi registrasi/pembelian tiket ke sebuah event.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - `registrations` (id, event_id, user_id, ticket_id, status (Pending, Confirmed), registered_at, timestamps).

2. **Model**:
   - Model `Registration`.
   - Relasi ke `Event`, `User`, dan `Ticket`.

3. **Seeder**:
   - Data dummy transaksi registrasi minimal 5 record yang terhubung dengan akun attendee, event yang ada, dan tiket yang ada.

4. **Controller (Logika Utama)**:
   - `RegistrationController@store` harus memvalidasi apakah **quota tiket masih mencukupi** sebelum melakukan insert.
   - Pendaftaran dilakukan di dalam `DB::beginTransaction()`.
   - Kurangi field `quota` di tabel `tickets` sejumlah pendaftaran jika sukses, lalu commit.

5. **Views**:
   - Halaman daftar pendaftar (bagi admin/organizer).
   - Halaman history registrasi (bagi attendee).
