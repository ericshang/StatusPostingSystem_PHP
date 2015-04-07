<?php
	require_once("./inc/header.php");
?>



<!--mainbody start-->
<div class="mainBox">
	
    <div class='statusContainer'>
    	<h3>Search Status:</h3>
		<div class="status">
        	<form method="get" action="./searchstatusprocess.php">
            <ul class="postUl">
                <li>Status <br /><input name="keywords" /></textarea></li>
                <li><input type="submit" value="Search"></li>
            </ul>
            </form>
        </div>
    </div>
    
</div>
<!--mainbody ends-->


<?php
	require_once("./inc/footer.php");
?>