function HondaLib()
{var DealerID='';var _domain='honda-eparts.com.au';var gImage=null;var g=null;var gContext=null;var MinX=0,MinY=0;var _offsetX=0,_offsetY=0,_mouseX,_mouseY,_mouseDownX,_mouseDownY,_mouseMoveX,_mouseMoveY;var _imagePosX,_imagePosY;var _scalefactor=2;var _hitTolerance=50;var zoom,zoomIn,zoomOut,mousePosX,mousePosY,paint;var _Width=400;var _Height=600;var _centreX=_Width/2;var _centreY=_Height/2;var _hotspots=Array();$(document).ready(function(){init();});function init(){DealerID=$.cookies.get('accesskey[honda]');$('<option value="MB">Honda</option>').appendTo('#TypeSelect');$('#TypeSelect').change(function(){var selectedType=$(this).val();getYearshonda(selectedType);});var leftButtonDown=false;$(document).mousedown(function(e){if(e.which===1)leftButtonDown=true;});$(document).mouseup(function(e){if(e.which===1)leftButtonDown=false;});$('#image').mousedown(function(e){_mouseDownX=mousePosX(e);_mouseDownY=mousePosY(e);_mouseMoveX=_mouseDownX;_mouseMoveY=_mouseDownY;_imagePosX=_mouseMoveX-_offsetX;_imagePosY=_mouseMoveY-_offsetY;$('#status').html('_mouseDownX:'+_mouseDownX+', _mouseDownY:'+_mouseDownY);});$('#image').mouseover(function(e){$('#image').css('cursor','move');}).mouseout(function(e){$('#image').css('cursor','default');});function tweakMouseMoveEvent(e){if($.browser.msie&&!(document.documentMode>=9)&&!event.button){leftButtonDown=false;}
if(e.which===1&&!leftButtonDown)e.which=0;}
$('#image').mousemove(function(e){tweakMouseMoveEvent(e);_mouseX=mousePosX(e);_mouseY=mousePosY(e);if(leftButtonDown){var newOffsetX=_offsetX+((_mouseX-_mouseMoveX)*_scalefactor);var newOffsetY=_offsetY+((_mouseY-_mouseMoveY)*_scalefactor);_mouseMoveX=_mouseX;_mouseMoveY=_mouseY;_offsetX=newOffsetX;_offsetY=newOffsetY;paint();}
else{_imagePosX=_mouseX*_scalefactor-_offsetX;_imagePosY=_mouseY*_scalefactor-_offsetY;$('#status').html(_mouseX+', '+_mouseY);var arLen=_hotspots.length;var gotone=false;for(var i=0,len=arLen;i<len;++i){if(((_hotspots[i].RefX>=_imagePosX-_hitTolerance)&&(_hotspots[i].RefX<=_imagePosX+_hitTolerance))&&((_hotspots[i].RefY>=_imagePosY-_hitTolerance)&&(_hotspots[i].RefY<=_imagePosY+_hitTolerance))){gotone=true;$('#image').css('cursor','default');showInfoPopup(_hotspots[i]);highlightPartRow(_hotspots[i]);break;}}
if(gotone==false){$('#image').css('cursor','move');hideInfoPopup();unhighlightPartRow();}}});$("tr.partrow td").live('mouseover',function(){var partid=$(this).parent().attr("data-partid");var arrlen=_hotspots.length;for(var i=0;i<arrlen;i++){if(_hotspots[i].PartID==partid){focusHotspot(_hotspots[i].RefX,_hotspots[i].RefY);break;}}
$(this).css('background-color','#77FF99');}).live('mouseout',function(){$(this).css('background-color','transparent');});$("#zoomIn").click(function(){zoomIn();});$("#zoomOut").click(function(){zoomOut();});gImage=new Image();if(document.getElementById('image')!=null){g=document.getElementById("image");gContext=g.getContext("2d");_Width=g.width;_Height=g.height;}
init_mouse();}
function init_mouse(){if($('#image').offset()!=null){MinX=$('#image').offset().left;MinY=$('#image').offset().top;_centreX=_Width/2;_centreY=_Height/2;}}
mousePosX=function(event){var x=0;if(event.pageX||event.pageX===0){x=event.pageX-MinX;}else if(event.offsetX||event.offsetX===0){x=event.offsetX;}
return x;};mousePosY=function(event){var y=0;if(event.pageY||event.pagerY===0){y=event.pageY-MinY;}else if(event.offsetY||event.offsetY===0){y=event.offsetY;}
return y;};function paint(){var newWidth=_Width*(1/_scalefactor);var newHeight=_Height*(1/_scalefactor);if(document.getElementById('image')!=null)
g=document.getElementById('image');gContext=g.getContext('2d');gContext.save();gContext.scale(1/_scalefactor,1/_scalefactor);gContext.fillStyle=gContext.strokeStyle="#fff";gContext.clearRect(0,0,_Width*_scalefactor,_Height*_scalefactor);gContext.drawImage(gImage,_offsetX,_offsetY);gContext.restore();}
function focusHotspot(Xpos,Ypos){var newOffsetX=Xpos-(_centreX*_scalefactor);var newOffsetY=Ypos-(_centreY*_scalefactor);_offsetX=-newOffsetX;_offsetY=-newOffsetY;$('#status').html("_offsetX : "+newOffsetX+"_offsetY : "+newOffsetY);paint();}
function showInfoPopup(partdata){var hotspotPosX=((partdata.RefX+_offsetX)*(1/_scalefactor))+MinX;var hotspotPosY=((partdata.RefY+_offsetY)*(1/_scalefactor))+MinY;$('#status').html('Got part '+partdata.RefNo);$('<div class="partinfopanel"></div>').html('<h4>'+partdata.PartNo+'</h4><p>'+partdata.Description+'</p>').appendTo('body').css('top',(hotspotPosY+20)+'px').css('left',(hotspotPosX+20)+'px').fadeIn('slow');}
function hideInfoPopup(){$('.partinfopanel').remove();}
function highlightPartRow(partdata){$('#part_'+partdata.PartID+' td').css('background-color','#77FF99');}
function unhighlightPartRow(){$('.partrow td').css('background-color','transparent');}
function zoomIn(){_scalefactor-=0.5;$('#status').html('Scale factor : '+_scalefactor);paint();}
function zoomOut(){_scalefactor+=0.5;$('#status').html('Scale factor : '+_scalefactor);paint();}
function getYearshonda(type,selectedYear){$.getJSON('http://'+_domain+'/Models/Years/'+type+'/'+DealerID+'?callback=?',function(data){$('#YearSelect option').remove();$('#YearSelect').change(function(){var selectedType=$('#TypeSelect').val();var thisYear=$(this).val();getModelsForYear(selectedType,thisYear);return false;});$('<option value="-1">Please select a Year</option>').appendTo('#YearSelect')
$.each(data,function(i,item){if(!item.match('~')){$('<option id="ModelYear_'+item+'">'+item+'</option>').attr('selected',item==selectedYear).appendTo('#YearSelect');}});});}
function getModelsForYear(type,year,selectedModelID){$.getJSON('http://'+_domain+'/Models/'+type+'/Year/'+year+'/'+DealerID+'?callback=?',function(data){$('#ModelSelect option').remove();$('#ModelSelect').change(function(){var modelId=$(this).children(":selected").attr("data-modelid");getAssembliesForModel(modelId);getAccessoriesForModel(modelId);getAdrAssembliesForModel(modelId);return false;});$('<option value="-1">Please select a Model</option>').appendTo('#ModelSelect');$.each(data,function(i,item){$('<option id="model_'+item.ModelID+'">'+item.MODEL+'</option>').attr('data-modelid',item.ModelID).attr('selected',item.ModelID==selectedModelID).appendTo('#ModelSelect');});});}
function getAssembliesForModel(modelId){$.getJSON('http://'+_domain+'/Assembly/Model/'+modelId+'/'+DealerID+'?callback=?',function(data){$('#AssemblySelect option').remove();$('#AssemblySelect').change(function(){var assId=$(this).children(":selected").attr("data-assid");getPartsForAssembly(modelId,assId);return false;});$('<option value="-1">Please select an Assembly</option>').appendTo('#AssemblySelect')
$.each(data,function(i,item){$('<option id="assembly_'+item.AssemblyID+'">'+item.AddressNo+' - '+item.Name+'</option>').attr('data-assid',item.AssemblyID).appendTo('#AssemblySelect')});});}
function getAccessoriesForModel(modelId){$.getJSON('http://'+_domain+'/Accessory/Model/'+modelId+'/'+DealerID+'?callback=?',function(data){$('#AccessorySelect option').remove();$('#AccessorySelect').change(function(){var assId=$(this).children(":selected").attr("data-assid");getPartsForAssembly(modelId,assId);return false;});$('<option value="-1">Please select an Accessory</option>').appendTo('#AccessorySelect')
$.each(data,function(i,item){$('<option id="accessory_'+item.AssemblyID+'">'+item.AddressNo+' - '+item.Name+'</option>').attr('data-assid',item.AssemblyID).appendTo('#AccessorySelect')});});}
function getAdrAssembliesForModel(modelId){$.getJSON('http://'+_domain+'/AdrAssembly/Model/'+modelId+'/'+DealerID+'?callback=?',function(data){$('#AdrAssemblySelect option').remove();$('#AdrAssemblySelect').change(function(){var assId=$(this).children(":selected").attr("data-assid");getPartsForAssembly(modelId,assId);return false;});$('<option value="-1">Please select an Assembly</option>').appendTo('#AdrAssemblySelect')
$.each(data,function(i,item){$('<option id="adrassembly_'+item.AssemblyID+'">'+item.AddressNo+' - '+item.Name+'</option>').attr('data-assid',item.AssemblyID).appendTo('#AdrAssemblySelect')});});}
function getPartsForAssembly(modelId,assemblyId){$("#asembly").val(assemblyId);$("#models").val(modelId);$.getJSON('http://'+_domain+'/Part/Assembly/'+modelId+'/'+assemblyId+'/'+DealerID+'?callback=?',function(data){$('#PartsList tbody tr').remove();_hotspots.length=0;$.each(data,function(i,item){var partId=item.PartID;_hotspots.push(item);$('<tr id="part_'+item.PartID+'" class="partrow"></tr>').append('<td><input type="checkbox" id="chk_'+item.PartID+'"></input></td><td>'+item.RefNo+'</td><td>'+item.Description+'</td><td>'+item.PartNo+'</td><td>'+item.SsPartNo+'</td><td>'+item.Quantity+'</td><td>'+item.Price+'</td><td><input type="button" id="btnAdd_'+item.PartID+'" class="btnAdd"  onclick="javascript:addto_cart()" value="Add to Cart"></input></td>').attr('data-partid',item.PartID).attr('data-partno',item.PartNo).attr('data-quantity',item.Quantity).attr('data-price',item.Price).attr('data-refno',item.RefNo).attr('data-descrp',item.Description).appendTo('#PartsList tbody');})
$('#PartsListContainer').fadeIn();});}}