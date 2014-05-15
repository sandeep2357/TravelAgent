<?php

//Fetch flight information auckland airport site


require_once("mainfile.php");
@$db->query("DELETE FROM ".$prefix."_flights");
 fetchflight("a");
 fetchflight("d");

function fetchflight($act){
	global $db,$prefix;
	$head=array("a"=>"International Arrivals","d"=>"International Departures");
	$info=$head[$act];

	$fd=fopen("http://www.auckland-airport.co.nz/flight_info.php?leg=$act&range=I","r");
	 $contents="";
	#$content="<form>
	#<Table width=\"100%\"><tr class=\"title\"><td><h2>$head[$act]</h2>Flight Information at auckland airport.</td><td align=\"right\">Please select option
	#<select name=\"act\"  onChange='OnChange(this.form.act,\"index.php?m=flightinformation&act=\");'>";


	#$content.="<option value=\"a\" $sel1>Arrivales</option>
	#<option value=\"d\" $sel2>Departure</option>
	#</select>
	#</td>
	#</tr>
	#</table>
	#<hr></form>";

	$content.="<h3>Information";
	$start = "<h3>Information";            // Start Grabbing Code
	$stop  = "</table>";                 // Stop Grabbing Code
	$page  = "news.txt";            //name of first cache file
	$page3 = "paglasoft.xml";
	$page4="ticker.txt";


	  while ($line=fgets($fd,2000))
	  {
		 $contents.=$line;
	  }
	  fclose ($fd);

	   // Isolates desired section.
	 if(eregi("$start(.*)$stop", $contents, $printing)) {
	   $substring=$printing[1];


	   // while is added as there are multiple instances of the </table> string & eregi
	   // searches to include the most that matches, not the next.
	  while(eregi("(.*)$stop", $substring, $printing)) {
		  $substring=$printing[1];
		};

	  } else {
		echo "Didn't find content";
	 }



	  // Replaces specific HTML tags and text
	$printing[1] = eregi_replace( "- .* records</b>", "", $printing[1] ); // Text
	$printing[1] = eregi_replace( "<img SRC=[^>]*>", "", $printing[1] );   // Images
	$printing[1] = eregi_replace( "<font[^>]*>", "", $printing[1] ); // Fonts
	$printing[1] = eregi_replace( "</font>", "", $printing[1] );
	#$printing[1] = eregi_replace( "<tr[^>]*>", "<tr>", $printing[1] ); // Table Codes
	#$printing[1] = eregi_replace( "<td[^>]*>", "<td>", $printing[1] );
	$printing[1] = eregi_replace( "<table[^>]*>", "<table width=100% border=0 cellpadding=2 cellspacing=2 bgcolor=\"orange\">", $printing[1] );

	#$printing[1] = eregi_replace( "</tr>", "</tr>", $printing[1] );
	#$printing[1] = eregi_replace( "</td>", "</td>", $printing[1] );
	$printing[1] = eregi_replace( "<li>", "", $printing[1] );
	$printing[1] = eregi_replace( "</li>", "\n", $printing[1] );
	$printing[1] = eregi_replace( "<b>", " ", $printing[1] );
	$printing[1] = eregi_replace( "</ul><br />", " ", $printing[1] );
	$printing[1] = eregi_replace( "class=\"boardrow\"", "class=\"flighttd\"", $printing[1] );
	$printing[1] = eregi_replace( "class=\"boardheadrow\"", "class=\"title\"", $printing[1] );



	$content.="$printing[1]";
	$content.="</table>
	</table>";

	$content=addslashes($content);

	@$db->query("INSERT INTO ".$prefix."_flights(flight_title,flight_action,flight_content)values('$info','$act','$content')");
}
?>