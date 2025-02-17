# Aplikasi Tampilan Data Gaji Karyawan

Aplikasi ini digunakan untuk menampilkan data gaji karyawan per bulan. Data gaji ditampilkan dalam tabel yang responsif dan dapat di-scroll horizontal.

## Fitur

*   Menampilkan data gaji karyawan, termasuk nama, gaji pokok, gaji harian, hari kerja, hari masuk, hari izin, hari absen, gaji, tunjangan masa kerja, tunjangan jabatan, total jam lembur, total gaji lembur, BPJS Kesehatan, BPJS Ketenagakerjaan, dan gaji bersih.
*   Filter data gaji berdasarkan bulan.
*   Tabel responsif yang dapat di-scroll horizontal pada layar besar.
*   Memiliki 3 role untuk penggunaan

## Teknologi yang Digunakan

*   Laravel
*   Bootstrap
*   Carbon (untuk manipulasi tanggal)

## Cara Penggunaan

1.  Clone repositori ini:

    ```bash
    git clone https://github.com/Iphint/tsm-presence.git
    ```

2.  Install dependencies:

    ```bash
    composer install
    ```

3.  Konfigurasi database:

    *   Buat database baru.
    *   Buka file `.env` dan isi konfigurasi database sesuai dengan database Anda.

4.  Migrasi database:

    ```bash
    php artisan migrate
    ```

5.  Jalankan aplikasi:

    ```bash
    php artisan serve
    ```

6.  Buka browser dan akses aplikasi di `http://localhost:8000`.


## Kontribusi

Silakan ajukan *pull request* jika Anda ingin berkontribusi pada proyek ini.

## Lisensi

Tsamaniya

## Catatan

*   Pastikan Anda sudah menginstal PHP dan Composer di komputer Anda.
*   Sesuaikan konfigurasi database dan *environment* lainnya sesuai kebutuhan Anda.