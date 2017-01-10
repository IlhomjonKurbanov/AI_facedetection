<!DOCTYPE html>
<head>
    <title>Wrzuć zdjęcie</title>
	<link href="css/form.css" type="text/css" rel="stylesheet" />

</head>
<body>
		<div class="login-page">
			 <div class="form">
    <?php if(empty($_POST["pass"])) { ?>
					<form action="upload.php" method="post" enctype="multipart/form-data" class="register-form form pure-form">
					<p>Wybierz plik do pobrania:</p>
					<p><input type="file" name="fileToUpload" id="fileToUpload"></p>
					<p>Hasło: <input type="password" name="pass" id="fileToUpload"></p>
				   <p><input type="submit" value="Wrzuć" name="submit"></p>
				</form>
    <?php
        }
        else if(md5($_POST["pass"]) == "35b9ec58626112b6fd736e672c1f71ed") {
            $target_dir = "img/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            if (isset($_POST["submit"])) {
                $check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "Plik nie jest obrazem.";
                    $uploadOk = 0;
                }
            }
            if (file_exists($target_file) &&  $uploadOk) {
                echo "Plik o tej nazwie istnieje.";
                $uploadOk = 0;
            }
            if ($_FILES["fileToUpload"]["size"] > 500000 &&  $uploadOk) {
                echo "Plik jest zbyt duży.";
                $uploadOk = 0;
            }
            $image_info = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);

            if($image_info[0] > 800 && $image_info[1] > 600 &&  $uploadOk){
                echo "Rozdzielczość zbyt duża. Maks 800 x 600";
                $uploadOk = 0;
            }



            if ($imageFileType != "jpg" &&  $uploadOk) {
                echo "Dozwolony jedynie format jpg";
                $uploadOk = 0;
            }
            if ($uploadOk == 0) {
                echo " Plik nie został wrzucony.";
            } else {
                if (@move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "Plik " . basename($_FILES["fileToUpload"]["name"]) . " został wrzucony.";
                } else {
                    echo "Błąd uploadowania pliku";
                }
            }
        } 
		else {
		     echo "Błędne hasło";
		}
    ?>
				<a href="index.php">&lt; &lt;</a>
			</div>
		</div>
</body>