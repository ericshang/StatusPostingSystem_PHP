<?php
	require_once("./inc/header.php");
	require_once("./inc/declare.php");
	
	$page = 0; // to show wich page
	if(isset($_GET['page']) && !empty(trim($_GET['page']))){
		$page = (int)$_GET['page'];
	}

	
	function ListStatus($page){
		require_once("./inc/db.php");
		$sql = "SELECT count(*) count FROM `status`";
		$db = new DB();
		$rs = $db->query($sql);
		$totalRecords = $rs->row['count']; // total number of records
		//total pages of status		
		$totalPage = ($totalRecords%NUM_OF_STATUS_PER_PAGE == 0)   ? 
							$totalRecords / NUM_OF_STATUS_PER_PAGE :
							((int)($totalRecords / NUM_OF_STATUS_PER_PAGE))+1;
							
		$pageHtml = "";
		//correct illegal $page in case needed
		$page = ($page > $totalPage) || $page <=0 ? 1 : $page;
		
		
		$outputHtml = "<div class='totalRecords' >Total Records: $totalRecords</div>";
		$sql ="SELECT * FROM `status` ";
		$limit = " LIMIT 0 , ". NUM_OF_STATUS_PER_PAGE." ";
		$orderBy = " ORDER BY  `statusCode` DESC  ";
		if($page>1){
			$limit = " LIMIT ".(NUM_OF_STATUS_PER_PAGE * ($page-1)).", ". NUM_OF_STATUS_PER_PAGE." ";
		}
		$sql .= $orderBy . $limit;
		if($query = $db->query($sql)){
			$rows = $query->rows;
			foreach($rows as $row){
				$date = $row['date'];
				$status = $row['status'];
				$allowLike = $row['allowLike'];
				$outputHtml .="<div class='status'>
								<div class='userInfoBox'>
									<ul>
										<li>Date: $date</li>
									</ul>
								</div>
									$status
								</div>
								<ul class='statusOperationsUL'>
									<li> </li>
								</ul>";
			}
		}else{
			$outputHtml .="Something is wrong!";
		}
		
		$prevPage = $page > 1 ? " <a href = '?page=".($page-1)."'> Previous </a> | " : "";
		$nextPage = $page < $totalPage ? " | <a href = '?page=".($page+1)."'> Next </a>  " : "";
		$pageHtml = "<div class='page'>".$prevPage . " Page: $page / $totalPage ".$nextPage."</div>" ;
		
		return $outputHtml .$pageHtml;
	}
	
	
?>


<!--mainbody start-->
<div class="mainBox">
	
    <div class='statusContainer'>
    	<h3>List of Status:</h3>
		<?php echo ListStatus($page); ?>
    </div>
    
</div>
<!--mainbody ends-->



<?php
	require_once("./inc/footer.php");
?>