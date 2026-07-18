# Task 6: Manajemen Jenis & Stok Tiket

## Deskripsi
Modul untuk mengelola ketersediaan tiket dan variasi harga tiket untuk sebuah Event.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - `ticket_types` (id, name, description). (Master table untuk tipe: Regular, VIP, Early Bird).
   - `tickets` (id, event_id, ticket_type_id, price (decimal), quota (integer)).

2. **Model**:
   - Model `TicketType`.
   - Model `Ticket` dengan relasi ke `Event` dan `TicketType`. (Di model `Event`, tambahkan `hasMany` ke `Ticket`).

3. **Seeder**:
   - `TicketTypeSeeder` dengan data minimal (Regular, VIP).
   - `TicketSeeder` untuk menyuntikkan tiket dummy ke event-event yang sudah di-seed di Task 5.

4. **Controller & Views**:
   - Modul ini dapat dijadikan Controller terpisah (`TicketController`) atau disematkan (embedded) ke dalam Detail Event.
   - Implementasikan CRUD tiket.
