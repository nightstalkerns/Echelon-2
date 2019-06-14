<?php
$auth_name = 'mapconfig';
require '../inc.php';

// set vars
$data = "";

$mapcycleFile = "../../echelonv1/files/mapcycle.txt";

if (isset($_POST['data'])) {
    //$data = (cleanvar($_POST['data']));
    $data = ($_POST['data']);
}

if ($data !== "") {
    $data = str_replace("&nbsp;", " ", $data);
    $data = str_replace("<br>", "\n", $data);
    $data = str_replace("<br />", "\n", $data);
    $data = str_replace("\\\"", "\"", $data);
    if (!file_put_contents($mapcycleFile, $data)) :
        sendBack('There is a problem. The mapcycle.txt has not been written.');
    endif;
}
else {
    sendBack('There is a problem. There was no data to write.');  
}
        
sendGood('The mapcycle.txt has been written.');

?>
