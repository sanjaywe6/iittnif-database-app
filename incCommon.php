<?php

	#########################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		get_table_groups() -- returns an associative array (table_group => tables_array)
		getTablePermissions($tn) -- returns an array of permissions allowed for logged member to given table (allowAccess, allowInsert, allowView, allowEdit, allowDelete) -- allowAccess is set to true if any access level is allowed
		get_sql_fields($tn) -- returns the SELECT part of the table view query
		get_sql_from($tn[, true, [, false]]) -- returns the FROM part of the table view query, with full joins (unless third paramaeter is set to true), optionally skipping permissions if true passed as 2nd param.
		get_joined_record($table, $id[, true]) -- returns assoc array of record values for given PK value of given table, with full joins, optionally skipping permissions if true passed as 3rd param.
		get_defaults($table) -- returns assoc array of table fields as array keys and default values (or empty), excluding automatic values as array values
		htmlUserBar() -- returns html code for displaying user login status to be used on top of pages.
		showNotifications($msg, $class) -- returns html code for displaying a notification. If no parameters provided, processes the GET request for possible notifications.
		parseMySQLDate(a, b) -- returns a if valid mysql date, or b if valid mysql date, or today if b is true, or empty if b is false.
		parseCode(code) -- calculates and returns special values to be inserted in automatic fields.
		addFilter(i, filterAnd, filterField, filterOperator, filterValue) -- enforce a filter over data
		clearFilters() -- clear all filters
		loadView($view, $data) -- passes $data to templates/{$view}.php and returns the output
		loadTable($table, $data) -- loads table template, passing $data to it
		br2nl($text) -- replaces all variations of HTML <br> tags with a new line character
		entitiesToUTF8($text) -- convert unicode entities (e.g. &#1234;) to actual UTF8 characters, requires multibyte string PHP extension
		func_get_args_byref() -- returns an array of arguments passed to a function, by reference
		permissions_sql($table, $level) -- returns an array containing the FROM and WHERE additions for applying permissions to an SQL query
		error_message($msg[, $back_url]) -- returns html code for a styled error message .. pass explicit false in second param to suppress back button
		toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format)
		reIndex(&$arr) -- returns a copy of the given array, with keys replaced by 1-based numeric indices, and values replaced by original keys
		get_embed($provider, $url[, $width, $height, $retrieve]) -- returns embed code for a given url (supported providers: [auto-detect], or explicitly pass one of: youtube, vimeo, googlemap, dailymotion, videofileurl)
		check_record_permission($table, $id, $perm = 'view') -- returns true if current user has the specified permission $perm ('view', 'edit' or 'delete') for the given recors, false otherwise
		NavMenus($options) -- returns the HTML code for the top navigation menus. $options is not implemented currently.
		StyleSheet() -- returns the HTML code for included style sheet files to be placed in the <head> section.
		PrepareUploadedFile($FieldName, $MaxSize, $FileTypes={image file types}, $NoRename=false, $dir="") -- validates and moves uploaded file for given $FieldName into the given $dir (or the default one if empty)
		get_home_links($homeLinks, $default_classes, $tgroup) -- process $homeLinks array and return custom links for homepage. Applies $default_classes to links if links have classes defined, and filters links by $tgroup (using '*' matches all table_group values)
		quick_search_html($search_term, $label, $separate_dv = true) -- returns HTML code for the quick search box.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/

	#########################################################

	function get_table_groups($skip_authentication = false) {
		$tables = getTableList($skip_authentication);
		$all_groups = ['Approval App', 'Facilities Apps', 'Events / Meetings / Goals Apps', 'HRD Apps', 'SDP Apps', 'Program Apps', 'Technology Development Apps', 'Startup Data Management Apps', 'Employee Data Management Apps', 'Asset Management Apps', 'Accounts &amp; Finance Apps', 'Transport Apps', 'Suggestion App'];

		$groups = [];
		foreach($all_groups as $grp) {
			foreach($tables as $tn => $td) {
				if($td[3] && $td[3] == $grp) $groups[$grp][] = $tn;
				if(!$td[3]) $groups[0][] = $tn;
			}
		}

		return $groups;
	}

	#########################################################

	function getTablePermissions($tn) {
		static $table_permissions = [];
		if(isset($table_permissions[$tn])) return $table_permissions[$tn];

		$groupID = getLoggedGroupID();
		$memberID = makeSafe(getLoggedMemberID());
		$res_group = sql("SELECT `tableName`, `allowInsert`, `allowView`, `allowEdit`, `allowDelete` FROM `membership_grouppermissions` WHERE `groupID`='{$groupID}'", $eo);
		$res_user  = sql("SELECT `tableName`, `allowInsert`, `allowView`, `allowEdit`, `allowDelete` FROM `membership_userpermissions`  WHERE LCASE(`memberID`)='{$memberID}'", $eo);

		while($row = db_fetch_assoc($res_group)) {
			$table_permissions[$row['tableName']] = [
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			];
		}

		// user-specific permissions, if specified, overwrite his group permissions
		while($row = db_fetch_assoc($res_user)) {
			$table_permissions[$row['tableName']] = [
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			];
		}

		// if user has any type of access, set 'access' flag
		foreach($table_permissions as $t => $p) {
			$table_permissions[$t]['access'] = $table_permissions[$t][0] = false;

			if($p['insert'] || $p['view'] || $p['edit'] || $p['delete']) {
				$table_permissions[$t]['access'] = $table_permissions[$t][0] = true;
			}
		}

		return $table_permissions[$tn] ?? [];
	}

	#########################################################

	function get_sql_fields($table_name) {
		$sql_fields = [
			'user_table' => "`user_table`.`user_id` as 'user_id', `user_table`.`memberID` as 'memberID', `user_table`.`name` as 'name'",
			'suggestion' => "`suggestion`.`suggestion_id` as 'suggestion_id', `suggestion`.`department` as 'department', `suggestion`.`suggestion` as 'suggestion', `suggestion`.`attachment` as 'attachment', `suggestion`.`department_remarks` as 'department_remarks', `suggestion`.`ceo_pd_remarks` as 'ceo_pd_remarks', `suggestion`.`created_by` as 'created_by', `suggestion`.`created_at` as 'created_at', `suggestion`.`last_updated_by` as 'last_updated_by', `suggestion`.`last_updated_at` as 'last_updated_at'",
			'approval_table' => "`approval_table`.`id` as 'id', `approval_table`.`type` as 'type', `approval_table`.`description` as 'description', `approval_table`.`quantity` as 'quantity', `approval_table`.`full_est_value` as 'full_est_value', `approval_table`.`name_of_vendor` as 'name_of_vendor', `approval_table`.`purpose` as 'purpose', `approval_table`.`requested_department` as 'requested_department', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'person_responsbility', `approval_table`.`mode_of_purchase` as 'mode_of_purchase', `approval_table`.`others_if_any` as 'others_if_any', `approval_table`.`approval_status` as 'approval_status', `approval_table`.`remarks_for_approval` as 'remarks_for_approval', `approval_table`.`image` as 'image', `approval_table`.`other_file` as 'other_file', `approval_table`.`created_by` as 'created_by', `approval_table`.`created_at` as 'created_at', `approval_table`.`last_updated_by` as 'last_updated_by', `approval_table`.`last_updated_at` as 'last_updated_at'",
			'car_table' => "`car_table`.`id` as 'id', `car_table`.`car_number` as 'car_number', `car_table`.`registration_number` as 'registration_number', `car_table`.`car_model` as 'car_model', `car_table`.`car_vin` as 'car_vin', `car_table`.`fuel_type` as 'fuel_type', `car_table`.`seating_capacity` as 'seating_capacity', `car_table`.`car_color` as 'car_color', `car_table`.`rental_company_name` as 'rental_company_name', `car_table`.`contact_person` as 'contact_person', `car_table`.`contact_number_of_person` as 'contact_number_of_person', `car_table`.`rental_rate` as 'rental_rate', if(`car_table`.`rental_start_date`,date_format(`car_table`.`rental_start_date`,'%d/%m/%Y'),'') as 'rental_start_date', if(`car_table`.`rental_end_date`,date_format(`car_table`.`rental_end_date`,'%d/%m/%Y'),'') as 'rental_end_date', `car_table`.`purpose` as 'purpose', `car_table`.`created_by` as 'created_by', `car_table`.`created_at` as 'created_at', `car_table`.`last_updated_by` as 'last_updated_by', `car_table`.`last_updated_at` as 'last_updated_at'",
			'car_usage_table' => "`car_usage_table`.`car_usage_id` as 'car_usage_id', IF(    CHAR_LENGTH(`car_table1`.`car_number`) || CHAR_LENGTH(`car_table1`.`car_model`), CONCAT_WS('',   `car_table1`.`car_number`, '::', `car_table1`.`car_model`), '') as 'car_lookup', `car_usage_table`.`used_by` as 'used_by', if(`car_usage_table`.`datetime_from`,date_format(`car_usage_table`.`datetime_from`,'%d/%m/%Y %H:%i'),'') as 'datetime_from', if(`car_usage_table`.`datetime_to`,date_format(`car_usage_table`.`datetime_to`,'%d/%m/%Y %H:%i'),'') as 'datetime_to', `car_usage_table`.`total_distance_run` as 'total_distance_run', `car_usage_table`.`purpose` as 'purpose', `car_usage_table`.`created_by` as 'created_by', `car_usage_table`.`created_at` as 'created_at', `car_usage_table`.`last_updated_by` as 'last_updated_by', `car_usage_table`.`last_updated_at` as 'last_updated_at'",
			'cycle_table' => "`cycle_table`.`id` as 'id', `cycle_table`.`registration_number` as 'registration_number', `cycle_table`.`cycle_model` as 'cycle_model', `cycle_table`.`cycle_color` as 'cycle_color', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'responsible_contact_person', `cycle_table`.`contact_number_of_person` as 'contact_number_of_person', `cycle_table`.`purpose` as 'purpose', `cycle_table`.`created_by` as 'created_by', `cycle_table`.`created_at` as 'created_at', `cycle_table`.`last_updated_by` as 'last_updated_by', `cycle_table`.`last_updated_at` as 'last_updated_at'",
			'cycle_usage_table' => "`cycle_usage_table`.`id` as 'id', IF(    CHAR_LENGTH(`cycle_table1`.`registration_number`) || CHAR_LENGTH(`cycle_table1`.`cycle_model`), CONCAT_WS('',   `cycle_table1`.`registration_number`, '::', `cycle_table1`.`cycle_model`), '') as 'cycle_lookup', `cycle_usage_table`.`used_by` as 'used_by', if(`cycle_usage_table`.`datetime_from`,date_format(`cycle_usage_table`.`datetime_from`,'%d/%m/%Y %H:%i'),'') as 'datetime_from', if(`cycle_usage_table`.`datetime_to`,date_format(`cycle_usage_table`.`datetime_to`,'%d/%m/%Y %H:%i'),'') as 'datetime_to', `cycle_usage_table`.`total_distance_run` as 'total_distance_run', `cycle_usage_table`.`created_by` as 'created_by', `cycle_usage_table`.`created_at` as 'created_at', `cycle_usage_table`.`last_updated_by` as 'last_updated_by', `cycle_usage_table`.`last_updated_at` as 'last_updated_at'",
			'gym_table' => "`gym_table`.`id` as 'id', `gym_table`.`username` as 'username', `gym_table`.`in` as 'in', `gym_table`.`out` as 'out', if(`gym_table`.`date`,date_format(`gym_table`.`date`,'%d/%m/%Y'),'') as 'date', `gym_table`.`created_by` as 'created_by', `gym_table`.`created_at` as 'created_at', `gym_table`.`last_updated_by` as 'last_updated_by', `gym_table`.`last_updated_at` as 'last_updated_at'",
			'coffee_table' => "`coffee_table`.`id` as 'id', `coffee_table`.`username` as 'username', `coffee_table`.`cup_type` as 'cup_type', `coffee_table`.`time` as 'time', if(`coffee_table`.`date`,date_format(`coffee_table`.`date`,'%d/%m/%Y'),'') as 'date', `coffee_table`.`created_by` as 'created_by', `coffee_table`.`created_at` as 'created_at', `coffee_table`.`last_updated_by` as 'last_updated_by', `coffee_table`.`last_updated_at` as 'last_updated_at'",
			'event_table' => "`event_table`.`event_id` as 'event_id', `event_table`.`event_name` as 'event_name', `event_table`.`participants` as 'participants', `event_table`.`venue` as 'venue', if(`event_table`.`event_from_date`,date_format(`event_table`.`event_from_date`,'%d/%m/%Y'),'') as 'event_from_date', if(`event_table`.`event_to_date`,date_format(`event_table`.`event_to_date`,'%d/%m/%Y'),'') as 'event_to_date', `event_table`.`event_str` as 'event_str', `event_table`.`created_by` as 'created_by', `event_table`.`created_at` as 'created_at', `event_table`.`last_updated_by` as 'last_updated_by', `event_table`.`last_updated_at` as 'last_updated_at'",
			'outcomes_expected_table' => "`outcomes_expected_table`.`outcomes_expected_id` as 'outcomes_expected_id', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', `outcomes_expected_table`.`target_audience` as 'target_audience', `outcomes_expected_table`.`expected_outcomes` as 'expected_outcomes', `outcomes_expected_table`.`outcomes_expected_str` as 'outcomes_expected_str', `outcomes_expected_table`.`created_by` as 'created_by', `outcomes_expected_table`.`created_at` as 'created_at', `outcomes_expected_table`.`last_updated_by` as 'last_updated_by', `outcomes_expected_table`.`last_updated_at` as 'last_updated_at'",
			'event_decision_table' => "`event_decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`outcomes_expected_table1`.`outcomes_expected_str`), CONCAT_WS('',   `outcomes_expected_table1`.`outcomes_expected_str`), '') as 'outcomes_expected_lookup', `event_decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`event_decision_table`.`action_taken_with_date`,date_format(`event_decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `event_decision_table`.`decision_status` as 'decision_status', if(`event_decision_table`.`decision_status_update_date`,date_format(`event_decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `event_decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `event_decision_table`.`decision_str` as 'decision_str', `event_decision_table`.`created_by` as 'created_by', `event_decision_table`.`created_at` as 'created_at', `event_decision_table`.`last_updated_by` as 'last_updated_by', `event_decision_table`.`last_updated_at` as 'last_updated_at'",
			'meetings_table' => "`meetings_table`.`meetings_id` as 'meetings_id', IF(    CHAR_LENGTH(`visiting_card_table1`.`visiting_card_str`), CONCAT_WS('',   `visiting_card_table1`.`visiting_card_str`), '') as 'visiting_card_lookup', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', `meetings_table`.`meeting_title` as 'meeting_title', `meetings_table`.`participants` as 'participants', `meetings_table`.`venue` as 'venue', if(`meetings_table`.`meeting_from_date`,date_format(`meetings_table`.`meeting_from_date`,'%d/%m/%Y'),'') as 'meeting_from_date', if(`meetings_table`.`meeting_to_date`,date_format(`meetings_table`.`meeting_to_date`,'%d/%m/%Y'),'') as 'meeting_to_date', `meetings_table`.`meeting_str` as 'meeting_str', `meetings_table`.`created_by` as 'created_by', `meetings_table`.`created_at` as 'created_at', `meetings_table`.`last_updated_by` as 'last_updated_by', `meetings_table`.`last_updated_at` as 'last_updated_at'",
			'agenda_table' => "`agenda_table`.`agenda_id` as 'agenda_id', IF(    CHAR_LENGTH(`meetings_table1`.`meeting_str`), CONCAT_WS('',   `meetings_table1`.`meeting_str`), '') as 'meeting_lookup', `agenda_table`.`agenda_description` as 'agenda_description', `agenda_table`.`agenda_str` as 'agenda_str', `agenda_table`.`created_by` as 'created_by', `agenda_table`.`created_at` as 'created_at', `agenda_table`.`last_updated_by` as 'last_updated_by', `agenda_table`.`last_updated_at` as 'last_updated_at'",
			'decision_table' => "`decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`agenda_table1`.`agenda_str`), CONCAT_WS('',   `agenda_table1`.`agenda_str`), '') as 'agenda_lookup', `decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`decision_table`.`action_taken_with_date`,date_format(`decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `decision_table`.`decision_status` as 'decision_status', if(`decision_table`.`decision_status_update_date`,date_format(`decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `decision_table`.`decision_str` as 'decision_str', `decision_table`.`created_by` as 'created_by', `decision_table`.`created_at` as 'created_at', `decision_table`.`last_updated_by` as 'last_updated_by', `decision_table`.`last_updated_at` as 'last_updated_at'",
			'participants_table' => "`participants_table`.`participants_id` as 'participants_id', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', IF(    CHAR_LENGTH(`meetings_table1`.`meeting_str`), CONCAT_WS('',   `meetings_table1`.`meeting_str`), '') as 'meeting_lookup', `participants_table`.`name` as 'name', `participants_table`.`designation` as 'designation', `participants_table`.`participant_type` as 'participant_type', `participants_table`.`accepted_status` as 'accepted_status', if(`participants_table`.`status_date`,date_format(`participants_table`.`status_date`,'%d/%m/%Y'),'') as 'status_date', `participants_table`.`created_by` as 'created_by', `participants_table`.`created_at` as 'created_at', `participants_table`.`last_updated_by` as 'last_updated_by', `participants_table`.`last_updated_at` as 'last_updated_at'",
			'action_actor' => "`action_actor`.`actor_ID` as 'actor_ID', `action_actor`.`action_str` as 'action_str', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'actor', `action_actor`.`action_status` as 'action_status', `action_actor`.`created_by` as 'created_by', `action_actor`.`created_at` as 'created_at', `action_actor`.`last_updated_by` as 'last_updated_by', `action_actor`.`last_updated_at` as 'last_updated_at'",
			'visiting_card_table' => "`visiting_card_table`.`visiting_card_id` as 'visiting_card_id', `visiting_card_table`.`name` as 'name', `visiting_card_table`.`recommended_by` as 'recommended_by', `visiting_card_table`.`designation` as 'designation', `visiting_card_table`.`company_name` as 'company_name', `visiting_card_table`.`mobile_no` as 'mobile_no', `visiting_card_table`.`email` as 'email', `visiting_card_table`.`company_website_addr` as 'company_website_addr', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'given_by', `visiting_card_table`.`suggested_way_forward` as 'suggested_way_forward', `visiting_card_table`.`front_img` as 'front_img', `visiting_card_table`.`back_img` as 'back_img', `visiting_card_table`.`visiting_card_str` as 'visiting_card_str', `visiting_card_table`.`created_by` as 'created_by', `visiting_card_table`.`created_at` as 'created_at', `visiting_card_table`.`last_updated_by` as 'last_updated_by', `visiting_card_table`.`last_updated_at` as 'last_updated_at'",
			'mou_details_table' => "`mou_details_table`.`id` as 'id', `mou_details_table`.`type` as 'type', `mou_details_table`.`company_name` as 'company_name', `mou_details_table`.`objective_of_mou` as 'objective_of_mou', `mou_details_table`.`agreement_period` as 'agreement_period', if(`mou_details_table`.`date_of_agreement`,date_format(`mou_details_table`.`date_of_agreement`,'%d/%m/%Y'),'') as 'date_of_agreement', if(`mou_details_table`.`date_of_expiry`,date_format(`mou_details_table`.`date_of_expiry`,'%d/%m/%Y'),'') as 'date_of_expiry', `mou_details_table`.`status` as 'status', `mou_details_table`.`point_of_contact` as 'point_of_contact', `mou_details_table`.`contact_number` as 'contact_number', `mou_details_table`.`contact_email_id` as 'contact_email_id', `mou_details_table`.`website_link` as 'website_link', `mou_details_table`.`country` as 'country', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'assigned_mou_to', `mou_details_table`.`upload_mou` as 'upload_mou', `mou_details_table`.`created_at` as 'created_at', `mou_details_table`.`created_by` as 'created_by', `mou_details_table`.`last_updated_by` as 'last_updated_by', `mou_details_table`.`last_updated_at` as 'last_updated_at'",
			'mou_company_area_details_table' => "`mou_company_area_details_table`.`id` as 'id', IF(    CHAR_LENGTH(`mou_details_table1`.`company_name`), CONCAT_WS('',   `mou_details_table1`.`company_name`), '') as 'name_of_the_company', `mou_company_area_details_table`.`area` as 'area', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'assigned_mou_to', `mou_company_area_details_table`.`remarks` as 'remarks', `mou_company_area_details_table`.`created_by` as 'created_by', `mou_company_area_details_table`.`created_at` as 'created_at', `mou_company_area_details_table`.`last_updated_by` as 'last_updated_by', `mou_company_area_details_table`.`last_updated_at` as 'last_updated_at'",
			'goal_setting_table' => "`goal_setting_table`.`goal_id` as 'goal_id', `goal_setting_table`.`goal_status` as 'goal_status', `goal_setting_table`.`goal_description` as 'goal_description', `goal_setting_table`.`goal_duration` as 'goal_duration', if(`goal_setting_table`.`goal_set_date`,date_format(`goal_setting_table`.`goal_set_date`,'%d/%m/%Y'),'') as 'goal_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `goal_setting_table`.`goal_setting_str` as 'goal_setting_str', `goal_setting_table`.`created_by` as 'created_by', `goal_setting_table`.`created_at` as 'created_at', `goal_setting_table`.`last_updated_by` as 'last_updated_by', `goal_setting_table`.`last_updated_at` as 'last_updated_at'",
			'goal_progress_table' => "`goal_progress_table`.`id` as 'id', IF(    CHAR_LENGTH(`goal_setting_table1`.`goal_description`) || CHAR_LENGTH(`goal_setting_table1`.`goal_duration`), CONCAT_WS('',   `goal_setting_table1`.`goal_description`, '::', `goal_setting_table1`.`goal_duration`), '') as 'goal_lookup', `goal_progress_table`.`goal_progress` as 'goal_progress', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'remarks_by', `goal_progress_table`.`remarks` as 'remarks', `goal_progress_table`.`created_by` as 'created_by', `goal_progress_table`.`created_at` as 'created_at', `goal_progress_table`.`last_updated_by` as 'last_updated_by', `goal_progress_table`.`last_updated_at` as 'last_updated_at'",
			'task_setting_table' => "`task_setting_table`.`task_id` as 'task_id', `task_setting_table`.`task_status` as 'task_status', `task_setting_table`.`task_description` as 'task_description', `task_setting_table`.`task_duration` as 'task_duration', if(`task_setting_table`.`task_set_date`,date_format(`task_setting_table`.`task_set_date`,'%d/%m/%Y'),'') as 'task_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `task_setting_table`.`task_setting_str` as 'task_setting_str', `task_setting_table`.`created_by` as 'created_by', `task_setting_table`.`created_at` as 'created_at', `task_setting_table`.`last_updated_by` as 'last_updated_by', `task_setting_table`.`last_updated_at` as 'last_updated_at'",
			'subtask_setting_table' => "`subtask_setting_table`.`subtask_id` as 'subtask_id', IF(    CHAR_LENGTH(`task_setting_table1`.`task_description`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `task_setting_table1`.`task_description`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'task_lookup', `subtask_setting_table`.`subtask_status` as 'subtask_status', `subtask_setting_table`.`subtask_description` as 'subtask_description', `subtask_setting_table`.`subtask_duration` as 'subtask_duration', if(`subtask_setting_table`.`subtask_set_date`,date_format(`subtask_setting_table`.`subtask_set_date`,'%d/%m/%Y'),'') as 'subtask_set_date', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table3`.`memberID`) || CHAR_LENGTH(`user_table3`.`name`), CONCAT_WS('',   `user_table3`.`memberID`, '::', `user_table3`.`name`), '') as 'assigned_to', `subtask_setting_table`.`subtask_setting_str` as 'subtask_setting_str', `subtask_setting_table`.`created_by` as 'created_by', `subtask_setting_table`.`created_at` as 'created_at', `subtask_setting_table`.`last_updated_by` as 'last_updated_by', `subtask_setting_table`.`last_updated_at` as 'last_updated_at'",
			'internship_fellowship_details_app' => "`internship_fellowship_details_app`.`id` as 'id', `internship_fellowship_details_app`.`standard` as 'standard', `internship_fellowship_details_app`.`iittnif_id` as 'iittnif_id', `internship_fellowship_details_app`.`name_of_the_candidate` as 'name_of_the_candidate', `internship_fellowship_details_app`.`type_of_internship_fellowship` as 'type_of_internship_fellowship', `internship_fellowship_details_app`.`year` as 'year', `internship_fellowship_details_app`.`project_title` as 'project_title', `internship_fellowship_details_app`.`gender` as 'gender', `internship_fellowship_details_app`.`department` as 'department', `internship_fellowship_details_app`.`institute_id_number` as 'institute_id_number', `internship_fellowship_details_app`.`institute` as 'institute', `internship_fellowship_details_app`.`latitude` as 'latitude', `internship_fellowship_details_app`.`longitude` as 'longitude', `internship_fellowship_details_app`.`start_date` as 'start_date', `internship_fellowship_details_app`.`end_date` as 'end_date', `internship_fellowship_details_app`.`status` as 'status', `internship_fellowship_details_app`.`cotegory` as 'cotegory', `internship_fellowship_details_app`.`report_link` as 'report_link', `internship_fellowship_details_app`.`outcomes` as 'outcomes', `internship_fellowship_details_app`.`created_by` as 'created_by', `internship_fellowship_details_app`.`created_at` as 'created_at', `internship_fellowship_details_app`.`last_updated_by` as 'last_updated_by', `internship_fellowship_details_app`.`last_updated_at` as 'last_updated_at'",
			'star_pnt' => "`star_pnt`.`id` as 'id', IF(    CHAR_LENGTH(`internship_fellowship_details_app1`.`iittnif_id`), CONCAT_WS('',   `internship_fellowship_details_app1`.`iittnif_id`), '') as 'iittnif_id', `star_pnt`.`name_of_the_candidate` as 'name_of_the_candidate', `star_pnt`.`institute` as 'institute', `star_pnt`.`workspace` as 'workspace', `star_pnt`.`year_and_department` as 'year_and_department', `star_pnt`.`project_title` as 'project_title', `star_pnt`.`created_by` as 'created_by', `star_pnt`.`created_at` as 'created_at', `star_pnt`.`last_updated_by` as 'last_updated_by', `star_pnt`.`last_updated_at` as 'last_updated_at'",
			'hrd_sdp_events_table' => "`hrd_sdp_events_table`.`id` as 'id', `hrd_sdp_events_table`.`year` as 'year', `hrd_sdp_events_table`.`program_name` as 'program_name', `hrd_sdp_events_table`.`area_of_workshop` as 'area_of_workshop', `hrd_sdp_events_table`.`host_name` as 'host_name', `hrd_sdp_events_table`.`location` as 'location', if(`hrd_sdp_events_table`.`start_date`,date_format(`hrd_sdp_events_table`.`start_date`,'%d/%m/%Y'),'') as 'start_date', if(`hrd_sdp_events_table`.`end_date`,date_format(`hrd_sdp_events_table`.`end_date`,'%d/%m/%Y'),'') as 'end_date', `hrd_sdp_events_table`.`number_of_participants` as 'number_of_participants', `hrd_sdp_events_table`.`more_details` as 'more_details', `hrd_sdp_events_table`.`created_by` as 'created_by', `hrd_sdp_events_table`.`created_at` as 'created_at', `hrd_sdp_events_table`.`last_updated_by` as 'last_updated_by', `hrd_sdp_events_table`.`last_updated_at` as 'last_updated_at'",
			'training_program_on_geospatial_tchnologies_table' => "`training_program_on_geospatial_tchnologies_table`.`id` as 'id', `training_program_on_geospatial_tchnologies_table`.`certificate_number` as 'certificate_number', if(`training_program_on_geospatial_tchnologies_table`.`datetime`,date_format(`training_program_on_geospatial_tchnologies_table`.`datetime`,'%d/%m/%Y'),'') as 'datetime', `training_program_on_geospatial_tchnologies_table`.`salutation` as 'salutation', `training_program_on_geospatial_tchnologies_table`.`name` as 'name', `training_program_on_geospatial_tchnologies_table`.`email_id` as 'email_id', `training_program_on_geospatial_tchnologies_table`.`secondary_email_id` as 'secondary_email_id', `training_program_on_geospatial_tchnologies_table`.`mobile_number` as 'mobile_number', `training_program_on_geospatial_tchnologies_table`.`whatsapp_number` as 'whatsapp_number', `training_program_on_geospatial_tchnologies_table`.`gender` as 'gender', `training_program_on_geospatial_tchnologies_table`.`social_media_link` as 'social_media_link', `training_program_on_geospatial_tchnologies_table`.`education_qualification` as 'education_qualification', `training_program_on_geospatial_tchnologies_table`.`profession` as 'profession', `training_program_on_geospatial_tchnologies_table`.`school_name` as 'school_name', `training_program_on_geospatial_tchnologies_table`.`parents_name` as 'parents_name', `training_program_on_geospatial_tchnologies_table`.`parents_contact_number` as 'parents_contact_number', `training_program_on_geospatial_tchnologies_table`.`parents_email_id` as 'parents_email_id', `training_program_on_geospatial_tchnologies_table`.`residential_address` as 'residential_address', `training_program_on_geospatial_tchnologies_table`.`parents_designation` as 'parents_designation', `training_program_on_geospatial_tchnologies_table`.`parents_school_name` as 'parents_school_name', `training_program_on_geospatial_tchnologies_table`.`teaching_subject` as 'teaching_subject', `training_program_on_geospatial_tchnologies_table`.`address_line_2` as 'address_line_2', `training_program_on_geospatial_tchnologies_table`.`city` as 'city', `training_program_on_geospatial_tchnologies_table`.`state_region_province` as 'state_region_province', `training_program_on_geospatial_tchnologies_table`.`zip_code` as 'zip_code', `training_program_on_geospatial_tchnologies_table`.`country` as 'country', `training_program_on_geospatial_tchnologies_table`.`how_did_you_know` as 'how_did_you_know', `training_program_on_geospatial_tchnologies_table`.`attended_training_school` as 'attended_training_school', if(`training_program_on_geospatial_tchnologies_table`.`attended_training_date`,date_format(`training_program_on_geospatial_tchnologies_table`.`attended_training_date`,'%d/%m/%Y'),'') as 'attended_training_date', `training_program_on_geospatial_tchnologies_table`.`created_by` as 'created_by', `training_program_on_geospatial_tchnologies_table`.`created_at` as 'created_at', `training_program_on_geospatial_tchnologies_table`.`last_updated_by` as 'last_updated_by', `training_program_on_geospatial_tchnologies_table`.`last_updated_at` as 'last_updated_at'",
			'space_day_school_details_app' => "`space_day_school_details_app`.`id` as 'id', `space_day_school_details_app`.`school_name` as 'school_name', `space_day_school_details_app`.`profile_type` as 'profile_type', `space_day_school_details_app`.`name_of_student_teacher` as 'name_of_student_teacher', `space_day_school_details_app`.`gender` as 'gender', `space_day_school_details_app`.`class_subject` as 'class_subject', `space_day_school_details_app`.`contact_number` as 'contact_number', `space_day_school_details_app`.`created_by` as 'created_by', `space_day_school_details_app`.`created_at` as 'created_at', `space_day_school_details_app`.`last_updated_by` as 'last_updated_by', `space_day_school_details_app`.`last_updated_at` as 'last_updated_at'",
			'space_day_college_student_table' => "`space_day_college_student_table`.`id` as 'id', `space_day_college_student_table`.`name_of_student` as 'name_of_student', `space_day_college_student_table`.`registration_number` as 'registration_number', `space_day_college_student_table`.`degree_department` as 'degree_department', `space_day_college_student_table`.`gender` as 'gender', `space_day_college_student_table`.`home_address` as 'home_address', `space_day_college_student_table`.`email_id` as 'email_id', `space_day_college_student_table`.`contact_number` as 'contact_number', `space_day_college_student_table`.`interest` as 'interest', `space_day_college_student_table`.`college_name` as 'college_name', `space_day_college_student_table`.`created_by` as 'created_by', `space_day_college_student_table`.`created_at` as 'created_at', `space_day_college_student_table`.`last_updated_by` as 'last_updated_by', `space_day_college_student_table`.`last_updated_at` as 'last_updated_at'",
			'school_list' => "`school_list`.`id` as 'id', `school_list`.`district_name` as 'district_name', `school_list`.`school_code` as 'school_code', `school_list`.`school_name` as 'school_name', `school_list`.`pincode` as 'pincode', `school_list`.`school_type` as 'school_type', `school_list`.`school_phone_number` as 'school_phone_number', `school_list`.`created_by` as 'created_by', `school_list`.`created_at` as 'created_at', `school_list`.`last_updated_by` as 'last_updated_by', `school_list`.`last_updated_at` as 'last_updated_at'",
			'sdp_participants_college_details_table' => "`sdp_participants_college_details_table`.`id` as 'id', `sdp_participants_college_details_table`.`participants_type` as 'participants_type', `sdp_participants_college_details_table`.`school_college_name` as 'school_college_name', `sdp_participants_college_details_table`.`location` as 'location', `sdp_participants_college_details_table`.`latitude` as 'latitude', `sdp_participants_college_details_table`.`longitude` as 'longitude', `sdp_participants_college_details_table`.`number_of_participants` as 'number_of_participants', if(`sdp_participants_college_details_table`.`start_date`,date_format(`sdp_participants_college_details_table`.`start_date`,'%d/%m/%Y'),'') as 'start_date', if(`sdp_participants_college_details_table`.`end_date`,date_format(`sdp_participants_college_details_table`.`end_date`,'%d/%m/%Y'),'') as 'end_date', `sdp_participants_college_details_table`.`state` as 'state', `sdp_participants_college_details_table`.`created_by` as 'created_by', `sdp_participants_college_details_table`.`created_at` as 'created_at', `sdp_participants_college_details_table`.`last_updated_by` as 'last_updated_by', `sdp_participants_college_details_table`.`last_updated_at` as 'last_updated_at'",
			'asset_table' => "`asset_table`.`id` as 'id', if(`asset_table`.`Date`,date_format(`asset_table`.`Date`,'%d/%m/%Y'),'') as 'Date', `asset_table`.`ClassificationofAssest` as 'ClassificationofAssest', `asset_table`.`SubCategory` as 'SubCategory', `asset_table`.`AssetSerialNo` as 'AssetSerialNo', `asset_table`.`QRBarCode` as 'QRBarCode', `asset_table`.`AssetNo` as 'AssetNo', `asset_table`.`PONO` as 'PONO', if(`asset_table`.`PODATE`,date_format(`asset_table`.`PODATE`,'%d/%m/%Y'),'') as 'PODATE', `asset_table`.`particulars_of_supplier_name_address` as 'particulars_of_supplier_name_address', `asset_table`.`ItemDescription` as 'ItemDescription', `asset_table`.`BillNo` as 'BillNo', if(`asset_table`.`BillDate`,date_format(`asset_table`.`BillDate`,'%d/%m/%Y'),'') as 'BillDate', `asset_table`.`QUANTITY` as 'QUANTITY', `asset_table`.`CostoftheAssetinINR` as 'CostoftheAssetinINR', `asset_table`.`TotalInvoiceValueinINR` as 'TotalInvoiceValueinINR', `asset_table`.`CustodyDepartment` as 'CustodyDepartment', `asset_table`.`custodian` as 'custodian', `asset_table`.`CustodianSignature` as 'CustodianSignature', `asset_table`.`remarks` as 'remarks', `asset_table`.`created_by` as 'created_by', `asset_table`.`created_at` as 'created_at', `asset_table`.`last_updated_by` as 'last_updated_by', `asset_table`.`last_updated_at` as 'last_updated_at'",
			'asset_allotment_table' => "`asset_allotment_table`.`id` as 'id', IF(    CHAR_LENGTH(`asset_table1`.`ClassificationofAssest`) || CHAR_LENGTH(`asset_table1`.`ItemDescription`), CONCAT_WS('',   `asset_table1`.`ClassificationofAssest`, '::', `asset_table1`.`ItemDescription`), '') as 'asset_details', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `asset_allotment_table`.`department` as 'department', if(`asset_allotment_table`.`date`,date_format(`asset_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `asset_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `asset_allotment_table`.`status` as 'status', if(`asset_allotment_table`.`returned_date`,date_format(`asset_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `asset_allotment_table`.`created_by` as 'created_by', `asset_allotment_table`.`created_at` as 'created_at', `asset_allotment_table`.`last_updated_by` as 'last_updated_by', `asset_allotment_table`.`last_updated_at` as 'last_updated_at'",
			'it_inventory_app' => "`it_inventory_app`.`it_inventory_id` as 'it_inventory_id', if(`it_inventory_app`.`date`,date_format(`it_inventory_app`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_app`.`description` as 'description', `it_inventory_app`.`classification_of_asset` as 'classification_of_asset', `it_inventory_app`.`sub_category` as 'sub_category', `it_inventory_app`.`qty` as 'qty', `it_inventory_app`.`asset_serial_number` as 'asset_serial_number', `it_inventory_app`.`qr_and_bar_code` as 'qr_and_bar_code', `it_inventory_app`.`custody_department` as 'custody_department', `it_inventory_app`.`custodian` as 'custodian', `it_inventory_app`.`custodian_signature` as 'custodian_signature', `it_inventory_app`.`no_of_years_useful_life_of_assets` as 'no_of_years_useful_life_of_assets', if(`it_inventory_app`.`date_of_useful_life_of_assets_ends`,date_format(`it_inventory_app`.`date_of_useful_life_of_assets_ends`,'%d/%m/%Y'),'') as 'date_of_useful_life_of_assets_ends', `it_inventory_app`.`remarks` as 'remarks', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'sactioned_by', `it_inventory_app`.`it_inventory_str` as 'it_inventory_str', `it_inventory_app`.`created_by` as 'created_by', `it_inventory_app`.`created_at` as 'created_at', `it_inventory_app`.`last_updated_by` as 'last_updated_by', `it_inventory_app`.`last_updated_at` as 'last_updated_at'",
			'it_inventory_billing_details' => "`it_inventory_billing_details`.`it_inventory_biling_details_id` as 'it_inventory_biling_details_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`, '::'), '') as 'it_inventory_lookup', `it_inventory_billing_details`.`po_no` as 'po_no', if(`it_inventory_billing_details`.`po_date`,date_format(`it_inventory_billing_details`.`po_date`,'%d/%m/%Y'),'') as 'po_date', `it_inventory_billing_details`.`particulars_of_supplier` as 'particulars_of_supplier', `it_inventory_billing_details`.`item_description` as 'item_description', `it_inventory_billing_details`.`bill_no` as 'bill_no', if(`it_inventory_billing_details`.`bill_date`,date_format(`it_inventory_billing_details`.`bill_date`,'%d/%m/%Y'),'') as 'bill_date', `it_inventory_billing_details`.`quantity` as 'quantity', `it_inventory_billing_details`.`total_invoice_value` as 'total_invoice_value', `it_inventory_billing_details`.`cost_of_the_asset` as 'cost_of_the_asset', `it_inventory_billing_details`.`image` as 'image', `it_inventory_billing_details`.`created_by` as 'created_by', `it_inventory_billing_details`.`created_at` as 'created_at', `it_inventory_billing_details`.`last_updated_by` as 'last_updated_by', `it_inventory_billing_details`.`last_updated_at` as 'last_updated_at'",
			'it_inventory_allotment_table' => "`it_inventory_allotment_table`.`it_inventory_allotment_id` as 'it_inventory_allotment_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`), '') as 'it_inventory_lookup', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `it_inventory_allotment_table`.`department` as 'department', if(`it_inventory_allotment_table`.`date`,date_format(`it_inventory_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `it_inventory_allotment_table`.`status` as 'status', if(`it_inventory_allotment_table`.`returned_date`,date_format(`it_inventory_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `it_inventory_allotment_table`.`created_by` as 'created_by', `it_inventory_allotment_table`.`created_at` as 'created_at', `it_inventory_allotment_table`.`last_updated_by` as 'last_updated_by', `it_inventory_allotment_table`.`last_updated_at` as 'last_updated_at'",
			'computer_details_table' => "`computer_details_table`.`id` as 'id', `computer_details_table`.`pc_number` as 'pc_number', `computer_details_table`.`pc_hostname` as 'pc_hostname', `computer_details_table`.`pc_mac_address` as 'pc_mac_address', `computer_details_table`.`room_number` as 'room_number', `computer_details_table`.`desk_number` as 'desk_number', `computer_details_table`.`maintained_by` as 'maintained_by', `computer_details_table`.`assigned_to_user` as 'assigned_to_user', `computer_details_table`.`remote_access` as 'remote_access', `computer_details_table`.`created_by` as 'created_by', `computer_details_table`.`created_at` as 'created_at', `computer_details_table`.`last_updated_by` as 'last_updated_by', `computer_details_table`.`last_updated_at` as 'last_updated_at'",
			'computer_usage_table' => "`computer_usage_table`.`id` as 'id', IF(    CHAR_LENGTH(`computer_details_table1`.`pc_number`) || CHAR_LENGTH(`computer_details_table1`.`pc_hostname`), CONCAT_WS('',   `computer_details_table1`.`pc_number`, '::', `computer_details_table1`.`pc_hostname`), '') as 'pc_id', `computer_usage_table`.`name_of_user` as 'name_of_user', `computer_usage_table`.`role` as 'role', if(`computer_usage_table`.`from_date`,date_format(`computer_usage_table`.`from_date`,'%d/%m/%Y %H:%i'),'') as 'from_date', if(`computer_usage_table`.`to_date`,date_format(`computer_usage_table`.`to_date`,'%d/%m/%Y %H:%i'),'') as 'to_date', `computer_usage_table`.`purpose` as 'purpose', `computer_usage_table`.`email_d` as 'email_d', `computer_usage_table`.`mobile_number` as 'mobile_number', `computer_usage_table`.`created_by` as 'created_by', `computer_usage_table`.`created_at` as 'created_at', `computer_usage_table`.`last_updated_by` as 'last_updated_by', `computer_usage_table`.`last_updated_at` as 'last_updated_at'",
			'employees_personal_data_table' => "`employees_personal_data_table`.`id` as 'id', `employees_personal_data_table`.`name` as 'name', `employees_personal_data_table`.`employee_type` as 'employee_type', `employees_personal_data_table`.`emp_id` as 'emp_id', if(`employees_personal_data_table`.`date_of_birth`,date_format(`employees_personal_data_table`.`date_of_birth`,'%d/%m/%Y'),'') as 'date_of_birth', `employees_personal_data_table`.`blood_group` as 'blood_group', `employees_personal_data_table`.`email` as 'email', `employees_personal_data_table`.`phone_number` as 'phone_number', `employees_personal_data_table`.`department` as 'department', if(`employees_personal_data_table`.`date_of_joining`,date_format(`employees_personal_data_table`.`date_of_joining`,'%d/%m/%Y'),'') as 'date_of_joining', if(`employees_personal_data_table`.`date_of_exit`,date_format(`employees_personal_data_table`.`date_of_exit`,'%d/%m/%Y'),'') as 'date_of_exit', `employees_personal_data_table`.`active_status` as 'active_status', `employees_personal_data_table`.`profile_photo` as 'profile_photo', `employees_personal_data_table`.`signature` as 'signature', `employees_personal_data_table`.`created_by` as 'created_by', `employees_personal_data_table`.`created_at` as 'created_at', `employees_personal_data_table`.`last_updated_by` as 'last_updated_by', `employees_personal_data_table`.`last_updated_at` as 'last_updated_at', `employees_personal_data_table`.`employee_str` as 'employee_str'",
			'employees_designation_table' => "`employees_designation_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_personal_data_table1`.`name`) || CHAR_LENGTH(`employees_personal_data_table1`.`emp_id`), CONCAT_WS('',   `employees_personal_data_table1`.`name`, '::', `employees_personal_data_table1`.`emp_id`), '') as 'employee_lookup', `employees_designation_table`.`designation` as 'designation', if(`employees_designation_table`.`date_of_appointment_to_designation`,date_format(`employees_designation_table`.`date_of_appointment_to_designation`,'%d/%m/%Y'),'') as 'date_of_appointment_to_designation', `employees_designation_table`.`active_status` as 'active_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_officer', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_designation_table`.`created_by` as 'created_by', `employees_designation_table`.`created_at` as 'created_at', `employees_designation_table`.`last_updated_by` as 'last_updated_by', `employees_designation_table`.`last_updated_at` as 'last_updated_at', `employees_designation_table`.`employees_designation_str` as 'employees_designation_str'",
			'employees_appraisal_table' => "`employees_appraisal_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_designation_table1`.`employees_designation_str`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `employees_designation_table1`.`employees_designation_str`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'employee_designation_lookup', `employees_appraisal_table`.`current_review_period` as 'current_review_period', `employees_appraisal_table`.`roles` as 'roles', `employees_appraisal_table`.`self_explanation` as 'self_explanation', `employees_appraisal_table`.`upload_file_1` as 'upload_file_1', `employees_appraisal_table`.`upload_file_2` as 'upload_file_2', `employees_appraisal_table`.`upload_file_3` as 'upload_file_3', `employees_appraisal_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_table`.`overall_rating` as 'overall_rating', `employees_appraisal_table`.`reporting_appraisal_status` as 'reporting_appraisal_status', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_appraisal_table`.`reviewing_appraisal_status` as 'reviewing_appraisal_status', `employees_appraisal_table`.`created_by` as 'created_by', `employees_appraisal_table`.`created_at` as 'created_at', `employees_appraisal_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_table`.`last_updated_at` as 'last_updated_at'",
			'employees_appraisal_feedback_table' => "`employees_appraisal_feedback_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_appraisal_table1`.`roles`) || CHAR_LENGTH(`employees_appraisal_table1`.`self_explanation`), CONCAT_WS('',   `employees_appraisal_table1`.`roles`, '::', `employees_appraisal_table1`.`self_explanation`), '') as 'employees_appraisal_lookup', `employees_appraisal_feedback_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_feedback_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_feedback_table`.`overall_rating` as 'overall_rating', `employees_appraisal_feedback_table`.`appraisal_feedback_status` as 'appraisal_feedback_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reviewing_officer', `employees_appraisal_feedback_table`.`created_by` as 'created_by', `employees_appraisal_feedback_table`.`created_at` as 'created_at', `employees_appraisal_feedback_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_feedback_table`.`last_updated_at` as 'last_updated_at'",
			'beyond_workingHours_table' => "`beyond_workingHours_table`.`id` as 'id', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `beyond_workingHours_table`.`reson_for_overtime` as 'reson_for_overtime', if(`beyond_workingHours_table`.`start_datetime`,date_format(`beyond_workingHours_table`.`start_datetime`,'%d/%m/%Y %H:%i'),'') as 'start_datetime', if(`beyond_workingHours_table`.`end_datetime`,date_format(`beyond_workingHours_table`.`end_datetime`,'%d/%m/%Y %H:%i'),'') as 'end_datetime', `beyond_workingHours_table`.`number_of_hours` as 'number_of_hours', `beyond_workingHours_table`.`approval_status` as 'approval_status', `beyond_workingHours_table`.`approval_remarks` as 'approval_remarks', `beyond_workingHours_table`.`approved_by` as 'approved_by', `beyond_workingHours_table`.`created_by` as 'created_by', `beyond_workingHours_table`.`created_at` as 'created_at', `beyond_workingHours_table`.`last_updated_by` as 'last_updated_by', `beyond_workingHours_table`.`last_updated_at` as 'last_updated_at'",
			'attendence_details_table' => "`attendence_details_table`.`id` as 'id', `attendence_details_table`.`enrollment_no` as 'enrollment_no', `attendence_details_table`.`name` as 'name', `attendence_details_table`.`mode` as 'mode', if(`attendence_details_table`.`date`,date_format(`attendence_details_table`.`date`,'%d/%m/%Y'),'') as 'date', `attendence_details_table`.`in_time` as 'in_time', `attendence_details_table`.`out_time` as 'out_time', `attendence_details_table`.`working_hours` as 'working_hours', `attendence_details_table`.`remarks` as 'remarks', `attendence_details_table`.`created_by` as 'created_by', `attendence_details_table`.`created_at` as 'created_at', `attendence_details_table`.`last_updated_by` as 'last_updated_by', `attendence_details_table`.`last_updated_at` as 'last_updated_at'",
			'leave_table' => "`leave_table`.`leave_id` as 'leave_id', `leave_table`.`leave_type` as 'leave_type', `leave_table`.`purpose_of_leave` as 'purpose_of_leave', if(`leave_table`.`from_date`,date_format(`leave_table`.`from_date`,'%d/%m/%Y %H:%i'),'') as 'from_date', if(`leave_table`.`to_date`,date_format(`leave_table`.`to_date`,'%d/%m/%Y %H:%i'),'') as 'to_date', `leave_table`.`created_by` as 'created_by', `leave_table`.`created_at` as 'created_at', `leave_table`.`last_updated_by` as 'last_updated_by', `leave_table`.`last_updated_at` as 'last_updated_at'",
			'work_from_home_table' => "`work_from_home_table`.`work_from_home_id` as 'work_from_home_id', `work_from_home_table`.`work_from_home_purpose` as 'work_from_home_purpose', if(`work_from_home_table`.`from_date`,date_format(`work_from_home_table`.`from_date`,'%d/%m/%Y'),'') as 'from_date', if(`work_from_home_table`.`to_date`,date_format(`work_from_home_table`.`to_date`,'%d/%m/%Y'),'') as 'to_date', IF(    CHAR_LENGTH(`user_table1`.`user_id`), CONCAT_WS('',   `user_table1`.`user_id`), '') as 'approved_by', `work_from_home_table`.`created_by` as 'created_by', `work_from_home_table`.`created_at` as 'created_at', `work_from_home_table`.`last_updated_by` as 'last_updated_by', `work_from_home_table`.`last_updated_at` as 'last_updated_at'",
			'navavishkar_stay_table' => "`navavishkar_stay_table`.`id` as 'id', `navavishkar_stay_table`.`full_name` as 'full_name', `navavishkar_stay_table`.`emp_id` as 'emp_id', `navavishkar_stay_table`.`department` as 'department', `navavishkar_stay_table`.`designation` as 'designation', `navavishkar_stay_table`.`contact_email` as 'contact_email', `navavishkar_stay_table`.`contact_number` as 'contact_number', `navavishkar_stay_table`.`room_number` as 'room_number', if(`navavishkar_stay_table`.`check_in_date`,date_format(`navavishkar_stay_table`.`check_in_date`,'%d/%m/%Y'),'') as 'check_in_date', if(`navavishkar_stay_table`.`checkout_date`,date_format(`navavishkar_stay_table`.`checkout_date`,'%d/%m/%Y'),'') as 'checkout_date', `navavishkar_stay_table`.`reason_for_stay` as 'reason_for_stay', `navavishkar_stay_table`.`approval_status` as 'approval_status', `navavishkar_stay_table`.`approval_remarks` as 'approval_remarks', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'approved_by', `navavishkar_stay_table`.`created_by` as 'created_by', `navavishkar_stay_table`.`created_at` as 'created_at', `navavishkar_stay_table`.`last_updated_by` as 'last_updated_by', `navavishkar_stay_table`.`last_updated_at` as 'last_updated_at'",
			'navavishkar_stay_payment_table' => "`navavishkar_stay_payment_table`.`id` as 'id', IF(    CHAR_LENGTH(`navavishkar_stay_table1`.`full_name`) || CHAR_LENGTH(`navavishkar_stay_table1`.`emp_id`), CONCAT_WS('',   `navavishkar_stay_table1`.`full_name`, '::', `navavishkar_stay_table1`.`emp_id`), '') as 'navavishakr_stay_details', `navavishkar_stay_payment_table`.`payment_status` as 'payment_status', `navavishkar_stay_payment_table`.`amount` as 'amount', `navavishkar_stay_payment_table`.`additional_facilities_provided` as 'additional_facilities_provided', `navavishkar_stay_payment_table`.`payment_img` as 'payment_img', `navavishkar_stay_payment_table`.`remarks` as 'remarks', `navavishkar_stay_payment_table`.`created_by` as 'created_by', `navavishkar_stay_payment_table`.`created_at` as 'created_at', `navavishkar_stay_payment_table`.`last_updated_by` as 'last_updated_by', `navavishkar_stay_payment_table`.`last_updated_at` as 'last_updated_at'",
			'email_id_allocation_table' => "`email_id_allocation_table`.`email_id_allocation_id` as 'email_id_allocation_id', `email_id_allocation_table`.`name_of_person` as 'name_of_person', `email_id_allocation_table`.`allocated_email_id` as 'allocated_email_id', `email_id_allocation_table`.`alternative_email_id` as 'alternative_email_id', if(`email_id_allocation_table`.`date_of_allocation`,date_format(`email_id_allocation_table`.`date_of_allocation`,'%d/%m/%Y'),'') as 'date_of_allocation', `email_id_allocation_table`.`status` as 'status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_manager', `email_id_allocation_table`.`remarks` as 'remarks', `email_id_allocation_table`.`created_by` as 'created_by', `email_id_allocation_table`.`created_at` as 'created_at', `email_id_allocation_table`.`last_updated_by` as 'last_updated_by', `email_id_allocation_table`.`last_updated_at` as 'last_updated_at'",
			'all_startup_data_table' => "`all_startup_data_table`.`id` as 'id', `all_startup_data_table`.`company_id` as 'company_id', `all_startup_data_table`.`name_of_the_company` as 'name_of_the_company', `all_startup_data_table`.`business_sector` as 'business_sector', `all_startup_data_table`.`name_of_the_person` as 'name_of_the_person', `all_startup_data_table`.`mobile_number` as 'mobile_number', `all_startup_data_table`.`email_id` as 'email_id', `all_startup_data_table`.`mode_of_incubation` as 'mode_of_incubation', if(`all_startup_data_table`.`date_of_incubation`,date_format(`all_startup_data_table`.`date_of_incubation`,'%d/%m/%Y'),'') as 'date_of_incubation', `all_startup_data_table`.`shortlisted_for_fund` as 'shortlisted_for_fund', `all_startup_data_table`.`website_link` as 'website_link', `all_startup_data_table`.`company_logo` as 'company_logo', `all_startup_data_table`.`created_by` as 'created_by', `all_startup_data_table`.`created_at` as 'created_at', `all_startup_data_table`.`last_updated_by` as 'last_updated_by', `all_startup_data_table`.`last_updated_at` as 'last_updated_at'",
			'shortlisted_startups_for_fund_table' => "`shortlisted_startups_for_fund_table`.`id` as 'id', IF(    CHAR_LENGTH(`all_startup_data_table1`.`company_id`) || CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`company_id`, `all_startup_data_table1`.`name_of_the_company`), '') as 'startup', `shortlisted_startups_for_fund_table`.`scheme` as 'scheme', `shortlisted_startups_for_fund_table`.`recommended_fund` as 'recommended_fund', `shortlisted_startups_for_fund_table`.`name_of_founder` as 'name_of_founder', `shortlisted_startups_for_fund_table`.`email_of_founder` as 'email_of_founder', `shortlisted_startups_for_fund_table`.`phone_number_of_founder` as 'phone_number_of_founder', `shortlisted_startups_for_fund_table`.`due_diligence_start` as 'due_diligence_start', `shortlisted_startups_for_fund_table`.`terms_agreed` as 'terms_agreed', `shortlisted_startups_for_fund_table`.`grant_amount` as 'grant_amount', `shortlisted_startups_for_fund_table`.`debt_amount` as 'debt_amount', `shortlisted_startups_for_fund_table`.`ocd_or_ccd_amount` as 'ocd_or_ccd_amount', `shortlisted_startups_for_fund_table`.`equity_amount` as 'equity_amount', `shortlisted_startups_for_fund_table`.`interest_rate` as 'interest_rate', `shortlisted_startups_for_fund_table`.`period` as 'period', `shortlisted_startups_for_fund_table`.`conversion_formula` as 'conversion_formula', `shortlisted_startups_for_fund_table`.`equity_diluted` as 'equity_diluted', `shortlisted_startups_for_fund_table`.`comments` as 'comments', `shortlisted_startups_for_fund_table`.`remarks_1` as 'remarks_1', `shortlisted_startups_for_fund_table`.`remarks_2` as 'remarks_2', `shortlisted_startups_for_fund_table`.`created_by` as 'created_by', `shortlisted_startups_for_fund_table`.`created_at` as 'created_at', `shortlisted_startups_for_fund_table`.`last_updated_by` as 'last_updated_by', `shortlisted_startups_for_fund_table`.`last_updated_at` as 'last_updated_at'",
			'shortlisted_startups_dd_and_agreement_table' => "`shortlisted_startups_dd_and_agreement_table`.`id` as 'id', IF(    CHAR_LENGTH(`all_startup_data_table1`.`company_id`) || CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`company_id`, '::', `all_startup_data_table1`.`name_of_the_company`), '') as 'startup', `shortlisted_startups_dd_and_agreement_table`.`documents` as 'documents', `shortlisted_startups_dd_and_agreement_table`.`status_1` as 'status_1', `shortlisted_startups_dd_and_agreement_table`.`comment_1` as 'comment_1', `shortlisted_startups_dd_and_agreement_table`.`link_to_ddr` as 'link_to_ddr', `shortlisted_startups_dd_and_agreement_table`.`status_2` as 'status_2', `shortlisted_startups_dd_and_agreement_table`.`comment_2` as 'comment_2', `shortlisted_startups_dd_and_agreement_table`.`link_to_agreement` as 'link_to_agreement', `shortlisted_startups_dd_and_agreement_table`.`created_by` as 'created_by', `shortlisted_startups_dd_and_agreement_table`.`created_at` as 'created_at', `shortlisted_startups_dd_and_agreement_table`.`last_updated_by` as 'last_updated_by', `shortlisted_startups_dd_and_agreement_table`.`last_updated_at` as 'last_updated_at'",
			'vikas_startup_applications_table' => "`vikas_startup_applications_table`.`id` as 'id', `vikas_startup_applications_table`.`startup_name` as 'startup_name', `vikas_startup_applications_table`.`email` as 'email', if(`vikas_startup_applications_table`.`incorporation_date`,date_format(`vikas_startup_applications_table`.`incorporation_date`,'%d/%m/%Y'),'') as 'incorporation_date', `vikas_startup_applications_table`.`website_url` as 'website_url', `vikas_startup_applications_table`.`physical_address` as 'physical_address', `vikas_startup_applications_table`.`primary_contact_name` as 'primary_contact_name', `vikas_startup_applications_table`.`email_1` as 'email_1', `vikas_startup_applications_table`.`mobile_number` as 'mobile_number', `vikas_startup_applications_table`.`name_of_founders` as 'name_of_founders', `vikas_startup_applications_table`.`number_of_founders` as 'number_of_founders', `vikas_startup_applications_table`.`email_of_founders` as 'email_of_founders', `vikas_startup_applications_table`.`business_sector` as 'business_sector', `vikas_startup_applications_table`.`number_of_employees` as 'number_of_employees', `vikas_startup_applications_table`.`brief_description_of_service` as 'brief_description_of_service', `vikas_startup_applications_table`.`mode_of_incubation` as 'mode_of_incubation', `vikas_startup_applications_table`.`type_of_workspace_desired` as 'type_of_workspace_desired', `vikas_startup_applications_table`.`key_areas_of_support` as 'key_areas_of_support', `vikas_startup_applications_table`.`declaration_form_link` as 'declaration_form_link', `vikas_startup_applications_table`.`is_your_start_up_dpiit_registered` as 'is_your_start_up_dpiit_registered', `vikas_startup_applications_table`.`incubation_status` as 'incubation_status', if(`vikas_startup_applications_table`.`datetime`,date_format(`vikas_startup_applications_table`.`datetime`,'%d/%m/%Y %H:%i'),'') as 'datetime', `vikas_startup_applications_table`.`created_by` as 'created_by', `vikas_startup_applications_table`.`created_at` as 'created_at', `vikas_startup_applications_table`.`last_updated_by` as 'last_updated_by', `vikas_startup_applications_table`.`last_updated_at` as 'last_updated_at'",
			'programs_table' => "`programs_table`.`programs_id` as 'programs_id', `programs_table`.`title_of_the_program` as 'title_of_the_program', `programs_table`.`target_startup` as 'target_startup', `programs_table`.`created_by` as 'created_by', `programs_table`.`created_at` as 'created_at', `programs_table`.`last_updated_by` as 'last_updated_by', `programs_table`.`last_updated_at` as 'last_updated_at'",
			'evaluation_table' => "`evaluation_table`.`evaluation_id` as 'evaluation_id', `evaluation_table`.`result` as 'result', IF(    CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`name_of_the_company`), '') as 'select_startup', `evaluation_table`.`recommendation` as 'recommendation', `evaluation_table`.`marks` as 'marks', `evaluation_table`.`reason_for_not_recommending` as 'reason_for_not_recommending', `evaluation_table`.`created_by` as 'created_by', `evaluation_table`.`created_at` as 'created_at', `evaluation_table`.`last_updated_by` as 'last_updated_by', `evaluation_table`.`last_updated_at` as 'last_updated_at'",
			'problem_statement_table' => "`problem_statement_table`.`problem_statement_id` as 'problem_statement_id', IF(    CHAR_LENGTH(`programs_table1`.`title_of_the_program`), CONCAT_WS('',   `programs_table1`.`title_of_the_program`), '') as 'select_program_id', `problem_statement_table`.`program_description` as 'program_description', `problem_statement_table`.`remarks` as 'remarks', `problem_statement_table`.`created_by` as 'created_by', `problem_statement_table`.`created_at` as 'created_at', `problem_statement_table`.`last_updated_by` as 'last_updated_by', `problem_statement_table`.`last_updated_at` as 'last_updated_at'",
			'evaluators_table' => "`evaluators_table`.`evaluator_id` as 'evaluator_id', IF(    CHAR_LENGTH(`evaluation_table1`.`evaluation_id`), CONCAT_WS('',   `evaluation_table1`.`evaluation_id`), '') as 'evaluation_lookup', `evaluators_table`.`name` as 'name', `evaluators_table`.`designation` as 'designation', `evaluators_table`.`qualification` as 'qualification', `evaluators_table`.`self_description` as 'self_description', `evaluators_table`.`role` as 'role', `evaluators_table`.`created_by` as 'created_by', `evaluators_table`.`created_at` as 'created_at', `evaluators_table`.`last_updated_by` as 'last_updated_by', `evaluators_table`.`last_updated_at` as 'last_updated_at'",
			'approval_billing_table' => "`approval_billing_table`.`id` as 'id', IF(    CHAR_LENGTH(`approval_table1`.`type`) || CHAR_LENGTH(`approval_table1`.`description`), CONCAT_WS('',   `approval_table1`.`type`, '::', `approval_table1`.`description`), '') as 'approval_lookup', if(`approval_billing_table`.`date_of_purchase`,date_format(`approval_billing_table`.`date_of_purchase`,'%d/%m/%Y'),'') as 'date_of_purchase', `approval_billing_table`.`total_amount_of_bill` as 'total_amount_of_bill', `approval_billing_table`.`items_list` as 'items_list', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'paid_by', `approval_billing_table`.`attach_bill_1` as 'attach_bill_1', `approval_billing_table`.`attach_bill_2` as 'attach_bill_2', `approval_billing_table`.`attach_bill_3` as 'attach_bill_3', `approval_billing_table`.`created_by` as 'created_by', `approval_billing_table`.`created_at` as 'created_at', `approval_billing_table`.`last_updated_by` as 'last_updated_by', `approval_billing_table`.`last_updated_at` as 'last_updated_at'",
			'honorarium_claim_table' => "`honorarium_claim_table`.`id` as 'id', `honorarium_claim_table`.`name_of_advisor` as 'name_of_advisor', `honorarium_claim_table`.`email_advisor` as 'email_advisor', `honorarium_claim_table`.`department_of_tih` as 'department_of_tih', `honorarium_claim_table`.`bank_account_no` as 'bank_account_no', `honorarium_claim_table`.`ifsc_code` as 'ifsc_code', `honorarium_claim_table`.`bank_name` as 'bank_name', `honorarium_claim_table`.`pan` as 'pan', `honorarium_claim_table`.`place_of_work` as 'place_of_work', if(`honorarium_claim_table`.`date_1`,date_format(`honorarium_claim_table`.`date_1`,'%d/%m/%Y'),'') as 'date_1', `honorarium_claim_table`.`hours_1` as 'hours_1', if(`honorarium_claim_table`.`date_2`,date_format(`honorarium_claim_table`.`date_2`,'%d/%m/%Y'),'') as 'date_2', `honorarium_claim_table`.`hours_2` as 'hours_2', if(`honorarium_claim_table`.`date_3`,date_format(`honorarium_claim_table`.`date_3`,'%d/%m/%Y'),'') as 'date_3', `honorarium_claim_table`.`hours_3` as 'hours_3', if(`honorarium_claim_table`.`date_4`,date_format(`honorarium_claim_table`.`date_4`,'%d/%m/%Y'),'') as 'date_4', `honorarium_claim_table`.`hours_4` as 'hours_4', if(`honorarium_claim_table`.`date_5`,date_format(`honorarium_claim_table`.`date_5`,'%d/%m/%Y'),'') as 'date_5', `honorarium_claim_table`.`hours_5` as 'hours_5', `honorarium_claim_table`.`total_no_of_days` as 'total_no_of_days', `honorarium_claim_table`.`total_no_of_hours` as 'total_no_of_hours', `honorarium_claim_table`.`case_reference_email_subject` as 'case_reference_email_subject', `honorarium_claim_table`.`activities` as 'activities', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'coordinated_by_tih_user', if(`honorarium_claim_table`.`payment_date`,date_format(`honorarium_claim_table`.`payment_date`,'%d/%m/%Y'),'') as 'payment_date', `honorarium_claim_table`.`amount_paid` as 'amount_paid', `honorarium_claim_table`.`transaction_details` as 'transaction_details', `honorarium_claim_table`.`approval_status` as 'approval_status', `honorarium_claim_table`.`remarks_for_approval` as 'remarks_for_approval', `honorarium_claim_table`.`created_by` as 'created_by', `honorarium_claim_table`.`created_at` as 'created_at', `honorarium_claim_table`.`last_updated_by` as 'last_updated_by', `honorarium_claim_table`.`last_updated_at` as 'last_updated_at'",
			'all_bank_account_statement_table' => "`all_bank_account_statement_table`.`all_bank_account_statement_id` as 'all_bank_account_statement_id', `all_bank_account_statement_table`.`statement_type` as 'statement_type', if(`all_bank_account_statement_table`.`txn_date`,date_format(`all_bank_account_statement_table`.`txn_date`,'%d/%m/%Y'),'') as 'txn_date', if(`all_bank_account_statement_table`.`value_date`,date_format(`all_bank_account_statement_table`.`value_date`,'%d/%m/%Y'),'') as 'value_date', `all_bank_account_statement_table`.`description` as 'description', `all_bank_account_statement_table`.`ref_no_or_cheque_no` as 'ref_no_or_cheque_no', `all_bank_account_statement_table`.`branch_code` as 'branch_code', `all_bank_account_statement_table`.`debit` as 'debit', `all_bank_account_statement_table`.`credit` as 'credit', `all_bank_account_statement_table`.`balance_1` as 'balance_1', `all_bank_account_statement_table`.`balance_2` as 'balance_2', `all_bank_account_statement_table`.`remarks_1` as 'remarks_1', `all_bank_account_statement_table`.`remarks_2` as 'remarks_2', `all_bank_account_statement_table`.`category` as 'category', `all_bank_account_statement_table`.`created_by` as 'created_by', `all_bank_account_statement_table`.`created_at` as 'created_at', `all_bank_account_statement_table`.`last_updated_by` as 'last_updated_by', `all_bank_account_statement_table`.`last_updated_at` as 'last_updated_at'",
			'payment_track_details_table' => "`payment_track_details_table`.`payment_track_details_id` as 'payment_track_details_id', `payment_track_details_table`.`pfms_num` as 'pfms_num', if(`payment_track_details_table`.`date`,date_format(`payment_track_details_table`.`date`,'%d/%m/%Y'),'') as 'date', `payment_track_details_table`.`description` as 'description', `payment_track_details_table`.`amount` as 'amount', `payment_track_details_table`.`requested_by` as 'requested_by', `payment_track_details_table`.`paid_to` as 'paid_to', `payment_track_details_table`.`paid_status` as 'paid_status', if(`payment_track_details_table`.`payment_date`,date_format(`payment_track_details_table`.`payment_date`,'%d/%m/%Y'),'') as 'payment_date', `payment_track_details_table`.`remarks` as 'remarks', `payment_track_details_table`.`upload_scanned_file_1` as 'upload_scanned_file_1', `payment_track_details_table`.`upload_scanned_file_2` as 'upload_scanned_file_2', `payment_track_details_table`.`created_by` as 'created_by', `payment_track_details_table`.`created_at` as 'created_at', `payment_track_details_table`.`last_updated_by` as 'last_updated_by', `payment_track_details_table`.`last_updated_at` as 'last_updated_at'",
			'travel_table' => "`travel_table`.`id` as 'id', `travel_table`.`first_name` as 'first_name', `travel_table`.`last_name` as 'last_name', `travel_table`.`age` as 'age', `travel_table`.`gender` as 'gender', `travel_table`.`mobile_number` as 'mobile_number', `travel_table`.`travel_type` as 'travel_type', `travel_table`.`from_place` as 'from_place', `travel_table`.`to_place` as 'to_place', if(`travel_table`.`date_from`,date_format(`travel_table`.`date_from`,'%d/%m/%Y'),'') as 'date_from', if(`travel_table`.`date_to`,date_format(`travel_table`.`date_to`,'%d/%m/%Y'),'') as 'date_to', `travel_table`.`travel_description` as 'travel_description', `travel_table`.`approval_status` as 'approval_status', `travel_table`.`approval_remarks` as 'approval_remarks', `travel_table`.`created_by` as 'created_by', `travel_table`.`approved_by` as 'approved_by', `travel_table`.`created_at` as 'created_at', `travel_table`.`approved_at` as 'approved_at'",
			'travel_stay_table' => "`travel_stay_table`.`id` as 'id', `travel_stay_table`.`first_name` as 'first_name', `travel_stay_table`.`last_name` as 'last_name', `travel_stay_table`.`age` as 'age', `travel_stay_table`.`gender` as 'gender', `travel_stay_table`.`mobile_number` as 'mobile_number', `travel_stay_table`.`hotel_name` as 'hotel_name', `travel_stay_table`.`hotel_address` as 'hotel_address', if(`travel_stay_table`.`checkin_date`,date_format(`travel_stay_table`.`checkin_date`,'%d/%m/%Y'),'') as 'checkin_date', if(`travel_stay_table`.`checkout_date`,date_format(`travel_stay_table`.`checkout_date`,'%d/%m/%Y'),'') as 'checkout_date', `travel_stay_table`.`room_preferance` as 'room_preferance', `travel_stay_table`.`remarks` as 'remarks', `travel_stay_table`.`approval_status` as 'approval_status', `travel_stay_table`.`approval_remarks` as 'approval_remarks', `travel_stay_table`.`approved_by` as 'approved_by', `travel_stay_table`.`created_by` as 'created_by', `travel_stay_table`.`created_at` as 'created_at', `travel_stay_table`.`last_updated_at` as 'last_updated_at'",
			'travel_local_commute_table' => "`travel_local_commute_table`.`id` as 'id', `travel_local_commute_table`.`first_name` as 'first_name', `travel_local_commute_table`.`last_name` as 'last_name', `travel_local_commute_table`.`age` as 'age', `travel_local_commute_table`.`gender` as 'gender', `travel_local_commute_table`.`mobile_number` as 'mobile_number', `travel_local_commute_table`.`local_commute_type` as 'local_commute_type', `travel_local_commute_table`.`from_place` as 'from_place', `travel_local_commute_table`.`to_place` as 'to_place', `travel_local_commute_table`.`description` as 'description', `travel_local_commute_table`.`approval_status` as 'approval_status', `travel_local_commute_table`.`approval_remarks` as 'approval_remarks', `travel_local_commute_table`.`created_by` as 'created_by', `travel_local_commute_table`.`approved_by` as 'approved_by', `travel_local_commute_table`.`created_at` as 'created_at', `travel_local_commute_table`.`approved_at` as 'approved_at'",
			'r_and_d_progress' => "`r_and_d_progress`.`id` as 'id', `r_and_d_progress`.`username` as 'username', if(`r_and_d_progress`.`date`,date_format(`r_and_d_progress`.`date`,'%d/%m/%Y'),'') as 'date', `r_and_d_progress`.`labs` as 'labs', `r_and_d_progress`.`today_progress` as 'today_progress', `r_and_d_progress`.`tomorrow_plan` as 'tomorrow_plan', `r_and_d_progress`.`ceo_remarks` as 'ceo_remarks', `r_and_d_progress`.`pd_remarks` as 'pd_remarks', `r_and_d_progress`.`created_by` as 'created_by', `r_and_d_progress`.`created_at` as 'created_at', `r_and_d_progress`.`last_updated_by` as 'last_updated_by', `r_and_d_progress`.`last_updated_at` as 'last_updated_at'",
			'panel_decision_table_tdp' => "`panel_decision_table_tdp`.`panel_decision_id` as 'panel_decision_id', `panel_decision_table_tdp`.`edition` as 'edition', `panel_decision_table_tdp`.`project_id` as 'project_id', if(`panel_decision_table_tdp`.`date_of_presentation`,date_format(`panel_decision_table_tdp`.`date_of_presentation`,'%d/%m/%Y'),'') as 'date_of_presentation', `panel_decision_table_tdp`.`project_title` as 'project_title', `panel_decision_table_tdp`.`name_of_pi` as 'name_of_pi', `panel_decision_table_tdp`.`mobile_number` as 'mobile_number', `panel_decision_table_tdp`.`institute` as 'institute', `panel_decision_table_tdp`.`budget_specified` as 'budget_specified', `panel_decision_table_tdp`.`final_budget_to_be_allocated` as 'final_budget_to_be_allocated', `panel_decision_table_tdp`.`experts_comments` as 'experts_comments', `panel_decision_table_tdp`.`trl` as 'trl', `panel_decision_table_tdp`.`proposal_link` as 'proposal_link', `panel_decision_table_tdp`.`updated_proposal_link` as 'updated_proposal_link', `panel_decision_table_tdp`.`where_budget_need` as 'where_budget_need', `panel_decision_table_tdp`.`final_decision` as 'final_decision', `panel_decision_table_tdp`.`notification_mail` as 'notification_mail', `panel_decision_table_tdp`.`call_done` as 'call_done', `panel_decision_table_tdp`.`created_by` as 'created_by', `panel_decision_table_tdp`.`created_at` as 'created_at', `panel_decision_table_tdp`.`last_updated_by` as 'last_updated_by', `panel_decision_table_tdp`.`last_updated_at` as 'last_updated_at'",
			'selected_proposals_final_tdp' => "`selected_proposals_final_tdp`.`selected_proposals_id` as 'selected_proposals_id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `selected_proposals_final_tdp`.`breakthrough` as 'breakthrough', `selected_proposals_final_tdp`.`project_title` as 'project_title', `selected_proposals_final_tdp`.`short_name` as 'short_name', `selected_proposals_final_tdp`.`duration_in_months` as 'duration_in_months', `selected_proposals_final_tdp`.`name_of_pi` as 'name_of_pi', `selected_proposals_final_tdp`.`mobile_number` as 'mobile_number', `selected_proposals_final_tdp`.`institute` as 'institute', `selected_proposals_final_tdp`.`stage_1` as 'stage_1', `selected_proposals_final_tdp`.`stage_2` as 'stage_2', `selected_proposals_final_tdp`.`stage_3` as 'stage_3', `selected_proposals_final_tdp`.`stage_4` as 'stage_4', `selected_proposals_final_tdp`.`total_budget_specified` as 'total_budget_specified', `selected_proposals_final_tdp`.`one_slide_ppt_link` as 'one_slide_ppt_link', `selected_proposals_final_tdp`.`proposal_link` as 'proposal_link', `selected_proposals_final_tdp`.`existing_trl` as 'existing_trl', `selected_proposals_final_tdp`.`expected_trl` as 'expected_trl', `selected_proposals_final_tdp`.`created_by` as 'created_by', `selected_proposals_final_tdp`.`created_at` as 'created_at', `selected_proposals_final_tdp`.`last_updated_by` as 'last_updated_by', `selected_proposals_final_tdp`.`last_updated_at` as 'last_updated_at'",
			'stage_wise_budget_table_tdp' => "`stage_wise_budget_table_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `stage_wise_budget_table_tdp`.`project_title` as 'project_title', `stage_wise_budget_table_tdp`.`name_of_pi` as 'name_of_pi', `stage_wise_budget_table_tdp`.`mobile_number` as 'mobile_number', `stage_wise_budget_table_tdp`.`institute` as 'institute', `stage_wise_budget_table_tdp`.`duration_in_months` as 'duration_in_months', `stage_wise_budget_table_tdp`.`total_budget_specified` as 'total_budget_specified', `stage_wise_budget_table_tdp`.`first_phase` as 'first_phase', `stage_wise_budget_table_tdp`.`second_phase` as 'second_phase', `stage_wise_budget_table_tdp`.`third_phase` as 'third_phase', `stage_wise_budget_table_tdp`.`fourth_phase` as 'fourth_phase', `stage_wise_budget_table_tdp`.`total` as 'total', `stage_wise_budget_table_tdp`.`final_budget_to_be_allocated` as 'final_budget_to_be_allocated', `stage_wise_budget_table_tdp`.`proposal_link` as 'proposal_link', `stage_wise_budget_table_tdp`.`created_by` as 'created_by', `stage_wise_budget_table_tdp`.`created_at` as 'created_at', `stage_wise_budget_table_tdp`.`last_updated_by` as 'last_updated_by', `stage_wise_budget_table_tdp`.`last_updated_at` as 'last_updated_at'",
			'first_level_shortlisted_proposals_tdp' => "`first_level_shortlisted_proposals_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `first_level_shortlisted_proposals_tdp`.`name` as 'name', `first_level_shortlisted_proposals_tdp`.`institution` as 'institution', `first_level_shortlisted_proposals_tdp`.`domain_of_interest` as 'domain_of_interest', `first_level_shortlisted_proposals_tdp`.`proposal_link` as 'proposal_link', `first_level_shortlisted_proposals_tdp`.`first_level_comment` as 'first_level_comment', `first_level_shortlisted_proposals_tdp`.`created_by` as 'created_by', `first_level_shortlisted_proposals_tdp`.`created_at` as 'created_at', `first_level_shortlisted_proposals_tdp`.`last_updated_by` as 'last_updated_by', `first_level_shortlisted_proposals_tdp`.`last_updated_at` as 'last_updated_at'",
			'budget_table_tdp' => "`budget_table_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `budget_table_tdp`.`title_of_the_project` as 'title_of_the_project', `budget_table_tdp`.`name_of_pi` as 'name_of_pi', `budget_table_tdp`.`institute` as 'institute', if(`budget_table_tdp`.`date_of_presentation`,date_format(`budget_table_tdp`.`date_of_presentation`,'%d/%m/%Y'),'') as 'date_of_presentation', `budget_table_tdp`.`manpower` as 'manpower', `budget_table_tdp`.`travel` as 'travel', `budget_table_tdp`.`infrastructure` as 'infrastructure', `budget_table_tdp`.`consumables` as 'consumables', `budget_table_tdp`.`contigency` as 'contigency', `budget_table_tdp`.`overhead` as 'overhead', `budget_table_tdp`.`any_other` as 'any_other', `budget_table_tdp`.`total_budget` as 'total_budget', `budget_table_tdp`.`created_by` as 'created_by', `budget_table_tdp`.`created_at` as 'created_at', `budget_table_tdp`.`last_updated_by` as 'last_updated_by', `budget_table_tdp`.`last_updated_at` as 'last_updated_at'",
			'panel_comments_tdp' => "`panel_comments_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `panel_comments_tdp`.`project_title` as 'project_title', `panel_comments_tdp`.`name_of_pi` as 'name_of_pi', `panel_comments_tdp`.`institute` as 'institute', `panel_comments_tdp`.`final_budget` as 'final_budget', `panel_comments_tdp`.`comments_from_yvn_sir` as 'comments_from_yvn_sir', `panel_comments_tdp`.`comments_from_ramakrishna_sir` as 'comments_from_ramakrishna_sir', `panel_comments_tdp`.`comments_from_bharat_lohani_sir` as 'comments_from_bharat_lohani_sir', `panel_comments_tdp`.`remarks_1` as 'remarks_1', `panel_comments_tdp`.`remarks_2` as 'remarks_2', `panel_comments_tdp`.`finale_decision` as 'finale_decision', `panel_comments_tdp`.`created_by` as 'created_by', `panel_comments_tdp`.`created_at` as 'created_at', `panel_comments_tdp`.`last_updated_by` as 'last_updated_by', `panel_comments_tdp`.`last_updated_at` as 'last_updated_at'",
			'selected_tdp' => "`selected_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `selected_tdp`.`project_title` as 'project_title', `selected_tdp`.`name_of_pi` as 'name_of_pi', `selected_tdp`.`institute` as 'institute', `selected_tdp`.`budget` as 'budget', `selected_tdp`.`decision` as 'decision', `selected_tdp`.`created_by` as 'created_by', `selected_tdp`.`created_at` as 'created_at', `selected_tdp`.`last_updated_by` as 'last_updated_by', `selected_tdp`.`last_updated_at` as 'last_updated_at'",
			'address_tdp' => "`address_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `address_tdp`.`project_title` as 'project_title', `address_tdp`.`short_name` as 'short_name', `address_tdp`.`pincode` as 'pincode', `address_tdp`.`lattitude` as 'lattitude', `address_tdp`.`longitude` as 'longitude', `address_tdp`.`created_by` as 'created_by', `address_tdp`.`created_at` as 'created_at', `address_tdp`.`last_updated_by` as 'last_updated_by', `address_tdp`.`last_updated_at` as 'last_updated_at'",
			'summary_table_tdp' => "`summary_table_tdp`.`id` as 'id', `summary_table_tdp`.`project_number` as 'project_number', `summary_table_tdp`.`project_title` as 'project_title', `summary_table_tdp`.`year` as 'year', `summary_table_tdp`.`pi` as 'pi', `summary_table_tdp`.`institute` as 'institute', `summary_table_tdp`.`duration_in_months` as 'duration_in_months', `summary_table_tdp`.`overall_budget` as 'overall_budget', `summary_table_tdp`.`number_of_products` as 'number_of_products', `summary_table_tdp`.`trl_status` as 'trl_status', if(`summary_table_tdp`.`sactioned_date`,date_format(`summary_table_tdp`.`sactioned_date`,'%d/%m/%Y'),'') as 'sactioned_date', `summary_table_tdp`.`ongoing_month_of_project` as 'ongoing_month_of_project', `summary_table_tdp`.`last_monthly_report` as 'last_monthly_report', `summary_table_tdp`.`no_of_ug` as 'no_of_ug', `summary_table_tdp`.`no_of_pg` as 'no_of_pg', `summary_table_tdp`.`no_of_phd` as 'no_of_phd', `summary_table_tdp`.`no_of_postdoc` as 'no_of_postdoc', if(`summary_table_tdp`.`first_milestone_amount_and_date`,date_format(`summary_table_tdp`.`first_milestone_amount_and_date`,'%d/%m/%Y'),'') as 'first_milestone_amount_and_date', if(`summary_table_tdp`.`stage_I_completion`,date_format(`summary_table_tdp`.`stage_I_completion`,'%d/%m/%Y'),'') as 'stage_I_completion', if(`summary_table_tdp`.`second_milestone_amount_and_date`,date_format(`summary_table_tdp`.`second_milestone_amount_and_date`,'%d/%m/%Y'),'') as 'second_milestone_amount_and_date', if(`summary_table_tdp`.`stage_2_completion`,date_format(`summary_table_tdp`.`stage_2_completion`,'%d/%m/%Y'),'') as 'stage_2_completion', if(`summary_table_tdp`.`third_milestone_amount_and_date`,date_format(`summary_table_tdp`.`third_milestone_amount_and_date`,'%d/%m/%Y'),'') as 'third_milestone_amount_and_date', if(`summary_table_tdp`.`stage_3_completion`,date_format(`summary_table_tdp`.`stage_3_completion`,'%d/%m/%Y'),'') as 'stage_3_completion', if(`summary_table_tdp`.`fourth_milestone_amount_and_date`,date_format(`summary_table_tdp`.`fourth_milestone_amount_and_date`,'%d/%m/%Y'),'') as 'fourth_milestone_amount_and_date', if(`summary_table_tdp`.`stage_4_completion`,date_format(`summary_table_tdp`.`stage_4_completion`,'%d/%m/%Y'),'') as 'stage_4_completion', `summary_table_tdp`.`created_by` as 'created_by', `summary_table_tdp`.`created_at` as 'created_at', `summary_table_tdp`.`last_updated_by` as 'last_updated_by', `summary_table_tdp`.`last_updated_at` as 'last_updated_at'",
			'project_details_tdp' => "`project_details_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`summary_table_tdp1`.`project_number`), CONCAT_WS('',   `summary_table_tdp1`.`project_number`), '') as 'project_number', `project_details_tdp`.`stage_1` as 'stage_1', `project_details_tdp`.`stage_2` as 'stage_2', `project_details_tdp`.`stage_3` as 'stage_3', `project_details_tdp`.`stage_4` as 'stage_4', `project_details_tdp`.`total` as 'total', `project_details_tdp`.`details` as 'details', `project_details_tdp`.`created_by` as 'created_by', `project_details_tdp`.`created_at` as 'created_at', `project_details_tdp`.`last_updated_by` as 'last_updated_by', `project_details_tdp`.`last_updated_at` as 'last_updated_at'",
		];

		if(isset($sql_fields[$table_name])) return $sql_fields[$table_name];

		return false;
	}

	#########################################################

	function get_sql_from($table_name, $skip_permissions = false, $skip_joins = false, $lower_permissions = false) {
		$sql_from = [
			'user_table' => "`user_table` ",
			'suggestion' => "`suggestion` ",
			'approval_table' => "`approval_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_table`.`person_responsbility` ",
			'car_table' => "`car_table` ",
			'car_usage_table' => "`car_usage_table` LEFT JOIN `car_table` as car_table1 ON `car_table1`.`id`=`car_usage_table`.`car_lookup` ",
			'cycle_table' => "`cycle_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`cycle_table`.`responsible_contact_person` ",
			'cycle_usage_table' => "`cycle_usage_table` LEFT JOIN `cycle_table` as cycle_table1 ON `cycle_table1`.`id`=`cycle_usage_table`.`cycle_lookup` ",
			'gym_table' => "`gym_table` ",
			'coffee_table' => "`coffee_table` ",
			'event_table' => "`event_table` ",
			'outcomes_expected_table' => "`outcomes_expected_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`outcomes_expected_table`.`event_lookup` ",
			'event_decision_table' => "`event_decision_table` LEFT JOIN `outcomes_expected_table` as outcomes_expected_table1 ON `outcomes_expected_table1`.`outcomes_expected_id`=`event_decision_table`.`outcomes_expected_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`event_decision_table`.`decision_actor` ",
			'meetings_table' => "`meetings_table` LEFT JOIN `visiting_card_table` as visiting_card_table1 ON `visiting_card_table1`.`visiting_card_id`=`meetings_table`.`visiting_card_lookup` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`meetings_table`.`event_lookup` ",
			'agenda_table' => "`agenda_table` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`agenda_table`.`meeting_lookup` ",
			'decision_table' => "`decision_table` LEFT JOIN `agenda_table` as agenda_table1 ON `agenda_table1`.`agenda_id`=`decision_table`.`agenda_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`decision_table`.`decision_actor` ",
			'participants_table' => "`participants_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`participants_table`.`event_lookup` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`participants_table`.`meeting_lookup` ",
			'action_actor' => "`action_actor` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`action_actor`.`actor` ",
			'visiting_card_table' => "`visiting_card_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`visiting_card_table`.`given_by` ",
			'mou_details_table' => "`mou_details_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`mou_details_table`.`assigned_mou_to` ",
			'mou_company_area_details_table' => "`mou_company_area_details_table` LEFT JOIN `mou_details_table` as mou_details_table1 ON `mou_details_table1`.`id`=`mou_company_area_details_table`.`name_of_the_company` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`mou_company_area_details_table`.`assigned_mou_to` ",
			'goal_setting_table' => "`goal_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`goal_setting_table`.`assigned_to` ",
			'goal_progress_table' => "`goal_progress_table` LEFT JOIN `goal_setting_table` as goal_setting_table1 ON `goal_setting_table1`.`goal_id`=`goal_progress_table`.`goal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_progress_table`.`remarks_by` ",
			'task_setting_table' => "`task_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`task_setting_table`.`assigned_to` ",
			'subtask_setting_table' => "`subtask_setting_table` LEFT JOIN `task_setting_table` as task_setting_table1 ON `task_setting_table1`.`task_id`=`subtask_setting_table`.`task_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table1`.`assigned_to` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`subtask_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table3 ON `user_table3`.`user_id`=`subtask_setting_table`.`assigned_to` ",
			'internship_fellowship_details_app' => "`internship_fellowship_details_app` ",
			'star_pnt' => "`star_pnt` LEFT JOIN `internship_fellowship_details_app` as internship_fellowship_details_app1 ON `internship_fellowship_details_app1`.`id`=`star_pnt`.`iittnif_id` ",
			'hrd_sdp_events_table' => "`hrd_sdp_events_table` ",
			'training_program_on_geospatial_tchnologies_table' => "`training_program_on_geospatial_tchnologies_table` ",
			'space_day_school_details_app' => "`space_day_school_details_app` ",
			'space_day_college_student_table' => "`space_day_college_student_table` ",
			'school_list' => "`school_list` ",
			'sdp_participants_college_details_table' => "`sdp_participants_college_details_table` ",
			'asset_table' => "`asset_table` ",
			'asset_allotment_table' => "`asset_allotment_table` LEFT JOIN `asset_table` as asset_table1 ON `asset_table1`.`id`=`asset_allotment_table`.`asset_details` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`asset_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`asset_allotment_table`.`alloted_by` ",
			'it_inventory_app' => "`it_inventory_app` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_app`.`sactioned_by` ",
			'it_inventory_billing_details' => "`it_inventory_billing_details` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_billing_details`.`it_inventory_lookup` ",
			'it_inventory_allotment_table' => "`it_inventory_allotment_table` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_allotment_table`.`it_inventory_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`it_inventory_allotment_table`.`alloted_by` ",
			'computer_details_table' => "`computer_details_table` ",
			'computer_usage_table' => "`computer_usage_table` LEFT JOIN `computer_details_table` as computer_details_table1 ON `computer_details_table1`.`id`=`computer_usage_table`.`pc_id` ",
			'employees_personal_data_table' => "`employees_personal_data_table` ",
			'employees_designation_table' => "`employees_designation_table` LEFT JOIN `employees_personal_data_table` as employees_personal_data_table1 ON `employees_personal_data_table1`.`id`=`employees_designation_table`.`employee_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_designation_table`.`reviewing_officer` ",
			'employees_appraisal_table' => "`employees_appraisal_table` LEFT JOIN `employees_designation_table` as employees_designation_table1 ON `employees_designation_table1`.`id`=`employees_appraisal_table`.`employee_designation_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table1`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_appraisal_table`.`reviewing_officer` ",
			'employees_appraisal_feedback_table' => "`employees_appraisal_feedback_table` LEFT JOIN `employees_appraisal_table` as employees_appraisal_table1 ON `employees_appraisal_table1`.`id`=`employees_appraisal_feedback_table`.`employees_appraisal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_appraisal_feedback_table`.`reviewing_officer` ",
			'beyond_workingHours_table' => "`beyond_workingHours_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`beyond_workingHours_table`.`select_employee` ",
			'attendence_details_table' => "`attendence_details_table` ",
			'leave_table' => "`leave_table` ",
			'work_from_home_table' => "`work_from_home_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`work_from_home_table`.`approved_by` ",
			'navavishkar_stay_table' => "`navavishkar_stay_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`navavishkar_stay_table`.`approved_by` ",
			'navavishkar_stay_payment_table' => "`navavishkar_stay_payment_table` LEFT JOIN `navavishkar_stay_table` as navavishkar_stay_table1 ON `navavishkar_stay_table1`.`id`=`navavishkar_stay_payment_table`.`navavishakr_stay_details` ",
			'email_id_allocation_table' => "`email_id_allocation_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`email_id_allocation_table`.`reporting_manager` ",
			'all_startup_data_table' => "`all_startup_data_table` ",
			'shortlisted_startups_for_fund_table' => "`shortlisted_startups_for_fund_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`shortlisted_startups_for_fund_table`.`startup` ",
			'shortlisted_startups_dd_and_agreement_table' => "`shortlisted_startups_dd_and_agreement_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`shortlisted_startups_dd_and_agreement_table`.`startup` ",
			'vikas_startup_applications_table' => "`vikas_startup_applications_table` ",
			'programs_table' => "`programs_table` ",
			'evaluation_table' => "`evaluation_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`evaluation_table`.`select_startup` ",
			'problem_statement_table' => "`problem_statement_table` LEFT JOIN `programs_table` as programs_table1 ON `programs_table1`.`programs_id`=`problem_statement_table`.`select_program_id` ",
			'evaluators_table' => "`evaluators_table` LEFT JOIN `evaluation_table` as evaluation_table1 ON `evaluation_table1`.`evaluation_id`=`evaluators_table`.`evaluation_lookup` ",
			'approval_billing_table' => "`approval_billing_table` LEFT JOIN `approval_table` as approval_table1 ON `approval_table1`.`id`=`approval_billing_table`.`approval_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_billing_table`.`paid_by` ",
			'honorarium_claim_table' => "`honorarium_claim_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`honorarium_claim_table`.`coordinated_by_tih_user` ",
			'all_bank_account_statement_table' => "`all_bank_account_statement_table` ",
			'payment_track_details_table' => "`payment_track_details_table` ",
			'travel_table' => "`travel_table` ",
			'travel_stay_table' => "`travel_stay_table` ",
			'travel_local_commute_table' => "`travel_local_commute_table` ",
			'r_and_d_progress' => "`r_and_d_progress` ",
			'panel_decision_table_tdp' => "`panel_decision_table_tdp` ",
			'selected_proposals_final_tdp' => "`selected_proposals_final_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`selected_proposals_final_tdp`.`project_id` ",
			'stage_wise_budget_table_tdp' => "`stage_wise_budget_table_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`stage_wise_budget_table_tdp`.`project_id` ",
			'first_level_shortlisted_proposals_tdp' => "`first_level_shortlisted_proposals_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`first_level_shortlisted_proposals_tdp`.`project_id` ",
			'budget_table_tdp' => "`budget_table_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`budget_table_tdp`.`project_id` ",
			'panel_comments_tdp' => "`panel_comments_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`panel_comments_tdp`.`project_id` ",
			'selected_tdp' => "`selected_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`selected_tdp`.`project_id` ",
			'address_tdp' => "`address_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`address_tdp`.`project_id` ",
			'summary_table_tdp' => "`summary_table_tdp` ",
			'project_details_tdp' => "`project_details_tdp` LEFT JOIN `summary_table_tdp` as summary_table_tdp1 ON `summary_table_tdp1`.`id`=`project_details_tdp`.`project_number` ",
		];

		$pkey = [
			'user_table' => 'user_id',
			'suggestion' => 'suggestion_id',
			'approval_table' => 'id',
			'car_table' => 'id',
			'car_usage_table' => 'car_usage_id',
			'cycle_table' => 'id',
			'cycle_usage_table' => 'id',
			'gym_table' => 'id',
			'coffee_table' => 'id',
			'event_table' => 'event_id',
			'outcomes_expected_table' => 'outcomes_expected_id',
			'event_decision_table' => 'decision_id',
			'meetings_table' => 'meetings_id',
			'agenda_table' => 'agenda_id',
			'decision_table' => 'decision_id',
			'participants_table' => 'participants_id',
			'action_actor' => 'actor_ID',
			'visiting_card_table' => 'visiting_card_id',
			'mou_details_table' => 'id',
			'mou_company_area_details_table' => 'id',
			'goal_setting_table' => 'goal_id',
			'goal_progress_table' => 'id',
			'task_setting_table' => 'task_id',
			'subtask_setting_table' => 'subtask_id',
			'internship_fellowship_details_app' => 'id',
			'star_pnt' => 'id',
			'hrd_sdp_events_table' => 'id',
			'training_program_on_geospatial_tchnologies_table' => 'id',
			'space_day_school_details_app' => 'id',
			'space_day_college_student_table' => 'id',
			'school_list' => 'id',
			'sdp_participants_college_details_table' => 'id',
			'asset_table' => 'id',
			'asset_allotment_table' => 'id',
			'it_inventory_app' => 'it_inventory_id',
			'it_inventory_billing_details' => 'it_inventory_biling_details_id',
			'it_inventory_allotment_table' => 'it_inventory_allotment_id',
			'computer_details_table' => 'id',
			'computer_usage_table' => 'id',
			'employees_personal_data_table' => 'id',
			'employees_designation_table' => 'id',
			'employees_appraisal_table' => 'id',
			'employees_appraisal_feedback_table' => 'id',
			'beyond_workingHours_table' => 'id',
			'attendence_details_table' => 'id',
			'leave_table' => 'leave_id',
			'work_from_home_table' => 'work_from_home_id',
			'navavishkar_stay_table' => 'id',
			'navavishkar_stay_payment_table' => 'id',
			'email_id_allocation_table' => 'email_id_allocation_id',
			'all_startup_data_table' => 'id',
			'shortlisted_startups_for_fund_table' => 'id',
			'shortlisted_startups_dd_and_agreement_table' => 'id',
			'vikas_startup_applications_table' => 'id',
			'programs_table' => 'programs_id',
			'evaluation_table' => 'evaluation_id',
			'problem_statement_table' => 'problem_statement_id',
			'evaluators_table' => 'evaluator_id',
			'approval_billing_table' => 'id',
			'honorarium_claim_table' => 'id',
			'all_bank_account_statement_table' => 'all_bank_account_statement_id',
			'payment_track_details_table' => 'payment_track_details_id',
			'travel_table' => 'id',
			'travel_stay_table' => 'id',
			'travel_local_commute_table' => 'id',
			'r_and_d_progress' => 'id',
			'panel_decision_table_tdp' => 'panel_decision_id',
			'selected_proposals_final_tdp' => 'selected_proposals_id',
			'stage_wise_budget_table_tdp' => 'id',
			'first_level_shortlisted_proposals_tdp' => 'id',
			'budget_table_tdp' => 'id',
			'panel_comments_tdp' => 'id',
			'selected_tdp' => 'id',
			'address_tdp' => 'id',
			'summary_table_tdp' => 'id',
			'project_details_tdp' => 'id',
		];

		if(!isset($sql_from[$table_name])) return false;

		$from = ($skip_joins ? "`{$table_name}`" : $sql_from[$table_name]);

		if($skip_permissions) return $from . ' WHERE 1=1';

		// mm: build the query based on current member's permissions
		// allowing lower permissions if $lower_permissions set to 'user' or 'group'
		$perm = getTablePermissions($table_name);
		if($perm['view'] == 1 || ($perm['view'] > 1 && $lower_permissions == 'user')) { // view owner only
			$from .= ", `membership_userrecords` WHERE `{$table_name}`.`{$pkey[$table_name]}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='{$table_name}' AND LCASE(`membership_userrecords`.`memberID`)='" . getLoggedMemberID() . "'";
		} elseif($perm['view'] == 2 || ($perm['view'] > 2 && $lower_permissions == 'group')) { // view group only
			$from .= ", `membership_userrecords` WHERE `{$table_name}`.`{$pkey[$table_name]}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='{$table_name}' AND `membership_userrecords`.`groupID`='" . getLoggedGroupID() . "'";
		} elseif($perm['view'] == 3) { // view all
			$from .= ' WHERE 1=1';
		} else { // view none
			return false;
		}

		return $from;
	}

	#########################################################

	function get_joined_record($table, $id, $skip_permissions = false) {
		$sql_fields = get_sql_fields($table);
		$sql_from = get_sql_from($table, $skip_permissions);

		if(!$sql_fields || !$sql_from) return false;

		$pk = getPKFieldName($table);
		if(!$pk) return false;

		$safe_id = makeSafe($id, false);
		$sql = "SELECT {$sql_fields} FROM {$sql_from} AND `{$table}`.`{$pk}`='{$safe_id}'";
		$eo = ['silentErrors' => true];
		$res = sql($sql, $eo);
		if($row = db_fetch_assoc($res)) return $row;

		return false;
	}

	#########################################################

	function get_defaults($table) {
		/* array of tables and their fields, with default values (or empty), excluding automatic values */
		$defaults = [
			'user_table' => [
				'user_id' => '',
				'memberID' => '',
				'name' => '',
			],
			'suggestion' => [
				'suggestion_id' => '',
				'department' => 'Event',
				'suggestion' => '',
				'attachment' => '',
				'department_remarks' => '',
				'ceo_pd_remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'approval_table' => [
				'id' => '',
				'type' => '',
				'description' => '',
				'quantity' => '',
				'full_est_value' => '',
				'name_of_vendor' => '',
				'purpose' => '',
				'requested_department' => '',
				'person_responsbility' => '',
				'mode_of_purchase' => '',
				'others_if_any' => '',
				'approval_status' => 'Under Consideration',
				'remarks_for_approval' => 'None',
				'image' => '',
				'other_file' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'car_table' => [
				'id' => '',
				'car_number' => '',
				'registration_number' => '',
				'car_model' => '',
				'car_vin' => '',
				'fuel_type' => '',
				'seating_capacity' => '',
				'car_color' => '',
				'rental_company_name' => '',
				'contact_person' => '',
				'contact_number_of_person' => '',
				'rental_rate' => '',
				'rental_start_date' => '1',
				'rental_end_date' => '',
				'purpose' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'car_usage_table' => [
				'car_usage_id' => '',
				'car_lookup' => '',
				'used_by' => '',
				'datetime_from' => '',
				'datetime_to' => '',
				'total_distance_run' => '',
				'purpose' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'cycle_table' => [
				'id' => '',
				'registration_number' => '',
				'cycle_model' => '',
				'cycle_color' => '',
				'responsible_contact_person' => '',
				'contact_number_of_person' => '',
				'purpose' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'cycle_usage_table' => [
				'id' => '',
				'cycle_lookup' => '',
				'used_by' => '',
				'datetime_from' => '',
				'datetime_to' => '',
				'total_distance_run' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'gym_table' => [
				'id' => '',
				'username' => '',
				'in' => '',
				'out' => '',
				'date' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'coffee_table' => [
				'id' => '',
				'username' => '',
				'cup_type' => 'Cup',
				'time' => '',
				'date' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'event_table' => [
				'event_id' => '',
				'event_name' => '',
				'participants' => '',
				'venue' => '',
				'event_from_date' => '',
				'event_to_date' => '',
				'event_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'outcomes_expected_table' => [
				'outcomes_expected_id' => '',
				'event_lookup' => '',
				'target_audience' => '',
				'expected_outcomes' => '',
				'outcomes_expected_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'event_decision_table' => [
				'decision_id' => '',
				'outcomes_expected_lookup' => '',
				'decision_description' => '',
				'decision_actor' => '',
				'action_taken_with_date' => '',
				'decision_status' => 'Yet to Start',
				'decision_status_update_date' => '',
				'decision_status_remarks_by_superior' => '',
				'decision_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'meetings_table' => [
				'meetings_id' => '',
				'visiting_card_lookup' => '',
				'event_lookup' => '',
				'meeting_title' => '',
				'participants' => '',
				'venue' => '',
				'meeting_from_date' => '1',
				'meeting_to_date' => '1',
				'meeting_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'agenda_table' => [
				'agenda_id' => '',
				'meeting_lookup' => '',
				'agenda_description' => '',
				'agenda_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'decision_table' => [
				'decision_id' => '',
				'agenda_lookup' => '',
				'decision_description' => '',
				'decision_actor' => '',
				'action_taken_with_date' => '',
				'decision_status' => 'Yet to Start',
				'decision_status_update_date' => '',
				'decision_status_remarks_by_superior' => '',
				'decision_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'participants_table' => [
				'participants_id' => '',
				'event_lookup' => '',
				'meeting_lookup' => '',
				'name' => '',
				'designation' => '',
				'participant_type' => '',
				'accepted_status' => '',
				'status_date' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'action_actor' => [
				'actor_ID' => '',
				'action_str' => '',
				'actor' => '',
				'action_status' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'visiting_card_table' => [
				'visiting_card_id' => '',
				'name' => '',
				'recommended_by' => '',
				'designation' => '',
				'company_name' => '',
				'mobile_no' => '',
				'email' => '',
				'company_website_addr' => '',
				'given_by' => '',
				'suggested_way_forward' => '',
				'front_img' => '',
				'back_img' => '',
				'visiting_card_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'mou_details_table' => [
				'id' => '',
				'type' => '',
				'company_name' => '',
				'objective_of_mou' => '',
				'agreement_period' => '',
				'date_of_agreement' => '',
				'date_of_expiry' => '',
				'status' => '',
				'point_of_contact' => '',
				'contact_number' => '',
				'contact_email_id' => '',
				'website_link' => '',
				'country' => '',
				'assigned_mou_to' => '',
				'upload_mou' => '',
				'created_at' => '',
				'created_by' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'mou_company_area_details_table' => [
				'id' => '',
				'name_of_the_company' => '',
				'area' => '',
				'assigned_mou_to' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'goal_setting_table' => [
				'goal_id' => '',
				'goal_status' => '',
				'goal_description' => '',
				'goal_duration' => '',
				'goal_set_date' => '1',
				'supervisor_name' => '',
				'assigned_to' => '',
				'goal_setting_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'goal_progress_table' => [
				'id' => '',
				'goal_lookup' => '',
				'goal_progress' => '',
				'remarks_by' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'task_setting_table' => [
				'task_id' => '',
				'task_status' => '',
				'task_description' => '',
				'task_duration' => '',
				'task_set_date' => '1',
				'supervisor_name' => '',
				'assigned_to' => '',
				'task_setting_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'subtask_setting_table' => [
				'subtask_id' => '',
				'task_lookup' => '',
				'subtask_status' => '',
				'subtask_description' => '',
				'subtask_duration' => '',
				'subtask_set_date' => '1',
				'supervisor_name' => '',
				'assigned_to' => '',
				'subtask_setting_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'internship_fellowship_details_app' => [
				'id' => '',
				'standard' => '',
				'iittnif_id' => '',
				'name_of_the_candidate' => '',
				'type_of_internship_fellowship' => '',
				'year' => '',
				'project_title' => '',
				'gender' => 'Male',
				'department' => '',
				'institute_id_number' => '',
				'institute' => '',
				'latitude' => '',
				'longitude' => '',
				'start_date' => '',
				'end_date' => '',
				'status' => 'Yet to Start',
				'cotegory' => '',
				'report_link' => '',
				'outcomes' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'star_pnt' => [
				'id' => '',
				'iittnif_id' => '',
				'name_of_the_candidate' => '',
				'institute' => '',
				'workspace' => '',
				'year_and_department' => '',
				'project_title' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'hrd_sdp_events_table' => [
				'id' => '',
				'year' => '',
				'program_name' => '',
				'area_of_workshop' => '',
				'host_name' => '',
				'location' => '',
				'start_date' => '1',
				'end_date' => '1',
				'number_of_participants' => '',
				'more_details' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'training_program_on_geospatial_tchnologies_table' => [
				'id' => '',
				'certificate_number' => '',
				'datetime' => '1',
				'salutation' => '',
				'name' => '',
				'email_id' => '',
				'secondary_email_id' => '',
				'mobile_number' => '',
				'whatsapp_number' => '',
				'gender' => '',
				'social_media_link' => '',
				'education_qualification' => '',
				'profession' => '',
				'school_name' => '',
				'parents_name' => '',
				'parents_contact_number' => '',
				'parents_email_id' => '',
				'residential_address' => '',
				'parents_designation' => '',
				'parents_school_name' => '',
				'teaching_subject' => '',
				'address_line_2' => '',
				'city' => '',
				'state_region_province' => '',
				'zip_code' => '',
				'country' => '',
				'how_did_you_know' => '',
				'attended_training_school' => '',
				'attended_training_date' => '1',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'space_day_school_details_app' => [
				'id' => '',
				'school_name' => '',
				'profile_type' => '',
				'name_of_student_teacher' => '',
				'gender' => '',
				'class_subject' => '',
				'contact_number' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'space_day_college_student_table' => [
				'id' => '',
				'name_of_student' => '',
				'registration_number' => '',
				'degree_department' => '',
				'gender' => '',
				'home_address' => '',
				'email_id' => '',
				'contact_number' => '',
				'interest' => '',
				'college_name' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'school_list' => [
				'id' => '',
				'district_name' => '',
				'school_code' => '',
				'school_name' => '',
				'pincode' => '',
				'school_type' => '',
				'school_phone_number' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'sdp_participants_college_details_table' => [
				'id' => '',
				'participants_type' => '',
				'school_college_name' => '',
				'location' => '',
				'latitude' => '',
				'longitude' => '',
				'number_of_participants' => '',
				'start_date' => '1',
				'end_date' => '1',
				'state' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'asset_table' => [
				'id' => '',
				'Date' => '',
				'ClassificationofAssest' => '',
				'SubCategory' => '',
				'AssetSerialNo' => '',
				'QRBarCode' => '',
				'AssetNo' => '',
				'PONO' => '',
				'PODATE' => '',
				'particulars_of_supplier_name_address' => '',
				'ItemDescription' => '',
				'BillNo' => '',
				'BillDate' => '',
				'QUANTITY' => '',
				'CostoftheAssetinINR' => '',
				'TotalInvoiceValueinINR' => '',
				'CustodyDepartment' => '',
				'custodian' => '',
				'CustodianSignature' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'asset_allotment_table' => [
				'id' => '',
				'asset_details' => '',
				'select_employee' => '',
				'department' => '',
				'date' => '1',
				'purpose' => '',
				'alloted_by' => '',
				'status' => '',
				'returned_date' => '1',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'it_inventory_app' => [
				'it_inventory_id' => '',
				'date' => '1',
				'description' => '',
				'classification_of_asset' => '',
				'sub_category' => '',
				'qty' => '',
				'asset_serial_number' => '',
				'qr_and_bar_code' => '',
				'custody_department' => '',
				'custodian' => '',
				'custodian_signature' => '',
				'no_of_years_useful_life_of_assets' => '',
				'date_of_useful_life_of_assets_ends' => '',
				'remarks' => '',
				'sactioned_by' => '',
				'it_inventory_str' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'it_inventory_billing_details' => [
				'it_inventory_biling_details_id' => '',
				'it_inventory_lookup' => '',
				'po_no' => '',
				'po_date' => '1',
				'particulars_of_supplier' => '',
				'item_description' => '',
				'bill_no' => '',
				'bill_date' => '1',
				'quantity' => '',
				'total_invoice_value' => '',
				'cost_of_the_asset' => '',
				'image' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'it_inventory_allotment_table' => [
				'it_inventory_allotment_id' => '',
				'it_inventory_lookup' => '',
				'select_employee' => '',
				'department' => '',
				'date' => '1',
				'purpose' => '',
				'alloted_by' => '',
				'status' => '',
				'returned_date' => '1',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'computer_details_table' => [
				'id' => '',
				'pc_number' => '',
				'pc_hostname' => '',
				'pc_mac_address' => '',
				'room_number' => '',
				'desk_number' => '',
				'maintained_by' => '',
				'assigned_to_user' => '',
				'remote_access' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'computer_usage_table' => [
				'id' => '',
				'pc_id' => '',
				'name_of_user' => '',
				'role' => '',
				'from_date' => '',
				'to_date' => '',
				'purpose' => '',
				'email_d' => '',
				'mobile_number' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'employees_personal_data_table' => [
				'id' => '',
				'name' => '',
				'employee_type' => '',
				'emp_id' => '',
				'date_of_birth' => '',
				'blood_group' => '',
				'email' => '',
				'phone_number' => '',
				'department' => '',
				'date_of_joining' => '',
				'date_of_exit' => '',
				'active_status' => '',
				'profile_photo' => '',
				'signature' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
				'employee_str' => '',
			],
			'employees_designation_table' => [
				'id' => '',
				'employee_lookup' => '',
				'designation' => '',
				'date_of_appointment_to_designation' => '',
				'active_status' => '',
				'reporting_officer' => '',
				'reviewing_officer' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
				'employees_designation_str' => '',
			],
			'employees_appraisal_table' => [
				'id' => '',
				'employee_designation_lookup' => '',
				'current_review_period' => '',
				'roles' => '',
				'self_explanation' => '',
				'upload_file_1' => '',
				'upload_file_2' => '',
				'upload_file_3' => '',
				'reporting_officer_feedback' => '',
				'observations_by_reporting_officer' => '',
				'overall_rating' => '',
				'reporting_appraisal_status' => 'Pending',
				'reviewing_officer' => '',
				'reviewing_appraisal_status' => 'Pending',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'employees_appraisal_feedback_table' => [
				'id' => '',
				'employees_appraisal_lookup' => '',
				'reporting_officer_feedback' => '',
				'observations_by_reporting_officer' => '',
				'overall_rating' => '',
				'appraisal_feedback_status' => 'Yet to Start',
				'reviewing_officer' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'beyond_workingHours_table' => [
				'id' => '',
				'select_employee' => '',
				'reson_for_overtime' => '',
				'start_datetime' => '',
				'end_datetime' => '',
				'number_of_hours' => '',
				'approval_status' => 'Under Consideration',
				'approval_remarks' => '',
				'approved_by' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'attendence_details_table' => [
				'id' => '',
				'enrollment_no' => '',
				'name' => '',
				'mode' => '',
				'date' => '',
				'in_time' => '',
				'out_time' => '',
				'working_hours' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'leave_table' => [
				'leave_id' => '',
				'leave_type' => '',
				'purpose_of_leave' => '',
				'from_date' => '',
				'to_date' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'work_from_home_table' => [
				'work_from_home_id' => '',
				'work_from_home_purpose' => '',
				'from_date' => '1',
				'to_date' => '1',
				'approved_by' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'navavishkar_stay_table' => [
				'id' => '',
				'full_name' => '',
				'emp_id' => '',
				'department' => '',
				'designation' => '',
				'contact_email' => '',
				'contact_number' => '',
				'room_number' => '',
				'check_in_date' => '1',
				'checkout_date' => '1',
				'reason_for_stay' => '',
				'approval_status' => 'Under Consideration',
				'approval_remarks' => '',
				'approved_by' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'navavishkar_stay_payment_table' => [
				'id' => '',
				'navavishakr_stay_details' => '',
				'payment_status' => 'Pending',
				'amount' => '',
				'additional_facilities_provided' => '',
				'payment_img' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'email_id_allocation_table' => [
				'email_id_allocation_id' => '',
				'name_of_person' => '',
				'allocated_email_id' => '',
				'alternative_email_id' => '',
				'date_of_allocation' => '',
				'status' => '',
				'reporting_manager' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'all_startup_data_table' => [
				'id' => '',
				'company_id' => '',
				'name_of_the_company' => '',
				'business_sector' => '',
				'name_of_the_person' => '',
				'mobile_number' => '',
				'email_id' => '',
				'mode_of_incubation' => '',
				'date_of_incubation' => '',
				'shortlisted_for_fund' => '',
				'website_link' => '',
				'company_logo' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'shortlisted_startups_for_fund_table' => [
				'id' => '',
				'startup' => '',
				'scheme' => '',
				'recommended_fund' => '',
				'name_of_founder' => '',
				'email_of_founder' => '',
				'phone_number_of_founder' => '',
				'due_diligence_start' => '',
				'terms_agreed' => '',
				'grant_amount' => '',
				'debt_amount' => '',
				'ocd_or_ccd_amount' => '',
				'equity_amount' => '',
				'interest_rate' => '',
				'period' => '',
				'conversion_formula' => '',
				'equity_diluted' => '',
				'comments' => '',
				'remarks_1' => '',
				'remarks_2' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'shortlisted_startups_dd_and_agreement_table' => [
				'id' => '',
				'startup' => '',
				'documents' => '',
				'status_1' => '',
				'comment_1' => '',
				'link_to_ddr' => '',
				'status_2' => '',
				'comment_2' => '',
				'link_to_agreement' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'vikas_startup_applications_table' => [
				'id' => '',
				'startup_name' => '',
				'email' => '',
				'incorporation_date' => '1',
				'website_url' => '',
				'physical_address' => '',
				'primary_contact_name' => '',
				'email_1' => '',
				'mobile_number' => '',
				'name_of_founders' => '',
				'number_of_founders' => '',
				'email_of_founders' => '',
				'business_sector' => '',
				'number_of_employees' => '',
				'brief_description_of_service' => '',
				'mode_of_incubation' => '',
				'type_of_workspace_desired' => '',
				'key_areas_of_support' => '',
				'declaration_form_link' => '',
				'is_your_start_up_dpiit_registered' => '',
				'incubation_status' => '',
				'datetime' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'programs_table' => [
				'programs_id' => '',
				'title_of_the_program' => '',
				'target_startup' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'evaluation_table' => [
				'evaluation_id' => '',
				'result' => '',
				'select_startup' => '',
				'recommendation' => '',
				'marks' => '',
				'reason_for_not_recommending' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'problem_statement_table' => [
				'problem_statement_id' => '',
				'select_program_id' => '',
				'program_description' => '',
				'remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'evaluators_table' => [
				'evaluator_id' => '',
				'evaluation_lookup' => '',
				'name' => '',
				'designation' => '',
				'qualification' => '',
				'self_description' => '',
				'role' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'approval_billing_table' => [
				'id' => '',
				'approval_lookup' => '',
				'date_of_purchase' => '',
				'total_amount_of_bill' => '',
				'items_list' => '',
				'paid_by' => '',
				'attach_bill_1' => '',
				'attach_bill_2' => '',
				'attach_bill_3' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'honorarium_claim_table' => [
				'id' => '',
				'name_of_advisor' => '',
				'email_advisor' => '',
				'department_of_tih' => '',
				'bank_account_no' => '',
				'ifsc_code' => '',
				'bank_name' => '',
				'pan' => '',
				'place_of_work' => '',
				'date_1' => '',
				'hours_1' => '',
				'date_2' => '',
				'hours_2' => '',
				'date_3' => '',
				'hours_3' => '',
				'date_4' => '',
				'hours_4' => '',
				'date_5' => '',
				'hours_5' => '',
				'total_no_of_days' => '',
				'total_no_of_hours' => '',
				'case_reference_email_subject' => '',
				'activities' => '',
				'coordinated_by_tih_user' => '',
				'payment_date' => '',
				'amount_paid' => '',
				'transaction_details' => '',
				'approval_status' => 'Under Consideration',
				'remarks_for_approval' => 'None',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'all_bank_account_statement_table' => [
				'all_bank_account_statement_id' => '',
				'statement_type' => '',
				'txn_date' => '1',
				'value_date' => '1',
				'description' => '',
				'ref_no_or_cheque_no' => '',
				'branch_code' => '',
				'debit' => '',
				'credit' => '',
				'balance_1' => '',
				'balance_2' => '',
				'remarks_1' => '',
				'remarks_2' => '',
				'category' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'payment_track_details_table' => [
				'payment_track_details_id' => '',
				'pfms_num' => '',
				'date' => '1',
				'description' => '',
				'amount' => '',
				'requested_by' => '',
				'paid_to' => '',
				'paid_status' => '',
				'payment_date' => '1',
				'remarks' => '',
				'upload_scanned_file_1' => '',
				'upload_scanned_file_2' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'travel_table' => [
				'id' => '',
				'first_name' => '',
				'last_name' => '',
				'age' => '',
				'gender' => 'Male',
				'mobile_number' => '',
				'travel_type' => '',
				'from_place' => '',
				'to_place' => '',
				'date_from' => '',
				'date_to' => '',
				'travel_description' => '',
				'approval_status' => 'Under Consideration',
				'approval_remarks' => '',
				'created_by' => '',
				'approved_by' => '',
				'created_at' => '',
				'approved_at' => '',
			],
			'travel_stay_table' => [
				'id' => '',
				'first_name' => '',
				'last_name' => '',
				'age' => '',
				'gender' => 'Male',
				'mobile_number' => '',
				'hotel_name' => '',
				'hotel_address' => '',
				'checkin_date' => '',
				'checkout_date' => '',
				'room_preferance' => '',
				'remarks' => '',
				'approval_status' => 'Under Consideration',
				'approval_remarks' => '',
				'approved_by' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_at' => '',
			],
			'travel_local_commute_table' => [
				'id' => '',
				'first_name' => '',
				'last_name' => '',
				'age' => '',
				'gender' => 'Male',
				'mobile_number' => '',
				'local_commute_type' => 'Cab',
				'from_place' => '',
				'to_place' => '',
				'description' => '',
				'approval_status' => 'Under Consideration',
				'approval_remarks' => '',
				'created_by' => '',
				'approved_by' => '',
				'created_at' => '',
				'approved_at' => '',
			],
			'r_and_d_progress' => [
				'id' => '',
				'username' => '',
				'date' => '',
				'labs' => '',
				'today_progress' => '',
				'tomorrow_plan' => '',
				'ceo_remarks' => '',
				'pd_remarks' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'panel_decision_table_tdp' => [
				'panel_decision_id' => '',
				'edition' => '',
				'project_id' => '',
				'date_of_presentation' => '',
				'project_title' => '',
				'name_of_pi' => '',
				'mobile_number' => '',
				'institute' => '',
				'budget_specified' => '',
				'final_budget_to_be_allocated' => '',
				'experts_comments' => '',
				'trl' => '',
				'proposal_link' => '',
				'updated_proposal_link' => '',
				'where_budget_need' => '',
				'final_decision' => '',
				'notification_mail' => '',
				'call_done' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'selected_proposals_final_tdp' => [
				'selected_proposals_id' => '',
				'project_id' => '',
				'breakthrough' => '',
				'project_title' => '',
				'short_name' => '',
				'duration_in_months' => '',
				'name_of_pi' => '',
				'mobile_number' => '',
				'institute' => '',
				'stage_1' => '',
				'stage_2' => '',
				'stage_3' => '',
				'stage_4' => '',
				'total_budget_specified' => '',
				'one_slide_ppt_link' => '',
				'proposal_link' => '',
				'existing_trl' => '',
				'expected_trl' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'stage_wise_budget_table_tdp' => [
				'id' => '',
				'project_id' => '',
				'project_title' => '',
				'name_of_pi' => '',
				'mobile_number' => '',
				'institute' => '',
				'duration_in_months' => '',
				'total_budget_specified' => '',
				'first_phase' => '',
				'second_phase' => '',
				'third_phase' => '',
				'fourth_phase' => '',
				'total' => '',
				'final_budget_to_be_allocated' => '',
				'proposal_link' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'first_level_shortlisted_proposals_tdp' => [
				'id' => '',
				'project_id' => '',
				'name' => '',
				'institution' => '',
				'domain_of_interest' => '',
				'proposal_link' => '',
				'first_level_comment' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'budget_table_tdp' => [
				'id' => '',
				'project_id' => '',
				'title_of_the_project' => '',
				'name_of_pi' => '',
				'institute' => '',
				'date_of_presentation' => '',
				'manpower' => '',
				'travel' => '',
				'infrastructure' => '',
				'consumables' => '',
				'contigency' => '',
				'overhead' => '',
				'any_other' => '',
				'total_budget' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'panel_comments_tdp' => [
				'id' => '',
				'project_id' => '',
				'project_title' => '',
				'name_of_pi' => '',
				'institute' => '',
				'final_budget' => '',
				'comments_from_yvn_sir' => '',
				'comments_from_ramakrishna_sir' => '',
				'comments_from_bharat_lohani_sir' => '',
				'remarks_1' => '',
				'remarks_2' => '',
				'finale_decision' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'selected_tdp' => [
				'id' => '',
				'project_id' => '',
				'project_title' => '',
				'name_of_pi' => '',
				'institute' => '',
				'budget' => '',
				'decision' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'address_tdp' => [
				'id' => '',
				'project_id' => '',
				'project_title' => '',
				'short_name' => '',
				'pincode' => '',
				'lattitude' => '',
				'longitude' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'summary_table_tdp' => [
				'id' => '',
				'project_number' => '',
				'project_title' => '',
				'year' => '',
				'pi' => '',
				'institute' => '',
				'duration_in_months' => '',
				'overall_budget' => '',
				'number_of_products' => '',
				'trl_status' => '',
				'sactioned_date' => '1',
				'ongoing_month_of_project' => '',
				'last_monthly_report' => '',
				'no_of_ug' => '',
				'no_of_pg' => '',
				'no_of_phd' => '',
				'no_of_postdoc' => '',
				'first_milestone_amount_and_date' => '1',
				'stage_I_completion' => '',
				'second_milestone_amount_and_date' => '1',
				'stage_2_completion' => '',
				'third_milestone_amount_and_date' => '1',
				'stage_3_completion' => '',
				'fourth_milestone_amount_and_date' => '1',
				'stage_4_completion' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
			'project_details_tdp' => [
				'id' => '',
				'project_number' => '',
				'stage_1' => '',
				'stage_2' => '',
				'stage_3' => '',
				'stage_4' => '',
				'total' => '',
				'details' => '',
				'created_by' => '',
				'created_at' => '',
				'last_updated_by' => '',
				'last_updated_at' => '',
			],
		];

		return isset($defaults[$table]) ? $defaults[$table] : [];
	}

	#########################################################

	function htmlUserBar() {
		global $Translation;
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');

		$mi = getMemberInfo();
		$adminConfig = config('adminConfig');
		$home_page = (basename($_SERVER['PHP_SELF']) == 'index.php');
		ob_start();

		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden-print" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- application title is obtained from the name besides the yellow database icon in AppGini, use underscores for spaces -->
				<a class="navbar-brand" href="<?php echo PREPEND_PATH; ?>index.php"><i class="glyphicon glyphicon-home"></i> <?php echo APP_TITLE; ?></a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav"><?php echo ($home_page && !HOMEPAGE_NAVMENUS ? '' : NavMenus()); ?></ul>

				<?php if(userCanImport()){ ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>import-csv.php" class="btn btn-default navbar-btn hidden-xs btn-import-csv" title="<?php echo html_attr($Translation['import csv file']); ?>"><i class="glyphicon glyphicon-th"></i> <?php echo $Translation['import CSV']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>import-csv.php" class="btn btn-default navbar-btn visible-xs btn-lg btn-import-csv" title="<?php echo html_attr($Translation['import csv file']); ?>"><i class="glyphicon glyphicon-th"></i> <?php echo $Translation['import CSV']; ?></a>
					</ul>
				<?php } ?>

				<?php if(getLoggedAdmin() !== false) { ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn hidden-xs" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn visible-xs btn-lg" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
					</ul>
				<?php } ?>

				<?php if(!Request::val('signIn') && !Request::val('loginFailed')) { ?>
					<?php if(!$mi['username'] || $mi['username'] == $adminConfig['anonymousMember']) { ?>
						<p class="navbar-text navbar-right hidden-xs">&nbsp;</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success navbar-btn navbar-right hidden-xs"><?php echo $Translation['sign in']; ?></a>
						<p class="navbar-text navbar-right hidden-xs">
							<?php echo $Translation['not signed in']; ?>
						</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success btn-block btn-lg navbar-btn visible-xs">
							<?php echo $Translation['not signed in']; ?>
							<i class="glyphicon glyphicon-chevron-right"></i> 
							<?php echo $Translation['sign in']; ?>
						</a>
					<?php } else { ?>
						<ul class="nav navbar-nav navbar-right hidden-xs">
							<!-- logged user profile menu -->
							<li class="dropdown" title="<?php echo html_attr("{$Translation['signed as']} {$mi['username']}"); ?>">
								<a href="#" class="dropdown-toggle profile-menu-icon" data-toggle="dropdown"><i class="glyphicon glyphicon-user icon"></i><span class="profile-menu-text"><?php echo $mi['username']; ?></span><b class="caret"></b></a>
								<ul class="dropdown-menu profile-menu">
									<li class="user-profile-menu-item" title="<?php echo html_attr("{$Translation['Your info']}"); ?>">
										<a href="<?php echo PREPEND_PATH; ?>membership_profile.php"><i class="glyphicon glyphicon-user"></i> <span class="username"><?php echo $mi['username']; ?></span></a>
									</li>
									<li class="keyboard-shortcuts-menu-item" title="<?php echo html_attr("{$Translation['keyboard shortcuts']}"); ?>" class="hidden-xs">
										<a href="#" class="help-shortcuts-launcher">
											<img src="<?php echo PREPEND_PATH; ?>resources/images/keyboard.png">
											<?php echo html_attr($Translation['keyboard shortcuts']); ?>
										</a>
									</li>
									<li class="sign-out-menu-item" title="<?php echo html_attr("{$Translation['sign out']}"); ?>">
										<a href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav visible-xs">
							<a class="btn navbar-btn btn-default btn-lg visible-xs" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text text-center signed-in-as">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link username"><?php echo $mi['username']; ?></a></strong>
							</p>
						</ul>
						<script>
							/* periodically check if user is still signed in */
							setInterval(function() {
								$j.ajax({
									url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
									success: function(username) {
										if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
									}
								});
							}, 60000);
						</script>
					<?php } ?>
				<?php } ?>
			</div>
		</nav>
		<?php

		return ob_get_clean();
	}

	#########################################################

	function showNotifications($msg = '', $class = '', $fadeout = true) {
		global $Translation;
		if($error_message = strip_tags(Request::val('error_message')))
			$error_message = '<div class="text-bold">' . $error_message . '</div>';

		if(!$msg) { // if no msg, use url to detect message to display
			if(Request::val('record-added-ok')) {
				$msg = $Translation['new record saved'];
				$class = 'alert-success';
			} elseif(Request::val('record-added-error')) {
				$msg = $Translation['Couldn\'t save the new record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} elseif(Request::val('record-updated-ok')) {
				$msg = $Translation['record updated'];
				$class = 'alert-success';
			} elseif(Request::val('record-updated-error')) {
				$msg = $Translation['Couldn\'t save changes to the record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} elseif(Request::val('record-deleted-ok')) {
				$msg = $Translation['The record has been deleted successfully'];
				$class = 'alert-success';
			} elseif(Request::val('record-deleted-error')) {
				$msg = $Translation['Couldn\'t delete this record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} else {
				return '';
			}
		}
		$id = 'notification-' . rand();

		ob_start();
		// notification template
		?>
		<div id="%%ID%%" class="alert alert-dismissable %%CLASS%%" style="opacity: 1; padding-top: 6px; padding-bottom: 6px; animation: fadeIn 1.5s ease-out; z-index: 100; position: relative;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			%%MSG%%
		</div>
		<script>
			$j(function() {
				var autoDismiss = <?php echo $fadeout ? 'true' : 'false'; ?>,
					embedded = !$j('nav').length,
					messageDelay = 10, fadeDelay = 1.5;

				if(!autoDismiss) {
					if(embedded)
						$j('#%%ID%%').before('<div class="modal-top-spacer"></div>');
					else
						$j('#%%ID%%').css({ margin: '0 0 1rem' });

					return;
				}

				// below code runs only in case of autoDismiss

				if(embedded)
					$j('#%%ID%%').css({ margin: '1rem 0 -1rem' });
				else
					$j('#%%ID%%').css({ margin: '-15px 0 -20px' });

				setTimeout(function() {
					$j('#%%ID%%').css({    animation: 'fadeOut ' + fadeDelay + 's ease-out' });
				}, messageDelay * 1000);

				setTimeout(function() {
					$j('#%%ID%%').css({    visibility: 'hidden' });
				}, (messageDelay + fadeDelay) * 1000);
			})
		</script>
		<style>
			@keyframes fadeIn {
				0%   { opacity: 0; }
				100% { opacity: 1; }
			}
			@keyframes fadeOut {
				0%   { opacity: 1; }
				100% { opacity: 0; }
			}
		</style>

		<?php
		$out = ob_get_clean();

		$out = str_replace('%%ID%%', $id, $out);
		$out = str_replace('%%MSG%%', $msg, $out);
		$out = str_replace('%%CLASS%%', $class, $out);

		return $out;
	}

	#########################################################

	function validMySQLDate($date) {
		$date = trim($date);

		try {
			$dtObj = new DateTime($date);
		} catch(Exception $e) {
			return false;
		}

		$parts = explode('-', $date);
		return (
			count($parts) == 3
			// see https://dev.mysql.com/doc/refman/8.0/en/datetime.html
			&& intval($parts[0]) >= 1000
			&& intval($parts[0]) <= 9999
			&& intval($parts[1]) >= 1
			&& intval($parts[1]) <= 12
			&& intval($parts[2]) >= 1
			&& intval($parts[2]) <= 31
		);
	}

	#########################################################

	function parseMySQLDate($date, $altDate) {
		// is $date valid?
		if(validMySQLDate($date)) return trim($date);

		if($date != '--' && validMySQLDate($altDate)) return trim($altDate);

		if($date != '--' && $altDate && is_numeric($altDate))
			return @date('Y-m-d', @time() + ($altDate >= 1 ? $altDate - 1 : $altDate) * 86400);

		return '';
	}

	#########################################################

	function parseCode($code, $isInsert = true, $rawData = false) {
		$mi = Authentication::getUser();

		if($isInsert) {
			$arrCodes = [
				'<%%creatorusername%%>' => $mi['username'],
				'<%%creatorgroupid%%>' => $mi['groupId'],
				'<%%creatorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%creatorgroup%%>' => $mi['group'],

				'<%%creationdate%%>' => ($rawData ? date('Y-m-d') : date(app_datetime_format('phps'))),
				'<%%creationtime%%>' => ($rawData ? date('H:i:s') : date(app_datetime_format('phps', 't'))),
				'<%%creationdatetime%%>' => ($rawData ? date('Y-m-d H:i:s') : date(app_datetime_format('phps', 'dt'))),
				'<%%creationtimestamp%%>' => ($rawData ? date('Y-m-d H:i:s') : time()),
			];
		} else {
			$arrCodes = [
				'<%%editorusername%%>' => $mi['username'],
				'<%%editorgroupid%%>' => $mi['groupId'],
				'<%%editorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%editorgroup%%>' => $mi['group'],

				'<%%editingdate%%>' => ($rawData ? date('Y-m-d') : date(app_datetime_format('phps'))),
				'<%%editingtime%%>' => ($rawData ? date('H:i:s') : date(app_datetime_format('phps', 't'))),
				'<%%editingdatetime%%>' => ($rawData ? date('Y-m-d H:i:s') : date(app_datetime_format('phps', 'dt'))),
				'<%%editingtimestamp%%>' => ($rawData ? date('Y-m-d H:i:s') : time()),
			];
		}

		$pc = str_ireplace(array_keys($arrCodes), array_values($arrCodes), $code);

		return $pc;
	}

	#########################################################

	function parseMySQLDateTime($datetime, $altDateTime) {
		// is $datetime valid?
		if(mysql_datetime($datetime)) return mysql_datetime($datetime);

		if($altDateTime === '') return '';

		// is $altDateTime valid?
		if(mysql_datetime($altDateTime)) return mysql_datetime($altDateTime);

		/* parse $altDateTime */
		$matches = [];
		if(!preg_match('/^([+-])(\d+)(s|m|h|d)(0)?$/', $altDateTime, $matches))
			return '';

		$sign = ($matches[1] == '-' ? -1 : 1);
		$unit = $matches[3];
		$qty = $matches[2];

		// m0 means increment minutes, set seconds to 0
		// h0 means increment hours, set minutes and seconds to 0
		// d0 means increment days, set time to 00:00:00
		$zeroTime = $matches[4] == '0';

		switch($unit) {
			case 's':
				$seconds = $qty * $sign;
				break;
			case 'm':
				$seconds = $qty * 60 * $sign;
				if($zeroTime) return @date('Y-m-d H:i:00', @time() + $seconds);
				break;
			case 'h':
				$seconds = $qty * 3600 * $sign;
				if($zeroTime) return @date('Y-m-d H:00:00', @time() + $seconds);
				break;
			case 'd':
				$seconds = $qty * 86400 * $sign;
				if($zeroTime) return @date('Y-m-d 00:00:00', @time() + $seconds);
				break;
		}

		return @date('Y-m-d H:i:s', @time() + $seconds);
	}

	#########################################################

	function addFilter($index, $filterAnd, $filterField, $filterOperator, $filterValue) {
		// validate input
		if($index < 1 || $index > 80 || !is_int($index)) return false;
		if($filterAnd != 'or')   $filterAnd = 'and';
		$filterField = intval($filterField);

		/* backward compatibility */
		if(in_array($filterOperator, FILTER_OPERATORS)) {
			$filterOperator = array_search($filterOperator, FILTER_OPERATORS);
		}

		if(!in_array($filterOperator, array_keys(FILTER_OPERATORS))) {
			$filterOperator = 'like';
		}

		if(!$filterField) {
			$filterOperator = '';
			$filterValue = '';
		}

		$_REQUEST['FilterAnd'][$index] = $filterAnd;
		$_REQUEST['FilterField'][$index] = $filterField;
		$_REQUEST['FilterOperator'][$index] = $filterOperator;
		$_REQUEST['FilterValue'][$index] = $filterValue;

		return true;
	}

	#########################################################

	function clearFilters() {
		for($i=1; $i<=80; $i++) {
			addFilter($i, '', 0, '', '');
		}
	}

	#########################################################

	/**
	* Loads a given view from the templates folder, passing the given data to it
	* @param $view the name of a php file (without extension) to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_view (optional) associative array containing the data to pass to the view
	* @return string the output of the parsed view
	*/
	function loadView($view, $the_data_to_pass_to_the_view = false) {
		global $Translation;

		$view = __DIR__ . "/templates/$view.php";
		if(!is_file($view)) return false;

		if(is_array($the_data_to_pass_to_the_view)) {
			foreach($the_data_to_pass_to_the_view as $data_k => $data_v)
				$$data_k = $data_v;
		}
		unset($the_data_to_pass_to_the_view, $data_k, $data_v);

		ob_start();
		@include($view);
		return ob_get_clean();
	}

	#########################################################

	/**
	* Loads a table template from the templates folder, passing the given data to it
	* @param $table_name the name of the table whose template is to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_table associative array containing the data to pass to the table template
	* @return the output of the parsed table template as a string
	*/
	function loadTable($table_name, $the_data_to_pass_to_the_table = []) {
		$dont_load_header = $the_data_to_pass_to_the_table['dont_load_header'];
		$dont_load_footer = $the_data_to_pass_to_the_table['dont_load_footer'];

		$header = $table = $footer = '';

		if(!$dont_load_header) {
			// try to load tablename-header
			if(!($header = loadView("{$table_name}-header", $the_data_to_pass_to_the_table))) {
				$header = loadView('table-common-header', $the_data_to_pass_to_the_table);
			}
		}

		$table = loadView($table_name, $the_data_to_pass_to_the_table);

		if(!$dont_load_footer) {
			// try to load tablename-footer
			if(!($footer = loadView("{$table_name}-footer", $the_data_to_pass_to_the_table))) {
				$footer = loadView('table-common-footer', $the_data_to_pass_to_the_table);
			}
		}

		return "{$header}{$table}{$footer}";
	}

	#########################################################

	function br2nl($text) {
		return  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
	}

	#########################################################

	function entitiesToUTF8($input) {
		return preg_replace_callback('/(&#[0-9]+;)/', '_toUTF8', $input);
	}

	function _toUTF8($m) {
		if(function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
		} else {
			return $m[1];
		}
	}

	#########################################################

	function func_get_args_byref() {
		if(!function_exists('debug_backtrace')) return false;

		$trace = debug_backtrace();
		return $trace[1]['args'];
	}

	#########################################################

	function permissions_sql($table, $level = 'all') {
		if(!in_array($level, ['user', 'group'])) { $level = 'all'; }
		$perm = getTablePermissions($table);
		$from = '';
		$where = '';
		$pk = getPKFieldName($table);

		if($perm['view'] == 1 || ($perm['view'] > 1 && $level == 'user')) { // view owner only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and lcase(membership_userrecords.memberID)='" . getLoggedMemberID() . "')";
		} elseif($perm['view'] == 2 || ($perm['view'] > 2 && $level == 'group')) { // view group only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and membership_userrecords.groupID='" . getLoggedGroupID() . "')";
		} elseif($perm['view'] == 3) { // view all
			// no further action
		} elseif($perm['view'] == 0) { // view none
			return false;
		}

		return ['where' => $where, 'from' => $from, 0 => $where, 1 => $from];
	}

	#########################################################

	function error_message($msg, $back_url = '', $full_page = true) {
		global $Translation;

		ob_start();

		if($full_page) include(__DIR__ . '/header.php');

		echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading"><h3 class="panel-title">' . $Translation['error:'] . '</h3></div>';
			echo '<div class="panel-body"><p class="text-danger">' . $msg . '</p>';
			if($back_url !== false) { // explicitly passing false suppresses the back link completely
				echo '<div class="text-center">';
				if($back_url) {
					echo '<a href="' . $back_url . '" class="btn btn-danger btn-lg vspacer-lg"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				// in embedded mode, close modal window
				} elseif(Request::val('Embedded')) {
					echo '<button class="btn btn-danger btn-lg" type="button" onclick="AppGini.closeParentModal();"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</button>';
				} else {
					echo '<a href="#" class="btn btn-danger btn-lg vspacer-lg" onclick="history.go(-1); return false;"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

		if($full_page) include(__DIR__ . '/footer.php');

		return ob_get_clean();
	}

	#########################################################

	function toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format) {
		// extract date elements
		$de=explode($sep, $formattedDate);
		$mySQLDate=intval($de[strpos($ord, 'Y')]).'-'.intval($de[strpos($ord, 'm')]).'-'.intval($de[strpos($ord, 'd')]);
		return $mySQLDate;
	}

	#########################################################

	function reIndex(&$arr) {
		$i=1;
		foreach($arr as $n=>$v) {
			$arr2[$i]=$n;
			$i++;
		}
		return $arr2;
	}

	#########################################################

	function get_embed($provider, $url, $max_width = '', $max_height = '', $retrieve = 'html') {
		global $Translation;
		if(!$url) return '';

		$providers = [
			'youtube' => ['oembed' => 'https://www.youtube.com/oembed', 'regex' => '/^http.*(youtu\.be|youtube\.com)\/.*/i'],
			'vimeo' => ['oembed' => 'https://vimeo.com/api/oembed.json', 'regex' => '/^http.*vimeo\.com\/.*/i'],
			'googlemap' => ['oembed' => '', 'regex' => '/^http.*\.google\..*maps/i'],
			'dailymotion' => ['oembed' => 'https://www.dailymotion.com/services/oembed', 'regex' => '/^http.*(dailymotion\.com|dai\.ly)\/.*/i'],
			'videofileurl' => ['oembed' => '', 'regex' => '/\.(mp4|webm|ogg|ogv)$/i'],
		];

		if(!$max_height) $max_height = 360;
		if(!$max_width) $max_width = 480;

		if(!isset($providers[$provider])) {
			// try detecting provider from URL based on regex
			foreach($providers as $p => $opts) {
				if(preg_match($opts['regex'], $url)) {
					$provider = $p;
					break;
				}
			}

			if(!isset($providers[$provider]))
				return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
		}

		if(isset($providers[$provider]['regex']) && !preg_match($providers[$provider]['regex'], $url)) {
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		if($providers[$provider]['oembed']) {
			$oembed = $providers[$provider]['oembed'] . '?url=' . urlencode($url) . "&amp;maxwidth={$max_width}&amp;maxheight={$max_height}&amp;format=json";
			$data_json = request_cache($oembed);

			$data = json_decode($data_json, true);
			if($data === null) {
				/* an error was returned rather than a json string */
				if($retrieve == 'html') return "<div class=\"text-danger\">{$data_json}\n<!-- {$oembed} --></div>";
				return '';
			}

			// if html data not empty, apply max width and height in place of provided height and width
			$provided_width = $data['width'] ?? null;
			$provided_height = $data['height'] ?? null;
			if($provided_width && $provided_height) {
				$aspect_ratio = $provided_width / $provided_height;
				if($max_width / $aspect_ratio < $max_height) {
					$max_height = intval($max_width / $aspect_ratio);
				} else {
					$max_width = intval($max_height * $aspect_ratio);
				}

				$data['html'] = str_replace("width=\"{$provided_width}\"", "width=\"{$max_width}\"", $data['html']);
				$data['html'] = str_replace("height=\"{$provided_height}\"", "height=\"{$max_height}\"", $data['html']);
			}

			return (isset($data[$retrieve]) ? $data[$retrieve] : $data['html']);
		}

		/* special cases (where there is no oEmbed provider) */
		if($provider == 'googlemap') return get_embed_googlemap($url, $max_width, $max_height, $retrieve);
		if($provider == 'videofileurl') return get_embed_videofileurl($url, $max_width, $max_height, $retrieve);

		return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
	}

	#########################################################

	function get_embed_videofileurl($url, $max_width = '', $max_height = '', $retrieve = 'html') {
		global $Translation;

		$allowed_exts = ['mp4', 'webm', 'ogg', 'ogv'];
		$ext = strtolower(pathinfo($url, PATHINFO_EXTENSION));

		if(!in_array($ext, $allowed_exts)) {
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		$video = "<video controls style=\"max-width: 100%%; height: auto;\" src=\"%s\"></video>";

		switch($retrieve) {
			case 'html':
				return sprintf($video, $url);
			default: // 'thumbnail'
				return '';
		}
	}

	#########################################################

	function get_embed_googlemap($url, $max_width = '', $max_height = '', $retrieve = 'html') {
		global $Translation;
		$url_parts = parse_url($url);
		$coords_regex = '/-?\d+(\.\d+)?[,+]-?\d+(\.\d+)?(,\d{1,2}z)?/'; /* https://stackoverflow.com/questions/2660201 */

		if(!preg_match($coords_regex, $url_parts['path'] . '?' . $url_parts['query'], $m))
			return '<div class="text-danger">' . $Translation['cant retrieve coordinates from url'] . '</div>';

		list($lat, $long, $zoom) = explode(',', $m[0]);
		$zoom = intval($zoom);
		if(!$zoom) $zoom = 15; /* default zoom */
		if(!$max_height) $max_height = 360;
		if(!$max_width) $max_width = 480;

		$api_key = config('adminConfig')['googleAPIKey'];

		// if max_height is all numeric, append 'px' to it
		$frame_height = $max_height;
		if(is_numeric($frame_height)) $frame_height .= 'px';

		$embed_url = 'https://www.google.com/maps/embed/v1/%s?' . http_build_query([
			'key' => $api_key,
			'zoom' => $zoom,
			'maptype' => 'roadmap',
		], '', '&amp;');

		$thumbnail_url = 'https://maps.googleapis.com/maps/api/staticmap?' . http_build_query([
			'key' => $api_key,
			'zoom' => $zoom,
			'maptype' => 'roadmap',
			'size' => "{$max_width}x{$max_height}",
			'center' => "$lat,$long",
		], '', '&amp;');

		$iframe = "<iframe allowfullscreen loading=\"lazy\" style=\"border: none; width: 100%%; height: $frame_height;\" src=\"%s\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>";

		switch($retrieve) {
			case 'html':
				$embed_url = sprintf($embed_url, 'view') . '&amp;' . http_build_query(['center' => "$lat,$long"]);
				return sprintf($iframe, $embed_url);
			case 'html-pinpoint':
				$embed_url = sprintf($embed_url, 'place') . '&amp;' . http_build_query(['q' => "$lat,$long"]);
				return sprintf($iframe, $embed_url);
			case 'thumbnail-pinpoint':
				return $thumbnail_url . '&amp;' . http_build_query(['markers' => "$lat,$long"]);
			default: // 'thumbnail'
				return $thumbnail_url;
		}
	}

	#########################################################

	function request_cache($request, $force_fetch = false) {
		static $cache_table_exists = null;
		$max_cache_lifetime = 7 * 86400; /* max cache lifetime in seconds before refreshing from source */

		// force fetching request if no cache table exists
		if($cache_table_exists === null)
			$cache_table_exists = sqlValue("show tables like 'membership_cache'");

		if(!$cache_table_exists)
			return request_cache($request, true);

		/* retrieve response from cache if exists */
		if(!$force_fetch) {
			$res = sql("select response, request_ts from membership_cache where request='" . md5($request) . "'", $eo);
			if(!$row = db_fetch_array($res)) return request_cache($request, true);

			$response = $row[0];
			$response_ts = $row[1];
			if($response_ts < time() - $max_cache_lifetime) return request_cache($request, true);
		}

		/* if no response in cache, issue a request */
		if(!$response || $force_fetch) {
			$response = @file_get_contents($request);
			if($response === false) {
				$error = error_get_last();
				$error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
				return $error_message;
			} elseif($cache_table_exists) {
				/* store response in cache */
				$ts = time();
				sql("replace into membership_cache set request='" . md5($request) . "', request_ts='{$ts}', response='" . makeSafe($response, false) . "'", $eo);
			}
		}

		return $response;
	}

	#########################################################

	function check_record_permission($table, $id, $perm = 'view') {
		if($perm != 'edit' && $perm != 'delete') $perm = 'view';

		$perms = getTablePermissions($table);
		if(!$perms[$perm]) return false;

		$safe_id = makeSafe($id);
		$safe_table = makeSafe($table);

		// fix for zero-fill: quote id only if not numeric
		if(!is_numeric($safe_id)) $safe_id = "'$safe_id'";

		if($perms[$perm] == 1) { // own records only
			$username = getLoggedMemberID();
			$owner = sqlValue("select memberID from membership_userrecords where tableName='{$safe_table}' and pkValue={$safe_id}");
			if($owner == $username) return true;
		} elseif($perms[$perm] == 2) { // group records
			$group_id = getLoggedGroupID();
			$owner_group_id = sqlValue("select groupID from membership_userrecords where tableName='{$safe_table}' and pkValue={$safe_id}");
			if($owner_group_id == $group_id) return true;
		} elseif($perms[$perm] == 3) { // all records
			return true;
		}

		return false;
	}

	#########################################################

	function NavMenus($options = []) {
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		global $Translation;
		$prepend_path = PREPEND_PATH;

		/* default options */
		if(empty($options)) {
			$options = ['tabs' => 7];
		}

		$table_group_name = array_keys(get_table_groups()); /* 0 => group1, 1 => group2 .. */
		/* if only one group named 'None', set to translation of 'select a table' */
		if((count($table_group_name) == 1 && $table_group_name[0] == 'None') || count($table_group_name) < 1) $table_group_name[0] = $Translation['select a table'];
		$table_group_index = array_flip($table_group_name); /* group1 => 0, group2 => 1 .. */
		$menu = array_fill(0, count($table_group_name), '');

		$t = time();
		$arrTables = getTableList();
		if(is_array($arrTables)) {
			foreach($arrTables as $tn => $tc) {
				/* ---- list of tables where hide link in nav menu is set ---- */
				$tChkHL = array_search($tn, ['user_table','suggestion','approval_table','car_table','car_usage_table','cycle_table','cycle_usage_table','gym_table','coffee_table','event_table','outcomes_expected_table','event_decision_table','meetings_table','agenda_table','decision_table','participants_table','action_actor','visiting_card_table','mou_details_table','mou_company_area_details_table','goal_setting_table','goal_progress_table','task_setting_table','subtask_setting_table','internship_fellowship_details_app','star_pnt','hrd_sdp_events_table','training_program_on_geospatial_tchnologies_table','space_day_school_details_app','space_day_college_student_table','school_list','sdp_participants_college_details_table','asset_table','asset_allotment_table','it_inventory_app','it_inventory_billing_details','it_inventory_allotment_table','computer_details_table','computer_usage_table','employees_personal_data_table','employees_designation_table','employees_appraisal_table','employees_appraisal_feedback_table','beyond_workingHours_table','attendence_details_table','leave_table','work_from_home_table','navavishkar_stay_table','navavishkar_stay_payment_table','email_id_allocation_table','all_startup_data_table','shortlisted_startups_for_fund_table','shortlisted_startups_dd_and_agreement_table','vikas_startup_applications_table','programs_table','evaluation_table','problem_statement_table','evaluators_table','approval_billing_table','honorarium_claim_table','all_bank_account_statement_table','payment_track_details_table','travel_table','travel_stay_table','travel_local_commute_table','r_and_d_progress','panel_decision_table_tdp','selected_proposals_final_tdp','stage_wise_budget_table_tdp','first_level_shortlisted_proposals_tdp','budget_table_tdp','panel_comments_tdp','selected_tdp','address_tdp','summary_table_tdp','project_details_tdp']);

				/* ---- list of tables where filter first is set ---- */
				$tChkFF = array_search($tn, []);
				if($tChkFF !== false && $tChkFF !== null) {
					$searchFirst = '&Filter_x=1';
				} else {
					$searchFirst = '';
				}

				/* when no groups defined, $table_group_index['None'] is NULL, so $menu_index is still set to 0 */
				$menu_index = intval($table_group_index[$tc[3]]);
				if(!$tChkHL && $tChkHL !== 0) $menu[$menu_index] .= "<li><a href=\"{$prepend_path}{$tn}_view.php?t={$t}{$searchFirst}\"><img src=\"{$prepend_path}" . ($tc[2] ? $tc[2] : 'blank.gif') . "\" height=\"32\"> {$tc[0]}</a></li>";
			}
		}

		// custom nav links, as defined in "hooks/links-navmenu.php" 
		global $navLinks;
		if(is_array($navLinks)) {
			$memberInfo = getMemberInfo();
			$links_added = [];
			foreach($navLinks as $link) {
				if(!isset($link['url']) || !isset($link['title'])) continue;
				if(getLoggedAdmin() !== false || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])) {
					$menu_index = intval($link['table_group']);
					if(!$links_added[$menu_index]) $menu[$menu_index] .= '<li class="divider"></li>';

					/* add prepend_path to custom links if they aren't absolute links */
					if(!preg_match('/^(http|\/\/)/i', $link['url'])) $link['url'] = $prepend_path . $link['url'];
					if(!preg_match('/^(http|\/\/)/i', $link['icon']) && $link['icon']) $link['icon'] = $prepend_path . $link['icon'];

					$menu[$menu_index] .= "<li><a href=\"{$link['url']}\"><img src=\"" . ($link['icon'] ? $link['icon'] : "{$prepend_path}blank.gif") . "\" height=\"32\"> {$link['title']}</a></li>";
					$links_added[$menu_index]++;
				}
			}
		}

		$menu_wrapper = '';
		for($i = 0; $i < count($menu); $i++) {
			$menu_wrapper .= <<<EOT
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$table_group_name[$i]} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">{$menu[$i]}</ul>
				</li>
EOT;
		}

		return $menu_wrapper;
	}

	#########################################################

	function StyleSheet() {
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		$prepend_path = PREPEND_PATH;
		$mtime = filemtime( __DIR__ . '/dynamic.css');

		$css_links = <<<EOT

			<link rel="stylesheet" href="{$prepend_path}resources/initializr/css/spacelab.css">
			<link rel="stylesheet" href="{$prepend_path}resources/lightbox/css/lightbox.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/select2/select2.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/timepicker/bootstrap-timepicker.min.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}dynamic.css?{$mtime}">
EOT;

		return $css_links;
	}

	#########################################################

	function PrepareUploadedFile($FieldName, $MaxSize, $FileTypes = 'jpg|jpeg|gif|png|webp', $NoRename = false, $dir = '') {
		global $Translation;
		$f = $_FILES[$FieldName];
		if($f['error'] == 4 || !$f['name']) return '';

		$dir = getUploadDir($dir);

		/* get php.ini upload_max_filesize in bytes */
		$php_upload_size_limit = toBytes(ini_get('upload_max_filesize'));
		$MaxSize = min($MaxSize, $php_upload_size_limit);

		if($f['size'] > $MaxSize || $f['error']) {
			echo error_message(str_replace(['<MaxSize>', '{MaxSize}'], intval($MaxSize / 1024), $Translation['file too large']));
			exit;
		}
		if(!preg_match('/\.(' . $FileTypes . ')$/i', $f['name'], $ft)) {
			echo error_message(str_replace(['<FileTypes>', '{FileTypes}'], str_replace('|', ', ', $FileTypes), $Translation['invalid file type']));
			exit;
		}

		$name = str_replace(' ', '_', $f['name']);
		if(!$NoRename) $name = substr(md5(microtime() . rand(0, 100000)), -17) . $ft[0];

		if(!file_exists($dir)) @mkdir($dir, 0777);

		if(!@move_uploaded_file($f['tmp_name'], $dir . $name)) {
			echo error_message("Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.");
			exit;
		}

		@chmod($dir . $name, 0666);
		return $name;
	}

	#########################################################

	function get_home_links($homeLinks, $default_classes, $tgroup = '') {
		if(!is_array($homeLinks) || !count($homeLinks)) return '';

		$memberInfo = getMemberInfo();

		ob_start();
		foreach($homeLinks as $link) {
			if(!isset($link['url']) || !isset($link['title'])) continue;
			if($tgroup != $link['table_group'] && $tgroup != '*') continue;

			/* fall-back classes if none defined */
			if(!$link['grid_column_classes']) $link['grid_column_classes'] = $default_classes['grid_column'];
			if(!$link['panel_classes']) $link['panel_classes'] = $default_classes['panel'];
			if(!$link['link_classes']) $link['link_classes'] = $default_classes['link'];

			if(getLoggedAdmin() !== false || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])) {
				?>
				<div class="col-xs-12 <?php echo $link['grid_column_classes']; ?>">
					<div class="panel <?php echo $link['panel_classes']; ?>">
						<div class="panel-body">
							<a class="btn btn-block btn-lg <?php echo $link['link_classes']; ?>" title="<?php echo preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", html_attr(strip_tags($link['description']))); ?>" href="<?php echo $link['url']; ?>"><?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?><strong><?php echo $link['title']; ?></strong></a>
							<div class="panel-body-description"><?php echo $link['description']; ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

		return ob_get_clean();
	}

	#########################################################

	function quick_search_html($search_term, $label, $separate_dv = true) {
		global $Translation;

		$safe_search = html_attr($search_term);
		$safe_label = html_attr($label);
		$safe_clear_label = html_attr($Translation['Reset Filters']);

		if($separate_dv) {
			$reset_selection = "document.forms[0].SelectedID.value = '';";
		} else {
			$reset_selection = "document.forms[0].writeAttribute('novalidate', 'novalidate');";
		}
		$reset_selection .= ' document.forms[0].NoDV.value=1; return true;';

		$html = <<<EOT
		<div class="input-group" id="quick-search">
			<input type="text" id="SearchString" name="SearchString" value="{$safe_search}" class="form-control" placeholder="{$safe_label}">
			<span class="input-group-btn">
				<button name="Search_x" value="1" id="Search" type="submit" onClick="{$reset_selection}" class="btn btn-default" title="{$safe_label}"><i class="glyphicon glyphicon-search"></i></button>
				<button name="ClearQuickSearch" value="1" id="ClearQuickSearch" type="submit" onClick="\$j('#SearchString').val(''); {$reset_selection}" class="btn btn-default" title="{$safe_clear_label}"><i class="glyphicon glyphicon-remove-circle"></i></button>
			</span>
		</div>
EOT;
		return $html;
	}

	#########################################################

	function getLookupFields($skipPermissions = false, $filterByPermission = 'view') {
		$pcConfig = [
			'user_table' => [
			],
			'suggestion' => [
			],
			'approval_table' => [
				'person_responsbility' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Procurement approval - App <span class="hidden child-label-approval_table child-field-caption">(Person Responsbility)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Approval Type', 2 => 'Description', 3 => 'Quantity', 4 => 'Full Estimated Value', 5 => 'Name of Vendor', 6 => 'Purpose', 7 => 'Requested Department/Appointment', 8 => 'Person Responsbility', 9 => 'Mode of Purchase', 11 => 'Approval Status', 12 => 'Remarks for Approval', 13 => 'Upload Image if Any (Optional)', 14 => 'Upload Other File if Any (Optional)', 15 => 'Created By', 16 => 'Created At', 17 => 'Last Updated By', 18 => 'Approved At'],
					'display-field-names' => [0 => 'id', 1 => 'type', 2 => 'description', 3 => 'quantity', 4 => 'full_est_value', 5 => 'name_of_vendor', 6 => 'purpose', 7 => 'requested_department', 8 => 'person_responsbility', 9 => 'mode_of_purchase', 11 => 'approval_status', 12 => 'remarks_for_approval', 13 => 'image', 14 => 'other_file', 15 => 'created_by', 16 => 'created_at', 17 => 'last_updated_by', 18 => 'last_updated_at'],
					'sortable-fields' => [0 => '`approval_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18, 18 => 19],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-approval_table',
					'template-printable' => 'children-approval_table-printable',
					'query' => "SELECT `approval_table`.`id` as 'id', `approval_table`.`type` as 'type', `approval_table`.`description` as 'description', `approval_table`.`quantity` as 'quantity', `approval_table`.`full_est_value` as 'full_est_value', `approval_table`.`name_of_vendor` as 'name_of_vendor', `approval_table`.`purpose` as 'purpose', `approval_table`.`requested_department` as 'requested_department', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'person_responsbility', `approval_table`.`mode_of_purchase` as 'mode_of_purchase', `approval_table`.`others_if_any` as 'others_if_any', `approval_table`.`approval_status` as 'approval_status', `approval_table`.`remarks_for_approval` as 'remarks_for_approval', `approval_table`.`image` as 'image', `approval_table`.`other_file` as 'other_file', `approval_table`.`created_by` as 'created_by', `approval_table`.`created_at` as 'created_at', `approval_table`.`last_updated_by` as 'last_updated_by', `approval_table`.`last_updated_at` as 'last_updated_at' FROM `approval_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_table`.`person_responsbility` "
				],
			],
			'car_table' => [
			],
			'car_usage_table' => [
				'car_lookup' => [
					'parent-table' => 'car_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'car_usage_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Car usage table <span class="hidden child-label-car_usage_table child-field-caption">(Select Car)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Select Car', 2 => 'Used by', 3 => 'Date and time from', 4 => 'Date and time to', 5 => 'Total distance run (In KM)', 6 => 'Purpose', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'car_usage_id', 1 => 'car_lookup', 2 => 'used_by', 3 => 'datetime_from', 4 => 'datetime_to', 5 => 'total_distance_run', 6 => 'purpose', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`car_usage_table`.`car_usage_id`', 1 => 2, 2 => 3, 3 => '`car_usage_table`.`datetime_from`', 4 => '`car_usage_table`.`datetime_to`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-car_usage_table',
					'template-printable' => 'children-car_usage_table-printable',
					'query' => "SELECT `car_usage_table`.`car_usage_id` as 'car_usage_id', IF(    CHAR_LENGTH(`car_table1`.`car_number`) || CHAR_LENGTH(`car_table1`.`car_model`), CONCAT_WS('',   `car_table1`.`car_number`, '::', `car_table1`.`car_model`), '') as 'car_lookup', `car_usage_table`.`used_by` as 'used_by', if(`car_usage_table`.`datetime_from`,date_format(`car_usage_table`.`datetime_from`,'%d/%m/%Y %H:%i'),'') as 'datetime_from', if(`car_usage_table`.`datetime_to`,date_format(`car_usage_table`.`datetime_to`,'%d/%m/%Y %H:%i'),'') as 'datetime_to', `car_usage_table`.`total_distance_run` as 'total_distance_run', `car_usage_table`.`purpose` as 'purpose', `car_usage_table`.`created_by` as 'created_by', `car_usage_table`.`created_at` as 'created_at', `car_usage_table`.`last_updated_by` as 'last_updated_by', `car_usage_table`.`last_updated_at` as 'last_updated_at' FROM `car_usage_table` LEFT JOIN `car_table` as car_table1 ON `car_table1`.`id`=`car_usage_table`.`car_lookup` "
				],
			],
			'cycle_table' => [
				'responsible_contact_person' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Cycle - App <span class="hidden child-label-cycle_table child-field-caption">(Responsible Contact Person)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Registration number', 2 => 'Cycle model', 3 => 'Cycle color', 4 => 'Responsible Contact Person', 5 => 'Contact number of person', 6 => 'Purpose', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'registration_number', 2 => 'cycle_model', 3 => 'cycle_color', 4 => 'responsible_contact_person', 5 => 'contact_number_of_person', 6 => 'purpose', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`cycle_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-cycle_table',
					'template-printable' => 'children-cycle_table-printable',
					'query' => "SELECT `cycle_table`.`id` as 'id', `cycle_table`.`registration_number` as 'registration_number', `cycle_table`.`cycle_model` as 'cycle_model', `cycle_table`.`cycle_color` as 'cycle_color', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'responsible_contact_person', `cycle_table`.`contact_number_of_person` as 'contact_number_of_person', `cycle_table`.`purpose` as 'purpose', `cycle_table`.`created_by` as 'created_by', `cycle_table`.`created_at` as 'created_at', `cycle_table`.`last_updated_by` as 'last_updated_by', `cycle_table`.`last_updated_at` as 'last_updated_at' FROM `cycle_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`cycle_table`.`responsible_contact_person` "
				],
			],
			'cycle_usage_table' => [
				'cycle_lookup' => [
					'parent-table' => 'cycle_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Cycle usage table <span class="hidden child-label-cycle_usage_table child-field-caption">(Cycle Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Cycle Details', 2 => 'Used by', 3 => 'Date and time from', 4 => 'Date and time to', 5 => 'Total distance run (In KM)', 6 => 'Created by', 7 => 'Created at', 8 => 'Last updated by', 9 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'cycle_lookup', 2 => 'used_by', 3 => 'datetime_from', 4 => 'datetime_to', 5 => 'total_distance_run', 6 => 'created_by', 7 => 'created_at', 8 => 'last_updated_by', 9 => 'last_updated_at'],
					'sortable-fields' => [0 => '`cycle_usage_table`.`id`', 1 => 2, 2 => 3, 3 => '`cycle_usage_table`.`datetime_from`', 4 => '`cycle_usage_table`.`datetime_to`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-cycle_usage_table',
					'template-printable' => 'children-cycle_usage_table-printable',
					'query' => "SELECT `cycle_usage_table`.`id` as 'id', IF(    CHAR_LENGTH(`cycle_table1`.`registration_number`) || CHAR_LENGTH(`cycle_table1`.`cycle_model`), CONCAT_WS('',   `cycle_table1`.`registration_number`, '::', `cycle_table1`.`cycle_model`), '') as 'cycle_lookup', `cycle_usage_table`.`used_by` as 'used_by', if(`cycle_usage_table`.`datetime_from`,date_format(`cycle_usage_table`.`datetime_from`,'%d/%m/%Y %H:%i'),'') as 'datetime_from', if(`cycle_usage_table`.`datetime_to`,date_format(`cycle_usage_table`.`datetime_to`,'%d/%m/%Y %H:%i'),'') as 'datetime_to', `cycle_usage_table`.`total_distance_run` as 'total_distance_run', `cycle_usage_table`.`created_by` as 'created_by', `cycle_usage_table`.`created_at` as 'created_at', `cycle_usage_table`.`last_updated_by` as 'last_updated_by', `cycle_usage_table`.`last_updated_at` as 'last_updated_at' FROM `cycle_usage_table` LEFT JOIN `cycle_table` as cycle_table1 ON `cycle_table1`.`id`=`cycle_usage_table`.`cycle_lookup` "
				],
			],
			'gym_table' => [
			],
			'coffee_table' => [
			],
			'event_table' => [
			],
			'outcomes_expected_table' => [
				'event_lookup' => [
					'parent-table' => 'event_table',
					'parent-primary-key' => 'event_id',
					'child-primary-key' => 'outcomes_expected_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Outcomes expected table <span class="hidden child-label-outcomes_expected_table child-field-caption">(Event)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Event', 2 => 'Target audience', 3 => 'Expected outcomes', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'outcomes_expected_id', 1 => 'event_lookup', 2 => 'target_audience', 3 => 'expected_outcomes', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`outcomes_expected_table`.`outcomes_expected_id`', 1 => '`event_table1`.`event_str`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-outcomes_expected_table',
					'template-printable' => 'children-outcomes_expected_table-printable',
					'query' => "SELECT `outcomes_expected_table`.`outcomes_expected_id` as 'outcomes_expected_id', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', `outcomes_expected_table`.`target_audience` as 'target_audience', `outcomes_expected_table`.`expected_outcomes` as 'expected_outcomes', `outcomes_expected_table`.`outcomes_expected_str` as 'outcomes_expected_str', `outcomes_expected_table`.`created_by` as 'created_by', `outcomes_expected_table`.`created_at` as 'created_at', `outcomes_expected_table`.`last_updated_by` as 'last_updated_by', `outcomes_expected_table`.`last_updated_at` as 'last_updated_at' FROM `outcomes_expected_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`outcomes_expected_table`.`event_lookup` "
				],
			],
			'event_decision_table' => [
				'outcomes_expected_lookup' => [
					'parent-table' => 'outcomes_expected_table',
					'parent-primary-key' => 'outcomes_expected_id',
					'child-primary-key' => 'decision_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Decision - App <span class="hidden child-label-event_decision_table child-field-caption">(Expected Outcomes of Meeting)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Expected Outcomes of Meeting', 2 => 'Decision description', 3 => 'Decision actor', 4 => 'Action taken with date', 5 => 'Decision status', 6 => 'Decision status update date', 7 => 'Decision status remarks by superior', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'decision_id', 1 => 'outcomes_expected_lookup', 2 => 'decision_description', 3 => 'decision_actor', 4 => 'action_taken_with_date', 5 => 'decision_status', 6 => 'decision_status_update_date', 7 => 'decision_status_remarks_by_superior', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`event_decision_table`.`decision_id`', 1 => '`outcomes_expected_table1`.`outcomes_expected_str`', 2 => 3, 3 => 4, 4 => '`event_decision_table`.`action_taken_with_date`', 5 => 6, 6 => '`event_decision_table`.`decision_status_update_date`', 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-event_decision_table',
					'template-printable' => 'children-event_decision_table-printable',
					'query' => "SELECT `event_decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`outcomes_expected_table1`.`outcomes_expected_str`), CONCAT_WS('',   `outcomes_expected_table1`.`outcomes_expected_str`), '') as 'outcomes_expected_lookup', `event_decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`event_decision_table`.`action_taken_with_date`,date_format(`event_decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `event_decision_table`.`decision_status` as 'decision_status', if(`event_decision_table`.`decision_status_update_date`,date_format(`event_decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `event_decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `event_decision_table`.`decision_str` as 'decision_str', `event_decision_table`.`created_by` as 'created_by', `event_decision_table`.`created_at` as 'created_at', `event_decision_table`.`last_updated_by` as 'last_updated_by', `event_decision_table`.`last_updated_at` as 'last_updated_at' FROM `event_decision_table` LEFT JOIN `outcomes_expected_table` as outcomes_expected_table1 ON `outcomes_expected_table1`.`outcomes_expected_id`=`event_decision_table`.`outcomes_expected_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`event_decision_table`.`decision_actor` "
				],
				'decision_actor' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'decision_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Decision - App <span class="hidden child-label-event_decision_table child-field-caption">(Decision actor)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Expected Outcomes of Meeting', 2 => 'Decision description', 3 => 'Decision actor', 4 => 'Action taken with date', 5 => 'Decision status', 6 => 'Decision status update date', 7 => 'Decision status remarks by superior', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'decision_id', 1 => 'outcomes_expected_lookup', 2 => 'decision_description', 3 => 'decision_actor', 4 => 'action_taken_with_date', 5 => 'decision_status', 6 => 'decision_status_update_date', 7 => 'decision_status_remarks_by_superior', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`event_decision_table`.`decision_id`', 1 => '`outcomes_expected_table1`.`outcomes_expected_str`', 2 => 3, 3 => 4, 4 => '`event_decision_table`.`action_taken_with_date`', 5 => 6, 6 => '`event_decision_table`.`decision_status_update_date`', 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-event_decision_table',
					'template-printable' => 'children-event_decision_table-printable',
					'query' => "SELECT `event_decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`outcomes_expected_table1`.`outcomes_expected_str`), CONCAT_WS('',   `outcomes_expected_table1`.`outcomes_expected_str`), '') as 'outcomes_expected_lookup', `event_decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`event_decision_table`.`action_taken_with_date`,date_format(`event_decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `event_decision_table`.`decision_status` as 'decision_status', if(`event_decision_table`.`decision_status_update_date`,date_format(`event_decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `event_decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `event_decision_table`.`decision_str` as 'decision_str', `event_decision_table`.`created_by` as 'created_by', `event_decision_table`.`created_at` as 'created_at', `event_decision_table`.`last_updated_by` as 'last_updated_by', `event_decision_table`.`last_updated_at` as 'last_updated_at' FROM `event_decision_table` LEFT JOIN `outcomes_expected_table` as outcomes_expected_table1 ON `outcomes_expected_table1`.`outcomes_expected_id`=`event_decision_table`.`outcomes_expected_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`event_decision_table`.`decision_actor` "
				],
			],
			'meetings_table' => [
				'visiting_card_lookup' => [
					'parent-table' => 'visiting_card_table',
					'parent-primary-key' => 'visiting_card_id',
					'child-primary-key' => 'meetings_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Meetings - App <span class="hidden child-label-meetings_table child-field-caption">(Visiting card details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 3 => 'Meeting title', 4 => 'Participants', 5 => 'Venue', 6 => 'Meeting from date', 7 => 'Meeting to date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'meetings_id', 3 => 'meeting_title', 4 => 'participants', 5 => 'venue', 6 => 'meeting_from_date', 7 => 'meeting_to_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`meetings_table`.`meetings_id`', 1 => '`visiting_card_table1`.`visiting_card_str`', 2 => '`event_table1`.`event_str`', 3 => 4, 4 => 5, 5 => 6, 6 => '`meetings_table`.`meeting_from_date`', 7 => '`meetings_table`.`meeting_to_date`', 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 7,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-meetings_table',
					'template-printable' => 'children-meetings_table-printable',
					'query' => "SELECT `meetings_table`.`meetings_id` as 'meetings_id', IF(    CHAR_LENGTH(`visiting_card_table1`.`visiting_card_str`), CONCAT_WS('',   `visiting_card_table1`.`visiting_card_str`), '') as 'visiting_card_lookup', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', `meetings_table`.`meeting_title` as 'meeting_title', `meetings_table`.`participants` as 'participants', `meetings_table`.`venue` as 'venue', if(`meetings_table`.`meeting_from_date`,date_format(`meetings_table`.`meeting_from_date`,'%d/%m/%Y'),'') as 'meeting_from_date', if(`meetings_table`.`meeting_to_date`,date_format(`meetings_table`.`meeting_to_date`,'%d/%m/%Y'),'') as 'meeting_to_date', `meetings_table`.`meeting_str` as 'meeting_str', `meetings_table`.`created_by` as 'created_by', `meetings_table`.`created_at` as 'created_at', `meetings_table`.`last_updated_by` as 'last_updated_by', `meetings_table`.`last_updated_at` as 'last_updated_at' FROM `meetings_table` LEFT JOIN `visiting_card_table` as visiting_card_table1 ON `visiting_card_table1`.`visiting_card_id`=`meetings_table`.`visiting_card_lookup` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`meetings_table`.`event_lookup` "
				],
				'event_lookup' => [
					'parent-table' => 'event_table',
					'parent-primary-key' => 'event_id',
					'child-primary-key' => 'meetings_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Meetings - App <span class="hidden child-label-meetings_table child-field-caption">(Event Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 3 => 'Meeting title', 4 => 'Participants', 5 => 'Venue', 6 => 'Meeting from date', 7 => 'Meeting to date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'meetings_id', 3 => 'meeting_title', 4 => 'participants', 5 => 'venue', 6 => 'meeting_from_date', 7 => 'meeting_to_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`meetings_table`.`meetings_id`', 1 => '`visiting_card_table1`.`visiting_card_str`', 2 => '`event_table1`.`event_str`', 3 => 4, 4 => 5, 5 => 6, 6 => '`meetings_table`.`meeting_from_date`', 7 => '`meetings_table`.`meeting_to_date`', 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 7,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-meetings_table',
					'template-printable' => 'children-meetings_table-printable',
					'query' => "SELECT `meetings_table`.`meetings_id` as 'meetings_id', IF(    CHAR_LENGTH(`visiting_card_table1`.`visiting_card_str`), CONCAT_WS('',   `visiting_card_table1`.`visiting_card_str`), '') as 'visiting_card_lookup', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', `meetings_table`.`meeting_title` as 'meeting_title', `meetings_table`.`participants` as 'participants', `meetings_table`.`venue` as 'venue', if(`meetings_table`.`meeting_from_date`,date_format(`meetings_table`.`meeting_from_date`,'%d/%m/%Y'),'') as 'meeting_from_date', if(`meetings_table`.`meeting_to_date`,date_format(`meetings_table`.`meeting_to_date`,'%d/%m/%Y'),'') as 'meeting_to_date', `meetings_table`.`meeting_str` as 'meeting_str', `meetings_table`.`created_by` as 'created_by', `meetings_table`.`created_at` as 'created_at', `meetings_table`.`last_updated_by` as 'last_updated_by', `meetings_table`.`last_updated_at` as 'last_updated_at' FROM `meetings_table` LEFT JOIN `visiting_card_table` as visiting_card_table1 ON `visiting_card_table1`.`visiting_card_id`=`meetings_table`.`visiting_card_lookup` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`meetings_table`.`event_lookup` "
				],
			],
			'agenda_table' => [
				'meeting_lookup' => [
					'parent-table' => 'meetings_table',
					'parent-primary-key' => 'meetings_id',
					'child-primary-key' => 'agenda_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Agenda table <span class="hidden child-label-agenda_table child-field-caption">(Meeting)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Meeting', 2 => 'Agenda description', 4 => 'Created by', 5 => 'Created at', 6 => 'Last updated by', 7 => 'Last updated at'],
					'display-field-names' => [0 => 'agenda_id', 1 => 'meeting_lookup', 2 => 'agenda_description', 4 => 'created_by', 5 => 'created_at', 6 => 'last_updated_by', 7 => 'last_updated_at'],
					'sortable-fields' => [0 => '`agenda_table`.`agenda_id`', 1 => '`meetings_table1`.`meeting_str`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8],
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-agenda_table',
					'template-printable' => 'children-agenda_table-printable',
					'query' => "SELECT `agenda_table`.`agenda_id` as 'agenda_id', IF(    CHAR_LENGTH(`meetings_table1`.`meeting_str`), CONCAT_WS('',   `meetings_table1`.`meeting_str`), '') as 'meeting_lookup', `agenda_table`.`agenda_description` as 'agenda_description', `agenda_table`.`agenda_str` as 'agenda_str', `agenda_table`.`created_by` as 'created_by', `agenda_table`.`created_at` as 'created_at', `agenda_table`.`last_updated_by` as 'last_updated_by', `agenda_table`.`last_updated_at` as 'last_updated_at' FROM `agenda_table` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`agenda_table`.`meeting_lookup` "
				],
			],
			'decision_table' => [
				'agenda_lookup' => [
					'parent-table' => 'agenda_table',
					'parent-primary-key' => 'agenda_id',
					'child-primary-key' => 'decision_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Decision - App <span class="hidden child-label-decision_table child-field-caption">(Agenda of Meeting)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Agenda of Meeting', 2 => 'Decision description', 3 => 'Decision actor', 4 => 'Action taken with date', 5 => 'Decision status', 6 => 'Decision status update date', 7 => 'Decision status remarks by superior', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'decision_id', 1 => 'agenda_lookup', 2 => 'decision_description', 3 => 'decision_actor', 4 => 'action_taken_with_date', 5 => 'decision_status', 6 => 'decision_status_update_date', 7 => 'decision_status_remarks_by_superior', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`decision_table`.`decision_id`', 1 => '`agenda_table1`.`agenda_str`', 2 => 3, 3 => 4, 4 => '`decision_table`.`action_taken_with_date`', 5 => 6, 6 => '`decision_table`.`decision_status_update_date`', 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-decision_table',
					'template-printable' => 'children-decision_table-printable',
					'query' => "SELECT `decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`agenda_table1`.`agenda_str`), CONCAT_WS('',   `agenda_table1`.`agenda_str`), '') as 'agenda_lookup', `decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`decision_table`.`action_taken_with_date`,date_format(`decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `decision_table`.`decision_status` as 'decision_status', if(`decision_table`.`decision_status_update_date`,date_format(`decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `decision_table`.`decision_str` as 'decision_str', `decision_table`.`created_by` as 'created_by', `decision_table`.`created_at` as 'created_at', `decision_table`.`last_updated_by` as 'last_updated_by', `decision_table`.`last_updated_at` as 'last_updated_at' FROM `decision_table` LEFT JOIN `agenda_table` as agenda_table1 ON `agenda_table1`.`agenda_id`=`decision_table`.`agenda_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`decision_table`.`decision_actor` "
				],
				'decision_actor' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'decision_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Agenda decision table <span class="hidden child-label-decision_table child-field-caption">(Decision actor)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Agenda of Meeting', 2 => 'Decision description', 3 => 'Decision actor', 4 => 'Action taken with date', 5 => 'Decision status', 6 => 'Decision status update date', 7 => 'Decision status remarks by superior', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'decision_id', 1 => 'agenda_lookup', 2 => 'decision_description', 3 => 'decision_actor', 4 => 'action_taken_with_date', 5 => 'decision_status', 6 => 'decision_status_update_date', 7 => 'decision_status_remarks_by_superior', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`decision_table`.`decision_id`', 1 => '`agenda_table1`.`agenda_str`', 2 => 3, 3 => 4, 4 => '`decision_table`.`action_taken_with_date`', 5 => 6, 6 => '`decision_table`.`decision_status_update_date`', 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-decision_table',
					'template-printable' => 'children-decision_table-printable',
					'query' => "SELECT `decision_table`.`decision_id` as 'decision_id', IF(    CHAR_LENGTH(`agenda_table1`.`agenda_str`), CONCAT_WS('',   `agenda_table1`.`agenda_str`), '') as 'agenda_lookup', `decision_table`.`decision_description` as 'decision_description', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'decision_actor', if(`decision_table`.`action_taken_with_date`,date_format(`decision_table`.`action_taken_with_date`,'%d/%m/%Y'),'') as 'action_taken_with_date', `decision_table`.`decision_status` as 'decision_status', if(`decision_table`.`decision_status_update_date`,date_format(`decision_table`.`decision_status_update_date`,'%d/%m/%Y'),'') as 'decision_status_update_date', `decision_table`.`decision_status_remarks_by_superior` as 'decision_status_remarks_by_superior', `decision_table`.`decision_str` as 'decision_str', `decision_table`.`created_by` as 'created_by', `decision_table`.`created_at` as 'created_at', `decision_table`.`last_updated_by` as 'last_updated_by', `decision_table`.`last_updated_at` as 'last_updated_at' FROM `decision_table` LEFT JOIN `agenda_table` as agenda_table1 ON `agenda_table1`.`agenda_id`=`decision_table`.`agenda_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`decision_table`.`decision_actor` "
				],
			],
			'participants_table' => [
				'event_lookup' => [
					'parent-table' => 'event_table',
					'parent-primary-key' => 'event_id',
					'child-primary-key' => 'participants_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Participants / Speaker / VIP List Table <span class="hidden child-label-participants_table child-field-caption">(Event)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Event', 2 => 'Meeting', 3 => 'Name', 4 => 'Designation', 5 => 'Participant type', 6 => 'Accepted status', 7 => 'Status date', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'participants_id', 1 => 'event_lookup', 2 => 'meeting_lookup', 3 => 'name', 4 => 'designation', 5 => 'participant_type', 6 => 'accepted_status', 7 => 'status_date', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`participants_table`.`participants_id`', 1 => '`event_table1`.`event_str`', 2 => '`meetings_table1`.`meeting_str`', 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => '`participants_table`.`status_date`', 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-participants_table',
					'template-printable' => 'children-participants_table-printable',
					'query' => "SELECT `participants_table`.`participants_id` as 'participants_id', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', IF(    CHAR_LENGTH(`meetings_table1`.`meeting_str`), CONCAT_WS('',   `meetings_table1`.`meeting_str`), '') as 'meeting_lookup', `participants_table`.`name` as 'name', `participants_table`.`designation` as 'designation', `participants_table`.`participant_type` as 'participant_type', `participants_table`.`accepted_status` as 'accepted_status', if(`participants_table`.`status_date`,date_format(`participants_table`.`status_date`,'%d/%m/%Y'),'') as 'status_date', `participants_table`.`created_by` as 'created_by', `participants_table`.`created_at` as 'created_at', `participants_table`.`last_updated_by` as 'last_updated_by', `participants_table`.`last_updated_at` as 'last_updated_at' FROM `participants_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`participants_table`.`event_lookup` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`participants_table`.`meeting_lookup` "
				],
				'meeting_lookup' => [
					'parent-table' => 'meetings_table',
					'parent-primary-key' => 'meetings_id',
					'child-primary-key' => 'participants_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Participants / Speaker / VIP List - App <span class="hidden child-label-participants_table child-field-caption">(Meeting)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Event', 2 => 'Meeting', 3 => 'Name', 4 => 'Designation', 5 => 'Participant type', 6 => 'Accepted status', 7 => 'Status date', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'participants_id', 1 => 'event_lookup', 2 => 'meeting_lookup', 3 => 'name', 4 => 'designation', 5 => 'participant_type', 6 => 'accepted_status', 7 => 'status_date', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`participants_table`.`participants_id`', 1 => '`event_table1`.`event_str`', 2 => '`meetings_table1`.`meeting_str`', 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => '`participants_table`.`status_date`', 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-participants_table',
					'template-printable' => 'children-participants_table-printable',
					'query' => "SELECT `participants_table`.`participants_id` as 'participants_id', IF(    CHAR_LENGTH(`event_table1`.`event_str`), CONCAT_WS('',   `event_table1`.`event_str`), '') as 'event_lookup', IF(    CHAR_LENGTH(`meetings_table1`.`meeting_str`), CONCAT_WS('',   `meetings_table1`.`meeting_str`), '') as 'meeting_lookup', `participants_table`.`name` as 'name', `participants_table`.`designation` as 'designation', `participants_table`.`participant_type` as 'participant_type', `participants_table`.`accepted_status` as 'accepted_status', if(`participants_table`.`status_date`,date_format(`participants_table`.`status_date`,'%d/%m/%Y'),'') as 'status_date', `participants_table`.`created_by` as 'created_by', `participants_table`.`created_at` as 'created_at', `participants_table`.`last_updated_by` as 'last_updated_by', `participants_table`.`last_updated_at` as 'last_updated_at' FROM `participants_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`participants_table`.`event_lookup` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`participants_table`.`meeting_lookup` "
				],
			],
			'action_actor' => [
				'actor' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'actor_ID',
					'child-primary-key-index' => 0,
					'tab-label' => 'Action actor <span class="hidden child-label-action_actor child-field-caption">(Actor)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 2 => 'Actor', 3 => 'Action status', 4 => 'Created by', 5 => 'Created at', 6 => 'Last updated by', 7 => 'Last updated at'],
					'display-field-names' => [0 => 'actor_ID', 2 => 'actor', 3 => 'action_status', 4 => 'created_by', 5 => 'created_at', 6 => 'last_updated_by', 7 => 'last_updated_at'],
					'sortable-fields' => [0 => 1, 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-action_actor',
					'template-printable' => 'children-action_actor-printable',
					'query' => "SELECT `action_actor`.`actor_ID` as 'actor_ID', `action_actor`.`action_str` as 'action_str', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'actor', `action_actor`.`action_status` as 'action_status', `action_actor`.`created_by` as 'created_by', `action_actor`.`created_at` as 'created_at', `action_actor`.`last_updated_by` as 'last_updated_by', `action_actor`.`last_updated_at` as 'last_updated_at' FROM `action_actor` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`action_actor`.`actor` "
				],
			],
			'visiting_card_table' => [
				'given_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'visiting_card_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Visiting card table <span class="hidden child-label-visiting_card_table child-field-caption">(Given by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Name', 2 => 'Recommended by', 3 => 'Designation', 4 => 'Company name', 5 => 'Mobile no', 6 => 'Email', 7 => 'Company website address', 8 => 'Given by', 9 => 'Suggested way forward', 10 => 'Front img', 11 => 'Back img', 13 => 'Created by', 14 => 'Created at', 15 => 'Last updated by', 16 => 'Last updated at'],
					'display-field-names' => [0 => 'visiting_card_id', 1 => 'name', 2 => 'recommended_by', 3 => 'designation', 4 => 'company_name', 5 => 'mobile_no', 6 => 'email', 7 => 'company_website_addr', 8 => 'given_by', 9 => 'suggested_way_forward', 10 => 'front_img', 11 => 'back_img', 13 => 'created_by', 14 => 'created_at', 15 => 'last_updated_by', 16 => 'last_updated_at'],
					'sortable-fields' => [0 => '`visiting_card_table`.`visiting_card_id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-visiting_card_table',
					'template-printable' => 'children-visiting_card_table-printable',
					'query' => "SELECT `visiting_card_table`.`visiting_card_id` as 'visiting_card_id', `visiting_card_table`.`name` as 'name', `visiting_card_table`.`recommended_by` as 'recommended_by', `visiting_card_table`.`designation` as 'designation', `visiting_card_table`.`company_name` as 'company_name', `visiting_card_table`.`mobile_no` as 'mobile_no', `visiting_card_table`.`email` as 'email', `visiting_card_table`.`company_website_addr` as 'company_website_addr', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'given_by', `visiting_card_table`.`suggested_way_forward` as 'suggested_way_forward', `visiting_card_table`.`front_img` as 'front_img', `visiting_card_table`.`back_img` as 'back_img', `visiting_card_table`.`visiting_card_str` as 'visiting_card_str', `visiting_card_table`.`created_by` as 'created_by', `visiting_card_table`.`created_at` as 'created_at', `visiting_card_table`.`last_updated_by` as 'last_updated_by', `visiting_card_table`.`last_updated_at` as 'last_updated_at' FROM `visiting_card_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`visiting_card_table`.`given_by` "
				],
			],
			'mou_details_table' => [
				'assigned_mou_to' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'MoU details - App <span class="hidden child-label-mou_details_table child-field-caption">(Assigned MoU to)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Type', 2 => 'Company name', 3 => 'Objectives/ Scope of the MOU', 4 => 'Agreement period (In Years)', 5 => 'Date of agreement', 6 => 'Date of expiry', 7 => 'Status', 8 => 'Point of contact (Name)', 9 => 'Contact number', 10 => 'Contact email id', 11 => 'Website link', 12 => 'Country', 13 => 'Assigned MoU to', 14 => 'Upload MoU (PDF or DOC format)', 15 => 'Created at', 16 => 'Created by', 17 => 'Last updated by', 18 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'type', 2 => 'company_name', 3 => 'objective_of_mou', 4 => 'agreement_period', 5 => 'date_of_agreement', 6 => 'date_of_expiry', 7 => 'status', 8 => 'point_of_contact', 9 => 'contact_number', 10 => 'contact_email_id', 11 => 'website_link', 12 => 'country', 13 => 'assigned_mou_to', 14 => 'upload_mou', 15 => 'created_at', 16 => 'created_by', 17 => 'last_updated_by', 18 => 'last_updated_at'],
					'sortable-fields' => [0 => '`mou_details_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => '`mou_details_table`.`date_of_agreement`', 6 => '`mou_details_table`.`date_of_expiry`', 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18, 18 => 19],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-mou_details_table',
					'template-printable' => 'children-mou_details_table-printable',
					'query' => "SELECT `mou_details_table`.`id` as 'id', `mou_details_table`.`type` as 'type', `mou_details_table`.`company_name` as 'company_name', `mou_details_table`.`objective_of_mou` as 'objective_of_mou', `mou_details_table`.`agreement_period` as 'agreement_period', if(`mou_details_table`.`date_of_agreement`,date_format(`mou_details_table`.`date_of_agreement`,'%d/%m/%Y'),'') as 'date_of_agreement', if(`mou_details_table`.`date_of_expiry`,date_format(`mou_details_table`.`date_of_expiry`,'%d/%m/%Y'),'') as 'date_of_expiry', `mou_details_table`.`status` as 'status', `mou_details_table`.`point_of_contact` as 'point_of_contact', `mou_details_table`.`contact_number` as 'contact_number', `mou_details_table`.`contact_email_id` as 'contact_email_id', `mou_details_table`.`website_link` as 'website_link', `mou_details_table`.`country` as 'country', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'assigned_mou_to', `mou_details_table`.`upload_mou` as 'upload_mou', `mou_details_table`.`created_at` as 'created_at', `mou_details_table`.`created_by` as 'created_by', `mou_details_table`.`last_updated_by` as 'last_updated_by', `mou_details_table`.`last_updated_at` as 'last_updated_at' FROM `mou_details_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`mou_details_table`.`assigned_mou_to` "
				],
			],
			'mou_company_area_details_table' => [
				'name_of_the_company' => [
					'parent-table' => 'mou_details_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'MoU company area details - App <span class="hidden child-label-mou_company_area_details_table child-field-caption">(Name of the company)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Name of the company', 2 => 'Area / Scope', 3 => 'Assigned MoU to', 4 => 'Remarks', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'name_of_the_company', 2 => 'area', 3 => 'assigned_mou_to', 4 => 'remarks', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`mou_company_area_details_table`.`id`', 1 => '`mou_details_table1`.`company_name`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-mou_company_area_details_table',
					'template-printable' => 'children-mou_company_area_details_table-printable',
					'query' => "SELECT `mou_company_area_details_table`.`id` as 'id', IF(    CHAR_LENGTH(`mou_details_table1`.`company_name`), CONCAT_WS('',   `mou_details_table1`.`company_name`), '') as 'name_of_the_company', `mou_company_area_details_table`.`area` as 'area', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'assigned_mou_to', `mou_company_area_details_table`.`remarks` as 'remarks', `mou_company_area_details_table`.`created_by` as 'created_by', `mou_company_area_details_table`.`created_at` as 'created_at', `mou_company_area_details_table`.`last_updated_by` as 'last_updated_by', `mou_company_area_details_table`.`last_updated_at` as 'last_updated_at' FROM `mou_company_area_details_table` LEFT JOIN `mou_details_table` as mou_details_table1 ON `mou_details_table1`.`id`=`mou_company_area_details_table`.`name_of_the_company` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`mou_company_area_details_table`.`assigned_mou_to` "
				],
				'assigned_mou_to' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'MoU company area details - App <span class="hidden child-label-mou_company_area_details_table child-field-caption">(Assigned MoU to)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Name of the company', 2 => 'Area / Scope', 3 => 'Assigned MoU to', 4 => 'Remarks', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'name_of_the_company', 2 => 'area', 3 => 'assigned_mou_to', 4 => 'remarks', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`mou_company_area_details_table`.`id`', 1 => '`mou_details_table1`.`company_name`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-mou_company_area_details_table',
					'template-printable' => 'children-mou_company_area_details_table-printable',
					'query' => "SELECT `mou_company_area_details_table`.`id` as 'id', IF(    CHAR_LENGTH(`mou_details_table1`.`company_name`), CONCAT_WS('',   `mou_details_table1`.`company_name`), '') as 'name_of_the_company', `mou_company_area_details_table`.`area` as 'area', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'assigned_mou_to', `mou_company_area_details_table`.`remarks` as 'remarks', `mou_company_area_details_table`.`created_by` as 'created_by', `mou_company_area_details_table`.`created_at` as 'created_at', `mou_company_area_details_table`.`last_updated_by` as 'last_updated_by', `mou_company_area_details_table`.`last_updated_at` as 'last_updated_at' FROM `mou_company_area_details_table` LEFT JOIN `mou_details_table` as mou_details_table1 ON `mou_details_table1`.`id`=`mou_company_area_details_table`.`name_of_the_company` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`mou_company_area_details_table`.`assigned_mou_to` "
				],
			],
			'goal_setting_table' => [
				'supervisor_name' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'goal_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal setting table <span class="hidden child-label-goal_setting_table child-field-caption">(Supervisor name)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Goal status', 2 => 'Goal description', 3 => 'Goal duration', 4 => 'Goal set date', 5 => 'Supervisor name', 6 => 'Assigned to', 7 => 'Goal setting str', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'goal_id', 1 => 'goal_status', 2 => 'goal_description', 3 => 'goal_duration', 4 => 'goal_set_date', 5 => 'supervisor_name', 6 => 'assigned_to', 7 => 'goal_setting_str', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`goal_setting_table`.`goal_id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`goal_setting_table`.`goal_set_date`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-goal_setting_table',
					'template-printable' => 'children-goal_setting_table-printable',
					'query' => "SELECT `goal_setting_table`.`goal_id` as 'goal_id', `goal_setting_table`.`goal_status` as 'goal_status', `goal_setting_table`.`goal_description` as 'goal_description', `goal_setting_table`.`goal_duration` as 'goal_duration', if(`goal_setting_table`.`goal_set_date`,date_format(`goal_setting_table`.`goal_set_date`,'%d/%m/%Y'),'') as 'goal_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `goal_setting_table`.`goal_setting_str` as 'goal_setting_str', `goal_setting_table`.`created_by` as 'created_by', `goal_setting_table`.`created_at` as 'created_at', `goal_setting_table`.`last_updated_by` as 'last_updated_by', `goal_setting_table`.`last_updated_at` as 'last_updated_at' FROM `goal_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`goal_setting_table`.`assigned_to` "
				],
				'assigned_to' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'goal_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal setting table <span class="hidden child-label-goal_setting_table child-field-caption">(Assigned to)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Goal status', 2 => 'Goal description', 3 => 'Goal duration', 4 => 'Goal set date', 5 => 'Supervisor name', 6 => 'Assigned to', 7 => 'Goal setting str', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'goal_id', 1 => 'goal_status', 2 => 'goal_description', 3 => 'goal_duration', 4 => 'goal_set_date', 5 => 'supervisor_name', 6 => 'assigned_to', 7 => 'goal_setting_str', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`goal_setting_table`.`goal_id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`goal_setting_table`.`goal_set_date`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-goal_setting_table',
					'template-printable' => 'children-goal_setting_table-printable',
					'query' => "SELECT `goal_setting_table`.`goal_id` as 'goal_id', `goal_setting_table`.`goal_status` as 'goal_status', `goal_setting_table`.`goal_description` as 'goal_description', `goal_setting_table`.`goal_duration` as 'goal_duration', if(`goal_setting_table`.`goal_set_date`,date_format(`goal_setting_table`.`goal_set_date`,'%d/%m/%Y'),'') as 'goal_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `goal_setting_table`.`goal_setting_str` as 'goal_setting_str', `goal_setting_table`.`created_by` as 'created_by', `goal_setting_table`.`created_at` as 'created_at', `goal_setting_table`.`last_updated_by` as 'last_updated_by', `goal_setting_table`.`last_updated_at` as 'last_updated_at' FROM `goal_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`goal_setting_table`.`assigned_to` "
				],
			],
			'goal_progress_table' => [
				'goal_lookup' => [
					'parent-table' => 'goal_setting_table',
					'parent-primary-key' => 'goal_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal progress table <span class="hidden child-label-goal_progress_table child-field-caption">(Goal details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Goal details', 2 => 'Goal progress', 3 => 'Remarks by', 4 => 'Remarks', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'goal_lookup', 2 => 'goal_progress', 3 => 'remarks_by', 4 => 'remarks', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`goal_progress_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-goal_progress_table',
					'template-printable' => 'children-goal_progress_table-printable',
					'query' => "SELECT `goal_progress_table`.`id` as 'id', IF(    CHAR_LENGTH(`goal_setting_table1`.`goal_description`) || CHAR_LENGTH(`goal_setting_table1`.`goal_duration`), CONCAT_WS('',   `goal_setting_table1`.`goal_description`, '::', `goal_setting_table1`.`goal_duration`), '') as 'goal_lookup', `goal_progress_table`.`goal_progress` as 'goal_progress', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'remarks_by', `goal_progress_table`.`remarks` as 'remarks', `goal_progress_table`.`created_by` as 'created_by', `goal_progress_table`.`created_at` as 'created_at', `goal_progress_table`.`last_updated_by` as 'last_updated_by', `goal_progress_table`.`last_updated_at` as 'last_updated_at' FROM `goal_progress_table` LEFT JOIN `goal_setting_table` as goal_setting_table1 ON `goal_setting_table1`.`goal_id`=`goal_progress_table`.`goal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_progress_table`.`remarks_by` "
				],
				'remarks_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal progress table <span class="hidden child-label-goal_progress_table child-field-caption">(Remarks by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Goal details', 2 => 'Goal progress', 3 => 'Remarks by', 4 => 'Remarks', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'goal_lookup', 2 => 'goal_progress', 3 => 'remarks_by', 4 => 'remarks', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`goal_progress_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-goal_progress_table',
					'template-printable' => 'children-goal_progress_table-printable',
					'query' => "SELECT `goal_progress_table`.`id` as 'id', IF(    CHAR_LENGTH(`goal_setting_table1`.`goal_description`) || CHAR_LENGTH(`goal_setting_table1`.`goal_duration`), CONCAT_WS('',   `goal_setting_table1`.`goal_description`, '::', `goal_setting_table1`.`goal_duration`), '') as 'goal_lookup', `goal_progress_table`.`goal_progress` as 'goal_progress', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'remarks_by', `goal_progress_table`.`remarks` as 'remarks', `goal_progress_table`.`created_by` as 'created_by', `goal_progress_table`.`created_at` as 'created_at', `goal_progress_table`.`last_updated_by` as 'last_updated_by', `goal_progress_table`.`last_updated_at` as 'last_updated_at' FROM `goal_progress_table` LEFT JOIN `goal_setting_table` as goal_setting_table1 ON `goal_setting_table1`.`goal_id`=`goal_progress_table`.`goal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_progress_table`.`remarks_by` "
				],
			],
			'task_setting_table' => [
				'supervisor_name' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'task_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal setting - App <span class="hidden child-label-task_setting_table child-field-caption">(Supervisor name)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Task status', 2 => 'Task description', 3 => 'Task duration', 4 => 'Task set date', 5 => 'Supervisor name', 6 => 'Assigned to', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'task_id', 1 => 'task_status', 2 => 'task_description', 3 => 'task_duration', 4 => 'task_set_date', 5 => 'supervisor_name', 6 => 'assigned_to', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`task_setting_table`.`task_id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`task_setting_table`.`task_set_date`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-task_setting_table',
					'template-printable' => 'children-task_setting_table-printable',
					'query' => "SELECT `task_setting_table`.`task_id` as 'task_id', `task_setting_table`.`task_status` as 'task_status', `task_setting_table`.`task_description` as 'task_description', `task_setting_table`.`task_duration` as 'task_duration', if(`task_setting_table`.`task_set_date`,date_format(`task_setting_table`.`task_set_date`,'%d/%m/%Y'),'') as 'task_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `task_setting_table`.`task_setting_str` as 'task_setting_str', `task_setting_table`.`created_by` as 'created_by', `task_setting_table`.`created_at` as 'created_at', `task_setting_table`.`last_updated_by` as 'last_updated_by', `task_setting_table`.`last_updated_at` as 'last_updated_at' FROM `task_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`task_setting_table`.`assigned_to` "
				],
				'assigned_to' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'task_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Goal setting - App <span class="hidden child-label-task_setting_table child-field-caption">(Assigned to)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Task status', 2 => 'Task description', 3 => 'Task duration', 4 => 'Task set date', 5 => 'Supervisor name', 6 => 'Assigned to', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'task_id', 1 => 'task_status', 2 => 'task_description', 3 => 'task_duration', 4 => 'task_set_date', 5 => 'supervisor_name', 6 => 'assigned_to', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`task_setting_table`.`task_id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`task_setting_table`.`task_set_date`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-task_setting_table',
					'template-printable' => 'children-task_setting_table-printable',
					'query' => "SELECT `task_setting_table`.`task_id` as 'task_id', `task_setting_table`.`task_status` as 'task_status', `task_setting_table`.`task_description` as 'task_description', `task_setting_table`.`task_duration` as 'task_duration', if(`task_setting_table`.`task_set_date`,date_format(`task_setting_table`.`task_set_date`,'%d/%m/%Y'),'') as 'task_set_date', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'assigned_to', `task_setting_table`.`task_setting_str` as 'task_setting_str', `task_setting_table`.`created_by` as 'created_by', `task_setting_table`.`created_at` as 'created_at', `task_setting_table`.`last_updated_by` as 'last_updated_by', `task_setting_table`.`last_updated_at` as 'last_updated_at' FROM `task_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`task_setting_table`.`assigned_to` "
				],
			],
			'subtask_setting_table' => [
				'task_lookup' => [
					'parent-table' => 'task_setting_table',
					'parent-primary-key' => 'task_id',
					'child-primary-key' => 'subtask_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Subtask setting - App <span class="hidden child-label-subtask_setting_table child-field-caption">(Task)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Task', 2 => 'Subtask status', 3 => 'Subtask description', 4 => 'Subtask duration', 5 => 'Subtask set date', 6 => 'Supervisor name', 7 => 'Assigned to', 8 => 'Subtask setting str', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'subtask_id', 1 => 'task_lookup', 2 => 'subtask_status', 3 => 'subtask_description', 4 => 'subtask_duration', 5 => 'subtask_set_date', 6 => 'supervisor_name', 7 => 'assigned_to', 8 => 'subtask_setting_str', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`subtask_setting_table`.`subtask_id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => '`subtask_setting_table`.`subtask_set_date`', 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-subtask_setting_table',
					'template-printable' => 'children-subtask_setting_table-printable',
					'query' => "SELECT `subtask_setting_table`.`subtask_id` as 'subtask_id', IF(    CHAR_LENGTH(`task_setting_table1`.`task_description`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `task_setting_table1`.`task_description`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'task_lookup', `subtask_setting_table`.`subtask_status` as 'subtask_status', `subtask_setting_table`.`subtask_description` as 'subtask_description', `subtask_setting_table`.`subtask_duration` as 'subtask_duration', if(`subtask_setting_table`.`subtask_set_date`,date_format(`subtask_setting_table`.`subtask_set_date`,'%d/%m/%Y'),'') as 'subtask_set_date', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table3`.`memberID`) || CHAR_LENGTH(`user_table3`.`name`), CONCAT_WS('',   `user_table3`.`memberID`, '::', `user_table3`.`name`), '') as 'assigned_to', `subtask_setting_table`.`subtask_setting_str` as 'subtask_setting_str', `subtask_setting_table`.`created_by` as 'created_by', `subtask_setting_table`.`created_at` as 'created_at', `subtask_setting_table`.`last_updated_by` as 'last_updated_by', `subtask_setting_table`.`last_updated_at` as 'last_updated_at' FROM `subtask_setting_table` LEFT JOIN `task_setting_table` as task_setting_table1 ON `task_setting_table1`.`task_id`=`subtask_setting_table`.`task_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table1`.`assigned_to` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`subtask_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table3 ON `user_table3`.`user_id`=`subtask_setting_table`.`assigned_to` "
				],
				'supervisor_name' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'subtask_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Task setting - App <span class="hidden child-label-subtask_setting_table child-field-caption">(Supervisor name)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Task', 2 => 'Subtask status', 3 => 'Subtask description', 4 => 'Subtask duration', 5 => 'Subtask set date', 6 => 'Supervisor name', 7 => 'Assigned to', 8 => 'Subtask setting str', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'subtask_id', 1 => 'task_lookup', 2 => 'subtask_status', 3 => 'subtask_description', 4 => 'subtask_duration', 5 => 'subtask_set_date', 6 => 'supervisor_name', 7 => 'assigned_to', 8 => 'subtask_setting_str', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`subtask_setting_table`.`subtask_id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => '`subtask_setting_table`.`subtask_set_date`', 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-subtask_setting_table',
					'template-printable' => 'children-subtask_setting_table-printable',
					'query' => "SELECT `subtask_setting_table`.`subtask_id` as 'subtask_id', IF(    CHAR_LENGTH(`task_setting_table1`.`task_description`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `task_setting_table1`.`task_description`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'task_lookup', `subtask_setting_table`.`subtask_status` as 'subtask_status', `subtask_setting_table`.`subtask_description` as 'subtask_description', `subtask_setting_table`.`subtask_duration` as 'subtask_duration', if(`subtask_setting_table`.`subtask_set_date`,date_format(`subtask_setting_table`.`subtask_set_date`,'%d/%m/%Y'),'') as 'subtask_set_date', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table3`.`memberID`) || CHAR_LENGTH(`user_table3`.`name`), CONCAT_WS('',   `user_table3`.`memberID`, '::', `user_table3`.`name`), '') as 'assigned_to', `subtask_setting_table`.`subtask_setting_str` as 'subtask_setting_str', `subtask_setting_table`.`created_by` as 'created_by', `subtask_setting_table`.`created_at` as 'created_at', `subtask_setting_table`.`last_updated_by` as 'last_updated_by', `subtask_setting_table`.`last_updated_at` as 'last_updated_at' FROM `subtask_setting_table` LEFT JOIN `task_setting_table` as task_setting_table1 ON `task_setting_table1`.`task_id`=`subtask_setting_table`.`task_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table1`.`assigned_to` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`subtask_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table3 ON `user_table3`.`user_id`=`subtask_setting_table`.`assigned_to` "
				],
				'assigned_to' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'subtask_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Task setting - App <span class="hidden child-label-subtask_setting_table child-field-caption">(Assigned to)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Task', 2 => 'Subtask status', 3 => 'Subtask description', 4 => 'Subtask duration', 5 => 'Subtask set date', 6 => 'Supervisor name', 7 => 'Assigned to', 8 => 'Subtask setting str', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'subtask_id', 1 => 'task_lookup', 2 => 'subtask_status', 3 => 'subtask_description', 4 => 'subtask_duration', 5 => 'subtask_set_date', 6 => 'supervisor_name', 7 => 'assigned_to', 8 => 'subtask_setting_str', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`subtask_setting_table`.`subtask_id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => '`subtask_setting_table`.`subtask_set_date`', 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-subtask_setting_table',
					'template-printable' => 'children-subtask_setting_table-printable',
					'query' => "SELECT `subtask_setting_table`.`subtask_id` as 'subtask_id', IF(    CHAR_LENGTH(`task_setting_table1`.`task_description`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `task_setting_table1`.`task_description`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'task_lookup', `subtask_setting_table`.`subtask_status` as 'subtask_status', `subtask_setting_table`.`subtask_description` as 'subtask_description', `subtask_setting_table`.`subtask_duration` as 'subtask_duration', if(`subtask_setting_table`.`subtask_set_date`,date_format(`subtask_setting_table`.`subtask_set_date`,'%d/%m/%Y'),'') as 'subtask_set_date', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'supervisor_name', IF(    CHAR_LENGTH(`user_table3`.`memberID`) || CHAR_LENGTH(`user_table3`.`name`), CONCAT_WS('',   `user_table3`.`memberID`, '::', `user_table3`.`name`), '') as 'assigned_to', `subtask_setting_table`.`subtask_setting_str` as 'subtask_setting_str', `subtask_setting_table`.`created_by` as 'created_by', `subtask_setting_table`.`created_at` as 'created_at', `subtask_setting_table`.`last_updated_by` as 'last_updated_by', `subtask_setting_table`.`last_updated_at` as 'last_updated_at' FROM `subtask_setting_table` LEFT JOIN `task_setting_table` as task_setting_table1 ON `task_setting_table1`.`task_id`=`subtask_setting_table`.`task_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_setting_table1`.`assigned_to` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`subtask_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table3 ON `user_table3`.`user_id`=`subtask_setting_table`.`assigned_to` "
				],
			],
			'internship_fellowship_details_app' => [
			],
			'star_pnt' => [
				'iittnif_id' => [
					'parent-table' => 'internship_fellowship_details_app',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Star-PNT - APP <span class="hidden child-label-star_pnt child-field-caption">(IITTNiF id)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'IITTNiF id', 2 => 'Name of the Candidate', 3 => 'Institute', 4 => 'Workspace', 5 => 'Year and department', 6 => 'Project title', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'iittnif_id', 2 => 'name_of_the_candidate', 3 => 'institute', 4 => 'workspace', 5 => 'year_and_department', 6 => 'project_title', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`star_pnt`.`id`', 1 => '`internship_fellowship_details_app1`.`iittnif_id`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-star_pnt',
					'template-printable' => 'children-star_pnt-printable',
					'query' => "SELECT `star_pnt`.`id` as 'id', IF(    CHAR_LENGTH(`internship_fellowship_details_app1`.`iittnif_id`), CONCAT_WS('',   `internship_fellowship_details_app1`.`iittnif_id`), '') as 'iittnif_id', `star_pnt`.`name_of_the_candidate` as 'name_of_the_candidate', `star_pnt`.`institute` as 'institute', `star_pnt`.`workspace` as 'workspace', `star_pnt`.`year_and_department` as 'year_and_department', `star_pnt`.`project_title` as 'project_title', `star_pnt`.`created_by` as 'created_by', `star_pnt`.`created_at` as 'created_at', `star_pnt`.`last_updated_by` as 'last_updated_by', `star_pnt`.`last_updated_at` as 'last_updated_at' FROM `star_pnt` LEFT JOIN `internship_fellowship_details_app` as internship_fellowship_details_app1 ON `internship_fellowship_details_app1`.`id`=`star_pnt`.`iittnif_id` "
				],
			],
			'hrd_sdp_events_table' => [
			],
			'training_program_on_geospatial_tchnologies_table' => [
			],
			'space_day_school_details_app' => [
			],
			'space_day_college_student_table' => [
			],
			'school_list' => [
			],
			'sdp_participants_college_details_table' => [
			],
			'asset_table' => [
			],
			'asset_allotment_table' => [
				'asset_details' => [
					'parent-table' => 'asset_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset Allotment - App <span class="hidden child-label-asset_allotment_table child-field-caption">(Asset Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Asset Details', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'asset_details', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`asset_allotment_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`asset_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`asset_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-asset_allotment_table',
					'template-printable' => 'children-asset_allotment_table-printable',
					'query' => "SELECT `asset_allotment_table`.`id` as 'id', IF(    CHAR_LENGTH(`asset_table1`.`ClassificationofAssest`) || CHAR_LENGTH(`asset_table1`.`ItemDescription`), CONCAT_WS('',   `asset_table1`.`ClassificationofAssest`, '::', `asset_table1`.`ItemDescription`), '') as 'asset_details', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `asset_allotment_table`.`department` as 'department', if(`asset_allotment_table`.`date`,date_format(`asset_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `asset_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `asset_allotment_table`.`status` as 'status', if(`asset_allotment_table`.`returned_date`,date_format(`asset_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `asset_allotment_table`.`created_by` as 'created_by', `asset_allotment_table`.`created_at` as 'created_at', `asset_allotment_table`.`last_updated_by` as 'last_updated_by', `asset_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `asset_allotment_table` LEFT JOIN `asset_table` as asset_table1 ON `asset_table1`.`id`=`asset_allotment_table`.`asset_details` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`asset_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`asset_allotment_table`.`alloted_by` "
				],
				'select_employee' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset Allotment - App <span class="hidden child-label-asset_allotment_table child-field-caption">(Select employee)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Asset Details', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'asset_details', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`asset_allotment_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`asset_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`asset_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-asset_allotment_table',
					'template-printable' => 'children-asset_allotment_table-printable',
					'query' => "SELECT `asset_allotment_table`.`id` as 'id', IF(    CHAR_LENGTH(`asset_table1`.`ClassificationofAssest`) || CHAR_LENGTH(`asset_table1`.`ItemDescription`), CONCAT_WS('',   `asset_table1`.`ClassificationofAssest`, '::', `asset_table1`.`ItemDescription`), '') as 'asset_details', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `asset_allotment_table`.`department` as 'department', if(`asset_allotment_table`.`date`,date_format(`asset_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `asset_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `asset_allotment_table`.`status` as 'status', if(`asset_allotment_table`.`returned_date`,date_format(`asset_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `asset_allotment_table`.`created_by` as 'created_by', `asset_allotment_table`.`created_at` as 'created_at', `asset_allotment_table`.`last_updated_by` as 'last_updated_by', `asset_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `asset_allotment_table` LEFT JOIN `asset_table` as asset_table1 ON `asset_table1`.`id`=`asset_allotment_table`.`asset_details` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`asset_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`asset_allotment_table`.`alloted_by` "
				],
				'alloted_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset Allotment - App <span class="hidden child-label-asset_allotment_table child-field-caption">(Alloted by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Asset Details', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'asset_details', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`asset_allotment_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`asset_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`asset_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-asset_allotment_table',
					'template-printable' => 'children-asset_allotment_table-printable',
					'query' => "SELECT `asset_allotment_table`.`id` as 'id', IF(    CHAR_LENGTH(`asset_table1`.`ClassificationofAssest`) || CHAR_LENGTH(`asset_table1`.`ItemDescription`), CONCAT_WS('',   `asset_table1`.`ClassificationofAssest`, '::', `asset_table1`.`ItemDescription`), '') as 'asset_details', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `asset_allotment_table`.`department` as 'department', if(`asset_allotment_table`.`date`,date_format(`asset_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `asset_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `asset_allotment_table`.`status` as 'status', if(`asset_allotment_table`.`returned_date`,date_format(`asset_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `asset_allotment_table`.`created_by` as 'created_by', `asset_allotment_table`.`created_at` as 'created_at', `asset_allotment_table`.`last_updated_by` as 'last_updated_by', `asset_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `asset_allotment_table` LEFT JOIN `asset_table` as asset_table1 ON `asset_table1`.`id`=`asset_allotment_table`.`asset_details` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`asset_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`asset_allotment_table`.`alloted_by` "
				],
			],
			'it_inventory_app' => [
				'sactioned_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'it_inventory_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset - App <span class="hidden child-label-it_inventory_app child-field-caption">(Sactioned by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Date', 2 => 'Description', 3 => 'Classification of asset', 4 => 'Sub category', 5 => 'Qty', 6 => 'Asset serial number', 7 => 'Qr and bar code', 8 => 'Custody department', 9 => 'Custodian', 10 => 'Custodian signature', 11 => 'Number of years useful life of assets', 12 => 'Date of useful life of assets ends', 13 => 'Remarks', 14 => 'Sactioned by', 15 => 'It inventory str', 16 => 'Created by', 17 => 'Created at', 18 => 'Last updated by', 19 => 'Last updated at'],
					'display-field-names' => [0 => 'it_inventory_id', 1 => 'date', 2 => 'description', 3 => 'classification_of_asset', 4 => 'sub_category', 5 => 'qty', 6 => 'asset_serial_number', 7 => 'qr_and_bar_code', 8 => 'custody_department', 9 => 'custodian', 10 => 'custodian_signature', 11 => 'no_of_years_useful_life_of_assets', 12 => 'date_of_useful_life_of_assets_ends', 13 => 'remarks', 14 => 'sactioned_by', 15 => 'it_inventory_str', 16 => 'created_by', 17 => 'created_at', 18 => 'last_updated_by', 19 => 'last_updated_at'],
					'sortable-fields' => [0 => '`it_inventory_app`.`it_inventory_id`', 1 => '`it_inventory_app`.`date`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => '`it_inventory_app`.`date_of_useful_life_of_assets_ends`', 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18, 18 => 19, 19 => 20],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-it_inventory_app',
					'template-printable' => 'children-it_inventory_app-printable',
					'query' => "SELECT `it_inventory_app`.`it_inventory_id` as 'it_inventory_id', if(`it_inventory_app`.`date`,date_format(`it_inventory_app`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_app`.`description` as 'description', `it_inventory_app`.`classification_of_asset` as 'classification_of_asset', `it_inventory_app`.`sub_category` as 'sub_category', `it_inventory_app`.`qty` as 'qty', `it_inventory_app`.`asset_serial_number` as 'asset_serial_number', `it_inventory_app`.`qr_and_bar_code` as 'qr_and_bar_code', `it_inventory_app`.`custody_department` as 'custody_department', `it_inventory_app`.`custodian` as 'custodian', `it_inventory_app`.`custodian_signature` as 'custodian_signature', `it_inventory_app`.`no_of_years_useful_life_of_assets` as 'no_of_years_useful_life_of_assets', if(`it_inventory_app`.`date_of_useful_life_of_assets_ends`,date_format(`it_inventory_app`.`date_of_useful_life_of_assets_ends`,'%d/%m/%Y'),'') as 'date_of_useful_life_of_assets_ends', `it_inventory_app`.`remarks` as 'remarks', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'sactioned_by', `it_inventory_app`.`it_inventory_str` as 'it_inventory_str', `it_inventory_app`.`created_by` as 'created_by', `it_inventory_app`.`created_at` as 'created_at', `it_inventory_app`.`last_updated_by` as 'last_updated_by', `it_inventory_app`.`last_updated_at` as 'last_updated_at' FROM `it_inventory_app` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_app`.`sactioned_by` "
				],
			],
			'it_inventory_billing_details' => [
				'it_inventory_lookup' => [
					'parent-table' => 'it_inventory_app',
					'parent-primary-key' => 'it_inventory_id',
					'child-primary-key' => 'it_inventory_biling_details_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'IT inventory billing details - App <span class="hidden child-label-it_inventory_billing_details child-field-caption">(IT inventory )</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'IT inventory ', 2 => 'PO Number', 3 => 'PO Date', 4 => 'Particulars of supplier', 5 => 'Item description', 6 => 'Bill no', 7 => 'Bill date', 8 => 'Quantity', 9 => 'Total invoice value', 10 => 'Cost of the asset', 11 => 'Image', 12 => 'Created by', 13 => 'Created at', 14 => 'Last updated by', 15 => 'Last updated at'],
					'display-field-names' => [0 => 'it_inventory_biling_details_id', 1 => 'it_inventory_lookup', 2 => 'po_no', 3 => 'po_date', 4 => 'particulars_of_supplier', 5 => 'item_description', 6 => 'bill_no', 7 => 'bill_date', 8 => 'quantity', 9 => 'total_invoice_value', 10 => 'cost_of_the_asset', 11 => 'image', 12 => 'created_by', 13 => 'created_at', 14 => 'last_updated_by', 15 => 'last_updated_at'],
					'sortable-fields' => [0 => '`it_inventory_billing_details`.`it_inventory_biling_details_id`', 1 => 2, 2 => 3, 3 => '`it_inventory_billing_details`.`po_date`', 4 => 5, 5 => 6, 6 => 7, 7 => '`it_inventory_billing_details`.`bill_date`', 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-it_inventory_billing_details',
					'template-printable' => 'children-it_inventory_billing_details-printable',
					'query' => "SELECT `it_inventory_billing_details`.`it_inventory_biling_details_id` as 'it_inventory_biling_details_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`, '::'), '') as 'it_inventory_lookup', `it_inventory_billing_details`.`po_no` as 'po_no', if(`it_inventory_billing_details`.`po_date`,date_format(`it_inventory_billing_details`.`po_date`,'%d/%m/%Y'),'') as 'po_date', `it_inventory_billing_details`.`particulars_of_supplier` as 'particulars_of_supplier', `it_inventory_billing_details`.`item_description` as 'item_description', `it_inventory_billing_details`.`bill_no` as 'bill_no', if(`it_inventory_billing_details`.`bill_date`,date_format(`it_inventory_billing_details`.`bill_date`,'%d/%m/%Y'),'') as 'bill_date', `it_inventory_billing_details`.`quantity` as 'quantity', `it_inventory_billing_details`.`total_invoice_value` as 'total_invoice_value', `it_inventory_billing_details`.`cost_of_the_asset` as 'cost_of_the_asset', `it_inventory_billing_details`.`image` as 'image', `it_inventory_billing_details`.`created_by` as 'created_by', `it_inventory_billing_details`.`created_at` as 'created_at', `it_inventory_billing_details`.`last_updated_by` as 'last_updated_by', `it_inventory_billing_details`.`last_updated_at` as 'last_updated_at' FROM `it_inventory_billing_details` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_billing_details`.`it_inventory_lookup` "
				],
			],
			'it_inventory_allotment_table' => [
				'it_inventory_lookup' => [
					'parent-table' => 'it_inventory_app',
					'parent-primary-key' => 'it_inventory_id',
					'child-primary-key' => 'it_inventory_allotment_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'IT inventory allotment - App <span class="hidden child-label-it_inventory_allotment_table child-field-caption">(IT inventory )</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'IT inventory ', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'it_inventory_allotment_id', 1 => 'it_inventory_lookup', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`it_inventory_allotment_table`.`it_inventory_allotment_id`', 1 => '`it_inventory_app1`.`it_inventory_str`', 2 => 3, 3 => 4, 4 => '`it_inventory_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`it_inventory_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-it_inventory_allotment_table',
					'template-printable' => 'children-it_inventory_allotment_table-printable',
					'query' => "SELECT `it_inventory_allotment_table`.`it_inventory_allotment_id` as 'it_inventory_allotment_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`), '') as 'it_inventory_lookup', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `it_inventory_allotment_table`.`department` as 'department', if(`it_inventory_allotment_table`.`date`,date_format(`it_inventory_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `it_inventory_allotment_table`.`status` as 'status', if(`it_inventory_allotment_table`.`returned_date`,date_format(`it_inventory_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `it_inventory_allotment_table`.`created_by` as 'created_by', `it_inventory_allotment_table`.`created_at` as 'created_at', `it_inventory_allotment_table`.`last_updated_by` as 'last_updated_by', `it_inventory_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `it_inventory_allotment_table` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_allotment_table`.`it_inventory_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`it_inventory_allotment_table`.`alloted_by` "
				],
				'select_employee' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'it_inventory_allotment_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset allotment - App <span class="hidden child-label-it_inventory_allotment_table child-field-caption">(Select employee)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'IT inventory ', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'it_inventory_allotment_id', 1 => 'it_inventory_lookup', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`it_inventory_allotment_table`.`it_inventory_allotment_id`', 1 => '`it_inventory_app1`.`it_inventory_str`', 2 => 3, 3 => 4, 4 => '`it_inventory_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`it_inventory_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-it_inventory_allotment_table',
					'template-printable' => 'children-it_inventory_allotment_table-printable',
					'query' => "SELECT `it_inventory_allotment_table`.`it_inventory_allotment_id` as 'it_inventory_allotment_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`), '') as 'it_inventory_lookup', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `it_inventory_allotment_table`.`department` as 'department', if(`it_inventory_allotment_table`.`date`,date_format(`it_inventory_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `it_inventory_allotment_table`.`status` as 'status', if(`it_inventory_allotment_table`.`returned_date`,date_format(`it_inventory_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `it_inventory_allotment_table`.`created_by` as 'created_by', `it_inventory_allotment_table`.`created_at` as 'created_at', `it_inventory_allotment_table`.`last_updated_by` as 'last_updated_by', `it_inventory_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `it_inventory_allotment_table` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_allotment_table`.`it_inventory_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`it_inventory_allotment_table`.`alloted_by` "
				],
				'alloted_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'it_inventory_allotment_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Asset allotment - App <span class="hidden child-label-it_inventory_allotment_table child-field-caption">(Alloted by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'IT inventory ', 2 => 'Select employee', 3 => 'Department', 4 => 'Date', 5 => 'Purpose', 6 => 'Alloted by', 7 => 'Status', 8 => 'Returned date', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'it_inventory_allotment_id', 1 => 'it_inventory_lookup', 2 => 'select_employee', 3 => 'department', 4 => 'date', 5 => 'purpose', 6 => 'alloted_by', 7 => 'status', 8 => 'returned_date', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`it_inventory_allotment_table`.`it_inventory_allotment_id`', 1 => '`it_inventory_app1`.`it_inventory_str`', 2 => 3, 3 => 4, 4 => '`it_inventory_allotment_table`.`date`', 5 => 6, 6 => 7, 7 => 8, 8 => '`it_inventory_allotment_table`.`returned_date`', 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-it_inventory_allotment_table',
					'template-printable' => 'children-it_inventory_allotment_table-printable',
					'query' => "SELECT `it_inventory_allotment_table`.`it_inventory_allotment_id` as 'it_inventory_allotment_id', IF(    CHAR_LENGTH(`it_inventory_app1`.`it_inventory_str`), CONCAT_WS('',   `it_inventory_app1`.`it_inventory_str`), '') as 'it_inventory_lookup', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `it_inventory_allotment_table`.`department` as 'department', if(`it_inventory_allotment_table`.`date`,date_format(`it_inventory_allotment_table`.`date`,'%d/%m/%Y'),'') as 'date', `it_inventory_allotment_table`.`purpose` as 'purpose', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'alloted_by', `it_inventory_allotment_table`.`status` as 'status', if(`it_inventory_allotment_table`.`returned_date`,date_format(`it_inventory_allotment_table`.`returned_date`,'%d/%m/%Y'),'') as 'returned_date', `it_inventory_allotment_table`.`created_by` as 'created_by', `it_inventory_allotment_table`.`created_at` as 'created_at', `it_inventory_allotment_table`.`last_updated_by` as 'last_updated_by', `it_inventory_allotment_table`.`last_updated_at` as 'last_updated_at' FROM `it_inventory_allotment_table` LEFT JOIN `it_inventory_app` as it_inventory_app1 ON `it_inventory_app1`.`it_inventory_id`=`it_inventory_allotment_table`.`it_inventory_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_allotment_table`.`select_employee` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`it_inventory_allotment_table`.`alloted_by` "
				],
			],
			'computer_details_table' => [
			],
			'computer_usage_table' => [
				'pc_id' => [
					'parent-table' => 'computer_details_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Computer usage <span class="hidden child-label-computer_usage_table child-field-caption">(Pc ID)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Pc ID', 2 => 'Name of user', 3 => 'Role', 4 => 'From date', 5 => 'To date', 6 => 'Purpose', 7 => 'Email ID', 8 => 'Mobile number', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'pc_id', 2 => 'name_of_user', 3 => 'role', 4 => 'from_date', 5 => 'to_date', 6 => 'purpose', 7 => 'email_d', 8 => 'mobile_number', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`computer_usage_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`computer_usage_table`.`from_date`', 5 => '`computer_usage_table`.`to_date`', 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-computer_usage_table',
					'template-printable' => 'children-computer_usage_table-printable',
					'query' => "SELECT `computer_usage_table`.`id` as 'id', IF(    CHAR_LENGTH(`computer_details_table1`.`pc_number`) || CHAR_LENGTH(`computer_details_table1`.`pc_hostname`), CONCAT_WS('',   `computer_details_table1`.`pc_number`, '::', `computer_details_table1`.`pc_hostname`), '') as 'pc_id', `computer_usage_table`.`name_of_user` as 'name_of_user', `computer_usage_table`.`role` as 'role', if(`computer_usage_table`.`from_date`,date_format(`computer_usage_table`.`from_date`,'%d/%m/%Y %H:%i'),'') as 'from_date', if(`computer_usage_table`.`to_date`,date_format(`computer_usage_table`.`to_date`,'%d/%m/%Y %H:%i'),'') as 'to_date', `computer_usage_table`.`purpose` as 'purpose', `computer_usage_table`.`email_d` as 'email_d', `computer_usage_table`.`mobile_number` as 'mobile_number', `computer_usage_table`.`created_by` as 'created_by', `computer_usage_table`.`created_at` as 'created_at', `computer_usage_table`.`last_updated_by` as 'last_updated_by', `computer_usage_table`.`last_updated_at` as 'last_updated_at' FROM `computer_usage_table` LEFT JOIN `computer_details_table` as computer_details_table1 ON `computer_details_table1`.`id`=`computer_usage_table`.`pc_id` "
				],
			],
			'employees_personal_data_table' => [
			],
			'employees_designation_table' => [
				'employee_lookup' => [
					'parent-table' => 'employees_personal_data_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees designation table <span class="hidden child-label-employees_designation_table child-field-caption">(Employee Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employee Details', 2 => 'Designation', 3 => 'Date of appointment to designation', 4 => 'Active status', 5 => 'Reporting Officer', 6 => 'Reviewing Officer', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employee_lookup', 2 => 'designation', 3 => 'date_of_appointment_to_designation', 4 => 'active_status', 5 => 'reporting_officer', 6 => 'reviewing_officer', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_designation_table`.`id`', 1 => 2, 2 => 3, 3 => '`employees_designation_table`.`date_of_appointment_to_designation`', 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_designation_table',
					'template-printable' => 'children-employees_designation_table-printable',
					'query' => "SELECT `employees_designation_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_personal_data_table1`.`name`) || CHAR_LENGTH(`employees_personal_data_table1`.`emp_id`), CONCAT_WS('',   `employees_personal_data_table1`.`name`, '::', `employees_personal_data_table1`.`emp_id`), '') as 'employee_lookup', `employees_designation_table`.`designation` as 'designation', if(`employees_designation_table`.`date_of_appointment_to_designation`,date_format(`employees_designation_table`.`date_of_appointment_to_designation`,'%d/%m/%Y'),'') as 'date_of_appointment_to_designation', `employees_designation_table`.`active_status` as 'active_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_officer', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_designation_table`.`created_by` as 'created_by', `employees_designation_table`.`created_at` as 'created_at', `employees_designation_table`.`last_updated_by` as 'last_updated_by', `employees_designation_table`.`last_updated_at` as 'last_updated_at', `employees_designation_table`.`employees_designation_str` as 'employees_designation_str' FROM `employees_designation_table` LEFT JOIN `employees_personal_data_table` as employees_personal_data_table1 ON `employees_personal_data_table1`.`id`=`employees_designation_table`.`employee_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_designation_table`.`reviewing_officer` "
				],
				'reporting_officer' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees designation & Reporting - App <span class="hidden child-label-employees_designation_table child-field-caption">(Reporting Officer)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employee Details', 2 => 'Designation', 3 => 'Date of appointment to designation', 4 => 'Active status', 5 => 'Reporting Officer', 6 => 'Reviewing Officer', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employee_lookup', 2 => 'designation', 3 => 'date_of_appointment_to_designation', 4 => 'active_status', 5 => 'reporting_officer', 6 => 'reviewing_officer', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_designation_table`.`id`', 1 => 2, 2 => 3, 3 => '`employees_designation_table`.`date_of_appointment_to_designation`', 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_designation_table',
					'template-printable' => 'children-employees_designation_table-printable',
					'query' => "SELECT `employees_designation_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_personal_data_table1`.`name`) || CHAR_LENGTH(`employees_personal_data_table1`.`emp_id`), CONCAT_WS('',   `employees_personal_data_table1`.`name`, '::', `employees_personal_data_table1`.`emp_id`), '') as 'employee_lookup', `employees_designation_table`.`designation` as 'designation', if(`employees_designation_table`.`date_of_appointment_to_designation`,date_format(`employees_designation_table`.`date_of_appointment_to_designation`,'%d/%m/%Y'),'') as 'date_of_appointment_to_designation', `employees_designation_table`.`active_status` as 'active_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_officer', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_designation_table`.`created_by` as 'created_by', `employees_designation_table`.`created_at` as 'created_at', `employees_designation_table`.`last_updated_by` as 'last_updated_by', `employees_designation_table`.`last_updated_at` as 'last_updated_at', `employees_designation_table`.`employees_designation_str` as 'employees_designation_str' FROM `employees_designation_table` LEFT JOIN `employees_personal_data_table` as employees_personal_data_table1 ON `employees_personal_data_table1`.`id`=`employees_designation_table`.`employee_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_designation_table`.`reviewing_officer` "
				],
				'reviewing_officer' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees designation & Reporting - App <span class="hidden child-label-employees_designation_table child-field-caption">(Reviewing Officer)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employee Details', 2 => 'Designation', 3 => 'Date of appointment to designation', 4 => 'Active status', 5 => 'Reporting Officer', 6 => 'Reviewing Officer', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employee_lookup', 2 => 'designation', 3 => 'date_of_appointment_to_designation', 4 => 'active_status', 5 => 'reporting_officer', 6 => 'reviewing_officer', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_designation_table`.`id`', 1 => 2, 2 => 3, 3 => '`employees_designation_table`.`date_of_appointment_to_designation`', 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_designation_table',
					'template-printable' => 'children-employees_designation_table-printable',
					'query' => "SELECT `employees_designation_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_personal_data_table1`.`name`) || CHAR_LENGTH(`employees_personal_data_table1`.`emp_id`), CONCAT_WS('',   `employees_personal_data_table1`.`name`, '::', `employees_personal_data_table1`.`emp_id`), '') as 'employee_lookup', `employees_designation_table`.`designation` as 'designation', if(`employees_designation_table`.`date_of_appointment_to_designation`,date_format(`employees_designation_table`.`date_of_appointment_to_designation`,'%d/%m/%Y'),'') as 'date_of_appointment_to_designation', `employees_designation_table`.`active_status` as 'active_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_officer', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_designation_table`.`created_by` as 'created_by', `employees_designation_table`.`created_at` as 'created_at', `employees_designation_table`.`last_updated_by` as 'last_updated_by', `employees_designation_table`.`last_updated_at` as 'last_updated_at', `employees_designation_table`.`employees_designation_str` as 'employees_designation_str' FROM `employees_designation_table` LEFT JOIN `employees_personal_data_table` as employees_personal_data_table1 ON `employees_personal_data_table1`.`id`=`employees_designation_table`.`employee_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_designation_table`.`reviewing_officer` "
				],
			],
			'employees_appraisal_table' => [
				'employee_designation_lookup' => [
					'parent-table' => 'employees_designation_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees Appraisal  - App <span class="hidden child-label-employees_appraisal_table child-field-caption">(Employee Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employee Details', 2 => 'Current review period', 3 => 'Roles & Responsibilities', 4 => 'Employee Self-explanation', 5 => 'Upload file 1', 6 => 'Upload file 2', 7 => 'Upload file 3', 8 => 'Reporting Officer Feedback on the Employee Responsibilities', 9 => 'Observations by the Reporting Officer', 10 => 'Overall Rating by the Reporting Officer', 11 => 'Appraisal Feedback Status by Reporting Officer', 12 => 'Reviewing officer', 13 => 'Appraisal Feedback Status by Reviewing Officer', 14 => 'Created by', 15 => 'Created at', 16 => 'Last updated by', 17 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employee_designation_lookup', 2 => 'current_review_period', 3 => 'roles', 4 => 'self_explanation', 5 => 'upload_file_1', 6 => 'upload_file_2', 7 => 'upload_file_3', 8 => 'reporting_officer_feedback', 9 => 'observations_by_reporting_officer', 10 => 'overall_rating', 11 => 'reporting_appraisal_status', 12 => 'reviewing_officer', 13 => 'reviewing_appraisal_status', 14 => 'created_by', 15 => 'created_at', 16 => 'last_updated_by', 17 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_appraisal_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_appraisal_table',
					'template-printable' => 'children-employees_appraisal_table-printable',
					'query' => "SELECT `employees_appraisal_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_designation_table1`.`employees_designation_str`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `employees_designation_table1`.`employees_designation_str`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'employee_designation_lookup', `employees_appraisal_table`.`current_review_period` as 'current_review_period', `employees_appraisal_table`.`roles` as 'roles', `employees_appraisal_table`.`self_explanation` as 'self_explanation', `employees_appraisal_table`.`upload_file_1` as 'upload_file_1', `employees_appraisal_table`.`upload_file_2` as 'upload_file_2', `employees_appraisal_table`.`upload_file_3` as 'upload_file_3', `employees_appraisal_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_table`.`overall_rating` as 'overall_rating', `employees_appraisal_table`.`reporting_appraisal_status` as 'reporting_appraisal_status', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_appraisal_table`.`reviewing_appraisal_status` as 'reviewing_appraisal_status', `employees_appraisal_table`.`created_by` as 'created_by', `employees_appraisal_table`.`created_at` as 'created_at', `employees_appraisal_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_table`.`last_updated_at` as 'last_updated_at' FROM `employees_appraisal_table` LEFT JOIN `employees_designation_table` as employees_designation_table1 ON `employees_designation_table1`.`id`=`employees_appraisal_table`.`employee_designation_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table1`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_appraisal_table`.`reviewing_officer` "
				],
				'reviewing_officer' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees Appraisal  - App <span class="hidden child-label-employees_appraisal_table child-field-caption">(Reviewing officer)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employee Details', 2 => 'Current review period', 3 => 'Roles & Responsibilities', 4 => 'Employee Self-explanation', 5 => 'Upload file 1', 6 => 'Upload file 2', 7 => 'Upload file 3', 8 => 'Reporting Officer Feedback on the Employee Responsibilities', 9 => 'Observations by the Reporting Officer', 10 => 'Overall Rating by the Reporting Officer', 11 => 'Appraisal Feedback Status by Reporting Officer', 12 => 'Reviewing officer', 13 => 'Appraisal Feedback Status by Reviewing Officer', 14 => 'Created by', 15 => 'Created at', 16 => 'Last updated by', 17 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employee_designation_lookup', 2 => 'current_review_period', 3 => 'roles', 4 => 'self_explanation', 5 => 'upload_file_1', 6 => 'upload_file_2', 7 => 'upload_file_3', 8 => 'reporting_officer_feedback', 9 => 'observations_by_reporting_officer', 10 => 'overall_rating', 11 => 'reporting_appraisal_status', 12 => 'reviewing_officer', 13 => 'reviewing_appraisal_status', 14 => 'created_by', 15 => 'created_at', 16 => 'last_updated_by', 17 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_appraisal_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_appraisal_table',
					'template-printable' => 'children-employees_appraisal_table-printable',
					'query' => "SELECT `employees_appraisal_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_designation_table1`.`employees_designation_str`) || CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `employees_designation_table1`.`employees_designation_str`, '::', `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'employee_designation_lookup', `employees_appraisal_table`.`current_review_period` as 'current_review_period', `employees_appraisal_table`.`roles` as 'roles', `employees_appraisal_table`.`self_explanation` as 'self_explanation', `employees_appraisal_table`.`upload_file_1` as 'upload_file_1', `employees_appraisal_table`.`upload_file_2` as 'upload_file_2', `employees_appraisal_table`.`upload_file_3` as 'upload_file_3', `employees_appraisal_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_table`.`overall_rating` as 'overall_rating', `employees_appraisal_table`.`reporting_appraisal_status` as 'reporting_appraisal_status', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS('',   `user_table2`.`memberID`, '::', `user_table2`.`name`), '') as 'reviewing_officer', `employees_appraisal_table`.`reviewing_appraisal_status` as 'reviewing_appraisal_status', `employees_appraisal_table`.`created_by` as 'created_by', `employees_appraisal_table`.`created_at` as 'created_at', `employees_appraisal_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_table`.`last_updated_at` as 'last_updated_at' FROM `employees_appraisal_table` LEFT JOIN `employees_designation_table` as employees_designation_table1 ON `employees_designation_table1`.`id`=`employees_appraisal_table`.`employee_designation_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table1`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_appraisal_table`.`reviewing_officer` "
				],
			],
			'employees_appraisal_feedback_table' => [
				'employees_appraisal_lookup' => [
					'parent-table' => 'employees_appraisal_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees appraisal feedback table <span class="hidden child-label-employees_appraisal_feedback_table child-field-caption">(Employees appraisal lookup)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employees appraisal lookup', 2 => 'Reporting Officer Feedback on the Employee Responsibilities', 3 => 'Observations by the Reporting Officer', 4 => 'Overall Rating by the Reporting Officer', 5 => 'Appraisal Feedback Status', 6 => 'Reprting / Reviewing officer', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employees_appraisal_lookup', 2 => 'reporting_officer_feedback', 3 => 'observations_by_reporting_officer', 4 => 'overall_rating', 5 => 'appraisal_feedback_status', 6 => 'reviewing_officer', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_appraisal_feedback_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_appraisal_feedback_table',
					'template-printable' => 'children-employees_appraisal_feedback_table-printable',
					'query' => "SELECT `employees_appraisal_feedback_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_appraisal_table1`.`roles`) || CHAR_LENGTH(`employees_appraisal_table1`.`self_explanation`), CONCAT_WS('',   `employees_appraisal_table1`.`roles`, '::', `employees_appraisal_table1`.`self_explanation`), '') as 'employees_appraisal_lookup', `employees_appraisal_feedback_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_feedback_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_feedback_table`.`overall_rating` as 'overall_rating', `employees_appraisal_feedback_table`.`appraisal_feedback_status` as 'appraisal_feedback_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reviewing_officer', `employees_appraisal_feedback_table`.`created_by` as 'created_by', `employees_appraisal_feedback_table`.`created_at` as 'created_at', `employees_appraisal_feedback_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_feedback_table`.`last_updated_at` as 'last_updated_at' FROM `employees_appraisal_feedback_table` LEFT JOIN `employees_appraisal_table` as employees_appraisal_table1 ON `employees_appraisal_table1`.`id`=`employees_appraisal_feedback_table`.`employees_appraisal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_appraisal_feedback_table`.`reviewing_officer` "
				],
				'reviewing_officer' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Employees appraisal feedback table <span class="hidden child-label-employees_appraisal_feedback_table child-field-caption">(Reprting / Reviewing officer)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Employees appraisal lookup', 2 => 'Reporting Officer Feedback on the Employee Responsibilities', 3 => 'Observations by the Reporting Officer', 4 => 'Overall Rating by the Reporting Officer', 5 => 'Appraisal Feedback Status', 6 => 'Reprting / Reviewing officer', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'employees_appraisal_lookup', 2 => 'reporting_officer_feedback', 3 => 'observations_by_reporting_officer', 4 => 'overall_rating', 5 => 'appraisal_feedback_status', 6 => 'reviewing_officer', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`employees_appraisal_feedback_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => false,
					'default-sort-direction' => 'asc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-employees_appraisal_feedback_table',
					'template-printable' => 'children-employees_appraisal_feedback_table-printable',
					'query' => "SELECT `employees_appraisal_feedback_table`.`id` as 'id', IF(    CHAR_LENGTH(`employees_appraisal_table1`.`roles`) || CHAR_LENGTH(`employees_appraisal_table1`.`self_explanation`), CONCAT_WS('',   `employees_appraisal_table1`.`roles`, '::', `employees_appraisal_table1`.`self_explanation`), '') as 'employees_appraisal_lookup', `employees_appraisal_feedback_table`.`reporting_officer_feedback` as 'reporting_officer_feedback', `employees_appraisal_feedback_table`.`observations_by_reporting_officer` as 'observations_by_reporting_officer', `employees_appraisal_feedback_table`.`overall_rating` as 'overall_rating', `employees_appraisal_feedback_table`.`appraisal_feedback_status` as 'appraisal_feedback_status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reviewing_officer', `employees_appraisal_feedback_table`.`created_by` as 'created_by', `employees_appraisal_feedback_table`.`created_at` as 'created_at', `employees_appraisal_feedback_table`.`last_updated_by` as 'last_updated_by', `employees_appraisal_feedback_table`.`last_updated_at` as 'last_updated_at' FROM `employees_appraisal_feedback_table` LEFT JOIN `employees_appraisal_table` as employees_appraisal_table1 ON `employees_appraisal_table1`.`id`=`employees_appraisal_feedback_table`.`employees_appraisal_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_appraisal_feedback_table`.`reviewing_officer` "
				],
			],
			'beyond_workingHours_table' => [
				'select_employee' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Overtime table <span class="hidden child-label-beyond_workingHours_table child-field-caption">(Select Employee)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Select Employee', 2 => 'Reson for overtime', 3 => 'Start Date & Time', 4 => 'End Date & Time', 5 => 'Number of hours', 6 => 'Approval status', 7 => 'Approval remarks', 8 => 'Approved by', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'select_employee', 2 => 'reson_for_overtime', 3 => 'start_datetime', 4 => 'end_datetime', 5 => 'number_of_hours', 6 => 'approval_status', 7 => 'approval_remarks', 8 => 'approved_by', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`beyond_workingHours_table`.`id`', 1 => 2, 2 => 3, 3 => '`beyond_workingHours_table`.`start_datetime`', 4 => '`beyond_workingHours_table`.`end_datetime`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-beyond_workingHours_table',
					'template-printable' => 'children-beyond_workingHours_table-printable',
					'query' => "SELECT `beyond_workingHours_table`.`id` as 'id', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'select_employee', `beyond_workingHours_table`.`reson_for_overtime` as 'reson_for_overtime', if(`beyond_workingHours_table`.`start_datetime`,date_format(`beyond_workingHours_table`.`start_datetime`,'%d/%m/%Y %H:%i'),'') as 'start_datetime', if(`beyond_workingHours_table`.`end_datetime`,date_format(`beyond_workingHours_table`.`end_datetime`,'%d/%m/%Y %H:%i'),'') as 'end_datetime', `beyond_workingHours_table`.`number_of_hours` as 'number_of_hours', `beyond_workingHours_table`.`approval_status` as 'approval_status', `beyond_workingHours_table`.`approval_remarks` as 'approval_remarks', `beyond_workingHours_table`.`approved_by` as 'approved_by', `beyond_workingHours_table`.`created_by` as 'created_by', `beyond_workingHours_table`.`created_at` as 'created_at', `beyond_workingHours_table`.`last_updated_by` as 'last_updated_by', `beyond_workingHours_table`.`last_updated_at` as 'last_updated_at' FROM `beyond_workingHours_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`beyond_workingHours_table`.`select_employee` "
				],
			],
			'attendence_details_table' => [
			],
			'leave_table' => [
			],
			'work_from_home_table' => [
				'approved_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'work_from_home_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Work from home table <span class="hidden child-label-work_from_home_table child-field-caption">(Approved by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Purpose work from home', 2 => 'From date', 3 => 'To date', 4 => 'Approved by', 5 => 'Created by', 6 => 'Created at', 7 => 'Last updated by', 8 => 'Last updated at'],
					'display-field-names' => [0 => 'work_from_home_id', 1 => 'work_from_home_purpose', 2 => 'from_date', 3 => 'to_date', 4 => 'approved_by', 5 => 'created_by', 6 => 'created_at', 7 => 'last_updated_by', 8 => 'last_updated_at'],
					'sortable-fields' => [0 => '`work_from_home_table`.`work_from_home_id`', 1 => 2, 2 => '`work_from_home_table`.`from_date`', 3 => '`work_from_home_table`.`to_date`', 4 => '`user_table1`.`user_id`', 5 => 6, 6 => 7, 7 => 8, 8 => 9],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-work_from_home_table',
					'template-printable' => 'children-work_from_home_table-printable',
					'query' => "SELECT `work_from_home_table`.`work_from_home_id` as 'work_from_home_id', `work_from_home_table`.`work_from_home_purpose` as 'work_from_home_purpose', if(`work_from_home_table`.`from_date`,date_format(`work_from_home_table`.`from_date`,'%d/%m/%Y'),'') as 'from_date', if(`work_from_home_table`.`to_date`,date_format(`work_from_home_table`.`to_date`,'%d/%m/%Y'),'') as 'to_date', IF(    CHAR_LENGTH(`user_table1`.`user_id`), CONCAT_WS('',   `user_table1`.`user_id`), '') as 'approved_by', `work_from_home_table`.`created_by` as 'created_by', `work_from_home_table`.`created_at` as 'created_at', `work_from_home_table`.`last_updated_by` as 'last_updated_by', `work_from_home_table`.`last_updated_at` as 'last_updated_at' FROM `work_from_home_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`work_from_home_table`.`approved_by` "
				],
			],
			'navavishkar_stay_table' => [
				'approved_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Navavishkar Stay - App <span class="hidden child-label-navavishkar_stay_table child-field-caption">(Approved By)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Full Name', 2 => 'Employee ID', 3 => 'Department', 4 => 'Designation', 5 => 'Contact Email', 6 => 'Contact Number', 7 => 'Room number', 8 => 'Check in date', 9 => 'Checkout date', 10 => 'Reason for stay', 11 => 'Approval status', 12 => 'Approval remarks', 13 => 'Approved By', 14 => 'Created by', 15 => 'Created at', 16 => 'Last updated by', 17 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'full_name', 2 => 'emp_id', 3 => 'department', 4 => 'designation', 5 => 'contact_email', 6 => 'contact_number', 7 => 'room_number', 8 => 'check_in_date', 9 => 'checkout_date', 10 => 'reason_for_stay', 11 => 'approval_status', 12 => 'approval_remarks', 13 => 'approved_by', 14 => 'created_by', 15 => 'created_at', 16 => 'last_updated_by', 17 => 'last_updated_at'],
					'sortable-fields' => [0 => '`navavishkar_stay_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => '`navavishkar_stay_table`.`check_in_date`', 9 => '`navavishkar_stay_table`.`checkout_date`', 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-navavishkar_stay_table',
					'template-printable' => 'children-navavishkar_stay_table-printable',
					'query' => "SELECT `navavishkar_stay_table`.`id` as 'id', `navavishkar_stay_table`.`full_name` as 'full_name', `navavishkar_stay_table`.`emp_id` as 'emp_id', `navavishkar_stay_table`.`department` as 'department', `navavishkar_stay_table`.`designation` as 'designation', `navavishkar_stay_table`.`contact_email` as 'contact_email', `navavishkar_stay_table`.`contact_number` as 'contact_number', `navavishkar_stay_table`.`room_number` as 'room_number', if(`navavishkar_stay_table`.`check_in_date`,date_format(`navavishkar_stay_table`.`check_in_date`,'%d/%m/%Y'),'') as 'check_in_date', if(`navavishkar_stay_table`.`checkout_date`,date_format(`navavishkar_stay_table`.`checkout_date`,'%d/%m/%Y'),'') as 'checkout_date', `navavishkar_stay_table`.`reason_for_stay` as 'reason_for_stay', `navavishkar_stay_table`.`approval_status` as 'approval_status', `navavishkar_stay_table`.`approval_remarks` as 'approval_remarks', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'approved_by', `navavishkar_stay_table`.`created_by` as 'created_by', `navavishkar_stay_table`.`created_at` as 'created_at', `navavishkar_stay_table`.`last_updated_by` as 'last_updated_by', `navavishkar_stay_table`.`last_updated_at` as 'last_updated_at' FROM `navavishkar_stay_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`navavishkar_stay_table`.`approved_by` "
				],
			],
			'navavishkar_stay_payment_table' => [
				'navavishakr_stay_details' => [
					'parent-table' => 'navavishkar_stay_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Navavishkar Stay Payment - App <span class="hidden child-label-navavishkar_stay_payment_table child-field-caption">(Navavishakr stay details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Navavishakr stay details', 2 => 'Payment status', 3 => 'Amount (INR)', 4 => 'Additional Facilities Provided (Optional)', 5 => 'Upload Payment Image', 6 => 'Remarks', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'navavishakr_stay_details', 2 => 'payment_status', 3 => 'amount', 4 => 'additional_facilities_provided', 5 => 'payment_img', 6 => 'remarks', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`navavishkar_stay_payment_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-navavishkar_stay_payment_table',
					'template-printable' => 'children-navavishkar_stay_payment_table-printable',
					'query' => "SELECT `navavishkar_stay_payment_table`.`id` as 'id', IF(    CHAR_LENGTH(`navavishkar_stay_table1`.`full_name`) || CHAR_LENGTH(`navavishkar_stay_table1`.`emp_id`), CONCAT_WS('',   `navavishkar_stay_table1`.`full_name`, '::', `navavishkar_stay_table1`.`emp_id`), '') as 'navavishakr_stay_details', `navavishkar_stay_payment_table`.`payment_status` as 'payment_status', `navavishkar_stay_payment_table`.`amount` as 'amount', `navavishkar_stay_payment_table`.`additional_facilities_provided` as 'additional_facilities_provided', `navavishkar_stay_payment_table`.`payment_img` as 'payment_img', `navavishkar_stay_payment_table`.`remarks` as 'remarks', `navavishkar_stay_payment_table`.`created_by` as 'created_by', `navavishkar_stay_payment_table`.`created_at` as 'created_at', `navavishkar_stay_payment_table`.`last_updated_by` as 'last_updated_by', `navavishkar_stay_payment_table`.`last_updated_at` as 'last_updated_at' FROM `navavishkar_stay_payment_table` LEFT JOIN `navavishkar_stay_table` as navavishkar_stay_table1 ON `navavishkar_stay_table1`.`id`=`navavishkar_stay_payment_table`.`navavishakr_stay_details` "
				],
			],
			'email_id_allocation_table' => [
				'reporting_manager' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'email_id_allocation_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Email id allocation table <span class="hidden child-label-email_id_allocation_table child-field-caption">(Reporting manager)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Name of person', 2 => 'Allocated email id', 3 => 'Alternative email id', 4 => 'Date of allocation', 5 => 'Status', 6 => 'Reporting manager', 7 => 'Remarks', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'email_id_allocation_id', 1 => 'name_of_person', 2 => 'allocated_email_id', 3 => 'alternative_email_id', 4 => 'date_of_allocation', 5 => 'status', 6 => 'reporting_manager', 7 => 'remarks', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`email_id_allocation_table`.`email_id_allocation_id`', 1 => 2, 2 => 3, 3 => 4, 4 => '`email_id_allocation_table`.`date_of_allocation`', 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-email_id_allocation_table',
					'template-printable' => 'children-email_id_allocation_table-printable',
					'query' => "SELECT `email_id_allocation_table`.`email_id_allocation_id` as 'email_id_allocation_id', `email_id_allocation_table`.`name_of_person` as 'name_of_person', `email_id_allocation_table`.`allocated_email_id` as 'allocated_email_id', `email_id_allocation_table`.`alternative_email_id` as 'alternative_email_id', if(`email_id_allocation_table`.`date_of_allocation`,date_format(`email_id_allocation_table`.`date_of_allocation`,'%d/%m/%Y'),'') as 'date_of_allocation', `email_id_allocation_table`.`status` as 'status', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'reporting_manager', `email_id_allocation_table`.`remarks` as 'remarks', `email_id_allocation_table`.`created_by` as 'created_by', `email_id_allocation_table`.`created_at` as 'created_at', `email_id_allocation_table`.`last_updated_by` as 'last_updated_by', `email_id_allocation_table`.`last_updated_at` as 'last_updated_at' FROM `email_id_allocation_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`email_id_allocation_table`.`reporting_manager` "
				],
			],
			'all_startup_data_table' => [
			],
			'shortlisted_startups_for_fund_table' => [
				'startup' => [
					'parent-table' => 'all_startup_data_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Shortlisted startups for fund - App <span class="hidden child-label-shortlisted_startups_for_fund_table child-field-caption">(Select startup)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Select startup', 2 => 'Scheme', 3 => 'Recommended fund (in Lakhs INR)', 4 => 'Name of founder', 5 => 'Email of founder', 6 => 'Phone number of founder', 7 => 'Due diligence start', 8 => 'Terms agreed', 9 => 'Grant amount (in INR)', 10 => 'Debt amount (in INR)', 11 => 'OCD/CCD Amount (in INR)', 12 => 'Equity amount (in INR)', 13 => 'Interest rate (in %)', 14 => 'Period (in Years)', 15 => 'Conversion formula', 16 => 'Equity diluted (in %)', 17 => 'Comments', 18 => 'Remarks 1', 19 => 'Remarks 2', 20 => 'Created by', 21 => 'Created at', 22 => 'Last updated by', 23 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'startup', 2 => 'scheme', 3 => 'recommended_fund', 4 => 'name_of_founder', 5 => 'email_of_founder', 6 => 'phone_number_of_founder', 7 => 'due_diligence_start', 8 => 'terms_agreed', 9 => 'grant_amount', 10 => 'debt_amount', 11 => 'ocd_or_ccd_amount', 12 => 'equity_amount', 13 => 'interest_rate', 14 => 'period', 15 => 'conversion_formula', 16 => 'equity_diluted', 17 => 'comments', 18 => 'remarks_1', 19 => 'remarks_2', 20 => 'created_by', 21 => 'created_at', 22 => 'last_updated_by', 23 => 'last_updated_at'],
					'sortable-fields' => [0 => '`shortlisted_startups_for_fund_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => '`shortlisted_startups_for_fund_table`.`period`', 15 => 16, 16 => 17, 17 => 18, 18 => 19, 19 => 20, 20 => 21, 21 => 22, 22 => 23, 23 => 24],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-shortlisted_startups_for_fund_table',
					'template-printable' => 'children-shortlisted_startups_for_fund_table-printable',
					'query' => "SELECT `shortlisted_startups_for_fund_table`.`id` as 'id', IF(    CHAR_LENGTH(`all_startup_data_table1`.`company_id`) || CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`company_id`, `all_startup_data_table1`.`name_of_the_company`), '') as 'startup', `shortlisted_startups_for_fund_table`.`scheme` as 'scheme', `shortlisted_startups_for_fund_table`.`recommended_fund` as 'recommended_fund', `shortlisted_startups_for_fund_table`.`name_of_founder` as 'name_of_founder', `shortlisted_startups_for_fund_table`.`email_of_founder` as 'email_of_founder', `shortlisted_startups_for_fund_table`.`phone_number_of_founder` as 'phone_number_of_founder', `shortlisted_startups_for_fund_table`.`due_diligence_start` as 'due_diligence_start', `shortlisted_startups_for_fund_table`.`terms_agreed` as 'terms_agreed', `shortlisted_startups_for_fund_table`.`grant_amount` as 'grant_amount', `shortlisted_startups_for_fund_table`.`debt_amount` as 'debt_amount', `shortlisted_startups_for_fund_table`.`ocd_or_ccd_amount` as 'ocd_or_ccd_amount', `shortlisted_startups_for_fund_table`.`equity_amount` as 'equity_amount', `shortlisted_startups_for_fund_table`.`interest_rate` as 'interest_rate', `shortlisted_startups_for_fund_table`.`period` as 'period', `shortlisted_startups_for_fund_table`.`conversion_formula` as 'conversion_formula', `shortlisted_startups_for_fund_table`.`equity_diluted` as 'equity_diluted', `shortlisted_startups_for_fund_table`.`comments` as 'comments', `shortlisted_startups_for_fund_table`.`remarks_1` as 'remarks_1', `shortlisted_startups_for_fund_table`.`remarks_2` as 'remarks_2', `shortlisted_startups_for_fund_table`.`created_by` as 'created_by', `shortlisted_startups_for_fund_table`.`created_at` as 'created_at', `shortlisted_startups_for_fund_table`.`last_updated_by` as 'last_updated_by', `shortlisted_startups_for_fund_table`.`last_updated_at` as 'last_updated_at' FROM `shortlisted_startups_for_fund_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`shortlisted_startups_for_fund_table`.`startup` "
				],
			],
			'shortlisted_startups_dd_and_agreement_table' => [
				'startup' => [
					'parent-table' => 'all_startup_data_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Shortlisted startups DD and Agreement - App <span class="hidden child-label-shortlisted_startups_dd_and_agreement_table child-field-caption">(Startup)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Startup', 2 => 'Documents', 3 => 'Status', 4 => 'Comment', 5 => 'Link to DDR', 6 => 'Status', 7 => 'Comment', 8 => 'Link to agreement', 9 => 'Created by', 10 => 'Created at', 11 => 'Last updated by', 12 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'startup', 2 => 'documents', 3 => 'status_1', 4 => 'comment_1', 5 => 'link_to_ddr', 6 => 'status_2', 7 => 'comment_2', 8 => 'link_to_agreement', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`shortlisted_startups_dd_and_agreement_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-shortlisted_startups_dd_and_agreement_table',
					'template-printable' => 'children-shortlisted_startups_dd_and_agreement_table-printable',
					'query' => "SELECT `shortlisted_startups_dd_and_agreement_table`.`id` as 'id', IF(    CHAR_LENGTH(`all_startup_data_table1`.`company_id`) || CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`company_id`, '::', `all_startup_data_table1`.`name_of_the_company`), '') as 'startup', `shortlisted_startups_dd_and_agreement_table`.`documents` as 'documents', `shortlisted_startups_dd_and_agreement_table`.`status_1` as 'status_1', `shortlisted_startups_dd_and_agreement_table`.`comment_1` as 'comment_1', `shortlisted_startups_dd_and_agreement_table`.`link_to_ddr` as 'link_to_ddr', `shortlisted_startups_dd_and_agreement_table`.`status_2` as 'status_2', `shortlisted_startups_dd_and_agreement_table`.`comment_2` as 'comment_2', `shortlisted_startups_dd_and_agreement_table`.`link_to_agreement` as 'link_to_agreement', `shortlisted_startups_dd_and_agreement_table`.`created_by` as 'created_by', `shortlisted_startups_dd_and_agreement_table`.`created_at` as 'created_at', `shortlisted_startups_dd_and_agreement_table`.`last_updated_by` as 'last_updated_by', `shortlisted_startups_dd_and_agreement_table`.`last_updated_at` as 'last_updated_at' FROM `shortlisted_startups_dd_and_agreement_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`shortlisted_startups_dd_and_agreement_table`.`startup` "
				],
			],
			'vikas_startup_applications_table' => [
			],
			'programs_table' => [
			],
			'evaluation_table' => [
				'select_startup' => [
					'parent-table' => 'all_startup_data_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'evaluation_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Evaluation table <span class="hidden child-label-evaluation_table child-field-caption">(Select startup)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Result', 2 => 'Select startup', 3 => 'Recommendation', 4 => 'Marks', 5 => 'Reason for not recommending', 6 => 'Created by', 7 => 'Created at', 8 => 'Last updated by', 9 => 'Last updated at'],
					'display-field-names' => [0 => 'evaluation_id', 1 => 'result', 2 => 'select_startup', 3 => 'recommendation', 4 => 'marks', 5 => 'reason_for_not_recommending', 6 => 'created_by', 7 => 'created_at', 8 => 'last_updated_by', 9 => 'last_updated_at'],
					'sortable-fields' => [0 => '`evaluation_table`.`evaluation_id`', 1 => 2, 2 => '`all_startup_data_table1`.`name_of_the_company`', 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-evaluation_table',
					'template-printable' => 'children-evaluation_table-printable',
					'query' => "SELECT `evaluation_table`.`evaluation_id` as 'evaluation_id', `evaluation_table`.`result` as 'result', IF(    CHAR_LENGTH(`all_startup_data_table1`.`name_of_the_company`), CONCAT_WS('',   `all_startup_data_table1`.`name_of_the_company`), '') as 'select_startup', `evaluation_table`.`recommendation` as 'recommendation', `evaluation_table`.`marks` as 'marks', `evaluation_table`.`reason_for_not_recommending` as 'reason_for_not_recommending', `evaluation_table`.`created_by` as 'created_by', `evaluation_table`.`created_at` as 'created_at', `evaluation_table`.`last_updated_by` as 'last_updated_by', `evaluation_table`.`last_updated_at` as 'last_updated_at' FROM `evaluation_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`evaluation_table`.`select_startup` "
				],
			],
			'problem_statement_table' => [
				'select_program_id' => [
					'parent-table' => 'programs_table',
					'parent-primary-key' => 'programs_id',
					'child-primary-key' => 'problem_statement_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Problem statement table <span class="hidden child-label-problem_statement_table child-field-caption">(Select program id)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Select program id', 2 => 'Program description', 3 => 'Remarks', 4 => 'Created by', 5 => 'Created at', 6 => 'Last updated by', 7 => 'Last updated at'],
					'display-field-names' => [0 => 'problem_statement_id', 1 => 'select_program_id', 2 => 'program_description', 3 => 'remarks', 4 => 'created_by', 5 => 'created_at', 6 => 'last_updated_by', 7 => 'last_updated_at'],
					'sortable-fields' => [0 => '`problem_statement_table`.`problem_statement_id`', 1 => '`programs_table1`.`title_of_the_program`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-problem_statement_table',
					'template-printable' => 'children-problem_statement_table-printable',
					'query' => "SELECT `problem_statement_table`.`problem_statement_id` as 'problem_statement_id', IF(    CHAR_LENGTH(`programs_table1`.`title_of_the_program`), CONCAT_WS('',   `programs_table1`.`title_of_the_program`), '') as 'select_program_id', `problem_statement_table`.`program_description` as 'program_description', `problem_statement_table`.`remarks` as 'remarks', `problem_statement_table`.`created_by` as 'created_by', `problem_statement_table`.`created_at` as 'created_at', `problem_statement_table`.`last_updated_by` as 'last_updated_by', `problem_statement_table`.`last_updated_at` as 'last_updated_at' FROM `problem_statement_table` LEFT JOIN `programs_table` as programs_table1 ON `programs_table1`.`programs_id`=`problem_statement_table`.`select_program_id` "
				],
			],
			'evaluators_table' => [
				'evaluation_lookup' => [
					'parent-table' => 'evaluation_table',
					'parent-primary-key' => 'evaluation_id',
					'child-primary-key' => 'evaluator_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Evaluators table <span class="hidden child-label-evaluators_table child-field-caption">(Evaluation lookup)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 2 => 'Name', 3 => 'Designation', 4 => 'Qualification', 5 => 'Self description', 6 => 'Role', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'evaluator_id', 2 => 'name', 3 => 'designation', 4 => 'qualification', 5 => 'self_description', 6 => 'role', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`evaluators_table`.`evaluator_id`', 1 => '`evaluation_table1`.`evaluation_id`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-evaluators_table',
					'template-printable' => 'children-evaluators_table-printable',
					'query' => "SELECT `evaluators_table`.`evaluator_id` as 'evaluator_id', IF(    CHAR_LENGTH(`evaluation_table1`.`evaluation_id`), CONCAT_WS('',   `evaluation_table1`.`evaluation_id`), '') as 'evaluation_lookup', `evaluators_table`.`name` as 'name', `evaluators_table`.`designation` as 'designation', `evaluators_table`.`qualification` as 'qualification', `evaluators_table`.`self_description` as 'self_description', `evaluators_table`.`role` as 'role', `evaluators_table`.`created_by` as 'created_by', `evaluators_table`.`created_at` as 'created_at', `evaluators_table`.`last_updated_by` as 'last_updated_by', `evaluators_table`.`last_updated_at` as 'last_updated_at' FROM `evaluators_table` LEFT JOIN `evaluation_table` as evaluation_table1 ON `evaluation_table1`.`evaluation_id`=`evaluators_table`.`evaluation_lookup` "
				],
			],
			'approval_billing_table' => [
				'approval_lookup' => [
					'parent-table' => 'approval_table',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Approval billing table <span class="hidden child-label-approval_billing_table child-field-caption">(Approval Details)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Approval Details', 2 => 'Date of Purchase', 3 => 'Total Amount of Bill', 4 => 'Items List', 5 => 'Paid by', 6 => 'Attach bill 1', 7 => 'Attach bill 2', 8 => 'Attach bill 3', 9 => 'Created By', 10 => 'Created At', 11 => 'Last Updated By', 12 => 'Last Updated At'],
					'display-field-names' => [0 => 'id', 1 => 'approval_lookup', 2 => 'date_of_purchase', 3 => 'total_amount_of_bill', 4 => 'items_list', 5 => 'paid_by', 6 => 'attach_bill_1', 7 => 'attach_bill_2', 8 => 'attach_bill_3', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`approval_billing_table`.`id`', 1 => 2, 2 => '`approval_billing_table`.`date_of_purchase`', 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-approval_billing_table',
					'template-printable' => 'children-approval_billing_table-printable',
					'query' => "SELECT `approval_billing_table`.`id` as 'id', IF(    CHAR_LENGTH(`approval_table1`.`type`) || CHAR_LENGTH(`approval_table1`.`description`), CONCAT_WS('',   `approval_table1`.`type`, '::', `approval_table1`.`description`), '') as 'approval_lookup', if(`approval_billing_table`.`date_of_purchase`,date_format(`approval_billing_table`.`date_of_purchase`,'%d/%m/%Y'),'') as 'date_of_purchase', `approval_billing_table`.`total_amount_of_bill` as 'total_amount_of_bill', `approval_billing_table`.`items_list` as 'items_list', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'paid_by', `approval_billing_table`.`attach_bill_1` as 'attach_bill_1', `approval_billing_table`.`attach_bill_2` as 'attach_bill_2', `approval_billing_table`.`attach_bill_3` as 'attach_bill_3', `approval_billing_table`.`created_by` as 'created_by', `approval_billing_table`.`created_at` as 'created_at', `approval_billing_table`.`last_updated_by` as 'last_updated_by', `approval_billing_table`.`last_updated_at` as 'last_updated_at' FROM `approval_billing_table` LEFT JOIN `approval_table` as approval_table1 ON `approval_table1`.`id`=`approval_billing_table`.`approval_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_billing_table`.`paid_by` "
				],
				'paid_by' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Approval billing table <span class="hidden child-label-approval_billing_table child-field-caption">(Paid by)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Approval Details', 2 => 'Date of Purchase', 3 => 'Total Amount of Bill', 4 => 'Items List', 5 => 'Paid by', 6 => 'Attach bill 1', 7 => 'Attach bill 2', 8 => 'Attach bill 3', 9 => 'Created By', 10 => 'Created At', 11 => 'Last Updated By', 12 => 'Last Updated At'],
					'display-field-names' => [0 => 'id', 1 => 'approval_lookup', 2 => 'date_of_purchase', 3 => 'total_amount_of_bill', 4 => 'items_list', 5 => 'paid_by', 6 => 'attach_bill_1', 7 => 'attach_bill_2', 8 => 'attach_bill_3', 9 => 'created_by', 10 => 'created_at', 11 => 'last_updated_by', 12 => 'last_updated_at'],
					'sortable-fields' => [0 => '`approval_billing_table`.`id`', 1 => 2, 2 => '`approval_billing_table`.`date_of_purchase`', 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-approval_billing_table',
					'template-printable' => 'children-approval_billing_table-printable',
					'query' => "SELECT `approval_billing_table`.`id` as 'id', IF(    CHAR_LENGTH(`approval_table1`.`type`) || CHAR_LENGTH(`approval_table1`.`description`), CONCAT_WS('',   `approval_table1`.`type`, '::', `approval_table1`.`description`), '') as 'approval_lookup', if(`approval_billing_table`.`date_of_purchase`,date_format(`approval_billing_table`.`date_of_purchase`,'%d/%m/%Y'),'') as 'date_of_purchase', `approval_billing_table`.`total_amount_of_bill` as 'total_amount_of_bill', `approval_billing_table`.`items_list` as 'items_list', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'paid_by', `approval_billing_table`.`attach_bill_1` as 'attach_bill_1', `approval_billing_table`.`attach_bill_2` as 'attach_bill_2', `approval_billing_table`.`attach_bill_3` as 'attach_bill_3', `approval_billing_table`.`created_by` as 'created_by', `approval_billing_table`.`created_at` as 'created_at', `approval_billing_table`.`last_updated_by` as 'last_updated_by', `approval_billing_table`.`last_updated_at` as 'last_updated_at' FROM `approval_billing_table` LEFT JOIN `approval_table` as approval_table1 ON `approval_table1`.`id`=`approval_billing_table`.`approval_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_billing_table`.`paid_by` "
				],
			],
			'honorarium_claim_table' => [
				'coordinated_by_tih_user' => [
					'parent-table' => 'user_table',
					'parent-primary-key' => 'user_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Honorarium - App <span class="hidden child-label-honorarium_claim_table child-field-caption">(Coordinated by TIH User (For Office Use of TIH))</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Name of Advisor/Consultant', 2 => 'Eamil ID of Advisor/Consultant', 3 => 'Department of TIH', 4 => 'Bank Account No.', 5 => 'IFSC Code', 6 => 'Bank Name', 7 => 'PAN', 8 => 'Place of work (Visit) / Online', 9 => 'Day 1 Date', 10 => 'No. Hours', 11 => 'Day 2 Date', 12 => 'No. Hours', 13 => 'Day 3 Date', 14 => 'No. Hours', 15 => 'Day 4 Date', 16 => 'No. Hours', 17 => 'Day 5 Date', 18 => 'No. Hours', 19 => 'Total No. of Days', 20 => 'Total no of hours', 21 => 'Case Reference Email Subject (If Any)', 22 => 'Activities/Deliverables', 23 => 'Coordinated by TIH User (For Office Use of TIH)', 24 => 'Payment date (For Office Use of TIH)', 25 => 'Amount paid (For Office Use of TIH)', 26 => 'Transaction details (For Office Use of TIH)', 27 => 'Approval Status (For Office Use of TIH)', 28 => 'Remarks for Approval (For Office Use of TIH)', 29 => 'Created By', 30 => 'Created At', 31 => 'Last Updated By', 32 => 'Approved At'],
					'display-field-names' => [0 => 'id', 1 => 'name_of_advisor', 2 => 'email_advisor', 3 => 'department_of_tih', 4 => 'bank_account_no', 5 => 'ifsc_code', 6 => 'bank_name', 7 => 'pan', 8 => 'place_of_work', 9 => 'date_1', 10 => 'hours_1', 11 => 'date_2', 12 => 'hours_2', 13 => 'date_3', 14 => 'hours_3', 15 => 'date_4', 16 => 'hours_4', 17 => 'date_5', 18 => 'hours_5', 19 => 'total_no_of_days', 20 => 'total_no_of_hours', 21 => 'case_reference_email_subject', 22 => 'activities', 23 => 'coordinated_by_tih_user', 24 => 'payment_date', 25 => 'amount_paid', 26 => 'transaction_details', 27 => 'approval_status', 28 => 'remarks_for_approval', 29 => 'created_by', 30 => 'created_at', 31 => 'last_updated_by', 32 => 'last_updated_at'],
					'sortable-fields' => [0 => '`honorarium_claim_table`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => '`honorarium_claim_table`.`date_1`', 10 => 11, 11 => '`honorarium_claim_table`.`date_2`', 12 => 13, 13 => '`honorarium_claim_table`.`date_3`', 14 => 15, 15 => '`honorarium_claim_table`.`date_4`', 16 => 17, 17 => '`honorarium_claim_table`.`date_5`', 18 => 19, 19 => 20, 20 => 21, 21 => 22, 22 => 23, 23 => 24, 24 => '`honorarium_claim_table`.`payment_date`', 25 => 26, 26 => 27, 27 => 28, 28 => 29, 29 => 30, 30 => 31, 31 => 32, 32 => 33],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-honorarium_claim_table',
					'template-printable' => 'children-honorarium_claim_table-printable',
					'query' => "SELECT `honorarium_claim_table`.`id` as 'id', `honorarium_claim_table`.`name_of_advisor` as 'name_of_advisor', `honorarium_claim_table`.`email_advisor` as 'email_advisor', `honorarium_claim_table`.`department_of_tih` as 'department_of_tih', `honorarium_claim_table`.`bank_account_no` as 'bank_account_no', `honorarium_claim_table`.`ifsc_code` as 'ifsc_code', `honorarium_claim_table`.`bank_name` as 'bank_name', `honorarium_claim_table`.`pan` as 'pan', `honorarium_claim_table`.`place_of_work` as 'place_of_work', if(`honorarium_claim_table`.`date_1`,date_format(`honorarium_claim_table`.`date_1`,'%d/%m/%Y'),'') as 'date_1', `honorarium_claim_table`.`hours_1` as 'hours_1', if(`honorarium_claim_table`.`date_2`,date_format(`honorarium_claim_table`.`date_2`,'%d/%m/%Y'),'') as 'date_2', `honorarium_claim_table`.`hours_2` as 'hours_2', if(`honorarium_claim_table`.`date_3`,date_format(`honorarium_claim_table`.`date_3`,'%d/%m/%Y'),'') as 'date_3', `honorarium_claim_table`.`hours_3` as 'hours_3', if(`honorarium_claim_table`.`date_4`,date_format(`honorarium_claim_table`.`date_4`,'%d/%m/%Y'),'') as 'date_4', `honorarium_claim_table`.`hours_4` as 'hours_4', if(`honorarium_claim_table`.`date_5`,date_format(`honorarium_claim_table`.`date_5`,'%d/%m/%Y'),'') as 'date_5', `honorarium_claim_table`.`hours_5` as 'hours_5', `honorarium_claim_table`.`total_no_of_days` as 'total_no_of_days', `honorarium_claim_table`.`total_no_of_hours` as 'total_no_of_hours', `honorarium_claim_table`.`case_reference_email_subject` as 'case_reference_email_subject', `honorarium_claim_table`.`activities` as 'activities', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS('',   `user_table1`.`memberID`, '::', `user_table1`.`name`), '') as 'coordinated_by_tih_user', if(`honorarium_claim_table`.`payment_date`,date_format(`honorarium_claim_table`.`payment_date`,'%d/%m/%Y'),'') as 'payment_date', `honorarium_claim_table`.`amount_paid` as 'amount_paid', `honorarium_claim_table`.`transaction_details` as 'transaction_details', `honorarium_claim_table`.`approval_status` as 'approval_status', `honorarium_claim_table`.`remarks_for_approval` as 'remarks_for_approval', `honorarium_claim_table`.`created_by` as 'created_by', `honorarium_claim_table`.`created_at` as 'created_at', `honorarium_claim_table`.`last_updated_by` as 'last_updated_by', `honorarium_claim_table`.`last_updated_at` as 'last_updated_at' FROM `honorarium_claim_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`honorarium_claim_table`.`coordinated_by_tih_user` "
				],
			],
			'all_bank_account_statement_table' => [
			],
			'payment_track_details_table' => [
			],
			'travel_table' => [
			],
			'travel_stay_table' => [
			],
			'travel_local_commute_table' => [
			],
			'r_and_d_progress' => [
			],
			'panel_decision_table_tdp' => [
			],
			'selected_proposals_final_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'selected_proposals_id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Selected proposals final -App <span class="hidden child-label-selected_proposals_final_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Breakthrough / Novel', 3 => 'Project title', 4 => 'Short name', 5 => 'Duration in months', 6 => 'Name of PI', 7 => 'Mobile number', 8 => 'Institute', 9 => 'Stage 1 in Rs.', 10 => 'Stage 2 in Rs.', 11 => 'Stage 3 in Rs.', 12 => 'Stage 4 in Rs.', 13 => 'Total budget specified in Rs.', 14 => 'One slide PPT link', 15 => 'Proposal link', 16 => 'Existing TRL', 17 => 'Expected TRL', 18 => 'Created by', 19 => 'Created at', 20 => 'Last updated by', 21 => 'Last updated at'],
					'display-field-names' => [0 => 'selected_proposals_id', 1 => 'project_id', 2 => 'breakthrough', 3 => 'project_title', 4 => 'short_name', 5 => 'duration_in_months', 6 => 'name_of_pi', 7 => 'mobile_number', 8 => 'institute', 9 => 'stage_1', 10 => 'stage_2', 11 => 'stage_3', 12 => 'stage_4', 13 => 'total_budget_specified', 14 => 'one_slide_ppt_link', 15 => 'proposal_link', 16 => 'existing_trl', 17 => 'expected_trl', 18 => 'created_by', 19 => 'created_at', 20 => 'last_updated_by', 21 => 'last_updated_at'],
					'sortable-fields' => [0 => '`selected_proposals_final_tdp`.`selected_proposals_id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18, 18 => 19, 19 => 20, 20 => 21, 21 => 22],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-selected_proposals_final_tdp',
					'template-printable' => 'children-selected_proposals_final_tdp-printable',
					'query' => "SELECT `selected_proposals_final_tdp`.`selected_proposals_id` as 'selected_proposals_id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `selected_proposals_final_tdp`.`breakthrough` as 'breakthrough', `selected_proposals_final_tdp`.`project_title` as 'project_title', `selected_proposals_final_tdp`.`short_name` as 'short_name', `selected_proposals_final_tdp`.`duration_in_months` as 'duration_in_months', `selected_proposals_final_tdp`.`name_of_pi` as 'name_of_pi', `selected_proposals_final_tdp`.`mobile_number` as 'mobile_number', `selected_proposals_final_tdp`.`institute` as 'institute', `selected_proposals_final_tdp`.`stage_1` as 'stage_1', `selected_proposals_final_tdp`.`stage_2` as 'stage_2', `selected_proposals_final_tdp`.`stage_3` as 'stage_3', `selected_proposals_final_tdp`.`stage_4` as 'stage_4', `selected_proposals_final_tdp`.`total_budget_specified` as 'total_budget_specified', `selected_proposals_final_tdp`.`one_slide_ppt_link` as 'one_slide_ppt_link', `selected_proposals_final_tdp`.`proposal_link` as 'proposal_link', `selected_proposals_final_tdp`.`existing_trl` as 'existing_trl', `selected_proposals_final_tdp`.`expected_trl` as 'expected_trl', `selected_proposals_final_tdp`.`created_by` as 'created_by', `selected_proposals_final_tdp`.`created_at` as 'created_at', `selected_proposals_final_tdp`.`last_updated_by` as 'last_updated_by', `selected_proposals_final_tdp`.`last_updated_at` as 'last_updated_at' FROM `selected_proposals_final_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`selected_proposals_final_tdp`.`project_id` "
				],
			],
			'stage_wise_budget_table_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Stage wise budget - App <span class="hidden child-label-stage_wise_budget_table_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Project title', 3 => 'Name of PI', 4 => 'Mobile number', 5 => 'Institute', 6 => 'Duration in months', 7 => 'Budget specified in Rs.', 8 => 'First phase', 9 => 'Second phase', 10 => 'Third phase', 11 => 'Fourth phase', 12 => 'Total', 13 => 'Final budget to be allocated Rs.', 14 => 'Proposal link', 15 => 'Created by', 16 => 'Created at', 17 => 'Last updated by', 18 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'project_title', 3 => 'name_of_pi', 4 => 'mobile_number', 5 => 'institute', 6 => 'duration_in_months', 7 => 'total_budget_specified', 8 => 'first_phase', 9 => 'second_phase', 10 => 'third_phase', 11 => 'fourth_phase', 12 => 'total', 13 => 'final_budget_to_be_allocated', 14 => 'proposal_link', 15 => 'created_by', 16 => 'created_at', 17 => 'last_updated_by', 18 => 'last_updated_at'],
					'sortable-fields' => [0 => '`stage_wise_budget_table_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18, 18 => 19],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-stage_wise_budget_table_tdp',
					'template-printable' => 'children-stage_wise_budget_table_tdp-printable',
					'query' => "SELECT `stage_wise_budget_table_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `stage_wise_budget_table_tdp`.`project_title` as 'project_title', `stage_wise_budget_table_tdp`.`name_of_pi` as 'name_of_pi', `stage_wise_budget_table_tdp`.`mobile_number` as 'mobile_number', `stage_wise_budget_table_tdp`.`institute` as 'institute', `stage_wise_budget_table_tdp`.`duration_in_months` as 'duration_in_months', `stage_wise_budget_table_tdp`.`total_budget_specified` as 'total_budget_specified', `stage_wise_budget_table_tdp`.`first_phase` as 'first_phase', `stage_wise_budget_table_tdp`.`second_phase` as 'second_phase', `stage_wise_budget_table_tdp`.`third_phase` as 'third_phase', `stage_wise_budget_table_tdp`.`fourth_phase` as 'fourth_phase', `stage_wise_budget_table_tdp`.`total` as 'total', `stage_wise_budget_table_tdp`.`final_budget_to_be_allocated` as 'final_budget_to_be_allocated', `stage_wise_budget_table_tdp`.`proposal_link` as 'proposal_link', `stage_wise_budget_table_tdp`.`created_by` as 'created_by', `stage_wise_budget_table_tdp`.`created_at` as 'created_at', `stage_wise_budget_table_tdp`.`last_updated_by` as 'last_updated_by', `stage_wise_budget_table_tdp`.`last_updated_at` as 'last_updated_at' FROM `stage_wise_budget_table_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`stage_wise_budget_table_tdp`.`project_id` "
				],
			],
			'first_level_shortlisted_proposals_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'First level shortlisted proposals - App <span class="hidden child-label-first_level_shortlisted_proposals_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Name', 3 => 'Institution', 4 => 'Domain of interest', 5 => 'Proposal link', 6 => 'First level comment', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'name', 3 => 'institution', 4 => 'domain_of_interest', 5 => 'proposal_link', 6 => 'first_level_comment', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`first_level_shortlisted_proposals_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-first_level_shortlisted_proposals_tdp',
					'template-printable' => 'children-first_level_shortlisted_proposals_tdp-printable',
					'query' => "SELECT `first_level_shortlisted_proposals_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `first_level_shortlisted_proposals_tdp`.`name` as 'name', `first_level_shortlisted_proposals_tdp`.`institution` as 'institution', `first_level_shortlisted_proposals_tdp`.`domain_of_interest` as 'domain_of_interest', `first_level_shortlisted_proposals_tdp`.`proposal_link` as 'proposal_link', `first_level_shortlisted_proposals_tdp`.`first_level_comment` as 'first_level_comment', `first_level_shortlisted_proposals_tdp`.`created_by` as 'created_by', `first_level_shortlisted_proposals_tdp`.`created_at` as 'created_at', `first_level_shortlisted_proposals_tdp`.`last_updated_by` as 'last_updated_by', `first_level_shortlisted_proposals_tdp`.`last_updated_at` as 'last_updated_at' FROM `first_level_shortlisted_proposals_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`first_level_shortlisted_proposals_tdp`.`project_id` "
				],
			],
			'budget_table_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Budget App <span class="hidden child-label-budget_table_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Title of the project', 3 => 'Name of PI', 4 => 'Institute', 5 => 'Date of presentation', 6 => 'Manpower', 7 => 'Travel', 8 => 'Infrastructure / Equipment', 9 => 'Consumables', 10 => 'Contigency', 11 => 'Overhead', 12 => 'Any other', 13 => 'Total budget in Rs.', 14 => 'Created by', 15 => 'Created at', 16 => 'Last updated by', 17 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'title_of_the_project', 3 => 'name_of_pi', 4 => 'institute', 5 => 'date_of_presentation', 6 => 'manpower', 7 => 'travel', 8 => 'infrastructure', 9 => 'consumables', 10 => 'contigency', 11 => 'overhead', 12 => 'any_other', 13 => 'total_budget', 14 => 'created_by', 15 => 'created_at', 16 => 'last_updated_by', 17 => 'last_updated_at'],
					'sortable-fields' => [0 => '`budget_table_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => '`budget_table_tdp`.`date_of_presentation`', 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16, 16 => 17, 17 => 18],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-budget_table_tdp',
					'template-printable' => 'children-budget_table_tdp-printable',
					'query' => "SELECT `budget_table_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `budget_table_tdp`.`title_of_the_project` as 'title_of_the_project', `budget_table_tdp`.`name_of_pi` as 'name_of_pi', `budget_table_tdp`.`institute` as 'institute', if(`budget_table_tdp`.`date_of_presentation`,date_format(`budget_table_tdp`.`date_of_presentation`,'%d/%m/%Y'),'') as 'date_of_presentation', `budget_table_tdp`.`manpower` as 'manpower', `budget_table_tdp`.`travel` as 'travel', `budget_table_tdp`.`infrastructure` as 'infrastructure', `budget_table_tdp`.`consumables` as 'consumables', `budget_table_tdp`.`contigency` as 'contigency', `budget_table_tdp`.`overhead` as 'overhead', `budget_table_tdp`.`any_other` as 'any_other', `budget_table_tdp`.`total_budget` as 'total_budget', `budget_table_tdp`.`created_by` as 'created_by', `budget_table_tdp`.`created_at` as 'created_at', `budget_table_tdp`.`last_updated_by` as 'last_updated_by', `budget_table_tdp`.`last_updated_at` as 'last_updated_at' FROM `budget_table_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`budget_table_tdp`.`project_id` "
				],
			],
			'panel_comments_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Panel comments - App <span class="hidden child-label-panel_comments_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Project title', 3 => 'Name of PI', 4 => 'Institute', 5 => 'Final budget in Rs.', 6 => 'Comments from YVN sir', 7 => 'Comments from Ramakrishna sir', 8 => 'Comments from Bharat Lohani sir', 9 => 'Remarks 1', 10 => 'Remarks 2', 11 => 'Finale decision', 12 => 'Created by', 13 => 'Created at', 14 => 'Last updated by', 15 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'project_title', 3 => 'name_of_pi', 4 => 'institute', 5 => 'final_budget', 6 => 'comments_from_yvn_sir', 7 => 'comments_from_ramakrishna_sir', 8 => 'comments_from_bharat_lohani_sir', 9 => 'remarks_1', 10 => 'remarks_2', 11 => 'finale_decision', 12 => 'created_by', 13 => 'created_at', 14 => 'last_updated_by', 15 => 'last_updated_at'],
					'sortable-fields' => [0 => '`panel_comments_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12, 12 => 13, 13 => 14, 14 => 15, 15 => 16],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-panel_comments_tdp',
					'template-printable' => 'children-panel_comments_tdp-printable',
					'query' => "SELECT `panel_comments_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `panel_comments_tdp`.`project_title` as 'project_title', `panel_comments_tdp`.`name_of_pi` as 'name_of_pi', `panel_comments_tdp`.`institute` as 'institute', `panel_comments_tdp`.`final_budget` as 'final_budget', `panel_comments_tdp`.`comments_from_yvn_sir` as 'comments_from_yvn_sir', `panel_comments_tdp`.`comments_from_ramakrishna_sir` as 'comments_from_ramakrishna_sir', `panel_comments_tdp`.`comments_from_bharat_lohani_sir` as 'comments_from_bharat_lohani_sir', `panel_comments_tdp`.`remarks_1` as 'remarks_1', `panel_comments_tdp`.`remarks_2` as 'remarks_2', `panel_comments_tdp`.`finale_decision` as 'finale_decision', `panel_comments_tdp`.`created_by` as 'created_by', `panel_comments_tdp`.`created_at` as 'created_at', `panel_comments_tdp`.`last_updated_by` as 'last_updated_by', `panel_comments_tdp`.`last_updated_at` as 'last_updated_at' FROM `panel_comments_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`panel_comments_tdp`.`project_id` "
				],
			],
			'selected_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Selected (Draft) - App <span class="hidden child-label-selected_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Project title', 3 => 'Name of PI', 4 => 'Institute', 5 => 'Budget in Rs.', 6 => 'Decision', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'project_title', 3 => 'name_of_pi', 4 => 'institute', 5 => 'budget', 6 => 'decision', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`selected_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-selected_tdp',
					'template-printable' => 'children-selected_tdp-printable',
					'query' => "SELECT `selected_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `selected_tdp`.`project_title` as 'project_title', `selected_tdp`.`name_of_pi` as 'name_of_pi', `selected_tdp`.`institute` as 'institute', `selected_tdp`.`budget` as 'budget', `selected_tdp`.`decision` as 'decision', `selected_tdp`.`created_by` as 'created_by', `selected_tdp`.`created_at` as 'created_at', `selected_tdp`.`last_updated_by` as 'last_updated_by', `selected_tdp`.`last_updated_at` as 'last_updated_at' FROM `selected_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`selected_tdp`.`project_id` "
				],
			],
			'address_tdp' => [
				'project_id' => [
					'parent-table' => 'panel_decision_table_tdp',
					'parent-primary-key' => 'panel_decision_id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Scheduled data timings - App <span class="hidden child-label-address_tdp child-field-caption">(Project ID::Title)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project ID::Title', 2 => 'Project title', 3 => 'Short name', 4 => 'Pincode', 5 => 'Lattitude', 6 => 'Longitude', 7 => 'Created by', 8 => 'Created at', 9 => 'Last updated by', 10 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_id', 2 => 'project_title', 3 => 'short_name', 4 => 'pincode', 5 => 'lattitude', 6 => 'longitude', 7 => 'created_by', 8 => 'created_at', 9 => 'last_updated_by', 10 => 'last_updated_at'],
					'sortable-fields' => [0 => '`address_tdp`.`id`', 1 => 2, 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-address_tdp',
					'template-printable' => 'children-address_tdp-printable',
					'query' => "SELECT `address_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`panel_decision_table_tdp1`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp1`.`project_title`), CONCAT_WS('',   `panel_decision_table_tdp1`.`project_id`, '::', `panel_decision_table_tdp1`.`project_title`), '') as 'project_id', `address_tdp`.`project_title` as 'project_title', `address_tdp`.`short_name` as 'short_name', `address_tdp`.`pincode` as 'pincode', `address_tdp`.`lattitude` as 'lattitude', `address_tdp`.`longitude` as 'longitude', `address_tdp`.`created_by` as 'created_by', `address_tdp`.`created_at` as 'created_at', `address_tdp`.`last_updated_by` as 'last_updated_by', `address_tdp`.`last_updated_at` as 'last_updated_at' FROM `address_tdp` LEFT JOIN `panel_decision_table_tdp` as panel_decision_table_tdp1 ON `panel_decision_table_tdp1`.`panel_decision_id`=`address_tdp`.`project_id` "
				],
			],
			'summary_table_tdp' => [
			],
			'project_details_tdp' => [
				'project_number' => [
					'parent-table' => 'summary_table_tdp',
					'parent-primary-key' => 'id',
					'child-primary-key' => 'id',
					'child-primary-key-index' => 0,
					'tab-label' => 'Project details - App <span class="hidden child-label-project_details_tdp child-field-caption">(Project number)</span>',
					'auto-close' => false,
					'table-icon' => 'table.gif',
					'display-refresh' => true,
					'display-add-new' => true,
					'forced-where' => '',
					'display-fields' => [0 => 'ID', 1 => 'Project number', 2 => 'Stage 1st (12 Months)', 3 => 'Stage 2nd (12 Months)', 4 => 'Stage 3rd (12 Months)', 5 => 'Stage 4th (12 Months)', 6 => 'Total in Rs.', 7 => 'Details', 8 => 'Created by', 9 => 'Created at', 10 => 'Last updated by', 11 => 'Last updated at'],
					'display-field-names' => [0 => 'id', 1 => 'project_number', 2 => 'stage_1', 3 => 'stage_2', 4 => 'stage_3', 5 => 'stage_4', 6 => 'total', 7 => 'details', 8 => 'created_by', 9 => 'created_at', 10 => 'last_updated_by', 11 => 'last_updated_at'],
					'sortable-fields' => [0 => '`project_details_tdp`.`id`', 1 => '`summary_table_tdp1`.`project_number`', 2 => 3, 3 => 4, 4 => 5, 5 => 6, 6 => 7, 7 => 8, 8 => 9, 9 => 10, 10 => 11, 11 => 12],
					'records-per-page' => 10,
					'default-sort-by' => 0,
					'default-sort-direction' => 'desc',
					'open-detail-view-on-click' => true,
					'display-page-selector' => true,
					'show-page-progress' => true,
					'template' => 'children-project_details_tdp',
					'template-printable' => 'children-project_details_tdp-printable',
					'query' => "SELECT `project_details_tdp`.`id` as 'id', IF(    CHAR_LENGTH(`summary_table_tdp1`.`project_number`), CONCAT_WS('',   `summary_table_tdp1`.`project_number`), '') as 'project_number', `project_details_tdp`.`stage_1` as 'stage_1', `project_details_tdp`.`stage_2` as 'stage_2', `project_details_tdp`.`stage_3` as 'stage_3', `project_details_tdp`.`stage_4` as 'stage_4', `project_details_tdp`.`total` as 'total', `project_details_tdp`.`details` as 'details', `project_details_tdp`.`created_by` as 'created_by', `project_details_tdp`.`created_at` as 'created_at', `project_details_tdp`.`last_updated_by` as 'last_updated_by', `project_details_tdp`.`last_updated_at` as 'last_updated_at' FROM `project_details_tdp` LEFT JOIN `summary_table_tdp` as summary_table_tdp1 ON `summary_table_tdp1`.`id`=`project_details_tdp`.`project_number` "
				],
			],
		];

		if($skipPermissions) return $pcConfig;

		if(!in_array($filterByPermission, ['access', 'insert', 'edit', 'delete'])) $filterByPermission = 'view';

		/**
		* dynamic configuration based on current user's permissions
		* $userPCConfig array is populated only with parent tables where the user has access to
		* at least one child table
		*/
		$userPCConfig = [];
		foreach($pcConfig as $tn => $lookupFields) {
			$perm = getTablePermissions($tn);
			if(!$perm[$filterByPermission]) continue;

			foreach($lookupFields as $fn => $ChildConfig) {
				$permParent = getTablePermissions($ChildConfig['parent-table']);
				if(!$permParent[$filterByPermission]) continue;

				$userPCConfig[$tn][$fn] = $pcConfig[$tn][$fn];
				// show add new only if configured above AND the user has insert permission
				$userPCConfig[$tn][$fn]['display-add-new'] = ($perm['insert'] && $pcConfig[$tn][$fn]['display-add-new']);
			}
		}

		return $userPCConfig;
	}

	#########################################################

	function getChildTables($parentTable, $skipPermissions = false, $filterByPermission = 'view') {
		$pcConfig = getLookupFields($skipPermissions, $filterByPermission);
		$childTables = [];
		foreach($pcConfig as $tn => $lookupFields)
			foreach($lookupFields as $fn => $ChildConfig)
				if($ChildConfig['parent-table'] == $parentTable)
					$childTables[$tn][$fn] = $ChildConfig;

		return $childTables;
	}

	#########################################################

	function isDetailViewEnabled($tn) {
		$tables = ['user_table', 'suggestion', 'approval_table', 'car_table', 'car_usage_table', 'cycle_table', 'cycle_usage_table', 'gym_table', 'coffee_table', 'event_table', 'outcomes_expected_table', 'event_decision_table', 'meetings_table', 'agenda_table', 'decision_table', 'participants_table', 'action_actor', 'visiting_card_table', 'mou_details_table', 'mou_company_area_details_table', 'goal_setting_table', 'goal_progress_table', 'task_setting_table', 'subtask_setting_table', 'internship_fellowship_details_app', 'star_pnt', 'hrd_sdp_events_table', 'training_program_on_geospatial_tchnologies_table', 'space_day_school_details_app', 'space_day_college_student_table', 'school_list', 'sdp_participants_college_details_table', 'asset_table', 'asset_allotment_table', 'it_inventory_app', 'it_inventory_billing_details', 'it_inventory_allotment_table', 'computer_details_table', 'computer_usage_table', 'employees_personal_data_table', 'employees_designation_table', 'employees_appraisal_table', 'employees_appraisal_feedback_table', 'beyond_workingHours_table', 'attendence_details_table', 'leave_table', 'work_from_home_table', 'navavishkar_stay_table', 'navavishkar_stay_payment_table', 'email_id_allocation_table', 'all_startup_data_table', 'shortlisted_startups_for_fund_table', 'shortlisted_startups_dd_and_agreement_table', 'vikas_startup_applications_table', 'programs_table', 'evaluation_table', 'problem_statement_table', 'evaluators_table', 'approval_billing_table', 'honorarium_claim_table', 'all_bank_account_statement_table', 'payment_track_details_table', 'travel_table', 'travel_stay_table', 'travel_local_commute_table', 'r_and_d_progress', 'panel_decision_table_tdp', 'selected_proposals_final_tdp', 'stage_wise_budget_table_tdp', 'first_level_shortlisted_proposals_tdp', 'budget_table_tdp', 'panel_comments_tdp', 'selected_tdp', 'address_tdp', 'summary_table_tdp', 'project_details_tdp', ];
		return in_array($tn, $tables);
	}

	#########################################################

	function appDir($path = '') {
		// if path not empty and doesn't start with a slash, add it
		if($path && $path[0] != '/') $path = '/' . $path;
		return __DIR__ . $path;
	}

	#########################################################

	/**
	 * Inserts a new record in a table, performing various before and after tasks
	 * @param string $tableName the name of the table to insert into
	 * @param array $data associative array of field names and values to insert
	 * @param string $recordOwner the username of the record owner
	 * @param string $errorMessage error message to be set in case of failure
	 * 
	 * @return mixed the ID of the inserted record if successful, false otherwise
	 */
	function tableInsert($tableName, $data, $recordOwner, &$errorMessage = '') {
		global $Translation;

		// mm: can member insert record?
		if(!getTablePermissions($tableName)['insert']) {
			$errorMessage = $Translation['no insert permission'];
			return false;
		}

		$memberInfo = getMemberInfo();

		// check for required fields
		$fields = get_table_fields($tableName);
		$notNullFields = notNullFields($tableName);
		foreach($notNullFields as $fieldName) {
			if($data[$fieldName] !== '') continue;

			$errorMessage = "{$fields[$fieldName]['info']['caption']}: {$Translation['field not null']}";
			return false;
		}

		@include_once(__DIR__ . "/hooks/{$tableName}.php");

		// hook: before_insert
		$beforeInsertFunc = "{$tableName}_before_insert";
		if(function_exists($beforeInsertFunc)) {
			$args = [];
			if(!$beforeInsertFunc($data, $memberInfo, $args)) {
				if(isset($args['error_message'])) $errorMessage = $args['error_message'];
				return false;
			}
		}

		$pkIsAutoInc = pkIsAutoIncrement($tableName);
		$pkField = getPKFieldName($tableName) ?: '';

		$error = '';
		// set empty fields to NULL
		$data = array_map(function($v) { return ($v === '' ? NULL : $v); }, $data);
		insert($tableName, backtick_keys_once($data), $error);
		if($error) {
			$errorMessage = $error;
			return false;
		}

		$recID = $pkIsAutoInc ? db_insert_id() : ($data[$pkField] ?? false);

		update_calc_fields($tableName, $recID, calculated_fields()[$tableName]);

		// hook: after_insert
		$afterInsertFunc = "{$tableName}_after_insert";
		if(function_exists($afterInsertFunc)) {
			if($row = getRecord($tableName, $recID)) {
				$data = array_map('makeSafe', $row);
			}
			$data['selectedID'] = makeSafe($recID);
			$args = [];
			if(!$afterInsertFunc($data, $memberInfo, $args)) { return $recID; }
		}

		// mm: save ownership data
		// record owner is current user
		set_record_owner($tableName, $recID, $recordOwner);

		return $recID;
	}

	#########################################################

	/**
	 * Checks whether the primary key of a table is auto-increment
	 * @param string $tn the name of the table
	 * 
	 * @return bool true if the primary key is auto-increment, false otherwise
	 */
	function pkIsAutoIncrement($tn) {
		// caching
		static $cache = [];

		if(isset($cache[$tn])) return $cache[$tn];

		$pk = getPKFieldName($tn);
		if(!$pk) {
			$cache[$tn] = false;
			return false;
		}

		$isAutoInc = sqlValue("SHOW COLUMNS FROM `$tn` WHERE Field='{$pk}' AND Extra LIKE '%auto_increment%'");
		$cache[$tn] = $isAutoInc ? true : false;
		return $cache[$tn];
	}

	#########################################################

	/**
	 * @return bool true if the current user is an admin and revealing SQL is allowed, false otherwise
	 */
	function showSQL() {
		$allowAdminShowSQL = true;
		return $allowAdminShowSQL && getLoggedAdmin() !== false;
	}

