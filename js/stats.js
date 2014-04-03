/// <reference path="jquery.js"/>

/**
 * 
 */

var _domain = 'admin.epconline.com.au';
var _dealerId = '17a82b70-f7fa-4dbe-889a-e39ac7fc91c5';
var _dateStart = '2011-11-01';
var _dateEnd = '2012-11-01';

$(document).ready(function () {

    // pre-populate date range boxes
	$('.datepicker').datepicker( {dateFormat: 'yy-mm-dd', showOn: 'focus'});
	$('#dateStart').datepicker('setDate', '-1m');	
	$('#dateEnd').datepicker('setDate', new Date());
	
	$('#statsFilterForm').bind('submit', (function(e) {
		e.preventDefault();
		
		_dateStart = $('#dateStart').val();
		_dateEnd = $('#dateEnd').val();
		getModelAccessStats(_dealerId, _dateStart, _dateEnd);
	})); 
});


function getModelAccessStats(dealerId, dateStart, dateEnd) {

	    $.getJSON(

	    'http://' + _domain + '/ModelAccess/GetModelAccessStats/' + dealerId + '/' + dateStart + '/' + dateEnd + '?callback=?',

	    function (data) {

	        $('#StatsTable tbody tr').remove();

	        $.each(data, function (i, item) {

	            var Id = item.ModelAccessId;
	            
	            var dateObj = new Date(parseInt(item.dtAccess.substr(6)));
	            var month = dateObj.getMonth() + 1;
	            var sDate = dateObj.getFullYear() + '-' + month + '-' + dateObj.getDate() + ' T ' + dateObj.getHours() + ':' + dateObj.getMinutes() + ':' + dateObj.getSeconds(); 

	            $('<tr id="modelaccess_' + item.ModelAccessId + '" class="partrow"></tr>')

	            .append('<td>'+ item.ProductName +'</td><td>'+ item.ModelName+'</td><td>'+ item.AssemblyName +'</td><td>'+ item.Year +'</td><td>'+ sDate +'</td><td>'+ item.UserIpAddress +'</td>')

	            .attr('data-productname', item.ProductName)
	            .attr('data-assemblyid', item.AssemblyId)
	            .attr('data-assemblyname', item.AssemblyName)
				.attr('data-modelid', item.ModelId)
				.attr('data-modelname', item.ModelName)
				.attr('data-year', item.Year)
				.attr('data-dtaccess', item.dtAccess )
				.attr('data-useripaddress', item.UserIpAddress )
	            .appendTo('#StatsTable tbody');

	        })

	        $('#StatsTable tr:odd').addClass('odd');

	        $('#ModelAccessStatsContainer').fadeIn();

	    });

	}
