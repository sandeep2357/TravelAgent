<?php

//File : booking.php

//Date: 28/02/2005

//Desc : Booking details

if(!eregi("index.php",$_SERVER["PHP_SELF"])){

	header("location:index.php");

	die();

}



$index=2;



require_once("mainfile.php");

$page_title=$lang["booking_page_title"];

/*

if(!is_user()){

	include("header.php");

	$tpl=new Template();

	goto("index.php?m=member&file=login","Taking you to login page");

	//$tpl->display("modules/member/registration_msg.tpl");

	include("footer.php");

	exit;



}

*/





function  index(){

	session_start();

	global $db,$lang,$prefix;

	include("header.php");



	$tpl=& new Template();

	//Origin

	$qorigin=$db->query("SELECT origin_id,origin_name FROM ".$prefix."_origin");



	$origin_opt=array();

	while(list($origin_id,$origin_name)=$db->fetch_row($qorigin)){

		$origin_opt[$origin_id]=$origin_name;

	}





	//Destination

	$qdestination=$db->query("SELECT destination_id,destination_name FROM ".$prefix."_destination");

	$destination_opt=array();

	while(list($destination_id,$destination_name)=$db->fetch_array($qdestination)){

		$destination_opt[$destination_id]=$destination_name;

	}



	// Airlines

	$qairline=$db->query("SELECT airline_id,airline_name FROM ".$prefix."_airline");

	$airline_opt=array();

	while(list($airline_id,$airline_name)=$db->fetch_array($qairline)){

		$airline_opt[$airline_id]=$airline_name;

	}



	// Class

	$qclass=$db->query("SELECT class_id,class_name FROM ".$prefix."_class");

	$class_opt=array();

	while(list($class_id,$class_name)=$db->fetch_array($qclass)){

		$class_opt[$class_id]=$class_name;

	}





	smartyValidate::connect($tpl, empty($_POST));

	SmartyValidate::register_form('booking');

	 if(empty($_POST)) {

	 		$tpl->assign("lang",$lang);

			$tpl->assign("origin_opt",$origin_opt);

			$tpl->assign("destination_opt",$destination_opt);

			$tpl->assign("airline_opt",$airline_opt);

			$tpl->assign("class_opt",$class_opt);

		   $tpl->display('booking.tpl');

		} else {

		   // validate after a POST

		   if(SmartyValidate::is_valid($_POST)) {

			   // no errors, done with SmartyValidate

				SmartyValidate::disconnect();

				$adult=intval($_POST["adult"]);

				$adult=intval($_POST["adult"]);

				$children=intval($_POST["children"]);

				$infant=intval($_POST["infant"]);

				$origin=intval($_POST["origin"]);

				$destination=intval($_POST["destination"]);

				$departure_date=$_POST["departure_date"];

				$returning_date=$_POST["returning_date"];

				$class=intval($_POST["class"]);

				$airline=intval($_POST["airline"]);

				$type=intval($_POST["btype"]);

				//echo"<center>$lang[processing]<img src=\"images/redirecting.gif\"></center>";

				goto("index.php?m=booking&op=booking2&adult=$adult&children=$children&infant=$infant&origin=$origin&destination=$destination&departure_date=$departure_date&returning_date=$returning_date&class=$class&airline=$airline&type=$type",$lang[processing],1);





		   } else {

			   // error, redraw the form



			   $tpl->assign($_POST);

			   $tpl->assign("lang",$lang);

			   $tpl->assign("origin_opt",$origin_opt);

			   $tpl->assign("destination_opt",$destination_opt);

			   $tpl->assign("airline_opt",$airline_opt);

			   $tpl->assign("class_opt",$class_opt);



			   $tpl->display('booking.tpl');

		   }



		}



	include("footer.php");

}





