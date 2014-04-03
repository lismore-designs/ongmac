/***
 * Javascript file to handle interaction with Honda EPC Online 
 * This sample code is supplied as is to give basic functionality
 * of an online parts browser including a hotspotted parts diagram
 * 
 * Copyright (C) 2011 by K & K Computech

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
 */
var DealerID='';

var _domain = 'honda-eparts.com.au';


var gCanvas = null; // the canvas

var gContext = null;    // the context

var canvasMinX = 0, canvasMinY = 0;

var _offsetX = 0, _offsetY = 0, _mouseX, _mouseY, _mouseDownX, _mouseDownY, _mouseMoveX, _mouseMoveY;

var _imagePosX, _imagePosY;

var _scalefactor = 2;

var _scalefactor_zoomin = 2;

var _scalefactor_zoomout = 2;

var _hitTolerance = 50;

var zoom, zoomIn, zoomOut, mousePosX, mousePosY, paint;



var _canvasWidth = 920; // gContext.canvas.width;

var _canvasHeight = 565; // gContext.canvas.height;

var _centreX = _canvasWidth / 2;

var _centreY = _canvasHeight / 2;



var _hotspots = Array();



$(document).ready(function () { 

	init();

	init_mouse();
	
	show_count();

});

// contains function
function contains(arr, findValue) {
    var i = arr.length;

    while (i--) {
        if (arr[i] === findValue) return true;
    }
    return false;
}

/***
 * init function
 * Call this first to set things up
 */
