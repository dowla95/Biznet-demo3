<?php 
session_start();
include("../Connections/conn.php");
$_SESSION['id']=$_GET['id'];
echo "<div id='po' style='overflow:auto;text-align:center;color:black;z-index:1000;width:100%;float:left;'><div style='padding:5px;'>";
function generate_calendar($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){

	$first_of_month = gmmktime(0,0,0,$month,1,$year);

	#remember that mktime will automatically correct if invalid dates are entered

	# for instance, mktime(0,0,0,12,32,1997) will be the date for Jan 1, 1998

	# this provides a built in "rounding" feature to generate_calendar()
	$day_names = array(); #generate all the day names according to the current locale

	for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday

		$day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name



	list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));

	$weekday = ($weekday + 7 - $first_day - 1) % 7; #adjust for $first_day

	$title   = "<b>".htmlentities(ucfirst($month_name)).'&nbsp;'.$year."</b>";  #note that some locales don't capitalize month and day names



	#Begin calendar. Uses a real <caption>. See http://diveintomark.org/archives/2002/07/03

	@list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable

	if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';

	if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';

	$calendar = '<table class="calendar" cellpadding="2" cellspacing="3" style="color:rgba(148, 145, 145, 0.84);width:100%;">'."\n".

		'<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";



	if($day_name_length){ #if the day names should be shown ($day_name_length > 0)

		#if day_name_length is >3, the full name of the day will be printed

		foreach($day_names as $d){

	$d=str_replace("Sunday","Ponedeljak",$d);

    $d=str_replace("Monday","Utorak",$d);

    $d=str_replace("Tuesday","Sreda",$d);

    $d=str_replace("Wednesday","Cetvrtak",$d);

    $d=str_replace("Thursday","Petak",$d);

    $d=str_replace("Friday","Subota",$d);

    $d=str_replace("Saturday","Nedelja",$d); 

			$calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,3) : $d).'</th>';

				}

		$calendar .= "</tr>\n<tr>";



}

	if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days

	for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){

		if($weekday == 7){

			$weekday   = 0; #start a new week

			$calendar .= "</tr>\n<tr>";

		}

		if(isset($days[$day]) and is_array($days[$day])){

			@list($link, $classes, $content) = $days[$day];

			if(is_null($content))  $content  = $day;

			$calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').

				($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';

		}

		else {

   // if($_GET['id']==$day) $col="red"; else $col="blue";

 if($month<10)
   $mesi=str_replace(0,"",$month);
   else $mesi=$month;

$mesec="mesec".$mesi;


   $sql=@mysqli_query($conn, "SELECT * FROM zauzetost_soba  WHERE godina='$_GET[god]' AND $mesec LIKE '%<$day>%'  AND id_page=$_GET[cal]");

   $ss=@mysqli_fetch_array($sql);
$fa=@mysqli_query($conn, "SELECT * FROM proizvodi WHERE id='$ss[id_sobe]' AND akt='Y'   AND id_page=$_GET[cal]");
$fa1=@mysqli_num_rows($fa);
 if(@mysqli_num_rows($sql)==1 and $fa1==1){ 
	
	//pozadinska boja zauzetog termina
    $calendar .= "<td style='background:#b00;text-align:center;padding:2%;border:1px dotted #999;'>

    <a href='javascript:;' id='c-$_GET[cal]-$day'onclick = \"ds_sh2(this,'$day','$month',$year,$ss[id_sobe],$_GET[cal])\" class='link' >$day</a>

    </td>";

    }

 else
	//pozadinska boja slobodnog termina
   $calendar .= "<td style='background:#45B39E;text-align:center;padding:2%;color:#fff;border:1px dotted #999;'>$day</td>";    

  }

	}

	if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days



	return $calendar."</tr>\n</table>\n";

}



$year="2009";

$month=1;

$dd=date("Y");

$dm=date("m");

$year=$_GET[god];

$month=$_GET[mes];

$min=$dd-1;

$max=$dd+5;

//onchange="setMaxBuget(this.options[this.selectedIndex].value);" 

/*echo "<div style='float:left;width:100%px;height:10px;'>

<a href='javascript:void(0)' onclick=\"ds_sh1('','close','$month',$year,$_GET[id_sobe])\" style='border:0px;'>

<img src='$path1/panel/images/cancel.png'  border='0'></a>

</div>";*/
echo "<div style='margin:0 auto;width:70%;color:#0acc18;margin-top:10px;'>";
echo "<div style='display:table;width:100%;color:rgba(148, 145, 145, 0.84);'>";
echo "<div style='display:table-row;'>";
echo "<div style='display:table-cell;padding-left:4px;'>"; //ispis reci Godina

echo "Godina: <select onchange=\"ds_sh1('','','$month',this.options[this.selectedIndex].value,$_GET[id_sobe],$_GET[cal])\" name='god' style=''>";

for($gg=$min;$gg<$max; $gg++){

if($dd==$gg) $color="#2E77BC;"; else $color="black";

if($gg==$_GET[god]) $sel="SELECTED"; else $sel="";

echo "<option value='$gg' style='color:$color;' $sel>$gg</option>";

}

echo "</select>";

echo "</div>";

echo "<div style='display:table-cell;'>"; //ispis reci Mesec

$name_mes=array(" ","Januar","Februar","Mart","April","Maj","Jun","Jul","Avgust","Septembar","Oktobar","Novembar","Decembar");

echo "Mesec: <select onchange=\"ds_sh1('','',this.options[this.selectedIndex].value,$year,$_GET[id_sobe],$_GET[cal])\" name='mes' style=''>";

for($mm=1;$mm<13; $mm++){

if($dm==$mm) $color="#2E77BC;"; else $color="black";

if($mm==$_GET[mes]) $sel1="SELECTED"; else $sel1="";

echo "<option value='$mm' style='color:$color;' $sel1>$name_mes[$mm]</option>"; // boja fonta u ispisu meseca u izborniku

}

echo "</select>";

echo "</div></div></div>";

 

 // stil kalendara

echo generate_calendar($year, $month,'',2);

echo "<div style='margin:5px 3px;text-align:left;font-size:0.8em;color:rgba(148, 145, 145, 0.84);;float:left;font-weight:bold;padding-left:20px;'>";

echo "<span style='background:#45B39E;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Slobodni dani &nbsp;&nbsp;&nbsp;&nbsp;";

echo "<span style='background:#b00;'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> Rezervisani dani";

echo "</div>";
echo "</div>";
echo "</div>";

?>