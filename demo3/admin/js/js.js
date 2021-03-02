function get_absolute_path()
    {
     /*var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    var path= loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));*/
return $(location).attr('href').replace($(location).attr('pathname'),'/kliknovicg');
 }
//var path=$(location).attr('href').replace($(location).attr('pathname'),'/kliknovi');
//var path="http://www.klikdoposla.com";
str=$(location).attr('href').replace($(location).attr('pathname'),'');
if (str.indexOf("localhost") >= 0)
path=$(location).attr('href').replace($(location).attr('pathname'),'/kliknovicg');
//else
//path=$(location).attr('href').replace($(location).attr('pathname'),'');
//path="http://www.klikdooglasa.com";
//path="http://www.apartmanibeogradsmestaj.com";
patha=$(location).attr('href');
pathas=patha.split("/admin");
path=pathas[0]+"/admin";
 
 
  
 function lols(path)
{
var path;
var xPos;
var yPos;
width=600;
height=700;
xPos = (window.screen.width/2) - (width/2 + 10);
yPos = (window.screen.height/2) - (height/2 + 50);
var win2 = window.open(path,"Window2","status=no,height="+height+",width="+width+",resizable=yes,left=" + xPos + ",top=" + yPos + ",screenX=" + xPos + ",screenY=" + yPos + ",toolbar=no,menubar=no,scrollbars=yes,addressbar=no,location=no,directories=no");
win2.focus();
}
 
 
 
function dodeli(pojam)
{ 
  document.getElementById("kljucne_reci").value=pojam;
  document.getElementById("livesearch").style.display="none";
}

$(document).ready(function(){
$(".iframe_small").colorbox({iframe:true, width:"430px", height:"130px"});
$(".iframe").colorbox({iframe:true, width:"800px", height:"800px"});
$(".iframeB").colorbox({iframe:true, width:"90%", height:"800px"});
$(".iframe1").colorbox({iframe:true, width:"400px", height:"600px"});
$(".iframe2").colorbox({iframe:true, width:"550px", height:"500px"});
$(".iframe3").colorbox({iframe:true, width:"670px", height:"500px"});
$(".iframe4").colorbox({iframe:true, width:"700px", height:"750px"});
$(".iframe_ostali_gradovi").colorbox({iframe:true, width:"850px", height:"700px"});
$(".iframe_ostale_oblasti").colorbox({iframe:true, width:"700px", height:"420px"});
$(".group1").colorbox({rel:'group1'});
$(".inline").colorbox({inline:true, width:"600px"});
$(".inline1").colorbox({inline:true, width:"800px"});
 $(".iframe_small1").colorbox({iframe:true});
 });
 
    
 
 
///newslatter add email
function save_email(){
 $('#news_add').fadeIn('slow');
var post = $('#newslatter').serialize();    
jQuery('#news_add').html('...');
$.post(path+"/add_email.php", post, function(data) { 
jQuery('#news_add').html(data);
});

}
///newslatter add email ulog
function save_email_ulog(){
 $('#news_add').fadeIn('slow');
var post = $('#newslatter').serialize();    
jQuery('#news_add').html('...');
$.post(path+"/add_email_ulogovani.php", post, function(data) { 
jQuery('#news_add').html(data);
});

}
///anketa glasanje
function tus()
{
 $('#glasano').fadeIn('slow');
var post = $('#anketa').serialize();    
jQuery('#glasano').html('...');
$.post(path+"/glasaj.php", post, function(data) { 
jQuery('#glasano').html(data);
});
}
//search header more
$(function(){
$("#contactLink").click(function(){
if ($("#search_more").is(":hidden")){
$("#search_more").slideDown("fast");
//  $("#plus").hide("fast");
//  $("#minus").show("fast");
}
else{
 //$("#contactLink").html("<img src='<?php echo $patH?>/css_calendar/search.png'  />");
$("#search_more").slideUp("fast");
//$("#plus").show("fast");
//$("#minus").hide("fast");
}
});
$("#contactLink1").click(function(){
$("#search_more").slideUp("fast");
});
});

$(function(){
$(".ovor").click(function(){
var n = $(this).nextAll().has(":checkbox").first().find(":checkbox");
if ( $(this).is( ":checked" ) )
n.prop("checked", true);
else
n.prop("checked", false);
ar=$(this).val();
if(ar>0)
{
$.ajax({
type: "POST",
//dataType: "json",
url: path+"/save_page_akt.php",
data: {ara:ar},
cache: false,
success: function(datas){
 
}
});
}
});
});
 
