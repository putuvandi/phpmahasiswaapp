<?php
require_once 'DB_Functions_Acuan.php';
$db = new DB_Functions_Acuan();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_GET['kodeSex'])) {
 
    // menerima parameter GET ( nim )
    $kodeSex = $_GET['kodeSex'];
 
    // get mahasiswa
    $sex = $db->getJenisKelamin($kodeSex);
 
    if ($sex != false) {
        // user ditemukan
        $response["error"] = FALSE;
        $response["jenis_kelamin"] = $sex["nama_sex"];
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