<?php
$page = "maps";
$page_title = "Map Config";
$auth_name = 'mapconfig';
$b3_conn = true; // this page needs to connect to the B3 database
$pagination = false; // this page requires the pagination part of the footer
$query_normal = true;
require 'inc.php';

##########################
######## Varibles ########

## Default Vars ##
$orderby = "mapname";
$order = "ASC";

$is_search = false;  // may not need **

## Sorts requests vars ##
if($_GET['ob'])
	$orderby = addslashes($_GET['ob']);

if($_GET['o'])
	$order = addslashes($_GET['o']);

// allowed things to sort by
$allowed_orderby = array('id', 'mapname', 'capturelimit', 'g_suddendeath', 'g_gear', 'g_gravity', 'g_friendlyfire');
// Check if the sent varible is in the allowed array 
if(!in_array($orderby, $allowed_orderby))
	$orderby = 'mapname'; // if not just set to default

## Page Vars ##
if ($_GET['p'])
  $page_no = addslashes($_GET['p']);

$start_row = $page_no * $limit_rows;

## Search Request handling ##  // may not need **
if($_GET['s']) {
	$search_string = addslashes($_GET['s']);
	$is_search = true; // this is then a search page
}

if($_GET['t']) {
	$search_type = $_GET['t']; //  no need to escape it will be checked off whitelist
	$allowed_search_type = array('all', 'alias', 'pbid', 'ip', 'id', 'aliastable', 'ipaliastable');
	if(!in_array($search_type, $allowed_search_type))
		$search_type = 'all'; // if not just set to default all
}


###########################
######### QUERIES #########

$query = "SELECT * FROM mapconfig ";
            

if($is_search == true) : // IF SEARCH  // may not need **
	if($search_type == 'alias') { // NAME
		$query .= "AND c.name LIKE '%$search_string%' ORDER BY $orderby";
		
	} elseif($search_type == 'id') { // ID
		$query .= "AND c.id LIKE '%$search_string%' ORDER BY $orderby";
		
	} elseif($search_type == 'pbid') { // PBID
		$query .= "AND c.pbid LIKE '%$search_string%' ORDER BY $orderby";
		
	} elseif($search_type == 'ip') { // IP
		$query .= "AND c.ip LIKE '%$search_string%' ORDER BY $orderby";
		
	} elseif($search_type == 'aliastable') { // ALIAS
		$query = "SELECT client_id AS id, alias AS name, time_edit, time_add FROM aliases WHERE alias LIKE '%$search_string%' ORDER BY $orderby";

	} elseif($search_type == 'ipaliastable') { // IP-ALIAS
		$query = "SELECT client_id AS id, ip AS name, time_edit, time_add FROM ipaliases WHERE ip LIKE '%$search_string%' ORDER BY $orderby";

	}else { // ALL
		$query .= "AND c.name LIKE '%$search_string%' OR c.pbid LIKE '%$search_string%' OR c.ip LIKE '%$search_string%' OR c.id LIKE '%$search_string%'
			ORDER BY $orderby";
	}
else : // IF NOT SEARCH
	$query .= sprintf("ORDER BY %s ", $orderby);

endif; // end if search request

## Append this section to all queries since it is the same for all ##
if($order == "DESC")
	$query .= " DESC"; // set to desc 
else
	$query .= " ASC"; // default to ASC if nothing adds up

$query_limit = $query;
//$query_limit = sprintf("%s LIMIT %s, %s", $query, $start_row, $limit_rows); // add limit section

## Require Header ##	
require 'inc/header.php';

if(!$db->error) :
?>

<div class="container my-2" style="max-width:95%">
<div class="card">
<div class="card-header">
    <h5 class="my-auto">Game Maps (<?php echo $num_rows; ?>)
    <small class="my-1 float-sm-right"><?php echo $game_name; ?></small>
    </h5>
    			<?php  // may not need **
			if($search_type == "all")
				echo 'You are searching all clients that match <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
			elseif($search_type == 'alias')
				echo 'You are searching all clients names for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
            elseif($search_type == 'aliastable')
				echo 'You are searching all alias names for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
            elseif($search_type == 'ipaliastable')
				echo 'You are searching all client IP-alias names for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
			elseif($search_type == 'pbid')
				echo 'You are searching all clients Punkbuster Guids for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
			elseif($search_type == 'id')
				echo 'You are searching all clients B3 IDs for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
			elseif($search_type == 'ip')
				echo 'You are searching all clients IP addresses for <strong>'.$search_string.'</strong>. There are <strong>'. $total_rows .'</strong> entries matching your request.';
			?>
