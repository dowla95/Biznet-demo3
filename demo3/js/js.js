/******* AKTIVNOST **************/
function akti(idd,tipi){ 
path=$("#path").attr("href"); 

$.ajax({
type: "POST",
url: path+"/empty.php?nol=1",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
}
});
}
 /*******  **************/
function delm(idd,tipi, pita, idpar){
var answer = confirm(pita);
if(answer){


path=$("#path").attr("href"); 
$.ajax({
type: "POST",
url: path+"/empty.php?nol=1",
data: {id:idd, tip: tipi},
cache: false,
success: function(html){

if(idpar>0)
  $("#kom"+idpar).html(html);
  else {
  $(".kom"+idd).html(html);
  $("#kom"+idd).html(html);
  }
}
});
}
}
function formOdg(ide){
html=$("#komForma").html();
$("#fom"+ide).html('<div class="comment-form">'+html+'</div>');
$("#id_parent").val(ide);
}

/******* Uporedi **************/

function uporedi(idd){ 
path=$("#path").attr("href"); 

$.ajax({
type: "POST",
dataType: "json",
url: path+"/uporedi_check.php",
data: {idpro:idd}, 
cache: false,
success: function(html){

 if(html[0]>0) alert("Možete uporediti maksimalno "+html[0]+" proizvoda");
 else if(html[0]!="")
 {
 $("#up"+idd).html(html[0]);
 alert("Proizvod je prebačen na stranicu za poređenje!");
 }
 $(".count3").html(html[1]);
}, error: function(data){

            }
});
} 
$(document).ready(function() {
$(document).on('click', '.izmform', function() {
html=$("#komForma").html();
ide=$(this).attr('rel');
$('<div class="comment-form" id="izf'+ide+'">'+html+'</div>').insertAfter("#com"+ide);
path=$("#path").attr("href");
$.ajax({
type: "POST",
dataType: "json",
url: path+"/empty-json.php",
data: {iduKom:ide},
cache: false,
success: function(datas){

$('input[name=ime]').val(datas['ime']);
$('input[name=email]').val(datas['email']);
$('textarea[name=poruka]').val(datas['komentar']);

$("#izf"+ide+" form").append('<input type="hidden" name="izmena_komentara" value="'+ide+'">');
$('input[name=send_komentar]').remove();
$('input[name=id_parent]').remove();
}
});

});


$(document).on('change', '.starme', function() {
sev=$(this).val();

path=$("#path").attr("href");
$.ajax({
type: "POST",

url: path+"/empty.php",
data: {ocena: sev},
cache: false,
success: function(datas){
alert(datas)
}
});
});


$(".close-modal, .close-modal1").click(function(){
  $(".modal").css({"display":"none"});
});
$(document).on('change', '.sev', function() {
sev=$(this).val();
fajl=$(this).attr("rel");
var gethash=window.location.hash;
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/"+fajl+"?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]);
}
});
});
$(document).on('click', '#narucis', function() {
if($("#upotrebi-kod").length>0 && $("#promo-kod").val()!="") {
alert("Kliknite na Upotrebi kod kako biste upisani kod iskoristili, a zatim nastavite klikom na Naruči!");
return false;
}

});
$(document).on('click', '#upotrebi-kod', function() {
sev=$("#promo-kod").val();
izf=$("#glavna-forma").serialize();
path=$("#path").attr("href");

$.ajax({
type: "POST",
url: path+"/include/upotrebi-kod.php",
//data: {promo: sev},
data: izf,
cache: false,
success: function(datas){ 
if(datas==1) 
location.reload();
else
$("#promo-info").html(datas);
}
});

return false;
});

