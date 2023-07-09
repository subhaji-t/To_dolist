<?php
if (isset($_POST['title'])) {
    $sName = "localhost";
    $uName = "root";
    $pass = "";
    $db_name = "to_do_list";

    $conn = new mysqli($sName, $uName, $pass, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $title = $_POST['title'];

    if (empty($title)) {
        header("Location: ../index.php?mess=error");
    } else {
        $stmt = $conn->prepare("INSERT INTO todos (title) VALUES (?)");
        $stmt->bind_param("s", $title);
        $res = $stmt->execute();

        if ($res) {
            header("Location: ../index.php?mess=success");
        } else {
            header("Location: ../index.php");
        }

        $stmt->close();
        $conn->close();

        exit();
    }
} else {
    header("Location: ../index.php?mess=error");
}
?>
