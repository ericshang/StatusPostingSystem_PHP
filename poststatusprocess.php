<?php
	require_once("./inc/header.php");
	require_once("./inc/db.php"); //!important, db class
	
	$result = false;//!important, process results
	$error = ""; //error message
	$isGoodToGo = true;
	
	//get all variables from $_POST
	$statusCode = $_POST['statusCode']; // S0001 format
	$statusCode_pattern = "/^S\d{4}$/";
	
	$status = trim($_POST['status']);
	$date = trim($_POST['date']);
	$date_pattern = "/^\d{2}\/\d{2}\/\d{2}$/";//dd/mm/yy
	
	$share = !isset($_POST['share'])?1:(int)$_POST['share'];
	$allowLike = isset($_POST['allowLike'])?1:0;
	$allowComment = isset($_POST['allowComment'])?1:0;
	$allowShare = isset($_POST['allowShare'])?1:0;

	if(!$statusCode || !preg_match($statusCode_pattern,$statusCode)){ // illegal status code
		$isGoodToGo = false;
		$error .="<p>illegal status code</p>";
	}
	if(!$status){//status is empty
		$isGoodToGo = false;
		$error .="<p>Status is empty</p>";
	}
	
	if(!preg_match($date_pattern,$date) ){// date pattern is not correct
		$isGoodToGo = false;
		$error .="<p>Date format is not correct</p>";
	}
	if($isGoodToGo){
		$sql = "INSERT INTO `status` (`statusCode`, `status`,`share`, `date`, `allowLike`, `allowComment`, `allowShare`) VALUES('$statusCode','$status','$share','$date', '$allowLike', '$allowComment','$allowShare');";
		//do db query
		$db = new DB();
		if($db->query($sql)){
			$result = true;
			unset($_POST);//!important, to destroy post		
		}else{
			$error = "<p>Database error</p>";
		}
	}
?>

<!--mainbody start-->
<div class="mainBox">
    <div class="statusContainer">
        <h3>Post Status:</h3>
        <div style="text-align:center; padding:5em;">
        <?php 
			if($result){
				echo "<h4>Success!</h4>";
				echo "<a href='./'>Go back!</a>";
			}else{
				echo "<h3 style='color:red'>Mission failed. </h3>";
				echo "<p>Error:</p> " .$error;
				echo "<a onclick='javascript: window.history.back(-1)'>Go back!</a>";
			}
		 ?>
         </div>
    </div>
</div>
<!--mainbody ends-->



<?php
	require_once("./inc/footer.php");
?>
