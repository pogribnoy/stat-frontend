var containers = {};
var entities = {};

$(document).ready(function() {
	$.views.settings.debugMode(true); // DEBUG
	$.notifyDefaults({
		type: 'danger',// warning, success
		icon: 'glyphicon glyphicon-star',
		icon_type: 'class',
		allow_dismiss: true,
		newest_on_top: true,
		//mouse_over: 'pause',
		delay: 5000,				
		//type: 'minimalist',
		z_index: 2031,
		placement: {
			from: "top",
			align: "center"
		},
	});
	
	$.fn.select2.defaults.set( "theme", "bootstrap" );
	
	$("select.extended").select2();
});


/* Отображает уведомления об ошибках
* @error - поле с ошибками из ответа сервера (json.error) или подготовленный самостоятельно объект
* @container_id - идентификатор контейнера, в котором надо отображать
*/
function handleAjaxError(error, container_id){
	if(error) {
		// контейнер для вывода уведомления
		var container;
		if(container_id) container = containers[container_id];
		
		var len = error.messages.length;
		for(var i = 0; i < len; i++){
			var msg = error.messages[i];
			var title = msg.code ? msg.code + '. ' : '';
			title += msg.title ? msg.title : 'Ошибка'
			$.notify({
				// options
				title: title,
				message: msg.msg
			},{
				// settings
				type: 'danger',// warning, success
				icon: 'glyphicon glyphicon-star',
			});
		}
		return true;
	}
	return false;
}

/* Отображает уведомления об успешных событиях
* @success - поле с сообщениями из ответа сервера (json.success) или подготовленный самостоятельно объект
* @container_id - идентификатор контейнера, в котором надо отображать
*/
function handleAjaxSuccess(success, container_id){
	var container;
	if(container_id) container = containers[container_id];
	
	if(success) {
		var len = success.messages.length;
		var delay = 10000;
		for(var i = 0; i < len; i++, delay+=delay){
			var msg = success.messages[i];
			var title = msg.code ? msg.code + '. ' : '';
			title += msg.title ? msg.title : 'Операция успешна'
			var n = $.notify({
				// options
				title: title,
				message: msg.msg
			},{
				// settings
				type: 'success',// warning, danger
				delay: delay,
			});
			//console.log(n);
		}
		return true;
	}
	return false;
}