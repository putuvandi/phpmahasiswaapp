<?php
require_once 'DB_Functions_Acuan.php';
$db = new DB_Functions_Acuan();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['kodeKabupaten'])) {
 
    // menerima parameter GET ( nim )
    $kodeKabupaten = $_GET['kodeKabupaten'];
 
    // get mahasiswa
    $kab = $db->getKabupaten($kodeKabupaten);
 
    if ($kab != false) {
        // user ditemukan
        $response["error"] = FALSE;
        $response["kabupaten"] = $kab["nama_kabupaten"];
        echo json_encode($response);
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Gagal mengambil data";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Gagal mengambil data";
    echo json_encode($response);
}
?>