</div>
    <div class="card-body table table-hover table-sm table-responsive">
    <table width="100%">
	<thead>
		<tr>
			<th>Del</th>
			<th>Map Name
				<?php linkSortMaps('mapname', 'Map Name', $is_search, $search_type, $search_string); ?>
			</th>
			<th>Cycle</th>
			<th>Map ID
				<?php linkSortMaps('id', 'Map ID', $is_search, $search_type, $search_string); ?>
			</th>
			<th>capturelimit
				<?php linkSortMaps('capturelimit', 'capturelimit', $is_search, $search_type, $search_string); ?>
			</th>
			<th>g_suddendeath
				<?php linkSortMaps('g_suddendeath', 'g_suddendeath', $is_search, $search_type, $search_string); ?>
			</th>
			<th>g_gear
				<?php linkSortMaps('g_gear', 'g_gear', $is_search, $search_type, $search_string); ?>
			</th>
			<th>g_gravity
				<?php linkSortMaps('g_gravity', 'g_gravity', $is_search, $search_type, $search_string); ?>
			</th>
			<th>g_friendlyfire
				<?php linkSortMaps('g_friendlyfire', 'g_friendlyfire', $is_search, $search_type, $search_string); ?>
			</th>
			<th>startmessage
				<?php linkSortMaps('startmessage', 'startmessage', $is_search, $search_type, $search_string); ?>
			</th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th colspan="6">Click map name to see details.</th>
		</tr>
	</tfoot>
	<tbody>
	<?php
	if($num_rows > 0) : // query contains stuff
	    $rec = 1;
            foreach($data_set as $mapconfig): // get data from query and loop
                    $mid = $mapconfig['id'];
                    $mapname = $mapconfig['mapname'];
                    $capturelimit = $mapconfig['capturelimit'];
                    $g_suddendeath = $mapconfig['g_suddendeath'];
                    $g_gear = $mapconfig['g_gear'];
                    $g_gravity = $mapconfig['g_gravity'];
                    $g_friendlyfire = $mapconfig['g_friendlyfire'];
                    $startmessage = $mapconfig['startmessage'];

                    //$time_edit = date($tformat, $time_edit);

                    $alter = alter();

                    $mapconfig = mapconfigLink($mapname, $mid);


                    // setup heredoc (table data)			
                    $data = <<<EOD
                    <tr class="$alter">
                            <td>
                                <input type="button" id="delete" value="" onclick="doDelete($mid)" class="deletebutton" title="Delete" />
                            </td>
                            <td><strong>$mapconfig</strong></td>
                            <td><input type="button" id="add" value="Add" title="Add to mapcycle" onclick="doAdd($rec)" /></td>
                            <td>@$mid</td>
                            <td id="cl$rec">$capturelimit</td>
                            <td id="sd$rec">$g_suddendeath</td>
                            <td id="ge$rec">$g_gear</td>
                            <td id="gr$rec">$g_gravity</td>
                            <td id="ff$rec">$g_friendlyfire</td>
                            <td id="sm$rec">$startmessage</td>
                            <td id="mn$rec" style="display: none">$mapname</td>
                    </tr>
EOD;
                            //<td><em>$time_edit</em></td>

            echo $data;
            $rec++;
            endforeach;
	else :
		$no_data = true;
	
		echo '<tr class="odd"><td colspan="6">';
		if($is_search == false)
			echo 'There are no maps in the database.';
		else
			echo 'Your search for <strong>'.$search_string.'</strong> has returned no results.';
		echo '</td></tr>';
	endif; // no records
	?>
	</tbody>
    </table>
    <table width="100%">
        <thead>
            <tr style="background-color:#7a8456">  <!-- 406eb7 blue, 823a27 brown, 7a8456 yellow -->
                <th>
                    Create a mapcycle.txt
                </th>
                <th>
                    <input type="button" id="writefile" value="Write File" onclick="doWriteFile()" />
                </th>
                <th>
                    <a href="/echelonv1/files/mapcycle.txt" target="_blank" style="color: #fff">Current mapcycle</a>
                </th>
                <th>
                    Map Cycle with config settings <input type="checkbox" id="cycleWithConfig" value="false" />
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="6" id="mapcycle"></td>
            </tr>
        </tbody>
    </table>

    <form name="mapdetailsform" method="post" action="actions/b3/mapconfig-edit.php">
        <input type="hidden" name="t" value="del" />
        <input type="hidden" name="id" id="id" value="" />
        <input type="hidden" name="mapname" value="none" />
        <input type="hidden" name="capturelimit" value="0" />
        <input type="hidden" name="g_suddendeath" value="0" />
        <input type="hidden" name="g_gear" value="0" />
        <input type="hidden" name="g_gravity" value="800" />
        <input type="hidden" name="g_friendlyfire" value="0" />
        <input type="hidden" name="startmessage" value="" />
    </form>
    <form name="mapcycleform" method="post" action="actions/mapcycle.php">
        <input type="hidden" name="data" value="" />
    </form>
</div></div></div>

<script language="JavaScript">
    
function doAdd(rec){
    var text = $("#mapcycle").html();
    if($("#cycleWithConfig").is(':checked')) {
	    text += $("#mn" + rec).text().trim()
	        + '<br />{'
	        + '<br />&nbsp;&nbsp;&nbsp;&nbsp;capturelimit "' + $("#cl" + rec).text().trim()
	        + '"<br />&nbsp;&nbsp;&nbsp;&nbsp;g_suddendeath "' + $("#sd" + rec).text().trim()
	        + '"<br />&nbsp;&nbsp;&nbsp;&nbsp;g_gear "' + $("#ge" + rec).text().trim()
	        + '"<br />&nbsp;&nbsp;&nbsp;&nbsp;g_gravity "' + $("#gr" + rec).text().trim()
	        + '"<br />&nbsp;&nbsp;&nbsp;&nbsp;g_friendlyfire "' + $("#ff" + rec).text().trim()
	        + '"<br />}<br />';
	}
	else {
	    text += $("#mn" + rec).text().trim() + '<br />';
	}
    $("#mapcycle").html(text);
}

function doDelete(id){
    $("#id").val(id);
    document.forms["mapdetailsform"].submit();
}

function doWriteFile(){
    var text = $("#mapcycle").html();
    if (text !== ""){
        document.forms["mapcycleform"].data.value = text;
        document.forms["mapcycleform"].submit();
    }
}

</script>
<?php
	else:
		
	endif; // db error

	require 'inc/footer.php'; 
?>