function init(){

    // hide the parts list

    $('#AssemblyContainer').attr("class", "hide");

	 DealerID = $.cookies.get('accesskey[honda]');

    var ConfiguredProductTypes = $.cookies.get('epcconfig[honda]');

    var arrCfg = ConfiguredProductTypes.split(",");
    if (arrCfg.length > 1) {
        $('#TypeSelect option').remove();

        $('<option value="-1">Please select a Type</option>')

        .appendTo('#TypeSelect');

        if (contains(arrCfg, "MA")){
            $('<option value="MA">Marine</option>')
            .appendTo('#TypeSelect');
        }

        if (contains(arrCfg, "MB")){
            $('<option value="MB">Motorcycle</option>')
            .appendTo('#TypeSelect');
        }

        if (contains(arrCfg, "GP")){
            $('<option value="GP">Power Equipment</option>')
            .appendTo('#TypeSelect');
        }
    }
    else {
        $('#TypeSelect').remove();

        $('<input id="TypeSelect" type="hidden" />')
            .val(arrCfg)
            .appendTo('#TypeSelection');
        getYears("MB");
    }
    $('#status').hide();

    

//    if ($.browser.msie && !(document.documentMode >= 9) ) {
//
//    	_scalefactor = 1;
//
//
//
//    	$('#DiagramControls').hide();
//
//    }
//
//    else {

    	_scalefactor = 2;

//    }

    

	// handle click from Type Selection

    $('#TypeSelect').change(function () {

        var selectedType = $(this).val();

		//document.getElementById('wrapper').style.display='block';		

        getYears(selectedType);

	});



    var leftButtonDown = false;

    $("#imageCanvas").mousedown(function (e) {

        // Left mouse button was pressed, set flag

        if (e.which === 1) leftButtonDown = true;

    });



    $("#imageCanvas").mouseup(function (e) {

        // Left mouse button was released, clear flag

        if (e.which === 1) leftButtonDown = false;

    });





    $('#imageCanvas').mousedown(function (e) {

        _mouseDownX = mousePosX(e);

        _mouseDownY = mousePosY(e);



        _mouseMoveX = _mouseDownX;

        _mouseMoveY = _mouseDownY;



        // calculate position on image

        _imagePosX = _mouseMoveX - _offsetX;

        _imagePosY = _mouseMoveY - _offsetY;



        $('#status').html('_mouseDownX:' + _mouseDownX + ', _mouseDownY:' + _mouseDownY);

    });



    $('#imageCanvas').mouseover(function (e) {

        $('#imageCanvas').css('cursor', 'move');

    }).mouseout(function (e) {

        $('#imageCanvas').css('cursor', 'default');

    });



    function tweakMouseMoveEvent(e) {

        // Check from jQuery UI for IE versions < 9
//
//        if ($.browser.msie && !(document.documentMode >= 9) && !event.button) {
//
//           // leftButtonDown = false;
//
//        }



        // If left button is not set, set which to 0

        // This indicates no buttons pressed

        if (e.which === 1 && !leftButtonDown) e.which = 0;

    }







    $('#imageCanvas').mousemove(function (e) {

        // Call the tweak function to check for LMB and set correct e.which

        tweakMouseMoveEvent(e);

        _mouseX = mousePosX(e);

        _mouseY = mousePosY(e);



        if (leftButtonDown) {



            var newOffsetX = _offsetX + ((_mouseX - _mouseMoveX) * _scalefactor);

            var newOffsetY = _offsetY + ((_mouseY - _mouseMoveY) * _scalefactor);



            _mouseMoveX = _mouseX;

            _mouseMoveY = _mouseY;



            _offsetX = newOffsetX;

            _offsetY = newOffsetY;



            $('#status').html("'Left Mouse Down- _offsetX : " + newOffsetX + "_offsetY : " + newOffsetY);

            

            paint();

        }

        else {



            // calculate position on image

            _imagePosX = _mouseX * _scalefactor - _offsetX;

            _imagePosY = _mouseY * _scalefactor - _offsetY;



            $('#status').html(_mouseX + ', ' + _mouseY);



            // perform hit test



            var arLen = _hotspots.length;

            var gotone = false;

            for (var i = 0, len = arLen; i < len; ++i) {

                if (((_hotspots[i].RefX >= _imagePosX - _hitTolerance) && (_hotspots[i].RefX <= _imagePosX + _hitTolerance))

                    && ((_hotspots[i].RefY >= _imagePosY - _hitTolerance) && (_hotspots[i].RefY <= _imagePosY + _hitTolerance))) {

                    // popup part info

                    gotone = true;

                    $('#imageCanvas').css('cursor', 'default');



                    showInfoPopup(_hotspots[i]);

                    highlightPartRow(_hotspots[i]);

                    break;

                }

            }



            if (gotone == false) {

                $('#imageCanvas').css('cursor', 'move');

                hideInfoPopup();

                unhighlightPartRow();

            }

        }

    });



$(document).on('mouseover','tr.partrow', function () {

        // get partid

        var partid = $(this).parent().attr("data-partid");

        // index into hotspots array

        var arrlen = _hotspots.length;

        for (var i = 0; i < arrlen; i++) {

            if (_hotspots[i].PartID == partid) {

                // have found the part info here

                //focusHotspot(_hotspots[i].RefX, _hotspots[i].RefY);

                break;

            }

        }



        // $('#status').html("PartID : " + partid);

        // hilight this row

        $(this).css('background-color', '#fff');

    }).on('mouseout', 'tr.partrow', function () {

        $(this).css('background-color', 'transparent');

    });



    $("#zoomIn").click(function () {

        zoomIn();

    });



    $("#zoomOut").click(function () {



        zoomOut();

    });

    $(document).on('change','input[type="text"].qtyTextbox', function() {
        var newqty = $(this).val();
        $(this).parent().parent().attr('data-orderqty', newqty);
    });

    // This function handles the 'Add to cart' button
    // You can extend this to pass info to the shopping cart
    $(document).on('click','input[type="button"].btnAddToCart', function() {
		
		$.colorbox({scrolling:false,transition:"none",width:"400px",height:"200px", inline:true, href:"#add_to_cart_done", closeButton:false, overlayClose:0, escKey:false,photo:true});
		
		$("#add_to_cart_done").show();
		
        var partid = $(this).attr('data-partid');
        var partinfo = $(this).parent().parent().attr('data-partno');
        var quantity = $(this).parent().parent().attr('data-orderqty');
		var partdesc = $(this).parent().parent().attr('data-descrp');
		var partprice = $(this).parent().parent().attr('data-price');
      
		
		
		
			var dataString = 'partinfo='+partinfo+'&partid='+partid+'&product_name='+partdesc+'&product_price='+partprice+'&product_description='+partdesc+'&product_stock='+quantity+'&product_shipping=15&product_shipping_region=1';
			
			$.ajax({
			type: "POST",
			url: "http://parts.ongmacmotorcycles.com.au/symbiotic/admin/product-add.php",
			data: dataString,
			cache: false,
				success: function(pid)
				{
				
					
					var dataString_cart = 'product_id='+pid+'&action=add&ajax=true&qty='+quantity+'';
					$.ajax({
					type: "POST",
					url: "http://parts.ongmacmotorcycles.com.au/cart.php",
					data: dataString_cart,
					cache: false,
						success: function(html)
						{
							
							
							show_count();
							$.colorbox.close(); 
							$("#add_to_cart_done").hide();
							
							
							
									
						}
					}); 		
				}
			});
		
		
		
		
    });


	gImage = new Image();

	if(document.getElementById('imageCanvas')!=null){

    gCanvas = document.getElementById('imageCanvas');

    gContext = gCanvas.getContext('2d');

    _canvasWidth = gCanvas.width;

    _canvasHeight = gCanvas.height;

	}

	

}

