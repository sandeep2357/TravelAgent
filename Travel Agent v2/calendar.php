<script language="javascript">

var thisPage	= "calendar.php";
var formName	= "<?php echo"$_GET[formName]"; ?>";
var field_name	= "begin_date";

monthsNames = Array( "", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December" );

var tempString	= location.search.substring( 1 );
if ( tempString.indexOf( "&" ) != -1 ) {
	var temp1		= tempString.split( "&" );
	var strField	= temp1[ 0 ];
	var temp2		= temp1[ 1 ];
	var strData		= temp2.split( "," );
} else {
	var strField	= tempString;
	var strData		= tempString.split( "," );
}

var strMonth	= parseInt( strData[ 0 ], 10 );
var strYear		= parseInt( strData[ 1 ], 10 );

var dateObject	= new Date();
var thisMonth	= dateObject.getMonth();
var thisYear	= dateObject.getFullYear();
var curMonth	= dateObject.getMonth();
var curDay		= dateObject.getDate();
var curYear		= dateObject.getFullYear();

if (( strMonth > 0 ) || ( strYear > 0 )) {
	curMonth	= strMonth;
	curYear		= strYear;
}

var today		= new Date( curYear, curMonth, 1 );
var today		= today.getDay();


function daysPerMonth( month, year ) {
	days = 31;
	if (( month == 4 )||( month == 6 )||( month == 9 )||( month == 11 )) {
		days = 30;
	} else if ( month == 2 ) {
		if (((( year % 100 ) == 0 ) && (( year % 400 ) == 0 )) || ((( year % 100 )!=0 ) && (( year % 4 ) == 0 ))) {
			days = 29;
		} else {
			days = 28;
		}
	}
	return days;
}


function monthBack( month, year ) {
	if ( month == 0 ) {
		location.href = thisPage + "?" + strField + "&" + 11 + "," + ( year - 1 ) + "&"+"formName="+ formName;
	} else {
		location.href = thisPage + "?" + strField + "&"  + ( month - 1 ) + "," + year+ "&" +"formName="+ formName;
	}
}

function monthForward( month, year ) {
	if ( month == 11 ) {
		location.href = thisPage + "?" + strField + "&" + "0" + "," + ( year + 1 ) + "&"+"formName="+ formName;
	} else {
		location.href = thisPage + "?" + strField + "&" + ( month + 1 ) + "," + year + "&"+"formName="+ formName;
	}
}

function yearBack( month, year ) {
	location.href = thisPage + "?" + strField + "&" + ( month ) + "," + ( year - 1 )+ "&" +"formName="+ formName;
}

function yearForward( month, year ) {
	location.href = thisPage + "?" + strField + "&" + ( month ) + "," + ( year + 1 ) + "&"+"formName="+ formName;
}


function getYear( year ) {
	retval = new String( year );
	retval = retval.slice( 2, 4 );
	return retval;
}

function getMonth( month ) {
	month++;
	retval = new String( month );
	if ( retval < 10 ) {
		retval = "0" + retval;
	}
	return retval;
}

function getDay( day ) {
	retval = new String( day );
	if ( retval < 10 ) {
		retval = "0" + retval;
	}
	return retval;
}

function createCSS() {
	var cssStyle = "";
	cssStyle = cssStyle + "";
	cssStyle = cssStyle + "<style type=text/css>";
	cssStyle = cssStyle + "A:link { COLOR:#101010;TEXT-DECORATION:none; }";
	cssStyle = cssStyle + "A:visited { COLOR:#101010;TEXT-DECORATION:none; }";
	cssStyle = cssStyle + "A:active { COLOR:#101010;TEXT-DECORATION:none; }";
	cssStyle = cssStyle + "A:hover { COLOR: #101010;TEXT-DECORATION:none; }";
	cssStyle = cssStyle + ".Numeric { FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:10px;LINE-HEIGHT:16px; }";
	cssStyle = cssStyle + ".DaysLabel { FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:11px;LINE-HEIGHT:16px;COLOR:#FF0000; }";
	cssStyle = cssStyle + ".TextLabel { FONT-FAMILY:Verdana,Arial,Helvetica;FONT-SIZE:12px;LINE-HEIGHT:16px; }";
	cssStyle = cssStyle + "</style>\r\n";
	return cssStyle;
}

function createDaysTable() {
	var daysTable = "";
	daysTable = daysTable + "<table width=80% cellpadding=0 cellspacing=0 border=1>\r\n";
	daysTable = daysTable + "	<tr>\r\n";
	daysTable = daysTable + "		<td align=center>\r\n";
	daysTable = daysTable + "			<table width=100% cellpadding=2 cellspacing=0 border=0>\r\n";
	daysTable = daysTable + "				<tr>\r\n";
	daysTable = daysTable + "					<td align=left><span class=TextLabel><a href='javascript:monthBack(" + curMonth + "," + curYear + ")'><<</a>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "					<td align=center><span class=TextLabel><b>" + monthsNames[ curMonth + 1 ] + "</b>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=TextLabel><a href='javascript:monthForward(" + curMonth + "," + curYear + ")'>>></a>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "				</tr>\r\n";
	daysTable = daysTable + "			</table>\r\n";
	daysTable = daysTable + "		</td>\r\n";
	daysTable = daysTable + "	</tr>\r\n";
	daysTable = daysTable + "	<tr>\r\n";
	daysTable = daysTable + "		<td align=center>\r\n";
	daysTable = daysTable + "			<table width=100% cellpadding=2 cellspacing=0 border=0>\r\n";
	daysTable = daysTable + "				<tr>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>S&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>M&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>T&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>W&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>T&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>F&nbsp;</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=DaysLabel>S&nbsp;</td>\r\n";
	daysTable = daysTable + "				</tr>\r\n";
	daysTable = daysTable + "				<tr>\r\n";

	var dayCounter	= 1;

	for ( x=0; x<today; x++ ) {
		daysTable = daysTable + "					<td></td>\r\n";
	}

	for ( x=today; x<7; x++ ) {
		var selected = "";
		var strDate = getDay( dayCounter ) + "/" + getMonth( curMonth ) + "/"  + getYear( curYear );

		if (( dayCounter == curDay ) && ( curMonth == thisMonth ) && ( thisYear == curYear )) {
			selected = "<b>";
		}

		daysTable = daysTable + "					<td align='center'><font face=Verdana size=1><a href='#' onclick='window.opener.document." + formName + "." + strField + ".value=\"" + strDate + "\"; self.close();'>" + selected + "" + dayCounter + "</a></b></td>\r\n";
		dayCounter = dayCounter + 1;
	}

	for ( y=1; y<6; y++ ) {
		daysTable = daysTable + "				</tr>\r\n";
		daysTable = daysTable + "				<tr>\r\n";

		for ( z=0; z<7; z++ ) {
			var selected = "";
			var strDate = getDay( dayCounter ) + "/" + getMonth( curMonth ) + "/"  + getYear( curYear );

			if ( dayCounter >= daysPerMonth( curMonth + 1, curYear )) {
				var z=7;
				var y=5;
			}

			if (( dayCounter == curDay ) && ( curMonth == thisMonth ) && ( thisYear == curYear )) {
				selected = "<b>";
			}

			daysTable = daysTable + "					<td align=center><span class=Numeric><a href=# onclick='window.opener.document." + formName + "." + strField + ".value=\"" + strDate + "\"; self.close();'>" + selected + "" + dayCounter + "</a></b></td>\r\n";
			dayCounter = dayCounter + 1;
		}
		daysTable = daysTable + "				</tr>\r\n";
	}
	daysTable = daysTable + "			</table>\r\n";
	daysTable = daysTable + "		</td>\r\n";
	daysTable = daysTable + "	</tr>\r\n";
	daysTable = daysTable + "	<tr>\r\n";
	daysTable = daysTable + "		<td align=center>\r\n";
	daysTable = daysTable + "			<table width=100% cellpadding=2 cellspacing=0 border=0>\r\n";
	daysTable = daysTable + "				<tr>\r\n";
	daysTable = daysTable + "					<td align=left><span class=TextLabel><a href='javascript:yearBack(" + curMonth + "," + curYear + ")'><<</a>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "					<td align=center><span class=TextLabel><b>" + curYear + "</b>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "					<td align=right><span class=TextLabel><a href='javascript:yearForward(" + curMonth + "," + curYear + ")'>>></a>\r\n";
	daysTable = daysTable + "					</td>\r\n";
	daysTable = daysTable + "				</tr>\r\n";
	daysTable = daysTable + "			</table>\r\n";
	daysTable = daysTable + "		</td>\r\n";
	daysTable = daysTable + "	</tr>\r\n";
	daysTable = daysTable + "</table>\r\n";
	return daysTable;
}


var htmlBody = "";
htmlBody = htmlBody + "<html><head><title>DATE PICKER</title></head>\r\n";
htmlBody = htmlBody + "<body bgcolor=#EAF6FF text=#000000>\r\n";
htmlBody = htmlBody + "<div align=center>\r\n";
htmlBody = htmlBody + createCSS();
htmlBody = htmlBody + createDaysTable();
document.write( htmlBody );
</script>
</head>


