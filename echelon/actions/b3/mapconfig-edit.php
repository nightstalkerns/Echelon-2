<?php
$auth_name = 'mapconfig';
$b3_conn = true; // this page needs to connect to the B3 database
require '../../inc.php';

// set vars
$id = cleanvar($_POST['id']);
$mapname = cleanvar($_POST['mapname']);

## check numeric id ##
if(!is_numeric($id))
    sendBack('Invalid data sent, request aborted');
        
$capturelimit = cleanvar($_POST['capturelimit']);
$g_suddendeath = cleanvar($_POST['g_suddendeath']);
$g_gear = cleanvar($_POST['g_gear']);
$g_gravity = cleanvar($_POST['g_gravity']);
$g_friendlyfire = cleanvar($_POST['g_friendlyfire']);
$g_knockback = cleanvar($_POST['g_knockback']);
$timelimit = cleanvar($_POST['timelimit']);


if(isset($_POST['startmessage'])) $startmessage = cleanvar($_POST['startmessage']);
if($startmessage == null) $startmessage = "";
$skiprandom = cleanvar($_POST['skiprandom']);
$datelastadd = cleanvar($_POST['datelastadd']);

## check numeric ##
if(!is_numeric($g_suddendeath)) $g_suddendeath = 0;
if(!is_numeric($g_gravity)) $g_gravity = 800;
if(!is_numeric($g_friendlyfire)) $g_friendlyfire = 0;
if(!is_numeric($g_knockback)) $g_knockback = 6000;
if(!is_numeric($skiprandom)) $skiprandom = 0;
if(!is_numeric($timelimit)) $timelimit = 20;
//if (!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $datelastadd)) {
//    $datelastadd = "2000-01-01";
//}
$dt = DateTime::createFromFormat("Y-m-d", $datelastadd);
// logic will check for errors, so negate it
if(!($dt !== false && !array_sum($dt::getLastErrors()))) {
    $datelastadd = "2000-01-01";
}

if (is_null($g_gear) || $g_gear == "") $g_gear = "0";

// check for empty inputs
emptyInput($mapname, 'map name');


## Query Section ##


if($_POST['t'] == 'del') : // delete mapconfig
    $result = $db->delMapconfig($id);
    if($result)
        sendGood('Mapconfig has been deleted');
    else
        sendBack('There is a problem. The mapconfig has not been deleted');
    exit;
elseif($_POST['t'] == 'edit') :  // edit/update a mapconfig
    $result = $db->editMapconfig($id, $mapname, $capturelimit, $g_suddendeath, $g_gear, $g_gravity, $g_friendlyfire, $g_knockback, $startmessage, $skiprandom, $datelastadd, $timelimit);
    if($result)
        sendGood($mapname."'s information has been updated");
    else
        sendBack('There is a problem. The mapconfig information has not been changed');
    exit;
elseif($_POST['t'] == 'add') :  // add a new mapconfig
    $result = $db->addMapconfig($mapname, $capturelimit, $g_suddendeath, $g_gear, $g_gravity, $g_friendlyfire, $g_knockback, $startmessage, $skiprandom, $datelastadd, $timelimit);
    if($result)    
        sendGood($mapname."'s information has been saved");
    else
        sendBack('There is a problem. The mapconfig has not been saved');
    exit;
else :
        sendBack('There is a problem. Unknown command received.');
endif;


## return good ##
sendGood('Your mapconfig information has been successfully updated');
