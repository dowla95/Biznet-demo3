<?php 
if(isset($_POST['hashe']) and $_POST['hashe']!="")
{
$arr=array();
$hash=str_replace("#","",$_POST['hashe']);
parse_str($hash, $hashA);
unset($hashA[0]);
 
 
}

$hashAP=$hashA;

$flista .='
                 
        
         <div class="brands_products"><!--brands_products-->
							<h2>'.$arrwords['paket2'].'</h2>
							<div class="brands-name">
								<ul class="user_option">';
                
                
$tz = mysql_query("SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.nivo=1 AND p.id_cat=27 ORDER BY p.position ASC");
 
   while($tz1=mysql_fetch_array($tz))
     {
$uk=mysql_num_rows(mysql_query("SELECT * FROM pro WHERE brend=$tz1[ide] AND tip=4"));     
if(isset($hashA['brend']) and in_array($tz1['ide'],explode("-",$hashA['brend']))) $che="checked"; else $che="";      
if($uk==0) $nula=" class='neprikazuj'"; else $nula="";   
                $flista .='<li'.$nula.'><label class="checkbox fa"><input type="checkbox" '.$che.' class="ch" data-rel="sis" value="'.hashlink($tz1['ide'],$hashA,0,"brend").'"><span><span>'.$tz1['naziv'].' <b>'.$uk.'</b></span></span></label></li>';
    } 
								$flista .='</ul>
							</div>
						</div><!--/brands_products-->
                        <div class="clear"></div>
                    
						<h2>'.$arrwords['paket3'].'</h2>
            
            
						<div class="panel-group category-products" id="accordian"><!--category-productsr-->';
if(isset($hashA["filt1"]))
$ini=" in"; else $ini="";
 	$flista .='<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordian" href="#1">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
									POSEBNA PONUDA
										</a>
									</h4>
								</div>
								<div id="1" class="panel-collapse collapse'.$ini.'">
									<div class="panel-body">
										<ul class="user_option">';

 

if(isset($hashA["filt1"]) and in_array(1,explode("-",$hashA["filt1"]))) $che1="checked"; else $che1="";             
 $flista .='<li><label class="checkbox fa"><input type="checkbox" '.$che1.'  class="ch" data-rel="sis" value="'.hashlink(1,$hashA,1,"filt1").'"><span><span>Mobilni telefoni na akciji</span></span></label></li>';

if(isset($hashA["filt1"]) and in_array(2,explode("-",$hashA["filt1"]))) $che1="checked"; else $che1="";             
 $flista .='<li><label class="checkbox fa"><input type="checkbox" '.$che1.'  class="ch" data-rel="sis" value="'.hashlink(2,$hashA,1,"filt1").'"><span><span>Novi mobilni telefoni</span></span></label></li>';

                                        
			$flista .='							</ul>
									</div>
								</div>
							</div>';

                
$tz = mysql_query("SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.akt=1 AND p.nivo=1 AND (p.id_cat=28 or p.id_cat=31) ORDER BY -p.position DESC");
 $i=2;
   while($tz1=mysql_fetch_array($tz))
     {
      

     
      
if(count($hashA["filt$i"])>0)
$inis=" in"; else $inis="";

							$flista .='<div class="panel panel-default">
								<div class="panel-heading">
									<h4 class="panel-title">
									<a data-toggle="collapse" data-parent="#accordian" href="#'.$tz1['ide'].'">
											<span class="badge pull-right"><i class="fa fa-plus"></i></span>
										'.$tz1['naziv'].'
										</a>
									</h4>
								</div>
								<div id="'.$tz1['ide'].'" class="panel-collapse collapse'.$inis.'">
									<div class="panel-body">
										<ul class="user_option">';

 
                
$hz = mysql_query("SELECT p.*, pt.*, p.id as ide
        FROM stavke p
        INNER JOIN stavkel pt ON p.id = pt.id_page        
        WHERE pt.lang='$lang' AND  p.akt=1 AND p.nivo=2 AND  id_parent=$tz1[ide] ORDER BY -p.position DESC");
 
   while($hz1=mysql_fetch_array($hz))
     {
if(isset($hashA["filt$i"]) and in_array($hz1['ide'],explode("-",$hashA["filt$i"]))) $che1="checked"; else $che1="";          
   
 $flista .='<li><label class="checkbox fa"><input type="checkbox" '.$che1.'  class="ch" data-rel="sis" value="'.hashlink($hz1['ide'],$hashA,$i,"filt$i").'"><span><span>'.$hz1['naziv'].'</span></span></label></li>';
      }                                        
			$flista .='							</ul>
									</div>
								</div>
							</div>';
$i++;
}
              
 
$flista .='						</div><!--/category-products-->';