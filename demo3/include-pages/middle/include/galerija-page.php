<?php 
$izg=mysqli_query($conn, "SELECT * FROM slike WHERE akt='Y' and tip=0 and idupisa='$pte1[id]' ORDER BY -pozicija DESC");
$pp = mysqli_query($conn, "SELECT p.*, pt.*
        FROM slike p
        INNER JOIN slike_lang pt ON p.id = pt.id_slike        
        WHERE pt.lang='$lang' AND p.tip=0  AND p.akt='Y' AND p.idupisa=$pte1[id] ORDER BY -p.pozicija DESC");
while($izg1=mysqli_fetch_assoc($pp))
{
$wh=explode("-",image_size1(200,128,$izg1['slika']));
?>
					<div class="col-sm-3">
							<div class="product-image-wrapper">
								<div class="single-product">
                                <div class="product-f-image">
                                    <a href="<?php echo $patH?><?php echo GALFOLDER ?>/<?php echo $izg1['slika']?>" class='highslide' onclick='return hs.expand(this)' title="<?php echo $izg1['title']?>">
                                    <?php 
                                    echo '<img src="'.$patH.SUBFOLDER.GALFOLDER.'/thumb/'.$izg1['slika'].'" alt="'.$izg1['alt'].'" title="'.$izg1['title'].'">';
if($izg1['ulink']!="") $poseti="<div class='pull-right'><a href='".$izg1['ulink']."' title='".$izg1['title']."' target='_blank'>Poseti sajt</a></div>"; else $poseti="";
                                    ?>
                                    </a>
<div class="highslide-caption"><?php echo "<strong>".$izg1['alt']."</strong><br>".$izg1['title'].$poseti ?></div>
                                    
                                </div>
                            </div>
							</div>
						</div>
<?php } ?> 