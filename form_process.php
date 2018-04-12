<?php

$con = mysqli_connect('89.37.67.130', 'purlads', 'Funnypaki@123');

if (!$con) {
	echo 'not connected';
} else {
	echo 'connected';
}

// define variables and set to empty values
$name_error = $email_error = $phone_error = $url_error = "";
$name = $email = $phone = $message = $url = $success = "";

//form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["name"])) {
		$name_error = "Name is required";
	} else {
		$name = testInput($_POST["name"]);
		// check if name only contains letters and whitespace
		if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
			$name_error = "Only letters and white space allowed";
		}
	}

	if (empty($_POST["email"])) {
		$email_error = "Email is required";
	} else {
		$email = testInput($_POST["email"]);
		// check if e-mail address is well-formed
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$email_error = "Invalid email format";
		}
	}

	if (empty($_POST["phone"])) {
		$phone_error = "Phone is required";
	} else {
		$phone = testInput($_POST["phone"]);
		// check if e-mail address is well-formed
		if (!preg_match("/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i", $phone)) {
			$phone_error = "Invalid phone number";
		}
	}

	if (empty($_POST["url"])) {
		$url_error = "";
	} else {
		$url = testInput($_POST["url"]);
		// check if URL address syntax is valid (this regular expression also allows dashes in the URL)
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
			$url_error = "Invalid URL";
		}
	}

	if (empty($_POST["message"])) {
		$message = "";
	} else {
		$message = testInput($_POST["message"]);
	}

	if ($name_error == '' and $email_error == '' and $phone_error == '' and $url_error == '') {
		// $message_body = '';
		// unset($_POST['submit']);
		// foreach ($_POST as $key => $value){
		//     $message_body .=  "$key: $value\n";
		// }

		// $to = 'mohammad.faizan@inseyab.com';
		// $subject = 'Contact Form Submit';
		// if (mail($to, $subject, $message)){
		//     $success = "Message sent, thank you for contacting us!";
		//     $name = $email = $phone = $message = $url = '';
		// }
		$con = mysqli_connect('89.37.67.130', 'purlads', 'Funnypaki@123');

		if (!$con) {
			echo 'not connected';
		} else {
			echo 'connected';
		}

		if (!mysqli_select_db($con, 'test')) {
			echo 'Database not selected';
		}

		$name = $_POST["name"];
		$email = $_POST["email"];
		$phone = $_POST["phone"];
		$url = $_POST["url"];
		$name = $_POST["message"];

		$sql = "insert into contacts (name, email, number, url, message) values('$name','$email','$number','$url','$message')";

		if (!mysqli_query($con, $sql)) {
			echo 'Not inserted';
		} else {
			echo "inserted";
		}

		header("refresh:5; url=form.php");
	}

}

function testInput($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}