$(document).ready(function(){
$(".brp").submit(function() {
forma= $(this);
 forma.find('input[type=submit]').hide();
forma.children("img").show();
    $.ajax({
           type: "POST",
           url: path+"/prazno.php",
           data: $(this).serialize(), // serializes the form's elements.
           success: function(data)
           {
           forma.find('input[type=submit]').show();
            forma.children("img").hide();
            forma.find('div').show();
            forma.find('div').html(data);
           }
         });

    return false;
});

	$("#tabsR li").click(function() {
		//	First remove class "active" from currently active tab
		$("#tabsR li").removeClass('active');

		//	Now add class "active" to the selected/clicked tab
		$(this).addClass("active");

		//	Hide all tab content
		$(".tabR_content").hide();

		//	Here we get the href value of the selected tab
		var selected_tab = $(this).find("a").attr("href");

		//	Show the selected tab content
		$(selected_tab).fadeIn();

		//	At the end, we add return false so that the click on the link is not executed
		return false;
	});
  
 $("#tabsK li").click(function() {
		//	First remove class "active" from currently active tab
		$("#tabsK li").removeClass('active');

		//	Now add class "active" to the selected/clicked tab
		$(this).addClass("active");

		//	Hide all tab content
		$(".tabR_content").hide();

		//	Here we get the href value of the selected tab
		var selected_tab = $(this).find("a").attr("href");

		//	Show the selected tab content
		$(selected_tab).fadeIn();

		//	At the end, we add return false so that the click on the link is not executed
		return false;
	}); 
 $("#pronadji").fadeTo(0, 0.8);
});
 $(document).ready(function() {
        $('#pronadji').each(function() {
            $(this).hover(function() {
                $(this).stop().animate({ opacity: 1.0 }, 100);
            },
           function() {
               $(this).stop().animate({ opacity: 0.8 }, 100);
           });
        });
    });
/* za PRIKAZ oglasa na strani za poslodavce */

 $(document).ready(function() {

$(".obrisi-ovo").click(function(){
 var answer = confirm("Da li zelite da izbrisete izabrane upise?");

if(answer){
$("#obrisi-ovo").submit();
}
return false;
});
$(".exportuj-ovo").click(function(){
$("#exportuj-ovo").submit();
return false;
});

$(".oznaci").click(function(){
izabrano1=$(".oznaci:checked").map(
     function () {return this.value;}).get().join(",");
   if(izabrano1!="")
    $("#izmi").show();
    else
      $("#izmi").hide();
    izabrano=$(".oznaci:checked").map(
     function () {return this.value;}).get().join(",");
$('#obrisi_ovo').val(izabrano);
$('#exportuj_ovo').val(izabrano);
});
$("#checkAll").click(function(){
    $('.oznaci').not(this).prop('checked', this.checked);

    if($(this).is(":checked")==true) { 
     /* var allVals = [];
     $('.oznaci :checked').each(function() { alert($(this).val());
       allVals.push($(this).val());
     });
     $('#obrisi_ovo').val(allVals);*/
izabrano=$(".oznaci:checked").map(
     function () {return this.value;}).get().join(",");
$('#obrisi_ovo').val(izabrano);
$('#exportuj_ovo').val(izabrano);
    $("#izmi").show();
    } else $("#izmi").hide();
});

     // hides the slickbox as soon as the DOM is ready
      $('#slickbox').hide();
     // shows the slickbox on clicking the noted link  
      $('#slick-show').click(function() {
        $('#slickbox').show('slow');
        return false;
      });
     // hides the slickbox on clicking the noted link  
      $('#slick-hide').click(function() {
        $('#slickbox').hide('fast');
        return false;
      });
     
     // toggles the slickbox on clicking the noted link  
      $('#slick-toggle').click(function() {
        $('#slickbox').toggle(400);
        return false;
      });
    });

 
 
 
  
/* blokira prikazivanje forme za prijavu za ulogovane korisnike */
   function nodrop()
    {
   $("#novisible").hide();
    }
 
  function obrisime(idd,tipi){
 
var answer = confirm("Da li zelite da izbrisete izabrani upis?");

if(answer){
 $.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
 
 $("#sortid_"+idd).html(html); 
}
});
 
}
}
function obrisimer(idd,tipi){
 
var answer = confirm("Da li zelite da izbrisete izabrani upis?");
 
if(answer){
 $.ajax({
type: "POST",
url: path+"/prazno.php",
data: {delnal:idd, tip: tipi, no:"red"}, 
cache: false,
success: function(html){
 
 $("#sortid_"+idd).html(html); 
}
});
 
}
}
function show_text_position_page(idd){
 
$.ajax({
type: "POST",
url: path+"/show_text_position_page.php",
data: {id:idd}, 
cache: false,
success: function(html){
 
}
});
}

