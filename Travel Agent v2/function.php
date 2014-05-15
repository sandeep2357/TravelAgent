<?php
function getvarint($varname) {
$default='';
    if(empty($_GET[$varname])) return $default;
    	if(!is_numeric($_GET[$varname]))
    	 {
    	 message_die("Invalid id  number");
    	 return 0;
    	 }
        return (int)$_GET[$varname];
}

function postvarint($varname) {
$default='';
    if(empty($_POST[$varname])) return $default;
    	if(!is_numeric($_POST[$varname]))    	 {
    	die("Invalid id  number");
    	 return 0;
    	 }
        return (int)$_POST[$varname];
}
function getvar($varname) {
	$default='';
    if(empty($_GET[$varname])) return $default;
        return addslashes($_GET[$varname]);
}

function postvar($varname) {
	$default='';
    if(empty($_POST[$varname])) return $default;
        return addslashes($_POST[$varname]);
}



function makepagelink($link, $page, $pages){
 $page_link = "<b>(";
 if($page!=1) $page_link .= "&nbsp;&nbsp;<a href=\"$link&page=1\">&laquo;</a>&nbsp;&nbsp;<a href=\"$link&page=".($page-1)."\">‹</a>";
 if($page>=6) $page_link .= "&nbsp;&nbsp;<a href=\"$link&page=".($page-5)."\">...</a>";
 if($page+4>=$pages) $pagex=$pages;
 else $pagex=$page+4;
 for($i=$page-4 ; $i<=$pagex ; $i++) {
 if($i<=0) $i=1;
 if($i==$page) $page_link .= "&nbsp;&nbsp;$i";
 else $page_link .= "&nbsp;&nbsp;<a href=\"$link&page=$i\">$i</a>";
 }
 if(($pages-$page)>=5) $page_link .= "&nbsp;&nbsp;<a href=\"$link&page=".($page+5)."\">...</a>";
 if($page!=$pages) $page_link .= "&nbsp;&nbsp;<a href=\"$link&page=".($page+1)."\">›</a>&nbsp;&nbsp;<a href=\"$link&page=".$pages."\">&raquo;</a>";
 $page_link .= "&nbsp;&nbsp;)</b>";

 return $page_link;

}

function create_thumb($img="",$dir="",$thumb_w="",$thumb_h=""){
	if(empty($thumb_h)){
		$new_thumb ="$img";
	}else{
		$new_thumb ="thumb_$img";
	}
	if (!file_exists("$dir/$img")){
 		die("logo does not exist");
 	exit;
	}
	$ext = explode('.', $img);
	$ext = $ext[count($ext)-1];
	if (strtolower($ext)=="jpg"){
		$src_img = ImageCreateFromJPEG($dir.$img);
	}elseif(strtolower($ext)== "gif"){
		$src_img=ImageCreateFromgif($dir.$img);
	}else{
		die("Invalid picture format");
	}

	$org_h = imagesy($src_img);
	$org_w = imagesx($src_img);

	if(empty($thumb_h)){
		$thumb_h = floor($thumb_w * $org_h / $org_w);
	}else{
		$thumb_h=$thumb_h;
	}
	$dst_img = ImageCreateTrueColor($thumb_w,$thumb_h);
	ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $org_w, $org_h);
	ImageJPEG($dst_img, "$dir/$new_thumb");
	imageDestroy($src_img);

}

//Sendmail function customize function of mail()
 function sendemail($to,$subject,$message,$sender,$from) {
 	$mailheaders="From:$from<$sender>\n";
 	$mailheaders.="Reply-To: $sender\n\n";
 	mail($to, $subject, $message, $mailheaders);
}

//Send newsletter


function newsletter_send($title, $content,$test="",$ad1,$ad2,$ad3) {
    global $db,$config,$prefix;
    $from = $config[site_contact_email];
    $subject = "Newsletter: ".stripslashes($title)."";
    $content = stripslashes($content);
    $tpl=new Template();
   if($test==1){
          $xheaders = "From: " . $config[site_title] . " <" . $config[site_contact_email] . ">\n";
           $xheaders .= "X-Sender: <" . $config[site_contact_email]. ">\n";
           $xheaders .= "X-Mailer: PHP\n"; // mailer
           $xheaders .= "X-Priority: 6\n"; // Urgent message!
           $xheaders .= "Content-Type: text/html;charset=iso-8859-1\n"; // Mime type
			$tpl->assign("ad1",$ad1);
			$tpl->assign("ad2",$ad2);
			$tpl->assign("ad3",$ad3);
			$tpl->assign("user",$name);
			$tpl->assign("content",$content);
			$output=$tpl->fetch("newsletter.tpl");

           mail("$config[site_contact_email]","TEST $subject","$output",$xheaders);

   }elseif($test==0){
   			    $result = $db->query("select user_email,user_name from ".$prefix."_newsletter_user");

      		while(list($email,$name) = $db->fetch_row($result, $dbi)) {
    		$xheaders = "From: " . $config[site_title] . " <" . $config[site_contact_email] . ">\n";
        	$xheaders .= "X-Sender: <" . $config[site_contact_email]. ">\n";
        	$xheaders .= "X-Mailer: PHP\n"; // mailer
        	$xheaders .= "X-Priority: 6\n"; // Urgent message!
        	$xheaders .= "Content-Type: text/html;charset=iso-8859-1\n"; // Mime type
        	$tpl->assign("ad1",$ad1);
        	$tpl->assign("ad2",$ad2);
        	$tpl->assign("ad3",$ad3);
			$tpl->assign("user",$name);
			$tpl->assign("content",$content);
			$output=$tpl->fetch("newsletter.tpl");
	      	mail("$email","$subject","$output",$xheaders);
    	}
   }else{
   			die("Newsletter couldn't send. Please contact $config[site_contact_email]");

   }

   //Header("Location: admin.php?op=newsletter_sent");
}

?>