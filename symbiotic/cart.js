jQuery.noConflict();
(function($) {
$(document).ready(function(){

var cartpath = 'http://parts.ongmacmotorcycles.com.au';

	$("#symbiotic-cart-path").remove();
	$("body").append("<span style=\"display:none;\" id=\"symbiotic-cart-path\">" + cartpath + "</span>");
	$(".symbiotic").symbiotic();
	$(".symbiotic-img").symbioticImg();
	$(".symbiotic-desc").symbioticDesc();
	$(".symbiotic-items").symbioticShowCart();
	$(".symbiotic-total").symbioticShowTotal();
	$(".symbiotic-count-items").symbioticCountItems();

	$("#cart-form").unbind().bind('submit',function(){
		
		var form = $(this);
		var serialized = $(form).serialize();
		$("#sym-alert").removeClass('alert-success');
		$("#sym-alert").removeClass('alert-danger');
		$("#sym-alert").text('Please wait');
			$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:serialized + "&action=update&ajax=true",
			success: function(html){
			if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
	  				$("#cart-popup").load(cartpath + "/cart.php #cart-body",function(){
	  						$("#cart-popup").removeClass('sym-loading');
							$.getScript(cartpath + '/symbiotic/cart.js');
							$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
	  						});	
			}
		}
		});
		return false;
	});
	$("#cart-form .sym-remove").click(function(){
		var  cmd = $("#cart-form");
		var item_id = $(this).attr("data-item");
		$("#cart-form #item-"+ item_id).val('0');
		var  cmd = $("#cart-form");
		cmd.submit();
	});
	$(".cart-empty-button").click(function(){
	$("#sym-alert").removeClass('alert-success');
		$("#sym-alert").removeClass('alert-danger');
		$("#sym-alert").text('Please wait');
			$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:"&action=empty&ajax=true",
			success: function(html){
						if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
	  				$("#cart-popup").load(cartpath + "/cart.php #cart-body",function(){
					$("#cart-popup").removeClass('sym-loading');
	  						$.getScript(cartpath + '/symbiotic/cart.js');
	  						});
	  					
			}
		}
		});
		
	});
	$("#coupons-form").unbind().bind('submit',function(){
		 
		var form = $(this);
		var coupon = $(form).serialize()
$("#sym-alert").removeClass('alert-success');
		$("#sym-alert").removeClass('alert-danger');
		$("#sym-alert").text('Please wait');
			$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:coupon + "&ajax=true",
			success: function(html){
					if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
	  				$("#cart-popup").load(cartpath + "/cart.php #cart-body",function(){
					$("#cart-popup").removeClass('sym-loading');
	  						$.getScript(cartpath + '/symbiotic/cart.js');
	  						});
			}
		}
		});
		return false;
	});
	$("#coupon-remove").click(function(){
		 
		$("#coupon-input").val(null);
		$("#coupons-form").submit();
		
		
		return false;
		
	});
	
		$(".sym-count").change(function(){
		$("#cart-form").submit();
		});
		$("#cart-checkout-form").unbind().bind('submit',function(){
			
		$("#cartpage").hide();
		$("#checkoutpage").show();
				
			return false;
		});
		$("#cart-edit-button").unbind().bind('click',function(){
		$("#checkoutpage").hide();
		$("#cartpage").show();
		return false;
		});
