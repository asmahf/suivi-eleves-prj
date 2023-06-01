



 <?php 
define('DB_HOST','localhost');
define('DB_USER','Asma');
define('DB_PASS','232300');
define('DB_NAME','suivieleve');

//create connection
$con= new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
//check connection
if($con->connect_error) {
    die('Connection Failed'. $con->connect_error);
}
?>

<!-- // $username = "Asma"; -->
<!-- // $password = "232300"; -->
 <!-- $database = new PDO("mysql:host=localhost; dbname=suivieleve;",$username,$password); -->