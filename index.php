<?php 
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To-Do List</title>
    <link rel="stylesheet" href="css/style1.css">
</head>
<body>
    <div class="main-section">
       <div class="add-section">
          <form action="app/add.php" method="POST" autocomplete="off">
             <?php if(isset($_GET['mess']) && $_GET['mess'] == 'error'){ ?>
                <input type="text" 
                     name="title" 
                     style="border-color: #ff6666"
                     placeholder="This field is necessary" />
              <button type="submit">Add &nbsp;</button>

             <?php }else{ ?>
              <input type="text" 
                     name="title" 
                     placeholder="Enter Task" />
              <button type="submit">Add &nbsp;</button>
             <?php } ?>
          </form>
       </div>
       <?php 
          $todos = $conn->query("SELECT * FROM todos ORDER BY id DESC");
       ?>
       <div class="show-todo-section">
            <?php if($todos->num_rows <= 0){ ?>
                <div class="todo-item">
                    <div class="empty">
                        <img src="image/Rose.jpg" width="100%" />
                        <img src="image/Bird.jpg" width="80px">
                    </div>
                </div>
            <?php } ?>

            <?php while($todo = $todos->fetch_assoc()) { ?>
                <div class="todo-item">
                    <span id="<?php echo $todo['id']; ?>"
                          class="remove-to-do">x</span>
                    <?php if($todo['checked']){ ?> 
                        <input type="checkbox"
                               class="check-box"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               checked />
                        <h2 class="checked"><?php echo $todo['title'] ?></h2>
                    <?php }else { ?>
                        <input type="checkbox"
                               data-todo-id ="<?php echo $todo['id']; ?>"
                               class="check-box" />
                        <h2><?php echo $todo['title'] ?></h2>
                    <?php } ?>
                    <br>
                    <small>created: <?php echo $todo['date_time'] ?></small> 
                </div>
            <?php } ?>
       </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

    <script>
      $(document).ready(function () {
         $('.remove-to-do').click(function () {
        const id = $(this).attr('id');
        const element = $(this);

      $.post(
        'app/remove.php',
        {
          id: id,
        },
        function (data) {
          if (data === '1') {
            element.parent().hide(600);
          }
        }
      );
    });

    $('.check-box').click(function (e) {
      const id = $(this).attr('data-todo-id');
      const element = $(this).next('h2');

      $.post(
        'app/check.php',
        {
          id: id,
        },
        function (data) {
          if (data !== 'error') {
            if (data === '1') {
              element.removeClass('checked');
            } else {
              element.addClass('checked');
            }
          }
        }
      );
    });
  });
</script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>