$(document).on('click', '#obavestiEmail', function() {

izf=$("#obavesti").serialize();
path=$("#path").attr("href");

$(".infoe").remove();
if($('input[name=obavestime]').val()=="") {
$("<div class='infoe' style='color:red;float:left;width:100%;'>Upišite email adresu</div>").insertAfter( "#obavesti");
}
$.ajax({
type: "POST",
url: path+"/empty.php",
//data: {promo: sev},
data: izf,
cache: false,
success: function(datas){
console.log(datas);
if(datas==1) {
$("<div class='infoe' style='color:green;float:left;width:100%;'>Hvala na interesovanju, obavestićemo Vas čim proizvod ponovo bude na lageru.</div>").insertAfter( "#obavesti");
$("#obavesti").hide();
} else
$("<div class='infoe' style='color:red;float:left;width:100%;'>"+datas+"</div>").insertAfter( "#obavesti");
}
});

return false;
});

$(document).on('click', '#zanemari-kod', function() {
path=$("#path").attr("href");
sev=$("#promo-kod").val();
izf=$("#glavna-forma").serialize();


$.ajax({
type: "POST",
url: path+"/include/upotrebi-kod.php?zanemari=1",
//data: {promo: sev},
data: izf,
cache: false,
success: function(datas){

location.reload();

}
});

return false;
});

$(document).ready(function(){
    $(".upotr-kod").click(function(){
        $("#upkod").toggle();
        $("#zelkod").toggle();
    });
});

/*****************load m. telefona *******************/       
$(document).on('click', '.ch', function() {
path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();

$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/mobilni-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]); 
}
});
});


/*****************load televizora *******************/       
$(document).on('click', '.chtv', function() {
path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/tv-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){
$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]); 
}
});
});


 function parseQuery(qstr) {
        var query = {};
        var a = qstr.substr(1).split('&');
        for (var i = 0; i < a.length; i++) {
            var b = a[i].split('=');
            query[decodeURIComponent(b[0])] = decodeURIComponent(b[1] || '');
        }
        return query;
    }
  function toObject(arr) {
  var rv = {};
  for (var i = 0; i < arr.length; ++i)
    if (arr[i] !== undefined) rv[i] = arr[i];
  return rv;
}
  $(function() {
  mini=$("#amount").attr("data-min");
  maxi=$("#amount").attr("data-max");


   var gethash=window.location.hash;
   var geth=gethash.replace('#','');
        getha=parseQuery(geth);
      if(getha['price']!="" && getha['price']!=undefined)
      {
    var sp=getha['price'].split("-");
    var v1=sp[0];
  var v2=sp[1];
    } else {
v1=mini;
v2=maxi;
    }
if($( "#slider-range" ).length>0){
    $( "#slider-range" ).slider({
      step: 50,
      range: true,
      min: mini*1,
      max: maxi*1,
      values: [ v1, v2 ],
      slide: function( event, ui ) {

        $( "#amount" ).val( (ui.values[ 0 ] +1 )+ " RSD - " + (ui.values[ 1 ]+1) + " RSD");
      },
      stop: function( event, ui ) {
        var gethash=window.location.hash;
        var geth=gethash.replace('#','');
        getha=parseQuery(geth);
        price1 = ui.values[ 0 ];
        price2 = ui.values[ 1 ]+1;

        getha['price']=price1+"-"+price2;
        obje=$.extend({}, getha);
        string="#&"+decodeURIComponent( $.param(obje));
        window.location.hash=string;

 $( "#amount" ).val( price1+ " RSD - " + price2 + " RSD");

   if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=$("#path").attr("href")+"/"+$("#load-filter").attr('data')+"/"+string;
sev=$(".sev").val();
        $.ajax({
type: "POST",
dataType: "json",
url: $("#path").attr("href")+"/include-pages/ajax-load/oprema-load.php?va=rsd&sev="+sev,
data: {hashe: string, uris: window.location.href},
cache: false,
success: function(datas){

$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]);


}
});
        }
    });

    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 )+" RSD" +
      " - " + ($( "#slider-range" ).slider( "values", 1 )+1)+" RSD" );
      }
  });
