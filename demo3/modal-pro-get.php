<?php 
include("Connections/conn.php");
$key=strip_tags($_POST['pro']);
if($key>0)
{
?>
     <div class="table-responsive cart_info">
				<table class="table table-condensed">
					<tbody>
<?php 
$az = mysqli_query($conn, "SELECT p.*, pt.*, p.id as ide
        FROM pro p
        INNER JOIN prol pt ON p.id = pt.id_text
        $inner_plus
        WHERE pt.lang='$lang' AND p.akt=1 AND p.id=$key GROUP BY p.id ORDER BY -p.pozicija DESC, pt.naslov");
 $az1=mysqli_fetch_assoc($az);
$cenar=$az1['cena'];
 $cena_sum =roundCene($cenar,1);
$ukupno +=roundCene($cenar,1)*$value;
$sum =$value;
if($az1['tip']==4) $zalink=$all_links[2];
elseif($az1['tip']==6) $zalink=$all_links[48];
else $zalink=$all_links[3];
?>
						<tr id="row<?php echo $az1['id']?>">
							<td class="cart_product">
								<a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>/">
<img src="<?php echo $patH1?>/galerija/thumb/<?php echo $az1['slika']?>" title="<?php echo $az1['titleslike']?>" style="width:80px;height:auto;" alt="<?php echo $az1['altslike']?>">
</a>
							</td>
							<td class="cart_description">
								<h5><a href="<?php echo $patH1?>/<?php echo $zalink?>/<?php echo $az1['ulink']?>/"><?php echo $az1['naslov']?></a></h5>
								<p>Web ID: <?php echo $az1['ide']?></p>
							</td>
						</tr>
					</tbody>
				</table>
<div class="cart_price" style="text-align:right;position:relative;top:-10px;font-weight:bold;">
								<p><?php echo format_ceneS($cena_sum,1) ?></p>
							</div>
			</div>
       <?php 
}
?>