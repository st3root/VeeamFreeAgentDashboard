<?php
$servername = "localhost";
$username = "pi";
$password = "raspberry";
$dbname = "pcbv2";
$mypcname = htmlspecialchars($_GET["pcname"]);
echo "<a style='border: 1px solid #3d3d3d; text-decoration: none; color: #3d3d3d; background-color: #fff; width: 100px; padding: 10px; margin: 3px' href='index.php'> << Back</a><br>";

//echo $mypcname;
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT message,date FROM messages WHERE pcname = '$mypcname' ORDER BY date DESC LIMIT 10";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo $row['message']. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>
