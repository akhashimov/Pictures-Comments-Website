<?php
	require_once("track.php");
	$hitctr = new hitCounter("./stats/totalHits1.txt","./stats/visits3.txt");
	$hitctr->incrCounter();
	function convertImage($originalImage, $outputImage, $quality,$ext)
{

    if (preg_match('/jpg|jpeg/i',$ext))
        $imageTmp=imagecreatefromjpeg($originalImage);
    else if (preg_match('/png/i',$ext))
        $imageTmp=imagecreatefrompng($originalImage);
    else if (preg_match('/gif/i',$ext))
        $imageTmp=imagecreatefromgif($originalImage);
    else if (preg_match('/bmp/i',$ext))
        $imageTmp=imagecreatefrombmp($originalImage);
    else
        return 0;

    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
	$connect = new PDO("mysql: host=localhost; dbname=walls; charset=utf8","root",'9W3UmvzMAy95YsAe');	
	$walls = $connect->query("SELECT * FROM walls.walls ORDER BY datetime DESC");
?>
<?
	require_once("header.php")
?>
	<form method="POST" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
		<div class="fileUpload">
		Choose wallpicture
		<input class="upload" type="file" name="wall-paper" required>
			</div>
		<textarea name="wall-text" id="" cols="30" rows="10" required placeholder="WALL Text"></textarea>
			
		<input type="submit" value="PROCEED" class="send">

	</form>

<?
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $walltext = test_input($_POST["wall-text"]);
  $target_dir = "./wallpapers/";
  $target_file=basename($_FILES["wall-paper"]["name"]);

 
	$uploadOk = 1;
	$initial_name=$_FILES["wall-paper"]["name"];

	if(!isset($_POST["submit"])) {
	// Check file size
	if ($_FILES["wall-paper"]["size"] > 4000000 or $_FILES["wall-paper"]["size"] < 100) {
	    echo "<br>
	    Image size does not fit.<br>
	    The image size should be between 1 Kb and 4 Mb.<br>";
	    $uploadOk = 0;
	}
	else{		
	        // Check if image file is a actual image or fake image
	        $check = getimagesize($_FILES["wall-paper"]["tmp_name"]);
	            if($check !== false) {
	            	
	                // Allow certain file formats
	                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
	                    && $imageFileType != "gif" ) {
	                        echo "Please verify that the image extension is one of the following: jpg, jpeg, gif, png<br>";
	                        $uploadOk = 0;
	                    }
	                    else{
	                    		
	                        $uploadOk = 1;
	                        $extension = str_replace("image/","", $check["mime"]);
	                        //ID assignment
	                        $ID=rand(1000,9999);
	                        $target_file = $target_dir.$ID."_".basename($_FILES["wall-paper"]["name"]);
	                        while (file_exists($target_file)) {
	                            $ID=rand(1000,9999);
	                            $target_file = $target_dir.$ID."_". basename($_FILES["wall-paper"]["name"]);
	                        };
	                     }
	            } 
	            else {
	                echo "File is not an image.";
	                $uploadOk = 0;
	                }
	            }
	}
	if ($uploadOk == 1){
	    if (move_uploaded_file($_FILES["wall-paper"]["tmp_name"],$target_file)) {
	            $ip_forwarded=$_SERVER['HTTP_X_FORWARDED_FOR'];
	            $ip_client= $_SERVER['HTTP_CLIENT_IP'];
	            $ip_remote=$_SERVER['REMOTE_ADDR'];

  	            $formated_img=$target_file."_formated.jpg";
				
				convertImage($target_file,$formated_img,90,$extension);
				
				$final_formated=addslashes(file_get_contents($formated_img));
				$imageitself=addslashes(file_get_contents($target_file));
				

	            $query=$connect->query("INSERT INTO walls.walls (text,photoid,photo_init,ip_forwarded,ip_client,ip_remote,extension,formated_img,image) VALUES ('$walltext',$ID,'$initial_name','$ip_forwarded','$ip_client','$ip_remote','$extension','$final_formated','$imageitself')");
	            if ($query){
	            	
	            }
	            else {
	            	echo " <br>чёт не так (<br>";
	             }
	            echo '<div class="uploadComplete">The WALL has been created !</div>'; }
	    else {
	            echo "Sorry, there was an error uploading your file.";
	}
	}
}?>

<?
require_once("footer.php");
?>