/******* AKTIVNOST **************/
  function akti(idd,tipi){
 
$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
 
}
});
}
  function aktit(idd, tipi, tab){

$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:idd, kolona: tipi, tabela: tab},
cache: false,
success: function(html){

}
});
}
$(document).ready(function() {
$('.filters').click(function() {  
var nic = new Array();
$(".filter input[type=checkbox]:checked").each(function(key, value) {

nic[key] =$(this).val();
 
    });

$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:nic, tip: "akti_lang"}, 
cache: false,
success: function(html){
 
}
});    
    
    });
    });  
$(document).ready(function() {
$('.def').click(function() {  
nic =$(this).val();
alert(nic)
$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:nic, tip: "def_lang"}, 
cache: false,
success: function(html){
 
}
});    
});
    });  
$(document).ready(function() {
 $('#paketzz').change(function() {
 izbo=$(this).val(); 
$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:izbo, tip: "paket"}, 
cache: false,
success: function(html){
  
}
});
 
 });
/*$( document ).on( "click", "input[type=submit][name='save_pro'], input[type=submit][name='save_change_pro']", function() {

var checked = $("#filter :radio:checked");
    var groups = [];
    $("#filter :radio").each(function() {
        if (groups.indexOf(this.name) < 0) {
            groups.push(this.name);
        }
    });
    if (groups.length == checked.length) {
        //alert('all are checked!');
    }
    else {
        var total = groups.length - checked.length;
        alert('U '+total + ' grupi filtera niste izabrali stavku.');
    }
});*/
/*$( document ).on( "click", "input[type=submit][name='save_pro']", function() {

if ($('#filter:not(:has(:radio:checked))').length) {
    alert("Izaberite stavke filtera, pre toga, ukoliko niste, izabirite kategoriju!");
    return false;
}
});*/

$( document ).on( "change", "input[type=radio][name='kategorija']", function() {

abrend=$("select[name='brendovi']").val();
idpro=$("input[name='idpro']").val();
izbo=$("input[type=radio][name='kategorija']:checked").val();
zasend="&kategorija="+izbo+"&brend="+abrend+"&idpro="+idpro;
$.ajax({
type: "POST",
dataType: "json",
url: path+"/loadBrends.php",
data: zasend,
cache: false,
success: function(html){

$("select[name='brendovi']").html(html[0]);
$("#filter").html(html[1]);
}
});

 });

if($("select[name='brendovi']").length>0) {
abrend=$("select[name='brendovi']").val();
idpro=$("input[name='idpro']").val();
izbo=$("input[type=radio][name='kategorija']:checked").val();

zasend="&kategorija="+izbo+"&brend="+abrend+"&idpro="+idpro;
$.ajax({
type: "POST",
dataType: "json",
url: path+"/loadBrends.php",
data: zasend,
cache: false,
success: function(html){

$("select[name='brendovi']").html(html[0]);

$("#filter").html(html[1]);
}
});
}
});

function paket(izbo, id)
{
$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:izbo, tip: "paket"}, 
cache: false,
success: function(html){ 
}
});
} 
 function omoguci(idd,tipi){
$("#loaderce").show();
$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:idd, tip: tipi}, 
cache: false,
success: function(html){
$("#loaderce").hide(); 
}
});

}
	function blok(idd){
var answer = confirm("Da li zelite da blokirate ili odblokirate ovog korisnika?");
if(answer){

$.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id:idd},
cache: false,
success: function(html){
 
}
});
 
}
}

	function obavesti(idd, tip){
var answer = confirm("Da li zelite da posaljete obavestenje o postojanju proizvoda?");
if(answer){

$.ajax({
type: "POST",
url: "https://amazonka.rs/empty.php",
data: {id:idd, tips: tip},
cache: false,
success: function(html){
if(html==1)
alert("Obavestenje je poslato ovom korisniku!");
}
});

}
}
/************* sacuvaj posao ******************/
function sacuvaj_oglas(idd,ti){

$.ajax({
type: "POST",
dataType: "json",
url: path+"/sacuvaj_oglas.php",
data: {id:idd, tii:ti},
cache: false,
success: function(datas){
 
//for(var key in datas) { 
//  alert(datas); 
$("#saves"+idd).html(datas[0]); 
  $("#sposlovi").html("("+datas[2]+")");
 
 
//}
// 
}
});

}

 function pwdFocus() {
            $('#fakepassword').hide();
            $('#password').show();
            $('#password').focus();
        }

        function pwdBlur() {
            if ($('#password').attr('value') == '') {
                $('#password').hide();
                $('#fakepassword').show();
            }
        }  
 
 