function show_count()
{
	var dataString_cart = 'action=count_cart_prod';
					$.ajax({
					type: "POST",
					url: "http://parts.ongmacmotorcycles.com.au/cart.php",
					data: dataString_cart,
					cache: false,
						success: function(value_count)
						{
							
							if(value_count == ''){
								$("#cart_count_front").html('Cart (0)');	
							}
							else
							{
								$("#cart_count_front").html('Cart ('+value_count+')');	
							}
							
						
								
						}
					}); 			
}



function init_mouse() {

	if($('#imageCanvas').offset()!=null){

    canvasMinX = $('#imageCanvas').offset().left;

    canvasMinY = $('#imageCanvas').offset().top;

	}

    _centreX = _canvasWidth / 2;

    _centreY = _canvasHeight / 2;

}



function mousePosX(event) {

    // Get the mouse position relative to the canvas element.

    var x = 0;



    if (event.pageX || event.pageX === 0) { // Firefox

        x = event.pageX - canvasMinX;

    } else if (event.offsetX || event.offsetX === 0) { // Opera

        x = event.offsetX;

    }



    return x;

};



function  mousePosY(event) {

    var y = 0;



    if (event.pageY || event.pagerY === 0) { // Firefox

        y = event.pageY - canvasMinY;

    } else if (event.offsetY || event.offsetY === 0) { // Opera

        y = event.offsetY;

    }



    return y;

};



function paint() {

    var newWidth = _canvasWidth * (1 / _scalefactor);

    var newHeight = _canvasHeight * (1 / _scalefactor);

	if(document.getElementById('imageCanvas')!=null)

    gCanvas = document.getElementById('imageCanvas');

    gContext = gCanvas.getContext('2d');

    gContext.save();

    //gContext.translate(-((newWidth - _canvasWidth) / 2), -((newHeight - _canvasHeight) / 2));

    //gContext.scale(1 / _scalefactor, 1 / _scalefactor);

if(_scalefactor <=0 ){

		_scalefactor = 0.5;

		gContext.scale(1 / _scalefactor, 1 / _scalefactor);

	}

	else{

    	gContext.scale(1 / _scalefactor, 1 / _scalefactor);

	}



    gContext.fillStyle = gContext.strokeStyle = "#fff";

    //

    // Clear

    //

    gContext.clearRect(0, 0, _canvasWidth * _scalefactor, _canvasHeight * _scalefactor);

    gContext.drawImage(gImage, _offsetX, _offsetY);

    gContext.restore();



}





function focusHotspot(Xpos, Ypos) {

    // calculate offsets required to position hotspot in centre of canvas

    var newOffsetX = Xpos - (_centreX * _scalefactor);// * (1 / _scalefactor);

    var newOffsetY = Ypos - (_centreY * _scalefactor); // * (1 / _scalefactor);



    _offsetX = - newOffsetX;

    _offsetY = - newOffsetY;



    //alert("_offsetX : " + newOffsetX + "_offsetY : " + newOffsetY);



    $('#status').html("_offsetX : " + newOffsetX + "_offsetY : " + newOffsetY);

    paint();



}



function showInfoPopup(partdata) {

    // get hotspot position relative to page

    // first get relative to canvas

    var hotspotPosX = ((partdata.RefX + _offsetX) * (1 / _scalefactor)) + canvasMinX;

    var hotspotPosY = ((partdata.RefY + _offsetY) * (1 / _scalefactor)) + canvasMinY;



    $('#status').html('Got part ' + partdata.RefNo);

    $('<div class="partinfopanel"></div>')

        .html('<h4>' + partdata.PartNo + '</h4><p>'+partdata.Description+'</p>')

        .appendTo('body')

        .css('top', (hotspotPosY + 20) + 'px')

        .css('left', (hotspotPosX + 20) + 'px')

        .fadeIn('slow');

}



function hideInfoPopup() {

    $('.partinfopanel').remove();

}



function highlightPartRow(partdata) {
//alert('hilight');
    $('#part_' + partdata.PartID +' td').addClass('hilight');

}



