<?PHP
putenv('TZ=EST-5');

$d=date("d");
$m=date("m");
$y=date("y");

$fd=fopen("http://www.auckland-airport.co.nz/flight_info.php?leg=A&range=I","r");
 $contents="";
$html=<<<HTML
<h3>Information last updated 11th Jun 2005 23:59</h3>		<table  cellspacing=0 cellpadding=2 border=0>

		<tr>
		<td align="LEFT">12 Jun 2005</td>
		<td align="CENTER" >International Arrivals</td>
		<td align="RIGHT">23:59</td>
		</tr>

		<tr><td colspan="3">
		<table  cellspacing="1" cellpadding="2" border="0">

		<tr>
		<td rowspan="2">&nbsp;</td>
		<td  rowspan="2">Flight</td>

		<td  colspan="2" width="130">Scheduled</td>

		<td width=180  rowspan="2">Origin</td>
		<td  rowspan="2">Arr.<br>Time&nbsp;&nbsp;</td>

		<td  rowspan="2">Remarks &nbsp;</td>
		</tr>
<tr><td  width="55">Date</td>
<td >Time</td>
HTML;
echo"$html";
$start = "Time</td>";            // Start Grabbing Code
$stop  = "</table>";                 // Stop Grabbing Code
$page  = "news.txt";            //name of first cache file
$page3 = "paglasoft.xml";
$page4="ticker.txt";


  while ($line=fgets($fd,2000))
  {
     $contents.=$line;
  }
  fclose ($fd);

 // echo"<font face=Boishakhi>".strip_tags($contents)."</font>";

//  exit;

   // Isolates desired section.
 if(eregi("$start(.*)$stop", $contents, $printing)) {
   $substring=$printing[1];


   // while is added as there are multiple instances of the </table> string & eregi
   // searches to include the most that matches, not the next.
  while(eregi("(.*)$stop", $substring, $printing)) {
      $substring=$printing[1];
    };

  } else {
    echo "Didn't find News";
 }



  // Replaces specific HTML tags and text
$printing[1] = eregi_replace( "- .* records</b>", "", $printing[1] ); // Text
$printing[1] = eregi_replace( "<img SRC=[^>]*>", "", $printing[1] );   // Images
$printing[1] = eregi_replace( "<font[^>]*>", "", $printing[1] ); // Fonts
$printing[1] = eregi_replace( "</font>", "", $printing[1] );
$printing[1] = eregi_replace( "<tr[^>]*>", "<tr>", $printing[1] ); // Table Codes
$printing[1] = eregi_replace( "<td[^>]*>", "<td>", $printing[1] );
$printing[1] = eregi_replace( "<table[^>]*>", "<table>", $printing[1] );

$printing[1] = eregi_replace( "</tr>", "</tr>", $printing[1] );
$printing[1] = eregi_replace( "</td>", "</td>", $printing[1] );
$printing[1] = eregi_replace( "<li>", "", $printing[1] );
$printing[1] = eregi_replace( "</li>", "\n", $printing[1] );
$printing[1] = eregi_replace( "<br>", " ", $printing[1] );
$printing[1] = eregi_replace( "</ul><br />", " ", $printing[1] );
$printing[1] = eregi_replace( "</ul>", " ", $printing[1] );

echo"$printing[1]";
echo"</table>
		</table>";

exit;



 //  Saves output to include file
$cartFile = fopen("$page","w");
fwrite($cartFile,$printing[1]);
fclose($cartFile);


// Create RDF format

  // What appears on the head of the RDF file.

$rdf1="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n<rss version=\"2.0\">\n<channel>\n";


  // Changes include formatting above almost to XML format

$rdf2 = eregi_replace( "<li>", "<item>", $printing[1] );
$rdf2 = eregi_replace( "<a href=\"", "<item>\n<link>", $rdf2 );
$rdf2 = eregi_replace( "\">", "</link></item><title>", $rdf2 );
$rdf2 = eregi_replace( "</a>", "</title>\n", $rdf2 );

  // Saves this to a cache file
$cartFile = fopen("$page","w");
fwrite($cartFile,$rdf2);
fclose($cartFile);

  // Opens cache file and line by line changes the format to be in proper XML format
$fd = fopen("$page", "r");
$rdf2a = "";       // Leave this blank

while ($buffer = fgets($fd, 4096)) {
  $buffer = eregi_replace( "(<link>.*</item>)(<title>.*</title>)", "\\2 \n \\1 \n", $buffer);
 $buffer = eregi_replace( "</link>", "</link>\n", $buffer );
 $rdf2a .= $buffer;
}
fclose($fd);

  // Closing the RDF & placing it together in a single variable
$rdf3 = "</channel>\n</rss>\n";
$rdf = $rdf1 . $rdf2a. $rdf3;

  // Writes above variable to a RDF file
$cartFile = fopen("$page3","w");
fwrite($cartFile,$rdf);
fclose($cartFile);



?>