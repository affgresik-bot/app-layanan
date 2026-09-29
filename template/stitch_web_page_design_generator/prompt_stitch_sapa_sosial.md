# Prompt Google Stitch — Portal Publik SAPA SOSIAL

Kumpulan prompt untuk membuat UI/frontend portal layanan publik **SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar** di https://stitch.withgoogle.com/, disusun berdasarkan `PRD_SAPA_SOSIAL.md`.

## Cara Pakai

1. Tempel **Prompt 0** lebih dulu untuk menetapkan gaya visual dan sistem desain.
2. Tempel **Prompt 1–9** satu per satu (satu prompt = satu halaman) di project Stitch yang sama agar gaya visualnya konsisten.
3. Prompt ditulis dalam bahasa Inggris agar hasil lebih konsisten; seluruh teks di UI diminta berbahasa Indonesia.
4. Buat versi **Mobile** dan **Web** dengan prompt yang sama dengan mengganti mode perangkat di Stitch.

## Daftar Prompt

| No | Halaman |
|----|---------|
| 0 | Gaya visual & sistem desain |
| 1 | Beranda |
| 2 | Informasi Layanan (daftar & detail) |
| 3 | Pilih Jenis Layanan (Ajukan Layanan) |
| 4 | Form Pengajuan SK DTSEN |
| 5 | Form Pengajuan Reaktivasi KIS/PBI-JK |
| 6 | Cek Status Tiket |
| 7 | Form Pengaduan Sosial |
| 8 | Verifikasi Keaslian Surat |
| 9 | Login / Daftar & Riwayat Pengajuan Saya |

---

## Prompt 0: Gaya visual & sistem desain

```
Design a responsive, mobile-first public service web portal for "SAPA SOSIAL — Satu Pintu Layanan Sosial Kabupaten Blitar", run by Dinas Sosial Kabupaten Blitar (East Java, Indonesia). It is a single-window portal where citizens apply for social services, file complaints, and track progress with a ticket number. All UI text must be in Bahasa Indonesia.

Visual style: trustworthy, humane, and clean, like a modern Indonesian government service portal, not corporate or flashy. Primary color deep teal-green (#0F766E) with a warm amber accent (#F59E0B) for calls to action and priority badges; neutral slate grays; white cards on a very light gray-green background (#F6F8F7). Font: Plus Jakarta Sans or Inter. Rounded corners (12px), soft shadows, generous whitespace, large tap targets (min 48px), high contrast for accessibility, since many users are elderly or low-digital-literacy. Use simple line icons (Lucide/Heroicons style). No stock photos of people; use subtle geometric or illustration accents.

Global layout: sticky top navbar with logo placeholder + text "SAPA SOSIAL" and subtitle "Dinas Sosial Kabupaten Blitar"; menu items: Beranda, Layanan, Ajukan Layanan, Pengaduan, Cek Status, Verifikasi Surat; a "Masuk" button (outlined) on the right. Mobile: hamburger menu plus a bottom navigation bar (Beranda, Layanan, Pengaduan, Cek Status). Footer: office address, phone, service hours, links, and copyright "© Dinas Sosial Kabupaten Blitar".

Status badge color system used everywhere: blue = Diajukan, amber = Perlu Perbaikan, purple = Sedang Diverifikasi, teal = Diproses, green = Selesai, red = Ditolak.
```

---

## Prompt 1: Beranda

