<?php
 
class DB_Functions_Acuan {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect_Acuan.php';
        // koneksi ke database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
	
	/**
     * Get kabupaten berdasarkan kodeKabupaten
     */
    public function getKabupaten($kodeKabupaten) {
		
		//SELECT concat(status, ' ', nama_kabupaten) as kab FROM `kabupaten` WHERE kode_kabupaten = '1111' 
 
		if ($stmt = $this->conn->prepare("SELECT nama_kabupaten FROM kabupaten WHERE kode_kabupaten = ?")) {
 
			$stmt->bind_param("s", $kodeKabupaten);
 
			if ($stmt->execute()) {
				$kabupaten = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				return $kabupaten;
			} else {
				return NULL;
			}
		}
    }
	
	/**
     * Get jenis kelamin berdasarkan kodeSex
     */
    public function getJenisKelamin($nim) {
		
		//SELECT concat(status, ' ', nama_kabupaten) as kab FROM `kabupaten` WHERE kode_kabupaten = '1111'
		//SELECT nama_sex FROM acuan.sex s INNER JOIN sdm.pegawai p ON p.kode_sex = s.kode_sex WHERE p.kode_pegawai = 00910	
		//SELECT nama_sex FROM sex WHERE kode_sex = ?
 
		if ($stmt = $this->conn->prepare("SELECT nama_sex FROM acuan.sex s INNER JOIN dbase5314.mahasiswa5314 m ON m.kode_sex = s.kode_sex WHERE m.nim = ?")) {
 
			$stmt->bind_param("s", $nim);
 
			if ($stmt->execute()) {
				$jeniskelamin = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				return $jeniskelamin;
			} else {
				return NULL;
			}
		}
    }
}
 
?>