<?php require_once('../../../wp-config.php');require_once('function_manage_submit_task.php');require_once('function_page_timesheet.php');$type = $_POST['type'];$data_id = $_POST['data_id'];$edit_form_data = $_POST['edit_form_data'];$archive_form_data = $_POST['archive_form_data'];$update_archive_form_data = $_POST['update_archive_form_data'];$delete_form_data = $_POST['delete_form_data'];$submit_ids = $_POST['submit_ids'];$paused_submit_ids = $_POST['paused_submit_ids'];$delete_cron_id = $_POST['data_id'];$pause_cron_id = $_POST['data_id'];$start_cron_id = $_POST['data_id'];$submit_start_schedule_task_data = $_POST['submit_start_schedule_task_data'];$submit_schedule_task_data = $_POST['submit_schedule_task_data'];$edit_cron_id = $_POST['data_id'];$submit_edit_schedule_task_data = $_POST['submit_edit_schedule_task_data'];$submit_now_task_data = $_POST['submit_now_task_data'];$submit_subtask_form_data = $_POST['submit_subtask_form_data'];$save_timesheet_task_data = $_POST['save_timesheet_task_data'];$delete_form = $_POST['delete_form'];$edit_timesheet_id_not_current = $_POST['data_id'];$update_timesheet_data = $_POST['update_timesheet_task_data'];$save_add_timesheet_task_data = $_POST['save_add_timesheet_task_data'];$day_date_week = $_POST['day_date_week'];$asc_date_array = $_POST['asc_date_array'];$desc_date_array = $_POST['desc_date_array'];$asc_client_array = $_POST['asc_client_array'];$desc_client_array = $_POST['desc_client_array'];$asc_task_array = $_POST['asc_task_array'];$desc_task_array = $_POST['desc_task_array'];$project_category_color = $_POST['project_category_color'];$staff_timesheet_data = $_POST['staff_timesheet_data'];$date_hour_day_week = $_POST['date_hour_day_week'];$site_url = $_POST['site_url'];$website_form = $_POST['website_form'];$filter_details = $_POST['filter_details'];$filter_year = $_POST['filter_year'];$check_details = $_POST['check_details'];$add_project_details = $_POST['add_project_details'];$save_project_client = $_POST['save_project_client'];$hosting_domain = $_POST['hosting_domain'];$report_client_sort = $_POST['report_client_sort'];$report_time_sort_hour = $_POST['report_time_sort_hour'];$report_time_sort_billable = $_POST['report_time_sort_billable'];$report_time_sort_unbillable = $_POST['report_time_sort_unbillable'];$report_time_sort_name = $_POST['report_time_sort_name'];$report_time_sort_billable_a = $_POST['report_time_sort_billable_a'];$report_time_sort_unbillable_a = $_POST['report_time_sort_unbillable_a'];$filter_details_detailed_time = $_POST['filter_details_detailed_time'];$report_sorting_type = $_POST['report_sorting_type'];$goals_div_id = $_POST['div_id'];$goal_update_edit_details = $_POST['goal_update_edit_details'];$goal_delete_details = $_POST['goal_delete_details'];$dashboard_goals_value = $_POST['dashboard_goals_value'];$dashboard_goals_value_uncheck = $_POST['dashboard_goals_value_uncheck'];$message_div_id = $_POST['message_div_id'];$message_update_edit_details = $_POST['message_update_edit_details'];$message_delete_details = $_POST['message_delete_details'];$checklist_div_id = $_POST['checklist_div_id'];$checklist_update_edit_details = $_POST['checklist_update_edit_details'];$checklist_delete_details = $_POST['checklist_delete_details'];$template_name = $_POST['template_name'];$task_checklist_details = $_POST['task_checklist_details'];$done_today_form = $_POST['done_today_form'];$project_name_edit_details = $_POST['project_name_edit_details'];$client_name_edit_details = $_POST['client_name_edit_details'];$person_name = $_POST['person_name'];$update_checklist_category_details = $_POST['update_checklist_category_details'];$delete_checklist_category_details = $_POST['delete_checklist_category_details'];$update_checklist_template_details = $_POST['update_checklist_template_details'];$delete_checklist_template_details = $_POST['delete_checklist_template_details'];$delete_ajax_details = $_POST['delete_ajax_details'];$checklist_category_name = $_POST['checklist_category_name'];$category_priority_details = $_POST['category_priority_details'];$person_details = $_POST['person_details'];$client_name = $_POST['client_name'];$website_client_id = $_POST['website_client_id'];$website_client_id_array = $_POST['website_client_id_array'];$website_sort_details = $_POST['website_sort_details'];$site_type = $_POST['site_type'];$website_id = $_POST['website_id'];$website_id_array = $_POST['website_id_array'];$submit_bulk_details = $_POST['submit_bulk_details'];$dialog_bulk_actions_details = $_POST['dialog_bulk_actions_details'];$delete_form_details = $_POST['delete_form_details'];$apply_bulk_action_form = $_POST['apply_bulk_action_form'];$form_details = $_POST['form_details'];$data_new_other_asset = $_POST['data_new_other_asset'];$new_entry_info = $_POST['new_entry_info'];$client_id =  $_POST['client_id'];$new_entry_timesheet = $_POST['new_entry_timesheet'];$save_timesheet_row = $_POST['save_timesheet_row'];$update_entries_values= $_POST['update_entries_values'];$new_service_option = $_POST['option'];$add_services_to_client = $_POST['add_services_to_client'];$service_id = $_POST['service_id'];$edit_project_entry = $_POST['edit_project_entry'];$project_editing_value = $_POST['project_editing_value'];$edit_taskname_entry = $_POST['edit_taskname_entry'];$taskname_editing_value = $_POST['taskname_editing_value'];$filter_data_type = $_POST['filter_data_type'];$data_object = $_POST['data_object'];switch($type){	case 'project_management_edit_modal':		print_r(edit_modal_form($data_id));	break;	case 'project_management_save_edit_modal':		print_r(json_encode(save_edit_modal_form($edit_form_data)));	break;	case 'project_management_archive_modal':		print_r(archive_modal_form($data_id));	break;	case 'project_management_save_archive_modal':		print_r(json_encode(save_archive_modal_form($archive_form_data)));	break;	case 'project_management_edit_archive_modal':		print_r(project_management_edit_archive_modal($data_id));	break;	case 'project_management_update_archive_modal':		print_r(json_encode(update_archive_modal_form($update_archive_form_data)));	break;	case 'project_management_confirm_delete_modal':		print_r(delete_confirm_modal_form($data_id));	break;		case 'project_management_delete_modal_row':		print_r(json_encode(delete_modal_form($delete_form_data)));	break;	case 'pm_completed_webdev_filter':		print_r(json_encode(pm_completed_webdev_filter($filter_year)));	break;		case 'pm_current_seo_filter':		print_r(json_encode(pm_current_seo_filter($filter_details)));	break;	case 'pm_current_internal_dev_filter':		print_r(json_encode(pm_current_internal_dev_filter($filter_details)));	break;		case 'pm_current_internal_seo_filter':		print_r(json_encode(pm_current_internal_seo_filter($filter_details)));	break;	case 'pm_current_issue_bug_filter':		print_r(json_encode(pm_current_issue_bug_filter($filter_details)));	break;		// case 'submit_task_delete_bulk':		// print_r(json_encode(submit_task_bulk_delete($submit_ids)));	// break;	case 'dialog_bulk_actions':		print_r(dialog_bulk_actions($dialog_bulk_actions_details));	break;	case 'apply_bulk_actions':		print_r(json_encode(apply_bulk_actions($apply_bulk_action_form)));	break;	case 'submit_bulk_actions':		print_r(json_encode(submit_bulk_actions($submit_bulk_details)));	break;		case 'submit_pause_task_delete_bulk':		print_r(json_encode(submit_pause_task_bulk_delete($paused_submit_ids)));	break;	case 'submit_task_delete_cron':		print_r(json_encode(submit_task_cron_delete($delete_cron_id)));	break;	case 'submit_task_pause_cron':		print_r(submit_task_cron_pause($pause_cron_id));	break;	case 'submit_start_cron_form':		print_r(submit_task_cron_start($start_cron_id));	break;	case 'submit_start_schedule_task':		print_r(json_encode(submit_start_scheduled_task($submit_start_schedule_task_data)));	break;	case 'submit_edit_cron_form':		print_r(submit_task_cron_edit($edit_cron_id));	break;	case 'submit_edit_schedule_task':		print_r(json_encode(submit_edit_scheduled_task($submit_edit_schedule_task_data)));	break;	case 'sort_asc_submit_date_task':		print_r(json_encode(sort_asc_submit_task_date($asc_date_array)));	break;	case 'sort_desc_submit_date_task':		print_r(json_encode(sort_desc_submit_task_date($desc_date_array)));	break;	case 'sort_asc_submit_client_task':		print_r(json_encode(sort_asc_client_task_date($asc_client_array)));	break;	case 'sort_desc_submit_client_task':		print_r(json_encode(sort_desc_client_task_date($desc_client_array)));	break;	case 'sort_asc_submit_task':		print_r(json_encode(sort_asc_task_date($asc_task_array)));	break;	case 'sort_desc_submit_task':		print_r(json_encode(sort_desc_task_date($desc_task_array)));	break;	case 'submit_schedule_task':		print_r(json_encode(submit_scheduled_task($submit_schedule_task_data)));	break;	case 'check_project_details':		print_r(json_encode(check_project_exist($check_details)));	break;	case 'add_client_project':		print_r(add_client_project_form($add_project_details));	break;	case 'save_client_project':		print_r(json_encode(save_client_project($save_project_client)));	break;	case 'submit_now_task':		print_r(json_encode(submit_now_tasks($submit_now_task_data)));	break;	case 'submit_subtask':		print_r(json_encode(submit_task_api($submit_subtask_form_data)));	break;	case 'submit_subtask_form':		print_r(submit_sub_task_form());	break;	case 'task_import_timesheet':		print_r(json_encode(import_task_timesheet()));	break;	// case 'task_import_timesheet_not_current':		// print_r(json_encode(import_task_timesheet_not_current($date_hour_day_week)));	// break;	case 'import_task_kanban':		print_r(json_encode(import_task_kanban($date_hour_day_week)));	break;	case 'task_save_timesheet':		print_r(json_encode(save_task_timesheet($save_timesheet_task_data)));	break;	case 'task_delete_timesheet':		print_r(json_encode(delete_task_timesheet($delete_form)));	break;	// case 'task_delete_timesheet_task':		// print_r(json_encode(task_delete_timesheet_task($delete_form_details)));	// break;	case 'task_edit_timesheet':		print_r(edit_task_timesheet($edit_timesheet_id));	break;	case 'confirm_delete_task':		print_r(json_encode(confirm_delete_task($delete_form_details)));	break;	case 'task_edit_timesheet_task':		print_r(task_edit_timesheet_task($data_id));	break;	case 'task_update_timesheet':		print_r(json_encode(update_task_timesheet($update_timesheet_data)));	break;	case 'timesheet_add_task':		print_r(timesheet_add_task($day_date_week));	break;		case 'task_save_add_timesheet':		print_r(json_encode(save_add_task_timesheet($save_add_timesheet_task_data)));	break;	case 'filter_project_client':		print_r(json_encode(filter_project_client($client_id)));	break;	case 'save_project_category_color':		print_r(json_encode(project_category_color_save($project_category_color)));	break;	case 'search_staff_timesheet':		print_r(json_encode(staff_timesheet($staff_timesheet_data)));	break;		case 'get_theme_details':		print_r(theme_detail($site_url));	break;	case 'get_wp_details':		print_r(wp_detail($site_url));	break;	case 'website_form_save':		print_r(json_encode(save_website_form($website_form)));	break;	case 'report_time_filter_top':		print_r(json_encode(filter_report_time_top($filter_details)));	break;	case 'report_time_filter_client':		print_r(json_encode(filter_report_time_client($filter_details)));	break;	case 'report_time_filter_project':		print_r(json_encode(filter_report_time_project($filter_details)));	break;	case 'report_time_filter_task':		print_r(json_encode(filter_report_time_task($filter_details)));	break;	case 'report_time_filter_staff':		print_r(json_encode(filter_report_time_staff($filter_details)));	break;	case 'year_last_week':		print_r(last_week_year($filter_year));	break;	case 'save_hosting_domain':		print_r(save_host_domain($hosting_domain));	break;	case 'report_time_client_sort':		print_r(json_encode(report_time_client_sort($report_client_sort)));	break;	case 'report_time_hour_sort':		print_r(json_encode(report_time_hour_sort($report_time_sort_hour)));	break;	case 'report_time_billable_sort':		print_r(json_encode(report_time_billable_sort($report_time_sort_billable)));	break;	case 'report_time_unbillable_sort':		print_r(json_encode(report_time_unbillable_sort($report_time_sort_unbillable)));	break;	case 'report_time_name_sort':		print_r(json_encode(report_time_name_sort($report_time_sort_name)));	break;	case 'report_time_billable_a_sort':		print_r(json_encode(report_time_billable_a_sort($report_time_sort_billable_a)));	break;	case 'report_time_unbillable_a_sort':		print_r(json_encode(report_time_unbillable_a_sort($report_time_sort_unbillable_a)));	break;	case 'report_time_filter_detailed_time':		print_r(json_encode(filter_report_time_detailed($filter_details_detailed_time, $report_sorting_type)));	break;	case 'get_data_type_list':		print_r(json_encode(get_data_type_list($filter_data_type)));	break;	case 'edit_goals':		print_r(edit_goals($goals_div_id));	break;	case 'update_edit_goals':		print_r(json_encode(update_edit_goals($goal_update_edit_details)));	break;	case 'confirm_delete_goals':		print_r(confirm_delete_goals($goals_div_id));	break;	case 'delete_goals':		print_r(json_encode(delete_goals($goal_delete_details)));	break;	case 'dashboard_goals':		print_r(json_encode(dashboard_goals($dashboard_goals_value)));	break;	case 'dashboard_goals_uncheck':		print_r(json_encode(dashboard_goals_uncheck($dashboard_goals_value_uncheck)));	break;	case 'edit_message':		print_r(edit_message($message_div_id));	break;	case 'update_edit_message':		print_r(json_encode(update_edit_message($message_update_edit_details)));	break;	case 'confirm_delete_message':		print_r(confirm_delete_message($message_div_id));	break;		case 'delete_message':		print_r(json_encode(delete_message($message_delete_details)));	break;	case 'edit_checklist':		print_r(edit_checklist($checklist_div_id));	break;	case 'update_edit_checklist':		print_r(json_encode(update_edit_checklist($checklist_update_edit_details)));	break;	case 'confirm_delete_checklist':		print_r(confirm_delete_checklist($checklist_div_id));	break;	case 'delete_checklist':		print_r(json_encode(checklist_delete_details($checklist_delete_details)));	break;	case 'check_template_exist':		print_r(check_template_exist($template_name));	break;	case 'template_checklist_select':		print_r(json_encode(template_checklist_select($template_name)));	break;	case 'done_today_edit':		print_r(done_today_edit($data_id));	break;	case 'task_done_today_save':		print_r(json_encode(task_done_today_save($done_today_form)));	break;	case 'project_name_edit':		print_r(project_name_edit($project_name_edit_details));	break;	case 'client_name_edit':		print_r(client_name_edit($client_name_edit_details));	break;	case 'task_checklist_select':		print_r(json_encode(task_checklist_select($task_checklist_details)));	break;	case 'task_person_checklist_select':		print_r(json_encode(task_person_checklist_select($person_name)));	break;	case 'edit_checklist_category':		print_r(edit_checklist_category($data_id));	break;		case 'update_checklist_category':		print_r(update_checklist_category($update_checklist_category_details));	break;	case 'confirm_delete_checklist_category':		print_r(confirm_delete_checklist_category($data_id));	break;	case 'delete_checklist_category':		print_r(delete_checklist_category($delete_checklist_category_details));	break;	case 'edit_checklist_template':		print_r(edit_checklist_template($data_id));	break;	case 'update_checklist_template':		print_r(update_checklist_template($update_checklist_template_details));	break;	case 'confirm_delete_checklist_template':		print_r(confirm_delete_checklist_template($data_id));	break;		case 'delete_checklist_template':		print_r(delete_checklist_template($delete_checklist_template_details));	break;		case 'delete_ajax':		print_r(delete_ajax($delete_ajax_details));	break;		case 'add_checklist_category_select':		print_r(add_checklist_category_select($checklist_category_name));	break;	case 'checklist_category_priority':		print_r(checklist_category_priority($category_priority_details));	break;		case 'archive_person':		print_r(json_encode(archive_person($person_details)));	break;	case 'unarchive_person':		print_r(json_encode(unarchive_person($person_details)));	break;	case 'client_information':		print_r(json_encode(client_information($client_name)));	break;	case 'get_moz_metrix':		print_r(json_encode(get_moz_metrix($website_client_id)));	break;	case 'bulk_get_moz_metrix':		print_r(json_encode(bulk_get_moz_metrix($website_client_id_array)));	break;	case 'website_sort':		print_r(json_encode(website_sort($website_sort_details)));	break;	case 'site_type_filter':		print_r(json_encode(site_type_filter($site_type)));	break;	case 'get_wp_th_details':		print_r(json_encode(get_wp_th_details($website_id)));	break;	case 'bulk_get_wp_th':		print_r(json_encode(bulk_get_wp_th($website_id_array)));	break;    case 'build_array':        print_r(build_array($form_details));    break;    case 'edit_add_asset':        print_r(json_encode(edit_add_asset($form_details)));    break;	case 'add_other_option':		print_r(add_other_option($form_details));	break;	case 'inventory_client_filter':		print_r(inventory_client_filter($client_id));	break;	case 'get_add_new_row':		print_r(json_encode(get_add_new_row($new_entry_info)));	break;	case 'get_client_projects':		print_r(get_client_projects($client));	break;	case 'add_new_entry_timesheet':		print_r(json_encode(add_new_entry_timesheet($new_entry_timesheet)));	break;	case 'save_timesheet_entry':		print_r(json_encode(save_timesheet_entry($save_timesheet_row)));	break;	case 'update_record_column_timesheet':		print_r(json_encode(update_entry_column($update_entries_values)));	break;	case 'get_service_info':		print_r(json_encode(get_service_info($service_id)));	break;	case 'add_new_service_option':		print_r(json_encode(add_new_service_option($new_service_option)));	break;	case 'add_services_to_client':		print_r(json_encode(add_services_to_client($form_details)));	break;	case 'edit_services_to_client':		print_r(json_encode(edit_services_to_client($form_details, $service_id)));	break;	case 'edit_project_timesheet':		print_r(json_encode(EditProjectTimeSheet($edit_project_entry)));	break;	case 'save_editing_project_to_db':		print_r(json_encode(UpdateProjectNameOnClient($project_editing_value)));	break;	case 'edit_taskname_timesheet':		print_r(json_encode(EditTaskNameTimeSheet($edit_taskname_entry)));	break;	case 'save_editing_taskname_to_db':		print_r(json_encode(UpdateTaskNameOnClient($taskname_editing_value)));	break;	case 'manage_edit_client':		print_r(json_encode(UpdateMangeClient($data_object)));	break;	case 'manage_edit_client_update':		print_r(json_encode(UpdateMangeClientSave($data_object)));	break;	case 'detailed_time_get_client_projects':		print_r(json_encode(DetailedTimeReportGetProjects($edit_project_entry)));	break;	case 'detailed_time_update_project':		print_r(json_encode(DetailedTimeUpdateProject($project_editing_value)));	break;	case 'detailed_time_edit_taskname':		print_r(json_encode(DetailedTimeEditTaskname($edit_taskname_entry)));	break;	case 'add_client_todolist':		print_r(json_encode(AddTodoList($data_object)));	break;	case 'get_todolist_info':		print_r(json_encode(Get_TodoList_Info($data_id)));	break;	case 'save_todolist_progress':		print_r(json_encode(SaveTodoListProgress($data_object)));	break;	case 'delete_todolist_row':		print_r(json_encode(DeleteTodoList($data_id)));	break;	case 'update_todolist_row_status':		print_r(json_encode(UpdateTodoListRowStatus($data_object)));	break;	case 'get_consultants_dropdown_list':		print_r(json_encode(ConsultantDropdownList($data_id)));	break;	case 'updating_default_consultant_todolist':		print_r(json_encode(UpdatingConsultantDefaultTodoList($data_object)));	break;	case 'update_todolist_deadline':		print_r(json_encode(UpdateTodoListDeadline($data_object)));	break;	case 'filter_todolist_table':		print_r(json_encode(FilterTodoListTable($data_object)));	break;	case 'invoice_services':		print_r(json_encode(InvoiceClientService($data_id)));	break;	case 'delete_service_option':		print_r(json_encode(DeleteServiceOption($data_id)));	break;	case 'load_member_todolist':		print_r(json_encode(LoadMemberTodoList($data_object)));	break;	case 'update_client_todolist':		print_r(json_encode(UpdateTodoList($data_object)));	break;	case 'client_maintenanace_update_date':		print_r(json_encode(ClientMaintenanceUpdateDate($data_object)));	break;	case 'get_client_maitenance_info':		print_r(json_encode(ViewClientMaintenanceInfo($data_object)));	break;		case 'done_maintenance_schedule':		print_r(json_encode(DoneMaintenanceSchedule($data_object)));		break;	case 'delete_client_service':		print_r(json_encode(DeleteClientService($data_id)));		break;		case 'filter_client_service':		print_r(json_encode(FIlterClientServices($data_object)));	break;	case 'complete_maintenance':		print_r(json_encode(CompleteMaintenance($data_id)));	break;	case 'edit_detailed_time_order_no':		print_r(json_encode(EditDetailedTimeOrderNumber($data_object)));	break;	case 'get_client_default_project':		print_r(json_encode(GetClientDefaultProject($data_id)));	break;}?>