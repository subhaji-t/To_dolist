<?php
if(isset($_POST['id'])){
    $sName = "localhost";     // The server name (usually 'localhost')
    $uName = "root";          // The username for the database
    $pass = "";               // The password for the database
    $db_name = "to_do_list";  // The name of the database you want to connect to

    // Create a MySQLi object and establish the connection
    $conn = new mysqli($sName, $uName, $pass, $db_name);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];

    if(empty($id)){
        echo 'error';
    }else {
        $todos = $conn->prepare("SELECT id, checked FROM todos WHERE id=?");
        $todos->bind_param("i", $id);
        $todos->execute();
        $todos->bind_result($uId, $checked);
        $todos->fetch();
        $todos->close();

        $uChecked = $checked ? 0 : 1;

        $res = $conn->query("UPDATE todos SET checked=$uChecked WHERE id=$uId");

        if($res){
            echo $checked;
        }else {
            echo "error";
        }

        // Close the database connection
        $conn->close();

        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}
?>