```
Create the Home page (Beranda) of SAPA SOSIAL.

1. Hero section: headline "Satu Pintu Layanan Sosial Kabupaten Blitar", subheadline "Ajukan layanan, sampaikan pengaduan, dan pantau prosesnya secara online dengan nomor tiket." Two large buttons: "Ajukan Layanan" (primary) and "Cek Status Tiket" (secondary). Beside or below it, a compact quick-track card with one input "Masukkan nomor tiket (contoh: DTSEN-202610-00012)" and a "Lacak" button.

2. "Layanan Utama" section with 3 large highlighted cards, each with icon, short description, and "Ajukan Sekarang" link:
   - Surat Keterangan DTSEN: "Surat status DTSEN/desil untuk syarat SPMB, PIP, KIP Kuliah, bantuan sosial, dan layanan kesehatan."
   - Reaktivasi KIS / PBI-JK: "Aktifkan kembali kepesertaan BPJS Kesehatan PBI yang dinonaktifkan." Add a small amber tag "Prioritas untuk darurat medis".
   - Pelayanan Rehabilitasi Sosial: "Bantuan untuk lansia terlantar, penyandang disabilitas, ODGJ, anak, dan korban kekerasan."

3. Secondary row of 3 smaller cards: "Pengajuan Layanan Lainnya", "Pengaduan & Laporan Sosial", "Verifikasi Keaslian Surat".

4. "Bagaimana Caranya?" 4-step horizontal stepper: 1 Pilih layanan → 2 Isi data & unggah dokumen → 3 Dapatkan nomor tiket → 4 Pantau sampai selesai.

5. "Informasi Terbaru" grid of 3 article/info cards with category chips (Program, Disabilitas, Lansia, Rehabilitasi).

6. FAQ accordion with 4 questions, e.g. "Apa saja syarat membuat Surat Keterangan DTSEN?", "Berapa lama proses reaktivasi PBI-JK?".

7. A "Butuh bantuan?" banner: "Datang ke Operator Kecamatan/Desa atau Puskesos terdekat", with a contact button.

Include a prominent global search bar under the hero: "Cari layanan, persyaratan, atau informasi…".
```

---

## Prompt 2: Informasi Layanan (daftar & detail)

```
Create the "Informasi Layanan" page of SAPA SOSIAL, a public page that needs no login.

Top: page title, breadcrumb, a large keyword search bar, and category filter chips: Semua, Program Sosial, Rehabilitasi Sosial, Disabilitas, Lansia, Pengaduan.

Below: a grid of service information cards (title, category chip, 2-line description, "Lihat Detail" link).

Also show the DETAIL view of one example, "Surat Keterangan DTSEN", as a two-column layout:
- Left (main): sections "Deskripsi", "Persyaratan" (checklist: KTP, Kartu Keluarga), "Alur Pelayanan" (vertical numbered steps), "Waktu Pelayanan", "Lokasi & Kontak", and FAQ accordion.
- Right (sticky sidebar): a highlighted card with primary button "Ajukan Layanan Ini", secondary button "Buat Pengaduan", and a "Formulir Unduhan" list with file names, version tag "v2 (berlaku)", and download icons.
Add a small note "Terakhir diperbarui: 24 September 2026".
```

---

## Prompt 3: Pilih Jenis Layanan (halaman "Ajukan Layanan")

```
Create the "Ajukan Layanan" page of SAPA SOSIAL where citizens choose which service to apply for.

Top: title "Pilih Layanan yang Anda Butuhkan", short helper text, and a search bar.

Content: a grid of selectable service cards. The first three are highlighted as "Layanan Utama" with a small star: Surat Keterangan DTSEN, Reaktivasi KIS/PBI-JK, Pelayanan Rehabilitasi Sosial. Below them, a section "Layanan Lainnya" with 3 more cards (e.g. Rekomendasi Bantuan Sosial, Permohonan Pelayanan Rehabilitasi, Layanan Sosial Lainnya). Each card has an icon, name, one-line description, estimated processing note, and a "Pilih" button.

When a card is selected, show a right-side panel (bottom sheet on mobile) previewing "Persyaratan" as a checklist (e.g. KTP, Kartu Keluarga, Kartu BPJS/KIS) and a primary button "Mulai Pengajuan". Also add a small hint box: "Butuh bantuan mengisi? Datang ke Operator Kecamatan/Desa atau Puskesos terdekat."
```

---

## Prompt 4: Form Pengajuan SK DTSEN