function unhighlightPartRow() {

    //$('.partrow td').css('background-color', 'transparent');
    $('.partrow td').removeClass('hilight');

}



function zoomIn() {

    _scalefactor -= 0.5;

    $('#status').html('Scale factor : ' + _scalefactor);

    paint();

}



function zoomOut() {

    _scalefactor += 0.5;

    $('#status').html('Scale factor : ' + _scalefactor);

    paint();

}



    

/*function getProductsByVin(vin) {

    $.getJSON(

    'http://' + _domain + '/Products/Vin/' + vin + '/' + DealerID,

    function (data) {

        if (data != null) {

            $.each(data, function (i, item) {

                var productId = item.ProductID;

                var selectedType = item.Type;

                var thisYear = item.Year;

                var model = item.Model;

                setTypeSelector(selectedType);

                getYears(selectedType, thisYear);

                getModelsForYear(selectedType, thisYear, productId);

                getContentForModel(productId);

            });

        }

        else {

            alert('Sorry, that VIN could not be found');

        }

    });

}*/



function setTypeSelector(selType) {

    $('select#TypeSelect')

        .children()

        .attr('selected', function (i, selected) {

            return $(this).val() == selType;

        });

}





function getYears(type, selectedYear) {
	
    if (typeof type != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Models/Years/' + type + '/'+ DealerID + '?callback=?',
        function (data) {
            // first delete any content
            $('#YearSelect option').remove();
            $('#YearSelect')
                .unbind('change')
                .change(function () {
					
                    // clear Models droplist
                    $('#ModelSelect option').remove();
                    // clear Assemblies droplist
                    $('#AssemblySelect option').remove();
                    // clear Accessories droplist
                    $('#AccessorySelect option').remove();
                    // clear AdrAssemblies droplist
                    $('#AdrAssemblySelect option').remove();



                    var selectedType = $('#TypeSelect').val();

                    var thisYear = $(this).val();

                    

				
	getModelsForYear(selectedType, thisYear);

                    return false;

                });

          
			
			$('<option value="-1">Please select a year</option>')

                .appendTo('#YearSelect')



            $.each(data, function (i, item) {
              if(!item.match('~')){ // ~ checking
                    $('<option id="ModelYear_' + item + '">' + item + '</option>')
                    .attr('selected', item == selectedYear)
                    .appendTo('#YearSelect');
               }
            });

        });
    }
}



function getModelsForYear(type, year, selectedModelID) {
    if ((typeof type != 'undefined') && (typeof year != 'undefined')) {
        $.getJSON(
        'http://' + _domain + '/Models/' + type + '/Year/' + year + '/' + DealerID + '?callback=?',

        function (data) {
            $('#ModelSelect option').remove();
            $('#ModelSelect')
                .unbind('change')
                .change(function () {
                    // clear Assemblies droplist
                    $('#AssemblySelect option').remove();
                    // clear Accessories droplist
                    $('#AccessorySelect option').remove();
                    // clear AdrAssemblies droplist
                    $('#AdrAssemblySelect option').remove();

                    var modelId = $(this).children(":selected").attr("data-modelid");
					
                    getModelImage(modelId);
                    getAssembliesForModel(modelId);
                    getAccessoriesForModel(modelId);
                    getAdrAssembliesForModel(modelId);
                   
				   
				  
				   
				   
                    return false;
                });

            $('<option value="-1">Please select a Model</option>')
                .appendTo('#ModelSelect');

            $.each(data, function (i, item) {

                $('<option id="model_' + item.ModelID + '">' + item.MODEL + '</option>')
                .attr('data-modelid', item.ModelID)
                .attr('selected', item.ModelID == selectedModelID)
                .appendTo('#ModelSelect');
            });

				

        });
    }
}

function getAssembliesForModel(modelId) {
    if (typeof modelId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Assembly/Model/' + modelId + '/' + DealerID + '?callback=?',
        function (data) {
            $('#AssemblySelect option').remove();
            $('#AssemblySelect')
                .unbind('change')
                .change(function () {
                    // clear Accessories droplist
                    $('#AccessorySelect').val(-1);
                    // clear AdrAssemblies droplist
                    $('#AdrAssemblySelect').val(-1);

                    // use substring to remove 'assembly_'
                    var assId = $(this).children(":selected").attr("data-assid");
                    //alert(assId);
                    getAssemblyImage(assId);
                    getPartsForAssembly(modelId, assId);
                    return false;
                });

            $('<option value="-1">Please select an assembly</option>')
                .appendTo('#AssemblySelect');

            $.each(data, function (i, item) {
                $('<option id="assembly_' + item.AssemblyID + '">'+ item.AddressNo + ' - ' + item.Name + '</option>')
                .attr('data-assid', item.AssemblyID)
                .appendTo('#AssemblySelect')
            });
        });
    }
}

