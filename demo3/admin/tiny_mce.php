<?php
$novi_editor=1;
if($novi_editor==1) {
?>
<script type="text/javascript" src="<?=$patHA?>/tinymce_new/tinymce.min.js"></script>
 <script>
tinyMCE.init({
    selector: 'textarea',
    height: 150,
    theme: 'modern',

    plugins : 'advlist autolink lists link image charmap print preview hr anchor pagebreak image code        searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking save table contextmenu directionality emoticons template paste textcolor colorpicker textpattern spellchecker',
    toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | fontsizeselect',
    toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',

    fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',

    entity_encoding: "raw",
		detect_highcontrast : true,
 		relative_urls : false,
    remove_script_host : false,
    convert_urls : false,

    // enable title field in the Image dialog
    image_title: true,
    // enable automatic uploads of images represented by blob or data URIs
    automatic_uploads: true,
    file_picker_types: 'file image media',
    // without images_upload_url set, Upload tab won't show up
    images_upload_url: '<?=$patHA?>/postAcceptor.php',
    // override default upload handler to simulate successful upload
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr, formData;

        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '<?=$patHA?>/postAcceptor.php');

        xhr.onload = function() {
            var json;

            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }

            json = JSON.parse(xhr.responseText);

            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }

            success(json.location);
        };

        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());

        xhr.send(formData);
    },
    file_picker_callback: function(cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/* audio/* video/*');
        input.onchange = function() {
            var file = this.files[0];

            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function () {
                var id = 'blobid' + (new Date()).getTime();
                var blobCache =  tinymce.get("editor").editorUpload.blobCache; //this is where the error occurs
                var base64 = reader.result.split(',')[1];
                var blobInfo = blobCache.create(id, file, base64);
                blobCache.add(blobInfo);

                // call the callback and populate the Title field with the file name
                cb(blobInfo.blobUri(), { title: file.name });
            };
        };

        input.click();
    }
});
  </script>
<?php
} else {
?>
 <script type="text/javascript" src="<?php echo $patHA?>/tiny_mce1/tiny_mce.js"></script>
  <script type="text/javascript" src="<?php echo $patHA?>/tiny_mce1/plugins/tinybrowser/tb_tinymce.js.php"></script>
<script type="text/javascript">

	tinyMCE.init({
	//	editor_selector : "mceEditor",
    editor_deselector : "mceNoEditor",
		mode : "textareas",
		theme : "advanced",

		 file_browser_callback : "tinyBrowser",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
 theme_advanced_font_sizes : "8px=8px, 10px=10px, 11px=11px, 12px=12px, 13px=13px,  14px=14px, 16px=16px, 18px=18px, 20px=20px, 22px=22px, 24px=24px, 26px=26px",
extended_valid_elements : "script[src|type],"+"iframe[src|class|width|height|name|align]",
  entity_encoding: "raw",

		// Example content CSS (should be your site CSS)
		// using false to ensure that the default browser settings are used for best Accessibility
		// ACCESSIBILITY SETTINGS

		// Use browser preferred colors for dialogs.
		browser_preferred_colors : true,
		detect_highcontrast : true,

 		relative_urls : false,

remove_script_host : false,
        convert_urls : false
	});



function toggleEditor(id) {

if (!tinyMCE.get(id))

tinyMCE.execCommand('mceAddControl', false, id);

else

tinyMCE.execCommand('mceRemoveControl', false, id);

}
</script>
<?php }