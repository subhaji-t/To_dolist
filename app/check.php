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

        $conn->close();

        exit();
    }
}else {
    header("Location: ../index.php?mess=error");
}
?>