/*****************load opreme *******************/
$(document).on('click', '.cho', function() {

path=$("#path").attr("href");
var zahas=$(this).val(); 
if($(this).attr("rel")!="sis")
{
var zahas=$(this).attr("rel");
}
if(zahas!="")
{
window.location.hash = zahas;
var gethash=window.location.hash;
if($("#load-filter").attr('data')!="" && $("#load-filter").attr('data')!=undefined)
window.location=path+"/"+$("#load-filter").attr('data')+"/"+gethash;
}else
{
parent.location.hash = '';
var gethash='';
}
sev=$(".sev").val();

$.ajax({
type: "POST",
dataType: "json",
url: path+"/include-pages/ajax-load/oprema-load.php?va="+$("#load-filter").attr("rel")+"&sev="+sev,
data: {hashe: gethash, uris: window.location.href},
cache: false,
success: function(datas){

$("#load-filter").html(datas[0]);
$("#load-lista").html(datas[1]);
$("#collapseTree").html(datas[2]);
if ( $('.navigation-top').css('display') == 'none')
brr=70;
else
brr=220;
  $('html, body').animate({
        scrollTop: $("body").offset().top+brr
    }, 400);


/*var v1=datas[3];
  var v2=datas[4];
   var gethash=window.location.hash;
   var geth=gethash.replace('#','');
        getha=parseQuery(geth);


    $( "#amount" ).val( (datas[3]*1)+" RSD" +
      " - " + (datas[4]*1)+" RSD" );*/
jedinica=0;
if($('.cho:checked').length<1) {
mini=$("#amount").attr("data-min")*1;
  maxi=$("#amount").attr("data-max")*1;
     var gethash=window.location.hash;
   var geth=gethash.replace('#','');
        getha=parseQuery(geth);
   if(getha['price']!="" && getha['price']!=undefined)
      {
    var sp=getha['price'].split("-");
    var v1=sp[0];
  var v2=sp[1];
    } else {
   v1=datas[3]*1;
  v2=datas[4]*1;
}
} else {
  v1=mini=datas[3]*1;
  v2=maxi=datas[4]*1;
  jedinica=1;
  }



//alert(mini + '---' +maxi + ' ### '+v1+'---'+v2);


    $( "#slider-range" ).slider({
      step: 50,
      range: true,
      min: mini,
      max: maxi,
      values: [ v1, v2 ],
      slide: function( event, ui ) {
        $( "#amount" ).val( (ui.values[ 0 ] +1 )+ " RSD - " + (ui.values[ 1 ]) + " RSD");
      }
    });

    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 )+" RSD" +
      " - " + ($( "#slider-range" ).slider( "values", 1 )+jedinica)+" RSD" );

}
});



});
/*****************add comment *******************/
$(document).on("submit", ".comment-form", function (e) {
//$(".comment-form").submit(function(){
path=$("#path").attr("href");

forma=$(this);
$(".alert-success").remove();
$(".alert-warning").remove();
 var datastring = forma.serialize();

$.ajax({
type: "POST",
dataType: "json",
url: path+"/empty-json.php",
data: datastring,
cache: false,
success: function(datas){

if(datas['type']=="success")
{
$("<div class='alert alert-success'>"+datas['message']+"</div>").insertBefore(forma);
//$(".alert-success").fadeIn();
//$(".alert-success").html(datas['message']);
}
if(datas['type']=="error")
{
$("<div class='alert alert-warning'>"+datas['message']+"</div>").insertBefore(forma);
//$(".alert-warning").fadeIn();
//$(".alert-warning").html(datas['message']);
}
}
});
return false;
});
/*****************send mail *******************/       
//$(document).on('click', '.sendmail', function() {
$("#main-contact-form").submit(function(){
path=$("#path").attr("href");

$(".alert-success").hide();
$(".alert-warning").hide();
 var datastring = $("#main-contact-form").serialize();

$.ajax({
type: "POST",
dataType: "json",
url: path+"/sendemail.php",
data: datastring,
cache: false,
success: function(datas){

if(datas['type']=="success")
{
$(".alert-success").fadeIn();
$(".alert-success").html(datas['message']);
} 
if(datas['type']=="error")
{
$(".alert-warning").fadeIn();
$(".alert-warning").html(datas['message']);
}
}
});
return false;
});
$("#submit_btn").click(function() { 
path=$("#path").attr("href");
  var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields		
		$("#futrole-form input[required=true]").each(function(){  
			$(this).css('border-color',''); 
			if(!$.trim($(this).val())){ //if this field is empty 
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
			//check invalid email
			var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
			if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
		});
  if($('input[name=file_attach]')[0].files[0]==undefined || $('input[name=file_attach]')[0].files[0]=="")
  {
  $("#atfile div").css({           
            "border": "1px solid red",
            "padding": "5px"
          }); 
  proced = false;
  } else {
   $("#atfile div").css({           
            "border": "0px",
            "padding": "5px"
          }); 
  } 
        if(proceed) //everything looks good! proceed...
        { 
  var m_data = new FormData();
    m_data.append( 'name', $('input[name=name]').val());
    m_data.append( 'adresa', $('input[name=adresa]').val());
    m_data.append( 'tel', $('input[name=tel]').val());
    m_data.append( 'email', $('input[name=email]').val());
    m_data.append( 'model', $('input[name=model]').val());
    m_data.append( 'postbr', $('input[name=postbr]').val());
	m_data.append( 'grad', $('input[name=grad]').val());
    m_data.append( 'message', $('textarea[name=message]').val());
 	m_data.append( 'file_attach', $('input[name=file_attach]')[0].files[0]);
$("#submit_btn").prop("disabled",true);
$.ajax({
type: "POST",
data: m_data,
processData: false,
contentType: false,
dataType: "json",
url: path+"/futrole-naruci.php",
cache: false,
success: function(datas){
$(".alert-success").fadeIn();
if(datas['type']=="success")
{
$(".alert-success").html(datas['message']);
} else
$("#submit_btn").prop("disabled",false);
}
});
}
return false;
});

/* forma posao */
$("#submit_posao").click(function() { 
path=$("#path").attr("href");
  var proceed = true;
        //simple validation at client's end
        //loop through each field and we simply change border color to red for invalid fields		
		$("#posao-form input[required=true], #posao-form select[required=true]").each(function(){  
			$(this).css('border-color',''); 
			if(!$.trim($(this).val())){ //if this field is empty       
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag
			}
			//check invalid email
			var email_reg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/; 
			if($(this).attr("type")=="email" && !email_reg.test($.trim($(this).val()))){
				$(this).css('border-color','red'); //change border color to red   
				proceed = false; //set do not proceed flag				
			}
		});
  if($('input[name=file_attach_a]')[0].files[0]==undefined || $('input[name=file_attach_a]')[0].files[0]=="")
  {
  $("#atfile-a div").css({           
            "border": "1px solid red",
            "padding": "5px"
          }); 
  proced = false;
  } else {
   $("#atfile-a div").css({           
            "border": "0px",
            "padding": "5px"
          });
  } 
    if($('input[name=file_attach_b]')[0].files[0]==undefined || $('input[name=file_attach_b]')[0].files[0]=="")
  {
  $("#atfile-b div").css({           
            "border": "1px solid red",
            "padding": "5px"
          });
  proced = false;
  } else {
   $("#atfile-b div").css({           
            "border": "0px",
            "padding": "5px"
          }); 
  }
   if (!$("input[name='pol']:checked").val()) {      
  $("#pol div").css({           
            "border": "1px solid red",
            "padding": "5px"
          });
  proced = false;
   } else
   {
    $("#pol div").css({           
            "border": "0px",
            "padding": "5px"
          });
   }
        if(proceed) //everything looks good! proceed...
        { 
  var m_data = new FormData();
    m_data.append( 'ime', $('input[name=ime]').val());
    m_data.append( 'prezime', $('input[name=prezime]').val());
    m_data.append( 'adresa', $('input[name=adresa]').val());
    m_data.append( 'postbr', $('input[name=postbr]').val());
    m_data.append( 'mesto', $('input[name=mesto]').val());
    m_data.append( 'pol', $("input[name='pol']:checked").val());
    m_data.append( 'dan', $('select[name=dan]').val());
    m_data.append( 'mesec', $('select[name=mesec]').val());
    m_data.append( 'godina', $('select[name=godina]').val());
    m_data.append( 'mob', $('input[name=mob]').val());
    m_data.append( 'tel', $('input[name=tel]').val());
      var allVals = [];
    $('#dozvola input[type="checkbox"]:checked').each(function() { 
          allVals.push($(this).val());
    });
    if($("#invalid").is(':checked')) var invalid="DA"; else var invalid="NE";
    m_data.append( 'dozvola', allVals.join(", "));
    m_data.append( 'inv', invalid);
    m_data.append( 'ssp', $('select[name=ssp]').val());
    m_data.append( 'skola', $('input[name=skola]').val());
    m_data.append( 'zanimanje', $('input[name=zanimanje]').val());
    m_data.append( 'lokacija', $('input[name=lokacija]').val());
    m_data.append( 'ocena', $('input[name=ocena]').val());
    m_data.append( 'poceo', $('input[name=poceo]').val());
    m_data.append( 'zavrsio', $('input[name=zavrsio]').val());
    m_data.append( 'racunar', $('select[name=racunar]').val());
    m_data.append( 'programi', $('textarea[name=programi]').val());
    m_data.append( 'ostalo', $('textarea[name=ostalo]').val());
    m_data.append( 'profint', $('textarea[name=profint]').val());
    m_data.append( 'ostint', $('textarea[name=ostint]').val());
    m_data.append( 'email', $('input[name=email]').val());
 	m_data.append( 'file_attach_a', $('input[name=file_attach_a]')[0].files[0]);
	m_data.append( 'file_attach_b', $('input[name=file_attach_b]')[0].files[0]);

$.ajax({
type: "POST",
data: m_data,
processData: false,
contentType: false,
dataType: "json",
url: path+"/posao-forma-send.php",
cache: false,
success: function(datas){
  $('html, body').animate({
        scrollTop: $(".contact-form").offset().top-70
    }, 500);    
$(".alert-success").fadeIn();
if(datas==1)
document.getElementById('myModal').style.display = "block";
//$(".alert-success").html("Vaša prijava je uspešno proslata. Kontaktiraćemo Vas ukoliko uđete u uži krug");
else
$(".alert-success").html("Vaša prijava nije poslata. Pokušajte ponovo.");
}
});
}
return false;
});

/* end forma posao */

$("#naruci-form").submit(function(){
path=$("#path").attr("href");
 var datastring = $("#naruci-form").serialize();
$.ajax({
type: "POST",
dataType: "json",
url: path+"/sendemailforma.php",
data: datastring,
cache: false,
success: function(datas){
if(datas['type']=="success")
{
//$(".alert-success").html(datas['message']);
window.location="http://www.biznet.rs/mts-primljen-zahtev/";
}else
$(".alert-success").fadeIn(); 
}
});
return false;
});

/*****************email prijava *******************/       
$(document).on('click', '.prij', function() {

path=$("#path").attr("href");
var form = $(this).closest('form');
var datastring = form.serialize();

$.ajax({
type: "POST",
//dataType: "json",
url: path+"/empty.php",
data: datastring,
cache: false,
success: function(datas){
datar=datas.split('##');
alert(datar[1])
//form.html(datar[1]);
/*if(datar[0]>0) {
form.html(datar[1]);
$('#donte').hide();
} else
$("#infomsg").html(datar[1]);*/
}
});
return false;
});
$("input[name='neprikazujpopup']").on('change', function() {
if($("input[name='neprikazujpopup']:checked").val()==1) {
$.ajax({
type: "POST",
//dataType: "json",
url: "empty.php",
data: {iskljucipopup: 1},
cache: false,
success: function(datas){

}
});
}
});
});
function print(path)
{
var path;
var xPos;
var yPos;
width=630;
height=800;
xPos = (window.screen.width/2) - (width/2 + 10);
yPos = (window.screen.height/2) - (height/2 + 50);
var win2 = window.open(path,"Window2","status=no,height="+height+",width="+width+",resizable=yes,left=" + xPos + ",top=" + yPos + ",screenX=" + xPos + ",screenY=" + yPos + ",addressbar=no, toolbar=no,menubar=no,scrollbars=no,location=no,directories=no");
win2.focus();
}

