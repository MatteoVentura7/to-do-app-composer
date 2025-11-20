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

// Gestione  per cancellare un  task
if (isset($_GET['delete'])) {
    $taskIdToDelete = $_GET['delete'];

    (new OperationCrud())
        ->from('tasks')
        ->where('id', $taskIdToDelete)
        ->executeDelete();

    header('Location: index.php');
    exit;
}

// Gestione  per modificare un  task
if (isset($_GET['edit']) && isset($_GET['save'])) {
    $taskIdToEdit = $_GET['edit'];
    $newTaskText = $_GET['save'];

    (new OperationCrud())
        ->from('tasks')
        ->select(['text'])
        ->edit(["'" . addslashes($newTaskText) . "'"])
        ->where('id', $taskIdToEdit)
        ->executeEdit();

    header('Location: index.php');
    exit;
}

// Gestione  per completare un  task
if (isset($_GET['complete'])) {
    $taskIdToComplete = $_GET['complete'];

    // Recupera il valore attuale di "completed"
    $currentCompleted = (new OperationCrud())
        ->from('tasks')
        ->select(['completed'])
        ->where('id', $taskIdToComplete)
        ->execute()
        ->fetch(PDO::FETCH_ASSOC)['completed'];

    // Calcola il nuovo valore (opposto)
    $newCompleted = $currentCompleted == 1 ? 0 : 1;

    // Aggiorna il valore di "completed"
    (new OperationCrud())
        ->from('tasks')
        ->select(['completed'])
        ->edit([$newCompleted])
        ->where('id', $taskIdToComplete)
        ->executeEdit();

    header('Location: index.php');
    exit;
}




$query = (new OperationCrud())
    ->select(['id', 'text', 'completed'])
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .completed {
            text-decoration: line-through;
            color: gray;
        }

        .complete {
            color: green;
        }
    </style>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center p-4">
    <h1 class="text-3xl font-bold text-blue-600 mb-6">To-Do List</h1>
    <form method="post" class="w-full max-w-md mb-6">
        <div class="flex items-center">
            <input type="text" name="task" placeholder="New Task" required
                class="flex-1 p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-r-md hover:bg-blue-600">Add
                Task</button>
        </div>
    </form>
    <ul class="w-full max-w-fit  bg-white shadow-md rounded-md divide-y divide-gray-200">
        <?php foreach ($query as $row) { ?>
            <li class="p-4 flex items-center justify-between">
                <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['id']) { ?>
                    <form method="get" class="flex items-center w-full">
                        <input type="text" name="save" value="<?php echo $row['text']; ?>" required
                            class="flex-1 p-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button name="edit" value="<?php echo $row['id']; ?>"
                            class="bg-green-500 text-white px-4 py-2 rounded-r-md hover:bg-green-600">Save</button>
                    </form>
                <?php } else { ?>
                    <div class="flex items-center align-middle space-x-4 pr-6">
                        <form method="get" class="pt-2 pr-6">

                            <button class="h-5 w-5 text-3xl  text-blue-600 <?php echo $row['completed'] ? 'complete' : ''; ?>"
                                name="complete" value="<?php echo $row['id']; ?>">
                                <?php if ($row['completed']) { ?>
                                    <i class="fa-solid fa-square-check"></i>
                                <?php } else { ?>
                                    <i class="fa-regular fa-square"></i>
                                <?php } ?>
                            </button>
                        </form>
                        <span class="<?php echo $row['completed'] ? 'completed' : ''; ?> text-lg ">
                            <p class="text-wrap"> <?php echo $row['text']; ?></p>
                        </span>
                    </div>
                    <div class="flex space-x-2 items-center pt-4">
                        <form method="get">
                            <button name="delete" value="<?php echo $row['id']; ?>"
                                class="bg-red-500 text-white px-2 py-2 rounded-md hover:bg-red-600"><i
                                    class="fa-solid fa-trash"></i></button>
                        </form>
                        <form method="get">
                            <button name="edit" value="<?php echo $row['id']; ?>"
                                class="bg-yellow-500 text-white px-2 py-2 rounded-md hover:bg-yellow-600"><i
                                    class="fa-solid fa-pencil"></i></button>
                        </form>
                    </div>
                <?php } ?>
            </li>
        <?php } ?>
    </ul>
</body>

</html>