```
Create a multi-step application form page "Pengajuan Surat Keterangan DTSEN" for SAPA SOSIAL, with a horizontal progress stepper of 4 steps: "Tujuan", "Data Pemohon", "Unggah Dokumen", "Tinjau & Kirim".

Step content shown on this screen (Step 2 active, with Steps 1 and 3-4 visible in the stepper):
- Card "Tujuan Penggunaan": select with options SPMB (jalur afirmasi), PIP, KIP Kuliah, Bantuan Sosial, Layanan Kesehatan, Lainnya.
- Card "Data Pemohon": Nama Lengkap, NIK (16 digit, numeric with counter), Nomor KK (16 digit), Alamat, dropdown Kecamatan then dependent dropdown Desa/Kelurahan, No. HP.
- Card "Data Orang yang Diterangkan": Nama, NIK, "Hubungan dengan Pemohon" (select: diri sendiri, anak, orang tua, lainnya).
- Card "Unggah Dokumen": two drag-and-drop upload zones labeled "KTP (wajib)" and "Kartu Keluarga (wajib)", accepted formats PDF/JPG/PNG, showing one uploaded-file state with a green check and one empty state.

Right sidebar (desktop) or collapsible top panel (mobile): "Persyaratan" checklist and an info box "Setelah dikirim, Anda akan mendapat nomor tiket untuk memantau proses."
Bottom: "Kembali" and "Lanjutkan" buttons. Show inline validation states (one field with an error message in Indonesian). Also design the success screen: a large check icon, "Pengajuan Berhasil Dikirim", a big ticket number "DTSEN-202610-00012" with a copy button, a reminder "Simpan nomor tiket ini untuk cek status", and buttons "Cek Status" and "Kembali ke Beranda".
```

---

## Prompt 5: Form Pengajuan Reaktivasi KIS/PBI-JK

```
Create a multi-step application form page "Pengajuan Reaktivasi KIS / PBI-JK" for SAPA SOSIAL, with a horizontal progress stepper of 4 steps: "Data Peserta", "Alasan Reaktivasi", "Unggah Dokumen", "Tinjau & Kirim".

Show Step 2 "Alasan Reaktivasi" as active, with this content:
- Card "Data Peserta": Nama Peserta, NIK (16 digit), Nomor Kartu BPJS/KIS, Perkiraan Tanggal Nonaktif (date picker), Kecamatan and Desa/Kelurahan dropdowns, No. HP pemohon.
- Card "Alasan Reaktivasi": selectable radio cards: Penyakit Kronis/Katastropik, Kondisi Darurat Medis, Bayi Baru Lahir dari Ibu Peserta PBI, Lainnya. When "Kondisi Darurat Medis" is selected, show an amber info banner: "Pengajuan darurat medis akan diprioritaskan oleh petugas."
- Conditional fields for medical reasons: Nama Fasilitas Kesehatan and Nomor Surat Keterangan Faskes.
- Card "Unggah Dokumen": upload zones for "KTP (wajib)", "Kartu Keluarga (wajib)", "Kartu BPJS/KIS (wajib)", and "Surat Keterangan Faskes (wajib untuk alasan medis)", with one uploaded and the others empty.

Sidebar: "Persyaratan" checklist and "Tahapan Proses" mini-timeline (Pemeriksaan → Verifikasi → Surat Rekomendasi → Diusulkan ke Kemensos → Aktif Kembali). Bottom buttons "Kembali" and "Lanjutkan". Add an inline validation error example in Indonesian.
```

---

## Prompt 6: Cek Status Tiket

```
Create the "Cek Status Tiket" page for SAPA SOSIAL.

Top card: title "Pantau Pengajuan Anda", inputs "Nomor Tiket" and "4 digit terakhir NIK atau No. HP" (helper text explains it is for privacy), and button "Cek Status".

Result section (show a result for a PBI-JK reactivation ticket, PBI-202610-00007):
- Summary card: ticket number, service name "Reaktivasi KIS/PBI-JK", applicant name (masked, e.g. "Sri W*****"), submission date, current status badge "Diusulkan ke Kemensos", and an amber "Prioritas – Darurat Medis" badge.
- A vertical timeline of all stages, with completed steps in green checkmarks, the current step highlighted with a pulsing teal dot, and future steps in gray: Diajukan → Pemeriksaan Berkas → Verifikasi Kelayakan → Menunggu Persetujuan Pejabat → Surat Rekomendasi Terbit → Diusulkan ke Kemensos (current) → Disetujui Kemensos → Kepesertaan Aktif Kembali → Selesai. Each completed step shows date/time and a short note.
- An alternative-state example card below: "Perlu Perbaikan" alert (amber) with officer note "Foto Kartu BPJS kurang jelas" and a button "Unggah Perbaikan".
- Help box: "Ada kendala? Hubungi kami" with phone and hours.
```

