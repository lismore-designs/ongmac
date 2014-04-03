
/****************************************************************/
/*	Symbiotic 5	http://superblab.com/symbiotic					*/
/*	File Last Modified:(20/12/2013)								*/
/*	Copyright SuperbLab 2014									*/
/****************************************************************/

jQuery.noConflict();
(function($) {
$(document).ready(function(){
$("#img_init").click(function(){
$("#uploadfile").click();
return false;
});

$("#print-Button").unbind().bind('click',function(){
	 
	$('#printable-area').printElement({
		leaveOpen:true,
        printMode:'popup',
        pageTitle:'Invoice.html'
        	});
	return false;
});

$("form").unbind().bind('submit',function(){
	$("#message").html('Please wait..');
	$("#message").fadeIn();
});

});
})(jQuery);