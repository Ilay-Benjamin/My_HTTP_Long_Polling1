<?php
require './inc/bootstrap.php';

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

$method = $_SERVER['REQUEST_METHOD'];
$protocol = $_SERVER['SERVER_PROTOCOL'];
$headers = getallheaders();

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

$fixedPath = strtolower(substr($path, 1));
$list = (explode("/", $fixedPath));
$workspacename = "";
$actionName = "";
$fileBasename = $list[count($list) - 1];
$fileName = $list[count($list) - 1];
$filePath = "";

$strList = json_encode($list);

echo "<h2 style='color: green;'>";
echo($strList);
echo "</h2>";

function sendView($path) {

    echo file_get_contents($path);

}

try {
    if (count($list) < 1 || $list[0] === "") {
        throw new Exception("Empty path");
    }
    if (Workspaces::tryFrom($list[0]) === null) {
        throw new Exception("Invalid workspace");
    }
    $workspacename = $list[0];
    if (count($list) < 2 || $list[1] === "") {
        throw new Exception("Empty Action");
    }
    if (Actions::tryFrom($list[1]) === null) {
        throw new Exception("Invalid action");
    }
    $actionName = $list[1];
    if (count($list) < 3 || $list[2] === "") {
        throw new Exception("Empty file");
    }
    if (Views::tryFrom($list[2]) === null) {
        throw new Exception("Invalid file");
    }
    $fileBasename = $list[2];
    $file = Views::tryFrom($fileBasename)->getFile();
    $fileName = $file['name'];
    $filePath = $file['path'];
    sendView($filePath);
} catch(Exception $e) {
    if ($e->getMessage() === "Empty path") {
        $workspacename = Workspaces::BLOG->value;
        $actionName = Actions::VIEW->value;
        $file = Views::HOME->getFile();
        $fileBasename = $file['baseName'];
        $fileName = $file['name'];
        $filePath = $file['path'];
        $list[0] = $workspacename;
        $list[1] = $actionName;
        $list[2] = $fileBasename;
        echo "<h1>Empty Path</h1>";
        sendView($filePath);
    } else if ($e->getMessage() === "Invalid workspace") {
        echo "<h1>Invalid workspace</h1>";
        unset($list[1]);
        unset($list[2]);
        $list = array_values($list);
    } else if ($e->getMessage() == "Empty Action") {
        $actionName = Actions::VIEW->value;
        $file = Views::HOME->getFile();
        $fileBasename = $file['baseName'];
        $fileName = $file['name'];
        $filePath = $file['path'];
        $list[0] = $workspacename;
        $list[1] = $actionName;
        $list[2] = $fileBasename;
        echo "<h1>Empty Action</h1>";
        sendView($filePath);
    } else if ($e->getMessage() == "Invalid action") {
        echo "<h1>Invalid Action</h1>";
        unset($list[1]);
        $list = array_values($list);
    } else if ($e->getMessage() == "Empty file") {
        $file = Views::HOME->getFile();
        $fileBasename = $file['baseName'];
        $fileName = $file['name'];
        $filePath = $file['path'];
        $list[0] = $workspacename;
        $list[1] = $actionName;
        $list[2] = $fileBasename;
        echo "<h1>Empty File</h1>";
        sendView($filePath);
    } else if ($e->getMessage() == "Invalid file") {
        $file = Views::ERROR->getFile();
        $fileBasename = $file['baseName'];
        $fileName = $file['name'];
        $filePath = $file['path'];
        $list[0] = $workspacename;
        $list[1] = $actionName;
        $list[2] = $fileBasename;
        echo "<h1>Invalid File</h1>";
        sendView($filePath);
    }
}



$strList = json_encode($list);

echo "<h2 style='color: blue;'>";
echo($strList);
echo "</h2>";



//echo "Not Found!";