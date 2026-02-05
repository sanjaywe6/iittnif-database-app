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

		setupTable('cycle_table', []);
		setupIndexes('cycle_table', ['responsible_contact_person',]);

		setupTable('cycle_usage_table', []);
		setupIndexes('cycle_usage_table', ['cycle_lookup',]);

		setupTable('gym_table', []);

		setupTable('coffee_table', []);

		setupTable('cafeteria_table', []);

		setupTable('event_table', []);

		setupTable('outcomes_expected_table', []);
		setupIndexes('outcomes_expected_table', ['event_lookup',]);

		setupTable('event_decision_table', []);
		setupIndexes('event_decision_table', ['outcomes_expected_lookup','decision_actor',]);

		setupTable('meetings_table', []);
		setupIndexes('meetings_table', ['visiting_card_lookup','event_lookup',]);

		setupTable('agenda_table', []);
		setupIndexes('agenda_table', ['meeting_lookup',]);

		setupTable('decision_table', []);
		setupIndexes('decision_table', ['agenda_lookup','decision_actor',]);

		setupTable('participants_table', []);
		setupIndexes('participants_table', ['event_lookup','meeting_lookup',]);

		setupTable('action_actor', []);
		setupIndexes('action_actor', ['actor',]);

		setupTable('visiting_card_table', []);
		setupIndexes('visiting_card_table', ['given_by',]);

		setupTable('mou_details_table', []);
		setupIndexes('mou_details_table', ['assigned_mou_to',]);

		setupTable('goal_setting_table', []);
		setupIndexes('goal_setting_table', ['supervisor_name','assigned_to',]);

		setupTable('goal_progress_table', []);
		setupIndexes('goal_progress_table', ['goal_lookup','remarks_by',]);

		setupTable('task_allocation_table', []);
		setupIndexes('task_allocation_table', ['supervisor_name','assigned_to',]);

		setupTable('task_progress_status_table', []);
		setupIndexes('task_progress_status_table', ['task_lookup',]);

		setupTable('timesheet_entry_table', []);
		setupIndexes('timesheet_entry_table', ['reporting_manager',]);

		setupTable('internship_fellowship_details_app', []);

		setupTable('star_pnt', []);
		setupIndexes('star_pnt', ['iittnif_id',]);

		setupTable('hrd_sdp_events_table', []);

		setupTable('training_program_on_geospatial_tchnologies_table', []);

		setupTable('space_day_school_details_app', []);

		setupTable('space_day_college_student_table', []);

		setupTable('school_list', []);

		setupTable('sdp_participants_college_details_table', []);

		setupTable('asset_table', []);

		setupTable('asset_allotment_table', []);
		setupIndexes('asset_allotment_table', ['asset_lookup','select_employee','alloted_by',]);

		setupTable('sub_asset_table', []);

		setupTable('sub_asset_allotment_table', []);
		setupIndexes('sub_asset_allotment_table', ['sub_asset_lookup','select_employee','alloted_by',]);

		setupTable('it_inventory_app', []);
		setupIndexes('it_inventory_app', ['sactioned_by',]);

		setupTable('it_inventory_billing_details', []);
		setupIndexes('it_inventory_billing_details', ['it_inventory_lookup',]);

		setupTable('it_inventory_allotment_table', []);
		setupIndexes('it_inventory_allotment_table', ['select_employee','alloted_by',]);

		setupTable('computer_details_table', []);

		setupTable('computer_user_details', []);
		setupIndexes('computer_user_details', ['pc_id',]);

		setupTable('computer_allotment_table', []);
		setupIndexes('computer_allotment_table', ['pc_id',]);

		setupTable('employees_personal_data_table', []);

		setupTable('employees_designation_table', []);
		setupIndexes('employees_designation_table', ['employee_lookup','reporting_officer','reviewing_officer',]);

		setupTable('employees_appraisal_table', []);
		setupIndexes('employees_appraisal_table', ['employee_designation_lookup','reviewing_officer',]);

		setupTable('beyond_working_hours_table', []);

		setupTable('leave_table', []);

		setupTable('half_day_leave_table', []);

		setupTable('work_from_home_table', []);

		setupTable('work_from_home_tasks_app', []);
		setupIndexes('work_from_home_tasks_app', ['work_from_home_details',]);

		setupTable('navavishkar_stay_table', []);

		setupTable('navavishkar_stay_payment_table', []);
		setupIndexes('navavishkar_stay_payment_table', ['navavishakr_stay_details',]);

		setupTable('email_id_allocation_table', []);
		setupIndexes('email_id_allocation_table', ['reporting_manager',]);

		setupTable('attendence_details_table', []);

		setupTable('all_startup_data_table', []);

		setupTable('shortlisted_startups_for_fund_table', []);
		setupIndexes('shortlisted_startups_for_fund_table', ['startup',]);

		setupTable('shortlisted_startups_dd_and_agreement_table', []);
		setupIndexes('shortlisted_startups_dd_and_agreement_table', ['startup',]);

		setupTable('vikas_startup_applications_table', []);

		setupTable('programs_table', []);

		setupTable('evaluation_table', []);
		setupIndexes('evaluation_table', ['select_startup',]);

		setupTable('problem_statement_table', []);
		setupIndexes('problem_statement_table', ['select_program_id',]);

		setupTable('evaluators_table', []);
		setupIndexes('evaluators_table', ['evaluation_lookup',]);

		setupTable('approval_billing_table', []);
		setupIndexes('approval_billing_table', ['approval_lookup','paid_by',]);

		setupTable('honorarium_claim_table', []);
		setupIndexes('honorarium_claim_table', ['coordinated_by_tih_user',]);

		setupTable('honorarium_Activities', []);

		setupTable('all_bank_account_statement_table', []);

		setupTable('payment_track_details_table', []);

		setupTable('travel_table', []);

		setupTable('travel_stay_table', []);

		setupTable('travel_local_commute_table', []);

		setupTable('r_and_d_progress', []);

		setupTable('panel_decision_table_tdp', []);

		setupTable('selected_proposals_final_tdp', []);
		setupIndexes('selected_proposals_final_tdp', ['project_id',]);

		setupTable('stage_wise_budget_table_tdp', []);
		setupIndexes('stage_wise_budget_table_tdp', ['project_id',]);

		setupTable('first_level_shortlisted_proposals_tdp', []);
		setupIndexes('first_level_shortlisted_proposals_tdp', ['project_id',]);

		setupTable('budget_table_tdp', []);
		setupIndexes('budget_table_tdp', ['project_id',]);

		setupTable('panel_comments_tdp', []);
		setupIndexes('panel_comments_tdp', ['project_id',]);

		setupTable('selected_tdp', []);
		setupIndexes('selected_tdp', ['project_id',]);

		setupTable('address_tdp', []);
		setupIndexes('address_tdp', ['project_id',]);

		setupTable('summary_table_tdp', []);

		setupTable('project_details_tdp', []);
		setupIndexes('project_details_tdp', ['project_number',]);

		setupTable('newsletter_table', []);

		setupTable('contact_call_log_table', []);

		setupTable('r_and_d_monthly_progress_app', []);
		setupIndexes('r_and_d_monthly_progress_app', ['r_and_d_lookup',]);

		setupTable('r_and_d_quarterly_progress_app', []);
		setupIndexes('r_and_d_quarterly_progress_app', ['r_and_d_lookup',]);

		setupTable('projects', []);

		setupTable('td_projects_td_intellectual_property', []);
		setupIndexes('td_projects_td_intellectual_property', ['source_of_ip',]);

		setupTable('td_projects_td_technology_products', []);
		setupIndexes('td_projects_td_technology_products', ['source_of_ip',]);

		setupTable('td_publications_and_intellectual_activities', []);

		setupTable('td_publications', []);
		setupIndexes('td_publications', ['publications_and_intellectual_activities_details','source_of_ip',]);

		setupTable('td_ipr', []);
		setupIndexes('td_ipr', ['publications_and_intellectual_activities_details',]);

		setupTable('td_cps_research_base', []);

		setupTable('ed_tbi', []);

		setupTable('ed_startup_companies', []);

		setupTable('ed_gcc', []);

		setupTable('ed_eir', []);

		setupTable('ed_job_creation', []);

		setupTable('hrd_Fellowship', []);

		setupTable('hrd_sd', []);

		setupTable('it_International_Collaboration', []);



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
