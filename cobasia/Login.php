<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['nim']) && isset($_POST['password'])) {
 
    // menerima parameter POST ( email dan password )
    $nim = $_POST['nim'];
    $password = $_POST['password'];
 
    // get the user by email and password
    // get user berdasarkan email dan password
    $user = $db->getUserByEmailAndPassword($nim, $password);
 
    if ($user != false) {
        // user ditemukan
        $response["error"] = FALSE;
        //$response["uid"] = $user["unique_id"];
        $response["user"]["nim"] = $user["nim"];
        //$response["user"]["email"] = $user["email"];
        echo json_encode($response);
    } else {
        // user tidak ditemukan password/email salah
        $response["error"] = TRUE;
        $response["error_msg"] = "Login gagal. NIM atau Password salah";
        echo json_encode($response);
    }
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "NIM atau password ada yang kurang";
    echo json_encode($response);
}
?>