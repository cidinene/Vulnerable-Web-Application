<!DOCTYPE html>
<html>
<head>
	<title>SQL Injection</title>
	<link rel="shortcut icon" href="../Resources/hmbct.png" />
</head>
<body>

	 <div style="background-color:#c9c9c9;padding:15px;">
      <button type="button" name="homeButton" onclick="location.href='../homepage.html';">Home Page</button>
      <button type="button" name="mainButton" onclick="location.href='sqlmainpage.html';">Main Page</button>
	</div>

	<div align="center">
	<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" >
		<p>John -> Doe</p>
		First name : <input type="text" name="firstname">
		<input type="submit" name="submit" value="Submit">
	</form>
	</div>


<?php

$config = require __DIR__ . '/config.php';


$servername = $config['servername'];
$username = $config['username'];
$password = $config['password'];
$db = $config['database'];


$conn = mysqli_connect($servername, $username, $password, $db);


if (!$conn) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_POST["submit"])) {
    
    if (isset($_POST["firstname"]) && !empty(trim($_POST["firstname"]))) {
        $firstname = trim($_POST["firstname"]);

       
        $stmt = $conn->prepare("SELECT lastname FROM users WHERE firstname = ?");
        $stmt->bind_param("s", $firstname); 
        $stmt->execute();
        $result = $stmt->get_result();

        
        if ($result->num_rows > 0) {
            
            while ($row = $result->fetch_assoc()) {
                echo htmlspecialchars($row["lastname"]) . "<br>"; 
            }
        } else {
            echo "No se encontraron resultados.";
        }

        
        $stmt->close();
    } else {
        echo "Por favor, ingrese un nombre válido.";
    }
}


mysqli_close($conn);
?>


</body>
</html>
