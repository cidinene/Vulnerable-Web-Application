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

    $uploadOk = 1; 
    $allowed_types = ['image/png', 'image/jpeg']; 
    $max_file_size = 2 * 1024 * 1024; 

    
    if (!isset($_FILES["file"]["tmp_name"]) || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
        echo "Error: No se seleccionó un archivo válido.";
        $uploadOk = 0;
    }

   
    $file_type = mime_content_type($_FILES["file"]["tmp_name"]);
    if (!in_array($file_type, $allowed_types)) {
        echo "Error: Solo se permiten archivos JPG, JPEG y PNG.";
        $uploadOk = 0;
    }

    
    if ($_FILES["file"]["size"] > $max_file_size) {
        echo "Error: El archivo excede el tamaño máximo permitido (2 MB).";
        $uploadOk = 0;
    }

   
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check === false) {
        echo "Error: El archivo no es una imagen válida.";
        $uploadOk = 0;
    }

   
    $file_extension = strtolower(pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION));
    $new_file_name = uniqid() . '.' . $file_extension;
    $target_file = $target_dir . $new_file_name;

    
    if ($uploadOk === 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "Archivo subido exitosamente: /uploads/" . htmlspecialchars($new_file_name);
        } else {
            echo "Error: No se pudo subir el archivo.";
        }
    } else {
        echo "Error: No se pudo completar la subida del archivo.";
    }
} else {
    echo "Error: No se recibió un archivo.";
}
?>


</body>
</html>
