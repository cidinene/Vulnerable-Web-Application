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
		<p>Give me book's number and I give you book's name in my library.</p>
		Book's number : <input type="text" name="number">
		<input type="submit" name="submit" value="Submit">
		<!-- <p>//Is this same with the level 2?</p>-->
	</form>
	</div>

<?php
require __DIR__ . '/vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$servername = $_ENV['DB_SERVERNAME'];
$username = $_ENV['DB_USERNAME'];
$password = $_ENV['DB_PASSWORD'];
$db = $_ENV['DB_DATABASE'];


$conn = new mysqli($servername, $username, $password, $db);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["submit"])) {
    if (isset($_POST['number']) && is_numeric($_POST['number'])) {
        $number = intval($_POST['number']); 

        
        $stmt = $conn->prepare("SELECT bookname, authorname FROM books WHERE number = ?");
        $stmt->bind_param("i", $number);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<hr>";
                echo htmlspecialchars($row['bookname']) . " ----> " . htmlspecialchars($row['authorname']);
            }
        } else {
            echo "No results found.";
        }

        $stmt->close();
    } else {
        echo "Please enter a valid number.";
    }
}

$conn->close();
?>


</body>
</html>