---

## Prompt 7: Form Pengaduan Sosial

```
Create the "Pengaduan & Laporan Sosial" page for SAPA SOSIAL.

Intro: short text "Laporkan permasalahan sosial di lingkungan Anda. Laporan akan diverifikasi dan ditindaklanjuti petugas."

Form (single-page, sectioned cards):
1. "Kategori Permasalahan": selectable large chips/cards with icons (e.g. Lansia Terlantar, Penyandang Disabilitas, ODGJ Terlantar, Anak Terlantar, Kekerasan, Bantuan Sosial Bermasalah, Lainnya).
2. "Lokasi Kejadian": dropdown Kecamatan, dependent dropdown Desa/Kelurahan, textarea "Detail lokasi (jalan, RT/RW, patokan)".
3. "Uraian Masalah": textarea with character counter.
4. "Lampiran (opsional)": photo/document uploader with image thumbnails preview.
5. "Data Pelapor": Nama, No. HP (both required). Note: "Data pelapor dijaga kerahasiaannya."
Submit button "Kirim Laporan". Also design the confirmation state showing report number "ADU-202610-00004" with copy button and a "Cek Status Laporan" button.
```

---

## Prompt 8: Verifikasi Keaslian Surat

```
Create the public page "Verifikasi Keaslian Surat" for SAPA SOSIAL, reached by scanning the QR code on an SK DTSEN letter (URL pattern /verifikasi/{kode}).

Show a simple centered layout with an input "Kode Verifikasi" and a "Periksa" button (plus an option to scan QR with camera). Design THREE result states as separate cards:
1. VALID (green): large check icon, "Surat Asli & Berlaku", details: nomor surat "400.9/123/409.XX/2026", nama yang diterangkan (masked), tujuan penggunaan "SPMB", tanggal terbit, masa berlaku sampai, penandatangan "Kepala Dinas Sosial Kabupaten Blitar".
2. KEDALUWARSA (amber): "Surat Sudah Tidak Berlaku" with expiry date.
3. TIDAK DITEMUKAN (red): "Kode Tidak Ditemukan" with advice to contact Dinsos.
Keep the design minimal, official-looking, and very readable on mobile.
```

---

## Prompt 9: Login / Daftar & Riwayat Pengajuan Saya

```
Create two screens for the citizen account area of SAPA SOSIAL.

Screen A, "Masuk / Daftar": a centered card with two tabs, "Masuk" and "Daftar". Masuk: email or No. HP, password, "Lupa kata sandi?" link, primary button "Masuk". Daftar: Nama Lengkap, NIK (16 digit), No. HP, Email, Kata Sandi, checkbox for data-privacy consent, primary button "Buat Akun". Below the card, a friendly note: "Tanpa akun pun Anda tetap bisa melihat informasi dan cek status dengan nomor tiket." with a "Cek Status Tanpa Login" link.

Screen B, "Riwayat Pengajuan Saya" (after login): greeting header, summary tiles (Total Pengajuan, Dalam Proses, Selesai, Perlu Perbaikan), filter tabs (Semua, Layanan, Pengaduan), and a list of ticket cards. Each card shows ticket number, service name, submission date, status badge, and a "Lihat Detail" button. Include one card with an amber "Perlu Perbaikan" state and a call-to-action "Unggah Perbaikan", and one completed DTSEN card with a "Unduh Surat (PDF)" button. Add an empty-state illustration for when there are no tickets.
```

---

## Tips Penyempurnaan di Stitch

- Jika desain terlalu ramai: `Simplify the layout, use larger text, and keep one primary button per section.`
- Jika kartu terlalu kecil untuk pengguna lansia: `Make the cards larger, increase font size to at least 16px, and increase contrast.`
- Untuk konsistensi antarhalaman: `Keep the same navbar, footer, colors, and component styles as the previous screens.`
- Dashboard internal (petugas/pimpinan) tidak dibuat di Stitch karena panel admin memakai Filament v5.
