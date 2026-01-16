<?php
	define('PREPEND_PATH', '');
	include_once(__DIR__ . '/lib.php');

	// accept a record as an assoc array, return transformed row ready to insert to table
	$transformFunctions = [
		'user_table' => function($data, $options = []) {

			return $data;
		},
		'suggestion' => function($data, $options = []) {

			return $data;
		},
		'approval_table' => function($data, $options = []) {
			if(isset($data['person_responsbility'])) $data['person_responsbility'] = pkGivenLookupText($data['person_responsbility'], 'approval_table', 'person_responsbility');

			return $data;
		},
		'techlead_web_page' => function($data, $options = []) {
			if(isset($data['website_update_date'])) $data['website_update_date'] = guessMySQLDateTime($data['website_update_date']);

			return $data;
		},
		'navavishkar_stay_facilities_table' => function($data, $options = []) {
			if(isset($data['item_purchased_date'])) $data['item_purchased_date'] = guessMySQLDateTime($data['item_purchased_date']);
			if(isset($data['BillDate'])) $data['BillDate'] = guessMySQLDateTime($data['BillDate']);
			if(isset($data['custodian'])) $data['custodian'] = pkGivenLookupText($data['custodian'], 'navavishkar_stay_facilities_table', 'custodian');

			return $data;
		},
		'navavishkar_stay_facilities_allotment_table' => function($data, $options = []) {
			if(isset($data['item_lookup'])) $data['item_lookup'] = pkGivenLookupText($data['item_lookup'], 'navavishkar_stay_facilities_allotment_table', 'item_lookup');
			if(isset($data['select_employee'])) $data['select_employee'] = pkGivenLookupText($data['select_employee'], 'navavishkar_stay_facilities_allotment_table', 'select_employee');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['alloted_by'])) $data['alloted_by'] = pkGivenLookupText($data['alloted_by'], 'navavishkar_stay_facilities_allotment_table', 'alloted_by');
			if(isset($data['returned_date'])) $data['returned_date'] = guessMySQLDateTime($data['returned_date']);

			return $data;
		},
		'car_table' => function($data, $options = []) {
			if(isset($data['rental_start_date'])) $data['rental_start_date'] = guessMySQLDateTime($data['rental_start_date']);
			if(isset($data['rental_end_date'])) $data['rental_end_date'] = guessMySQLDateTime($data['rental_end_date']);

			return $data;
		},
		'car_usage_table' => function($data, $options = []) {
			if(isset($data['car_lookup'])) $data['car_lookup'] = pkGivenLookupText($data['car_lookup'], 'car_usage_table', 'car_lookup');
			if(isset($data['datetime_from'])) $data['datetime_from'] = guessMySQLDateTime($data['datetime_from']);
			if(isset($data['datetime_to'])) $data['datetime_to'] = guessMySQLDateTime($data['datetime_to']);

			return $data;
		},
		'cycle_table' => function($data, $options = []) {
			if(isset($data['responsible_contact_person'])) $data['responsible_contact_person'] = pkGivenLookupText($data['responsible_contact_person'], 'cycle_table', 'responsible_contact_person');

			return $data;
		},
		'cycle_usage_table' => function($data, $options = []) {
			if(isset($data['cycle_lookup'])) $data['cycle_lookup'] = pkGivenLookupText($data['cycle_lookup'], 'cycle_usage_table', 'cycle_lookup');
			if(isset($data['datetime_from'])) $data['datetime_from'] = guessMySQLDateTime($data['datetime_from']);
			if(isset($data['datetime_to'])) $data['datetime_to'] = guessMySQLDateTime($data['datetime_to']);

			return $data;
		},
		'gym_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'coffee_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'cafeteria_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'event_table' => function($data, $options = []) {
			if(isset($data['event_from_date'])) $data['event_from_date'] = guessMySQLDateTime($data['event_from_date']);
			if(isset($data['event_to_date'])) $data['event_to_date'] = guessMySQLDateTime($data['event_to_date']);

			return $data;
		},
		'outcomes_expected_table' => function($data, $options = []) {
			if(isset($data['event_lookup'])) $data['event_lookup'] = pkGivenLookupText($data['event_lookup'], 'outcomes_expected_table', 'event_lookup');

			return $data;
		},
		'event_decision_table' => function($data, $options = []) {
			if(isset($data['outcomes_expected_lookup'])) $data['outcomes_expected_lookup'] = pkGivenLookupText($data['outcomes_expected_lookup'], 'event_decision_table', 'outcomes_expected_lookup');
			if(isset($data['decision_actor'])) $data['decision_actor'] = pkGivenLookupText($data['decision_actor'], 'event_decision_table', 'decision_actor');
			if(isset($data['action_taken_with_date'])) $data['action_taken_with_date'] = guessMySQLDateTime($data['action_taken_with_date']);
			if(isset($data['decision_status_update_date'])) $data['decision_status_update_date'] = guessMySQLDateTime($data['decision_status_update_date']);

			return $data;
		},
		'meetings_table' => function($data, $options = []) {
			if(isset($data['visiting_card_lookup'])) $data['visiting_card_lookup'] = pkGivenLookupText($data['visiting_card_lookup'], 'meetings_table', 'visiting_card_lookup');
			if(isset($data['event_lookup'])) $data['event_lookup'] = pkGivenLookupText($data['event_lookup'], 'meetings_table', 'event_lookup');
			if(isset($data['meeting_from_date'])) $data['meeting_from_date'] = guessMySQLDateTime($data['meeting_from_date']);
			if(isset($data['meeting_to_date'])) $data['meeting_to_date'] = guessMySQLDateTime($data['meeting_to_date']);

			return $data;
		},
		'agenda_table' => function($data, $options = []) {
			if(isset($data['meeting_lookup'])) $data['meeting_lookup'] = pkGivenLookupText($data['meeting_lookup'], 'agenda_table', 'meeting_lookup');

			return $data;
		},
		'decision_table' => function($data, $options = []) {
			if(isset($data['agenda_lookup'])) $data['agenda_lookup'] = pkGivenLookupText($data['agenda_lookup'], 'decision_table', 'agenda_lookup');
			if(isset($data['decision_actor'])) $data['decision_actor'] = pkGivenLookupText($data['decision_actor'], 'decision_table', 'decision_actor');
			if(isset($data['action_taken_with_date'])) $data['action_taken_with_date'] = guessMySQLDateTime($data['action_taken_with_date']);
			if(isset($data['decision_status_update_date'])) $data['decision_status_update_date'] = guessMySQLDateTime($data['decision_status_update_date']);

			return $data;
		},
		'participants_table' => function($data, $options = []) {
			if(isset($data['event_lookup'])) $data['event_lookup'] = pkGivenLookupText($data['event_lookup'], 'participants_table', 'event_lookup');
			if(isset($data['meeting_lookup'])) $data['meeting_lookup'] = pkGivenLookupText($data['meeting_lookup'], 'participants_table', 'meeting_lookup');
			if(isset($data['status_date'])) $data['status_date'] = guessMySQLDateTime($data['status_date']);

			return $data;
		},
		'action_actor' => function($data, $options = []) {
			if(isset($data['actor'])) $data['actor'] = pkGivenLookupText($data['actor'], 'action_actor', 'actor');

			return $data;
		},
		'visiting_card_table' => function($data, $options = []) {
			if(isset($data['given_by'])) $data['given_by'] = pkGivenLookupText($data['given_by'], 'visiting_card_table', 'given_by');

			return $data;
		},
		'mou_details_table' => function($data, $options = []) {
			if(isset($data['date_of_agreement'])) $data['date_of_agreement'] = guessMySQLDateTime($data['date_of_agreement']);
			if(isset($data['date_of_expiry'])) $data['date_of_expiry'] = guessMySQLDateTime($data['date_of_expiry']);
			if(isset($data['assigned_mou_to'])) $data['assigned_mou_to'] = pkGivenLookupText($data['assigned_mou_to'], 'mou_details_table', 'assigned_mou_to');

			return $data;
		},
		'goal_setting_table' => function($data, $options = []) {
			if(isset($data['goal_set_date'])) $data['goal_set_date'] = guessMySQLDateTime($data['goal_set_date']);
			if(isset($data['supervisor_name'])) $data['supervisor_name'] = pkGivenLookupText($data['supervisor_name'], 'goal_setting_table', 'supervisor_name');
			if(isset($data['assigned_to'])) $data['assigned_to'] = pkGivenLookupText($data['assigned_to'], 'goal_setting_table', 'assigned_to');

			return $data;
		},
		'goal_progress_table' => function($data, $options = []) {
			if(isset($data['goal_lookup'])) $data['goal_lookup'] = pkGivenLookupText($data['goal_lookup'], 'goal_progress_table', 'goal_lookup');
			if(isset($data['remarks_by'])) $data['remarks_by'] = pkGivenLookupText($data['remarks_by'], 'goal_progress_table', 'remarks_by');

			return $data;
		},
		'task_allocation_table' => function($data, $options = []) {
			if(isset($data['task_set_date'])) $data['task_set_date'] = guessMySQLDateTime($data['task_set_date']);
			if(isset($data['supervisor_name'])) $data['supervisor_name'] = pkGivenLookupText($data['supervisor_name'], 'task_allocation_table', 'supervisor_name');
			if(isset($data['assigned_to'])) $data['assigned_to'] = pkGivenLookupText($data['assigned_to'], 'task_allocation_table', 'assigned_to');

			return $data;
		},
		'task_progress_status_table' => function($data, $options = []) {
			if(isset($data['task_lookup'])) $data['task_lookup'] = pkGivenLookupText($data['task_lookup'], 'task_progress_status_table', 'task_lookup');
			if(isset($data['progree_entry_date'])) $data['progree_entry_date'] = guessMySQLDateTime($data['progree_entry_date']);

			return $data;
		},
		'timesheet_entry_table' => function($data, $options = []) {
			if(isset($data['time_in'])) $data['time_in'] = guessMySQLDateTime($data['time_in']);
			if(isset($data['time_out'])) $data['time_out'] = guessMySQLDateTime($data['time_out']);
			if(isset($data['reporting_manager'])) $data['reporting_manager'] = pkGivenLookupText($data['reporting_manager'], 'timesheet_entry_table', 'reporting_manager');

			return $data;
		},
		'internship_fellowship_details_app' => function($data, $options = []) {

			return $data;
		},
		'star_pnt' => function($data, $options = []) {
			if(isset($data['iittnif_id'])) $data['iittnif_id'] = pkGivenLookupText($data['iittnif_id'], 'star_pnt', 'iittnif_id');

			return $data;
		},
		'hrd_sdp_events_table' => function($data, $options = []) {
			if(isset($data['start_date'])) $data['start_date'] = guessMySQLDateTime($data['start_date']);
			if(isset($data['end_date'])) $data['end_date'] = guessMySQLDateTime($data['end_date']);

			return $data;
		},
		'training_program_on_geospatial_tchnologies_table' => function($data, $options = []) {
			if(isset($data['datetime'])) $data['datetime'] = guessMySQLDateTime($data['datetime']);
			if(isset($data['attended_training_date'])) $data['attended_training_date'] = guessMySQLDateTime($data['attended_training_date']);

			return $data;
		},
		'space_day_school_details_app' => function($data, $options = []) {

			return $data;
		},
		'space_day_college_student_table' => function($data, $options = []) {

			return $data;
		},
		'school_list' => function($data, $options = []) {

			return $data;
		},
		'sdp_participants_college_details_table' => function($data, $options = []) {
			if(isset($data['start_date'])) $data['start_date'] = guessMySQLDateTime($data['start_date']);
			if(isset($data['end_date'])) $data['end_date'] = guessMySQLDateTime($data['end_date']);

			return $data;
		},
		'asset_table' => function($data, $options = []) {
			if(isset($data['Date'])) $data['Date'] = guessMySQLDateTime($data['Date']);
			if(isset($data['PODATE'])) $data['PODATE'] = guessMySQLDateTime($data['PODATE']);
			if(isset($data['BillDate'])) $data['BillDate'] = guessMySQLDateTime($data['BillDate']);

			return $data;
		},
		'asset_allotment_table' => function($data, $options = []) {
			if(isset($data['asset_lookup'])) $data['asset_lookup'] = pkGivenLookupText($data['asset_lookup'], 'asset_allotment_table', 'asset_lookup');
			if(isset($data['select_employee'])) $data['select_employee'] = pkGivenLookupText($data['select_employee'], 'asset_allotment_table', 'select_employee');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['alloted_by'])) $data['alloted_by'] = pkGivenLookupText($data['alloted_by'], 'asset_allotment_table', 'alloted_by');
			if(isset($data['returned_date'])) $data['returned_date'] = guessMySQLDateTime($data['returned_date']);

			return $data;
		},
		'sub_asset_table' => function($data, $options = []) {
			if(isset($data['Date'])) $data['Date'] = guessMySQLDateTime($data['Date']);
			if(isset($data['PODATE'])) $data['PODATE'] = guessMySQLDateTime($data['PODATE']);
			if(isset($data['BillDate'])) $data['BillDate'] = guessMySQLDateTime($data['BillDate']);

			return $data;
		},
		'sub_asset_allotment_table' => function($data, $options = []) {
			if(isset($data['sub_asset_lookup'])) $data['sub_asset_lookup'] = pkGivenLookupText($data['sub_asset_lookup'], 'sub_asset_allotment_table', 'sub_asset_lookup');
			if(isset($data['select_employee'])) $data['select_employee'] = pkGivenLookupText($data['select_employee'], 'sub_asset_allotment_table', 'select_employee');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['alloted_by'])) $data['alloted_by'] = pkGivenLookupText($data['alloted_by'], 'sub_asset_allotment_table', 'alloted_by');
			if(isset($data['returned_date'])) $data['returned_date'] = guessMySQLDateTime($data['returned_date']);

			return $data;
		},
		'it_inventory_app' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['date_of_useful_life_of_assets_ends'])) $data['date_of_useful_life_of_assets_ends'] = guessMySQLDateTime($data['date_of_useful_life_of_assets_ends']);
			if(isset($data['sactioned_by'])) $data['sactioned_by'] = pkGivenLookupText($data['sactioned_by'], 'it_inventory_app', 'sactioned_by');

			return $data;
		},
		'it_inventory_billing_details' => function($data, $options = []) {
			if(isset($data['it_inventory_lookup'])) $data['it_inventory_lookup'] = pkGivenLookupText($data['it_inventory_lookup'], 'it_inventory_billing_details', 'it_inventory_lookup');
			if(isset($data['po_date'])) $data['po_date'] = guessMySQLDateTime($data['po_date']);
			if(isset($data['bill_date'])) $data['bill_date'] = guessMySQLDateTime($data['bill_date']);

			return $data;
		},
		'it_inventory_allotment_table' => function($data, $options = []) {
			if(isset($data['select_employee'])) $data['select_employee'] = pkGivenLookupText($data['select_employee'], 'it_inventory_allotment_table', 'select_employee');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['alloted_by'])) $data['alloted_by'] = pkGivenLookupText($data['alloted_by'], 'it_inventory_allotment_table', 'alloted_by');
			if(isset($data['returned_date'])) $data['returned_date'] = guessMySQLDateTime($data['returned_date']);

			return $data;
		},
		'computer_details_table' => function($data, $options = []) {

			return $data;
		},
		'computer_user_details' => function($data, $options = []) {
			if(isset($data['pc_id'])) $data['pc_id'] = pkGivenLookupText($data['pc_id'], 'computer_user_details', 'pc_id');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'computer_allotment_table' => function($data, $options = []) {
			if(isset($data['pc_id'])) $data['pc_id'] = pkGivenLookupText($data['pc_id'], 'computer_allotment_table', 'pc_id');
			if(isset($data['from_date'])) $data['from_date'] = guessMySQLDateTime($data['from_date']);
			if(isset($data['to_date'])) $data['to_date'] = guessMySQLDateTime($data['to_date']);

			return $data;
		},
		'employees_personal_data_table' => function($data, $options = []) {
			if(isset($data['date_of_birth'])) $data['date_of_birth'] = guessMySQLDateTime($data['date_of_birth']);
			if(isset($data['date_of_joining'])) $data['date_of_joining'] = guessMySQLDateTime($data['date_of_joining']);
			if(isset($data['date_of_exit'])) $data['date_of_exit'] = guessMySQLDateTime($data['date_of_exit']);

			return $data;
		},
		'employees_designation_table' => function($data, $options = []) {
			if(isset($data['employee_lookup'])) $data['employee_lookup'] = pkGivenLookupText($data['employee_lookup'], 'employees_designation_table', 'employee_lookup');
			if(isset($data['date_of_appointment_to_designation'])) $data['date_of_appointment_to_designation'] = guessMySQLDateTime($data['date_of_appointment_to_designation']);
			if(isset($data['reporting_officer'])) $data['reporting_officer'] = pkGivenLookupText($data['reporting_officer'], 'employees_designation_table', 'reporting_officer');
			if(isset($data['reviewing_officer'])) $data['reviewing_officer'] = pkGivenLookupText($data['reviewing_officer'], 'employees_designation_table', 'reviewing_officer');

			return $data;
		},
		'employees_appraisal_table' => function($data, $options = []) {
			if(isset($data['employee_designation_lookup'])) $data['employee_designation_lookup'] = pkGivenLookupText($data['employee_designation_lookup'], 'employees_appraisal_table', 'employee_designation_lookup');
			if(isset($data['current_review_period_from'])) $data['current_review_period_from'] = guessMySQLDateTime($data['current_review_period_from']);
			if(isset($data['current_review_period_to'])) $data['current_review_period_to'] = guessMySQLDateTime($data['current_review_period_to']);
			if(isset($data['reviewing_officer'])) $data['reviewing_officer'] = pkGivenLookupText($data['reviewing_officer'], 'employees_appraisal_table', 'reviewing_officer');

			return $data;
		},
		'beyond_working_hours_table' => function($data, $options = []) {
			if(isset($data['start_datetime'])) $data['start_datetime'] = guessMySQLDateTime($data['start_datetime']);
			if(isset($data['end_datetime'])) $data['end_datetime'] = guessMySQLDateTime($data['end_datetime']);

			return $data;
		},
		'leave_table' => function($data, $options = []) {
			if(isset($data['from_date'])) $data['from_date'] = guessMySQLDateTime($data['from_date']);
			if(isset($data['to_date'])) $data['to_date'] = guessMySQLDateTime($data['to_date']);

			return $data;
		},
		'half_day_leave_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'work_from_home_table' => function($data, $options = []) {
			if(isset($data['from_date'])) $data['from_date'] = guessMySQLDateTime($data['from_date']);
			if(isset($data['to_date'])) $data['to_date'] = guessMySQLDateTime($data['to_date']);

			return $data;
		},
		'work_from_home_tasks_app' => function($data, $options = []) {
			if(isset($data['work_from_home_details'])) $data['work_from_home_details'] = pkGivenLookupText($data['work_from_home_details'], 'work_from_home_tasks_app', 'work_from_home_details');
			if(isset($data['day'])) $data['day'] = guessMySQLDateTime($data['day']);

			return $data;
		},
		'navavishkar_stay_table' => function($data, $options = []) {
			if(isset($data['check_in_date'])) $data['check_in_date'] = guessMySQLDateTime($data['check_in_date']);
			if(isset($data['checkout_date'])) $data['checkout_date'] = guessMySQLDateTime($data['checkout_date']);

			return $data;
		},
		'navavishkar_stay_payment_table' => function($data, $options = []) {
			if(isset($data['navavishakr_stay_details'])) $data['navavishakr_stay_details'] = pkGivenLookupText($data['navavishakr_stay_details'], 'navavishkar_stay_payment_table', 'navavishakr_stay_details');

			return $data;
		},
		'email_id_allocation_table' => function($data, $options = []) {
			if(isset($data['date_of_allocation'])) $data['date_of_allocation'] = guessMySQLDateTime($data['date_of_allocation']);
			if(isset($data['reporting_manager'])) $data['reporting_manager'] = pkGivenLookupText($data['reporting_manager'], 'email_id_allocation_table', 'reporting_manager');

			return $data;
		},
		'attendence_details_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'all_startup_data_table' => function($data, $options = []) {
			if(isset($data['date_of_incubation'])) $data['date_of_incubation'] = guessMySQLDateTime($data['date_of_incubation']);

			return $data;
		},
		'shortlisted_startups_for_fund_table' => function($data, $options = []) {
			if(isset($data['startup'])) $data['startup'] = pkGivenLookupText($data['startup'], 'shortlisted_startups_for_fund_table', 'startup');

			return $data;
		},
		'shortlisted_startups_dd_and_agreement_table' => function($data, $options = []) {
			if(isset($data['startup'])) $data['startup'] = pkGivenLookupText($data['startup'], 'shortlisted_startups_dd_and_agreement_table', 'startup');

			return $data;
		},
		'vikas_startup_applications_table' => function($data, $options = []) {
			if(isset($data['incorporation_date'])) $data['incorporation_date'] = guessMySQLDateTime($data['incorporation_date']);
			if(isset($data['datetime'])) $data['datetime'] = guessMySQLDateTime($data['datetime']);

			return $data;
		},
		'programs_table' => function($data, $options = []) {

			return $data;
		},
		'evaluation_table' => function($data, $options = []) {
			if(isset($data['select_startup'])) $data['select_startup'] = pkGivenLookupText($data['select_startup'], 'evaluation_table', 'select_startup');

			return $data;
		},
		'problem_statement_table' => function($data, $options = []) {
			if(isset($data['select_program_id'])) $data['select_program_id'] = pkGivenLookupText($data['select_program_id'], 'problem_statement_table', 'select_program_id');

			return $data;
		},
		'evaluators_table' => function($data, $options = []) {
			if(isset($data['evaluation_lookup'])) $data['evaluation_lookup'] = pkGivenLookupText($data['evaluation_lookup'], 'evaluators_table', 'evaluation_lookup');

			return $data;
		},
		'approval_billing_table' => function($data, $options = []) {
			if(isset($data['approval_lookup'])) $data['approval_lookup'] = pkGivenLookupText($data['approval_lookup'], 'approval_billing_table', 'approval_lookup');
			if(isset($data['date_of_purchase'])) $data['date_of_purchase'] = guessMySQLDateTime($data['date_of_purchase']);
			if(isset($data['paid_by'])) $data['paid_by'] = pkGivenLookupText($data['paid_by'], 'approval_billing_table', 'paid_by');

			return $data;
		},
		'honorarium_claim_table' => function($data, $options = []) {
			if(isset($data['date_1'])) $data['date_1'] = guessMySQLDateTime($data['date_1']);
			if(isset($data['date_2'])) $data['date_2'] = guessMySQLDateTime($data['date_2']);
			if(isset($data['date_3'])) $data['date_3'] = guessMySQLDateTime($data['date_3']);
			if(isset($data['date_4'])) $data['date_4'] = guessMySQLDateTime($data['date_4']);
			if(isset($data['date_5'])) $data['date_5'] = guessMySQLDateTime($data['date_5']);
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['coordinated_by_tih_user'])) $data['coordinated_by_tih_user'] = pkGivenLookupText($data['coordinated_by_tih_user'], 'honorarium_claim_table', 'coordinated_by_tih_user');
			if(isset($data['payment_date'])) $data['payment_date'] = guessMySQLDateTime($data['payment_date']);

			return $data;
		},
		'honorarium_Activities' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'all_bank_account_statement_table' => function($data, $options = []) {
			if(isset($data['txn_date'])) $data['txn_date'] = guessMySQLDateTime($data['txn_date']);
			if(isset($data['value_date'])) $data['value_date'] = guessMySQLDateTime($data['value_date']);

			return $data;
		},
		'payment_track_details_table' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);
			if(isset($data['payment_date'])) $data['payment_date'] = guessMySQLDateTime($data['payment_date']);

			return $data;
		},
		'travel_table' => function($data, $options = []) {
			if(isset($data['date_from'])) $data['date_from'] = guessMySQLDateTime($data['date_from']);
			if(isset($data['date_to'])) $data['date_to'] = guessMySQLDateTime($data['date_to']);

			return $data;
		},
		'travel_stay_table' => function($data, $options = []) {
			if(isset($data['checkin_date'])) $data['checkin_date'] = guessMySQLDateTime($data['checkin_date']);
			if(isset($data['checkout_date'])) $data['checkout_date'] = guessMySQLDateTime($data['checkout_date']);

			return $data;
		},
		'travel_local_commute_table' => function($data, $options = []) {

			return $data;
		},
		'r_and_d_progress' => function($data, $options = []) {
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'panel_decision_table_tdp' => function($data, $options = []) {
			if(isset($data['date_of_presentation'])) $data['date_of_presentation'] = guessMySQLDateTime($data['date_of_presentation']);

			return $data;
		},
		'selected_proposals_final_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'selected_proposals_final_tdp', 'project_id');

			return $data;
		},
		'stage_wise_budget_table_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'stage_wise_budget_table_tdp', 'project_id');

			return $data;
		},
		'first_level_shortlisted_proposals_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'first_level_shortlisted_proposals_tdp', 'project_id');

			return $data;
		},
		'budget_table_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'budget_table_tdp', 'project_id');
			if(isset($data['date_of_presentation'])) $data['date_of_presentation'] = guessMySQLDateTime($data['date_of_presentation']);

			return $data;
		},
		'panel_comments_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'panel_comments_tdp', 'project_id');

			return $data;
		},
		'selected_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'selected_tdp', 'project_id');

			return $data;
		},
		'address_tdp' => function($data, $options = []) {
			if(isset($data['project_id'])) $data['project_id'] = pkGivenLookupText($data['project_id'], 'address_tdp', 'project_id');

			return $data;
		},
		'summary_table_tdp' => function($data, $options = []) {
			if(isset($data['sactioned_date'])) $data['sactioned_date'] = guessMySQLDateTime($data['sactioned_date']);
			if(isset($data['first_milestone_amount_and_date'])) $data['first_milestone_amount_and_date'] = guessMySQLDateTime($data['first_milestone_amount_and_date']);
			if(isset($data['stage_I_completion'])) $data['stage_I_completion'] = guessMySQLDateTime($data['stage_I_completion']);
			if(isset($data['second_milestone_amount_and_date'])) $data['second_milestone_amount_and_date'] = guessMySQLDateTime($data['second_milestone_amount_and_date']);
			if(isset($data['stage_2_completion'])) $data['stage_2_completion'] = guessMySQLDateTime($data['stage_2_completion']);
			if(isset($data['third_milestone_amount_and_date'])) $data['third_milestone_amount_and_date'] = guessMySQLDateTime($data['third_milestone_amount_and_date']);
			if(isset($data['stage_3_completion'])) $data['stage_3_completion'] = guessMySQLDateTime($data['stage_3_completion']);
			if(isset($data['fourth_milestone_amount_and_date'])) $data['fourth_milestone_amount_and_date'] = guessMySQLDateTime($data['fourth_milestone_amount_and_date']);
			if(isset($data['stage_4_completion'])) $data['stage_4_completion'] = guessMySQLDateTime($data['stage_4_completion']);

			return $data;
		},
		'project_details_tdp' => function($data, $options = []) {
			if(isset($data['project_number'])) $data['project_number'] = pkGivenLookupText($data['project_number'], 'project_details_tdp', 'project_number');

			return $data;
		},
		'newsletter_table' => function($data, $options = []) {

			return $data;
		},
		'contact_call_log_table' => function($data, $options = []) {

			return $data;
		},
		'r_and_d_monthly_progress_app' => function($data, $options = []) {
			if(isset($data['r_and_d_lookup'])) $data['r_and_d_lookup'] = pkGivenLookupText($data['r_and_d_lookup'], 'r_and_d_monthly_progress_app', 'r_and_d_lookup');

			return $data;
		},
		'r_and_d_quarterly_progress_app' => function($data, $options = []) {
			if(isset($data['r_and_d_lookup'])) $data['r_and_d_lookup'] = pkGivenLookupText($data['r_and_d_lookup'], 'r_and_d_quarterly_progress_app', 'r_and_d_lookup');
			if(isset($data['date'])) $data['date'] = guessMySQLDateTime($data['date']);

			return $data;
		},
		'projects' => function($data, $options = []) {

			return $data;
		},
		'td_projects_td_intellectual_property' => function($data, $options = []) {
			if(isset($data['year_field'])) $data['year_field'] = guessMySQLDateTime($data['year_field']);
			if(isset($data['year_granted'])) $data['year_granted'] = guessMySQLDateTime($data['year_granted']);
			if(isset($data['source_of_ip'])) $data['source_of_ip'] = pkGivenLookupText($data['source_of_ip'], 'td_projects_td_intellectual_property', 'source_of_ip');

			return $data;
		},
		'td_projects_td_technology_products' => function($data, $options = []) {
			if(isset($data['source_of_ip'])) $data['source_of_ip'] = pkGivenLookupText($data['source_of_ip'], 'td_projects_td_technology_products', 'source_of_ip');

			return $data;
		},
		'td_publications_and_intellectual_activities' => function($data, $options = []) {

			return $data;
		},
		'td_publications' => function($data, $options = []) {
			if(isset($data['publications_and_intellectual_activities_details'])) $data['publications_and_intellectual_activities_details'] = pkGivenLookupText($data['publications_and_intellectual_activities_details'], 'td_publications', 'publications_and_intellectual_activities_details');
			if(isset($data['publication_year'])) $data['publication_year'] = guessMySQLDateTime($data['publication_year']);
			if(isset($data['source_of_ip'])) $data['source_of_ip'] = pkGivenLookupText($data['source_of_ip'], 'td_publications', 'source_of_ip');

			return $data;
		},
		'td_ipr' => function($data, $options = []) {
			if(isset($data['publications_and_intellectual_activities_details'])) $data['publications_and_intellectual_activities_details'] = pkGivenLookupText($data['publications_and_intellectual_activities_details'], 'td_ipr', 'publications_and_intellectual_activities_details');
			if(isset($data['start_date'])) $data['start_date'] = guessMySQLDateTime($data['start_date']);
			if(isset($data['end_date'])) $data['end_date'] = guessMySQLDateTime($data['end_date']);

			return $data;
		},
		'td_cps_research_base' => function($data, $options = []) {

			return $data;
		},
		'ed_tbi' => function($data, $options = []) {
			if(isset($data['collaboration_date'])) $data['collaboration_date'] = guessMySQLDateTime($data['collaboration_date']);

			return $data;
		},
		'ed_startup_companies' => function($data, $options = []) {

			return $data;
		},
		'ed_gcc' => function($data, $options = []) {
			if(isset($data['Start_Date'])) $data['Start_Date'] = guessMySQLDateTime($data['Start_Date']);
			if(isset($data['End_Date'])) $data['End_Date'] = guessMySQLDateTime($data['End_Date']);

			return $data;
		},
		'ed_eir' => function($data, $options = []) {
			if(isset($data['Start_Date'])) $data['Start_Date'] = guessMySQLDateTime($data['Start_Date']);
			if(isset($data['End_Date'])) $data['End_Date'] = guessMySQLDateTime($data['End_Date']);

			return $data;
		},
		'ed_job_creation' => function($data, $options = []) {
			if(isset($data['Joining_Date'])) $data['Joining_Date'] = guessMySQLDateTime($data['Joining_Date']);

			return $data;
		},
		'hrd_Fellowship' => function($data, $options = []) {
			if(isset($data['Start_Date'])) $data['Start_Date'] = guessMySQLDateTime($data['Start_Date']);
			if(isset($data['End_Date'])) $data['End_Date'] = guessMySQLDateTime($data['End_Date']);

			return $data;
		},
		'hrd_sd' => function($data, $options = []) {
			if(isset($data['Start_Date'])) $data['Start_Date'] = guessMySQLDateTime($data['Start_Date']);
			if(isset($data['End_Date'])) $data['End_Date'] = guessMySQLDateTime($data['End_Date']);

			return $data;
		},
		'it_International_Collaboration' => function($data, $options = []) {
			if(isset($data['MoU_Signed_Date'])) $data['MoU_Signed_Date'] = guessMySQLDateTime($data['MoU_Signed_Date']);
			if(isset($data['Start_Date'])) $data['Start_Date'] = guessMySQLDateTime($data['Start_Date']);
			if(isset($data['End_Date'])) $data['End_Date'] = guessMySQLDateTime($data['End_Date']);

			return $data;
		},
	];

	// accept a record as an assoc array, return a boolean indicating whether to import or skip record
	$filterFunctions = [
		'user_table' => function($data, $options = []) { return true; },
		'suggestion' => function($data, $options = []) { return true; },
		'approval_table' => function($data, $options = []) { return true; },
		'techlead_web_page' => function($data, $options = []) { return true; },
		'navavishkar_stay_facilities_table' => function($data, $options = []) { return true; },
		'navavishkar_stay_facilities_allotment_table' => function($data, $options = []) { return true; },
		'car_table' => function($data, $options = []) { return true; },
		'car_usage_table' => function($data, $options = []) { return true; },
		'cycle_table' => function($data, $options = []) { return true; },
		'cycle_usage_table' => function($data, $options = []) { return true; },
		'gym_table' => function($data, $options = []) { return true; },
		'coffee_table' => function($data, $options = []) { return true; },
		'cafeteria_table' => function($data, $options = []) { return true; },
		'event_table' => function($data, $options = []) { return true; },
		'outcomes_expected_table' => function($data, $options = []) { return true; },
		'event_decision_table' => function($data, $options = []) { return true; },
		'meetings_table' => function($data, $options = []) { return true; },
		'agenda_table' => function($data, $options = []) { return true; },
		'decision_table' => function($data, $options = []) { return true; },
		'participants_table' => function($data, $options = []) { return true; },
		'action_actor' => function($data, $options = []) { return true; },
		'visiting_card_table' => function($data, $options = []) { return true; },
		'mou_details_table' => function($data, $options = []) { return true; },
		'goal_setting_table' => function($data, $options = []) { return true; },
		'goal_progress_table' => function($data, $options = []) { return true; },
		'task_allocation_table' => function($data, $options = []) { return true; },
		'task_progress_status_table' => function($data, $options = []) { return true; },
		'timesheet_entry_table' => function($data, $options = []) { return true; },
		'internship_fellowship_details_app' => function($data, $options = []) { return true; },
		'star_pnt' => function($data, $options = []) { return true; },
		'hrd_sdp_events_table' => function($data, $options = []) { return true; },
		'training_program_on_geospatial_tchnologies_table' => function($data, $options = []) { return true; },
		'space_day_school_details_app' => function($data, $options = []) { return true; },
		'space_day_college_student_table' => function($data, $options = []) { return true; },
		'school_list' => function($data, $options = []) { return true; },
		'sdp_participants_college_details_table' => function($data, $options = []) { return true; },
		'asset_table' => function($data, $options = []) { return true; },
		'asset_allotment_table' => function($data, $options = []) { return true; },
		'sub_asset_table' => function($data, $options = []) { return true; },
		'sub_asset_allotment_table' => function($data, $options = []) { return true; },
		'it_inventory_app' => function($data, $options = []) { return true; },
		'it_inventory_billing_details' => function($data, $options = []) { return true; },
		'it_inventory_allotment_table' => function($data, $options = []) { return true; },
		'computer_details_table' => function($data, $options = []) { return true; },
		'computer_user_details' => function($data, $options = []) { return true; },
		'computer_allotment_table' => function($data, $options = []) { return true; },
		'employees_personal_data_table' => function($data, $options = []) { return true; },
		'employees_designation_table' => function($data, $options = []) { return true; },
		'employees_appraisal_table' => function($data, $options = []) { return true; },
		'beyond_working_hours_table' => function($data, $options = []) { return true; },
		'leave_table' => function($data, $options = []) { return true; },
		'half_day_leave_table' => function($data, $options = []) { return true; },
		'work_from_home_table' => function($data, $options = []) { return true; },
		'work_from_home_tasks_app' => function($data, $options = []) { return true; },
		'navavishkar_stay_table' => function($data, $options = []) { return true; },
		'navavishkar_stay_payment_table' => function($data, $options = []) { return true; },
		'email_id_allocation_table' => function($data, $options = []) { return true; },
		'attendence_details_table' => function($data, $options = []) { return true; },
		'all_startup_data_table' => function($data, $options = []) { return true; },
		'shortlisted_startups_for_fund_table' => function($data, $options = []) { return true; },
		'shortlisted_startups_dd_and_agreement_table' => function($data, $options = []) { return true; },
		'vikas_startup_applications_table' => function($data, $options = []) { return true; },
		'programs_table' => function($data, $options = []) { return true; },
		'evaluation_table' => function($data, $options = []) { return true; },
		'problem_statement_table' => function($data, $options = []) { return true; },
		'evaluators_table' => function($data, $options = []) { return true; },
		'approval_billing_table' => function($data, $options = []) { return true; },
		'honorarium_claim_table' => function($data, $options = []) { return true; },
		'honorarium_Activities' => function($data, $options = []) { return true; },
		'all_bank_account_statement_table' => function($data, $options = []) { return true; },
		'payment_track_details_table' => function($data, $options = []) { return true; },
		'travel_table' => function($data, $options = []) { return true; },
		'travel_stay_table' => function($data, $options = []) { return true; },
		'travel_local_commute_table' => function($data, $options = []) { return true; },
		'r_and_d_progress' => function($data, $options = []) { return true; },
		'panel_decision_table_tdp' => function($data, $options = []) { return true; },
		'selected_proposals_final_tdp' => function($data, $options = []) { return true; },
		'stage_wise_budget_table_tdp' => function($data, $options = []) { return true; },
		'first_level_shortlisted_proposals_tdp' => function($data, $options = []) { return true; },
		'budget_table_tdp' => function($data, $options = []) { return true; },
		'panel_comments_tdp' => function($data, $options = []) { return true; },
		'selected_tdp' => function($data, $options = []) { return true; },
		'address_tdp' => function($data, $options = []) { return true; },
		'summary_table_tdp' => function($data, $options = []) { return true; },
		'project_details_tdp' => function($data, $options = []) { return true; },
		'newsletter_table' => function($data, $options = []) { return true; },
		'contact_call_log_table' => function($data, $options = []) { return true; },
		'r_and_d_monthly_progress_app' => function($data, $options = []) { return true; },
		'r_and_d_quarterly_progress_app' => function($data, $options = []) { return true; },
		'projects' => function($data, $options = []) { return true; },
		'td_projects_td_intellectual_property' => function($data, $options = []) { return true; },
		'td_projects_td_technology_products' => function($data, $options = []) { return true; },
		'td_publications_and_intellectual_activities' => function($data, $options = []) { return true; },
		'td_publications' => function($data, $options = []) { return true; },
		'td_ipr' => function($data, $options = []) { return true; },
		'td_cps_research_base' => function($data, $options = []) { return true; },
		'ed_tbi' => function($data, $options = []) { return true; },
		'ed_startup_companies' => function($data, $options = []) { return true; },
		'ed_gcc' => function($data, $options = []) { return true; },
		'ed_eir' => function($data, $options = []) { return true; },
		'ed_job_creation' => function($data, $options = []) { return true; },
		'hrd_Fellowship' => function($data, $options = []) { return true; },
		'hrd_sd' => function($data, $options = []) { return true; },
		'it_International_Collaboration' => function($data, $options = []) { return true; },
	];

	/*
	Hook file for overwriting/amending $transformFunctions and $filterFunctions:
	hooks/import-csv.php
	If found, it's included below

	The way this works is by either completely overwriting any of the above 2 arrays,
	or, more commonly, overwriting a single function, for example:
		$transformFunctions['tablename'] = function($data, $options = []) {
			// new definition here
			// then you must return transformed data
			return $data;
		};

	Another scenario is transforming a specific field and leaving other fields to the default
	transformation. One possible way of doing this is to store the original transformation function
	in GLOBALS array, calling it inside the custom transformation function, then modifying the
	specific field:
		$GLOBALS['originalTransformationFunction'] = $transformFunctions['tablename'];
		$transformFunctions['tablename'] = function($data, $options = []) {
			$data = call_user_func_array($GLOBALS['originalTransformationFunction'], [$data, $options]);
			$data['fieldname'] = 'transformed value';
			return $data;
		};
	*/

	@include(__DIR__ . '/hooks/import-csv.php');

	$ui = new CSVImportUI($transformFunctions, $filterFunctions);
