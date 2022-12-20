<?php
session_start();
include "front/includes/header.php";
?>

    <a href="backend/logout.php" class='btn btn-outline-dark float-right'>Выйти</a>


    <div class="container align-items-center pt-5">

        <form >
            <div class="row justify-content-center">

                <div class="col-md-8">
                    <input class="form-control" id="taskTextInput" aria-describedby="taskHelp" placeholder="Enter text...">
                </div>
                <div>
                    <button class="btn btn-primary btn-dark float-right" id="addTask">Add Task</button>
                </div>
            </div>
        <div class="row justify-content-center">
            <button class="btn btn-outline-dark" id="removeAllBtn">Remove All</button>
            <button class="btn btn-outline-dark" id="readyAllBtn">Ready All</button>
        </div>
        </form>
    </div>

<?php
include 'backend/tasklist.php';
$tasks = getTasks();

?>
    <div class="container align-items-center pt-5">
        <table class="table table-striped text-center" id="taskTbl">
            <tbody>
                <?php  if( isset($tasks) && $tasks != null): ?>
                    <?php foreach ($tasks as $task): ?>
                        <?php if($task != null):?>
                        <?php $statiusColour = ($task['status']==true) ? 'green': 'red'; ?>
                            <tr>
                                <td id="taskId" hidden><?= htmlspecialchars($task['id'])?></td>
                                <td style="width:80%"><?= htmlspecialchars($task['description']) ?></td>
                                <td class="noborder"><button class="btn" id="taskStatus" value="ready" style="color:<?= $statiusColour ?>">READY</button></td>
                                <td class="noborder"><button class="btn" id="taskDelete" value="delete">DELETE</button></td>
                            </tr>
                        <?php endif; ?>
                    <?php  endforeach; ?>
                <?php endif;  ?>
            </tbody>
        </table>
    </div>




<?php
include 'front/includes/footer.php';
