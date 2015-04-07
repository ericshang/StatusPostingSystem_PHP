<?php
	require_once("./inc/header.php");
	
	$page = 0; // to show wich page
	if(isset($_GET['page']) && !empty(trim($_GET['page']))){
		$page = (int)$_GET['page'];
	}
	$keywords ="";
	if(isset($_GET['keywords']) && !empty(trim($_GET['keywords']))){
		$keywords = trim($_GET['keywords']);
	}

	function ListStatus($keyword, $page){
		require_once("./inc/db.php");
		$where = (!$keyword || $keyword=="") ? " WHERE `status` LIKE '' " : " WHERE `status` LIKE '%$keyword%' ";
		$sql = "SELECT count(*) count FROM `status`".$where;
		
		$db = new DB();
		$rs = $db->query($sql);
		$totalRecords = $rs->row['count']; // total number of records
		
		if($totalRecords==0){//no records found, return;
			$outputHtml = "<div class='totalRecords' >Total Records: $totalRecords</div>";
			$outputHtml .="<div class='status'>
							There is no record of status found.
							</div>
							<ul class='statusOperationsUL'>
								<li><a href='' onclick='javascript: window.history.back(-1)'>Search Again</a></li>
								<li><a href='./'>Return to Home Page</a></li>
							</ul>";
			
			return $outputHtml;
		}
		
		//total pages of status		
		$totalPage = ($totalRecords%NUM_OF_STATUS_PER_PAGE == 0)              ? 
							$totalRecords / NUM_OF_STATUS_PER_PAGE            :
							((int)($totalRecords / NUM_OF_STATUS_PER_PAGE))+1;
							
		$pageHtml = "";
		//correct illegal $page in case needed
		$page = (($page > $totalPage) || $page <=0) ? 1 : $page;		
		
		$outputHtml = "<div class='totalRecords' >Total Records found: $totalRecords</div>";
		$sql ="SELECT * FROM `status` ";
		$limit = " LIMIT 0 , ". NUM_OF_STATUS_PER_PAGE." ";
		$orderBy = " ORDER BY  `statusCode` DESC  ";
		if($page>1){
			$limit = " LIMIT ".(NUM_OF_STATUS_PER_PAGE * ($page-1)).", ". NUM_OF_STATUS_PER_PAGE." ";
		}
		$sql .= $where. $orderBy . $limit;
		
		if($query = $db->query($sql)){
			$rows = $query->rows;
			foreach($rows as $row){
				$date = $row['date'];
				$status = $row['status'];
				$allowLike = ($row['allowLike']==1)? " Allow Like | ": "";
				$allowComment = ($row['allowComment']==1)? " Allow Comment | ": "";
				$allowShare = ($row['allowShare']==1)? " Allow Share ": "";
				$allow = "".$allowLike.$allowComment.$allowShare;
				if($row['allowLike']!=1 && $row['allowComment']!=1 && $row['allowShare']!=1){
					$allow = "None";
				}
				$share = $row['share'];
				if($share == 2){
					$share = " Friends ";
				}else if($share ==3){
					$share = " Only me ";
				}else{
					$share = " Public ";
				}
				$outputHtml .="<div class='status'>
									<div class='userInfoBox'>
										<ul>
											<li>Date: $date</li>
											<li>Share: $share</li>
											<li>Permission: $allow</li>
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
		
		$pageHtml = ($totalPage ==1) ? "" : $pageHtml;
		
		return $outputHtml."<ul class='statusOperationsUL'>
								<li><a href='./searchstatusform.php'>Search Again</a></li>
								<li><a href='./'>Return to Home Page</a></li>
							</ul>" .$pageHtml;
	}
?>

<!--mainbody start-->
<div class="mainBox">
	
    <div class='statusContainer'>
    	<h3>Search Status by: "<?php echo $keywords; ?>"</h3>
        <p></p>
		<?php echo ListStatus($keywords, $page); ?>
    </div>
    
</div>
<!--mainbody ends-->

<?php
	require_once("./inc/footer.php");
?>