<div class='detaljno_smestaj whites'><div class='naslov_smestaj_padd'><h1 class="border_ha">Podešavanja modula</h1></div><?php $mess="";if(isset($_POST['izmeni_modul'])) {$mod=mysqli_query($conn, "SELECT * FROM moduli ORDER BY id ASC");while($mod1=mysqli_fetch_array($mod)){$v=$mod1['id'];if(isset($_POST["moduli$v"]))$stat=1;else$stat=0;mysqli_query($conn, "UPDATE moduli SET status=$stat WHERE id=$mod1[id]");}$mess= "<div class='infos1'><div>Izmenjeno</div></div>";}?> <form method="post" action="" enctype="multipart/form-data"><?php$d=1;$mod=mysqli_query($conn, "SELECT * FROM moduli ORDER BY id ASC");while($mod1=mysqli_fetch_array($mod)){if($mod1['status']==1) $chack=" checked"; else $chack="";//if($mod1['id']==40 or $mod1['id']==50 or $mod1['id']==60) $chb=" class='chb'"; else $chb="";?><div class="row"><div class="col-4 mb-10"><div class="podes"><span><?php echo $d?>. <?php echo $mod1['name']?></span><div class="checkbox checbox-switch switch-primary"><label><input class='chb' type='checkbox' name='moduli<?php echo $mod1['id']?>' value='1' <?php  echo $chack?>><span></span></label></div></div></div><div class="col-1 mt-5"><div class="cs<?php echo $d?>"></div></div></div><?php$d++;}echo $mess;?><div class="col-12"><input type='submit' name='izmeni_modul' class="submit_dugmici_blue mt-20" value='Sačuvaj'></div></form></div><script>$(".chb").change(function() {    $(".chb").prop('checked', false);    $(this).prop('checked', true);});/*$(".chb").change(function() {    $(".chb").not(this).prop('checked', false);});*/</script>