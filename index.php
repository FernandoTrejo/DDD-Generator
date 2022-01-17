<?php

include_once "./generator.php";

if(isset($_POST["info"])){
    $namespace = $_POST["namespace"];
    $modelName = $_POST["modelName"];
    $properties = $_POST["properties"];

    $propsParts = explode("\n", $properties);
    $props = [];
    foreach($propsParts as $propPart){
        $data = explode(",", $propPart);
        $props[] = [
            'name' => $data[0],
            'type' => $data[1]
        ];
    }
    // print_r($props);
    $generator = new Gen($namespace, $modelName, $props);
    $generator->generate();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>

<body>
    <form action="" method="post">
        Namespace: <input type="text" name="namespace" id="">
        Model Name: <input type="text" name="modelName" id=""> <br>
        Properties: <textarea name="properties"></textarea> <br>
        <button type="submit" name="info">Send</button>
    </form>
</body>

</html>