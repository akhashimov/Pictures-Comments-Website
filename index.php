<?php
	require_once("track.php");
	$hitctr= new hitCounter("./stats/totalHits1.txt","./stats/visits1.txt");
	$hitctr->incrCounter();
	$connect = new PDO("mysql: host=localhost; dbname=walls; charset=utf8","root",'9W3UmvzMAy95YsAe');
	
	$walls = $connect->query("SELECT * FROM walls.walls ORDER BY datetime DESC");
	$walls = $walls->fetchAll(PDO::FETCH_ASSOC);

?>
<?
	require_once("header.php")
?>	
	<div class="walls">			

			<?
			if ($walls){
				foreach($walls as $wall){
				echo "<a href=/wall.php/$wall[photoid]>";
				echo '<img id="wall-img" src="data:image/jpeg;base64,'.base64_encode( $wall['formated_img'] ).'" max-height="10%" max-width="10%" /></a>';
				}}
				else{
				echo "Be the first one to create a wall !";
			}?>
		</div>
<?
require_once("footer.php");
?>