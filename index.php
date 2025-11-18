<?php

include('./vendor/autoload.php');

use  Argomedia\ToDoAppComposer\OperationCrud;






 $query = (new OperationCrud())
     ->select(['id', 'text',])
     ->from('tasks')
     ->execute();

    //   $query1 = (new OperationCrud())
     
    //  ->from('tasks')
    //  ->select(['id', 'text'])
    //  ->insert("'2','New Task'")
    //  ->executeInsert();



    
 echo "<br>";



 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h1>to do list</h1>
    <form>
        <input type="text" name="task" placeholder="New Task" required>
        <button>Add Task</button>
    </form>
    <ul>
        <?php foreach ($query as $row ) { ?>
            <li>
                    <?php echo "ID: {$row['id']} - Text: {$row['text']}<br>"; ?>
                    <form method="get">
                        <button name="delete" value="<?php echo $index; ?>">x</button>
                    </form>
                    <form method="get">
                        <button name="edit" value="<?php echo $index; ?>">edit</button>
                    </form>
                <?php } ?>
            </li>
    </ul>
</body>   
</html>

