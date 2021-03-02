 

(function($) {
$.fn.serial = function() {
 var array = [];
 var $elem = $(this); 
    $elem.each(function(i) {
      var menu = this.id;
        $('li', this).each(function(e) {
                array.push( menu + '['+e+']=' + this.id  );
        });
    });
    return array.join('&');      
    }
 
})(jQuery);


$(document).ready(function(){


	calcWidth($('#title0'));

	window.onresize = function(event) {
    	console.log("window resized");

    	//method to execute one time after a timer

    };

	//recursively calculate the Width all titles
	function calcWidth(obj){
		//console.log('---- calcWidth -----');

		var titles = 
		$(obj).siblings('.space').children('.route').children('.title');

		$(titles).each(function(index, element){
			var pTitleWidth = parseInt($(obj).css('width'));
			var leftOffset = parseInt($(obj).siblings('.space').css('margin-left'));

			var newWidth = pTitleWidth - leftOffset;

			if ($(obj).attr('id') == 'title0'){
				console.log("called");

				newWidth = newWidth - 10;
			}

			$(element).css({
				'width': newWidth,
			})

			calcWidth(element);
		});

	}


	$('.space').sortable({
		connectWith:'.space',
		// handle:'.title',
		// placeholder: ....,
		tolerance:'intersect',
		over:function(event,ui){ 
			// //Recaculate width of all children
			// var pTitleWidth = parseInt($(this).siblings('.title').css('width').replace('px', ''));
			
			// if ($(this).siblings('.title').attr('id') == 'title0'){
			// 	var newWidth = (pTitleWidth-20).toString().concat('px');
			// }
			// else {
			// 	var newWidth = (pTitleWidth-70).toString().concat('px');
			// }
			
			// console.log(pTitleWidth + ', ' + newWidth);

			// $(ui.item).children('.title').css({
			// 	'width': newWidth,
			// });
		},
		receive:function(event, ui){
			calcWidth($(this).siblings('.title'));
		},
        update: function(event, ui) {
   /* var position = $('.sortable').sortable('serialize', {
            key: 'menu',
            connected: true
        });*/
    $('#aaa').empty().html( $('#zovo').serial() );
    },
     stop: function(){
 
   
      }
	});
	$('.space').disableSelection();





});

