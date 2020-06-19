<?php
$servername = "localhost";
$username = "pi";
$password = "raspberry";
$dbname = "pcbv2";

echo "<h3 style='color: #3d3d3d;'>Veeam workstation backup summary</h3>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT pcname,status,date FROM pc GROUP BY pcname ORDER BY date DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

	// pielago stilu konkretajam PC statusam

	if ($row[status] == 1) {
		$style = "border: 1px solid #3d3d3d; text-decoration: none; color: #3d3d3d; background-color: #00B050; width: 20%; padding: 10px; margin: 3px; float: left; text-align: center;";
		$status = "Success";
	} elseif ($row[status] == 2) {
		$style = "border: 1px solid #3d3d3d; text-decoration: none; color: #3d3d3d; background-color: #ffd96c; width: 20%; padding: 10px; margin: 3px; float: left; text-align: center;";
		$status = "Warning";
	} elseif ($row[status] == 3) {
		$style = "border: 1px solid #3d3d3d; text-decoration: none; color: #3d3d3d; background-color: #fb9895; width: 20%; padding: 10px; margin: 3px; float: left; text-align: center;";
		$status = "Failed";
	} else {
		$style = "border: 1px solid #3d3d3d; text-decoration: none; color: #3d3d3d; width: 20%; padding: 10px; margin: 3px; float: left; text-align: center;";
		$status = "Unknown";
	}

        echo "<h4><a href='message.php?pcname=". $row['pcname']. "' style='". $style . "'>". $row['pcname']. " = ". $status. "</a></h4>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>

