<?php
if(isset($_POST['id'])){
    $sName = "localhost";
    $uName = "root";
    $pass = "";
    $db_name = "to_do_list";

    $conn = new mysqli($sName, $uName, $pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = $_POST['id'];

    if (empty($id)) {
        echo 0;
    } else {
        $stmt = $conn->prepare("DELETE FROM todos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $res = $stmt->execute();

        if ($res) {
            echo 1;
        } else {
            echo 0;
        }

        $stmt->close();
        $conn->close();

        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}
?>