function getAssembliesForModel2(modelId,selectedAssemblyID) {
    if (typeof modelId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Assembly/Model/' + modelId + '/' + DealerID + '?callback=?',

        function (data) {
            $('#AssemblySelect option').remove();
            $('#AssemblySelect')
                .unbind('change')
                .change(function () {
                    // clear Accessories droplist
                    $('#AccessorySelect').val(-1);
                    // clear AdrAssemblies droplist
                    $('#AdrAssemblySelect').val(-1);
                    var assId = $(this).children(":selected").attr("data-assid");
                    getAssemblyImage(assId);
                    getPartsForAssembly(modelId, assId);
                    return false;
                });

            $('<option value="-1">Please select an assembly</option>')

                .appendTo('#AssemblySelect');



            $.each(data, function (i, item) {
                $('<option id="assembly_' + item.AssemblyID + '">'+ item.AddressNo + ' - ' + item.Name + '</option>')
                .attr('data-assid', item.AssemblyID)
                .attr('selected', item.AssemblyID == selectedAssemblyID)
                .appendTo('#AssemblySelect')
            });

        });
    }
}

function getAccessoriesForModel(modelId) {
    if (typeof modelId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Accessory/Model/' + modelId + '/' + DealerID + '?callback=?',

        function (data) {
            //alert(data);
            $('#AccessorySelect option').remove();
            $('#AccessorySelect')
                .unbind('change')
                .change(function () {
                    // clear Assemblies droplist
                    $('#AssemblySelect').val(-1);
                    // clear AdrAssemblies droplist
                    $('#AdrAssemblySelect').val(-1);

                    var assId = $(this).children(":selected").attr("data-assid");

                    getAssemblyImage(assId);
                    getPartsForAssembly(modelId, assId);
                    return false;
                });

            $('<option value="-1">Please select an accessory</option>')

                .appendTo('#AccessorySelect')

            $.each(data, function (i, item) {
                $('<option id="accessory_' + item.AssemblyID + '">' + item.AddressNo + ' - ' + item.Name + '</option>')
                .attr('data-assid', item.AssemblyID)
                .appendTo('#AccessorySelect')
            });

        });
    }
}

function getAdrAssembliesForModel(modelId) {
    if (typeof modelId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/AdrAssembly/Model/' + modelId + '/' + DealerID + '?callback=?',
        function (data) {
            $('#AdrAssemblySelect option').remove();
            $('#AdrAssemblySelect')
                .unbind('change')
                .change(function () {

                    // clear Assemblies droplist
                    $('#AssemblySelect').val(-1);
                    // clear AdrAssemblies droplist
                    $('#AccessorySelect').val(-1);

                    var assId = $(this).children(":selected").attr("data-assid");
                    getAssemblyImage(assId);
                    getPartsForAssembly(modelId, assId);
                    return false;
                });

            $('<option value="-1">Please select an ADR assembly</option>')
                .appendTo('#AdrAssemblySelect');

            $.each(data, function (i, item) {
                $('<option id="adrassembly_' + item.AssemblyID + '">' + item.AddressNo + ' - ' + item.Name + '</option>')
                .attr('data-assid', item.AssemblyID)
                .appendTo('#AdrAssemblySelect')
            });
			
        });
    }
}

