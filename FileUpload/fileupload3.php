<!DOCTYPE html>
<html>
<head>
	<link rel="shortcut icon" href="../Resources/hmbct.png" />
</head>
<body>
<div style="background-color:#c9c9c9;padding:15px;">
      <button type="button" name="homeButton" onclick="location.href='../homepage.html';">Home Page</button>
      <button type="button" name="mainButton" onclick="location.href='fileupl.html';">Main Page</button>
</div>
<div align="center">
<form action="" method="post" enctype="multipart/form-data">
    <br>
    <b>Select image : </b> 
    <input type="file" name="file" id="file" style="border: solid;">
    <input type="submit" value="Submit" name="submit">
</form>
	</div>
<?php
if (isset($_POST["submit"])) {
   
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true); 
    }
    $file_name = basename($_FILES["file"]["name"]);
    $target_file = $target_dir . $file_name;

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_types = ['png', 'gif']; 
    $max_file_size = 2 * 1024 * 1024; 

    
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check !== false) {
        if (!in_array($imageFileType, $allowed_types)) {
            echo "Error: Solo se permiten archivos PNG y GIF.";
            $uploadOk = 0;
        }

        
        if ($_FILES["file"]["size"] > $max_file_size) {
            echo "Error: El archivo excede el tamaño máximo permitido (2 MB).";
            $uploadOk = 0;
        }
    } else {
        echo "Error: El archivo no es una imagen válida.";
        $uploadOk = 0;
    }

    
    if (file_exists($target_file)) {
        echo "Error: Ya existe un archivo con el mismo nombre.";
        $uploadOk = 0;
    }

    
    if ($uploadOk === 1) {
        
        $new_file_name = uniqid() . '.' . $imageFileType;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Archivo subido exitosamente: " . htmlspecialchars($new_file_name);
        } else {
            echo "Error: No se pudo subir el archivo.";
        }
    } else {
        echo "Error: No se pudo subir el archivo por problemas de validación.";
    }
} else {
    echo "Error: No se envió ningún archivo.";
}
?>

</body>
</html>
