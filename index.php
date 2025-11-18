<?php

include('./vendor/autoload.php');

use Argomedia\ToDoAppComposer\OperationCrud;

// Gestione  per aggiungere un nuovo task
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task'])) {
    $taskText = $_POST['task'];


    (new OperationCrud())
        ->from('tasks')
        ->select(['id', 'text'])
        ->insert(["NULL", "'" . addslashes($taskText) . "'"])
        ->executeInsert();


    header('Location: index.php');
    exit;
}

$query = (new OperationCrud())
    ->select(['id', 'text',])
    ->from('tasks')
    ->execute();

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
    <form method="post">
        <input type="text" name="task" placeholder="New Task" required>
        <button type="submit">Add Task</button>
    </form>
    <ul>
        <?php foreach ($query as $row) { ?>
            <li>
                <?php echo "ID: {$row['id']} - Text: {$row['text']}<br>"; ?>
                <form method="get">
                    <button name="delete" value="<?php echo $row['id']; ?>">x</button>
                </form>
                <form method="get">
                    <button name="edit" value="<?php echo $row['id']; ?>">edit</button>
                </form>
            <?php } ?>
        </li>
    </ul>
</body>

</html>