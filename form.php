<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['username']) && isset($_POST['regnumber']) &&
        isset($_POST['year']) && isset($_POST['branch']) && isset($_POST['tuser']) && isset($_POST['email'])
        && isset($_POST['phone'])) {
        
        $username = $_POST['username'];
        $regnumber = $_POST['regnumber'];
        $year = $_POST['year'];
        $branch = $_POST['branch'];
        $tuser = $_POST['tuser'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "info";

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM register WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(username, regnumber, year, branch, tuser, email, phone) values(?, ?, ?, ?, ?, ?, ?)";

            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;

            if ($rnum == 0) {
                $stmt->close();

                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssssi",$username, $regnumber, $year, $branch, $tuser, $email, $phone);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Email already registered.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>