////////korpa/////////

function displaySubs(idd,vrr, trr=null){

path=$("#path").attr("href");
$.ajax({
type: "POST",
dataType: "json",
url: path+"/korpaAdd.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){
if($('#item-korpa'+idd).length>0)
$('#item-korpa'+idd).remove();

if(trr!=null)
window.location=trr.getAttribute('rel');



$('.cart-amunt').html(datas[0]);
$('.product-count').html(datas[1]);
$('.shopping-item').mouseenter().mouseleave();
$(".shopping-item").fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200).fadeOut(200).fadeIn(200);
if(trr==null)
  $("#modal-name").css({"display":"block"});
  $.ajax({
type: "POST",
url: path+"/modal-pro-get.php",
data: {pro:idd},
cache: false,
success: function(resu){

 $('#resus').html(resu);
}
});

//coun=$('.cart-counter').html()*1+1;

$("#ukorpu-header").append(datas[9]);
coun=$('.single-item').length;

$('.count2').html(coun);
if(coun>0) {
$('.prKor').hide();
$('.cart-calculation-table').show();
}
$("#ukupno-header").html(datas[4])
/*setInterval(function(){
  $(".shopping-item").toggleClass("divtoBlink");
  },500)
*/
}
});
}
function displaySubsEdit(idd,vrr,old){
path=$("#path").attr("href");

$.ajax({
type: "POST",
dataType: "json",
url: path+"/korpaAdd.php",
data: {id:idd, tip: vrr, oldid:old},
cache: false,
success: function(datas){

window.location.reload();
}
});
}
function displaySubs1(idd,vrr){ 
path=$("#path").attr("href");
prov=$('#val'+idd).val();
if(vrr=="minus")
prov=prov-1;
if(prov>0)
{
 $.ajax({
type: "POST",
dataType: "json",
url: path+"/korpaAdd.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){  
$('.cart-amunt').html(datas[0]);
$('.product-count').html(datas[1]);
if(datas[7]==1) {
$('.ukupno').html('<del>'+datas[4]+'</del>');
$('.ukupno-promo').html(datas[8]);
}
else
$('.ukupno').html(datas[4]);
$('#bzp').html(datas[5]);
$('#pdve').html(datas[6]);
if(vrr!="drop")
{
$('#cen'+idd).html(datas[2]);
$('#val'+idd).val(datas[3]);
}else
{
$('#row'+idd).hide();
}
}
});
}
}

function displaySubs2(idd,vrr){
var answer = confirm("Da li zaista želite da izbacite iz korpe ovaj proizvod?");
if(answer){
$.ajax({
type: "POST",
dataType: "json",
url: "korpaAdd.php",
data: {id:idd, tip: vrr},
cache: false,
success: function(datas){

$('.cart-amunt').html(datas[0]);
$('.product-count').html(datas[1]);
//$('.ukupno').html(datas[0]);
$('#bzp').html(datas[5]);
$('#pdve').html(datas[6]);
$('#row'+idd).hide();
$('#item-korpa'+idd).remove();
coun=$('.count2').html()*1-1;
$('.count2').html(coun);

if(coun<1) {
$('.prKor').show();
$('.cart-calculation-table').hide();
$(".sukupno").hide();
} else {
$("#ukupno-header").html(datas[4]);
$('.ukupno').html(datas[4]);
}

}
});
}
}