//novi link 
  jQuery(document).ready(function ($) {
  
 

  $('#order').change(function() {

 var vred=$(this).val();
tren=$("#trenutni_url").val();
 
 
 if(tren.indexOf("?orderb="))
 {
 deo=tren.split("?orderb=");
 tren=deo[0];
 if(vred!="")
 konac=tren+"?orderb="+vred
 else
 konac=tren
 }
 else
if(tren.indexOf("?"))  
 {  
 if(tren.indexOf("&orderb="))
 {
 deo=tren.split("&orderb=");
 tren=deo[0];
 konac=tren+"&orderb="+vred
 }
else
 {
 if(tren.indexOf("orderb="))
 {
 deo=tren.split("?orderb=");
 tren=deo[0];
 }
 konac=tren+"?orderb="+vred
 }   
 }else  
 if(vred!="")
 konac=tren+"?orderb="+vred
 else
 konac=tren
 
   window.location=konac;
});    


 $('#ponpot').change(function() {
 var vred=$(this).val();
tren=$("#trenutni_url1").val();

if(vred=="") 
   window.location=tren;

else

   window.location=tren+""+vred+"/";
});    

    });   
 
function obnovi_sessiju(){

 
 

$.ajax({
			type: "POST",
			
			data: {userid: '0', tabela: 'adrese'},
			url: path+"/obnovi_sesiju.php",
			beforeSend: function(){
 	 
			},
			success: function(data){
 

var cc=setTimeout('obnovi_sessiju()', 300000);
  
			}
	
      	});	  
 
    	}
  
/******* oceni oglas *********/
function oceni(ide, oc)
    {  
    $.ajax({
type: "POST",
url: path+"/oceni_oglas.php",
data: {id: ide, ocena: oc}, 
cache: false,
success: function(datas){
 
$("#ocenjeno").html(datas);
}
});

    }
function uklonis(tip,fajl)
{

$.ajax({
type: "POST",
url: path+"/ukloni_temp_file.php",
data: {file:fajl},
cache: false,
success: function(html){

if(tip==1)
{
 $("#preview").html("<input type='hidden' id='civi' name='civi' value='' />");
 $("#cve").show();
 $("#cv").val("");
//$("#contactform").attr("action",path+"/private/prazno.php");

}
}
});
}             
function del_v()
    {  
    $.ajax({
type: "POST",
url: path+"/del_cook.php",
data: {delis: "1"}, 
cache: false,
success: function(datas){
 
$(".padi").html("");
//$("#drugi").html("");
}
});

    }
function obris(ide, table, kolona, upozor)
    { 
var answer = confirm(upozor);

if(answer && upozor!=""){    
    $.ajax({
type: "POST",
url: path+"/aktivnost.php",
data: {id: ide, tab: table, kol: kolona}, 
cache: false,
success: function(datas){
 
$("#sortid_"+ide).hide();

}
});
}
    }    
function load_cats(ide)
{ 
    
  $.ajax({
type: "POST",
url: path+"/load_cats.php",
data: {id: ide}, 
cache: false,
success: function(datas){
 
$("#cats").html(datas);

}
});
}        

function load_mod(ide,nas)
{ 
    
  $.ajax({
type: "POST",
url: path+"/load_model.php",
data: {id: ide,nasl: nas}, 
cache: false,
success: function(datas){
 
$(".mods").html(datas);

}
});
}
$(document).ready(function() {
    $('.fontSizePlus').click(function() {
        $('#opisi_oglasi').css("font-size", function() {
            return parseInt($(this).css('font-size')) + 1 + 'px';
        });
    });
    
     $('.fontSizeMinus').click(function() {
        $('#opisi_oglasi').css("font-size", function() {
            return parseInt($(this).css('font-size')) - 1 + 'px';
        });
    });
});
$(document).ready(function() {

$('#katis').change(function() {
konac=$(this).val();
 
if(konac>0)
$("#podkat").removeAttr("disabled");
else
$('#podkat').prop('disabled', true); 
 $('.pronadji_smestaj .sajax-loadings').fadeIn();
$.ajax({
type: "POST",
url: path+"/get_gradovi_search.php",
data: {delis: konac}, 
cache: false,
success: function(datas){
 
$("#podkat").html(datas);
$('.pronadji_smestaj .sajax-loadings').fadeOut();
}
});
});
});

