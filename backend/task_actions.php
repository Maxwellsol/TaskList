<?php
function getTasks(){
    $conn = connectDB();
    try {
        $sql = 'SELECT * FROM `tasks` WHERE `user_id` = :user_id';
        $userId = $_SESSION['user_id'];
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id'=>$userId]);
        return $stmt->fetchAll();
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
};


function addTask($text, $conn, $userId){
    try {
        $sql = "INSERT INTO `tasks` (`description`, `user_id`) VALUES (:desc, :user_id)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':desc' => $text, ':user_id' => $userId]);
        $taskId = $conn->lastInsertId();
        echo $taskId;
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
}

function removeAll($conn, $userId){
    try {
        $sql = "DELETE FROM `tasks` WHERE `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        echo 'all deleted';
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
}

function readyAll($conn, $userId){
    try {
        $sql = "UPDATE `tasks` SET `status` = true WHERE `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        echo 'all ready';
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
}

function changeStatus($taskId, $conn, $userId){
    try {
        $statusSql = "SELECT `status` FROM `tasks` WHERE `id` = :task_id AND `user_id` = :user_id";
        $statusStmt = $conn->prepare($statusSql);
        $statusStmt->execute([':task_id'=> $taskId, ':user_id' => $userId]);
        $status = $statusStmt->fetch();
        if($status['status'] == 1){
            $newStatus = 0;
        }else{
            $newStatus = 1;
        }
        $sql = "UPDATE `tasks` SET `status` = :new_status WHERE `id` = :task_id AND `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':new_status' => $newStatus,':task_id'=> $taskId, ':user_id' => $userId]);
        echo $status['status'];
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
}

function deleteTask($taskId, $conn, $userId){
    try {
        $sql = "DELETE FROM `tasks` WHERE `id` = :task_id AND `user_id` = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':task_id'=> $taskId, ':user_id' => $userId]);
        echo $taskId;
    }catch (PDOException $e){
        echo "DatabaseError: ".$e;
    }
}
