# 📱 Panduan Setup Telegram Bot

## Langkah 1: Buat Bot di Telegram

1. Buka Telegram, cari **@BotFather**
2. Ketik `/newbot`
3. Ikuti instruksi:
   - Beri nama bot (contoh: `Riyadlul Huda Notifikasi`)
   - Beri username bot (contoh: `riyadlulhuda_bot`)
4. **Salin Bot Token** yang diberikan (contoh: `1234567890:ABCDeFGhIJKlmnOPQRsTUVWxyZ`)

## Langkah 2: Buat Grup/Channel Admin

1. Buat **Group baru** di Telegram untuk notifikasi admin
2. **Tambahkan bot** yang baru dibuat ke group
3. Buat bot menjadi **Admin** (agar bisa kirim pesan)

## Langkah 3: Dapatkan Chat ID

**Cara termudah:**
1. Tambahkan bot **@userinfobot** atau **@getidsbot** ke group
2. Ketik `/start` di group
3. Bot akan membalas dengan **Chat ID** (contoh: `-1001234567890`)

**Atau via API:**
1. Kirim pesan ke group
2. Buka browser: `https://api.telegram.org/bot{BOT_TOKEN}/getUpdates`
3. Cari `"chat":{"id": -1001234567890}` di response

## Langkah 4: Konfigurasi .env

Buka file `.env` dan isi:

```env
TELEGRAM_BOT_TOKEN=1234567890:ABCDeFGhIJKlmnOPQRsTUVWxyZ
TELEGRAM_CHAT_ID=-1001234567890
```

## Langkah 5: Test Notifikasi

Jalankan command berikut di terminal:

```bash
php artisan telegram:test
```

Jika berhasil, akan muncul notifikasi di group Telegram! 🎉

---

## Contoh Penggunaan di Code

```php
use App\Services\TelegramService;

// Kirim pesan custom
$telegram = new TelegramService();
$telegram->sendMessage("Halo dari Dashboard Riyadlul Huda!");

// Notifikasi santri baru
$telegram->notifySantriRegistration([
    'nama' => 'Ahmad',
    'jenis_kelamin' => 'Laki-laki',
    'kelas' => '1A',
    'asrama' => 'Al-Fatih'
]);

// Notifikasi pembayaran
$telegram->notifyPaymentReceived([
    'nama_santri' => 'Ahmad',
    'jumlah' => 500000,
    'keterangan' => 'SPP Januari'
]);
```

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Bot tidak respond | Pastikan bot sudah jadi admin di group |
| Chat ID salah | Cek ulang dengan @getidsbot |
| Token invalid | Cek typo, salin ulang dari @BotFather |