function setgrad(konac, kon)
{
 
 $('.pronadji_smestaj .sajax-loadings').fadeIn();
$.ajax({
type: "POST",
url: path+"/get_gradovi.php",
data: {delis: konac, delisa: kon}, 
cache: false,
success: function(datas){
 
$("#podkat").html(datas);
 
$('.pronadji_smestaj .sajax-loadings').fadeOut();
}
});
}

function podkat(konac, konac1)
{
$("#podkat").removeAttr("disabled");

 $('.pronadji_oglas .sajax-loadings').fadeIn();
$.ajax({
type: "POST",
url: path+"/get_podkat.php",
data: {delis: konac, delis1: konac1}, 
cache: false,
success: function(datas){
 
$("#podkat").html(datas);
$('.pronadji_oglas .sajax-loadings').fadeOut();
}
});
}

function getgrad(konac, konac1)
{
$(".cest").hide();
$.ajax({
type: "POST",
url: path+"/get_grad.php",
data: {delis: konac, delis1: konac1}, 
cache: false,
success: function(datas){
$("#ce"+konac).show();
if($('#invalid').is(':checked')) {  } else
{ 
$(".gf-radio").removeAttr('checked');
 
$("#invalid"+konac).attr('checked', 'checked');
}
$("#postanski_broj").html(datas);

}
});
}
function getkat(konac, konac1)
{

$.ajax({
type: "POST",
url: path+"/get_podkati.php",
data: {delis: konac, delis1: konac1}, 
cache: false,
success: function(datas){
 
$("#podkat").html(datas);

}
});
}
  function add() {
   if($(".file_input_div1").length==13)
   alert("Maksimalan broj slika uz oglas je 12")
   else
   {
    var item = $('#template').clone();
 
    $('#guest_details').append(item);
    }
}
 var windowsize = $(window).width();

$(window).resize(function() {
  windowsize = $(window).width();
  if (windowsize > 440) {
    //if the window is greater than 440px wide then turn on jScrollPane..
    //  $('.group').jScrollPane({
         //scrollbarWidth:15, 
         //scrollbarMargin:52
//      });
  }
});
/* Ucitavanje oglasa dodatnih na stranici oglasi-poslodavci.php */
$(function() {
//More Button
$('.more').live("click",function() 
{
 
var ID = $(this).attr("id");
var idog = $(this).attr("rel");
var path=$("#home").attr("rel");


if(ID)
{
$("#more"+ID).html('<img src="'+path+'/images/loader.gif" style="padding-top:7px;padding-bottom:7px;" />');

$.ajax({
type: "POST",
url: path+"/jos_slika.php",
data: {lastmsg: ID, ido: idog}, 
cache: false,
success: function(html){
 
$("#append_image").append(html);
 
//$('<div></div>').appendTo("#slickbox1").hide().append(html).fadeIn('slow');
$("#more"+ID).remove();
}
});
$("#more_end").show();
}
else
{
$(".morex").html('<a href="javascript:;">END</a>');

}


return false;


});
 $('.more_end').live("click",function() 
{
var tren = $(this).attr("rel");
deo=tren.split("#");
var zapri="<div id='more0' class='morebox morex'><a href='javascript:;' class='more' rel='"+deo[0]+"' id='0'>"+deo[1]+"</a></div>";
$("#append_image").html(zapri);
$("#more_end").hide();
return false;
});
});
 function clone(){
   
 var clon=   $("#ovo").html();

         clon1=clon.replace("hiden","");
              
        $("#append").append(clon1);
        
 
   
    return false;
}
function remove(){
 
var answer = confirm("Brisanjem ovog upisa, sajt će ostati bez upisanih reči. Da nastavim?");
      var posl=$(".clonedInput").length;
      
     if(posl==2)
     alert("Potrebno je da ostane jedan red!")
     else   
     

if(answer){
    $(this).parent().parents(".clonedInput").remove();
    }
    return false;
}


  $(document).ready(function() {
  $('a.clone').live('click', clone)
  $('a.remove').live('click', remove)
     
  
 $("#getis").on("click", function() {
 alert($("#append").html())
 
 });
 
        });
  
  $(document).ready(function() {
 $('.ratings_stars').hover(
 
            // Handles the mouseover

            function() {

                $(this).prevAll().andSelf().addClass('ratings_over');
               

            },

            // Handles the mouseout

            function() {

                $(this).prevAll().andSelf().removeClass('ratings_over');

            }

        );
//send ajax request to rate.php
        $('.ratings_stars').bind('click', function() {
			var path=$("#home").attr("rel");
			var id=$(this).parent().attr("id");
		    var num=$(this).attr("class");
       
			var poststr="id="+id+"&stars="+num;
		$.ajax({url:path+"/rate.php",cache:0,data:poststr,success:function(result){
   document.getElementById(id).innerHTML=result;}
   });	
		});

 
 
 
 
 
        });

        

