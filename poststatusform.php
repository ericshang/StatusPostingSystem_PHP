<?php
	require_once("./inc/header.php");
	require_once("./inc/db.php"); //!important, db class
	$today = date("d/m/y");
	$sql ="SELECT `statusCode` from `status` ORDER BY `statusCode` DESC LIMIT 0,1"; // select the last record from status table
	$db = new DB();
	$satusCode = "S0000";//default value
	if($rs = $db->query($sql)){
		$satusCode = $rs->row['statusCode'];
	}
	$num = (string)substr($satusCode,1)+1;
	while(strlen($num)<4){ // in case of starting with zeros
		$num ="0".$num;
	}
	$satusCode = "S".$num;
	$js = "<script>setFormValue('".$satusCode."','". $today."'); </script>"; // for javascript used for reset
?>


<!--mainbody start-->
<?php echo $js; ?>
<div class="mainBox">
	<div class="statusContainer">
		<h3>Post New Status</h3>
    	<div class="status">
        	<form method="post" action="./poststatusprocess.php" id="postForm">
            <ul class="postUl">
            	<li>* Status Code <br /><input name="statusCode" value='<?php echo $satusCode; ?>' id="statusCode" /></li>
                <li>* Status <br /><textarea name="status" rows="3" cols="60" id="status"></textarea></li>
                <li>Share with: <br /><input type="radio" name="share" value="1" checked="checked" id="sharePublic" />Public <input type="radio" name="share" value="2"  id="shareFriends" />Friends <input type="radio" name="share" value="3" />Only me </li>
                <li>Date: <br /><input name="date" value='<?php echo $today; ?>'/></li>
                <li>Permission Type:  <br /><input type="checkbox" name="allowLike"  /> Allow Like <input type="checkbox" name="allowComment" /> Allow Comment  <input type="checkbox" name="allowShare" /> Allow Share </li>
                <li> </li>
                <li><input type="submit" value="Submit"> <input type="button" value="Reset" onclick="resetForms()"></li>
            </ul>
            </form>
        </div>
	</div>
    
</div>
<!--mainbody ends-->



<?php
	require_once("./inc/footer.php");
?>