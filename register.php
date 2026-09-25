<?php
// register.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data teks
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $whatsapp = isset($_POST['whatsapp']) ? trim($_POST['whatsapp']) : '';
    $institusi = isset($_POST['institusi']) ? trim($_POST['institusi']) : '';

    // 2. Olah data checkbox (array)
    $sumber_info_arr = isset($_POST['sumber_info']) ? $_POST['sumber_info'] : [];
    $info_lain = isset($_POST['info_lain']) ? trim($_POST['info_lain']) : '';

    // Jika 'Lain-lain' dicentang dan input teks diisi, gabungkan nilainya
    if (in_array("Lain-lain", $sumber_info_arr) && !empty($info_lain)) {
        $key = array_search("Lain-lain", $sumber_info_arr);
        $sumber_info_arr[$key] = "Lain-lain: " . $info_lain;
    }

    // Gabungkan array checkbox menjadi satu string yang dipisahkan koma
    $sumber_info = implode(", ", $sumber_info_arr);

    // Validasi data wajib 
    if (empty($nama) || empty($email) || empty($whatsapp) || empty($institusi)) {
        http_response_code(400);
        echo "Data tidak lengkap. Mohon isi semua kolom yang wajib.";
        exit;
    }

    date_default_timezone_set('Asia/Jakarta');
    $waktu_daftar = date('Y-m-d H:i:s');
    $nama_file = '_data.csv';
    $file_sudah_ada = file_exists($nama_file);
    $file = fopen($nama_file, 'a');

    if ($file) {
        // Tentukan separator (pemisah) dan enclosure (pengurung string)
        $separator = ';'; 
        $enclosure = '"'; // Digunakan untuk membungkus teks yang panjang/mengandung spasi

        // Tulis header baru jika file belum pernah dibuat
        if (!$file_sudah_ada) {
            $header = array('Waktu Daftar', 'Nama Lengkap', 'Email', 'WhatsApp', 'Gereja/Institusi', 'Sumber Info');
            // Menambahkan separator titik koma
            fputcsv($file, $header, $separator, $enclosure);
        }

        // Masukkan baris data pendaftar sesuai urutan header
        $data_pendaftar = array($waktu_daftar, $nama, $email, $whatsapp, $institusi, $sumber_info);
        // Menambahkan separator titik koma
        fputcsv($file, $data_pendaftar, $separator, $enclosure);
        
        fclose($file);

        http_response_code(200);
        echo "Sukses";
    } else {
        http_response_code(500);
        echo "Gagal menyimpan data ke server.";
    }
} else {
    http_response_code(405);
    echo "Akses ditolak.";
}
?>