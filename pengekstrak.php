<?php
/**
 * Nama file    :   Pengekstrak result.json Telegram
 * Deskripsi    :   Skrip sederhana untuk mengekstrak file result.json hasil ekspor channel Telegram.
 * Pengembang   :   Danns Bass
 * Email        :   dannsbass@gmail.com
 * Last Update  :   9 Nov 2022
 * Penjelasan   :   Jika kita tidak memiliki database, channel Telegram bisa digunakan sebagai database sementara untuk menampung input dari user ke bot. Caranya, buat channel baru yang masih kosong. Lalu masukkan bot ke dalam channel sebagai admin agar bisa posting. Atur agar semua input dari user (berupa JSON yang dikirim oleh Telegram) dikirim / diteruskan ke channel tersebut. Setelah itu, ekspor isi channel ke dalam format JSON. Hasil ekstrak berupa file tunggal bernama 'result.json'
 */

//ambil isi file result.json
$konten = file_get_contents('result.json');
//ubah menjadi array
$ar = json_decode($konten, true);
// contoh isi json bisa dilihat di bagian akhir file ini
foreach ($ar['messages'] as $no => $msg) {
    //jika tipe bukan 'message' maka abaikan
    if ($msg['type'] != 'message') continue;
    //siapkan variabel penampung string
    $txt = '';
    //jika $msg['text'] berupa array, uraikan telebih dahulu
    if(is_array($msg['text'])) {
        foreach ($msg['text'] as $m) {
            if(is_array($m)){
                $txt .= $m['text'];
            }else{
                $txt .= $m;
            }
        }
    }else {
        $txt .= $msg['text'];
    }
    //saya menggunakan JSON_PRETTY_PRINT ketika mengirim ke channel sehingga baris baru diubah menjadi underscore
    $txt = str_replace(',_"message"', ',"message"', $txt);
    //tulis ke dalam file berdasarkan message id
    file_put_contents($msg['id'] . ".txt", $txt);
}

/* 

Contoh isi result.json
 
{

 "name": "Nama channel kamu",

 "type": "tipe channel kamu",

 "id": "id channel kamu",

 "messages": [

  {

   "id": 1,

   "type": "service",

   "date": "tanggal kejadian",

   "date_unixtime": "tanggal kejadian dalam format unix",

   "actor": "pihak yang melakukan aksi",

   "actor_id": "id pihak yang melakukan aksi",

   "action": "jenis aksi",

   "title": "judul",

   "text": "",

   "text_entities": []

  },

  {

   "id": 4,

   "type": "message",

   "date": "2020-10-05T22:38:22",

   "date_unixtime": "1601908702",

   "from": "Channel ABC",

   "from_id": "channel1273006836",

   "text": [

    "teks yang diposting di channel",

    {

     "type": "code",

     "text": "-1001273006836"

    }

   ],

   "text_entities": [

    {

     "type": "plain",

     "text": "teks yang diposting di channel "

    },

    {

     "type": "code",

     "text": "-1001273006836"

    }

   ]

  },
*/
