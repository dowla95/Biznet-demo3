         <div class='login' <?php echo $klasa_plus?> >
		 <div class='naslov_smestaj_padd'><h1 class="border_ha"><?php echo $langa['logins']?><br>
		 <a class="text-center mb-10" href="" target="_blank" title=""><img src="images/logo.png" title="" alt=""></a>
		 </h1></div>
         <?php 
         if(strlen($msls)>2)
         {
         ?>   
         <div class='box'><div>
         <?php echo $msls?>
         </div></div>
         <?php
         }
if(isset($_GET['resetForm']) and $_GET['resetForm']=='add-pass'){
         if(isset($msgr) and $msgr!='')
         echo "<div class='info_box'><div>$msgr</div></div>";
         if($istekao_link_za_sifru==0) {
?>
    <form action="" method="post" name="login" id="form-login" class='gf-form' >
		<span>Nova šifra:</span>
        <input class='input_poljes_sivo' type="password" name="password" class="text"   size="18" autofocus />
		<span>Ponovi šifru:</span>
		<input class='input_poljes_sivo' type="password" name="password1" class="text"   size="18" autofocus />
		<br><br>
		<input type="hidden" name="renew" value="<?php echo strip_tags($_GET['renew'])?>">
        <input  type="submit" name='addnewPass' value="Završi" class='submit_dugmici_blue'  />
	</form>
<?php
}
} else
         if(isset($_GET['resetForm']) and $_GET['resetForm']=='lost-pass'){
         if(isset($msgr) and $msgr!='')
         echo "<div class='info_box'><div>$msgr</div></div>";
?>
    <form action="" method="post" name="login" id="form-login">
		<h2>Reset lozinke</h2>
        <span>Unesite email adresu naloga u adminu:</span>
        <input class='form-control' type="text" name="email" class="text" alt="username" size="18" autofocus />
		<input  type="submit" name='newPass' value="Pošalji zahtev" class='submit_dugmici_blue float-right mt-10' />
    </form>
<?php
} else { ?>

    <form action="" method="post" name="login" id="form-login">
        <span><?php echo $langa['email']?>:</span>
        <input class='form-control mb-10' type="text" name="email" alt="username" size="20" />                      
		<span><?php echo $langa['passw']?>:</span>
		<input class='form-control mb-10' type="password" name="pass" size="20" alt="password" />
		<p>                       
		<input id="modlgn_remember" name="remember" value="1" tabindex="7" type="checkbox" class="mr-10" />
		<label for="modlgn_remember"><?php echo $langa['logins3']?></label>
		</p>
		<p><a href="index.php?resetForm=lost-pass">Zaboravljena šifra</a></p>
        <input  type="submit" name='sublogins' value="<?php echo $langa['logins5']?>" class='submit_dugmici_blue float-right'  /> 
    </form>      
    <?php } ?>
 </div>