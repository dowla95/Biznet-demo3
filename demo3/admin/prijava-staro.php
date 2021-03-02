 <div class='detaljno_smestaj whites'>
<div class='naslov_smestaj_padd'><h1 class="border_ha"><?php echo $langa['logins']?></h1></div>

              <br />
    </div>        
         <div class='detaljno_smestaj whites' <?php echo $klasa_plus?> >
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

                    <div class="levis">
                      <span>Nova šifra:</span>

                      <input class='input_poljes_sivo' type="password" name="password" class="text"   size="18" autofocus />

                    </div>

 <div class="desnis">

  <span>Ponovi šifru:</span>
 <input class='input_poljes_sivo' type="password" name="password1" class="text"   size="18" autofocus />
<br><br>
<input type="hidden" name="renew" value="<?php echo strip_tags($_GET['renew'])?>">
                 <input  type="submit" name='addnewPass' value="Završi" class='submit_dugmici_blue'  />

</div>
                         </form>
<?php
}
         } else
         if(isset($_GET['resetForm']) and $_GET['resetForm']=='lost-pass'){
         if(isset($msgr) and $msgr!='')
         echo "<div class='info_box'><div>$msgr</div></div>";
?>
    <form action="" method="post" name="login" id="form-login" class='gf-form' >

                    <div class="levis">
                      <span><?php echo $langa['email']?> sa kojom imate nalog u adminu:</span>

                      <input class='input_poljes_sivo' type="text" name="email" class="text" alt="username" size="18" autofocus />

                    </div>

 <div class="desnis">

<br>

                 <input  type="submit" name='newPass' value="Pošalji zahtev" class='submit_dugmici_blue'  />

</div>
                         </form>
<?php
         } else {
         ?>

    <form action="" method="post" name="login" id="form-login" class='gf-form' >
              
                    <div class="levis"> 
                      <span><?php echo $langa['email']?>:</span>
                       
                      <input class='input_poljes_sivo' type="text" name="email" class="text" alt="username" size="18" autofocus />
<p>                       
<input id="modlgn_remember" class='gf-checkbox' name="remember" value="1" tabindex="7" type="checkbox" /> <label for="modlgn_remember"><?php echo $langa['logins3']?></label>
</p>                      
                    </div> 
                    <div class="desnis"> 
                      <span><?php echo $langa['passw']?>:</span>
                       
                      <input class='input_poljes_sivo' type="password" name="pass" class="text" size="18" alt="password" />

                  <p><a href="index.php?resetForm=lost-pass">Zaboravljena šifra</a></p>
       
                    </div>
                          <br class='clear' />      <br />
           
                        
                              
                 <input  type="submit" name='sublogins' value="<?php echo $langa['logins5']?>" class='submit_dugmici_blue'  /> 
                 
              
                         </form>      
                        
                 
    <?php } ?>
 </div> 

                         
 <br />        <br />  
                    