function booking2(){

	session_start();

	global $db,$lang,$prefix;

	include("header.php");

	$tpl=&  new Template();

	smartyValidate::connect($tpl);

	SmartyValidate::register_form('booking2');



	$adult=intval($_REQUEST["adult"]);

	$children=intval($_REQUEST["children"]);

	$infant=intval($_REQUEST["infant"]);

	$origin=intval($_REQUEST["origin"]);

	$destination=intval($_REQUEST["destination"]);

	$departure_date=$_REQUEST["departure_date"];

	$returning_date=$_REQUEST["returning_date"];

	$class=intval($_REQUEST["class"]);

	$airline=intval($_REQUEST["airline"]);



		// Product

		$qprod=$db->query("SELECT * FROM ".$prefix."_product");

		$prod_opt=array();

		while(list($product_id,$product_name)=$db->fetch_array($qprod)){

			$prod_chkbox[$product_id]=$product_name;

		}





	$type=intval($_REQUEST["btype"]);

	 if(empty($_POST)) {

	 					$tpl->assign("lang",$lang);

	 					$tpl->assign("adult",$adult);

						$tpl->assign("children",$children);

						$tpl->assign("infant",$infant);

						$tpl->assign("origin",$origin);

						$tpl->assign("destination",$destination);

						$tpl->assign("departure_date",$departure_date);

						$tpl->assign("returning_date",$returning_date);

						$tpl->assign("type",$type);

						$tpl->assign("class",$class);

						$tpl->assign("airline",$airline);

						$tpl->assign("prod_chkbox",$prod_chkbox);

				   		$tpl->display('booking2.tpl');

	} else {

			   // validate after a POST

			   if(SmartyValidate::is_valid($_POST)) {

				   // no errors, done with SmartyValidate

					SmartyValidate::disconnect();

					$tpl->assign("lang",$lang);

					$adult=intval($_REQUEST["adult"]);

					$children=intval($_REQUEST["children"]);

					$infant=intval($_REQUEST["infant"]);

					$originx=intval($_REQUEST["origin"]);

					$destinationx=intval($_REQUEST["destination"]);

					$departure_date=$_REQUEST["departure_date"];

					$returning_date=$_REQUEST["returning_date"];

					$classx=intval($_REQUEST["class"]);

					$airlinex=intval($_REQUEST["airline"]);

					$btype=intval($_REQUEST["btype"]);

					$type=booking_type($btype);

					$origin= getrow("origin_name","".$prefix."_origin","origin_id","$originx");

					$destination= getrow("destination_name","".$prefix."_destination","destination_id","$destinationx");

					$class=getrow("class_name","".$prefix."_class","class_id","$classx");

					$airline=getrow("airline_name","".$prefix."_airline","airline_id","$airlinex");

					$product=$_REQUEST["product"];



					$fullname=$_POST["fullname"];

					$phonenumber=$_POST["phonenumber"];

					$mobilenumber=$_POST["mobilenumber"];



					$email=$_POST["email"];



					$adult_fname=$_POST["adult_fname"];

					$adult_lname=$_POST["adult_lname"];

					$adult_name=arraycombine($adult_fname,$adult_lname);



					$child_fname=$_POST["child_fname"];

					$child_lname=$_POST["child_lname"];

					$child_name=arraycombine($child_fname,$child_lname);



					$infant_fname=$_POST["infant_fname"];

					$infant_lname=$_POST["infant_lname"];

					$infant_name=arraycombine($infant_fname,$infant_lname);



					$total=count($adult_name) + count($child_name) + count($infant_name);





					$msg=$_POST["msg"];



					$message="";

					$message.="#$lang[booking_details]\n";

					$message.="--------------\n";

					$message.="$lang[origin]:$origin\n";

					$message.="$lang[destination]: $destination\n";

					$message.="$lang[departure_date]: $departure_date\n";

					$message.="$lang[returning_date]. $returning_date\n";

					$message.="$lang[airline]:$airline\n";

					$message.="$lang[fare_class]:$class\n";

					$message.="Type:$type\n";



					$message.="#$lang[customer_details]\n";

					$message.="------------------\n";

					$message.="$lang[full_name] : $fullname\n";

					$message.="$lang[phone_no] :$phonenumber\n";

					$message.="$lang[email]: $email\n";

					$message.="$lang[no_of_people]: $adult $lang[adult], $children $lang[children],$infant $lang[infant].\n\n";



					$message.="#$lang[traveler_details]\n";

					$message.="------------------\n";

					$message.="#$lang[adult]\n";

					$message.="---------------\n";



					foreach($adult_name as $value){

						$message.="$value \n";



					}

					$message.="\n";

					if(is_array($child_name) && !empty($children)>0){

						$message.="#$lang[children]\n";

						$message.="---------------\n";

						foreach($child_name as $value){

						$message.="$value\n ";



						}

					$message.="\n";



					}

					if(is_array($infant_name) && !empty($infant)){

						$message.="#$lang[infant]\n";

						$message.="---------------\n";

						foreach($infant_name as $value){

						$message.="$value\n ";



						}

					$message.="\n";

					}

					$message.="#$lang[additional_request]\n";

					$message.="--------------------\n";



					if(is_array($product)){

						foreach($product as $key=>$value){

							if(is_array($value)){

								foreach($value as $v){

									$prod=getrow("product_name","".$prefix."_product","product_id",$v);

									$message.="$prod\n";

								}

							}

						}



					}

					$message.="\n";

					$message.="#$lang[comments]\n";

					$message.="-----------------\n";

					$message.="$msg\n\n";

					$message.="-----------------\n";



					$save=$message;

					$time=time();

					if(!empty($returning_date)){

						$returning_date=unixDate($returning_date);

					}else{

						$returning_date="";

					}

					$db->query("INSERT INTO ".$prefix."_user_booking

					(user_booking_user,user_booking_origin,user_booking_destination,user_booking_departure_date,user_booking_arriving_date,

					user_booking_class,user_booking_airline,user_booking_type,user_booking_total_passenger,user_booking_date,user_booking_comment)

					values('$_SESSION[uid]',$originx,$destinationx,".unixDate($departure_date).",'',$classx,$airlinex,$btype,$total,$time,'$msg')");

					$bid=mysql_insert_id();

					if(is_array($adult_name)){

						insertPassenger($adult_name,$bid,1);

					}

					if(is_array($child_name)){

						insertPassenger($child_name,$bid,2);

					}

					if(is_array($infant_name)){

						insertPassenger($infant_name,$bid,3);

					}



					if(is_array($products)){

						insertProduct($product,$bid);

					}



					$message.="$config[site_title]\n$config[site_addr]\n$config[site_url]";

					sendmail($config[site_booking_email],"$lang[booking_request]",$message,"$fullname",$email);

					$tocustomer="";

					$tocustomer.="$lang[dear] $fullname\n$lang[booking_thankyou]\n\n";

					$tocustomer.="$message";

					sendmail($email,"$lang[booking_reply_subject]",$tocustomer,"$config[site_title]",$config[site_booking_email]);

					$tpl->display("success_booking_request.tpl");









			   } else {

				   // error, redraw the form

				   $tpl->assign("lang",$lang);

					$tpl->assign($_POST);

					$tpl->assign("prod_chkbox",$prod_chkbox);

				   $tpl->display('booking2.tpl');

			   }



	}

include("footer.php");

}





function insertPassenger($array,$bid,$type){

	global $db,$prefix;

	foreach($array as $value){

		$result=$db->query("INSERT INTO ".$prefix."_passenger(passenger_booking,passenger_name,passenger_type) values($bid,'$value',$type)");

	}



}





function insertProduct($product,$bid){

	global $db,$prefix;

	if(is_array($product) && !empty($product)){

		foreach($product as $value){

			$result=$db->query("INSERT INTO ".$prefix."_booking_product(booking_product_bid,booking_product_product) values($bid,'$value')");

		}

	}



}





switch($op){

	default:

	index();

	break;



	case"booking2":

	booking2();

	break;







}









?>