function getPartsForAssembly(modelId, assemblyId) {

  // alert('getting parts for assembly ' + assemblyId);
    if ((typeof modelId != 'undefined') && (typeof assemblyId != 'undefined')) {
        $.getJSON(
        'http://' + _domain + '/Part/Assembly/' + modelId + '/' + assemblyId + '/' + DealerID + '?callback=?',
        function (data) {
            $('#AssemblyContainer').attr("class"," ");
            $('#AssemblyContainer').fadeIn();
            $('#PartsList tbody tr').remove();
            // clear hotspot array
            _hotspots.length = 0;

            $.each(data, function (i, item) {
                var partId = item.PartID;

                // put the item in the hotspot array
                _hotspots.push(item);
                 // handle supersessioned parts - Display Supersession part no and Price
                 var PartNoCell;
                 var itemPrice = 0.00;
                 var  itemPartID="";

                 if (item.SsPartNo != null) {
                     PartNoCell = "<td class=\"supersession\">"+item.SsPartNo+"</td>";
                     itemPrice = item.SsPrice;
                     itemPartID = item.SsPartNo;
                 }

                 else {
                    PartNoCell= "<td>"+item.PartNo+"</td>";
                    itemPrice = item.Price;
                    itemPartID = item.PartNo;
                 }

                if(itemPrice){
                 clm ='<td><input type="button" id="btnAdd_' + item.PartID + '" data-partid="'+ item.PartID +'" data-partno="'+ itemPartID +'" class="productContentfooterLeft btnAddToCart" value="Add to Cart"></input></td>';
                }
                 else{
                  /*clm ='<td><input type="button" value="Contact store" rel="facebox" class="contactstore" id="btn_' + item.PartID + '_'+item.Description+'" /></td>';*/
                  clm ='<td><a href="contact_store.php?desc='+item.Description+'&product_id='+item.PartID+' " class="contactstore" rel="facebox">Contact Store</a></td>';
                 }



                $('<tr id="part_' + item.PartID + '" class="partrow"></tr>')
                .append('<td class="refCol"><input  id="chk_' + item.PartID + '" type="hidden"></input>' + item.RefNo + '</td><td class="text descCol">' + item.Description + '</td>' + PartNoCell + '<td class="numberCol">' + item.Quantity + '</td><td><input name="qty_'+item.PartID+'" id="qty_'+item.PartID+'" type="text" class="qtyTextbox"  value="1"/></td><td>'+ itemPrice+'</td>')
                .append(clm)

                .attr('data-partid', item.PartID)
                .attr('data-partno', itemPartID)
                .attr('data-quantity', item.Quantity)
                .attr('data-orderqty', 1)
                .attr('data-price', itemPrice)
                .attr('data-refno', item.RefNo)
                .attr('data-sspartno', item.SsPartNo)
                .attr('data-descrp', item.Description)

                .appendTo('#PartsList tbody');

        }
        )

        $("a.contactstore[rel*=facebox]").facebox({

            loadingImage : "images/loading.gif",
            closeImage   : "images/closelabel.png"
          });

          $('#PartsList tr:odd').addClass('odd');
          $('#PartsListContainer').fadeIn();
       });

    }
}


function logStatus(statusText) {

    $('textarea#statuslog').val($('textarea#statuslog').val() + '\n' + statusText);

}

function clearLog() {

    $('textarea#statuslog').val('');

}

function getModelImage(modelId) {

    if (typeof modelId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Model/Image/' + modelId + '/' + DealerID + '?callback=?',

        function (data) {
            clearLog();
            logStatus('Image Received');

            $('div#imageWrap img').remove();
            $('div#imageWrap .modelImageContainer').remove();

            if (data.length > 0) {
                $.each(data, function (i, item) {
                    var modelImage = new Image();
                    modelImage.src = 'http://' + _domain + '/Image/getImage/' + item.Key + '/type/' + item.Value;
                    $('<img class="modelImage">')
                        .attr('src', modelImage.src)
                        .addClass('this')
                        .appendTo($('<div class="modelImageContainer"></div>')
                            .appendTo($('div#imageWrap'))
                        )
                        .hide()
                        .load(function() {
                            $(this).fadeIn();
                        });


                });

            }

            else {
                logStatus('No Image');
            }
        }
        );
    }
}


function getAssemblyImage(assemblyId) {
    if (typeof assemblyId != 'undefined') {
        $.getJSON(
        'http://' + _domain + '/Assembly/Image/' + assemblyId + '/' + DealerID + '?callback=?',

        function (data) {
            $('#status').html('Image Received');
            if(document.getElementById('imageCanvas')){
                gCanvas = document.getElementById('imageCanvas');
                gCanvas.width = gCanvas.width;
            }

            _offsetX, _offsetY = 0;

            gImage.onload = function () {
                $('#status').html('Image Loaded');
                paint();
            }

            gImage.src = 'http://' + _domain + '/Image/getImage/' + data.Key + '/type/' + data.Value;
        });
    }
}

 $(document).on('click','input.contactstore', function () {

	var urlpart=$(this).attr("id").split("_");	

	$(location).attr('href',"contactus.php?product_id="+urlpart[1]+"&desc="+urlpart[2]+"&part=honda");

});