/***************************** novi multiselect *************************/

(function($) {

    $.fn.fSelect = function(options) {

        if (typeof options == 'string' ) {
            var settings = options;
        }
        else {
            var settings = $.extend({
                placeholder: 'Select some options',
                numDisplayed: 10,
                overflowText: 'izabrano {n}',
                searchText: 'Pronadji',
                showSearch: true
            }, options);
        }


        /**
         * Constructor
         */
        function fSelect(select, settings) { 
            this.$select = $(select);
            this.settings = settings;
            this.create();
        }


        /**
         * Prototype class
         */
        fSelect.prototype = {
            create: function() {
                var multiple = this.$select.is('[multiple]') ? ' multiple' : '';
                
                this.$select.wrap('<div class="fs-wrap' + multiple + '"></div>');
                this.$select.before('<div class="fs-label-wrap"><div class="fs-label">' + this.settings.placeholder + '</div><span class="fs-arrow"></span></div>');
                this.$select.before('<div class="fs-dropdown hidden"><div class="fs-options"></div></div>');
                this.$select.addClass('hidden');
                this.$wrap = this.$select.closest('.fs-wrap');
                this.reload();
            },

            reload: function() {
                if (this.settings.showSearch) {
                    var search = '<div class="fs-search"><input type="search" placeholder="' + this.settings.searchText + '" /></div>';
                    this.$wrap.find('.fs-dropdown').prepend(search);
                }
                var choices = this.buildOptions(this.$select);
                this.$wrap.find('.fs-options').html(choices);
                this.reloadDropdownLabel();
            },

            destroy: function() {
                this.$wrap.find('.fs-label-wrap').remove();
                this.$wrap.find('.fs-dropdown').remove();
                this.$select.unwrap().removeClass('hidden');
            },

            buildOptions: function($element) {
                var $this = this;

                var choices = '';
                $element.children().each(function(i, el) {
                    var $el = $(el);

                    if ('optgroup' == $el.prop('nodeName').toLowerCase()) {
                        choices += '<div class="fs-optgroup">';
                        choices += '<div class="fs-optgroup-label">' + $el.prop('label') + '</div>';
                        choices += $this.buildOptions($el);
                        choices += '</div>';
                    }
                    else {  
                        var selected = $el.is('[selected]') ? ' selected' : '';
                        choices += '<div class="fs-option' + selected + '" data-value="' + $el.prop('value') + '" rel="'+ $el.attr("rel") +'"><span class="fs-checkbox"><i></i></span><div class="fs-option-label"><span class="'+ $el.attr("title") +'">' + $el.html() + '</span></div></div>';
                    }
                });

                return choices;
            },

            reloadDropdownLabel: function() {
                var settings = this.settings;
                var labelText = [];

                this.$wrap.find('.fs-option.selected').each(function(i, el) {
                    labelText.push($(el).find('.fs-option-label').text());
                    
                    //alert($(el).find('.fs-option-label').text())
                });

                if (labelText.length < 1) {
                    labelText = settings.placeholder;
                }
                else if (labelText.length > settings.numDisplayed) {
                    labelText = settings.overflowText.replace('{n}', labelText.length);
                }
                else {
                    labelText = labelText.join(', ');
                }
  
                this.$wrap.find('.fs-label').html(labelText);
                this.$select.change();
            }
        }


        /**
         * Loop through each matching element
         */
        return this.each(function() {
            var data = $(this).data('fSelect');

            if (!data) {
                data = new fSelect(this, settings);
                $(this).data('fSelect', data);
            }

            if (typeof settings == 'string') {
                data[settings]();
            }
        });
    }


    /**
     * Events
     */
    window.fSelect = {
        'active': null,
        'idx': -1
    };

    function setIndexes($wrap) {
        $wrap.find('.fs-option:not(.hidden)').each(function(i, el) {
            $(el).attr('data-index', i);
            $wrap.find('.fs-option').removeClass('hl');
        });
        //$wrap.find('.fs-search input').focus();
        window.fSelect.idx = -1;
    }

    function setScroll($wrap) {
        var $container = $wrap.find('.fs-options');
        var $selected = $wrap.find('.fs-option.hl');

        var itemMin = $selected.offset().top + $container.scrollTop();
        var itemMax = itemMin + $selected.outerHeight();
        var containerMin = $container.offset().top + $container.scrollTop();
        var containerMax = containerMin + $container.outerHeight();

        if (itemMax > containerMax) { // scroll down
            var to = $container.scrollTop() + itemMax - containerMax;
            $container.scrollTop(to);
        }
        else if (itemMin < containerMin) { // scroll up
            var to = $container.scrollTop() - containerMin - itemMin;
            $container.scrollTop(to);
        }
    }
 $(document).on('click touchstart', '.fs-optgroup-label', function() {
  var selected = [];
  
   var s=0;
       var niz=new Array();
  
  $(this).parent().find('.fs-option').each(function(i, el) {
    
 
     if($(el).attr('class')=="fs-option")   
     {
 
    selected.push($(el).attr('data-value'));
    }
      $(this).toggleClass('selected');          
             });
 
 $(".fs-options").find('.fs-option').each(function(i, el) {
          
            if($(el).attr('class')=="fs-option selected")
            {
             niz[i]=$(el).attr('data-value');
           selected.push($(el).attr('data-value'));
            } 
         //  alert("aa")
           s +=1;  
             });
 
/*var array_flipped=[];
$.each(selected, function(i, el) {
  array_flipped[el]=i;
});*/
//alert(array_flipped[109])
  
     var $wrap = $(this).closest('.fs-wrap');
           
       $wrap.find('select').val(selected);
        $wrap.find('select').fSelect('reloadDropdownLabel');            
             

 if($(".modeli_arr").length>0)
            {
          vr=$(".modeli_arr").val();
          //(
           
          
          nizic=vr.split(",");
          var hh=0;
          niz.forEach(function(entry1) {
          nizic.forEach(function(entry2) {
          
          if(entry1*1==entry2*1)
             {             
           hh +=1;         
             } 
           });
           });
 
          if(hh>0)
          {
          if(hh==1)
          $(".zamodele").fadeIn(400).fadeOut(400).fadeIn(400);
          else
          $(".zamodele").fadeIn();
           if($(".asa").length==0)
           {
          $(".zamodele input").prop('required',true);
          $(".kosa").prop('required',true);
          $(".oci").prop('required',true);
          }
          } 
          else
          {
          $(".zamodele").fadeOut(400);
          if($(".asa").length==0)
           {
          $(".zamodele input").prop('required',false);
          $(".kosa").prop('required',false);
          $(".oci").prop('required',false);
          }
          }
            }
                      
   });  
    $(document).on('click touchstart', '.fs-option', function() { 
        var $wrap = $(this).closest('.fs-wrap');

        if ($wrap.hasClass('multiple')) { 
            var selected = [];

            $(this).toggleClass('selected');
            
            var niz=new Array();
            var h=0;
            $wrap.find('.fs-option.selected').each(function(i, el) {
            
             selected.push($(el).attr('data-value'));
             niz[i]=$(el).attr('data-value');
             h +=1;   
            });
             
            if($(".modeli_arr").length>0 && $(this).attr("rel")=="ohos")
            {
          vr=$(".modeli_arr").val();
          //(beee(vr,niz));
          nizic=vr.split(",");
          var hh=0;
          niz.forEach(function(entry1) {
          nizic.forEach(function(entry2) {
          
          if(entry1*1==entry2*1)
             {             
           hh +=1;         
             } 
           });
           });
           
          if(hh>0)
          {
          $(".zamodele").fadeIn(400).fadeOut(400).fadeIn(400).fadeOut(400).fadeIn(400);
           if($(".asa").length==0)
           {
          $(".zamodele input").prop('required',true);
          $(".kosa").prop('required',true);
          $(".oci").prop('required',true);
          }
          } 
          else
          {
          $(".zamodele").fadeOut(400);
          if($(".asa").length==0)
           {
          $(".zamodele input").prop('required',false);
          $(".kosa").prop('required',false);
          $(".oci").prop('required',false);
          }
          }
            }

            
        }
        else {
            var selected = $(this).attr('data-value');
            
            $wrap.find('.fs-option').removeClass('selected');
            $(this).addClass('selected');
            /* aca izbacio */
            $wrap.find('.fs-dropdown').hide();
            $wrap.find('.fs-dropdown').addClass('hidden');
            
        }

        $wrap.find('select').val(selected);
        $wrap.find('select').fSelect('reloadDropdownLabel');
    });

    $(document).on('keyup', '.fs-search input', function(e) {
        if (40 == e.which) {
            $(this).blur();
            return;
        }

        var $wrap = $(this).closest('.fs-wrap');
        var keywords = $(this).val();

        $wrap.find('.fs-option, .fs-optgroup-label').removeClass('hidden');

        if ('' != keywords) {
            $wrap.find('.fs-option').each(function() {
                var regex = new RegExp(keywords, 'gi');
                if (null === $(this).find('.fs-option-label').text().match(regex)) {
                    $(this).addClass('hidden');
                }
            });

            $wrap.find('.fs-optgroup-label').each(function() {
                var num_visible = $(this).closest('.fs-optgroup').find('.fs-option:not(.hidden)').length;
                if (num_visible < 1) {
                    $(this).addClass('hidden');
                }
            });
        }

        setIndexes($wrap);
    });

    $(document).bind('click touchstart', function(e) { 
        var $el = $(e.target);
        var $wrap = $el.closest('.fs-wrap');
 
        if (0 < $wrap.length) {
            if ($el.hasClass('fs-label')) {
             
                window.fSelect.active = $wrap;
                var is_hidden = $wrap.find('.fs-dropdown').hasClass('hidden');
                $('.fs-dropdown').addClass('hidden');
                 $wrap.find('.fs-dropdown').hide();
 
                if (is_hidden) {
                
                    $wrap.find('.fs-dropdown').removeClass('hidden');
                    $wrap.find('.fs-dropdown').show();
                }
                else {
                    $wrap.find('.fs-dropdown').addClass('hidden');
                    $wrap.find('.fs-dropdown').hide();
                     
                }

                setIndexes($wrap);
            }
        }
        else {
            $('.fs-dropdown').addClass('hidden');
            window.fSelect.active = null;
        }
    });

    $(document).on('keydown', function(e) {
        var $wrap = window.fSelect.active;

        if (null === $wrap) {
            return;
        }
        else if (38 == e.which) { // up
            e.preventDefault();

            $wrap.find('.fs-option').removeClass('hl');

            if (window.fSelect.idx > 0) {
                window.fSelect.idx--;
                $wrap.find('.fs-option[data-index=' + window.fSelect.idx + ']').addClass('hl');
                setScroll($wrap);
            }
            else {
                window.fSelect.idx = -1;
                //$wrap.find('.fs-search input').focus();
            }
        }
        else if (40 == e.which) { // down
            e.preventDefault();

            var last_index = $wrap.find('.fs-option:last').attr('data-index');
            if (window.fSelect.idx < parseInt(last_index)) {
                window.fSelect.idx++;
                $wrap.find('.fs-option').removeClass('hl');
                $wrap.find('.fs-option[data-index=' + window.fSelect.idx + ']').addClass('hl');
                setScroll($wrap);
            }
        }
        else if (32 == e.which || 13 == e.which) { // space, enter
            $wrap.find('.fs-option.hl').click();
        }
        else if (27 == e.which) { // esc
            $('.fs-dropdown').addClass('hidden');
            window.fSelect.active = null;
        }
    });

})(jQuery);

function isMobile() {
 try {///Android|
    if(/webOS|iPhone|iPad|iPod|pocket|psp|kindle|avantgo|blazer|midori|Tablet|Palm|maemo|plucker|phone|BlackBerry|symbian|IEMobile|mobile|ZuneWP7|Windows Phone|Opera Mini/i.test(navigator.userAgent)) {
     return true;
    };
    return false;
 } catch(e){ console.log("Error in isMobile"); return false; }
}


$(function() {
if(isMobile() && $(window).width()<420) 
{ 
$(".pronadji_posao .search .trazenje_posla").css({                 
                "margin-bottom": "3px"                              
            });
            
$(".pronadji_posao .search1 .trazenje_posla").css({                 
                "margin-bottom": "3px"                              
            });            
}

          
    
    });

 
/******************* end novi multiselect ************************/