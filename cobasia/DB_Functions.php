<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // koneksi ke database
        $db = new Db_Connect();
        $this->conn = $db->connect();
    }
 
    // destructor
    function __destruct() {
         
    }
 
    /*public function simpanUser($nama, $email, $password) {
        $uuid = uniqid('', true);
        $hash = $this->hashSSHA($password);
        $encrypted_password = $hash["encrypted"]; // encrypted password
        $salt = $hash["salt"]; // salt
 
        $stmt = $this->conn->prepare("INSERT INTO tbl_user(unique_id, nama, email, encrypted_password, salt) VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $uuid, $nama, $email, $encrypted_password, $salt);
        $result = $stmt->execute();
        $stmt->close();
 
        // cek jika sudah sukses
        if ($result) {
            $stmt = $this->conn->prepare("SELECT * FROM tbl_user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $user = $stmt->get_result()->fetch_assoc();
            $stmt->close();
 
            return $user;
        } else {
            return false;
        }
    }*/
 
    /**
     * Get user berdasarkan email dan password
     */
    public function getMhsByNimAndPassword($nim, $password) {
 
		if ($stmt = $this->conn->prepare("SELECT * FROM password5314 WHERE nim = ? AND password = ?")) {
 
			$stmt->bind_param("ss", $nim, $password);
 
			if ($stmt->execute()) {
				$user = $stmt->get_result()->fetch_assoc();
				$stmt->close();
 
				// verifikasi password user
				/*$salt = $user['salt'];
				$encrypted_password = $user['encrypted_password'];
				$hash = $this->checkhashSSHA($salt, $password);
				// cek password jika sesuai
				if ($encrypted_password == $hash) {
					// autentikasi user berhasil
					return $user;
				}*/
				return $user;
			} else {
				return NULL;
			}
		}
    }
	
	/**
	 * Mengganti password user 
	 */
	public function ubahPassword($nim, $passwordbaru) {
		
		if ($stmt = $this->conn->prepare("UPDATE password5314 SET password = ? WHERE nim = ?")) {
			
			$stmt->bind_param("ss", $passwordbaru, $nim);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				//echo "Password berhasil diubah";
				return true;
			} else {
				echo "Gagal mengubah password";
				//return false;
			}
		}
		
	}
	
	/**
	 * Mengganti biodata mahasiswa 
	 */
	public function ubahBiodata($nim, $kodeKabLahir, $tempatLahir, $tglLahir, $alamatSkr, $kodeKabSkr, $kodePosSkr, 
	$alamatAsal, $kodeKabAsal, $kodePosAsal, $namaAyah, $email, $noHp, $nisn, $nik, $tglLahirAyah, $namaIbu, $tglLahirIbu, 
	$nikAyah, $nikIbu) {
		
		$subquery = "SELECT kode_kabupaten FROM acuan.kabupaten WHERE nama_kabupaten = ?";
		
		$query = "UPDATE mahasiswa5314 SET kode_kabupaten_lahir = (".$subquery."), tempat_lahir = ?, tgl_lahir = ?, ".
			"alamat_skr = ?, kode_kabupaten_skr = (".$subquery."), kode_pos_skr = ?, alamat_asal = ?, ".
			"kode_kabupaten_asal = (".$subquery."), kode_pos_asal = ?, nama_ayah = ?, email = ?, no_hp = ?, nisn = ?, nik = ?, ".
			"tgl_lahir_ayah = ?, nama_ibu_kandung = ?, tgl_lahir_ibu_kandung = ?, nik_ayah = ?, nik_ibu_kandung = ? WHERE nim = ?";
		
		if ($stmt = $this->conn->prepare($query)) {
			
			$stmt->bind_param("ssssssssssssssssssss", $kodeKabLahir, $tempatLahir, $tglLahir, $alamatSkr, $kodeKabSkr, 
			$kodePosSkr, $alamatAsal, $kodeKabAsal, $kodePosAsal, $namaAyah, $email, $noHp, $nisn, $nik, $tglLahirAyah, 
			$namaIbu, $tglLahirIbu, $nikAyah, $nikIbu, $nim);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				//echo "Password berhasil diubah";
				return true;
			} else {
				echo "Gagal mengubah biodata";
				//return false;
			}
		}
		
	}
	
	public function ubahKodeKabupatenLahir($nim, $kodeKabLahir) {
		$query = "UPDATE mahasiswa5314 SET kode_kabupaten_lahir = (SELECT kode_kabupaten FROM acuan.kabupaten WHERE nama_kabupaten = ?) WHERE nim = ?";
		
		if ($stmt = $this->conn->prepare($query)) {
			
			$stmt->bind_param("ss", $kodeKabLahir, $nim);
			
			if ($stmt->execute()) {
				$stmt->close();
				
				//echo "Password berhasil diubah";
				return true;
			} else {
				echo "Gagal mengubah biodata";
				//return false;
			}
		}
	}
	
	/**
     * Get user berdasarkan nim
     */
    public function getMahasiswa($nim) {
 
		if ($stmt = $this->conn->prepare("SELECT * FROM mahasiswa5314 WHERE nim = ?")) {
 
			$stmt->bind_param("s", $nim);
 
			if ($stmt->execute()) {
				$mhs = $stmt->get_result()->fetch_assoc();
				$stmt->close();
 
				// verifikasi password user
				/*$salt = $user['salt'];
				$encrypted_password = $user['encrypted_password'];
				$hash = $this->checkhashSSHA($salt, $password);
				// cek password jika sesuai
				if ($encrypted_password == $hash) {
					// autentikasi user berhasil
					return $user;
				}*/
				return $mhs;
			} else {
				return NULL;
			}
		}
    }
	
	/**
     * Get kabupaten berdasarkan kodeKabupaten
     */
    public function getKabupaten($kodeKabupaten) {
		
		//SELECT concat(status, ' ', nama_kabupaten) as kab FROM `kabupaten` WHERE kode_kabupaten = '1111' 
 
		if ($stmt = $this->conn->prepare("SELECT nama_kabupaten FROM acuan.kabupaten k WHERE k.kode_kabupaten = ?")) {
 
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
	
	/**
     * Get jenis kelamin berdasarkan kodeSex
     */
    public function getAllKabupaten() {
 
		if ($stmt = $this->conn->query("SELECT nama_kabupaten from acuan.kabupaten")) {
 
			//$stmt->bind_param("s", $nim);
 
			//if ($stmt->execute()) {
			$output = array();
			while ($baris = mysqli_fetch_assoc($stmt)) {
				//$output[] = $baris['nama_kabupaten'];
				array_push($output,array("kabupaten"=>$baris['nama_kabupaten']));
			}
			echo json_encode(array('result'=>$output));
			//$jumlahBaris = $stmt->num_rows;
			//if($jumlahBaris >= 1) {
				//$row_all = mysqli_fetch_all($stmt,MYSQLI_ASSOC);
				//header('Content-type: application/json');
				//echo json_encode($row_all); 		
			//} else {
				//echo "no rows";
			//} 
			//} else {
				//return NULL;
			//}
		}
    }
	
	/**
     * Get jenis kelamin berdasarkan kodeSex
     */
    public function getAllStatusPegawai() {
 
		if ($stmt = $this->conn->query("SELECT nama_stats_pegawai from acuan.status_pegawai")) {
 
			//$stmt->bind_param("s", $nim);
 
			//if ($stmt->execute()) {
			$output = array();
			while ($baris = mysqli_fetch_assoc($stmt)) {
				//$output[] = $baris['nama_kabupaten'];
				array_push($output,array("status_pegawai"=>$baris['nama_stats_pegawai']));
			}
			echo json_encode(array('result'=>$output));
			//$jumlahBaris = $stmt->num_rows;
			//if($jumlahBaris >= 1) {
				//$row_all = mysqli_fetch_all($stmt,MYSQLI_ASSOC);
				//header('Content-type: application/json');
				//echo json_encode($row_all); 		
			//} else {
				//echo "no rows";
			//} 
			//} else {
				//return NULL;
			//}
		}
    }
	
	public function getStatusPegawai($kodePegawai) {
		if ($stmt = $this->conn->prepare("SELECT nama_stats_pegawai FROM acuan.status_pegawai s INNER JOIN
		sdm.pegawai p ON p.kode_status_pegawai = s.kode_status_pegawai WHERE p.kode_pegawai = ?")) {
			
			$stmt->bind_param("s", $kodePegawai);
			
			if ($stmt->execute()) {
				$statuspegawai = $stmt->get_result()->fetch_assoc();
				$stmt->close();
				
				return $statuspegawai;
			} else {
				return NULL;
			}
			
		}
	}
 
    /**
     * Cek User ada atau tidak
     */
    /*public function isUserExisted($email) {
        $stmt = $this->conn->prepare("SELECT email from tbl_user WHERE email = ?");
 
        $stmt->bind_param("s", $email);
 
        $stmt->execute();
 
        $stmt->store_result();
 
        if ($stmt->num_rows > 0) {
            // user telah ada 
            $stmt->close();
            return true;
        } else {
            // user belum ada 
            $stmt->close();
            return false;
        }
    }*/
 
    /**
     * Encrypting password
     * @param password
     * returns salt and encrypted password
     */
    /*public function hashSSHA($password) {
 
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }*/
 
    /**
     * Decrypting password
     * @param salt, password
     * returns hash string
     */
    /*public function checkhashSSHA($salt, $password) {
 
        $hash = base64_encode(sha1($password . $salt, true) . $salt);
 
        return $hash;
    }*/
 
}
 
?>