var n = $("body #cart-popup").length;
if(location.hash == "#cart" && n < 1){
					
					$("body #cart-popup").remove();
					$("body #cart-dialogue").remove();
					$("body").append("<div id='cart-lightbox cart-popup' class='sym-loading'></div><button class='close' id='close-cart-popup'>&times;</button>");
					$("#cart-popup").load(cartpath + "/cart.php #cart-body",function(){
					
						$("#cart-popup").removeClass('sym-loading');$.getScript(cartpath + '/symbiotic/cart.js');
					$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});}
					);
						$("#close-cart-popup").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
}

	$(".symbiotic-lightBox").unbind().bind('click',function(){
					var id = $(this).attr('data-id');
					$("#close-cart-popup").remove();
					$("body #cart-popup").remove();
					$("body #cart-dialogue").remove();
					var width=  window.innerWidth; 
						var height=  window.innerHeight; 
						if(height <= 500 || width <= 724){
						top.location.href=cartpath+"/product-single.php?id="+id;
						}
					$("body").append("<div id='cart-popup' class='cart-lightbox sym-loading'></div><button class='close' id='close-cart-popup'>&times;</button>");
					$("#cart-popup").load(cartpath + "/product-single.php?id="+id+" #product-info",function(){
					$("#cart-popup").removeClass('sym-loading');
					$.getScript(cartpath + '/symbiotic/cart.js');
					}
					);
					$("#close-cart-popup").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
					$("html, body").animate({scrollTop:0},"slow");
					return false;
					});

	$(".showAjaxCart").unbind().bind('click',function(){
					$("body #cart-popup").remove();
					$("#close-cart-popup").remove();
					$("body #cart-dialogue").remove();
						var width=  window.innerWidth; 
						var height=  window.innerHeight; 
						if(height <= 500 || width <= 724){
						top.location.href=cartpath+'/cart.php';
						}
					$("body").append("<div id='cart-popup' class='cart-lightbox sym-loading'></div><button class='close' id='close-cart-popup'>&times;</button>");
					$("#cart-popup").load(cartpath + "/cart.php #cart-body",function(){
					$("#cart-popup").removeClass('sym-loading');
					$.getScript(cartpath + '/symbiotic/cart.js');
					$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});}
					);
					$("#close-cart-popup").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
					$("html, body").animate({scrollTop:0},"slow");
					return false;
					});
	$("#checkout-login").unbind().bind('submit',function(){
	
			var form = $(this);
		var serialized = $(form).serialize();
		$("#sym-alert").text('Please wait');
		$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:serialized +"&ajax=true",
			success: function(html){			if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
						$("#cart-popup").load(cartpath + "/cart.php?checkout #cart-body",function(){
						$.getScript(cartpath + '/symbiotic/cart.js');
	  						$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
	  				});	}
					}
		});
		return false;
	});	
	$("#checkout-by-email").unbind().bind('submit',function(){
	
			var form = $(this);
		var serialized = $(form).serialize();
		$("#sym-alert").text('Please wait');
		$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:serialized +"&ajax=true",
			success: function(html){
						if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
				$("#cart-popup").load(cartpath + "/cart.php?checkout #cart-body",function(){
						$.getScript(cartpath + '/symbiotic/cart.js');
	  						$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
	  				});	}
					}
		});
		return false;
	});
	
	$("#add-address-btn").unbind().bind('click',function(){
	$("#add-address").toggle();
	$("#checkout-form").toggle();
	
	});
	$("#cancel-add-address").unbind().bind('click',function(){
	$("#add-address").toggle();
	$("#checkout-form").toggle();
	
	});
	
		$("#addr-add").unbind().bind('submit',function(){
	
			var form = $(this);
		var serialized = $(form).serialize();
		$("#sym-alert").text('Please wait');
		$("#sym-alert").fadeIn();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:serialized +"&ajax=true",
			success: function(html){
			if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
				$("#cart-popup").load(cartpath + "/cart.php?checkout #cart-body",function(){
						$.getScript(cartpath + '/symbiotic/cart.js');
	  						$("#continue-shopping-btn").click(function(){
					$("#close-cart-popup").remove();
					$("#cart-popup").remove();
					});
	  				});	}
					}
		});
		return false;
	});
	
	
	$("#checkout-form").unbind().bind('submit',function(){
	$("html, body").animate({scrollTop:0},"slow");
	$("#sym-alert").text('Please wait');
			$("#sym-alert").fadeIn();
			var form = $(this);
		var serialized = $(form).serialize();
		$.ajax({
			type:"POST",
			url: cartpath + "/cart.php",
			data:serialized +"&ajax=true",
			success: function(html){
						if( html.indexOf("ERROR:") == 0 ){ 
			var html = html.replace("ERROR:", "");
			$("#sym-alert").text('');
			$("#sym-alert").hide();
			$("#sym-alert").addClass('alert-danger');
			$("#sym-alert").text(html);
			$("#sym-alert").show();
			$("#sym-alert").delay(10000).fadeOut();
			}
			else{
				$("#sym-alert").text('');
				$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
				$("#sym-alert").text(html);
				$("#sym-alert").show();
				
	  				$("body #cart-dialogue").remove();
					$("#sym-alert").text('');
			$("#sym-alert").hide();
				$("#sym-alert").addClass('alert-success');
  			$("#sym-alert").text('Processing your Order');
  			$("#sym-alert").show();
			top.location.href=html;
  					}
						
					}
		});
		return false;
	});
				
					
});

