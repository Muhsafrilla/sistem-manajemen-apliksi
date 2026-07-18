# Task 9: Feedback Acara & Laporan Kehadiran

## Deskripsi
Fitur evaluasi dari peserta yang telah mengikuti acara, serta laporan analitik ringkas.

## Kebutuhan (Requirements)

1. **Database & Migrasi**:
   - `feedback_forms` (id, event_id, user_id, rating (integer), comments (text), timestamps).

2. **Model**:
   - Model `FeedbackForm` (relasi ke Event dan User).

3. **Seeder**:
   - Hasilkan minimal 5 ulasan (rating 1-5) dummy dari peserta ke acara yang sudah diregistrasi.

4. **Controller & Views**:
   - Fitur Attendee untuk mengisi form rating pasca-acara.
   - Widget/Card tambahan di Dashboard (via `DashboardController` existing) yang menampilkan:
     - Total Event aktif.
     - Total Registrasi keseluruhan.
     - Rata-rata rating acara.
