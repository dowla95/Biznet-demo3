<?php
$zaha = mysqli_query($conn, "SELECT p.*, pt.*, p.id as id
        FROM pages_text p
        INNER JOIN pages_text_lang pt ON p.id = pt.id_text        
        WHERE p.youtube<>''");
//$ptenum=mysqli_num_rows($pte);
while($zaha1=mysqli_fetch_assoc($zaha))
{
echo $ogo["naslov"].$zaha1['youtube']."<br>";
}
?>