jQuery.fn.symbiotic = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){

		var id = $(this).html();
		var button_text = $(this).attr('data-text');
		var options = $(this).attr('data-options');
		var price = $(this).attr('data-price');
		var name = $(this).attr('data-name');
		var qty = $(this).attr('data-qty');
	//	alert(price);
						
				
		$(this).removeClass('symbiotic');
		$(this).addClass('cart-button');
		$(this).attr('id','pid-'+id);
		var curr = $(this) ;
		$(this).html('Loading..');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/symbiotic/cart-engine.php",
	  		data:"product_id=" + id + "&options=" + options + "&qty=" + qty + "&price=" + price + "&button_text="  + button_text +"&name=" + name + "&type=btn",
	  		success: function(html){
			curr.html(html);
			
					$(".symbiotic-form").unbind().bind('submit',function(){
				var form = $(this);
		var serialized = $(form).serialize();
				$("body #cart-popup").remove();
				$("body #cart-dialogue").remove();
				$("body #close-cart-popup").remove();
					$("body").append("<div id='cart-dialogue' >Adding to Cart</div>");
				/*Thanks  http://eligeske.com/jquery/jquery-sending-multiple-ajax-requests-all-by-itself-kind-of/ */	
				$.ajax({
					type:"POST",
					url: cartpath + "/cart.php",
					data:serialized ,
					success: function(html){
					if( html.indexOf("ERROR:") == 0 ){ 
					$("body #cart-dialogue").addClass("cart-dialogue-error");
					var html = html.replace("ERROR:", "");
					$("body #cart-dialogue").fadeIn().text(html).delay(1600).fadeOut();	
					}else{
					$.getScript(cartpath + '/symbiotic/cart.js');
					$("body #cart-dialogue").fadeIn().text(html).delay(1600).fadeOut();				
					}
					}
				});
				return false;
			});
		}});
	
	});

return false;

};

jQuery.fn.symbioticImg = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){
		var id = $(this).html();
		var size = $(this).attr('data-size');
		var w = $(this).attr('data-w');
		var h = $(this).attr('data-h');
		$(this).addClass('cart-image');
		$(this).removeClass('symbiotic-img');
		var curr = $(this) ;
		$(this).html('Loading image..');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/symbiotic/cart-engine.php",
	  		data:"product_id=" + id + "&size=" + size + "&w=" + w + "&h=" + h + "&type=img",
	  		success: function(html){
			curr.html(html);
		}});
	
	});

return false;

};	
jQuery.fn.symbioticDesc = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){
		var id = $(this).html();
		$(this).addClass('cart-description');
		$(this).removeClass('symbiotic-desc');
		var curr = $(this) ;
		$(this).html('Loading description..');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/symbiotic/cart-engine.php",
	  		data:"product_id=" + id + "&type=desc",
	  		success: function(html){
			curr.html(html);
		}});
	
	});

return false;

};
jQuery.fn.symbioticShowTotal = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){
		var id = $(this).html();
				$(this).addClass('cart-total');
		// $(this).removeClass('symbiotic-total');
		var curr = $(this) ;
		$(this).html('Loading...');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/cart.php",
	  		data:"action=show_total&ajax=true",
	  		success: function(html){
			curr.html(html);
		}});
	
	});

return false;

};
jQuery.fn.symbioticShowCart = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){
		var id = $(this).html();
		$(this).addClass('cart-cart');
		// $(this).removeClass('symbiotic-items');
		var curr = $(this) ;
		$(this).html('Loading Cart..');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/cart.php",
	  		data:"action=show_cart&ajax=true",
	  		success: function(html){
			curr.html(html);
		}});
	
	});

return false;

};
jQuery.fn.symbioticCountItems = function(){
 var cartpath = $("#symbiotic-cart-path").html();
	this.each(function(){
		var id = $(this).html();
		$(this).addClass('cart-count');
		// $(this).removeClass('symbiotic-count-items');
		var curr = $(this) ;
		$(this).html('0');
		$.ajax({
	  		type: "POST",
	  		url: cartpath + "/cart.php",
	  		data:"action=count_cart&ajax=true",
	  		success: function(html){
			curr.html(html);
		}});
	
	});

return false;

};			

})(jQuery);