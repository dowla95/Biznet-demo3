<?php 
//ini_set("display_errors", 1);
//error_reporting(E_ALL);
//include("../Connections/conn.php");
//include("../include/Izvrsenja.php");
$poslat_mail=0;
$diff=0;
$fdate = strtotime("+1 day", strtotime(date("Y-m-d")));
$cdate= date("Y-m-d");
//AND (datum>='$cdate' or datum<='$fdate')
$ari=mysqli_query($conn, "SELECT * FROM privremena WHERE status=0 AND poslat_email=0 AND proveren=0  ORDER BY id DESC LIMIT 1");
$ari1=@mysqli_fetch_array($ari);


if($ari1['id']>0)
{
/*$date1 = new DateTime($ari1['datum']);
$date2 = new DateTime($cdate);

$diff = $date2->diff($date1)->format("%a");*/
$diff =  (time()-$ari1['vreme'])/3600;
echo $diff;
if(strlen($ari1['trackid'])>3  and $diff>0.06)
{
$xml_str="<CC5Request>
            <Name>BizNet</Name>
            <Password>r32rAwr3</Password>
            <ClientId>13IN060589</ClientId>
             <OrderId>$ari1[trackid]</OrderId>
             <Extra>
    <ORDERSTATUS>QUERY</ORDERSTATUS>
  </Extra>
</CC5Request> ";
//$url="https://testsecurepay.eway2pay.com/fim/api";

$url="https://bib.eway2pay.com/fim/api";
$ch = curl_init($url);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
curl_setopt($ch, CURLOPT_POSTFIELDS, "$xml_str");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$output = curl_exec($ch);
//if(curl_errno($ch)) print curl_error($ch);
//else print_r($output);
curl_close($ch);
$xml=simplexml_load_string($output);
$ResCode= $xml->Response;
$TrckID= $xml->OrderId;
$ProcReturnCode= $xml->ProcReturnCode;
$extra=$xml->Extra;
$AutCode=$extra->AUTH_CODE;
$prvo=explode(".",$extra->AUTH_DTTM);
$PosDate=str_replace("-","",$prvo[0]);
$TransID=$extra->TRANS_ID;
$PayID=$TransID;
$mdStatus = $extra->MDSTATUS;

 function createRandom() {
    $chars = "abcdefghijkmnopqrstuvwxyz023456789";
    srand((double)microtime()*1000000);
    $i = 0;
    $pass = '' ;
    while ($i <= 7) {
        $num = rand() % 33;
        $tmp = substr($chars, $num, 1);
        $pass = $pass . $tmp;
        $i++;
    }
    return $pass;
}
  function zabeleziNarudzbinuUBazuK() {
global $PayID;
global $TransID;
global $ResCode;
global $AutCode;
global $PosDate;
global $TrckID;
global $mdStatus;
global $conn;

$pri=mysqli_query($conn, "SELECT * FROM privremena WHERE trackid='$TrckID'");
$pri1=@mysqli_fetch_array($pri);

$ukupno_rsd = $pri1['iznos'];

if($pri1['id']>0)
{
if(!mysqli_query($conn, "INSERT INTO porudzbine SET user_id=$pri1[usid], ime=".safe($pri1['ime']).", adresa=".safe($pri1['adresa']).", posta=".safe($posta).", grad=".safe($pri1['grad']).", telefon=".safe($pri1['telefon']).", email=".safe($pri1['mejl']).", pib=".safe($pri1['pib']).", nacin_placanja=4, poruka=".safe($pri1['poruka']).", nacin_isporuke=".safe($pri1['nacin_kupovine']).", iznos=".safe($pri1['iznos']).", iznos_sa_kodom=".safe($pri1['iznos_sa_kodom']).", idpromo=".safe($pri1['idpromo']).", vreme='".time()."'"))
	    return false;


 $narudzbine_id = mysqli_insert_id($conn);
if($narudzbine_id>0){
$prK=mysqli_query($conn, "SELECT * FROM promo_kodovi WHERE id='$pri1[idpromo]'");
$prK1=@mysqli_fetch_array($prK);
if($pri1['idpromo']>0)
mysqli_query($conn, "UPDATE promo_kodovi SET iskoriscen=iskoriscen+1 WHERE id=$pri1[idpromo]");
unset($_SESSION[$sid]);
unset($_SESSION['promo-kod']);
unset($_SESSION['izf']);
}

$ri=mysqli_query($conn, "SELECT * FROM privremena_pro WHERE trackid='$TrckID'");
while($v=@mysqli_fetch_array($ri))
{
$k=$v['idpro'];


mysqli_query($conn, "INSERT INTO poruceno SET id_porudzbine=$narudzbine_id, id_pro=$k, naziv=".safe($v['naslov']).", cena='".$v['cena']."', kolicina=$v[kolicina]");

	  }

	  return $narudzbine_id;
    }else return false;
	}

function korpaZaMejliPrikaz($tipa, $br_narudzbine) {
global $PayID;
global $TransID;
global $ResCode;
global $AutCode;
global $PosDate;
global $TrckID;
global $mdStatus;
global $ProcReturnCode;
global $conn;


$pri=mysqli_query($conn, "SELECT * FROM privremena WHERE trackid='$TrckID'");
$pri1=@mysqli_fetch_array($pri);

	  $korpa = '
	    <table cellpadding="1" cellspacing="1" width="100%" style="background:#ccc;font-family:arial;">
		  <tr>
		    <th width="65%" align="left" style="background:#eee; padding:3px 5px 3px 5px">Proizvod</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Cena</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Količina</th>
		    <th width="15%" style="background:#eee; padding:3px 5px 3px 5px">Ukupna cena</th>
		  </tr>
	  ';

    $ukupno_rsd = 0;

	  $ri=mysqli_query($conn, "SELECT * FROM privremena_pro WHERE trackid='$TrckID'");

while($v=@mysqli_fetch_array($ri))
{
$k=$v['idpro'];


        $moneta = 'rsd';
		    $ukupno_rsd = $v['cena'] * $v['kolicina'];


      $plus = '<br /> + <br />';

		$korpa .= '
		  <tr>
		    <td width="65%" align="left" style="background:#fff; padding:3px 5px 3px 5px">'.$v['naziv'].'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format($v['cena'], 2, ',', '.').'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.$v['kolicina'].'</td>
		    <td width="15%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format(($v['cena'] * $v['kolicina']), 2, ',', '.').' '.$moneta.'</td>
		  </tr>
		';

      }

$ukupno_sve=$ukupno_rsd=$pri1['ukupnosve'];

if ($ukupno_sve > 3000) $dost="Dostava je betplatna"; else $dost="Dostava je po cenovniku Post Ekspres službe i plaća se prilikom preuzimanja pošiljke.";
     $korpa .= '
	      <tr>
			<td width="100%" colspan="5" style="background:#fff; padding:3px 5px 3px 5px">'.$dost.'</td>
          </td>
          </tr>';







          $korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Ukupno za naplatu</td>
	        <td width="15%" align="center"  style="background:#cccccc; padding:3px 5px 3px 5px">';
          if($pri1['idpromo']>0){
 $korpa .= '<span style="color:#CC0000;"><b><i style="font-size:11px;">'.number_format($ukupno_sve, 2, ',', '.')." rsd";

   $korpa .="</i><br>cena sa promo kodom: ".number_format($pri1['iznos_sa_kodom'], 2, ',', '.')." rsd";
    $korpa .='</b></span>';
          }
          else
    $korpa .= '<span style="color:#CC0000;"><b>'.number_format($ukupno_sve, 2, ',', '.').' rsd</b></span>';

          $korpa .= '</td>
          </tr>';

  $porez=number_format(round($ukupno_sve-($ukupno_sve/1.2),2), 2, ',', '.');
    $korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Porez obračunat u cenu placanja</td>
	        <td width="15%" align="center"  style="background:#ffffff; padding:3px 5px 3px 5px">
    '.$porez.' rsd
          </td>
          </tr>';
        $korpa .='</table>';



  $korpa .="<br /><table style='width:100%;background:#ccc;' cellspacing='1' cellpadding='1'>";

$korpa .="<tr>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Detalji transakcije</b></th>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci kupca</b></th>
<th width='30%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci firme</b></th></tr>";

$korpa .="<tr>";
$PosD=explode(" ",$PosDate);
  $PostD1=$PosD[0];
$y=substr($PostD1,0,4);
$m=substr($PostD1,4,2);
$d=substr($PostD1,6,2);
$datum_transakcije="$d-$m-$y $PosD[1]";
$korpa .='<td style="background:white;" valign="top"><table style="width:100%;">
   ';

$korpa .='
    <tr>
      <td width="40%">Način plaćanja:<br>
       Platna kartica</td>
    </tr>
     <tr>
      <td width="40%">Način isporuke:<br>'.$pri1["nacin_kupovine"].'</td>
    </tr>
     <tr>
      <td>Datum transakcije:<br>';
    if($pri1["transactionid"]!="")
    $korpa .=$datum_transakcije;

    $korpa .='</td></tr>
    <tr>
      <td>Iznos:<br>';
      if($pri1['idpromo']>0)
      $korpa .=number_format(round($pri1['iznos_sa_kodom'],2), 2, ',', '.');
      else
      $korpa .=number_format(round($ukupno_sve,2), 2, ',', '.');

      $korpa .=' rsd</td>
    </tr>

  <tr>
      <td width="40%">Broj narudzbine:<br>'.strip_tags($pri1["trackid"]).' (<b>'.$br_narudzbine.'</b>)</td>
    </tr>

    <tr>
      <td>Autorizacioni kod:<br>'.strip_tags($AutCode).'</td>
    </tr>
<tr>
      <td>Status transakcije:<br>'.strip_tags($ResCode).'</td>
    </tr>
    <tr>
      <td>Kod statusa transakcije:<br>'.strip_tags($ProcReturnCode).'</td>
    </tr>
    <tr>
      <td>Broj transakcije:<br>'.strip_tags($TransID).'</td>
    </tr>

    <tr>
      <td>Statusni kod 3D transakcije:<br>'.strip_tags($mdStatus).'</td>
    </tr>
  </table></td>';

  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">

    <tr>
      <td width="40%">Ime i prezime:<br>'.$pri1['ime'].'</td>

    </tr>
    <tr>
      <td>Grad, pošt. broj:<br>'.$pri1["grad"].'</td>

    </tr>
    <tr>
      <td>Adresa:<br>'.$pri1['adresa'].'</td>

    </tr>
    <tr>
      <td>Telefon:<br>'.$pri1['telefon'].'</td>

    </tr>

    <tr>
      <td>Email:<br>'.$pri1['mejl'].'</td>

    </tr>';
    if($pri1['pib']>0)
$korpa .=' <tr><td>PIB:<br>'.$pri1['pib'].'</td></tr>';
  $korpa .='</table></td>';

  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">

  <tr>
      <td width="40%">Ime i prezime</td>
      <td>'.$pri1['ime'].'</td>
    </tr>
    <tr>
      <td>Grad, pošt. broj</td>
      <td>'.$pri1["grad"].'</td>
    </tr>
    <tr>
      <td>Adresa</td>
    <td>'.$pri1['adresa'].'</td>
    </tr>
    <tr>
      <td>Telefon</td>
      <td>'.$pri1['telefon'].'</td>
    </tr>

    <tr>
      <td>Email</td>
     <td>'.$pri1['mejl'].'</td>
    </tr>';
    if($pri1['pib']>0)
$korpa .=' <tr><td>PIB:<br>'.$pri1['pib'].'</td></tr>';
  $korpa .='</table></td>';


$korpa .="</tr>";

        $korpa .="</table>";

	  return $korpa;
	}


 		function korpaZaMejliPrikazNO() {
    global $PayID;
global $TransID;
global $ResCode;
global $AutCode;
global $PosDate;
global $TrckID;
global $conn;

   // mail("aleksandrou@gmail.com", "naslov", "poruka poruka");
	  $korpa = '
	    <table cellpadding="1" cellspacing="1" width="100%" style="background:#ccc;">
		  <tr>
		    <th width="65%" align="left" style="background:#eee; padding:3px 5px 3px 5px">Proizvod</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Cena</th>
		    <th width="10%" style="background:#eee; padding:3px 5px 3px 5px">Količina</th>
		    <th width="15%" style="background:#eee; padding:3px 5px 3px 5px">Ukupna cena</th>
		  </tr>
	  ';

    $ukupno_rsd = 0;

 $ri=mysqli_query($conn, "SELECT * FROM privremena_pro WHERE trackid='$TrckID'");
while($v=@mysqli_fetch_array($ri))
{
$k=$v['idpro'];


        $moneta = 'rsd';
		    $ukupno_rsd = $v['cena'] * $v['kolicina'];


      $plus = '<br /> + <br />';

		$korpa .= '
		  <tr>
		    <td width="65%" align="left" style="background:#fff; padding:3px 5px 3px 5px">'.$v['naziv'].' / '.$v['grupa'].'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format($v['cena'], 2, ',', '.').'</td>
		    <td width="10%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.$v['kolicina'].'</td>
		    <td width="15%" align="center" style="background:#fff; padding:3px 5px 3px 5px">'.number_format(($v['cena'] * $v['kolicina']), 2, ',', '.').' '.$moneta.'</td>
		  </tr>
		';

      }
$ukupno_sve=$ukupno_rsd=$pri1['ukupnosve'];

/*if ($ukupno_sve > 3000) $dost="Dostava je betplatna"; else $dost="Dostava je po cenovniku Post Ekspres službe i plaća se prilikom preuzimanja pošiljke.";
     $korpa .= '
	      <tr>
			<td width="100%" colspan="5" style="background:#fff; padding:3px 5px 3px 5px">'.$dost.'</td>
          </td>
          </tr>';*/







          $korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Ukupno za naplatu</td>
	        <td width="15%" align="center"  style="background:#cccccc; padding:3px 5px 3px 5px">';
          if($pri1['idpromo']>0){
 $korpa .= '<span style="color:#CC0000;"><b><i style="font-size:11px;">'.number_format($ukupno_sve, 2, ',', '.')." rsd";

   $korpa .="</i><br>cena sa promo kodom: ".number_format($pri1['iznos_sa_kodom'], 2, ',', '.')." rsd";
    $korpa .='</b></span>';
          }
          else
    $korpa .= '<span style="color:#CC0000;"><b>'.number_format($ukupno_sve, 2, ',', '.').' rsd</b></span>';

          $korpa .= '</td>
          </tr>';

  $porez=number_format(round($ukupno_sve-($ukupno_sve/1.2),2), 2, ',', '.');
    $korpa .= '
	      <tr>
	        <td width="85%" colspan="3" style="background:#fff; padding:3px 5px 3px 5px">Porez obračunat u cenu placanja</td>
	        <td width="15%" align="center"  style="background:#ffffff; padding:3px 5px 3px 5px">
    '.$porez.' rsd
          </td>
          </tr>';
        $korpa .='</table>';


  $korpa .="<br /><table style='width:100%;background:#ccc;' cellspacing='1' cellpadding='1'>";

$korpa .="<tr>

<th width='49%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci kupca</b></th>
<th width='49%' style='background:#eee; padding:3px 5px 3px 5px'><b>Podaci firme</b></th></tr>";

$korpa .="<tr>";
$datum_transakcije=substr(strip_tags($PosDate), -2)."-".substr(strip_tags($PosDate), 0, 2)."-".date("Y").".";


  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">

    <tr>
      <td width="40%">Ime i prezime</td>
      <td>'.$pri1['ime'].'</td>
    </tr>
    <tr>
      <td>Grad, pošt. broj</td>
      <td>'.$pri1["grad"].'</td>
    </tr>
    <tr>
      <td>Adresa</td>
    <td>'.$pri1['adresa'].'</td>
    </tr>
    <tr>
      <td>Telefon</td>
      <td>'.$pri1['telefon'].'</td>
    </tr>

    <tr>
      <td>Email</td>
     <td>'.$pri1['mejl'].'</td>
    </tr>

  </table></td>';

  $korpa .='<td style="background:white;" valign="top"><table style="width:100%;">

    <tr>
      <td width="40%">Naziv firme:<br>BizNet doo Beograd</td>

    </tr>
    <tr>
      <td>Adresa:<br>Beograd-Zvezdara, Golubačka 1</td>

    </tr>
    <tr>
      <td>PIB:<br>105170964</td>

    </tr>
    <tr>
      <td>Telefon:<br>011/20-80-555</td>

    </tr>
    <tr>
      <td>E-mail:<br>office@biznet.rs</td>

    </tr>
    <tr>
      <td>Web:<br><a href="https://www.biznet.rs">www.biznet.rs</a></td>

    </tr>
  </table></td>';


$korpa .="</tr>";

        $korpa .="</table>";

	  return $korpa;
	}
	function posaljiK($tip,  $namail) {
     global $PayID;
global $TransID;
global $ResCode;
global $AutCode;
global $PosDate;
global $TrckID;
global $poslat_mail;
global $from_email;
global $from_name;
global $settings;
global $conn;

    if($PayID>0)
    {
$pri=mysqli_query($conn, "SELECT * FROM privremena WHERE trackid='$TrckID'");
$pri1=mysqli_fetch_array($pri);

    }
    if($tip=="uspeh")
    {
    $usp="USPESNA TRANSAKCIJA";
    }else
    {
    $usp="NEUSPESNA TRANSAKCIJA";
    }
	  $naslov = $usp.' - narudzbina na sajtu BizNet ['.date("H:i:s d/m/Y").']';



      $novi_kod="";
      $poruka ="";
      if($tip=="uspeh")
     $poruka .="<br />";

 if($tip=="uspeh")
  $br_narudzbine = zabeleziNarudzbinuUBazuK();
      else
    $br_narudzbine=$TrckID;

      $poruka .= '<b style="color: #9C161D">'.$usp.'</b> - Narudžbinu <span style="black">broj: '.$br_narudzbine.'</span> je izvršio <b style="color: #9C161D">'.$pri1['ime'].'</b>, ';
      $poruka .= 'vreme <b>'.date("H:i:s d/m/Y")."</b><br /><br />";
     if($namail>0)
      $poruka .= korpaZaMejliPrikaz($namail, $br_narudzbine);
      else
      $poruka .= korpaZaMejliPrikazNO();
  if(!empty($pri1['poruka']))
        $poruka .= '<br /><b>Ostavio je i poruku: </b><div style="width:100%; border: 1px solid #cccccc; background: #f1f1f1"><p style="margin: 5px 0px 10px 0px; padding: 5px 5px 5px 5px;">'.$pri1['poruka']."</p></div>";

         $poruka .="<br />".sprintf($rzi1['tekst'],$novi_kod);

    //  $mejlovi = $GLOBALS['narudzbina_mejlovi'];
	 //if(in_array($pri1['mejl'], $GLOBALS['narudzbina_odbaci_mejlovi'])) {
	   // unset($mejlovi);
		//$mejlovi = array($pri1['mejl']);
	  //}

 $poruka_sid=session_id();







  if($br_narudzbine!="")
  {





$aaa1="";
$from_name="BizNet.rs";
$from_email="office@biznet.rs";

send_email("mail", $pri1['mejl'], $from_email, $pri1['mejl'], $naslov, $from_name, $poruka, $aaa1);

//if($tip=="uspeh" and $br_narudzbine>0)
send_email("mail", $from_email, $from_email, $pri1['mejl'], $naslov, $from_name, $poruka, $aaa1);





    }

	}


if ($ResCode=="Approved" and $AutCode!="")
{
$imko=mysqli_query($conn, "SELECT * FROM privremena  WHERE trackid='$TrckID'");
$imko1=mysqli_fetch_assoc($imko);
if($imko1['id']>0) {
echo 1;
mysqli_query($conn, "UPDATE privremena SET payamentid='$PayID', transactionid='$TransID', status=$mdStatus, ProcReturnCode=".safe($ProcReturnCode).", auth='$AutCode', resultcode='$ResCode', trantype='PreAuth', postdate='$PosDate', poslat_email='1', proveren=1  WHERE trackid='$TrckID'");
}
}
elseif($ResCode!="" and $TransID!="")
{
$imko=mysqli_query($conn, "SELECT * FROM privremena  WHERE trackid='$ari1[trackid]'");
$imko1=mysqli_fetch_assoc($imko);
if($imko1['id']>0) {

mysqli_query($conn, "UPDATE privremena SET status=0,  poslat_email='1', proveren=1  WHERE trackid='$ari1[trackid]'");
}
}
elseif($diff>0.06 and $ari1['proveren']==0) {
$imko=mysqli_query($conn, "SELECT * FROM privremena  WHERE trackid='$ari1[trackid]'");
$imko1=mysqli_fetch_assoc($imko);
if($imko1['id']>0) {
mysqli_query($conn, "UPDATE privremena SET status=0,  poslat_email='0', proveren=1  WHERE trackid='$ari1[trackid]' AND proveren=0");

}
}

 if($PayID!="")
{

}
elseif($diff>1 and $ari1['proveren']==0)
{

}
}
}

?>
