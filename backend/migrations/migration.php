<?php
require_once("../connection.php");

function getMigrationFiles($conn) {
    $sqlFolder = str_replace('\\', '/', realpath(dirname(__FILE__)) . '/');
    $allFiles = glob($sqlFolder . '*.sql');
    $query = sprintf('show tables from `%s` like "%s"', DB_NAME, DB_TABLE_VERSIONS);
    $data = $conn->query($query);
    $firstMigration = !$data->rowCount();

    if ($firstMigration) {
        return $allFiles;
    }

    $versionsFiles = array();
    $query = sprintf('select `name` from `%s`', DB_TABLE_VERSIONS);
    $data = $conn->query($query)->fetchAll();

    foreach ($data as $row) {
        array_push($versionsFiles, $sqlFolder . $row['name']);
    }

    return array_diff($allFiles, $versionsFiles);

}


function migrate($conn, $file) {
    $statments = file_get_contents($file);
    $fileName = basename($file);

    try {
        $conn->exec($statments);
        echo "Migration ".$fileName." completed successfully <br /><br />";
        $sql = sprintf('insert into `%s` (`name`) values("%s")', DB_TABLE_VERSIONS, $fileName);
        $conn->exec($sql);
    }catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}

$conn = connectDB();


$files = getMigrationFiles($conn);


if (empty($files)) {
    echo 'Ваша база данных в актуальном состоянии';
} else {

    echo 'Start Migration<br /><br />';

    foreach ($files as $file) {
        migrate($conn, $file);
    }

    echo '<br />Migration ended';
}
