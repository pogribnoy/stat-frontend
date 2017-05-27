$(document).ready(function() {
	if ($.fn.select2) {
		$.fn.select2.defaults.set( "theme", "bootstrap");
		$("select.extended").select2();
	}
});

function organizationRequest(container_id, expenseID) {
	// родительский контейнер (скроллер), элемент которого открываем
	var container = containers[container_id];
	var scroller = container.data;
	
	var orgID = null;
	for(var i=0; i<scroller.count; i++){
		if(scroller.items[i].fields.id.value == expenseID) {
			orgID = scroller.items[i].fields.organization.value_id;
			break;
		}
	}
	
	// запрашиваем с сервера пустую сущность
	$.ajax({
		url: '/organizationrequest/edit?filter_organization_id=' + orgID + '&filter_expense_id='+expenseID,
		dataType: 'json',
		method: 'get',
		beforeSend: function() {
				// показываем прогрессбар
		},
		complete: function() {
			// скрываем прогрессбар
		},			
		success: function(json) {
			if(!handleAjaxError(json.error)) {
				//console.log("С сервера получены полные данные сущности скроллера:");
				console.log(json);
				
				// сохраняем полученные данные
				var local_entity = saveFullServerEntity(json);
				
				// рисуем модалку
				var renderData = renderModal(local_entity);
				renderData.dfd.done(function(data){
					// показываем модалку
					showModal(renderData.container_id);
				});
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			handleAjaxError({
				messages: [{
					title: 'Ошибка обмена данными',
					msg: 'Ошибка обработки запроса на стороне сервера. Обратитесь в службу поддержки',
				}],
			});
		}
	});
}

