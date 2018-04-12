(function (app) {
	"use strict";
	
	var messages = {"code":"ru","date_format_short":"d.m.Y","date_format_long":"l dS F Y","time_format":"h:i:s A","decimal_point":".","thousand_point":" ","currency_short":"\u0440","currency_thousand_short":" \u0442\u044b\u0441. \u0440.","text_empty":"\u041f\u0443\u0441\u0442\u043e\u0435 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435","text_home":"\u041f\u0435\u0440\u0435\u0439\u0442\u0438 \u043a \u0433\u043b\u0430\u0432\u043d\u043e\u0439 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0435","text_yes":"\u0414\u0430","text_no":"\u041d\u0435\u0442","text_none":" --- \u041d\u0435 \u0432\u044b\u0431\u0440\u0430\u043d\u043e --- ","text_select":" --- \u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 --- ","text_pagination":"\u041f\u043e\u043a\u0430\u0437\u0430\u043d\u043e \u0441 {start} \u043f\u043e {end} \u0438\u0437 {total} (\u0441\u0442\u0440\u0430\u043d\u0438\u0446: {pages})","text_page_sizes":"\u041f\u043e\u043a\u0430\u0437\u044b\u0432\u0430\u0442\u044c \u043f\u043e","text_separator":" &raquo; ","text_search":"\u041f\u043e\u0438\u0441\u043a","text_active_short":"(\u0430\u043a\u0442.)","text_nonactive_short":" (\u043d\u0435\u0430\u043a\u0442.)","text_site_contacts_infomail":"\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u043d\u044b\u0439 \u0430\u0434\u0440\u0435\u0441","text_site_full_name":"\u0418\u043d\u0442\u0435\u0440\u043d\u0435\u0442 \u043f\u043e\u0440\u0442\u0430\u043b \u043e\u0431\u0449\u0435\u0434\u043e\u0441\u0442\u0443\u043f\u043d\u043e\u0439 \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u0438 \u043e \u0440\u0430\u0441\u0445\u043e\u0434\u0430\u0445 \u043c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u044c\u043d\u044b\u0445 \u043e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u043d\u0438\u0439 \u00ab\u0420\u0430\u0441\u0445\u043e\u0434\u044b \u0433\u043e\u0440\u043e\u0434\u0430\u00bb","text_site_full_name_federal_project":"\u0424\u0435\u0434\u0435\u0440\u0430\u043b\u044c\u043d\u044b\u0439 \u043f\u0440\u043e\u0435\u043a\u0442","text_site_short_name":"\u0420\u0430\u0441\u0445\u043e\u0434\u044b \u0433\u043e\u0440\u043e\u0434\u0430","text_site_version":"\u0412\u0435\u0440\u0441\u0438\u044f","text_site_work_time":"\u041f\u0440\u043e\u0444\u0438\u043b\u0430\u043a\u0442\u0438\u0447\u0435\u0441\u043a\u0438\u0435 \u0440\u0430\u0431\u043e\u0442\u044b \u043d\u0430 \u0441\u0430\u0439\u0442\u0435","text_site_work_time_value":"23:00 - 07:00, \u0432\u0440\u0435\u043c\u044f \u043c\u043e\u0441\u043a\u043e\u0432\u0441\u043a\u043e\u0435","text_index_title":"\u0420\u0430\u0441\u0445\u043e\u0434\u044b \u0433\u043e\u0440\u043e\u0434\u0430","text_index_subtitle":"\u0424\u0435\u0434\u0435\u0440\u0430\u043b\u044c\u043d\u044b\u0439 \u043f\u0440\u043e\u0435\u043a\u0442","text_index_description":"\u0413\u043b\u0430\u0432\u043d\u0430\u044f \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0430 \u043f\u043e\u0440\u0442\u0430\u043b\u0430 \u043e \u0440\u0430\u0441\u0445\u043e\u0434\u0430\u0445 \u0433\u043e\u0440\u043e\u0434\u0430","index_select_region":"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u0440\u0435\u0433\u0438\u043e\u043d","index_select_organization":"\u0412\u044b\u0431\u0435\u0440\u0438\u0442\u0435 \u043d\u0430\u0441\u0435\u043b\u0435\u043d\u043d\u044b\u0439 \u043f\u0443\u043d\u043a\u0442","text_errors_title":"\u041e\u0448\u0438\u0431\u043a\u0430","text_page_unauthorized":"\u0414\u043e\u0441\u0442\u0443\u043f \u0437\u0430\u043f\u0440\u0435\u0449\u0435\u043d","text_page_not_found":"\u0421\u0442\u0440\u0430\u043d\u0438\u0446\u0430 \u043d\u0435 \u043d\u0430\u0439\u0434\u0435\u043d\u0430","text_page_system_error":"\u0421\u0438\u0441\u0442\u0435\u043c\u043d\u0430\u044f \u043e\u0448\u0438\u0431\u043a\u0430","text_unauthorized":"\u0423 \u0412\u0430\u0441 \u043d\u0435\u0442 \u0434\u043e\u0441\u0442\u0443\u043f\u0430 \u043a \u0434\u0430\u043d\u043d\u043e\u043c\u0443 \u0444\u0443\u043d\u043a\u0446\u0438\u043e\u043d\u0430\u043b\u0443. \u041e\u0431\u0440\u0430\u0442\u0438\u0442\u0435\u0441\u044c \u0432 \u0441\u043b\u0443\u0436\u0431\u0443 \u043f\u043e\u0434\u0434\u0435\u0440\u0436\u043a\u0438","text_not_found":"\u0412\u044b \u043e\u043e\u0431\u0440\u0430\u0442\u0438\u043b\u0438\u0441\u044c \u043a \u043d\u0435\u0441\u0443\u0449\u0435\u0441\u0442\u0432\u0443\u044e\u0449\u0435\u0439 (\u0443\u0434\u0430\u043b\u0435\u043d\u043d\u043e\u0439) \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0435. \u041e\u0431\u0440\u0430\u0442\u0438\u0442\u0435\u0441\u044c \u0432 \u0441\u043b\u0443\u0436\u0431\u0443 \u043f\u043e\u0434\u0434\u0435\u0440\u0436\u043a\u0438","text_system_error":"\u0412\u043e\u0437\u043d\u0438\u043a\u043b\u0430 \u043d\u0435\u043f\u0440\u0435\u0434\u0432\u0438\u0434\u0435\u043d\u043d\u0430\u044f \u043e\u0448\u0438\u0431\u043a\u0430. \u0415\u0441\u043b\u0438 \u043e\u043d\u0430 \u043f\u043e\u0432\u0442\u043e\u0440\u044f\u0435\u0442\u0441\u044f, \u043f\u043e\u0436\u0430\u043b\u0443\u0439\u0441\u0442\u0430, \u0441\u0432\u044f\u0436\u0438\u0442\u0435\u0441\u044c \u0441 \u043d\u0430\u043c\u0438","text_about_title":"\u041e \u043f\u0440\u043e\u0435\u043a\u0442\u0435","text_about_description":"\u0418\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044f \u043e \u043f\u0440\u043e\u0435\u043a\u0442\u0435","text_organization_description":"\u0410\u043a\u0442\u0443\u0430\u043b\u044c\u043d\u044b\u0435 \u0440\u0430\u0441\u0445\u043e\u0434\u044b \u0433\u043e\u0440\u043e\u0434\u0430. \u041c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u0438\u0442\u0435\u0442: %param1%","text_organization_chart_title":"\u0420\u0430\u0441\u043f\u0440\u0435\u0434\u0435\u043b\u0435\u043d\u0438\u0435 \u0444\u0438\u043d\u0430\u043d\u0441\u043e\u0432\u044b\u0445 \u0440\u0435\u0441\u0443\u0440\u0441\u043e\u0432 \u0437\u0430 {year} \u0433\u043e\u0434","text_organization_chart_note":"\u0421\u0432\u0435\u0434\u0435\u043d\u0438\u044f \u043e \u0440\u0430\u0441\u0445\u043e\u0434\u0430\u0445 \u043f\u0440\u0435\u0434\u0441\u0442\u0430\u0432\u043b\u0435\u043d\u044b \u0441\u043f\u0440\u0430\u0432\u043e\u0447\u043d\u043e, \u0431\u0435\u0437 \u0434\u0435\u0442\u0430\u043b\u0438\u0437\u0430\u0446\u0438\u0438, \u0438 \u043a\u043e\u0440\u0440\u0435\u043a\u0442\u0438\u0440\u0443\u044e\u0442\u0441\u044f \u043f\u043e \u043c\u0435\u0440\u0435 \u0443\u0442\u043e\u0447\u043d\u0435\u043d\u0438\u044f \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u0438 \u043c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u0438\u0442\u0435\u0442\u043e\u043c","text_organization_chart_expensetype_name":"\u0422\u0438\u043f \u0440\u0430\u0441\u0445\u043e\u0434\u0430","text_organization_chart_expensetype_percent":"\u0414\u043e\u043b\u044f \u0442\u0438\u043f\u0430 \u0440\u0430\u0441\u0445\u043e\u0434\u0430 \u043e\u0442 \u043e\u0431\u0449\u0435\u0439 \u0441\u0443\u043c\u043c\u044b \u0440\u0430\u0441\u0445\u043e\u0434\u043e\u0432, %","text_organization_chart_id":"\u0418\u0434\u0435\u043d\u0442\u0438\u0444\u0438\u043a\u0430\u0442\u043e\u0440","text_organization_chart_no_data":"\u0417\u0430 \u0443\u043a\u0430\u0437\u0430\u043d\u043d\u044b\u0439 \u043f\u0435\u0440\u0438\u043e\u0434 \u0434\u0430\u043d\u043d\u044b\u0445 \u043d\u0435\u0442","text_newslist_title":"\u041d\u043e\u0432\u043e\u0441\u0442\u0438","text_newslist_description":"\u041d\u043e\u0432\u043e\u0441\u0442\u0438 \u043e \u0440\u0430\u0441\u0445\u043e\u0434\u0430\u0445 \u0433\u043e\u0440\u043e\u0434\u0430","text_organizationrequest_title":"\u041e\u0441\u0442\u0430\u0432\u044c\u0442\u0435 \u043a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439","text_organizationrequest_new_entity_title":"\u041d\u043e\u0432\u044b\u0439 \u043a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439","text_organizationrequest_expense":"\u0420\u0430\u0441\u0445\u043e\u0434","text_organizationrequest_topic":"\u0422\u0435\u043c\u0430","text_organizationrequest_request":"\u041a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439","text_organizationrequest_response":"\u041e\u0442\u0432\u0435\u0442","text_organizationrequest_response_email":"Email \u0434\u043b\u044f \u043e\u0442\u0432\u0435\u0442\u0430","code_status_declined":"\u041e\u0442\u043a\u0430\u0437\u0430\u043d","code_status_done":"\u0413\u043e\u0442\u043e\u0432","code_status_in_progress":"\u0412 \u043e\u0431\u0440\u0430\u0431\u043e\u0442\u043a\u0435","code_status_new":"\u041d\u043e\u0432\u044b\u0439","code_status_processed":"\u041e\u0431\u0440\u0430\u0431\u043e\u0442\u0430\u043d","text_expenselist_title":"\u0420\u0430\u0441\u0445\u043e\u0434\u044b","text_expenselist_description":"\u0410\u043a\u0442\u0443\u0430\u043b\u044c\u043d\u044b\u0435 \u0440\u0430\u0441\u0445\u043e\u0434\u044b \u0433\u043e\u0440\u043e\u0434\u0430. \u0422\u0430\u0431\u043b\u0438\u0446\u0430 \u0440\u0430\u0441\u0445\u043e\u0434\u043e\u0432 \u0433\u043e\u0440\u043e\u0434\u0430. \u041c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u0438\u0442\u0435\u0442: %param1%","text_expenselist_expense_type":"\u0422\u0438\u043f \u0440\u0430\u0441\u0445\u043e\u0434\u043e\u0432","text_expenselist_settlement":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435 \u043d\u0430\u0441. \u043f\u0443\u043d\u043a\u0442\u0430","text_expenselist_expense_name":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435 \u0440\u0430\u0441\u0445\u043e\u0434\u0430","text_expenselist_organization_region":"\u0420\u0435\u0433\u0438\u043e\u043d \u043c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u0438\u0442\u0435\u0442\u0430","text_expenselist_target_date":"\u0421\u0440\u043e\u043a \u0432\u044b\u043f\u043e\u043b\u043d\u0435\u043d\u0438\u044f","main_menu_main":"\u0413\u043b\u0430\u0432\u043d\u0430\u044f","main_menu_newslist":"\u041d\u043e\u0432\u043e\u0441\u0442\u0438","main_menu_about":"\u041e \u043f\u0440\u043e\u0435\u043a\u0442\u0435","text_tab_main_information":"\u041e\u0441\u043d\u043e\u0432\u043d\u0430\u044f \u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044f","text_tab_properties":"\u0421\u0432\u043e\u0439\u0441\u0442\u0432\u0430","text_tab_geodata":"\u0413\u0435\u043e\u0438\u043d\u0444\u043e\u0440\u043c\u0430\u0446\u0438\u044f","text_entity_property_actions":"\u0414\u0435\u0439\u0441\u0442\u0432\u0438\u044f","text_entity_property_active":"\u0410\u043a\u0442\u0438\u0432\u043d\u043e\u0441\u0442\u044c","text_entity_property_amount":"\u0421\u0443\u043c\u043c\u0430, \u0442\u044b\u0441. \u0440.","text_entity_property_code":"\u041a\u043e\u0434","text_entity_property_contacts":"\u041a\u043e\u043d\u0442\u0430\u043a\u0442\u044b","text_entity_property_coordinates_x":"X = ","text_entity_property_coordinates_y":"Y = ","text_entity_property_created_at":"\u0421\u043e\u0437\u0434\u0430\u043d\u043e","text_entity_property_created_by":"\u0410\u0432\u0442\u043e\u0440","text_entity_property_date":"\u0414\u0430\u0442\u0430","text_entity_property_description":"\u041e\u043f\u0438\u0441\u0430\u043d\u0438\u0435","text_entity_property_email":"Email","text_entity_property_executor":"\u041f\u043e\u0434\u0440\u044f\u0434\u0447\u0438\u043a","text_entity_property_files":"\u0424\u0430\u0439\u043b\u044b","text_entity_property_fio":"\u0424\u0418\u041e","text_entity_property_header":"\u0417\u0430\u0433\u043e\u043b\u043e\u0432\u043e\u043a","text_entity_property_id":"ID","text_entity_property_image":"\u0418\u0437\u043e\u0431\u0440\u0430\u0436\u0435\u043d\u0438\u0435","text_entity_property_images":"\u0418\u0437\u043e\u0431\u0440\u0430\u0436\u0435\u043d\u0438\u044f","text_entity_property_house_building":"\u0414\u043e\u043c, \u0441\u0442\u0440.","text_entity_property_login":"\u041b\u043e\u0433\u0438\u043d","text_entity_property_n":"\u2116","text_entity_property_name":"\u041d\u0430\u0438\u043c\u0435\u043d\u043e\u0432\u0430\u043d\u0438\u0435","text_entity_property_password":"\u041f\u0430\u0440\u043e\u043b\u044c","text_entity_property_phone":"\u0422\u0435\u043b\u0435\u0444\u043e\u043d","text_entity_property_recaptcha":"\u041f\u0440\u043e\u0432\u0435\u0440\u043a\u0430 \u043d\u0430 \u0447\u0435\u043b\u043e\u0432\u0435\u0447\u043d\u043e\u0441\u0442\u044c","text_entity_property_recipient":"\u041f\u043e\u043b\u0443\u0447\u0430\u0442\u0435\u043b\u044c","text_entity_property_region":"\u0420\u0435\u0433\u0438\u043e\u043d","text_entity_property_related_data":"\u0421\u0432\u044f\u0437\u0430\u043d\u043d\u044b\u0435 \u0437\u0430\u043f\u0438\u0441\u0438","text_entity_property_role":"\u0420\u043e\u043b\u044c","text_entity_property_status":"\u0421\u0442\u0430\u0442\u0443\u0441","text_entity_property_street":"\u0423\u043b\u0438\u0446\u0430","text_entity_property_street_type":"\u0422\u0438\u043f \u0443\u043b\u0438\u0446\u044b","text_entity_property_value":"\u0417\u043d\u0430\u0447\u0435\u043d\u0438\u0435","status_new":"\u041d\u043e\u0432\u044b\u0439","status_prcessed":"\u041e\u0431\u0440\u0430\u0431\u043e\u0442\u0430\u043d\u043e","status_declined":"\u041e\u0442\u043a\u0430\u0437\u0430\u043d\u043e","status_in_progress":"\u0412 \u043e\u0431\u0440\u0430\u0431\u043e\u0442\u043a\u0435","button_add":"\u0414\u043e\u0431\u0430\u0432\u0438\u0442\u044c","button_add_address":"\u0414\u043e\u0431\u0430\u0432\u0438\u0442\u044c \u0430\u0434\u0440\u0435\u0441","button_apply":"\u041f\u0440\u0438\u043c\u0435\u043d\u0438\u0442\u044c","button_apply_title":"\u041f\u0440\u0438\u043c\u0435\u043d\u0438\u0442\u044c","button_back":"\u041d\u0430\u0437\u0430\u0434","button_cancel":"\u041e\u0442\u043c\u0435\u043d\u0430","button_clear":"\u041e\u0447\u0438\u0441\u0442\u0438\u0442\u044c","button_clear_title":"\u041e\u0447\u0438\u0441\u0442\u0438\u0442\u044c","button_change_address":"\u0418\u0437\u043c\u0435\u043d\u0438\u0442\u044c \u0430\u0434\u0440\u0435\u0441","button_check":"\u041f\u0440\u043e\u0432\u0435\u0440\u0438\u0442\u044c","button_confirm":"\u041f\u043e\u0434\u0442\u0432\u0435\u0440\u0434\u0438\u0442\u044c","button_continue":"\u041f\u0440\u043e\u0434\u043e\u043b\u0436\u0438\u0442\u044c","button_copy":"\u041a\u043e\u043f\u0438\u0440\u043e\u0432\u0430\u0442\u044c","button_coupon":"\u041f\u0440\u0438\u043c\u0435\u043d\u0438\u0442\u044c \u043a\u0443\u043f\u043e\u043d","button_delete":"\u0423\u0434\u0430\u043b\u0438\u0442\u044c","button_delete_title":"\u0423\u0434\u0430\u043b\u0438\u0442\u044c","button_download":"\u0421\u043a\u0430\u0447\u0430\u0442\u044c","button_edit":"\u0420\u0435\u0434\u0430\u043a\u0442\u0438\u0440\u043e\u0432\u0430\u0442\u044c","button_edit_title":"\u0420\u0435\u0434\u0430\u043a\u0442\u0438\u0440\u043e\u0432\u0430\u0442\u044c","button_enter":"\u0412\u043e\u0439\u0442\u0438","button_filter":"\u0424\u0438\u043b\u044c\u0442\u0440\u043e\u0432\u0430\u0442\u044c","button_filter_clear":"\u0421\u0431\u0440\u043e\u0441","button_login":"\u0412\u043e\u0439\u0442\u0438","button_new_address":"\u041d\u043e\u0432\u044b\u0439 \u0430\u0434\u0440\u0435\u0441","button_password_change":"\u0421\u043c\u0435\u043d\u0438\u0442\u044c \u043f\u0430\u0440\u043e\u043b\u044c","button_password_print":"\u041d\u0430\u043f\u0435\u0447\u0430\u0442\u0430\u0442\u044c \u043f\u0430\u0440\u043e\u043b\u044c","button_password_recover":"\u041d\u0430\u043f\u043e\u043c\u043d\u0438\u0442\u044c \u043f\u0430\u0440\u043e\u043b\u044c","button_question":"\u041e\u0441\u0442\u0430\u0432\u0438\u0442\u044c \u043a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439","button_question_title":"\u041e\u0441\u0442\u0430\u0432\u0438\u0442\u044c \u043a\u043e\u043c\u043c\u0435\u043d\u0442\u0430\u0440\u0438\u0439 \u043c\u0443\u043d\u0438\u0446\u0438\u043f\u0430\u043b\u0438\u0442\u0435\u0442\u0443","button_remove":"\u0423\u0434\u0430\u043b\u0438\u0442\u044c","button_save":"\u0421\u043e\u0445\u0440\u0430\u043d\u0438\u0442\u044c","button_save_direct":"\u0421\u043e\u0445\u0440\u0430\u043d\u0438\u0442\u044c \u043d\u0430 \u0441\u0435\u0440\u0432\u0435\u0440","button_save_local":"\u0421\u043e\u0445\u0440\u0430\u043d\u0438\u0442\u044c \u043b\u043e\u043a\u0430\u043b\u044c\u043d\u043e","button_search":"\u041f\u043e\u0438\u0441\u043a","button_select":"\u0423\u043a\u0430\u0437\u0430\u0442\u044c","button_send":"\u041e\u0442\u043f\u0440\u0430\u0432\u0438\u0442\u044c","button_show":"\u041f\u0440\u043e\u0441\u043c\u043e\u0442\u0440","button_show_title":"\u041f\u0440\u043e\u0441\u043c\u043e\u0442\u0440","button_update":"\u041f\u0440\u0438\u043c\u0435\u043d\u0438\u0442\u044c","button_upload":"\u0417\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u044c","button_view":"\u041f\u0440\u043e\u0441\u043c\u043e\u0442\u0440","button_wishlist":"\u0432 \u0437\u0430\u043a\u043b\u0430\u0434\u043a\u0438","text_no_data":"\u041d\u0435\u0442 \u0434\u0430\u043d\u043d\u044b\u0445 \u0434\u043b\u044f \u043e\u0442\u043e\u0431\u0440\u0430\u0436\u0435\u043d\u0438\u044f","text_no_edit":"\u0420\u0435\u0434\u0430\u043a\u0442\u0438\u0440\u043e\u0432\u0430\u043d\u0438\u0435 \u043d\u0435\u0432\u043e\u0437\u043c\u043e\u0436\u043d\u043e","msg_success_title":"\u041e\u043f\u0435\u0440\u0430\u0446\u0438\u044f \u0443\u0441\u043f\u0435\u0448\u043d\u0430","msg_success_entity_saved":"\u0417\u0430\u043f\u0438\u0441\u044c \u0441 \u0443\u0441\u043f\u0435\u0448\u043d\u043e \u0441\u043e\u0445\u0440\u0430\u043d\u0435\u043d\u0430","msg_success_file_deleted":"\u0424\u0430\u0439\u043b \"{file_name}\" \u0443\u0434\u0430\u043b\u0435\u043d","msg_check_field_invalid_value":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u041f\u0435\u0440\u0435\u0434\u0430\u043d\u043e \u043d\u0435\u043a\u043e\u0440\u0440\u0435\u043a\u0442\u043d\u043e\u0435 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435","msg_check_field_mandatory":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u043e\u0431\u044f\u0437\u0430\u0442\u0435\u043b\u044c\u043d\u043e \u0434\u043b\u044f \u0443\u043a\u0430\u0437\u0430\u043d\u0438\u044f","msg_check_field_min_value":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u043c\u0435\u043d\u044c\u0448\u0435 \u0434\u043e\u043f\u0443\u0441\u0442\u0438\u043c\u043e\u0433\u043e","msg_check_field_max_value":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u0431\u043e\u043b\u044c\u0448\u0435 \u0434\u043e\u043f\u0443\u0441\u0442\u0438\u043c\u043e\u0433\u043e","msg_check_field_email_format":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435, \u043d\u0435 \u0441\u043e\u043e\u0442\u0432\u0435\u0442\u0441\u0442\u0432\u0443\u0449\u0435\u0435 \u0430\u0434\u0440\u0435\u0441\u0443 \u044d\u043b\u0435\u043a\u0442\u0440\u043e\u043d\u043d\u043e\u0439 \u043f\u043e\u0447\u0442\u044b","msg_check_field_text_min":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0441\u043b\u0438\u0448\u043a\u043e\u043c \u043a\u043e\u0440\u043e\u0442\u043a\u043e\u0435 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435 (\u0434\u043e\u043b\u0436\u043d\u043e \u0431\u044b\u0442\u044c \u043d\u0435 \u043c\u0435\u043d\u0435\u0435 %field_min% \u0441\u0438\u043c\u0432\u043e\u043b\u043e\u0432)","msg_check_field_text_max":"\u041f\u043e\u043b\u0435 \"%field_name%\" \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0441\u043b\u0438\u0448\u043a\u043e\u043c \u0434\u043b\u0438\u043d\u043d\u043e\u0435 \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435 (\u0434\u043e\u043b\u0436\u043d\u043e \u0431\u044b\u0442\u044c \u043d\u0435 \u0431\u043e\u043b\u0435\u0435 %field_max% \u0441\u0438\u043c\u0432\u043e\u043b\u043e\u0432)","msg_check_field_period_1":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u0414\u0430\u0442\u0430 \"%field_name1%\" \u043e\u0431\u044f\u0437\u0430\u0442\u0435\u043b\u044c\u043d\u0430 \u0434\u043b\u044f \u0437\u0430\u043f\u043e\u043b\u043d\u0435\u043d\u0438\u044f","msg_check_field_period_2":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u0414\u0430\u0442\u0430 \"%field_name2%\" \u043e\u0431\u044f\u0437\u0430\u0442\u0435\u043b\u044c\u043d\u0430 \u0434\u043b\u044f \u0437\u0430\u043f\u043e\u043b\u043d\u0435\u043d\u0438\u044f","msg_check_field_period_any":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u0414\u043e\u043b\u0436\u043d\u0430 \u0431\u044b\u0442\u044c \u0437\u0430\u043f\u043e\u043b\u043d\u0435\u043d\u0430 \u0445\u043e\u0442\u044f \u0431\u044b \u043e\u0434\u043d\u0430 \u0434\u0430\u0442\u0430","msg_check_field_period_full":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u041f\u0435\u0440\u0438\u043e\u0434 \u0434\u043e\u043b\u0436\u0435\u043d \u0431\u044b\u0442\u044c \u0437\u0430\u043f\u043e\u043b\u043d\u0435\u043d \u043f\u043e\u043b\u043d\u043e\u0441\u0442\u044c\u044e","msg_check_field_period_2lt1":"\u0412 \u043f\u043e\u043b\u0435 \"%field_name%\" \u0434\u0430\u0442\u0430 \u043e\u043a\u043e\u043d\u0447\u0430\u043d\u0438\u044f \u043f\u0435\u0440\u0438\u043e\u0434\u0430 \u043d\u0435 \u043c\u043e\u0436\u0435\u0442 \u0431\u044b\u0442\u044c \u043c\u0435\u043d\u044c\u0448\u0435 \u0434\u0430\u0442\u044b \u043d\u0430\u0447\u0430\u043b\u0430 \u043f\u0435\u0440\u0438\u043e\u0434\u0430","msg_check_field_not_found_by_id":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u041f\u043e \u043f\u0435\u0440\u0435\u0434\u0430\u043d\u043e\u043c\u0443 \u0438\u0434\u0435\u043d\u0442\u0438\u0444\u0438\u043a\u0430\u0442\u043e\u0440\u0443 \u043d\u0435 \u043d\u0430\u0439\u0434\u0435\u043d\u0430 \u0437\u0430\u043f\u0438\u0441\u044c \u0432 \u0411\u0414","msg_check_field_not_in_list":"\u041f\u043e\u043b\u0435 \"%field_name%\". \u041f\u0435\u0440\u0435\u0434\u0430\u043d\u043e \u0437\u043d\u0430\u0447\u0435\u043d\u0438\u0435 \u043d\u0435 \u0438\u0437 \u0441\u043f\u0438\u0441\u043a\u0430","msg_check_field_recaptcha":"\u0415\u0441\u0442\u044c \u043f\u043e\u0434\u043e\u0437\u0440\u0435\u043d\u0438\u0435, \u0447\u0442\u043e \u0432\u044b \u0440\u043e\u0431\u043e\u0442. \u041f\u0435\u0440\u0435\u0437\u0430\u0433\u0440\u0443\u0437\u0438\u0442\u0435 \u0441\u0442\u0440\u0430\u043d\u0438\u0446\u0443 \u0438 \u043f\u043e\u0432\u0442\u043e\u0440\u0438\u0442\u0435 \u0432\u0432\u043e\u0434","msg_error_title":"\u041e\u0448\u0438\u0431\u043a\u0430","msg_error_not_one_rows":"001. \u0412\u044b\u0431\u043e\u0440\u043a\u0430 \u0434\u0430\u043d\u043d\u044b\u0445 \u0438\u0437 \u0411\u0414 \u043b\u0438\u0431\u043e \u043f\u0443\u0441\u0442\u0430, \u043b\u0438\u0431\u043e \u0441\u043e\u0434\u0435\u0440\u0436\u0438\u0442 \u0431\u043e\u043b\u0435\u0435 1 \u0437\u0430\u043f\u0438\u0441\u0438","msg_error_post_is_expected":"002. \u041e\u0436\u0438\u0434\u0430\u0435\u0442\u0441\u044f \u0438\u0441\u043f\u043e\u043b\u044c\u0437\u043e\u0432\u0430\u043d\u0438\u0435 \u043c\u0435\u0442\u043e\u0434\u0430 POST","msg_error_no_id":"003. \u041d\u0435 \u043f\u043e\u043b\u0443\u0447\u0435\u043d \u0438\u0434\u0435\u043d\u0442\u0438\u0444\u0438\u043a\u0430\u0442\u043e\u0440 \u0441\u0443\u0449\u043d\u043e\u0441\u0442\u0438","msg_error_file_not_deleted":"004. \u0424\u0430\u0439\u043b \"{file_name}\" \u043d\u0435 \u0443\u0434\u0430\u043b\u0435\u043d","msg_error_file_not_deleted_from_hdd":"005. \u0424\u0430\u0439\u043b \"{file_name}\" \u043d\u0435 \u0443\u0434\u0430\u043b\u0435\u043d \u0438\u0437 \u0444\u0430\u0439\u043b\u043e\u0432\u043e\u0433\u043e \u0445\u0440\u0430\u043d\u0438\u043b\u0438\u0449\u0430","msg_error_files_not_deleted":"006. \u0423\u0434\u0430\u043b\u0435\u043d\u0438\u0435 \u0444\u0430\u0439\u043b\u043e\u0432 \u043d\u0435\u0443\u0441\u043f\u0435\u0448\u043d\u043e","error_upload_1":"\u0417\u0430\u0433\u0440\u0443\u0436\u0430\u0435\u043c\u044b\u0439 \u043d\u0430 \u0441\u0435\u0440\u0432\u0435\u0440 \u0444\u0430\u0439\u043b \u043f\u0440\u0435\u0432\u044b\u0448\u0430\u0435\u0442 \u043f\u0430\u0440\u0430\u043c\u0435\u0442\u0440 upload_max_filesize \u0432 php.ini!","error_upload_2":"\u0417\u0430\u0433\u0440\u0443\u0436\u0430\u0435\u043c\u044b\u0439 \u043d\u0430 \u0441\u0435\u0440\u0432\u0435\u0440 \u0444\u0430\u0439\u043b \u043f\u0440\u0435\u0432\u044b\u0448\u0430\u0435\u0442 \u043f\u0430\u0440\u0430\u043c\u0435\u0442\u0440 MAX_FILE_SIZE \u043a\u043e\u0442\u043e\u0440\u044b\u0439 \u043e\u043f\u0440\u0435\u0434\u0435\u043b\u0435\u043d \u0432 HTML \u0444\u043e\u0440\u043c\u0435!","error_upload_3":"\u0417\u0430\u0433\u0440\u0443\u0436\u0430\u0435\u043c\u044b\u0439 \u043d\u0430 \u0441\u0435\u0440\u0432\u0435\u0440 \u0444\u0430\u0439\u043b \u0431\u044b\u043b \u0437\u0430\u0433\u0440\u0443\u0436\u0435\u043d \u043d\u0435 \u043f\u043e\u043b\u043d\u043e\u0441\u0442\u044c\u044e!","error_upload_4":"\u0424\u0430\u0439\u043b \u043d\u0435 \u0431\u044b\u043b \u0437\u0430\u0433\u0440\u0443\u0436\u0435\u043d!","error_upload_6":"\u041e\u0442\u0441\u0443\u0442\u0441\u0432\u0443\u0435\u0442 \u0432\u0440\u0435\u043c\u0435\u043d\u043d\u0430\u044f \u0434\u0438\u0440\u0435\u043a\u0442\u043e\u0440\u0438\u044f!","error_upload_7":"\u041d\u0435 \u0443\u0434\u0430\u043b\u043e\u0441\u044c \u0437\u0430\u043f\u0438\u0441\u0430\u0442\u044c \u0444\u0430\u0439\u043b \u043d\u0430 \u0434\u0438\u0441\u043a!","error_upload_8":"\u0417\u0430\u0433\u0440\u0443\u0436\u0430\u0435\u043c\u044b\u0439 \u043d\u0430 \u0441\u0435\u0440\u0432\u0435\u0440 \u0444\u0430\u0439\u043b \u043d\u0435 \u043f\u043e\u0434\u0445\u043e\u0434\u0438\u0442 \u043f\u043e \u0440\u0430\u0441\u0448\u0438\u0440\u0435\u043d\u0438\u044e!","error_upload_999":"\u041d\u0435\u0438\u0437\u0432\u0435\u0441\u0442\u043d\u0430\u044f \u043e\u0448\u0438\u0431\u043a\u0430!"};
	
	var obj = {};
	
	obj._ = function(code, params) {
		if((!code || typeof code != 'string') && (params !== null && typeof params !== 'object')) return '<Модуль Переводчик. В функцию перевода переданы неверные параметры>';
		
		var result = code;
		if(messages[code]) {
			result = messages[code];
			for (var key in params) {
				var value = params[key];
				result = result.replace(new RegExp('{' + key + '}', 'g') , value);
			}
		}
		return result;
	};
	
	obj.messages = messages;
	
	app.t = obj;
	
}(app));
