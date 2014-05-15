<?php

//Description: All admin functionalites are here
if(!eregi("admin.php",$_SERVER["PHP_SELF"])){
die("You can't acces this page directly");
}
$index=4;
global $link;
require_once("mainfile.php");
$page_title="Admin Control Panel";
global $op;

if(!is_admin()){
	include("header.php");
	echo"<table align=center><tr>";
	echo"<td align=center>Please login to <a href=\"admin.php?m=admin&file=login\">admin</a></td>";
	echo"</tr></table>";
	include("footer.php");
	exit;
}

function adminmenu(){
	$tpl=new Template();
	$tpl->setTemplateDir("admin");
	$tpl->display("adminMenu.tpl");
}


function package(){
	session_start();
	global $db,$prefix,$site_path;
	include("header.php");
	$tpl=new Template();
	adminmenu();
	$result=$db->query("SELECT * FROM ".$prefix."_continent");
	while($row=$db->fetch_array($result)){
		$continent_opt["$row[continent_id]"]=$row[continent_name];
	}


	$tpl->setTemplateDir("admin");
	SmartyValidate::connect($tpl, empty($_POST));
	SmartyValidate::register_form("frm_addpackage");

	$tpl->assign("continent_opt",$continent_opt);

	$opt_radio=array("0"=>"No","1"=>"Yes");
	$tpl->assign("opt_radio",$opt_radio);


	if(empty($_POST)) {
	   $tpl->display('package.tpl');
	} else {
	   // validate after a POST
	   if(SmartyValidate::is_valid($_POST)) {
		   // no errors, done with SmartyValidate
		   SmartyValidate::disconnect();

		$name=addslashes($_POST["name"]);
		$desc=addslashes($_POST["description"]);
		$price=addslashes($_POST["price"]);
		$active=$_POST["active"];
		$continent=intval($_POST["continent"]);

		//Package file
		$ftype=$_FILES["packagefile"]["type"];
		$fsize=$_FILES["packagefile"]["size"];
		$fname=$_FILES["packagefile"]["name"];
		$ftemp=$_FILES["packagefile"]['tmp_name'];
		if(!empty($fsize)){
			$handle = fopen($ftemp, "r");
			$packagefile = fread($handle, filesize($ftemp));
			fclose($handle);
		}
		$packagefile=addslashes($packagefile);


		$imtype=$_FILES["filename"]["type"];
		$imsize=$_FILES["filename"]["size"];
		$imname=$_FILES["filename"]["name"];
		$imtemp=$_FILES['filename']['tmp_name'];
		$imsize=ceil($imsize / 1024);
		$immaxsize=ceil($immaxsize/ 1024);
		$destination="$site_path/images/packages/";
		if(!empty($imsize)){
			if(!is_uploaded_file($_FILES["filename"]["tmp_name"])){
			echo"<center>Sorry,photo couldn't be uploaded.</center>";
			include("footer.php");
			exit;
		}
			$imsize=ceil($imsize / 1024);
			$immaxsize=ceil($immaxsize/ 1024);
			$extension="";

			if($imtype == "image/jpeg"){
				$extension=".jpg";
			}elseif ($imtype == "image/pjpeg"){
				$extension=".jpg";
			}elseif ($imtype == "image/gif"){
				$extension=".gif";
			}else{
				echo"<center>Image type is invalid.</center>";
				include("footer.php");
				exit;
			}


		}
		$expire=intval(tounixdate($_POST["expire"]));

		$result=$db->query("INSERT INTO  travel_package(package_name,package_cost,package_desc,package_active,package_expire,package_continent,package_file,package_file_name,package_file_type,package_file_size,package_photo)values('$name','$price','$desc','$active','$expire','$continent','$packagefile','$fname','$ftype','$fsize','$pix')");
		if(!empty($imsize)){
			if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
				$last_id=mysql_insert_id();
				$pix=$last_id.$extension;
				$dest= $destination.$pix;
				move_uploaded_file($imtemp,$dest);
				//create_thumb("$pix","$destination",200,null);
			}
		}
		if($result){
			echo"<center>Packages added successfully.</center>";
			/*
			if(!empty($imsize)){
				$db->query("UPDATE travel_package SET package_photo='$pix' WHERE package_id=$last_id") or die("Error photo");
			}

			if(!empty($fsize)){
				$db->query("UPDATE travel_package SET package_file='$contents' WHERE package_id=$last_id");
			}
			*/
			goto("admin.php?op=viewpackage");
		}else{
			echo"<center>Sorry, packages couldn't be addedd. <a href=javascript:back()>Try again</a></center>";
		}

	   } else {
		   // error, redraw the form
		   $tpl->assign($_POST);
		   $tpl->display('package.tpl');
	   }
}
	include("footer.php");


}


function viewpackage(){
	global $db;
	include("header.php");
	adminmenu();
	$result=$db->query("SELECT *  FROM travel_package");
	$num_record=$db->row_count($result);
	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;

	$currentpage=$page;

	$perpage =10;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);

	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
	   $end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
	   $end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link = makepagelink("admin.php?op=viewpackage", $page, $pages);
	else
	$page_link = "";
	$result2=$db->query("SELECT * FROM travel_package ORDER BY package_id DESC limit $start,$perpage");
	echo"<table bgcolor=#FFCC66 width=100%>";
	echo"<tr><td>Displaying: $starting_no-$end_count of $num_record record(s) » Page $currentpage</td><td> $page_link</td></tr>";
	echo"</table>";

	echo"<table>";
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend>View packages</legend>";
	echo"<table  width=100% cellpadding=\"2\" cellspacing=\"0\" nowrap>";
	echo"<tr class=orangebackground ><td>Package name</td><td>Package price</td><td>Acitve</td><td>Expire on </td><td>Action</td></tr>";
	while($row=$db->fetch_array($result2)){
		if($row["package_active"]==1){
		$active="Yes";
		}else{
		$active="No";
		}
		echo"<tr><td>$row[package_name]</td><td>$$row[package_cost]</td><td>$active</td><td>".date("d/m/Y",$row[package_expire])."</td><td><a href=\"admin.php?op=editpackage&id=$row[package_id]\">Edit/Delete</a></td></tr>";
	}
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr>";
	echo"</table>";
	include("footer.php");

}

//Edit Package
function editpackage(){

	session_start();
	global $db,$prefix,$site_path;
	include("header.php");
	adminmenu();
	$tpl=new Template();
	$tpl->setTemplateDir("admin");

	$result=$db->query("SELECT * FROM ".$prefix."_continent");
	while($row=$db->fetch_array($result)){
		$continent_opt["$row[continent_id]"]=$row[continent_name];
	}

	$opt_radio=array(1=>"Yes",0=>"No");
	$tpl->assign("opt_radio",$opt_radio);

	$id=intval($_REQUEST["id"]);
	$tpl->assign("id",$id);
	$file=getrow("package_photo","".$prefix."_package","package_id","$id");
	if(isset($_POST["del"])){
		$result=$db->query("DELETE FROM  ".$prefix."_package WHERE package_id=$id");
		@unlink("$site_path/images/packages/$file");
		if($result){
			echo"<center>Package removed successfully.</center>";
		}else{
			echo"<center>Package could not be removed .</center>";
		}
		goto("admin.php?op=viewpackage");

		include("footer.php");
		exit;
	}


	$result=$db->query("SELECT * FROM ".$prefix."_package WHERE package_id=$id");
	$package=$db->fetch_array($result);

	SmartyValidate::connect($tpl, empty($_POST));
	SmartyValidate::register_form("frm_editpackage");
	$tpl->assign("package",$package);

	$tpl->assign("continent_opt",$continent_opt);
	$package[package_name]=stripslashes($package[package_name]);
	$tpl->assign("name",$package[package_name]);
	$package[package_desc]=stripslashes($package[package_desc]);
	$tpl->assign("description",$package[package_desc]);
	$tpl->assign("continent",$package[package_continent]);
	$tpl->assign("price",$package[package_cost]);
	$package[package_expire]=todate($package[package_expire]);
	$tpl->assign("expire",$package[package_expire]);

	$tpl->assign("active",$package[package_active]);

	if(empty($_POST)) {
	   $tpl->display("editpackage.tpl");
	} else {
	   // validate after a POST
	   if(SmartyValidate::is_valid($_POST)) {
		   // no errors, done with SmartyValidate
		   SmartyValidate::disconnect();

		$name=addslashes($_POST["name"]);
		$desc=addslashes($_POST["description"]);
		$price=addslashes($_POST["price"]);
		$active=$_POST["active"];
		$continent=intval($_POST["continent"]);

		//Package file
		$ftype=$_FILES["packagefile"]["type"];
		$fsize=$_FILES["packagefile"]["size"];
		$fname=$_FILES["packagefile"]["name"];
		$ftemp=$_FILES["packagefile"]["tmp_name"];
		if(!empty($fsize)){
			$handle = fopen($ftemp, "r");
			$packagefile = fread($handle, filesize($ftemp));
			fclose($handle);
		}
		$packagefile=addslashes($packagefile);


		$imtype=$_FILES["filename"]["type"];
		$imsize=$_FILES["filename"]["size"];
		$imname=$_FILES["filename"]["name"];
		$imtemp=$_FILES['filename']['tmp_name'];
		$imsize=ceil($imsize / 1024);
		$immaxsize=ceil($immaxsize/ 1024);
		$destination="$site_path/images/packages/";


		if(!empty($imsize)){
			if(!is_uploaded_file($_FILES["filename"]["tmp_name"])){
				echo"<center>Sorry,photo couldn't be uploaded.</center>";
				include("footer.php");
				exit;
			}
			$imsize=ceil($imsize / 1024);
			$immaxsize=ceil($immaxsize/ 1024);
			$extension="";

			if($imtype == "image/jpeg"){
				$extension=".jpg";
			}elseif ($imtype == "image/pjpeg"){
				$extension=".jpg";
			}elseif ($imtype == "image/gif"){
				$extension=".gif";
			}else{
				echo"<center>Image type is invalid.</center>";
				include("footer.php");
				exit;
			}

			if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
				$pix=$id.$extension;
				$dest= $destination.$pix;
				move_uploaded_file($imtemp,$dest);
				//create_thumb("$pix","$destination",200,null);
			}

			$cond="package_photo='$pix',";
		}

		if(!empty($packagefile)){

			$condx="package_file='$packagefile',
			package_file_name='$fname',
			package_file_size='$fsize',
			package_file_type='$ftype',";

		}

		$expire=intval(tounixdate($_POST["expire"]));
		$result=$db->query("UPDATE travel_package SET
		package_name='$name',
		package_cost='$price',
		package_desc='$desc',
		$cond
		package_active='$active',
		package_continent='$continent',
		$condx
		package_expire=$expire
		WHERE package_id=$id");


		if($result){
			echo"<center>Packages updated successfully.</center>";
			goto("admin.php?op=viewpackage");
		}else{
			echo"<center>Sorry, packages couldn't be updated. <a href=javascript:back()>Try again</a></center>";
		}

	   } else {
		   // error, redraw the form
		   $tpl->assign($_POST);
		   $tpl->display('editpackage.tpl');
	   }
	}

	include("footer.php");

}

