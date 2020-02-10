
<?php
require_once('DB_Connect.php');
  $sql = 'SELECT nama_kabupaten from acuan.kabupaten';
  $db = new DB_Connect();
  $connection = $db->connect();
  $statement = $connection->prepare($sql);
	  $statement->execute();
  
  if($statement->rowCount()) {
    $row_all = $statement->fetchall(PDO::FETCH_ASSOC);
    header('Content-type: application/json');
    echo json_encode($row_all); 		
  }  
  elseif(!$statement->rowCount()) {
    echo "no rows";
  }
?>
