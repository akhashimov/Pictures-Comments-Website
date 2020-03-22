<?php
	require_once("track.php");
	$hitctr= new hitCounter("./stats/totalHits2.txt","./stats/visits2.txt");
	$hitctr->incrCounter();
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	
	$connect = new PDO("mysql: host=localhost; dbname=walls; charset=utf8","root",'9W3UmvzMAy95YsAe');
	$photoid=substr($_SERVER['REQUEST_URI'],10);
	$wall = $connect->query("SELECT * FROM walls.walls WHERE photoid=$photoid");
	$wall = $wall->fetchAll(PDO::FETCH_ASSOC);
?>
<?
	require_once("header.php")
?>
		
		<div class="wall">
			<?
			echo '<img src="data:image/jpeg;base64,'.base64_encode( $wall[0]['formated_img'] ).'"/>';
			?>
		</div>

		<div class="wall-txt">
			<?	
					echo $wall[0]["text"];
					echo "<br>";
				?>		
		</div>
		


<?
require_once("footer.php");
?>