<?php
// long-polling.php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

// Set timeout limit to 5 minutes

function getData() {
    $json = file_get_contents(__DIR__ . '/storage/messages.json');
    $data = json_decode($json);
    return $data;
}

function saveData($name, $message) {
    $data = getData();
    $item = new stdClass();
    $item->name = $name;
    $item->message = $message;
    $item->id = count($data->messages) + 1;
    array_push($data->messages, $item);
    $data->counter = $data->counter + 1;
    $json = json_encode($data);
    file_put_contents(__DIR__.'/storage/messages.json', $json);
    return getData();
}

set_time_limit(300);

// Simulate new data every 10 seconds
$newDataInterval = 10;

// Start time
$startTime = time();

$n = 0;

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    while (time() - $startTime < $newDataInterval) {
        if (isset($_GET['message'])) {
            $msg = $_GET['message'];
            $data = saveData($name, $msg);
            if ($data) {
                echo json_encode(['data' => $data]);
                exit;
            }
        } else {
            $data = getData();
            if ($data) {
                echo json_encode(['data' => $data]);
                exit;
            }
        }
        sleep(5000);
        echo json_encode(['data' => null]);
    }
} else {
    echo json_encode(['error' => 'Name parameter is required']);
}
