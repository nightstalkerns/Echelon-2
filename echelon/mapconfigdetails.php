<?php
$page = "mapconfigdetails";
$page_title = "Map Config Details";
$auth_name = 'mapconfig';
$b3_conn = true; // this page needs to connect to the B3 database
$pagination = false; // this page requires the pagination part of the footer
require 'inc.php';

## Do Stuff ##
if($_GET['id'])
	$mid = $_GET['id'];

if(!isID($mid)) :
	set_error('The mapconfig id that you have supplied is invalid. Please supply a valid mapconfig id.');
	send('mapconfig.php');
	exit;
endif;
	
if($mid == '') {
	set_error('No map specified, please select one');
	send('mapconfig.php');
}

## Get Client information ##
$query = "SELECT m.id, m.mapname, m.capturelimit, m.g_suddendeath, m.g_gear, m.g_gravity, m.g_friendlyfire, m.startmessage, m.skiprandom FROM mapconfig m WHERE m.id = ? LIMIT 1";
$stmt = $db->mysql->prepare($query) or die('Database Error '. $db->mysql->error);
$stmt->bind_param('i', $mid);
$stmt->execute();
$stmt->bind_result($id, $mapname, $capturelimit, $g_suddendeath, $g_gear, $g_gravity, $g_friendlyfire, $startmessage, $skiprandom);
$stmt->fetch();
$stmt->close();

## Require Header ##
$page_title .= ' '.$mapname; // add the map name to the end of the title

require 'inc/header.php';
?>

<script type="text/javascript">
    
function doAdd(){
    $("#t").val("add");
    $("#id").val("0");
    document.forms["mapconfig-edit"].submit();
}

function doUpdate(){
    $("#t").val("edit");
    document.forms["mapconfig-edit"].submit();
}

function goBack() {
    window.history.back()
}

</script>

<div class="container">
<div class="card my-2">
    
    <form action="actions/b3/mapconfig-edit.php" method="post" id="mapconfig-edit">
	<input type="hidden" name="t" id="t" value="edit" />
        
        <div class="card-header">
            <h5 class="my-auto">Map Config Information</h5>
        </div>
        <div class="card-body table table-hover table-sm table-responsive">
            <table width="100%">
                <tbody>
                    <tr>
                        <th>Name</th>
                            <td>
                                <input type="text" name="mapname" value="<?php echo tableClean($mapname); ?>" maxlength="50" />
                            </td>
                        <th>@ID</th>
                            <td><?php echo $mid; ?><input type="hidden" name="id" id="id" value="<?php echo $mid ?>" /></td>
                    </tr>
                    <tr>
                        <th>capturelimit</th>
                        <td>
                            <input type="number" name="capturelimit" value="<?php echo $capturelimit; ?>" maxlength="2" />
                        </td>
                    </tr>
                    <tr>
                        <th>g_suddendeath</th>
                        <td>
                            <input type="number" name="g_suddendeath" value="<?php echo $g_suddendeath; ?>" maxlength="1" />
                        </td>
                    </tr>
                    <tr>
                        <th>g_gear</th>
                        <td>
                            <input type="text" name="g_gear" value="<?php echo tableClean($g_gear); ?>" maxlength="100" /> &nbsp; &nbsp; 
                            <a href="https://www.urbanterror.info/support/180-server-cvars/#2" target="_blank">Gear Calculator</a>
                        </td>
                    </tr>
                    <tr>
                        <th>g_gravity</th>
                        <td>
                            <input type="number" name="g_gravity" value="<?php echo $g_gravity; ?>" maxlength="4" />
                        </td>
                    </tr>
                    <tr>
                        <th>g_friendlyfire</th>
                        <td>
                            <input type="number" name="g_friendlyfire" value="<?php echo $g_friendlyfire; ?>" maxlength="1" />
                        </td>
                    </tr>
                    <tr>
                        <th>startmessage</th>
                        <td>
                            <input type="text" name="startmessage" value="<?php echo $startmessage; ?>" maxlength="75" />
                        </td>
                    </tr>
                    <tr>
                        <th>skiprandom</th>
                        <td>
                            <input type="text" name="skiprandom" value="<?php echo $skiprandom; ?>" maxlength="1" />
                        </td>
                    </tr>


                    <!--
                    <tr>
                        <th>Last Seen</th>
                        <td>< ?php echo date($tformat, $time_edit); ?></td>
                    </tr>
                    -->
                </tbody>
            </table>
        </div>
    	
        <!--
        <div class="card card-signin my-2">
            <div class="card-body">
                <h5 class="card-title">Verify Identity</h5>
                <div class="col justify-center">			
                    <div class="form-group row">
                        <label for="password" class="col-sm-4 col-form-label">Current Password</label>
                        <div class="col-sm-8"><input class="form-control" type="password" name="password" id="password" value=""/></div>
                    </div>
                </div>
            </div>
        </div>
        -->
        
        <table style="width:90%; margin:5px">
            <tr>
                <td style="text-align:left">NOTE: Adding a new map reloads on the original map.</td>
                <td style="text-align:right">
                    <button class="btn btn-primary my-2" type="button" onclick="goBack()">Go Back</button>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    <button id="mapconfig-edit-update" class="btn btn-primary my-2" value="Update" type="button" onclick="doUpdate()">Update</button>
                    &nbsp; &nbsp; &nbsp; &nbsp;
                    <button id="mapconfig-edit-add" class="btn btn-primary my-2" value="Add" type="button" onclick="doAdd()">Add New Map</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<?php
// Close page off with the footer
require 'inc/footer.php'; 
?>
