<?php 


$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "form";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}





$flag1 = $flag2 = $flag3 = "";
$nameErr = $contactErr = $emailErr = "";
$name = $contact = $email ="";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$naemErr = "Name is required";
		$flag1 = 1;
		} else {
			$name = test_input($_POST["name"]);
			if(!preg_match("/^[a-zA-Z]*$/", $name)) {
					$flag1 = 1;
					$nameErr = "Only letters and white space allowed";
					}
				}
	if(empty($_POST["contact"])) {
		$flag2 = 1;
		$contactErr = "Contact is required";
			}
	else {
		$contact = test_input($_POST["contact"]);
		if((!strlen($contact) == 10) && (!preg_match("/^[0-9]*$/", $contact))) {
				$flag2 = 1;
				$contactErr = "Add appropriate phone number";
					}
				}
	 if (empty($_POST["email"])) {
	 	$flag3 = 1;
    	$emailErr = "Email is required";
   } else {
   		 $email = test_input($_POST["email"]);
    	 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    	 	 $flag3 = 1;
      		 $emailErr = "Invalid email format";
     }
	}
	}
	if($flag1 || $flag2 || $flag3) {
		echo $nameErr;
		echo $contactErr;
		echo $emailErr;
	}
	else {
		$sql = "INSERT INTO form_table (name, contact, email)
VALUES ('$name', '$contact', '$email')";

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully<br>";
    
    $sql = "SELECT * FROM form_table";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["name"]. " contact" . $row["contact"]. " " . $row["email"]. "<br>";
    }
} else {
    echo "0 results";
}
    
    
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
	}
	mysqli_close($conn);
function test_input($data) {
   $data = trim($data);
   $data = stripslashes($data);
   $data = htmlspecialchars($data);
   return $data;
}
?>
