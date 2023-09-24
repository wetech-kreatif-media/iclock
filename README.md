# IClock Server Simple - Push Protocol

## Getting Started
1. Run migration
   ````php spark migrate````
2. copy env into .env
```
logger.threshold = 7
main.server_host = https://hr-progresia.local
main.server_key = 4370 
```

## What is Push Protocol

Perangkat ZKTeco yang support ADMS/WDMS/Web Service menggunakan protocol yang namanya Push Protocol. Berikut cara kerjanya.

## Mesin
Mesin yang dapat dikoneksikan harus mempunyai fitur koneksi jaringan baik melalui ethernet ataupun wireless. Mesin pun harus punya fitur kirim data ke web atau cloud. Cara koneksi dengan masuk menu COMM setting.

## Fungsi Utama
Ada 6 fungsi utama push protocol (sudut pandang dari sisi client):

1. Initializing Information Exchange (Inisialisasi Pertukaran Informasi antara client dan server)
2. Uploading Update Information (Mengirim Informasi Terkini)
3. Uploading Data (Mengirim Data)
4. Downloading Command (Mengambil Perintah dari Pusat)
5. Command Reply (Membalas Perintah dari Pusat)
6. Remote Attendance (Laporan Kehadiran Jarak Jauh/tidak di tempat)

