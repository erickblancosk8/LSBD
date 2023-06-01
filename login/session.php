<?php 

session_start();
var_dump($_SESSION['user_data']);

?>

<br/>
<br/>
<br/>
<br/>

<?php 

$userId = $_SESSION['user_data']['id'];
echo $userId;