function modifypackage(){
	global $db,$site_path;
	include("header.php");
	adminmenu();

	$id=$_POST["id"];
	$name=addslashes($_POST["name"]);
	$desc=addslashes($_POST["description"]);
	$price=$_POST["price"];
	$active=$_POST["active"];
	$continent=$_POST["continent"];
	$file=getrow("package_photo","travel_package","package_id","$id");
	if(isset($_POST["remove"])){
		echo"<table>";
		$result=$db->query("DELETE FROM  travel_package WHERE package_id=$id");
		@unlink("$site_path/images/packages/$file");
		if($result){
			echo"<center>Package removed successfully.</center.";
		}else{
			echo"<center>Package could not be removed .</center.";
		}
		goto("admin.php?op=viewpackage");
		echo"</table>";
		include("footer.php");
		exit;
	}

	if(empty($name) || empty($desc) || empty($price) || empty($continent)){
		echo"<table>";
		echo"<center>Sorry, form was incomplete.<a href=javascript:back()>Try again </a></center.";
		echo"</table>";
		include("footer.php");
		exit;
	}
	$imtype=$_FILES["filename"]["type"];
	$imsize=$_FILES["filename"]["size"];
	$imname=$_FILES["filename"]["name"];
	$imtemp=$_FILES['filename']['tmp_name'];
	$imsize=ceil($imsize / 1024);
	$immaxsize=ceil($immaxsize/ 1024);
	$destination="$site_path/images/packages/";


	if(!empty($imsize)){
		if(!is_uploaded_file($_FILES["filename"]["tmp_name"])){
			echo"<center>Sorry,photo couldn't be uploaded.</center>";
			include("footer.php");
			exit;
		}
		$imsize=ceil($imsize / 1024);
		$immaxsize=ceil($immaxsize/ 1024);
		$extension="";

		if($imtype == "image/jpeg"){
			$extension=".jpg";
		}elseif ($imtype == "image/pjpeg"){
			$extension=".jpg";
		}elseif ($imtype == "image/gif"){
			$extension=".gif";
		}else{
			echo"<center>Image type is invalid.</center>";
			include("footer.php");
			exit;
		}

		if(is_uploaded_file($_FILES["filename"]["tmp_name"])){
			$pix=$id.$extension;
			$dest= $destination.$pix;
			move_uploaded_file($imtemp,$dest);
			create_thumb("$pix","$destination",200,null);
		}

		$cond="package_photo='$pix',";
	}

	$expire=intval(tounixdate($_POST["expire"]));
	$result=$db->query("UPDATE travel_package SET
	package_name='$name',
	package_cost='$price',
	package_desc='$desc',
	$cond
	package_active='$active',
	package_continent='$continent',
	package_expire=$expire
	WHERE package_id=$id");
	echo"<table>";

	if($result){
		echo"<center>Packages updated successfully.</center>";

		goto("admin.php?op=viewpackage");
	}else{
		echo"<center>Sorry, packages couldn't be updated. <a href=javascript:back()>Try again</a></center>";
	}
	echo"</table>";

	include("footer.php");

}



function index(){
	session_start();
	include("header.php");
	adminmenu();
	$tpl=new Template();
	$tpl->setTemplateDir("admin");
	$tpl->display("admin_index.tpl");
	include("footer.php");

}
//Add fare
function fare(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$tpl=new Template();
	$tpl->setTemplateDir("admin");
	SmartyValidate::connect($tpl, empty($_POST));
	SmartyValidate::register_form("frm_addfare");

	//Pass Special
	$special_opt=array(1=>"Yes",0=>"No");
	$active_opt=array(1=>"Yes",0=>"No");
	$tpl->assign("active",1);
	$tpl->assign("special_opt",$special_opt);
	$tpl->assign("active_opt",$active_opt);

	//Pass airlines
	$qairline=$db->query("SELECT *  FROM ".$prefix."_airline");
	while($row=$db->fetch_array($qairline)){
		$airline_opt["$row[airline_id]"]=$row["airline_name"];
	}
	$tpl->assign("airline_opt",$airline_opt);

	//Pass Origin
	$qorigin=$db->query("SELECT *  FROM ".$prefix."_origin");
		while($row=$db->fetch_array($qorigin)){
			$origin_opt["$row[origin_id]"]=$row["origin_name"];
		}
	$tpl->assign("origin_opt",$origin_opt);
	//Pass destination
	$qdestination=$db->query("SELECT *  FROM ".$prefix."_destination");
	while($row=$db->fetch_array($qdestination)){
			$destination_opt["$row[destination_id]"]=$row["destination_name"];
	}
	$tpl->assign("destination_opt",$destination_opt);

	//Pass Fare
	$qtype=$db->query("SELECT * FROM ".$prefix."_faretype");
	while($row=$db->fetch_array($qtype)){
				$type_opt["$row[type_id]"]=$row["type_name"];
	}
	$tpl->assign("type_opt",$type_opt);

	//Pass  restriction type
	$qrestriction=$db->query("SELECT * FROM ".$prefix."_restfaretype");
	while($row=$db->fetch_array($qrestriction)){
				$restriction_opt["$row[restr_faretypeid]"]=$row["restr_faretype"];
	}
	$tpl->assign("restriction_opt",$restriction_opt);

	//Pass class
	$qclass=$db->query("SELECT * FROM ".$prefix."_class");
	while($row=$db->fetch_array($qclass)){
			$class_opt["$row[class_id]"]="$row[class_name]";
	}

	$tpl->assign("class_opt",$class_opt);

	if(empty($_POST)) {
		$tpl->display('addfare.tpl');
	} else {
		// validate after a POST
		if(SmartyValidate::is_valid($_POST)) {
	  	 // no errors, done with SmartyValidate
	   	SmartyValidate::disconnect();
		$airline=postvarint("airline");
		$adultfare=addslashes($_POST["adultfare"]);
		$date1=tounixdate(postvar("date1"));
		$date2=tounixdate(postvar("date2"));
		$mindate=postvar("mindate");
		$maxdate=postvar("maxdate");
		$restriction=postvar("restriction");
		$purchaseby=tounixdate(postvar("purchaseby"));
		$origin=$_POST["origin"];
		$destination=postvarint("destination");
		$faretype=intval($_POST["faretype"]);
		$class=postvar("travelclass");
		$special=postvarint("special");
		$active=postvarint("active");
		$time=time();
		$child=$_POST["child"];
		$infant=$_POST["infant"];
		$note=addslashes($_POST["note"]);
		$title=addslashes($_POST["title"]);


		$query="INSERT INTO ".$prefix."_fares(fare_airline,fare_title,fare_type,fare_special,fare_class,fare_adultfare,fare_dept_start,fare_dept_end, fare_stay_min, fare_stay_max,fare_restriction, fare_purchaseby,fare_destination,fare_addedon,fare_active,fare_child,fare_infant,fare_note)
		 values('$airline','$title','$faretype','$special','$class','$adultfare','$date1','$date2','$mindate','$maxdate',
		'$restriction','$purchaseby','$destination','$time','$active','$child','$infant','$note')";
		$result=$db->query($query);
		if($result){
		$last_id=mysql_insert_id();
		foreach($origin as $value){
			$db->query("INSERT INTO ".$prefix."_fares_origin(fares_origin,fares_fare) values('$value','$last_id')");
		}
			echo"<center>Added successfully. <a href=admin.php>Go to admin sectoin.</a></center>";
			goto("admin.php?op=viewfare");
		}else{
			echo"Sorry, new fair couldn't added successfully.";
		}



	} else {
			   // error, redraw the form
			   $tpl->assign($_POST);
			   $tpl->display('addfare.tpl');
		   }
	}

	include("footer.php");
}

// Edit fare by id number
function editfare(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$id=intval($_REQUEST["id"]);
	$tpl=new Template();
	$tpl->setTemplateDir("admin");
	if(isset($_POST["del"])){
		$db->query("DELETE FROM  ".$prefix."_fares WHERE fare_id=$id");
		goto("admin.php?op=viewfare");
		include("footer.php");
		exit;
	}

	SmartyValidate::connect($tpl, empty($_POST));
	SmartyValidate::register_form("frm_editfare");
	$tpl->assign("id",$id);

	//Pass Special
	$special_opt=array(1=>"Yes",0=>"No");
	$active_opt=array(1=>"Yes",0=>"No");
	$tpl->assign("special_opt",$special_opt);
	$tpl->assign("active_opt",$active_opt);

	//Pass airlines
	$qairline=$db->query("SELECT *  FROM ".$prefix."_airline");
	while($row=$db->fetch_array($qairline)){
		$airline_opt["$row[airline_id]"]=$row["airline_name"];
	}
	$tpl->assign("airline_opt",$airline_opt);

	//Pass Origin
	$qorigin=$db->query("SELECT *  FROM ".$prefix."_origin");
		while($row=$db->fetch_array($qorigin)){
			$origin_opt["$row[origin_id]"]=$row["origin_name"];
		}
	$tpl->assign("origin_opt",$origin_opt);
	//Pass destination
	$qdestination=$db->query("SELECT *  FROM ".$prefix."_destination");
	while($row=$db->fetch_array($qdestination)){
			$destination_opt["$row[destination_id]"]=$row["destination_name"];
	}
	$tpl->assign("destination_opt",$destination_opt);

	//Pass Fare
	$qtype=$db->query("SELECT * FROM ".$prefix."_faretype");
	while($row=$db->fetch_array($qtype)){
				$type_opt["$row[type_id]"]=$row["type_name"];
	}
	$tpl->assign("type_opt",$type_opt);

	//Pass  restriction type
	$qrestriction=$db->query("SELECT * FROM ".$prefix."_restfaretype");
	while($row=$db->fetch_array($qrestriction)){
				$restriction_opt["$row[restr_faretypeid]"]=$row["restr_faretype"];
	}
	$tpl->assign("restriction_opt",$restriction_opt);

	//Pass class
	$qclass=$db->query("SELECT * FROM ".$prefix."_class");
	while($row=$db->fetch_array($qclass)){
			$class_opt["$row[class_id]"]="$row[class_name]";
	}

	$tpl->assign("class_opt",$class_opt);

	//assign variable
	$qfare=$db->query("SELECT * FROM ".$prefix."_fares WHERE fare_id='$id'");
	$fare=$db->fetch_array($qfare);

	$qfareorigin=$db->query("SELECT * FROM ".$prefix."_fares_origin WHERE fares_fare=$fare[fare_id]");
	while($row=$db->fetch_array($qfareorigin)){
		$originopt[]=$row[fares_origin];
	}
	$date1=todate($fare[fare_dept_start]);
	$date2=todate($fare[fare_dept_end]);
	$purchaseby=todate($fare[fare_purchaseby]);
	$tpl->assign("airline",$fare[fare_airline]);
	$tpl->assign("adultfare",$fare[fare_adultfare]);
	$tpl->assign("date1",$date1);
	$tpl->assign("date2",$date2);
	$tpl->assign("mindate",$fare[fare_stay_min]);
	$tpl->assign("maxdate",$fare[fare_stay_max]);
	$tpl->assign("restriction",$fare[fare_restriction]);
	$tpl->assign("purchaseby",$purchaseby);
	$tpl->assign("origin",$originopt);
	$tpl->assign("destination",$fare[fare_destination]);
	$tpl->assign("faretype",$fare[fare_type]);
	$tpl->assign("travelclass",$fare[fare_class]);
	$tpl->assign("child",$fare[fare_child]);
	$tpl->assign("infant",$fare[fare_infant]);
	$tpl->assign("adultfare",$fare[fare_adultfare]);
	$tpl->assign("active",$fare[fare_active]);
	$tpl->assign("title",$fare[fare_title]);
	$tpl->assign("note",$fare[fare_note]);
	$tpl->assign("title",$fare[fare_title]);
	$tpl->assign("special",$fare[fare_special]);

	if(empty($_POST)) {
		$tpl->display('editfare.tpl');
	} else {
		// validate after a POST
		if(SmartyValidate::is_valid($_POST)) {
		 // no errors, done with SmartyValidate
		SmartyValidate::disconnect();
		$airline=postvarint("airline");
		$adultfare=addslashes($_POST["adultfare"]);
		$date1=tounixdate(postvar("date1"));
		$date2=tounixdate(postvar("date2"));
		$mindate=postvar("mindate");
		$maxdate=postvar("maxdate");
		$restriction=postvar("restriction");
		$purchaseby=tounixdate(postvar("purchaseby"));
		$origin=$_POST["origin"];
		$destination=postvarint("destination");
		$faretype=intval($_POST["faretype"]);
		$class=postvar("travelclass");
		$special=$_POST["special"];
		$active=postvarint("active");
		$time=time();
		$child=$_POST["child"];
		$infant=$_POST["infant"];
		$note=addslashes($_POST["note"]);
		$title=addslashes($_POST["title"]);

		$result=$db->query("UPDATE ".$prefix."_fares

		SET fare_airline='$airline',
		fare_title='$title',
		fare_type=$faretype,
		fare_special='$special',
		fare_class='$class',
		fare_adultfare='$adultfare',
		fare_dept_start='$date1',
		fare_dept_end='$date2',
		fare_stay_min='$mindate',
		fare_stay_max='$maxdate',
		fare_restriction='$restriction',
		fare_purchaseby='$purchaseby',
		fare_destination='$destination',
		fare_addedon='$time',
		fare_active='$active',
		fare_child='$child',
		fare_infant='$infant',
		fare_note ='$note'
		WHERE fare_id=$id");
		if($result){
		@$db->query("DELETE FROM ".$prefix."_fares_origin  WHERE fares_fare=$id");
		foreach($origin as $value){
			$db->query("INSERT INTO ".$prefix."_fares_origin(fares_origin,fares_fare) values('$value','$id')");
		}
			echo"<center>Updated successfully. <a href=admin.php>Go to admin sectoin.</a></center>";
			goto("admin.php?op=viewfare");
		}else{
			echo"Sorry, new fair couldn't be updated successfully.";
		}



	} else {
			   // error, redraw the form
			   $tpl->assign($_POST);
			   $tpl->display('editfare.tpl');
		   }
	}

include("footer.php");

}

// viewfare
function viewfare(){
	global $db,$prefix,$site_path;
	include("header.php");
	adminmenu();
	$q=addslashes($_REQUEST["q"]);
	if(!empty($q)){
		$cond=" WHERE fare_id LIKE '$q' OR destination_name LIKE'%$q%'";
	}else{
		$cond="";
	}
	$resultc=$db->query("SELECT * FROM  ".$prefix."_fares LEFT JOIN ".$prefix."_airline ON fare_airline=airline_id LEFT JOIN ".$prefix."_destination ON fare_destination=destination_id $cond");
	$num_record=$db->row_count($resultc);

	if(isset($_GET['page']))
	$page=intval($_GET['page']);
	else $page=1;

	$currentpage=$page;

	$perpage =10;
	$start=($page-1) * $perpage;
	$pages=ceil($num_record/$perpage);

	$starting_no = $start + 1;

	if ($num_record - $start<$perpage) {
	   $end_count = $num_record;
	} elseif ($num_record - $start >= $perpage) {
	   $end_count = $start + $perpage;
	}

	if($pages>1)
	$page_link = makepagelink("admin.php?op=viewfare", $page, $pages);
	else
	$page_link = "";
	echo"<fieldset>";
	echo"<legend>Fare  search</legend>";
	echo"<form action=\"admin.php?op=viewfare\" method=\"post\">";
	echo"<table bgcolor=#FFCC66 width=100% align=center>";
	echo"<tr><td></td><td align=\"right\" valign=\"top\">Search fare</td><td><input type=\"text\" name=\"q\" size=\"30\" value=\"$q\"><input type=\"submit\" value=\"search\"><br><small>Search by fare ID(ie.41) or Destination(ie.Dubai)</small></td></tr>";
	echo"</table>";
	if($num_record<1){
		echo"<center>Sorry, no fare found.</center>";
	}
	echo"</form>";
	echo"</fieldset>";
	echo"<hr>";
	$result=$db->query("SELECT * FROM  ".$prefix."_fares LEFT JOIN ".$prefix."_airline ON fare_airline=airline_id LEFT JOIN ".$prefix."_destination ON fare_destination=destination_id $cond ORDER BY fare_id DESC limit $start,$perpage ");
	echo"<table bgcolor=#FFCC66 width=100%>";
	echo"<tr><td>Displaying: $starting_no-$end_count of $num_record record(s) » Page $currentpage</td><td> $page_link</td></tr>";
	echo"</table>";
	echo"<table bgcolor=#FFCC66>";
	echo"<table width=100% bgcolor=\"#FFCC66\">";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend> Fares</legend>";
	echo"<table  width=100% boder=1 cellpadding=1 cellspacing=0>";
	echo"<tr class=orangebackground><td width=\"95\" colspan=\"2\" rowspan=\"2\">Airline</td>
		<td rowspan=\"2\">Adult Airfare</td>
		<td  colspan=\"2\" rowspan=\"2\">Departing<br>
		Between </td>
		<td  colspan=\"2\">
		Staying rule</td>
		<td  rowspan=\"2\">Destination</td>
		<td rowspan=\"2\">Purchase<br>
		By </td>
		<td rowspan=\"2\">Edit</td>

	</tr>
	<tr class=orangebackground>
		<td width=\"69\">Min</td>
		<td width=\"90\">Max</td>
		</tr>";

	while($row=$db->fetch_array($result)){
		if($row[fare_special]==1){
		$sp=" bgcolor=#FFFFCC";
		}else{
			$sp="";
		}
		//echo"<tr valign=center><td><img src=\"images/airlines/$row[airline_logo]\"></td><td>$row[airline_nick]</td><td></td><td>$$row[fare_adultfare]</td><td>".date("d M Y",$row[fare_dept_start])."</td><td>".date("d M Y",$row[fare_dept_end])."</td><td>$row[fare_purchaseby]</td><td>$row[fare_stay_min]</td><td>$row[fare_stay_max]</td><td>$row[fare_restriction]</td><td><a href=\"admin.php?op=editfare&id=$row[fare_id]\">Edit</a></td></tr>";
 		echo"<tr $sp>
		<td >";
		$logo=trim($row[airline_logo]);
		if(file_exists("$site_path/images/airlines/$logo")){
			echo"<img src=\"images/airlines/$logo\">";
		}
		echo"</td>
		<td >$row[airline_nick]</td>
		<td >$$row[fare_adultfare]</td>
		<td>".date("d M Y",$row[fare_dept_start])."</td>
		<td >".date("d M Y",$row[fare_dept_end])."</td>
		<td>$row[fare_stay_min]</td>
		<td >$row[fare_stay_max]</td>
		<td >".getrow("destination_name","".$prefix."_destination","destination_id",$row[fare_destination])."</td>
		<td >".date("d M Y",$row[fare_purchaseby])."</td>
		<td><a href=\"admin.php?op=editfare&id=$row[fare_id]\">View/Edit</a></td>
		</tr>";

	}
	echo"<font color=red>* Highlighteds are special</font>";
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr>";
	echo"</table>";
	include("footer.php");
}

function updatefare(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$id=intval($_POST["id"]);
	if(isset($_POST["del"])){
		$db->query("DELETE FROM ".$prefix."_fares WHERE fare_id=$id");
		$db->query("DELETE FROM ".$prefix."_fares_origin WHERE fares_fare=$id");
		echo"<center>Deleted successfully. <a href=admin.php>Go to admin section</a>.</center>";
		goto("admin.php?op=viewfare");
		include("footer.php");
		exit;
	}


	if(empty($_POST[adultfare]) || empty($_POST[date1])
	|| empty($_POST[date2]) || empty($_POST[purchaseby])
	|| empty($_POST[faretype]) || empty($_POST["title"])
	||  empty($_POST["travelclass"]) || empty($_POST[airline])
	|| empty($_POST[origin]) || empty($_POST[destination])
	){
		echo"<table bgcolor=#FFCC66>";
		echo"<tr><td align=center>Sorry, form was not filled properly. <a href=\"javascript:history.back()\">Go back check it.</a></td></tr>";
		echo"</table>";
		include("footer.php");
		exit;
	}

	$airline=postvarint("airline");
	$adultfare=postvar("adultfare");
	$date1=tounixdate(postvar("date1"));
	$date2=tounixdate(postvar("date2"));
	$mindate=postvar("mindate");
	$maxdate=postvar("maxdate");
	$restriction=postvar("restriction");
	$purchaseby=tounixdate(postvar("purchaseby"));
	$origin=postvarint("origin");
	$destination=postvarint("destination");
	$id=postvar("id");
	$active=postvarint("active");
	$special=postvarint("special");
	$type=postvar("faretype");
	$childfare=$_POST["childfare"];
	$infantfare=$_POST["infantfare"];
	$note=addslashes($_POST["note"]);
	$title=addslashes($_POST["title"]);

	$result=$db->query("UPDATE travel_fares
	SET  fare_airline ='$airline',
	fare_title='$title',
	fare_adultfare='$adultfare',
	fare_dept_start='$date1',
	fare_dept_end ='$date2',
	fare_stay_min='$mindate',
	fare_stay_max='$maxdate',
	fare_restriction='$restriction',
	fare_purchaseby='$purchaseby',
	 fare_origin ='$origin',
	fare_destination='$destination',
	fare_special='$special',
	fare_active='$active',
	fare_type='$type',
	fare_child='$childfare',
	fare_infant='$infantfare',
	fare_note='$note'
	WHERE fare_id=$id");
	echo"<table>";
	if($result){
		echo"<center>Updated successfully. <a href=admin.php>Go to admin section</a>.</center>";
		goto("admin.php?op=viewfare");
	}else{
		echo"<center>Sorry  couldn't update please <a href=\"javascript:history.back()\">try again </a>.</center>";

	}
	echo"</table>";
	include("footer.php");
}
//Show block list
 function blocklist(){
    global $db;
    include("header.php");
    adminmenu();
    $id=intval($_GET["id"]);
    $result=$db->query("SELECT * from travel_blocks ORDER BY block_position");
    echo"<table width=100% bgcolor=#FFCC66>";
    echo"<tr><td>";
    echo"<fieldset>";
    echo"<legend>Blocks </legend>";
    echo"<table bgcolor=#FFCC66>";
    echo"<tr><td >List of Blocks</td>";
    echo"<td ><select name=\"block\" onChange=\"top.location.href=this.options[this.selectedIndex].value\"  class=\"english\">\n";
    echo"<option value=\"admin.php?op=blocklist\">--Select a block--</option>";
    while($row=$db->fetch_array($result)){
    	if($id==$row["block_id"]){
    		$sel="selected";
    	}else{
    		$sel="";
    	}
    	echo"<option value=\"admin.php?op=blocklist&id=$row[block_id]\" $sel>$row[block_title] (Position-$row[block_position])</option>\n";
    }
  	  echo"</select>\n";
  	  echo"</td></tr>";
  	  echo"</table>";
  	  echo"</fieldset>";
  	  echo"</td></tr></table>";
  	  $id="";
  	  if(isset($_GET["id"])){
  	  $id=intval($_GET["id"]);
  	  $sql=$db->query("select * from travel_blocks where block_id=$id");
  	  $row=$db->fetch_array($sql);

  	  if ($row["block_position"]== "l") {
  	        $sel_l = "selected";
  	        $sel_r = "";

  	    } elseif ($row["block_position"]== "r") {
  	        $sel_l = "";
  	        $sel_r = "selected";
  	     } elseif ($row["block_position"]== "c") {
  	        $sel_l = "";
  	        $sel_r = "";
  	    }

  	  if ($row["block_active"]== 1) {
  	        $sel1 = "checked";
  	        $sel2 = "";
  	    } elseif ($row["block_active"]== 0) {
  	        $sel1 = "";
  	        $sel2 = "checked";
  	    }


  	  echo"<form action=\"admin.php?op=updateblock\" method=\"post\">";
  	  echo"<table width=100% bgcolor=#FFCC66>";
  	  echo"<tr><td>";
  	  echo"<fieldset>";
  	  echo"<legend>Blocks</legend>";
  	  echo"<table>";
  	  echo"<tr><td colspan=\"2\" >Updating block,if the block is a file,leave content empty.</a>";
  	  echo"<tr><td >Block title</td><td ><input type=\"text\" name=\"title\" size=\"30\" value=\"$row[block_title]\"></td></tr>";
  	  echo"<tr><td valign=\"top\" >Content</td><td ><textarea  name=\"content\" rows=\"8\" cols=\"51\" wrap=\"virtual\">".stripslashes($row[block_content])."</textarea></td></tr>";
  	  echo"<tr><td >Block Position</td>";
  	  echo"<td ><select name=\"position\" >";
  	  echo"<option value=\"l\" $sel_l>Left</option>";
  	  echo"<option value=\"r\" $sel_r>Right</option>";
  	  echo"</select></td></tr>";
  	   echo"<tr><td >Block File</td><td>";
	      echo"<select name=\"file\">";
	      echo"<option value=>--Select-</option>";
	      $dir = opendir("blocks");
	  	while ($f = readdir($dir)) {
	  		if (eregi("\.php",$f)){
	  			if($f=="$row[block_file]"){
	  			$sel="selected";
	  			}else{
	  			$sel="";
	  			}
	  	 		echo "<option value=\"$f\" $sel>$f</option>";
	  	 	}
	  	}
	  	echo"</select>";
    echo"</td></tr>";
  	  //echo"<tr><td >Block File</td><td ><input type=\"text\" name=\"file\" size=\"40\" value=\"$row[block_file]\"></td></tr>";
  	  echo"<tr><td >Active this block ?</td><td ><input type=\"radio\" name=\"active\" value=\"1\" $sel1>Yes &nbsp;<input type=\"radio\" value=\"0\" name=\"active\" $sel2>No</td></tr>";
   	  echo"<tr><td >Who can view</td><td >";
	     echo"<select name=\"view\">";
	     	if($row[block_viewby]==1){
	     		$sel="";
	     		$sel1="Selected";
	     		$sel2="";
	     	}elseif($row[block_viewby]==2){
	     		$sel="";
	     		$sel1="";
	     		$sel2="selected";
	     	}else{
	     		$sel="Selected";
	     		$sel1="";
	     		$sel="";
	     	}
	     echo"<option value=\"0\" $sel>Anyone</option>
	     <option value=\"1\" $sel1>Member Only</option>
	     <option value=\"2\" $sel2>Admin Only</option>";
	     echo"</select>";
    echo"</td></tr>";

   	 echo"<tr><td ></td><td ><input type=\"submit\" value=\"Update Block\"> <input type=\"submit\" value=\"Remove block\" name=\"del\"></td></tr>";
  	  echo"<input type=\"hidden\" name=\"id\" value=\"$row[block_id]\">";
  	  echo"</table>";
  	  echo"</fieldset>";
  	  echo"</td></tr></table>";
  	  echo"</form>";
    }
    include("footer.php");

  }
// Add block form

  function block(){
  	global $db,$prefix;
  	include("header.php");
  	adminmenu();
  	echo"<table width=100% bgcolor=#FFCC66>";
  	echo"<tr><td>";
  	echo"<fieldset>";
    echo"<legend> Add Block</legend>";
    echo"<form action=\"admin.php?op=addblock\" method=\"post\">";
   echo"<table>";
    echo"<tr><td colspan=\"2\" ><font color=red> * If the block is a file,leave content empty.</font></a>";
    echo"<tr><td >Block title</td><td ><input type=\"text\" name=\"title\" size=\"30\" ></td></tr>";
    echo"<tr><td valign=\"top\">Content</td><td ><textarea  name=\"content\" rows=\"8\" cols=\"51\" wrap=\"virtual\"></textarea></td></tr>";
    echo"<tr><td >Block Position</td>";
    echo"<td ><select name=\"position\" >";
    echo"<option value=\"l\">Left</option>";
    echo"<option value=\"r\">Right</option>";
    echo"</select></td></tr>";
    echo"<tr><td >Block File</td><td>";
    echo"<select name=\"file\">";
    echo"<option value=>--Select-</option>";
    $dir = opendir("blocks");
	while ($f = readdir($dir)) {
		if (eregi("\.php",$f)){
	 		echo "<option value=\"$f\">$f</option>";
	 	}
	}
	echo"</select>";
    echo"</td></tr>";
     echo"<tr><td >Active this block ?</td><td ><input type=\"radio\" name=\"active\" value=\"1\" checked>Yes &nbsp;<input type=\"radio\" value=\"0\" name=\"active\">No</td></tr>";
    echo"<tr><td >Who can view</td><td >";
    echo"<select name=\"view\">
    <option value=\"0\">Anyone</option>
    <option value=\"1\">Member Only</option>
    <option value=\"2\">Admin Only</option>";
    echo"</select>";
    echo"</td></tr>";
    echo"<tr><td ></td><td ><input type=\"submit\" value=\"Add Block\"></td></tr>";
   echo"</table>";
   echo"</fieldset>";
   echo"</td></tr></table>";
    echo"</form>";
    include("footer.php");

  }

//Add block to the database
  function addblock(){
  	global $db,$prefix;
  	include("header.php");
  	adminmenu();
  	$title=addslashes($_POST["title"]);
  	$content=addslashes($_POST["content"]);
  	$position=addslashes($_POST["position"]);
  	$active=$_POST["active"];
  	$file=$_POST["file"];
	$view=intval($_POST["view"]);

	//Find block order
		$qb=$db->query("SELECT block_rank  FROM ".$prefix."_blocks WHERE block_position='$position'  ORDER BY block_rank DESC");
		list($rank)=$db->fetch_array($qb);

	$rank=$rank+1;

  	if(empty($title) || empty($position)){
  		echo"Oops ! you did not fill the form correctly";
  		include("footer.php");
  		exit;
  	}

  	if(!empty($content) && !empty($file)){
  		echo"Sorry,you can have  either content or file base block,not both";
  		include("footer.php");
  		exit;
  	}


  	$result=$db->query("INSERT into travel_blocks
  	(block_title,block_content,block_position,block_rank,block_active,block_file,block_viewby) values('$title','$content','$position','$rank','$active','$file',$view)");
  	if($result){
  		echo"Block Added successfully";
  		goto("admin.php.");
  	}else{
  		echo"Sorry,Block Couldn't added";
  	}
  	include("footer.php");

  }

	// update block
  function updateblock(){
  	global $db,$prefix;
  	include("header.php");
  	adminmenu();
  	$id=intval($_POST["id"]);
  	if(isset($_POST["del"])){
  		$result=$db->query("DELETE FROM travel_blocks WHERE block_id=$id");

  		if($result){
  			echo"Block Deleted successfully";
  			goto("admin.php");
  		}else{
  			echo"Sorry, Block Couldn't deleted !";
  		}
  		include("footer.php");
  		exit;
  	}
  	// All the  post variables
  	$title=addslashes($_POST["title"]);
  	$content=addslashes($_POST["content"]);
  	$position=$_POST["position"];
  	$active=$_POST["active"];
  	$file=$_POST["file"];
  	$view=intval($_POST["view"]);

  	// Check form submission
  		if(empty($title) || empty($position)){
  		echo"Oops ! you did not fill the form correctly";
  		include("footer.php");
  		exit;
  	}

  	if(!empty($content) && !empty($file)){
  		echo"Sorry,you can have  either content or file base block,not both";
  		include("footer.php");
  		exit;
  	}

  	// Now update the database

  	$result=$db->query("UPDATE travel_blocks
  	 set block_title='$title',
  	block_content='$content',
  	block_position='$position',
  	block_file='$file',
  	block_active='$active',
  	block_viewby='$view'
  	where block_id='$id'");
  	if($result){
  		echo"Block Updated successfully";
  		goto("admin.php");
  	}else{
  		echo"Sorry, Block Couldn't updated";
  	}

  	include("footer.php");

  }

 // Rank of blocks
  function rank(){
  	global $db,$prefix;
  	include("header.php");
  	adminmenu();
  	echo"<table width=100% bgcolor=#FFCC66>";
  	echo"<tr><td>";
  	echo"<fieldset>";
  	echo"<legend>Update block position</legend>";
  	$result=$db->query("SELECT block_id,block_rank,block_title,block_position,block_active from travel_blocks order by block_position,block_rank ASC");
  	echo"<table width=\"100%\" cellspacing=0 cellpadding=2>";
  	echo"<tr bgcolor=\"orange\"><td  align=\"center\" width=20%>Now </td><td align=\"center\"> Move</td><td  align=\"center\">Block title</td><td  align=\"center\">Block Rank</td><td align=\"center\">Move Up</td><td align=\"center\"> Move Down</td></tr>";
  	while(list($block_id,$block_rank,$block_title,$block_position,$block_active)=$db->fetch_array($result)){
  		if($block_position=="l"){
  			$img="<img src=\"images/left.gif\" border=\"0\" alt=\"left\">";
  		}elseif($block_position=="r"){
  			$img="<img src=\"images/right.gif\" border=\"0\" alt=\"right\">";
  		}else{
  			$img="";
  		}

  		if(empty($block_active)){
  			$active="<font color=red> *</font>";
  		}else{
  			$active="";
  		}

  		if($block_position=="l"){
  			$imgpos="<a href=admin.php?op=rank&mode=right&id=$block_id><img src=\"images/right.gif\" border=\"0\" alt=\"right\"></a>";
  		}elseif($block_position=="r"){
  			$imgpos="<a href=admin.php?op=rank&mode=left&id=$block_id><img src=\"images/left.gif\" border=\"0\" alt=\"left\"></a>";
  		}else{
  			$imgpos="";
  		}

  		echo"<tr><td align=\"center\">$img</td><td align=\"center\">$imgpos</td><td align=\"center\">$block_title $active</td><td align=\"center\">$block_rank</td><td align=\"center\"><a href=\"admin.php?op=rank&amp;mode=up&amp;id=$block_id\"><img src=\"images\up.gif\" border=\"0\" alt=\"up\"></a></td><td align=\"center\"><a href=\"admin.php?op=rank&amp;mode=down&amp;id=$block_id\"><img src=\"images/down.gif\" border=\"0\" alt=\"down\"></a></td></tr>";
  	}
  	echo"<tr><td colspan=6> <font color=red>*</font> means not active</td></tr>";
  	echo"<tr><td colspan=6><a href=admin.php?op=resetblock><font color=\"red\">RESET ALL BLOCKS RANK WHEN BLOCKS RANK CONFLICT</a></font></td></tr>";
  	echo"</table>";
  	if(isset($_GET["mode"])){
  		$mode=addslashes($_GET["mode"]);
  	}else{
  		$mode="";
  	}
  	$id=intval($_GET["id"]);
  	switch($mode){
  		case"up":
  		$result=$db->query("SELECT block_id,block_rank,block_position from travel_blocks where block_id=$id");
  		list($block_id,$block_rank,$block_position)=mysql_fetch_row($result);
  		$check=$db->query("select block_id,block_rank from travel_blocks where block_rank<$block_rank AND block_position='$block_position' AND block_active=1 order by block_rank DESC ");
  		list($block_idx,$block_rankx)=$db->fetch_row($check);
  		$found=$db->row_count($check);

  		if($found>0){
  			$update2=$db->query("update travel_blocks set block_rank=$block_rankx where block_id=$block_id");
  			$update=$db->query("update  travel_blocks set block_rank=$block_rank where block_id=$block_idx");
  			goto("admin.php?op=rank");
  		}

  		break;

  		case"down":

  		$result=$db->query("SELECT block_id,block_rank,block_position from travel_blocks where block_id=$id");
  		list($block_id,$block_rank,$block_position)=mysql_fetch_row($result);
  		$check=$db->query("select block_id,block_rank from travel_blocks where block_rank>$block_rank AND block_position='$block_position' AND block_active=1 order by block_rank ASC");
  		list($block_idx,$block_rankx)=$db->fetch_row($check);
  		$found=$db->row_count($check);
  		if($found>0){
  			$update2=$db->query("update  travel_blocks set block_rank=$block_rankx where block_id=$block_id");
  			$update=$db->query("update  travel_blocks set block_rank=$block_rank where block_id=$block_idx");
  			goto("admin.php?op=rank");
  		}

  		break;


  		case"left":
  		$db->query("update  travel_blocks set block_position='l' where block_id=$id");
  		echo"Moved to Left";
  		goto("admin.php?op=rank");
  		break;

  		case"right":
  		echo"Moved to Right";
  		$db->query("update  travel_blocks set block_position='r' where block_id=$id");
  		goto("admin.php?op=rank");
  		break;

  	}
  	echo"</fieldset>";
  	echo"</td></tr></table>";
  	include("footer.php");

  }

//Reset Block Position
  function resetblock(){
  	include("header.php");
  	global $db,$prefix;
  	adminmenu();
  	$leftpos = "l";
      $rightpos = "r";
      $result = $db->query("select block_id from travel_blocks where block_position='$leftpos' order by block_rank ASC");
      $rank = 0;
      while(list($bid) =$db->fetch_row($result)) {
  		$rank++;
      	$bid = intval($bid);
  		$db->query("update travel_blocks set block_rank='$rank' where block_id='$bid'");
      }
      $result = $db->query("select block_id from travel_blocks where block_position='$rightpos' order by block_rank ASC");
      $rank = 0;
      while(list($bid) =$db->fetch_row($result)) {
  		$rank++;
      	$bid = intval($bid);
  		$db->query("update travel_blocks set block_rank='$rank' where block_id='$bid'");
      }
  	echo"<center>Reset done</center>";
  	goto("admin.php?op=rank");
  	include("footer.php");

}

function configuration(){
  global $prefix,$db,$site_path;
  include("header.php");
  adminmenu();
  $result=$db->query("SELECT * FROM travel_config",$link);
  $result2=$db->query("SELECT * FROM travel_admin",$link);
  $admin=$db->fetch_array($result2);
  $row=$db->fetch_array($result);
  echo"<form action=\"admin.php?op=updateconfig\" method=\"post\">";
  echo"<table width=100% bgcolor=#FFCC66>";
  echo"<tr><td>";
  echo"<fieldset>";
  echo"<legend>Update site Configuration</strong></legend>";
  echo"<table align=center cellpadding=5 width=100%>";
  echo"<tr><td align=\"right\">Site Title/Name *</td><td><input type=text name=\"site_title\" size=50 value=\"$row[site_title]\"></td></tr>";
  echo"<tr><td align=\"right\">Site url * </td><td><input type=text name=site_url size=50 value=$row[site_url]></td></tr>";
   echo"<tr><td valign=\"top\" align=\"right\">Site Description *</td><td><textarea   name=\"site_desc\" rows=4 cols=51>$row[site_desc]</textarea></td></tr>";
   echo"<tr><td valign=\"top\" align=\"right\">Site Keywords *</td><td><textarea   name=\"site_keywords\" rows=4 cols=51>$row[site_keywords]</textarea></td></tr>";
/*dgt   echo"<tr><td align=\"right\">Default Theme *</td><td>";
  echo "<select name=\"theme\" >";

  $th=opendir('themes');
  while ($file = readdir($th)) {
  	if ( (!ereg("[.]",$file)) ) {
  		$themelist .= "$file ";
  	}
  }
  closedir($th);
  $themelist = explode(" ", $themelist);
  sort($themelist);
  for ($i=0; $i < sizeof($themelist); $i++) {

  	if($themelist[$i]!="") {
  		echo "<option name='theme' value='$themelist[$i]' ";
  		if($themelist[$i]==$row["site_theme"]) echo "selected";
  		echo ">$themelist[$i]\n";

  	}

  }

  echo "</select>";
*/  
  echo"</td></tr>";
 echo"<tr><td align=\"right\">Default Language</td><td>";
  echo "<select name=\"language\" >";

    $th=opendir("$site_path/language");
    while ($file = readdir($th)) {
    	 if($file <>'.' && $file <>'..'){
    		$languagelist .= "$file ";
    	}
    }
    closedir($th);
    print_r($languagelist);
    $languagelist = explode(" ", $languagelist);
    sort($languagelist);
    for ($i=0; $i < sizeof($languagelist); $i++) {

    	if($languagelist[$i]!="") {
    		echo "<option name='languge' value='$languagelist[$i]' ";
    		if($languagelist[$i]==$row["site_language"]) echo "selected";
    		echo ">$languagelist[$i]\n";

    	}

    }

  echo "</select>";
 echo"</td></tr>";
 echo"<tr><td colspan=\"2\" align=\"center\"><small><font color=\"red\">If you don't want to change your old password leave Admin password box empty.</font></small></td></tr>";
  echo"<tr><td align=\"right\"> Admin Password</td><td><input type=\"password\" size=\"40\"  name=\"pass1\"></td></tr>";
  echo"<tr><td align=\"right\">Admin Password again</td><td><input type=\"password\" size=\"40\"  name=\"pass2\"></td></tr>";
  echo"<tr><td align=\"right\">Admin Email </td><td><input type=\"text\" name=\"email\" size=\"40\" value=\"$row[site_admin]\"></td></tr>";
  echo"<tr><td align=\"right\">Admin Email again </td><td><input type=\"text\" name=\"email2\" size=\"40\"	value=\"$row[site_admin]\"></td></tr>";
  echo"<tr><td align=\"right\">Booking enquiry phone no. *</td><td><input type=\"text\" name=\"phone\" size=\"35\"  value=\"$row[site_phone]\"></td></tr>";
  echo"<tr><td align=\"right\">Booking enquiry Email *</td><td><input type=\"text\" name=\"enquiry_email\" size=\"35\"  value=\"$row[site_booking_email]\"></td></tr>";
   echo"<tr><td align=\"right\">Contact Email *</td><td><input type=\"text\" name=\"contact_email\" size=\"35\"  value=\"$row[site_contact_email]\"><small>(uses for newsletter)</small></td></tr>";

 echo"<tr><td valign=\"top\" align=\"right\">Address</td><td><textarea name=\"addr\" rows=\"5\" cols=\"51\" wrap=\"virtual\">$row[site_addr]</textarea></td></tr>";
  echo"<tr><td></td><td><input type=\"submit\" value=\"Update now\"></td></tr>";
  echo"</table>";
  echo"</fieldset>";
  echo"</td></tr>";
  echo"</table>";
  include("footer.php");

}

function updateconfig(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
//dgt	$theme=$_POST["theme"];
	$siteurl=$_POST["site_url"];
	$sitetitle=addslashes($_POST["site_title"]);
	$sitedesc=addslashes($_POST["site_desc"]);
	$sitekeywords=addslashes($_POST["site_keywords"]);
	$pass1=$_POST["pass1"];
	$pass2=$_POST["pass2"];
	$email=addslashes($_POST["email"]);
	$email2=addslashes($_POST["email2"]);
	$phone=$_POST["phone"];
	$addr=addslashes($_POST["addr"]);
	$language=$_POST["language"];
	$enquiry_email=$_POST["enquiry_email"];
	$contact_email=$_POST["contact_email"];
	$result=$db->query("SELECT * FROM travel_config");
	$row=$db->fetch_array($result);
	if(!empty($pass1) || !empty($pass2)){
		if(strlen($pass1)<4 || ($pass1!=$pass2)){
			echo"<center>Either two password did not match each other or password must be minimum 4 characters long.<a href=javascript:history.back()>Go back </a></center>";
			include("footer.php");
			exit;
		}
	$pass=md5($pass1);
	}

	if(!empty($email) || !empty($email2)){
		if($email!=$email2){
			echo"<center>Email address did not match each other.<a href=javascript:history.back()>Go back </a></center>";
			include("footer.php");
			exit;
		}
	}

	if(empty($pass)){
		$pass=$row["site_pass"];
	}
	if(empty($email)){
	   $email=$row["site_email"];
	}
//dgt	site_theme='$theme',
	$result=$db->query("UPDATE travel_config SET site_url='$siteurl',
	site_title='$sitetitle',
	site_desc='$sitedesc',
	site_keywords='$sitekeywords',
	site_admin='$email',
	site_pass='$pass',
	site_language='$language',
	site_phone='$phone',
	site_booking_email='$enquiry_email',
	site_contact_email='$contact_email',
	site_addr='$addr'
	");
	echo"<center>Updated successfully</center>";
	goto("admin.php");
	include("footer.php");
}

function origin(){
	global $db;
	include("header.php");
	adminmenu();
	echo"<form action=\"admin.php?op=addorigin\" method=\"post\">";
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend>Add Origin</legend>";
	echo"<table>";
	echo"<tr><td>Origin Name</td><td><input type=\"text\" name=\"origin\"></td></tr>";
	echo"<tr><td colspan=2 align=\"center\"\><input type=\"submit\" value=\"Add origin\"></td></tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr></table>";
	echo"</form>";
	include("footer.php");


}

function addorigin(){
	global $db;
	include("header.php");
	adminmenu();
	$origin=$_POST["origin"];
	if(empty($origin)){
		echo"<center>Sorry form was incomplete.Please <a href=\"javascript:history.back()\">go back correct</a> it.</center>";
		include("footer.php");
		exit;

	}

	$qinsert=$db->query("INSERT INTO travel_origin(origin_name) values('$origin')");
	if($qinsert){
		echo"<center>Origin added successfully.</center>";
		goto("admin.php");

	}else{
		echo"<center>Sorry, origin couldn't be added.</center>";
	}
	include("footer.php");



}

function destination(){
	global $db;
	include("header.php");
	adminmenu();
	echo"<form action=\"admin.php?op=adddestination\" method=\"post\">";
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend>Add Destination</legend>";
	echo"<table >";
	echo"<tr><td>Destination Name</td><td><input type=\"text\" name=\"destination\"></td></tr>";
	echo"<tr><td colspan=2 align=\"center\"\><input type=\"submit\" value=\"Add destination\"></td></tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr>";
	echo"</table>";
	echo"</form>";
	include("footer.php");


}

function adddestination(){
	global $db;
	include("header.php");
	adminmenu();
	$destination=$_POST["destination"];
	if(empty($destination)){
		echo"<center>Sorry form was incomplete.Please <a href=\"javascript:history.back()\">go back correct</a> it.</center>";
		include("footer.php");
		exit;

	}

	$qinsert=$db->query("INSERT INTO travel_destination(destination_name) values('$destination')");
	if($qinsert){
		echo"<center>Destination added successfully.</center>";
		goto("admin.php");

	}else{
		echo"<center>Sorry, destination couldn't be added.</center>";
	}
	include("footer.php");
}


function modorigin(){
	global $db;
	include("header.php");
	adminmenu();
	echo"<form action=\"admin.php?op=updateorigin\" method=\"post\">";
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";

	echo"<fieldset>";
	echo"<legend>Update origin</legend>";
	echo"<table>";
	echo"<tr><td>Select Origin</td><td>";
	$qorigin=$db->query("SELECT * FROM travel_origin");
	echo"<select name=\"origin\">";
	while($origin=$db->fetch_array($qorigin)){
		echo"<option value=\"$origin[origin_id]\">$origin[origin_name]</option>";
	}
	echo"</select></td></tr>";
	echo"<tr><td>Rename to </td><td><input type=\"text\" name=\"origin_new\"></td></tr>";
	echo"<tr><td colspan=2 align=\"center\"\><input type=\"submit\" value=\"Update origin\" name=\"update\"><input type=\"submit\" value=\"Remove origin\" name=\"del\"></td></tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr></table>";
	echo"</form>";

	include("footer.php");

}


function updateorigin(){
	global $db;
	include("header.php");
	adminmenu();
	$origin=intval($_POST["origin"]);
	$origin_new=addslashes($_POST["origin_new"]);
	if(isset($_POST["del"])){
		$qdel=$db->query("DELETE FROM travel_origin WHERE origin_id=$origin");
		if($qdel){
			echo"<center>Removed successfully.</center>";
			goto("admin.php");
		}

	}

	if(isset($_POST["update"])){
		if(empty($origin_new)){
			echo"<center>Sorry form was incomplete.Please <a href=\"javascript:history.back()\">go back correct</a> it.</center>";

		}else{
			$qupdate=$db->query("UPDATE travel_origin SET origin_name='$origin_new'
			WHERE origin_id=$origin");
			echo"<center>Updated successfully.</center>";
			goto("admin.php");
		}

	}

	include("footer.php");

}


function moddestination(){
	global $db;
	include("header.php");
	adminmenu();
	echo"<form action=\"admin.php?op=updatedestination\" method=\"post\">";
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend>Update destination</legend>";
	echo"<table>";
	echo"<tr><td>Select Origin</td><td>";
	$qdestination=$db->query("SELECT * FROM travel_destination");
	echo"<select name=\"destination\">";
	while($destination=$db->fetch_array($qdestination)){
		echo"<option value=\"$destination[destination_id]\">$destination[destination_name]</option>";
	}
	echo"</select></td></tr>";
	echo"<tr><td>Rename to </td><td><input type=\"text\" name=\"destination_new\"></td></tr>";
	echo"<tr><td colspan=2 align=\"center\"\><input type=\"submit\" value=\"Update destination\" name=\"update\"><input type=\"submit\" value=\"Remove destination\" name=\"del\"></td></tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr></table>";
	echo"</form>";

	include("footer.php");

}


function updatedestination(){
	global $db;
	include("header.php");
	adminmenu();
	$destination=intval($_POST["destination"]);
	$destination_new=addslashes($_POST["destination_new"]);
	if(isset($_POST["del"])){
		$qdel=$db->query("DELETE FROM travel_destination WHERE destination_id=$destination");
		if($qdel){
			echo"<center>Removed successfully.</center>";
			goto("admin.php");
		}

	}

	if(isset($_POST["update"])){
		if(empty($destination_new)){
			echo"<center>Sorry form was incomplete.Please <a href=\"javascript:history.back()\">go back correct</a> it.</center>";

		}else{
			$qupdate=$db->query("UPDATE travel_destination SET destination_name='$destination_new'
			WHERE destination_id=$destination");
			echo"<center>Updated successfully.</center>";
			goto("admin.php");
		}

	}

	include("footer.php");

}
function viewnews(){
	include("header.php");
	global $db,$prefix;
	adminmenu();
	$id=getvarint("id");
	$result=$db->query("SELECT * FROM travel_news WHERE news_id=$id ORDER BY news_id DESC");
	$row=$db->fetch_array($result);
	echo"<form action=\"admin.php?op=updatenews\" method=post>";
	echo"<table>";
	echo"<tr><td valign=top>News Title</td><td><input type=text name=newstitle value=$row[news_title]></td>";
	echo"<tr><td valign=top>Short description</td><td><textarea name=sdesc rows=4 cols=51>".stripslashes($row[news_sdesc])."</textarea></td></tr>";
	echo"<tr><td valign=top> Long description</td><td><textarea name=desc rows=10 cols=51>".stripslashes($row[news_desc])."</textarea><br></td></tr>";
	echo"<tr><td></td><td><input type=\"submit\" name=\"submit\" value=\"Update\"> &nbsp; &nbsp;<input type=submit name=\"del\"value=\"Delete\"></td></tr>";
	echo"</table>";
	echo"<input type=hidden name=id value=$id.>";
	echo"</form>";
	include("footer.php");
}

function updatenews(){
	global $prefix,$db;
	include("header.php");
	adminmenu();
	$id=intval($_POST["id"]);
	$title=addslashes($_POST["newstitle"]);
	$sdesc=addslashes($_POST["sdesc"]);
	$desc=addslashes($_POST["desc"]);

	if(empty($title) || empty($sdesc)){
		echo"<center> Form was   incomplte. <a href=javascript:history.back()>Please go back and fill it correctly..</a></center>";
		include("footer.php");
		exit;
	}

	if(isset($_POST["del"])){
		$result=$db->query("DELETE FROM travel_news WHERE news_id=$id");
		if($result){
			echo"<center>News deleted successfully. <a href=admin.php>Go to admin section </A>";
		}else{
				echo"<center>News couldn't delete. <a href=admin.php>Try again </A>";
		}
		include("footer.php");
		exit;

	}

	$result=$db->query("UPDATE  travel_news set
	news_title='$title',
	news_sdesc='$sdesc',
	news_desc='$desc'
	WHERE news_id=$id");
	if($result){
		echo"<center>News pdated successfully.<a href=admin.php>Go to  admin section.</a></center>";
	}else{
		echo"<center>Sorry, news couldn't be updated.,<a href=admin.php>Go to  admin section.</a></center>";
	}
	include("footer.php");
}


function news(){
	include("header.php");
	global $db,$prefix;
	adminmenu();
	echo"<form action=\"admin.php?op=addnews\" method=\"post\">";
	echo"<table bgcolor=\"#FFCC66\" width=\"100%\">";
	echo"<tr><td valign=top>News Title</td><td><input type=text name=\"newstitle\" size=\"50\"></td>";
	echo"<tr><td valign=top>Short description</td><td><textarea name=\"sdesc\" rows=4 cols=51></textarea></td></tr>";
	echo"<tr><td valign=top> Long description</td><td><textarea name=\"desc\" rows=10 cols=51></textarea><br>
	</td></tr>";
	echo"<tr><td ></td><td><input type=submit name=submit value=\"Add News\"></td></tr>";
	echo"</table>";
	echo"</form>";
	include("footer.php");
}


function addnews(){
	global $prefix,$db;
	include("header.php");
	adminmenu();
	$id=intval($_POST["id"]);
	$title=addslashes($_POST["newstitle"]);
	$sdesc=addslashes($_POST["sdesc"]);
	$desc=addslashes($_POST["desc"]);

	if(empty($title) || empty($sdesc)){
		echo"<center> Form was   incomplte. <a href=javascript:history.back()>Please go back and fill it correctly..</a></center>";
		include("footer.php");
		exit;
	}
	$time=time();
	$result=$db->query("INSERT  INTO   travel_news (news_title,news_sdesc,news_desc,news_date) values('$title','$sdesc','$desc','$time')");
	if($result){
		echo"<center>News added successfully.<a href=admin.php>Go to  admin section.</a></center>";
	}else{
		echo"<center>Sorry, news couldn't be added,<a href=admin.php>Go to  admin section.</a></center>";
	}
	include("footer.php");
}

function  newsindex(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$result=$db->query("SELECT * FROM travel_news ORDER BY news_id DESC");
	$found=$db->row_count($result);
	if($found<1){
		echo"<center>Sorry,no news found.You can  add news <a href=admin.php?op=news>here</a>.</center>";
		include("footer.php");
		exit;
	}
	echo"<table width=100% bgcolor=#FFCC66>";
	echo"<tr><td>";
	echo"<fieldset>";
	echo"<legend>News</legend>";
	echo"<table border=\"0\" width=100% >";
	echo"<tr><td><b>Title</b></td><td><b>Date</b></td><td><b>Action</b></td></tr>";
	while($row=$db->fetch_array($result)){
		echo"<tr><td><a  href=admin.php?op=viewnews&id=$row[news_id]>$row[news_title]</a></td><td>
		".date("d m Y","$row[news_date]")."<td><a  href=admin.php?op=viewnews&id=$row[news_id]>Edit/Delete</a></td></tr>";
	}
	echo"</table>";
	echo"</fieldset>";
	echo"</td></tr>";
	echo"</table>";
	include("footer.php");
}


function newsletter(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$result=$db->query("SELECT count(user_id) FROM ".$prefix."_newsletter_user");
	list($found)=$db->fetch_row($result);
	echo"<fieldset>";
	echo"<table>";
	echo"<tr><td><b>Total User $found</b></td></tr>";
	echo"</table>";
	echo"</fieldset>";

	echo"<form action=\"admin.php?op=sndletter\" method=\"post\">";
	echo"<fieldset>";
	echo"<legend>Send News letter</legend>";
	echo"<table>";
	echo"<tr><td><strong>Subject</strong></td><td><input type=\"text\" name=\"subject\" size=\"60\"></td><td>&nbsp;</td></tr>";
	echo"<tr><td valign=\"top\"><strong>Newsletter Body</strong></td><td><textarea name=\"msg\" rows=\"20\" cols=\"81\"></textarea></td></tr>";
	echo"<tr><td valign=\"top\">1st text</td><td><textarea  name=\"txt1\" rows=\"4\" cols=\"51\"></textarea></td></tr>";
	echo"<tr><td valign=\"top\">1st Image</td><td><input type=\"text\" name=\"img1\" size=\"40\"></td></tr>";
	echo"<tr><td valign=\"top\">2nd text</td><td><textarea  name=\"txt2\" rows=\"4\" cols=\"51\"></textarea></td></tr>";
	echo"<tr><td valign=\"top\">2nd Image</td><td><input type=\"text\" name=\"img2\" size=\"40\"></td></tr>";
	echo"<tr><td valign=\"top\">3rd text</td><td><textarea  name=\"txt3\" rows=\"4\" cols=\"51\"></textarea></td></tr>";
	echo"<tr><td valign=\"top\">3rd Image</td><td><input type=\"text\" name=\"img3\" size=\"40\"></td></tr>";
	echo"<tr><td>&nbsp;</td><td><input type=\"submit\" value=\"Send Now !\"> &nbsp; <input type=\"submit\" value=\"Send me only\" name=\"test\"></td></tr>";
	echo"</table>";
	echo"</fieldset>";
	echo"</form>";
	include("footer.php");


}


function sndletter(){
	global $db,$prefix,$config;
	include("header.php");
	adminmenu();
	$subject=$_POST["subject"];
	$msg=$_POST["msg"];
	if(isset($_POST["test"])){
		$test=1;
	}else{
		$test=0;
	}
	if(empty($subject) || empty($msg)){
		echo"<center>Sorry,form was incomplete.<a href=\"javascript:history.back();\">Go back and fill in the form.</a></center>";
		include("footer.php");
		exit;
	}

	//Simple dummy way code that
	$txt1=$_POST["txt1"];
	$txt2=$_POST["txt2"];
	$txt3=$_POST["txt3"];
	$img1=$_POST["img1"];
	$img2=$_POST["img2"];
	$img3=$_POST["img3"];
	$ad1=array("txt1"=>$txt1,"img1"=>$img1);
	$ad2=array("txt2"=>$txt2,"img2"=>$img2);
	$ad3=array("txt3"=>$txt3,"img3"=>$img3);
	newsletter_send($subject, $msg,$test,$ad1,$ad2,$ad3);
	echo"<center>Thank you. Newsletter has been sent.</center>";

	include("footer.php");
}


function siteStat(){
	global $db,$prefix,$config;
	include("header.php");
	adminmenu();

	//Total page Views
	$qpview=$db->query("SELECT counter_id FROM ".$prefix."_counter ");
	$pageviews=$db->row_count($qpview);
	$result = $db->query("SELECT date_format(counter_time,'%d/%m/%y') as date FROM ".$prefix."_counter ORDER BY  counter_time ASC LIMIT 1");
	$stat=$db->fetch_array($result);
	$now=date("d/m/y");

	//Distinct hits
	$qdistinct=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter ORDER BY counter_ip");
	$total=$db->row_count($qdistinct);

	//daily Hits
	$qdhits=$db->query("SELECT TO_DAYS(MAX(counter_time)) - TO_DAYS(MIN(counter_time)) AS record FROM ".$prefix."_counter");
	list($avgday)=$db->fetch_row($qdhits);
	if(!empty($avgday)){
		$avghits=round($total/$avgday);

	}

	$qonline=$db->query("SELECT * FROM ".$prefix."_visitor");
	$online=$db->row_count($qonline);

	echo"<fieldset>";
	echo"<legend>Site Statistics</legend>";
	echo"<Table width=100% bgcolor=#FFCC6>";
	echo"<tr class=\"title\"><td>Site Statistics  SINCE $stat[date] </td><td>Page Views :$pageviews </td><td>Unique Hits : $total</td><td>Daily Hits(unique) : $avghits</td><td>Visitor online :<a href=\"admin.php?op=online\">$online</a></td></tr>";
	echo"</table>";
	echo"<br>";

	//IE
	$qie=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%MSIE%'");
	$ie=$db->row_count($qie);

	//netscape
	$qnetscape=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Netscape%'");
	$netscape=$db->row_count($qnetscape);

	//opera
	$qopera=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Opera%'");
	$opera=$db->row_count($qopera);

	//Konqueror
	$qkon=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Konqueror%'");
	$konqueror=$db->row_count($qkon);



	//FireFox
	$qff=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Firefox%'");
	$firefox=$db->row_count($qff);

	//Bot
	$qbot=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Bot%'");
	$bot=$db->row_count($bot);

	//Mozilla
	$qm=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Mozilla%'");
	$mozilla=$db->row_count($qm);

	//Other
	$other=$db->query("SELECT DISTINCT(counter_ip) FROM ".$prefix."_counter WHERE counter_browser LIKE '%Other%'");
	$other=$db->row_count($qother);
	echo"Browser<hr>";
	echo"<table width=\"100%\">";
 	echo "<tr><td><img src=\"images/stat/explorer.gif\" border=\"0\" alt=\"\">&nbsp;MSIE: </td><td>$ie</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/netscape.gif\" border=\"0\" alt=\"\">&nbsp;Netscape: </td><td>$netscape</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/opera.gif\" border=\"0\" alt=\"\">&nbsp;Opera: </td><td>$opera</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/konqueror.gif\" border=\"0\" alt=\"\">&nbsp;Konqueror: </td><td>$konqueror</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/firefox.png\" border=\"0\" alt=\"\">&nbsp;Firefox: </td><td>$firefox</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/mozzila.gif\" border=\"0\" alt=\"\">&nbsp;Mozilla: </td><td>$mozilla</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/altavista.gif\" border=\"0\" alt=\"\">&nbsp;Search Engines </td><td>$bot</td></tr>\n";
    echo "<tr><td><img src=\"images/stat/question.gif\" border=\"0\" alt=\"\">&nbsp;Uknown </td><td>$other</td></tr>";

	echo"</table>";
	/*
	echo"<br>";
	echo"Operating System<hr>";
	echo"<table width=\"100%\">";
	echo "<center><b>Operating System</b></center><br></td></tr>\n";
	echo "<tr><td><img src=\"images/stat/windows.gif\" border=\"0\" alt=\"\">&nbsp;Windows:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Windows\"><img src=\"images/stat/mainbar.gif\" Alt=\"Windows\" height=\"$m_size[1]\" width=", $windows[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Windows\"> $windows[1] % ($windows[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/linux.gif\" border=\"0\" alt=\"\">&nbsp;Linux:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Linux\"><img src=\"images/stat/mainbar.gif\" Alt=\"Linux\" height=\"$m_size[1]\" width=", $linux[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Linux\"> $linux[1] % ($linux[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/mac.gif\" border=\"0\" alt=\"\">&nbsp;Mac/PPC:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Mac/PPC\"><img src=\"images/stat/mainbar.gif\" Alt=\"Mac - PPC\" height=\"$m_size[1]\" width=", $mac[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"Mac/PPC\"> $mac[1] % ($mac[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/bsd.gif\" border=\"0\" alt=\"\">&nbsp;FreeBSD:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"FreeBSD\"><img src=\"images/stat/mainbar.gif\" Alt=\"FreeBSD\" height=\"$m_size[1]\" width=", $freebsd[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"FreeBSD\"> $freebsd[1] % ($freebsd[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/sun.gif\" border=\"0\" alt=\"\">&nbsp;SunOS:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"SunOS\"><img src=\"images/stat/mainbar.gif\" Alt=\"SunOS\" height=\"$m_size[1]\" width=", $sunos[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"SunOS\"> $sunos[1] % ($sunos[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/be.gif\" border=\"0\" alt=\"\">&nbsp;BeOS:</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"BeOS\"><img src=\"images/stat/mainbar.gif\" Alt=\"BeOS\" height=\"$m_size[1]\" width=", $beos[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\"BeOS\"> $beos[1] % ($beos[0])</td></tr>\n";
	echo "<tr><td><img src=\"images/stat/question.gif\" border=\"0\" alt=\"\">&nbsp;Uknown</td><td><img src=\"images/stat/leftbar.gif\" height=\"$l_size[1]\" width=\"$l_size[0]\" Alt=\"Otros - Desconocidos\"><img src=\"images/stat/mainbar.gif\" ALt=\"Otros - Desconocidos\" height=\"$m_size[1]\" width=", $os_other[1] * 2, "><img src=\"images/stat/rightbar.gif\" height=\"$r_size[1]\" width=\"$r_size[0]\" Alt=\""._OTHER."\"> $os_other[1] % ($os_other[0])\n";
	echo"</table>";
	echo"<br>";
	*/
	echo"Last Referrer<hr>";
	$qref=$db->query("SELECT *  FROM ".$prefix."_counter WHERE counter_referer!=''order by counter_id  DESC LIMIT 20");


	echo"<table width=\"100%\">";
	echo "<tr><td><b>Referer</b></td></tr>\n";

	while($referer=$db->fetch_array($qref)){
		echo "<tr>";
		echo"<td><a href=\"$referer[counter_referer]\">$referer[counter_referer]</a></td></tr>\n";
	}
	echo"</table>";
	echo"</fieldset>";
	include("footer.php");




}


function online(){
	global $db,$prefix;
	include("header.php");
	adminmenu();
	$qonline=$db->query("SELECT * FROM ".$prefix."_visitor");
	echo"<fieldset>";
	echo"<legend>Vistors</legend>";
	echo"<table bgcolor=\"#FFC6\" width=\"100%\">";
	echo"<tr><td><b>Visitor IP</b></td><td><b>Visitor Host Name</b></td><td><b>Total Time</b></td></tr>";
	$time=time();
	while($row=$db->fetch_array($qonline)){
		$unixtime = time() - $row[visitor_visit_time];
	       if($unixtime < 60)	       {
	             $sec=$unixtime;
	             $min=0;
	             $hour=0;
	       }
	       else if($unixtime < 3600){
	             $sec=$unixtime%60;
	             $hour=0;
	             $min_t = explode('.', number_format($unixtime/60,2));
	             $min=$min_t[0];
	       }
	       else if($unixtime >= 216000){
	             $hour_t = explode('.',number_format($unixtime/216000,2));
	             $hour=$hour_t[0];
	             $sec=$unixtime%60;
	             $min_te = $unixtime%216000;
	             $min_t = explode('.',number_format($min_te/60,2));
	             $min=$min_t[0];
       }
		echo"<tr><td>$row[visitor_ip]</td><td>$row[visitor_host]</td><td>$hour <b>Hrs</b>,$min <b>Min(s)</b>,$sec <b>Sec(s)</b></td></tr>";

	}
	echo"</table>";
	echo"</fieldset>";
	include("footer.php");

}


function viewPackageFile(){
	global $db,$prefix;
	$id=intval($_GET["id"]);
	$result=$db->query("SELECT * FROM ".$prefix."_package WHERE package_id=$id");
	$file=$db->fetch_array($result);
	header("Content-type: $file[package_file_type]");
	header("Content-length: $file[package_file_size]");
	header("Content-Disposition: attachment; filename=$file[package_file_name]");
	header("Content-Description: PHP Generated Data");
  	echo $file[package_file];

}


switch($op){
	default:
	index();
	break;

	case"fare";
	fare();
	break;

	case"editfare":
	editfare();
	break;

	case"viewfare":
	viewfare();
	break;

	case"updatefare":
	updatefare();
	break;

	case"package":
	package();
	break;

	case"viewpackage":
	viewpackage();
	break;

	case"editpackage":
	editpackage();
	break;

	case"modifypackage":
	modifypackage();
	break;

	case"blocklist":
	blocklist();
	break;

	case"block":
	block();
	break;

	case"addblock":
	addblock();
	break;

	case"updateblock":
	updateblock();
	break;

	case"rank":
	rank();
	break;

	case"resetblock";
	resetblock();
	break;

	case"configuration":
	configuration();
	break;

	case"updateconfig":
	updateconfig();
	break;

	case"origin":
	origin();
	break;

	case"addorigin":
	addorigin();
	break;


	case"destination":
	destination();
	break;

	case"adddestination":
	adddestination();
	break;

	case"modorigin":
	modorigin();
	break;

	case"updateorigin":
	updateorigin();
	break;

	case"moddestination":
	moddestination();
	break;

	case"updatedestination":
	updatedestination();
	break;

	case"newsindex":
	newsindex();
	break;

	case"addnews":
	addnews();
	break;

	case"news":
	news();
	break;

	case"viewnews":
	viewnews();
	break;

	case"updatenews":
	updatenews();
	break;


	case"newsletter":
	newsletter();
	break;

	case"sndletter":
	sndletter();
	break;


	case"siteStat":
	siteStat();
	break;

	case"online":
	online();
	break;

	case"viewPackageFile":
	viewPackageFile();
	break;


}


?>
