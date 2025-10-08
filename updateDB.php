<?php
	// check this file's MD5 to make sure it wasn't called before
	$tenantId = Authentication::tenantIdPadded();
	$setupHash = __DIR__ . "/setup{$tenantId}.md5";

	$prevMD5 = @file_get_contents($setupHash);
	$thisMD5 = md5_file(__FILE__);

	// check if this setup file already run
	if($thisMD5 != $prevMD5) {
		// set up tables
		setupTable('user_table', []);

		setupTable('suggestion', []);

		setupTable('approval_table', []);
		setupIndexes('approval_table', ['person_responsbility',]);

		setupTable('techlead_web_page', []);

		setupTable('navavishkar_stay_facilities_table', []);
		setupIndexes('navavishkar_stay_facilities_table', ['custodian',]);

		setupTable('navavishkar_stay_facilities_allotment_table', []);
		setupIndexes('navavishkar_stay_facilities_allotment_table', ['item_lookup','select_employee','alloted_by',]);

		setupTable('car_table', []);

		setupTable('car_usage_table', []);
		setupIndexes('car_usage_table', ['car_lookup',]);

		setupTable('cycle_table', [
				"ALTER TABLE `cycle_table` ADD `created_at_1` VARCHAR(255) NULL ",
				"ALTER TABLE `cycle_table` DROP `created_at_1`",
			]);
		setupIndexes('cycle_table', ['responsible_contact_person',]);

		setupTable('cycle_usage_table', []);
		setupIndexes('cycle_usage_table', ['cycle_lookup',]);

		setupTable('gym_table', [
				"ALTER TABLE `gym_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('coffee_table', [
				"ALTER TABLE `coffee_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('cafeteria_table', [
				"ALTER TABLE `cafeteria_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('event_table', [
				"ALTER TABLE `event_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('outcomes_expected_table', [
				"ALTER TABLE `outcomes_expected_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('outcomes_expected_table', ['event_lookup',]);

		setupTable('event_decision_table', [
				"ALTER TABLE `event_decision_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('event_decision_table', ['outcomes_expected_lookup','decision_actor',]);

		setupTable('meetings_table', [
				"ALTER TABLE `meetings_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('meetings_table', ['visiting_card_lookup','event_lookup',]);

		setupTable('agenda_table', [
				"ALTER TABLE `agenda_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('agenda_table', ['meeting_lookup',]);

		setupTable('decision_table', [
				"ALTER TABLE `decision_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('decision_table', ['agenda_lookup','decision_actor',]);

		setupTable('participants_table', [
				"ALTER TABLE `participants_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('participants_table', ['event_lookup','meeting_lookup',]);

		setupTable('action_actor', [
				"ALTER TABLE `action_actor` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('action_actor', ['actor',]);

		setupTable('visiting_card_table', [
				"ALTER TABLE `visiting_card_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('visiting_card_table', ['given_by',]);

		setupTable('mou_details_table', [
				"ALTER TABLE `mou_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('mou_details_table', ['assigned_mou_to',]);

		setupTable('mou_company_area_details_table', [
				"ALTER TABLE `mou_company_area_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('mou_company_area_details_table', ['name_of_the_company','assigned_mou_to',]);

		setupTable('goal_setting_table', [
				"ALTER TABLE `goal_setting_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('goal_setting_table', ['supervisor_name','assigned_to',]);

		setupTable('goal_progress_table', [
				"ALTER TABLE `goal_progress_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('goal_progress_table', ['goal_lookup','remarks_by',]);

		setupTable('task_setting_table', [
				"ALTER TABLE `task_setting_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('task_setting_table', ['supervisor_name','assigned_to',]);

		setupTable('subtask_setting_table', [
				"ALTER TABLE `subtask_setting_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('subtask_setting_table', ['task_lookup','supervisor_name','assigned_to',]);

		setupTable('internship_fellowship_details_app', [
				"ALTER TABLE `internship_fellowship_details_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('star_pnt', [
				"ALTER TABLE `star_pnt` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('star_pnt', ['iittnif_id',]);

		setupTable('hrd_sdp_events_table', [
				"ALTER TABLE `hrd_sdp_events_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('training_program_on_geospatial_tchnologies_table', [
				"ALTER TABLE `training_program_on_geospatial_tchnologies_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('space_day_school_details_app', [
				"ALTER TABLE `space_day_school_details_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('space_day_college_student_table', [
				"ALTER TABLE `space_day_college_student_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('school_list', [
				"ALTER TABLE `school_list` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('sdp_participants_college_details_table', [
				"ALTER TABLE `sdp_participants_college_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('asset_table', [
				"ALTER TABLE `asset_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('asset_allotment_table', [
				"ALTER TABLE `asset_allotment_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('asset_allotment_table', ['asset_lookup','select_employee','alloted_by',]);

		setupTable('sub_asset_table', [
				"ALTER TABLE `sub_asset_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('sub_asset_allotment_table', [
				"ALTER TABLE `sub_asset_allotment_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('sub_asset_allotment_table', ['sub_asset_lookup','select_employee','alloted_by',]);

		setupTable('it_inventory_app', [
				"ALTER TABLE `it_inventory_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('it_inventory_app', ['sactioned_by',]);

		setupTable('it_inventory_billing_details', [
				"ALTER TABLE `it_inventory_billing_details` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('it_inventory_billing_details', ['it_inventory_lookup',]);

		setupTable('it_inventory_allotment_table', [
				"ALTER TABLE `it_inventory_allotment_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('it_inventory_allotment_table', ['select_employee','alloted_by',]);

		setupTable('computer_details_table', [
				"ALTER TABLE `computer_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('computer_user_details', [
				"ALTER TABLE `computer_user_details` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('computer_user_details', ['pc_id',]);

		setupTable('computer_allotment_table', [
				"ALTER TABLE `computer_allotment_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('computer_allotment_table', ['pc_id',]);

		setupTable('employees_personal_data_table', [
				"ALTER TABLE `employees_personal_data_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('employees_designation_table', [
				"ALTER TABLE `employees_designation_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('employees_designation_table', ['employee_lookup','reporting_officer','reviewing_officer',]);

		setupTable('employees_appraisal_table', [
				"ALTER TABLE `employees_appraisal_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('employees_appraisal_table', ['employee_designation_lookup','reviewing_officer',]);

		setupTable('beyond_working_hours_table', [
				"ALTER TABLE `beyond_working_hours_table` ADD `last_updated_by_username_1` VARCHAR(255) NULL ",
				"ALTER TABLE `beyond_working_hours_table` DROP `last_updated_by_username_1`",
			]);

		setupTable('leave_table', []);

		setupTable('half_day_leave_table', [
				"ALTER TABLE `half_day_leave_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('work_from_home_table', [
				"ALTER TABLE `work_from_home_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('work_from_home_tasks_app', [
				"ALTER TABLE `work_from_home_tasks_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('work_from_home_tasks_app', ['work_from_home_details',]);

		setupTable('navavishkar_stay_table', [
				"ALTER TABLE `navavishkar_stay_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('navavishkar_stay_payment_table', [
				"ALTER TABLE `navavishkar_stay_payment_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('navavishkar_stay_payment_table', ['navavishakr_stay_details',]);

		setupTable('email_id_allocation_table', [
				"ALTER TABLE `email_id_allocation_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('email_id_allocation_table', ['reporting_manager',]);

		setupTable('attendence_details_table', [
				"ALTER TABLE `attendence_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('all_startup_data_table', [
				"ALTER TABLE `all_startup_data_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('shortlisted_startups_for_fund_table', [
				"ALTER TABLE `shortlisted_startups_for_fund_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('shortlisted_startups_for_fund_table', ['startup',]);

		setupTable('shortlisted_startups_dd_and_agreement_table', [
				"ALTER TABLE `shortlisted_startups_dd_and_agreement_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('shortlisted_startups_dd_and_agreement_table', ['startup',]);

		setupTable('vikas_startup_applications_table', [
				"ALTER TABLE `vikas_startup_applications_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('programs_table', [
				"ALTER TABLE `programs_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('evaluation_table', [
				"ALTER TABLE `evaluation_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('evaluation_table', ['select_startup',]);

		setupTable('problem_statement_table', [
				"ALTER TABLE `problem_statement_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('problem_statement_table', ['select_program_id',]);

		setupTable('evaluators_table', [
				"ALTER TABLE `evaluators_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('evaluators_table', ['evaluation_lookup',]);

		setupTable('approval_billing_table', [
				"ALTER TABLE `approval_billing_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('approval_billing_table', ['approval_lookup','paid_by',]);

		setupTable('honorarium_claim_table', [
				"ALTER TABLE `honorarium_claim_table` ADD `last_updated_by_username_1` VARCHAR(255) NULL ",
				"ALTER TABLE `honorarium_claim_table` DROP `last_updated_by_username_1`",
			]);
		setupIndexes('honorarium_claim_table', ['coordinated_by_tih_user',]);

		setupTable('all_bank_account_statement_table', [
				"ALTER TABLE `all_bank_account_statement_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('payment_track_details_table', [
				"ALTER TABLE `payment_track_details_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('travel_table', [
				"ALTER TABLE `travel_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('travel_stay_table', [
				"ALTER TABLE `travel_stay_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('travel_local_commute_table', [
				"ALTER TABLE `travel_local_commute_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('r_and_d_progress', [
				"ALTER TABLE `r_and_d_progress` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('panel_decision_table_tdp', [
				"ALTER TABLE `panel_decision_table_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('selected_proposals_final_tdp', [
				"ALTER TABLE `selected_proposals_final_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('selected_proposals_final_tdp', ['project_id',]);

		setupTable('stage_wise_budget_table_tdp', [
				"ALTER TABLE `stage_wise_budget_table_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('stage_wise_budget_table_tdp', ['project_id',]);

		setupTable('first_level_shortlisted_proposals_tdp', [
				"ALTER TABLE `first_level_shortlisted_proposals_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('first_level_shortlisted_proposals_tdp', ['project_id',]);

		setupTable('budget_table_tdp', [
				"ALTER TABLE `budget_table_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('budget_table_tdp', ['project_id',]);

		setupTable('panel_comments_tdp', [
				"ALTER TABLE `panel_comments_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('panel_comments_tdp', ['project_id',]);

		setupTable('selected_tdp', [
				"ALTER TABLE `selected_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('selected_tdp', ['project_id',]);

		setupTable('address_tdp', [
				"ALTER TABLE `address_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('address_tdp', ['project_id',]);

		setupTable('summary_table_tdp', [
				"ALTER TABLE `summary_table_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('project_details_tdp', [
				"ALTER TABLE `project_details_tdp` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('project_details_tdp', ['project_number',]);

		setupTable('newsletter_table', [
				"ALTER TABLE `newsletter_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('contact_call_log_table', [
				"ALTER TABLE `contact_call_log_table` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);

		setupTable('r_and_d_monthly_progress_app', [
				"ALTER TABLE `r_and_d_monthly_progress_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('r_and_d_monthly_progress_app', ['r_and_d_lookup',]);

		setupTable('r_and_d_quarterly_progress_app', [
				"ALTER TABLE `r_and_d_quarterly_progress_app` ADD `last_updated_by_username` VARCHAR(255) NULL ",
			]);
		setupIndexes('r_and_d_quarterly_progress_app', ['r_and_d_lookup',]);



		// set up internal tables
		setupTable('appgini_query_log', []);
		setupTable('appgini_csv_import_jobs', []);

		// save MD5
		@file_put_contents($setupHash, $thisMD5);
	}


	function setupIndexes($tableName, $arrFields) {
		if(!is_array($arrFields) || !count($arrFields)) return false;

		foreach($arrFields as $fieldName) {
			if(!$res = @db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")) continue;
			if(!$row = @db_fetch_assoc($res)) continue;
			if($row['Key']) continue;

			@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
		}
	}


	function setupTable($tableName, $arrAlter = []) {
		global $Translation;
		$oldTableName = '';

		$createSQL = createTableIfNotExists($tableName, true);
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(!empty($arrAlter)) {
			$matches = [];
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/i", $arrAlter[0], $matches)) {
				$oldTableName = $matches[1];
			}
		}

		if($res = @db_query("SELECT COUNT(1) FROM `$tableName`")) { // table already exists
			if($row = @db_fetch_array($res)) {
				echo str_replace(['<TableName>', '<NumRecords>'], [$tableName, $row[0]], $Translation['table exists']);
				if(!empty($arrAlter)) {
					echo '<br>';
					foreach($arrAlter as $alter) {
						if($alter != '') {
							echo "$alter ... ";
							if(!@db_query($alter)) {
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							} else {
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				} else {
					echo $Translation['table uptodate'];
				}
			} else {
				echo str_replace('<TableName>', $tableName, $Translation['couldnt count']);
			}
		} else { // given tableName doesn't exist

			if($oldTableName != '') { // if we have a table rename query
				if($ro = @db_query("SELECT COUNT(1) FROM `$oldTableName`")) { // if old table exists, rename it.
					$renameQuery = array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)) {
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					} else {
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(!empty($arrAlter)) setupTable($tableName, $arrAlter); // execute Alter queries on renamed table ...
				} else { // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName); // no Alter queries passed ...
				}
			} else { // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)) {
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';

					// create table with a dummy field
					@db_query("CREATE TABLE IF NOT EXISTS `$tableName` (`_dummy_deletable_field` TINYINT)");
				} else {
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}

			// set Admin group permissions for newly created table if membership_grouppermissions exists
			if($ro = @db_query("SELECT COUNT(1) FROM `membership_grouppermissions`")) {
				// get Admins group id
				$ro = @db_query("SELECT `groupID` FROM `membership_groups` WHERE `name`='Admins'");
				if($ro) {
					$adminGroupID = intval(db_fetch_row($ro)[0]);
					if($adminGroupID) @db_query("INSERT IGNORE INTO `membership_grouppermissions` SET
						`groupID`='$adminGroupID',
						`tableName`='$tableName',
						`allowInsert`=1, `allowView`=1, `allowEdit`=1, `allowDelete`=1
					");
				}
			}
		}

		echo '</div>';

		$out = ob_get_clean();
		if(defined('APPGINI_SETUP') && APPGINI_SETUP) echo $out;
	}
