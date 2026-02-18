<?php
	########################################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		set_headers() -- sets HTTP headers (encoding, same-origin frame policy, .. etc)
		getTableList() -- returns an associative array [tableName => [tableCaption, tableDescription, tableIcon], ...] of tables accessible by current user
		getThumbnailSpecs($tableName, $fieldName, $view) -- returns an associative array specifying the width, height and identifier of the thumbnail file.
		createThumbnail($img, $specs) -- $specs is an array as returned by getThumbnailSpecs(). Returns true on success, false on failure.
		makeSafe($string)
		formatUri($uri) -- convert \ to / and strip slashes from uri start/end
		checkPermissionVal($pvn)
		sql($statement, $o)
		sqlValue($statement)
		getLoggedAdmin()
		logOutUser()
		getPKFieldName($tn)
		getCSVData($tn, $pkValue, $stripTag=true)
		errorMsg($msg)
		redirect($URL, $absolute=FALSE)
		htmlRadioGroup($name, $arrValue, $arrCaption, $selectedValue, $selClass="", $class="", $separator="<br>")
		htmlSelect($name, $arrValue, $arrCaption, $selectedValue, $class="", $selectedClass="")
		htmlSQLSelect($name, $sql, $selectedValue, $class="", $selectedClass="")
		isEmail($email) -- returns $email if valid or false otherwise.
		notifyMemberApproval($memberID) -- send an email to member acknowledging his approval by admin, returns false if no mail is sent
		setupMembership() -- check if membership tables exist or not. If not, create them.
		thisOr($this_val, $or) -- return $this_val if it has a value, or $or if not.
		getUploadedFile($FieldName, $MaxSize=0, $FileTypes='csv|txt', $NoRename=false, $dir='')
		toBytes($val)
		convertLegacyOptions($CSVList)
		getValueGivenCaption($query, $caption)
		time24($t) -- return time in 24h format
		time12($t) -- return time in 12h format
		application_url($page) -- return absolute URL of provided page
		is_ajax() -- return true if this is an ajax request, false otherwise
		is_allowed_username($username, $exception = false) -- returns username if valid and unique, or false otherwise (if exception is provided and same as username, no uniqueness check is performed)
		csrf_token($validate) -- csrf-proof a form
		get_plugins() -- scans for installed plugins and returns them in an array ('name', 'title', 'icon' or 'glyphicon', 'admin_path')
		maintenance_mode($new_status = '') -- retrieves (and optionally sets) maintenance mode status
		html_attr($str) -- prepare $str to be placed inside an HTML attribute
		html_attr_tags_ok($str) -- same as html_attr, but allowing HTML tags
		Notification() -- class for providing a standardized html notifications functionality
		sendmail($mail) -- sends an email using PHPMailer as specified in the assoc array $mail( ['to', 'name', 'subject', 'message', 'debug'] ) and returns true on success or an error message on failure
		safe_html($str, $preserveNewLines = false) -- sanitize HTML strings, and convert new lines (\n) to breaks (<br>) for non-HTML ones (unless optional 2nd param is passed as true)
		get_tables_info($skip_authentication = false) -- retrieves table properties as a 2D assoc array ['table_name' => ['prop1' => 'val', ..], ..]
		getLoggedMemberID() -- returns memberID of logged member. If no login, returns anonymous memberID
		getLoggedGroupID() -- returns groupID of logged member, or anonymous groupID
		getMemberInfo() -- returns an array containing the currently signed-in member's info
		get_group_id($user = '') -- returns groupID of given user, or current one if empty
		prepare_sql_set($set_array, $glue = ', ') -- Prepares data for a SET or WHERE clause, to be used in an INSERT/UPDATE query
		insert($tn, $set_array) -- Inserts a record specified by $set_array to the given table $tn
		update($tn, $set_array, $where_array) -- Updates a record identified by $where_array to date specified by $set_array in the given table $tn
		set_record_owner($tn, $pk, $user) -- Set/update the owner of given record
		app_datetime_format($destination = 'php', $datetime = 'd') -- get date/time format string for use with one of these: 'php' (see date function), 'mysql', 'moment'. $datetime: 'd' = date, 't' = time, 'dt' = both
		mysql_datetime($app_datetime) -- converts $app_datetime to mysql-formatted datetime, 'yyyy-mm-dd H:i:s', or empty string on error
		app_datetime($mysql_datetime, $datetime = 'd') -- converts $mysql_datetime to app-formatted datetime (if 2nd param is 'dt'), or empty string on error
		to_utf8($str) -- converts string from app-configured encoding to utf8
		from_utf8($str) -- converts string from utf8 to app-configured encoding
		membership_table_functions() -- returns a list of update_membership_* functions
		configure_anonymous_group() -- sets up anonymous group and guest user if necessary
		configure_admin_group() -- sets up admins group and super admin user if necessary
		get_table_keys($tn) -- returns keys (indexes) of given table
		get_table_fields($tn) -- returns fields spec for given table
		update_membership_{tn}() -- sets up membership table tn and its indexes if necessary
		test($subject, $test) -- perform a test and return results
		invoke_method($object, $methodName, $param_array) -- invoke a private/protected method of a given object
		invoke_static_method($class, $methodName, $param_array) -- invoke a private/protected method of a given class statically
		get_parent_tables($tn) -- returns parents of given table: ['parent table' => [main lookup fields in child], ..]
		backtick_keys_once($data) -- wraps keys of given array with backticks ` if not already wrapped. Useful for use with fieldnames passed to update() and insert()
		calculated_fields() -- returns calculated fields config array: [table => [field => query, ..], ..]
		update_calc_fields($table, $id, $formulas, $mi = false) -- updates record of given $id in given $table according to given $formulas on behalf of user specified in given info array (or current user if false)
		latest_jquery() -- detects and returns the name of the latest jQuery file found in resources/jquery/js
		existing_value($tn, $fn, $id, $cache = true) -- returns (cached) value of field $fn of record having $id in table $tn. Set $cache to false to bypass caching.
		checkAppRequirements() -- if PHP doesn't meet app requirements, outputs error and exits
		getRecord($table, $id) -- return the record having a PK of $id from $table as an associative array, falsy value on error/not found
		guessMySQLDateTime($dt) -- if $dt is not already a mysql date/datetime, use mysql_datetime() to convert then return mysql date/datetime. Returns false if $dt invalid or couldn't be detected.
		pkGivenLookupText($val, $tn, $lookupField, $falseIfNotFound) -- returns corresponding PK value for given $val which is the textual lookup value for given $lookupField in given $tn table. If $val has no corresponding PK value, $val is returned as-is, unless $falseIfNotFound is set to true, in which case false is returned.
		userCanImport() -- returns true if user (or his group) can import CSV files (through the permission set in the group page in the admin area).
		bgStyleToClass($html) -- replaces bg color 'style' attr with a class to prevent style loss on xss cleanup.
		assocArrFilter($arr, $func) -- filters provided array using provided callback function. The callback receives 2 params ($key, $value) and should return a boolean.
		array_trim($arr) -- deep trim; trim each element in the array and its sub arrays.
		request_outside_admin_folder() -- returns true if currently executing script is outside admin folder, false otherwise.
		breakpoint(__FILE__, __LINE__, $msg) -- if DEBUG_MODE enabled, logs a message to {app_dir}/breakpoint.csv, if $msg is array, it will be converted to str via json_encode
		denyAccess($msg) -- Send a 403 Access Denied header, with an optional message then die
		getUploadDir($dir) -- if dir is empty, returns upload dir configured in defaultLang.php, else returns $dir.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/
	########################################################################
	function set_headers() {
		@header('Content-Type: text/html; charset=' . datalist_db_encoding);
		// @header('X-Frame-Options: SAMEORIGIN'); // deprecated
		@header("Content-Security-Policy: frame-ancestors 'self' " . application_url()); // prevent iframing by other sites to prevent clickjacking
	}
	########################################################################
	function get_tables_info($skip_authentication = false) {
		static $all_tables = [], $accessible_tables = [];

		/* return cached results, if found */
		if(($skip_authentication || getLoggedAdmin()) && count($all_tables)) return $all_tables;
		if(!$skip_authentication && count($accessible_tables)) return $accessible_tables;

		/* table groups */
		$tg = [
			'Approvals &amp; Sanctions',
			'Facilities Apps',
			'Event / Meeting / Goal /Tasks Apps',
			'HRD Apps',
			'SDP Apps',
			'Program Apps',
			'Technology Development Apps',
			'Startup Data Management Apps',
			'Employee Data Management Apps',
			'Asset Management Apps',
			'Accounts &amp; Finance Apps',
			'Transport Apps',
			'Newsletters &amp; Updates Apps',
			'Suggestions &amp; Others App',
			'NMICPS Portal - Apps'
		];

		$all_tables = [
			/* ['table_name' => [table props assoc array] */
				'user_table' => [
					'Caption' => 'User Table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[13],
					'homepageShowCount' => 1
				],
				'suggestion' => [
					'Caption' => 'Suggestion/Complaint - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[13],
					'homepageShowCount' => 1
				],
				'approval_table' => [
					'Caption' => 'Approval - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
				'techlead_web_page' => [
					'Caption' => 'Tech Manager Web Page  - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
				'navavishkar_stay_facilities_table' => [
					'Caption' => 'Navavishkar Stay Facilities - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'navavishkar_stay_facilities_allotment_table' => [
					'Caption' => 'Navavishkar Stay Facilities - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'car_table' => [
					'Caption' => 'Car - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/58f87367-3f09-42c0-a288-cf75f313cbed"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Car App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'car_usage_table' => [
					'Caption' => 'Car usage table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'cycle_table' => [
					'Caption' => 'Cycle - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/c941076f-d85a-4899-b163-1337a9b083ed"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Cycle Usage App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'cycle_usage_table' => [
					'Caption' => 'Cycle usage table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'gym_table' => [
					'Caption' => 'Gym - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'coffee_table' => [
					'Caption' => 'Coffee - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'cafeteria_table' => [
					'Caption' => 'Cafeteria - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'event_table' => [
					'Caption' => 'Event - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/7a6332d1-62b0-4602-baf9-7da8e4033e98"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Event App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'outcomes_expected_table' => [
					'Caption' => 'Outcomes Expected Table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'event_decision_table' => [
					'Caption' => 'Decision - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'meetings_table' => [
					'Caption' => 'Meetings - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/b7bf99ff-cb80-42d5-8c5e-9256eb638f3a"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Meetings App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'agenda_table' => [
					'Caption' => 'Agenda - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'decision_table' => [
					'Caption' => 'Decision - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'participants_table' => [
					'Caption' => 'Participants / Speaker / VIP List - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'action_actor' => [
					'Caption' => 'Action actor',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 0
				],
				'visiting_card_table' => [
					'Caption' => 'Visiting card - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'mou_details_table' => [
					'Caption' => 'MoU Details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'goal_setting_table' => [
					'Caption' => 'Goal setting - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'goal_progress_table' => [
					'Caption' => 'Goal progress table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 0
				],
				'task_allocation_table' => [
					'Caption' => 'Task Allocation - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/52ec0149-4f45-4041-92b6-afc26208458e"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Task Setting App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'task_progress_status_table' => [
					'Caption' => 'Task Progress Status - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'timesheet_entry_table' => [
					'Caption' => 'Timesheet Entry - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'internship_fellowship_details_app' => [
					'Caption' => 'Internship/Fellowship details - App',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'star_pnt' => [
					'Caption' => 'Star-PNT - APP',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'hrd_sdp_events_table' => [
					'Caption' => 'HRD & SDP Events - App',
					'Description' => 'HRD & SDP',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'training_program_on_geospatial_tchnologies_table' => [
					'Caption' => 'Training Program on Geospatial Technologies Details - App',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'space_day_school_details_app' => [
					'Caption' => 'Space day school student details app',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'space_day_college_student_table' => [
					'Caption' => 'Space day college student - App',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'school_list' => [
					'Caption' => 'School List - App',
					'Description' => 'HRD',
					'tableIcon' => 'table.gif',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'sdp_participants_college_details_table' => [
					'Caption' => 'SDP participants college details - App',
					'Description' => 'SDP',
					'tableIcon' => 'table.gif',
					'group' => $tg[4],
					'homepageShowCount' => 1
				],
				'asset_table' => [
					'Caption' => 'Master Inventory (Admin Department) - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'asset_allotment_table' => [
					'Caption' => 'Master Inventory Allotment - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'sub_asset_table' => [
					'Caption' => 'Sub Inventory (Technical Department) - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'sub_asset_allotment_table' => [
					'Caption' => 'Sub Inventory Allotment - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'it_inventory_app' => [
					'Caption' => 'IT inventory - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'it_inventory_billing_details' => [
					'Caption' => 'IT inventory billing details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'it_inventory_allotment_table' => [
					'Caption' => 'IT inventory Allotment - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'computer_details_table' => [
					'Caption' => 'Computer lab PC list - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/3dc9dac5-3945-4853-91cc-12e26b865666"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Computer lab PC Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'computer_user_details' => [
					'Caption' => 'Computer Uses Entry Table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'computer_allotment_table' => [
					'Caption' => 'PC Allotment Table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[9],
					'homepageShowCount' => 1
				],
				'employees_personal_data_table' => [
					'Caption' => 'Employee Personal Data - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/e46f3806-e78c-4f09-8417-049568d4783d"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Employee Details App Report</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'employees_designation_table' => [
					'Caption' => 'Employees designation & Reporting - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'employees_appraisal_table' => [
					'Caption' => 'Employees Appraisal  - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'beyond_working_hours_table' => [
					'Caption' => 'Beyond Working Hours Approval - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'leave_table' => [
					'Caption' => 'Leave - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'half_day_leave_table' => [
					'Caption' => 'Half Day Leave - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'work_from_home_table' => [
					'Caption' => 'Work From Home - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'work_from_home_tasks_app' => [
					'Caption' => 'Tasks',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'navavishkar_stay_table' => [
					'Caption' => 'Navavishkar Stay - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'navavishkar_stay_payment_table' => [
					'Caption' => 'Navavishkar Stay Payment - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'email_id_allocation_table' => [
					'Caption' => 'Email id allocation - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'attendence_details_table' => [
					'Caption' => 'Attendence details - App',
					'Description' => '<a href="https://lookerstudio.google.com/reporting/dd61ce5a-ccb5-4d55-b0a4-5233454f4b2c"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Attendence App View</b></button></a>',
					'tableIcon' => 'table.gif',
					'group' => $tg[8],
					'homepageShowCount' => 1
				],
				'all_startup_data_table' => [
					'Caption' => 'All Startups Data - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[7],
					'homepageShowCount' => 1
				],
				'shortlisted_startups_for_fund_table' => [
					'Caption' => 'Shortlisted startups for fund - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[7],
					'homepageShowCount' => 1
				],
				'shortlisted_startups_dd_and_agreement_table' => [
					'Caption' => 'Shortlisted startups DD and Agreement - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[7],
					'homepageShowCount' => 1
				],
				'vikas_startup_applications_table' => [
					'Caption' => 'Vikas startup applications - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[7],
					'homepageShowCount' => 1
				],
				'programs_table' => [
					'Caption' => 'Programs - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[5],
					'homepageShowCount' => 1
				],
				'evaluation_table' => [
					'Caption' => 'Evaluation table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[5],
					'homepageShowCount' => 1
				],
				'problem_statement_table' => [
					'Caption' => 'Problem statement - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[5],
					'homepageShowCount' => 1
				],
				'evaluators_table' => [
					'Caption' => 'Evaluators table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[5],
					'homepageShowCount' => 1
				],
				'approval_billing_table' => [
					'Caption' => 'Approval billing table',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[10],
					'homepageShowCount' => 1
				],
				'honorarium_claim_table' => [
					'Caption' => 'Honorarium - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[10],
					'homepageShowCount' => 1
				],
				'honorarium_Activities' => [
					'Caption' => 'Honorarium Activities',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[10],
					'homepageShowCount' => 1
				],
				'all_bank_account_statement_table' => [
					'Caption' => 'All bank account statement - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[10],
					'homepageShowCount' => 1
				],
				'payment_track_details_table' => [
					'Caption' => 'Payment track details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[10],
					'homepageShowCount' => 1
				],
				'travel_table' => [
					'Caption' => 'Travel - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[11],
					'homepageShowCount' => 1
				],
				'travel_stay_table' => [
					'Caption' => 'Stay Details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[11],
					'homepageShowCount' => 1
				],
				'travel_local_commute_table' => [
					'Caption' => 'Local Commute - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[11],
					'homepageShowCount' => 1
				],
				'r_and_d_progress' => [
					'Caption' => 'Inhouse R & D App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'panel_decision_table_tdp' => [
					'Caption' => 'TDP&#160;Projects&#160;- App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'selected_proposals_final_tdp' => [
					'Caption' => 'Selected proposals final - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'stage_wise_budget_table_tdp' => [
					'Caption' => 'Stage wise budget - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'first_level_shortlisted_proposals_tdp' => [
					'Caption' => 'First level shortlisted proposals - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'budget_table_tdp' => [
					'Caption' => 'Budget App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'panel_comments_tdp' => [
					'Caption' => 'Panel comments - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'selected_tdp' => [
					'Caption' => 'Selected (Draft) - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'address_tdp' => [
					'Caption' => 'Address Details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'summary_table_tdp' => [
					'Caption' => 'Summary of TDP - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'project_details_tdp' => [
					'Caption' => 'Project details - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 1
				],
				'newsletter_table' => [
					'Caption' => 'Newsletter - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[12],
					'homepageShowCount' => 1
				],
				'contact_call_log_table' => [
					'Caption' => 'Contact Call Log - App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[13],
					'homepageShowCount' => 0
				],
				'r_and_d_monthly_progress_app' => [
					'Caption' => 'Monthly Progress App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 0
				],
				'r_and_d_quarterly_progress_app' => [
					'Caption' => 'Quarterly Progress App',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[6],
					'homepageShowCount' => 0
				],
				'projects' => [
					'Caption' => 'Projects',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_projects_td_intellectual_property' => [
					'Caption' => 'Intellectual Property',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_projects_td_technology_products' => [
					'Caption' => 'Technology Products',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_publications_and_intellectual_activities' => [
					'Caption' => 'Publications and Intellectual Activities',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_publications' => [
					'Caption' => 'Td publications',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_ipr' => [
					'Caption' => 'IPR',
					'Description' => '',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'td_cps_research_base' => [
					'Caption' => 'CPS Research Base',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'ed_tbi' => [
					'Caption' => 'Technology Business Incubator (TBI)',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'ed_startup_companies' => [
					'Caption' => 'Start-ups & Spin-off companies',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'ed_gcc' => [
					'Caption' => 'GCC - Grand Challenges & Competitions',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'ed_eir' => [
					'Caption' => 'Entrepreneur In Residence (EIR)',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'ed_job_creation' => [
					'Caption' => 'Job Creation',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'hrd_Fellowship' => [
					'Caption' => 'Fellowship',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Human Resource Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'hrd_sd' => [
					'Caption' => 'Skill Development',
					'Description' => '<span style="color:red;font-size: 20px;"><b>Human Resource Development </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
				'it_International_Collaboration' => [
					'Caption' => 'International Collaboration',
					'Description' => '<span style="color:red;font-size: 20px;"><b> International Targets </b></span>',
					'tableIcon' => 'table.gif',
					'group' => $tg[14],
					'homepageShowCount' => 1
				],
		];

		if($skip_authentication || getLoggedAdmin()) return $all_tables;

		foreach($all_tables as $tn => $ti) {
			$arrPerm = getTablePermissions($tn);
			if(!empty($arrPerm['access'])) $accessible_tables[$tn] = $ti;
		}

		return $accessible_tables;
	}
	#########################################################
	function getTableList($skip_authentication = false, $include_internal_tables = false) {
		$arrAccessTables = [];
		$arrTables = [
			/* 'table_name' => ['table caption', 'homepage description', 'icon', 'table group name'] */
			'user_table' => ['User Table', '', 'table.gif', 'Suggestions &amp; Others App'],
			'suggestion' => ['Suggestion/Complaint - App', '', 'table.gif', 'Suggestions &amp; Others App'],
			'approval_table' => ['Approval - App', '', 'table.gif', 'Approvals &amp; Sanctions'],
			'techlead_web_page' => ['Tech Manager Web Page  - App', '', 'table.gif', 'Approvals &amp; Sanctions'],
			'navavishkar_stay_facilities_table' => ['Navavishkar Stay Facilities - App', '', 'table.gif', 'Facilities Apps'],
			'navavishkar_stay_facilities_allotment_table' => ['Navavishkar Stay Facilities - App', '', 'table.gif', 'Facilities Apps'],
			'car_table' => ['Car - App', '<a href="https://lookerstudio.google.com/reporting/58f87367-3f09-42c0-a288-cf75f313cbed"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Car App Report</b></button></a>', 'table.gif', 'Facilities Apps'],
			'car_usage_table' => ['Car usage table', '', 'table.gif', 'Facilities Apps'],
			'cycle_table' => ['Cycle - App', '<a href="https://lookerstudio.google.com/reporting/c941076f-d85a-4899-b163-1337a9b083ed"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Cycle Usage App Report</b></button></a>', 'table.gif', 'Facilities Apps'],
			'cycle_usage_table' => ['Cycle usage table', '', 'table.gif', 'Facilities Apps'],
			'gym_table' => ['Gym - App', '', 'table.gif', 'Facilities Apps'],
			'coffee_table' => ['Coffee - App', '', 'table.gif', 'Facilities Apps'],
			'cafeteria_table' => ['Cafeteria - App', '', 'table.gif', 'Facilities Apps'],
			'event_table' => ['Event - App', '<a href="https://lookerstudio.google.com/reporting/7a6332d1-62b0-4602-baf9-7da8e4033e98"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Event App Report</b></button></a>', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'outcomes_expected_table' => ['Outcomes Expected Table', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'event_decision_table' => ['Decision - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'meetings_table' => ['Meetings - App', '<a href="https://lookerstudio.google.com/reporting/b7bf99ff-cb80-42d5-8c5e-9256eb638f3a"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Meetings App Report</b></button></a>', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'agenda_table' => ['Agenda - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'decision_table' => ['Decision - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'participants_table' => ['Participants / Speaker / VIP List - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'action_actor' => ['Action actor', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'visiting_card_table' => ['Visiting card - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'mou_details_table' => ['MoU Details - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'goal_setting_table' => ['Goal setting - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'goal_progress_table' => ['Goal progress table', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'task_allocation_table' => ['Task Allocation - App', '<a href="https://lookerstudio.google.com/reporting/52ec0149-4f45-4041-92b6-afc26208458e"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Task Setting App Report</b></button></a>', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'task_progress_status_table' => ['Task Progress Status - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'timesheet_entry_table' => ['Timesheet Entry - App', '', 'table.gif', 'Event / Meeting / Goal /Tasks Apps'],
			'internship_fellowship_details_app' => ['Internship/Fellowship details - App', 'HRD', 'table.gif', 'HRD Apps'],
			'star_pnt' => ['Star-PNT - APP', 'HRD', 'table.gif', 'HRD Apps'],
			'hrd_sdp_events_table' => ['HRD & SDP Events - App', 'HRD & SDP', 'table.gif', 'HRD Apps'],
			'training_program_on_geospatial_tchnologies_table' => ['Training Program on Geospatial Technologies Details - App', 'HRD', 'table.gif', 'HRD Apps'],
			'space_day_school_details_app' => ['Space day school student details app', 'HRD', 'table.gif', 'HRD Apps'],
			'space_day_college_student_table' => ['Space day college student - App', 'HRD', 'table.gif', 'HRD Apps'],
			'school_list' => ['School List - App', 'HRD', 'table.gif', 'HRD Apps'],
			'sdp_participants_college_details_table' => ['SDP participants college details - App', 'SDP', 'table.gif', 'SDP Apps'],
			'asset_table' => ['Master Inventory (Admin Department) - App', '', 'table.gif', 'Asset Management Apps'],
			'asset_allotment_table' => ['Master Inventory Allotment - App', '', 'table.gif', 'Asset Management Apps'],
			'sub_asset_table' => ['Sub Inventory (Technical Department) - App', '', 'table.gif', 'Asset Management Apps'],
			'sub_asset_allotment_table' => ['Sub Inventory Allotment - App', '', 'table.gif', 'Asset Management Apps'],
			'it_inventory_app' => ['IT inventory - App', '', 'table.gif', 'Asset Management Apps'],
			'it_inventory_billing_details' => ['IT inventory billing details - App', '', 'table.gif', 'Asset Management Apps'],
			'it_inventory_allotment_table' => ['IT inventory Allotment - App', '', 'table.gif', 'Asset Management Apps'],
			'computer_details_table' => ['Computer lab PC list - App', '<a href="https://lookerstudio.google.com/reporting/3dc9dac5-3945-4853-91cc-12e26b865666"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Computer lab PC Report</b></button></a>', 'table.gif', 'Asset Management Apps'],
			'computer_user_details' => ['Computer Uses Entry Table', '', 'table.gif', 'Asset Management Apps'],
			'computer_allotment_table' => ['PC Allotment Table', '', 'table.gif', 'Asset Management Apps'],
			'employees_personal_data_table' => ['Employee Personal Data - App', '<a href="https://lookerstudio.google.com/reporting/e46f3806-e78c-4f09-8417-049568d4783d"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Employee Details App Report</b></button></a>', 'table.gif', 'Employee Data Management Apps'],
			'employees_designation_table' => ['Employees designation & Reporting - App', '', 'table.gif', 'Employee Data Management Apps'],
			'employees_appraisal_table' => ['Employees Appraisal  - App', '', 'table.gif', 'Employee Data Management Apps'],
			'beyond_working_hours_table' => ['Beyond Working Hours Approval - App', '', 'table.gif', 'Employee Data Management Apps'],
			'leave_table' => ['Leave - App', '', 'table.gif', 'Employee Data Management Apps'],
			'half_day_leave_table' => ['Half Day Leave - App', '', 'table.gif', 'Employee Data Management Apps'],
			'work_from_home_table' => ['Work From Home - App', '', 'table.gif', 'Employee Data Management Apps'],
			'work_from_home_tasks_app' => ['Tasks', '', 'table.gif', 'Employee Data Management Apps'],
			'navavishkar_stay_table' => ['Navavishkar Stay - App', '', 'table.gif', 'Employee Data Management Apps'],
			'navavishkar_stay_payment_table' => ['Navavishkar Stay Payment - App', '', 'table.gif', 'Employee Data Management Apps'],
			'email_id_allocation_table' => ['Email id allocation - App', '', 'table.gif', 'Employee Data Management Apps'],
			'attendence_details_table' => ['Attendence details - App', '<a href="https://lookerstudio.google.com/reporting/dd61ce5a-ccb5-4d55-b0a4-5233454f4b2c"><button style="background-color: #bf0606; color: white;padding: 6px 20px; font-size: 16px; border: none; border-radius: 5px; cursor: pointer; width:100%;"><b>Attendence App View</b></button></a>', 'table.gif', 'Employee Data Management Apps'],
			'all_startup_data_table' => ['All Startups Data - App', '', 'table.gif', 'Startup Data Management Apps'],
			'shortlisted_startups_for_fund_table' => ['Shortlisted startups for fund - App', '', 'table.gif', 'Startup Data Management Apps'],
			'shortlisted_startups_dd_and_agreement_table' => ['Shortlisted startups DD and Agreement - App', '', 'table.gif', 'Startup Data Management Apps'],
			'vikas_startup_applications_table' => ['Vikas startup applications - App', '', 'table.gif', 'Startup Data Management Apps'],
			'programs_table' => ['Programs - App', '', 'table.gif', 'Program Apps'],
			'evaluation_table' => ['Evaluation table', '', 'table.gif', 'Program Apps'],
			'problem_statement_table' => ['Problem statement - App', '', 'table.gif', 'Program Apps'],
			'evaluators_table' => ['Evaluators table', '', 'table.gif', 'Program Apps'],
			'approval_billing_table' => ['Approval billing table', '', 'table.gif', 'Accounts &amp; Finance Apps'],
			'honorarium_claim_table' => ['Honorarium - App', '', 'table.gif', 'Accounts &amp; Finance Apps'],
			'honorarium_Activities' => ['Honorarium Activities', '', 'table.gif', 'Accounts &amp; Finance Apps'],
			'all_bank_account_statement_table' => ['All bank account statement - App', '', 'table.gif', 'Accounts &amp; Finance Apps'],
			'payment_track_details_table' => ['Payment track details - App', '', 'table.gif', 'Accounts &amp; Finance Apps'],
			'travel_table' => ['Travel - App', '', 'table.gif', 'Transport Apps'],
			'travel_stay_table' => ['Stay Details - App', '', 'table.gif', 'Transport Apps'],
			'travel_local_commute_table' => ['Local Commute - App', '', 'table.gif', 'Transport Apps'],
			'r_and_d_progress' => ['Inhouse R & D App', '', 'table.gif', 'Technology Development Apps'],
			'panel_decision_table_tdp' => ['TDP&#160;Projects&#160;- App', '', 'table.gif', 'Technology Development Apps'],
			'selected_proposals_final_tdp' => ['Selected proposals final - App', '', 'table.gif', 'Technology Development Apps'],
			'stage_wise_budget_table_tdp' => ['Stage wise budget - App', '', 'table.gif', 'Technology Development Apps'],
			'first_level_shortlisted_proposals_tdp' => ['First level shortlisted proposals - App', '', 'table.gif', 'Technology Development Apps'],
			'budget_table_tdp' => ['Budget App', '', 'table.gif', 'Technology Development Apps'],
			'panel_comments_tdp' => ['Panel comments - App', '', 'table.gif', 'Technology Development Apps'],
			'selected_tdp' => ['Selected (Draft) - App', '', 'table.gif', 'Technology Development Apps'],
			'address_tdp' => ['Address Details - App', '', 'table.gif', 'Technology Development Apps'],
			'summary_table_tdp' => ['Summary of TDP - App', '', 'table.gif', 'Technology Development Apps'],
			'project_details_tdp' => ['Project details - App', '', 'table.gif', 'Technology Development Apps'],
			'newsletter_table' => ['Newsletter - App', '', 'table.gif', 'Newsletters &amp; Updates Apps'],
			'contact_call_log_table' => ['Contact Call Log - App', '', 'table.gif', 'Suggestions &amp; Others App'],
			'r_and_d_monthly_progress_app' => ['Monthly Progress App', '', 'table.gif', 'Technology Development Apps'],
			'r_and_d_quarterly_progress_app' => ['Quarterly Progress App', '', 'table.gif', 'Technology Development Apps'],
			'projects' => ['Projects', '', 'table.gif', 'NMICPS Portal - Apps'],
			'td_projects_td_intellectual_property' => ['Intellectual Property', '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'td_projects_td_technology_products' => ['Technology Products', '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'td_publications_and_intellectual_activities' => ['Publications and Intellectual Activities', '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'td_publications' => ['Td publications', '', 'table.gif', 'NMICPS Portal - Apps'],
			'td_ipr' => ['IPR', '', 'table.gif', 'NMICPS Portal - Apps'],
			'td_cps_research_base' => ['CPS Research Base', '<span style="color:red;font-size: 20px;"><b>Technology Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'ed_tbi' => ['Technology Business Incubator (TBI)', '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'ed_startup_companies' => ['Start-ups & Spin-off companies', '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'ed_gcc' => ['GCC - Grand Challenges & Competitions', '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'ed_eir' => ['Entrepreneur In Residence (EIR)', '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'ed_job_creation' => ['Job Creation', '<span style="color:red;font-size: 20px;"><b>Entrepreneurship Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'hrd_Fellowship' => ['Fellowship', '<span style="color:red;font-size: 20px;"><b>Human Resource Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'hrd_sd' => ['Skill Development', '<span style="color:red;font-size: 20px;"><b>Human Resource Development </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
			'it_International_Collaboration' => ['International Collaboration', '<span style="color:red;font-size: 20px;"><b> International Targets </b></span>', 'table.gif', 'NMICPS Portal - Apps'],
		];

		if($skip_authentication || getLoggedAdmin()) {
			if($include_internal_tables) {
				// merge internal tables with user tables
				$internalIcon = 'resources/images/appgini-icon.png';
				$internalTables = [
					'appgini_csv_import_jobs',
					'appgini_query_log',
					'membership_cache',
					'membership_grouppermissions',
					'membership_groups',
					'membership_userpermissions',
					'membership_userrecords',
					'membership_users',
					'membership_usersessions',
				];

				// format internal tables as 'tn' => ['tn', '', icon, ''] and merge with user tables
				$arrTables = array_merge($arrTables, array_combine(
					$internalTables,
					array_map(function($tn) use($internalIcon) { return [$tn, '', $internalIcon, '']; }, $internalTables)
				));
			}
			return $arrTables;
		}

		foreach($arrTables as $tn => $tc) {
			$arrPerm = getTablePermissions($tn);
			if(!empty($arrPerm['access'])) $arrAccessTables[$tn] = $tc;
		}

		return $arrAccessTables;
	}
	########################################################################
	function getThumbnailSpecs($tableName, $fieldName, $view) {
		if($tableName=='approval_table' && $fieldName=='image' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='approval_table' && $fieldName=='image' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='techlead_web_page' && $fieldName=='img1' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='techlead_web_page' && $fieldName=='img2' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='visiting_card_table' && $fieldName=='front_img' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='visiting_card_table' && $fieldName=='front_img' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='visiting_card_table' && $fieldName=='back_img' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='visiting_card_table' && $fieldName=='back_img' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='it_inventory_app' && $fieldName=='custodian_signature' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='it_inventory_app' && $fieldName=='custodian_signature' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='it_inventory_billing_details' && $fieldName=='image' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='it_inventory_billing_details' && $fieldName=='image' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='employees_personal_data_table' && $fieldName=='profile_photo' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='employees_personal_data_table' && $fieldName=='profile_photo' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='employees_personal_data_table' && $fieldName=='signature' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='employees_personal_data_table' && $fieldName=='signature' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='leave_table' && $fieldName=='upload_img' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='work_from_home_table' && $fieldName=='upload_img' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='payment_track_details_table' && $fieldName=='upload_scanned_file_1' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='payment_track_details_table' && $fieldName=='upload_scanned_file_1' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='payment_track_details_table' && $fieldName=='upload_scanned_file_2' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='payment_track_details_table' && $fieldName=='upload_scanned_file_2' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='newsletter_table' && $fieldName=='img1' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='newsletter_table' && $fieldName=='img1' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='newsletter_table' && $fieldName=='img2' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='newsletter_table' && $fieldName=='img2' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		return FALSE;
	}
	########################################################################
	/**
	 * Alias for `Thumbnail::create()`. Create a thumbnail of an image. The thumbnail is saved in the same directory as the original image, with the same name, suffixed with `$specs['identifier']`
	 * @param string $img - path to image file
	 * @param array $specs - array with thumbnail specs as returned by getThumbnailSpecs()
	 * @return bool - true on success, false on failure
	 */
	function createThumbnail($img, $specs) {
		return Thumbnail::create($img, $specs);
	}
	########################################################################
	function formatUri($uri) {
		$uri = str_replace('\\', '/', $uri);
		return trim($uri, '/');
	}
	########################################################################
	function makeSafe($string, $is_gpc = true) {
		static $cached = []; /* str => escaped_str */

		if(!strlen($string)) return '';
		if(is_numeric($string)) return db_escape($string); // don't cache numbers to avoid cases like '3.5' being equivelant to '3' in array indexes

		if(!db_link()) sql("SELECT 1+1", $eo);

		// if this is a previously escaped string, return from cached
		// checking both keys and values
		if(isset($cached[$string])) return $cached[$string];
		$key = array_search($string, $cached);
		if($key !== false) return $string; // already an escaped string

		$cached[$string] = db_escape($string);
		return $cached[$string];
	}
	########################################################################
	function checkPermissionVal($pvn) {
		// fn to make sure the value in the given POST variable is 0, 1, 2 or 3
		// if the value is invalid, it default to 0
		$pvn = intval(Request::val($pvn));
		if($pvn != 1 && $pvn != 2 && $pvn != 3) {
			return 0;
		} else {
			return $pvn;
		}
	}
	########################################################################
	function dieErrorPage($error) {
		global $Translation;

		$header = (defined('ADMIN_AREA') ? __DIR__ . '/incHeader.php' : __DIR__ . '/../header.php');
		$footer = (defined('ADMIN_AREA') ? __DIR__ . '/incFooter.php' : __DIR__ . '/../footer.php');

		ob_start();

		@include_once($header);
		echo Notification::placeholder();
		echo Notification::show([
			'message' => $error,
			'class' => 'danger',
			'dismiss_seconds' => 7200
		]);
		@include_once($footer);

		echo ob_get_clean();
		exit;
	}
	########################################################################
	function openDBConnection(&$o) {
		static $connected = false, $db_link;

		$dbServer = config('dbServer');
		$dbUsername = config('dbUsername');
		$dbPassword = config('dbPassword');
		$dbDatabase = config('dbDatabase');
		$dbPort = config('dbPort');

		if($connected) return $db_link;

		global $Translation;

		/****** Check that MySQL module is enabled ******/
		if(!extension_loaded('mysql') && !extension_loaded('mysqli')) {
			$o['error'] = 'PHP is not configured to connect to MySQL on this machine. Please see <a href="https://www.php.net/manual/en/ref.mysql.php">this page</a> for help on how to configure MySQL.';
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage($o['error']);
		}

		/****** Connect to MySQL ******/
		if(!($db_link = @db_connect($dbServer, $dbUsername, $dbPassword, NULL, $dbPort))) {
			$o['error'] = db_error($db_link, true);
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage($o['error'] ? $o['error'] : $Translation['no db connection']);
		}

		/****** Select DB ********/
		if(!db_select_db($dbDatabase, $db_link)) {
			$o['error'] = db_error($db_link);
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage(str_replace('<DBName>', '****', $Translation['no db name']));
		}

		$connected = true;
		return $db_link;
	}
	########################################################################
	function sql($statement, &$o) {

		/*
			Supported options that can be passed in $o options array (as array keys):
			'silentErrors': If true, errors will be returned in $o['error'] rather than displaying them on screen and exiting.
			'noSlowQueryLog': don't log slow query if true
			'noErrorQueryLog': don't log error query if true
		*/

		global $Translation;

		$db_link = openDBConnection($o);

		/*
		 if openDBConnection() fails, it would abort execution unless 'silentErrors' is true,
		 in which case, we should return false from sql() without further action since
		 $o['error'] would be already set by openDBConnection()
		*/
		if(!$db_link) return false;

		$t0 = microtime(true);

		if(!$result = @db_query($statement, $db_link)) {
			if(!stristr($statement, "show columns")) {
				// retrieve error codes
				$errorNum = db_errno($db_link);
				$o['error'] = db_error($db_link);

				if(empty($o['noErrorQueryLog']))
					logErrorQuery($statement, $o['error']);

				if(getLoggedAdmin())
					$o['error'] = htmlspecialchars($o['error']) .
						"<pre class=\"ltr\">{$Translation['query:']}\n" . htmlspecialchars($statement) . '</pre>' .
						"<p><i class=\"text-right\">{$Translation['admin-only info']}</i></p>" .
						"<p><a href=\"" . application_url('admin/pageRebuildFields.php') . "\">{$Translation['try rebuild fields']}</a></p>";

				if(!empty($o['silentErrors'])) return false;

				dieErrorPage($o['error']);
			}
		}

		/* log slow queries that take more than 1 sec */
		$t1 = microtime(true);
		if(($t1 - $t0) > 1.0 && empty($o['noSlowQueryLog']))
			logSlowQuery($statement, $t1 - $t0);

		return $result;
	}
	########################################################################
	function logSlowQuery($statement, $duration) {
		if(!createQueryLogTable()) return;

		$o = [
			'silentErrors' => true,
			'noSlowQueryLog' => true,
			'noErrorQueryLog' => true
		];
		$statement = makeSafe(trim(preg_replace('/^\s+/m', ' ', $statement)));
		$duration = floatval($duration);
		$memberID = makeSafe(getLoggedMemberID());
		$uri = $_SERVER['REQUEST_URI'];

		// for 'admin/ajax-sql.php' strip sql and csrf_token params from uri
		if(strpos($uri, 'admin/ajax-sql.php') !== false) {
			$uri = stripParams($uri, ['sql', 'csrf_token']);
		}
		$uri = makeSafe($uri);

		sql("INSERT INTO `appgini_query_log` SET
			`statement`='$statement',
			`duration`=$duration,
			`memberID`='$memberID',
			`uri`='$uri'
		", $o);
	}
	########################################################################
	function logErrorQuery($statement, $error) {
		if(!createQueryLogTable()) return;

		$o = [
			'silentErrors' => true,
			'noSlowQueryLog' => true,
			'noErrorQueryLog' => true
		];
		$statement = makeSafe(trim(preg_replace('/^\s+/m', ' ', $statement)));
		$error = makeSafe($error);
		$memberID = makeSafe(getLoggedMemberID());
		$uri = $_SERVER['REQUEST_URI'];

		// for 'admin/ajax-sql.php' strip sql and csrf_token params from uri
		if(strpos($uri, 'admin/ajax-sql.php') !== false) {
			$uri = stripParams($uri, ['sql', 'csrf_token']);
		}
		$uri = makeSafe($uri);

		sql("INSERT INTO `appgini_query_log` SET
			`statement`='$statement',
			`error`='$error',
			`memberID`='$memberID',
			`uri`='$uri'
		", $o);
	}

	########################################################################
	/**
	 * Strip specified parameters from a URL
	 * @param string $uri - the URL to strip parameters from, could be a full URL or just a URI
	 * @param array $paramsToRemove - an array of parameter names to remove
	 * @return string - the URL with specified parameters removed
	 */
	function stripParams($uri, $paramsToRemove) {
		// Parse the URL and its components
		$parsedUrl = parse_url($uri);

		// Parse the query string into an associative array
		parse_str($parsedUrl['query'] ?? '', $queryParams);

		// Remove specified parameters
		foreach ($paramsToRemove as $param) {
			unset($queryParams[$param]);
		}

		// Reconstruct the query string
		$newQuery = http_build_query($queryParams);

		// Reconstruct the URL
		$newUrl = $parsedUrl['scheme'] ?? '';
		if (!empty($newUrl)) {
			$newUrl .= '://';
		}
		$newUrl .= $parsedUrl['host'] ?? '';
		$newUrl .= $parsedUrl['path'] ?? '';
		if (!empty($newQuery)) {
			$newUrl .= '?' . $newQuery;
		}
		$newUrl .= $parsedUrl['fragment'] ?? '';

		return $newUrl;
	}
	########################################################################
	function createQueryLogTable() {
		static $created = false;
		if($created) return true;

		createTableIfNotExists('appgini_query_log');

		$created = true;
		return $created;
	}

	########################################################################
	function sqlValue($statement, &$error = NULL) {
		// executes a statement that retreives a single data value and returns the value retrieved
		$eo = ['silentErrors' => true];
		if(!$res = sql($statement, $eo)) { $error = $eo['error']; return false; }
		if(!$row = db_fetch_row($res)) return false;
		return $row[0];
	}
	########################################################################
	function getLoggedAdmin() {
		return Authentication::getAdmin();
	}
	########################################################################
	function initSession() {
		Authentication::initSession();
	}
	########################################################################
	function jwt_key() {
		if(!is_file(configFileName())) return false;
		return md5_file(configFileName());
	}
	########################################################################
	function jwt_token($user = false) {
		if($user === false) {
			$mi = Authentication::getUser();
			if(!$mi) return false;

			$user = $mi['memberId'];
		}

		$key = jwt_key();
		if($key === false) return false;
		return JWT::encode(['user' => $user], $key);
	}
	########################################################################
	function jwt_header() {
		/* adapted from https://stackoverflow.com/a/40582472/1945185 */
		$auth_header = null;
		if(isset($_SERVER['Authorization'])) {
			$auth_header = trim($_SERVER['Authorization']);
		} elseif(isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$auth_header = trim($_SERVER['HTTP_AUTHORIZATION']);
		} elseif(isset($_SERVER['HTTP_X_AUTHORIZATION'])) { //hack if all else fails
			$auth_header = trim($_SERVER['HTTP_X_AUTHORIZATION']);
		} elseif(function_exists('apache_request_headers')) {
			$rh = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$rh = array_combine(array_map('ucwords', array_keys($rh)), array_values($rh));
			if(isset($rh['Authorization'])) {
				$auth_header = trim($rh['Authorization']);
			} elseif(isset($rh['X-Authorization'])) {
				$auth_header = trim($rh['X-Authorization']);
			}
		}

		if(!empty($auth_header)) {
			if(preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) return $matches[1];
		}

		return null;
	}
	########################################################################
	function jwt_check_login() {
		// do we have an Authorization Bearer header?
		$token = jwt_header();
		if(!$token) return false;

		$key = jwt_key();
		if($key === false) return false;

		$error = '';
		$payload = JWT::decode($token, $key, $error);
		if(empty($payload['user'])) return false;

		Authentication::signInAs($payload['user']);

		// for API calls that just trigger an action and then close connection,
		// we need to continue running
		@ignore_user_abort(true);
		@set_time_limit(120);

		return true;
	}
	########################################################################
	function curl_insert_handler($table, $data) {
		if(!function_exists('curl_init')) return false;
		$ch = curl_init();

		$payload = $data;
		$payload['insert_x'] = 1;

		$url = application_url("{$table}_view.php");
		$token = jwt_token();
		$options = [
			CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($payload),
			CURLOPT_HTTPHEADER => [
				"User-Agent: {$_SERVER['HTTP_USER_AGENT']}",
				"Accept: {$_SERVER['HTTP_ACCEPT']}",
				"Authorization: Bearer $token",
				"X-Authorization: Bearer $token",
			],
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,

			/* this is a localhost request so need to verify SSL */
			CURLOPT_SSL_VERIFYPEER => false,

			// the following option allows sending request and then
			// closing the connection without waiting for response
			// see https://stackoverflow.com/a/10895361/1945185
			CURLOPT_TIMEOUT => 8,
		];

		if(defined('CURLOPT_TCP_FASTOPEN')) $options[CURLOPT_TCP_FASTOPEN] = true;
		if(defined('CURLOPT_SAFE_UPLOAD'))
			$options[CURLOPT_SAFE_UPLOAD] = function_exists('curl_file_create');

		// this is safe to use as we're sending a local request
		if(defined('CURLOPT_UNRESTRICTED_AUTH')) $options[CURLOPT_UNRESTRICTED_AUTH] = 1;

		curl_setopt_array($ch, $options);

		return $ch;
	}
	########################################################################
	function curl_batch($handlers) {
		if(!function_exists('curl_init')) return false;
		if(!is_array($handlers)) return false;
		if(!count($handlers)) return false;

		$mh = curl_multi_init();
		if(function_exists('curl_multi_setopt')) {
			curl_multi_setopt($mh, CURLMOPT_PIPELINING, 1);
			curl_multi_setopt($mh, CURLMOPT_MAXCONNECTS, min(20, count($handlers)));
		}

		foreach($handlers as $ch) {
			@curl_multi_add_handle($mh, $ch);
		}

		$active = false;
		do {
			@curl_multi_exec($mh, $active);
			usleep(2000);
		} while($active > 0);
	}
	########################################################################
	function logOutUser() {
		RememberMe::logout();
	}
	########################################################################
	function getPKFieldName($tn) {
		// get pk field name of given table
		static $pk = [];
		if(isset($pk[$tn])) return $pk[$tn];

		$stn = makeSafe($tn, false);
		$eo = ['silentErrors' => true];
		if(!$res = sql("SHOW FIELDS FROM `$stn`", $eo)) return $pk[$tn] = false;

		while($row = db_fetch_assoc($res))
			if($row['Key'] == 'PRI') return $pk[$tn] = $row['Field'];

		return $pk[$tn] = false;
	}
	########################################################################
	function getCSVData($tn, $pkValue, $stripTags = true) {
		// get pk field name for given table
		if(!$pkField = getPKFieldName($tn))
			return '';

		// get a concat string to produce a csv list of field values for given table record
		if(!$res = sql("SHOW FIELDS FROM `$tn`", $eo))
			return '';

		$csvFieldList = '';
		while($row = db_fetch_assoc($res))
			$csvFieldList .= "`{$row['Field']}`,";
		$csvFieldList = substr($csvFieldList, 0, -1);

		$csvData = sqlValue("SELECT CONCAT_WS(', ', $csvFieldList) FROM `$tn` WHERE `$pkField`='" . makeSafe($pkValue, false) . "'");

		return ($stripTags ? strip_tags($csvData) : $csvData);
	}
	########################################################################
	function errorMsg($msg) {
		echo "<div class=\"alert alert-danger\">{$msg}</div>";
	}
	########################################################################
	function redirect($url, $absolute = false) {
		$fullURL = ($absolute ? $url : application_url($url));

		// append browser window id to url (check if it should be preceded by ? or &)
		$fullURL .= (strpos($fullURL, '?') === false ? '?' : '&') . WindowMessages::windowIdQuery();

		if(!headers_sent()) header("Location: {$fullURL}");

		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;url={$fullURL}\">";
		echo "<br><br><a href=\"{$fullURL}\">Click here</a> if you aren't automatically redirected.";
		exit;
	}
	########################################################################
	function htmlRadioGroup($name, $arrValue, $arrCaption, $selectedValue, $selClass = 'text-primary', $class = '', $separator = '<br>') {
		if(!is_array($arrValue)) return '';

		ob_start();
		?>
		<div class="radio %%CLASS%%"><label>
			<input type="radio" name="%%NAME%%" id="%%ID%%" value="%%VALUE%%" %%CHECKED%%> %%LABEL%%
		</label></div>
		<?php
		$template = ob_get_clean();

		$out = '';
		for($i = 0; $i < count($arrValue); $i++) {
			$replacements = [
				'%%CLASS%%' => html_attr($arrValue[$i] == $selectedValue ? $selClass :$class),
				'%%NAME%%' => html_attr($name),
				'%%ID%%' => html_attr($name . $i),
				'%%VALUE%%' => html_attr($arrValue[$i]),
				'%%LABEL%%' => $arrCaption[$i],
				'%%CHECKED%%' => ($arrValue[$i]==$selectedValue ? " checked" : "")
			];
			$out .= str_replace(array_keys($replacements), array_values($replacements), $template);
		}

		return $out;
	}
	########################################################################
	function htmlSelect($name, $arrValue, $arrCaption, $selectedValue, $class = '', $selectedClass = '') {
		if($selectedClass == '')
			$selectedClass = $class;

		$out = '';
		if(is_array($arrValue)) {
			$out = "<select name=\"$name\" id=\"$name\">";
			for($i = 0; $i < count($arrValue); $i++)
				$out .= '<option value="' . $arrValue[$i] . '"' . ($arrValue[$i] == $selectedValue ? " selected class=\"$class\"" : " class=\"$selectedClass\"") . '>' . $arrCaption[$i] . '</option>';
			$out .= '</select>';
		}
		return $out;
	}
	########################################################################
	function htmlSQLSelect($name, $sql, $selectedValue, $class = '', $selectedClass = '') {
		$arrVal = [''];
		$arrCap = [''];
		if($res = sql($sql, $eo)) {
			while($row = db_fetch_row($res)) {
				$arrVal[] = $row[0];
				$arrCap[] = $row[1];
			}
			return htmlSelect($name, $arrVal, $arrCap, $selectedValue, $class, $selectedClass);
		}

		return '';
	}
	########################################################################
	function bootstrapSelect($name, $arrValue, $arrCaption, $selectedValue, $class = '', $selectedClass = '') {
		if($selectedClass == '') $selectedClass = $class;

		$out = "<select class=\"form-control\" name=\"{$name}\" id=\"{$name}\">";
		if(is_array($arrValue)) {
			for($i = 0; $i < count($arrValue); $i++) {
				$selected = "class=\"{$class}\"";
				if($arrValue[$i] == $selectedValue) $selected = "selected class=\"{$selectedClass}\"";
				$out .= "<option value=\"{$arrValue[$i]}\" {$selected}>{$arrCaption[$i]}</option>";
			}
		}
		$out .= '</select>';

		return $out;
	}
	########################################################################
	function bootstrapSQLSelect($name, $sql, $selectedValue, $class = '', $selectedClass = '') {
		$arrVal = [''];
		$arrCap = [''];
		$eo = ['silentErrors' => true];
		if($res = sql($sql, $eo)) {
			while($row = db_fetch_row($res)) {
				$arrVal[] = $row[0];
				$arrCap[] = $row[1];
			}
			return bootstrapSelect($name, $arrVal, $arrCap, $selectedValue, $class, $selectedClass);
		}

		return '';
	}
	########################################################################
	function isEmail($email){
		if(preg_match('/^([*+!.&#$¦\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,30})$/i', $email))
			return $email;

		return false;
	}
	########################################################################
	function notifyMemberApproval($memberID) {
		$adminConfig = config('adminConfig');
		$memberID = strtolower($memberID);

		$email = sqlValue("select email from membership_users where lcase(memberID)='{$memberID}'");

		return sendmail([
			'to' => $email,
			'name' => $memberID,
			'subject' => $adminConfig['approvalSubject'],
			'message' => nl2br($adminConfig['approvalMessage']),
		]);
	}
	########################################################################
	function setupMembership() {
		if(empty($_SESSION) || empty($_SESSION['memberID'])) return;

		/* abort if current page is one of the following exceptions */
		if(in_array(basename($_SERVER['PHP_SELF']), [
			'pageEditMember.php',
			'membership_passwordReset.php',
			'membership_profile.php',
			'membership_signup.php',
			'pageChangeMemberStatus.php',
			'pageDeleteGroup.php',
			'pageDeleteMember.php',
			'pageEditGroup.php',
			'pageEditMemberPermissions.php',
			'pageRebuildFields.php',
			'pageSettings.php',
			'ajax_check_login.php',
			'parent-children.php',
		])) return;

		// abort if current page is ajax
		if(is_ajax()) return;
		if(strpos(basename($_SERVER['PHP_SELF']), 'ajax-') === 0) return;

		// run once per session, but force proceeding if not all mem tables created
		$res = sql("show tables like 'membership_%'", $eo);
		$num_mem_tables = db_num_rows($res);
		$mem_update_fn = membership_table_functions();
		if(isset($_SESSION['setupMembership']) && $num_mem_tables >= count($mem_update_fn)) return;

		// call each update_membership function
		foreach($mem_update_fn as $mem_fn) {
			$mem_fn();
		}

		configure_anonymous_group();
		configure_admin_group();

		$_SESSION['setupMembership'] = time();
	}
	########################################################################
	function membership_table_functions() {
		// returns a list of update_membership_* functions
		$arr = get_defined_functions();
		return array_filter($arr['user'], function($f) {
			return (strpos($f, 'update_membership_') !== false);
		});
	}
	########################################################################
	function configure_anonymous_group() {
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		$adminConfig = config('adminConfig');
		$today = @date('Y-m-d');

		$anon_group_safe = makeSafe($adminConfig['anonymousGroup']);
		$anon_user = strtolower($adminConfig['anonymousMember']);
		$anon_user_safe = makeSafe($anon_user);

		/* create anonymous group if not there and get its ID */
		$same_fields = "`allowSignup`=0, `needsApproval`=0";
		sql("INSERT INTO `membership_groups` SET
				`name`='{$anon_group_safe}', {$same_fields},
				`description`='Anonymous group created automatically on {$today}'
			ON DUPLICATE KEY UPDATE {$same_fields}",
		$eo);

		$anon_group_id = sqlValue("SELECT `groupID` FROM `membership_groups` WHERE `name`='{$anon_group_safe}'");
		if(!$anon_group_id) return;

		/* create guest user if not there or if guest name in config differs from that in db */
		$anon_user_db = sqlValue("SELECT LCASE(`memberID`) FROM `membership_users`
			WHERE `groupID`='{$anon_group_id}'");
		if(!$anon_user_db || $anon_user_db != $anon_user) {
			sql("DELETE FROM `membership_users` WHERE `groupID`='{$anon_group_id}'", $eo);
			sql("INSERT INTO `membership_users` SET
				`memberID`='{$anon_user_safe}',
				`signUpDate`='{$today}',
				`groupID`='{$anon_group_id}',
				`isBanned`=0,
				`isApproved`=1,
				`comments`='Anonymous member created automatically on {$today}'",
			$eo);
		}
	}
	########################################################################
	function configure_admin_group() {
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		$adminConfig = config('adminConfig');
		$today = @date('Y-m-d');
		$admin_group_safe = 'Admins';
		$admin_user_safe = makeSafe(strtolower($adminConfig['adminUsername']));
		$admin_hash_safe = makeSafe($adminConfig['adminPassword']);
		$admin_email_safe = makeSafe($adminConfig['senderEmail']);

		/* create admin group if not there and get its ID */
		$same_fields = "`allowSignup`=0, `needsApproval`=1";
		sql("INSERT INTO `membership_groups` SET
				`name`='{$admin_group_safe}', {$same_fields},
				`description`='Admin group created automatically on {$today}'
			ON DUPLICATE KEY UPDATE {$same_fields}",
		$eo);
		$admin_group_id = sqlValue("SELECT `groupID` FROM `membership_groups` WHERE `name`='{$admin_group_safe}'");
		if(!$admin_group_id) return;

		/* create super-admin user if not there (if exists, query would abort with suppressed error) */
		sql("INSERT INTO `membership_users` SET
			`memberID`='{$admin_user_safe}',
			`passMD5`='{$admin_hash_safe}',
			`email`='{$admin_email_safe}',
			`signUpDate`='{$today}',
			`groupID`='{$admin_group_id}',
			`isBanned`=0,
			`isApproved`=1,
			`comments`='Admin member created automatically on {$today}'",
		$eo);

		/* insert/update admin group permissions to allow full access to all tables */
		$tables = getTableList(true);
		foreach($tables as $tn => $ignore) {
			$same_fields = '`allowInsert`=1,`allowView`=3,`allowEdit`=3,`allowDelete`=3';
			sql("INSERT INTO `membership_grouppermissions` SET
					`groupID`='{$admin_group_id}',
					`tableName`='{$tn}',
					{$same_fields}
				ON DUPLICATE KEY UPDATE {$same_fields}",
			$eo);
		}
	}
	########################################################################
	function get_table_keys($tn) {
		$keys = [];
		$res = sql("SHOW KEYS FROM `{$tn}`", $eo);
		while($row = db_fetch_assoc($res))
			$keys[$row['Key_name']][$row['Seq_in_index']] = $row;

		return $keys;
	}
	########################################################################
	function get_table_fields($tn = null, $include_internal_tables = false) {
		static $schema = null, $internalTables = null;

		if($schema === null) {
			/* application schema as created in AppGini */
			$schema = [
				'user_table' => [
					'user_id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'memberID' => [
						'appgini' => "VARCHAR(255) NULL UNIQUE",
						'info' => [
							'caption' => 'Member ID',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
				],
				'suggestion' => [
					'suggestion_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Event'",
						'info' => [
							'caption' => 'Suggestion Related to Department',
							'description' => '',
						],
					],
					'suggestion' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Suggestion / Complaint',
							'description' => '',
						],
					],
					'attachment' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Attachment',
							'description' => 'Maximum file size allowed: 200 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'department_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks of Department/Office Head',
							'description' => '',
						],
					],
					'ceo_pd_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks of CEO/PD',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending'",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by',
							'description' => '',
						],
					],
				],
				'approval_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'PD'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approval Type',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Description',
							'description' => '',
						],
					],
					'quantity' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Quantity',
							'description' => '',
						],
					],
					'full_est_value' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Full Estimated Value',
							'description' => '',
						],
					],
					'name_of_vendor' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of Vendor',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'requested_department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Requested Department/Appointment',
							'description' => '',
						],
					],
					'person_responsbility' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Person Responsbility',
							'description' => '',
						],
					],
					'mode_of_purchase' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mode of Purchase',
							'description' => '',
						],
					],
					'others_if_any' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Others if Any',
							'description' => '',
						],
					],
					'recurring_budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Recurring Budget (For Accounts Department)',
							'description' => '',
						],
					],
					'non_recurring_budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Non Recurring Budget (For Account Department)',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'remarks_for_approval' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks for Approval',
							'description' => '',
						],
					],
					'image' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload Image if Any (Optional)',
							'description' => 'Maximum file size allowed: 1000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'other_file' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload Other File if Any (Optional)',
							'description' => 'Maximum file size allowed: 100000 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'techlead_web_page' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'techlead' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'GNSS Tech Lead'",
						'info' => [
							'caption' => 'Tech Lead',
							'description' => '',
						],
					],
					'category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Foundational Research'",
						'info' => [
							'caption' => 'Category',
							'description' => '',
						],
					],
					'author' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Author/Team/Manager',
							'description' => '',
						],
					],
					'content_title' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Web Page Sub-section Title',
							'description' => '',
						],
					],
					'content' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Web Page Sub-section Material',
							'description' => '',
						],
					],
					'content_learn_more' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Web Page Sub-section Learn More Content',
							'description' => '',
						],
					],
					'img1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload Image First (Required)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'img2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload Image Second (Optional)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status by CEO',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval Remarks by CEO',
							'description' => '',
						],
					],
					'website_update_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending'",
						'info' => [
							'caption' => 'Website Update Status by IT Team',
							'description' => '',
						],
					],
					'website_update_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Website Update Remarks by IT Team',
							'description' => '',
						],
					],
					'website_update_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Website Updated Date by IT Team',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
				],
				'navavishkar_stay_facilities_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'item_purchased_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Item/Service Purchased Date',
							'description' => '',
						],
					],
					'type_of_item' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'type_of_item',
							'description' => '',
						],
					],
					'SubCategory' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Sub Category',
							'description' => '',
						],
					],
					'Item_serial_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Item Serial No',
							'description' => '',
						],
					],
					'particulars_of_supplier_name_address' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Partculars of Supplier Vendor Name & Address',
							'description' => '',
						],
					],
					'ItemDescription' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Item Description',
							'description' => '',
						],
					],
					'BillNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bill No.',
							'description' => '',
						],
					],
					'BillDate' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Bill Date',
							'description' => '',
						],
					],
					'QUANTITY' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Quantity',
							'description' => '',
						],
					],
					'CostoftheAssetinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cost of the Item (in INR)',
							'description' => '',
						],
					],
					'TotalInvoiceValueinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Invoice Value (in INR)',
							'description' => '',
						],
					],
					'CustodyDepartment' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custody Department',
							'description' => '',
						],
					],
					'custodian' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Custodian',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Usage Requirements)',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
				],
				'navavishkar_stay_facilities_allotment_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'item_lookup' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Asset Details',
							'description' => '',
						],
					],
					'select_employee' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Select employee',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'alloted_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Alloted by',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'returned_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Returned Date',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
				],
				'car_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'car_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Car number',
							'description' => '',
						],
					],
					'registration_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Registration number',
							'description' => '',
						],
					],
					'car_model' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Car model',
							'description' => '',
						],
					],
					'car_vin' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Car Vehicle Identification Number',
							'description' => '',
						],
					],
					'fuel_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Fuel type',
							'description' => '',
						],
					],
					'seating_capacity' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Seating capacity',
							'description' => '',
						],
					],
					'car_color' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Car color',
							'description' => '',
						],
					],
					'rental_company_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Rental company name',
							'description' => '',
						],
					],
					'contact_person' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact person',
							'description' => '',
						],
					],
					'contact_number_of_person' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact number of person',
							'description' => '',
						],
					],
					'rental_rate' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Rental rate (In INR)',
							'description' => '',
						],
					],
					'rental_start_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Rental start date',
							'description' => '',
						],
					],
					'rental_end_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Rental end date',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'car_usage_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'car_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Select Car',
							'description' => '',
						],
					],
					'used_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Used by',
							'description' => '',
						],
					],
					'datetime_from' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'Date and time from',
							'description' => '',
						],
					],
					'datetime_to' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'Date and time to',
							'description' => '',
						],
					],
					'total_distance_run' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total distance run (In KM)',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'cycle_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'registration_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Registration number',
							'description' => '',
						],
					],
					'cycle_model' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cycle model',
							'description' => '',
						],
					],
					'cycle_color' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cycle color',
							'description' => '',
						],
					],
					'responsible_contact_person' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Responsible Contact Person',
							'description' => '',
						],
					],
					'contact_number_of_person' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact number of person',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'cycle_usage_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'cycle_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Cycle Details',
							'description' => '',
						],
					],
					'used_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Used by',
							'description' => '',
						],
					],
					'datetime_from' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'Date and time from',
							'description' => '',
						],
					],
					'datetime_to' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'Date and time to',
							'description' => '',
						],
					],
					'total_distance_run' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total distance run (In KM)',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Optional)',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'gym_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'in' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'In Time',
							'description' => '',
						],
					],
					'out' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Out Time',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Optional)',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'coffee_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'cup_type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Cup'",
						'info' => [
							'caption' => 'Cup Type',
							'description' => '',
						],
					],
					'time' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Time',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Optional)',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'cafeteria_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Breakfast'",
						'info' => [
							'caption' => 'Type',
							'description' => '',
						],
					],
					'time' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Time',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Optional)',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'event_table' => [
					'event_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'event_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Event name',
							'description' => '',
						],
					],
					'participants' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Participants',
							'description' => '',
						],
					],
					'venue' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Venue',
							'description' => '',
						],
					],
					'event_from_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Event from date',
							'description' => '',
						],
					],
					'event_to_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Event to date',
							'description' => '',
						],
					],
					'event_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Event str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'outcomes_expected_table' => [
					'outcomes_expected_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'event_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Event',
							'description' => '',
						],
					],
					'target_audience' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Target audience',
							'description' => '',
						],
					],
					'expected_outcomes' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Expected outcomes',
							'description' => '',
						],
					],
					'outcomes_expected_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Outcomes expected str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'event_decision_table' => [
					'decision_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'outcomes_expected_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Expected Outcomes of Meeting',
							'description' => '',
						],
					],
					'decision_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Decision description',
							'description' => '',
						],
					],
					'decision_actor' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Decision actor',
							'description' => '',
						],
					],
					'action_taken_with_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Action taken with date',
							'description' => '',
						],
					],
					'decision_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Yet to Start'",
						'info' => [
							'caption' => 'Decision status',
							'description' => '',
						],
					],
					'decision_status_update_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Decision status update date',
							'description' => '',
						],
					],
					'decision_status_remarks_by_superior' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Decision status remarks by superior',
							'description' => '',
						],
					],
					'decision_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Decision str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'meetings_table' => [
					'meetings_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'visiting_card_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Visiting card details',
							'description' => '',
						],
					],
					'event_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Event Details',
							'description' => '',
						],
					],
					'meeting_title' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Meeting title',
							'description' => '',
						],
					],
					'participants' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Participants',
							'description' => '',
						],
					],
					'venue' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Venue',
							'description' => '',
						],
					],
					'meeting_from_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Meeting from date',
							'description' => '',
						],
					],
					'meeting_to_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Meeting to date',
							'description' => '',
						],
					],
					'minutes_of_meeting' => [
						'appgini' => "LONGTEXT NULL",
						'info' => [
							'caption' => 'Minutes of Meeting',
							'description' => '',
						],
					],
					'meeting_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Meeting str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'agenda_table' => [
					'agenda_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'meeting_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Meeting',
							'description' => '',
						],
					],
					'agenda_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Agenda description',
							'description' => '',
						],
					],
					'agenda_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Agenda str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'decision_table' => [
					'decision_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'agenda_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Agenda of Meeting',
							'description' => '',
						],
					],
					'decision_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Decision description',
							'description' => '',
						],
					],
					'decision_actor' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Decision actor',
							'description' => '',
						],
					],
					'action_taken_with_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Action taken with date',
							'description' => '',
						],
					],
					'decision_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Yet to Start'",
						'info' => [
							'caption' => 'Decision status',
							'description' => '',
						],
					],
					'decision_status_update_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Decision status update date',
							'description' => '',
						],
					],
					'decision_status_remarks_by_superior' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Decision status remarks by superior',
							'description' => '',
						],
					],
					'decision_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Decision str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'participants_table' => [
					'participants_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'event_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Event',
							'description' => '',
						],
					],
					'meeting_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Meeting',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'participant_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Participant type',
							'description' => '',
						],
					],
					'accepted_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Accepted status',
							'description' => '',
						],
					],
					'status_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Status date',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'action_actor' => [
					'actor_ID' => [
						'appgini' => "VARCHAR(40) NOT NULL PRIMARY KEY",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'action_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Action str',
							'description' => '',
						],
					],
					'actor' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Actor',
							'description' => '',
						],
					],
					'action_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Action status',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'visiting_card_table' => [
					'visiting_card_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'recommended_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Recommended by',
							'description' => '',
						],
					],
					'designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'company_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Company name',
							'description' => '',
						],
					],
					'mobile_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile no',
							'description' => '',
						],
					],
					'email' => [
						'appgini' => "VARCHAR(80) NULL",
						'info' => [
							'caption' => 'Email',
							'description' => '',
						],
					],
					'company_website_addr' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Company website address',
							'description' => '',
						],
					],
					'given_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Given by',
							'description' => '',
						],
					],
					'suggested_way_forward' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Suggested way forward',
							'description' => '',
						],
					],
					'front_img' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Front img',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'back_img' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Back img',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'visiting_card_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Visiting card str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'mou_details_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Type',
							'description' => '',
						],
					],
					'company_name' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Company name',
							'description' => '',
						],
					],
					'objective_of_mou' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Objectives/ Scope of the MOU',
							'description' => '',
						],
					],
					'agreement_period' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Agreement period (In Years)',
							'description' => '',
						],
					],
					'date_of_agreement' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of agreement',
							'description' => '',
						],
					],
					'date_of_expiry' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of expiry',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'point_of_contact' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Point of contact (Name)',
							'description' => '',
						],
					],
					'contact_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact number',
							'description' => '',
						],
					],
					'contact_email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact email id',
							'description' => '',
						],
					],
					'website_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Website link',
							'description' => '',
						],
					],
					'country' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Country',
							'description' => '',
						],
					],
					'assigned_mou_to' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Assigned MoU to',
							'description' => '',
						],
					],
					'upload_mou' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload MoU (PDF or DOC format)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'goal_setting_table' => [
					'goal_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'goal_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Goal status',
							'description' => '',
						],
					],
					'goal_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Goal description',
							'description' => '',
						],
					],
					'goal_duration' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Goal duration',
							'description' => '',
						],
					],
					'goal_set_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Goal set date',
							'description' => '',
						],
					],
					'supervisor_name' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Supervisor name',
							'description' => '',
						],
					],
					'assigned_to' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Assigned to',
							'description' => '',
						],
					],
					'goal_setting_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Goal setting str',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'goal_progress_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'goal_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Goal details',
							'description' => '',
						],
					],
					'goal_progress' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Goal progress',
							'description' => '',
						],
					],
					'remarks_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Remarks by',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'task_allocation_table' => [
					'task_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'task_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Task description',
							'description' => '',
						],
					],
					'task_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Task status',
							'description' => '',
						],
					],
					'task_duration' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Task Duration (Number of Days)',
							'description' => '',
						],
					],
					'task_set_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Task Assigned Date',
							'description' => '',
						],
					],
					'supervisor_name' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Supervisor name',
							'description' => '',
						],
					],
					'assigned_to' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Assigned to',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'task_progress_status_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'task_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Task',
							'description' => '',
						],
					],
					'progress_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Progress Description',
							'description' => '',
						],
					],
					'progree_entry_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Progree Entry Date & Time',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'timesheet_entry_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'time_in' => [
						'appgini' => "DATETIME NOT NULL",
						'info' => [
							'caption' => 'From Date Time',
							'description' => '',
						],
					],
					'time_out' => [
						'appgini' => "DATETIME NOT NULL",
						'info' => [
							'caption' => 'To Date Time',
							'description' => '',
						],
					],
					'number_of_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of Hours',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Task Description',
							'description' => '',
						],
					],
					'reporting_manager' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Reporting manager',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'internship_fellowship_details_app' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'standard' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Standard',
							'description' => '',
						],
					],
					'iittnif_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'IITTNiF id',
							'description' => '',
						],
					],
					'name_of_the_candidate' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the Candidate',
							'description' => '',
						],
					],
					'type_of_internship_fellowship' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Type of Internship/Fellowship',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'institute_id_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute ID number',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'latitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Latitude',
							'description' => '',
						],
					],
					'longitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Longitude',
							'description' => '',
						],
					],
					'start_date' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Start date',
							'description' => '',
						],
					],
					'end_date' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'End date',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Yet to Start'",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'cotegory' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cotegory',
							'description' => '',
						],
					],
					'report_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Report link',
							'description' => '',
						],
					],
					'outcomes' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Outcomes',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'star_pnt' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'iittnif_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'IITTNiF id',
							'description' => '',
						],
					],
					'name_of_the_candidate' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the Candidate',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'workspace' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Workspace',
							'description' => '',
						],
					],
					'year_and_department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Year and department',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'hrd_sdp_events_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'program_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Program name',
							'description' => '',
						],
					],
					'area_of_workshop' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Topic/Area of Workshop',
							'description' => '',
						],
					],
					'host_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Host name',
							'description' => '',
						],
					],
					'location' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Location',
							'description' => '',
						],
					],
					'start_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start date',
							'description' => '',
						],
					],
					'end_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End date',
							'description' => '',
						],
					],
					'number_of_participants' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of participants',
							'description' => '',
						],
					],
					'more_details' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'More details',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'training_program_on_geospatial_tchnologies_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'certificate_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Certificate No.',
							'description' => '',
						],
					],
					'datetime' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Datetime',
							'description' => '',
						],
					],
					'salutation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Salutation',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email id',
							'description' => '',
						],
					],
					'secondary_email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Secondary email id',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'whatsapp_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Whatsapp number',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'social_media_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Social media link',
							'description' => '',
						],
					],
					'education_qualification' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Educational Qualification',
							'description' => '',
						],
					],
					'profession' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Profession',
							'description' => '',
						],
					],
					'school_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School/Institute Name',
							'description' => '',
						],
					],
					'parents_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Parent\'s Name',
							'description' => '',
						],
					],
					'parents_contact_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Parent\'s Contact No.',
							'description' => '',
						],
					],
					'parents_email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Parents email id',
							'description' => '',
						],
					],
					'residential_address' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Residential address',
							'description' => '',
						],
					],
					'parents_designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'parents_school_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Parents school name',
							'description' => '',
						],
					],
					'teaching_subject' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Teaching subject',
							'description' => '',
						],
					],
					'address_line_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Address line 2',
							'description' => '',
						],
					],
					'city' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'City',
							'description' => '',
						],
					],
					'state_region_province' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'State/Region/Province',
							'description' => '',
						],
					],
					'zip_code' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Zip code',
							'description' => '',
						],
					],
					'country' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Country',
							'description' => '',
						],
					],
					'how_did_you_know' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'How did you know about the Training/Workshop?',
							'description' => '',
						],
					],
					'attended_training_school' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Training/Workshop attended at school/Institute name.',
							'description' => '',
						],
					],
					'attended_training_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Attended training date',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'space_day_school_details_app' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'school_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School name',
							'description' => '',
						],
					],
					'profile_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Profile type',
							'description' => '',
						],
					],
					'name_of_student_teacher' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of Student/Teacher',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'class_subject' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Class(If student) / Subject Handled (If Teacher)',
							'description' => '',
						],
					],
					'contact_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact number',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'space_day_college_student_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'name_of_student' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the student',
							'description' => '',
						],
					],
					'registration_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Registration number',
							'description' => '',
						],
					],
					'degree_department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Degree & Department',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'home_address' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Home address',
							'description' => '',
						],
					],
					'email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email id',
							'description' => '',
						],
					],
					'contact_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact number',
							'description' => '',
						],
					],
					'interest' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Interest',
							'description' => '',
						],
					],
					'college_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'College name',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'school_list' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'district_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'District name',
							'description' => '',
						],
					],
					'school_code' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School code',
							'description' => '',
						],
					],
					'school_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School name',
							'description' => '',
						],
					],
					'pincode' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Pincode',
							'description' => '',
						],
					],
					'school_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School type',
							'description' => '',
						],
					],
					'school_phone_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School phone number',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'sdp_participants_college_details_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'participants_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Participants type',
							'description' => '',
						],
					],
					'school_college_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'School/College name',
							'description' => '',
						],
					],
					'location' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Location',
							'description' => '',
						],
					],
					'latitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Latitude',
							'description' => '',
						],
					],
					'longitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Longitude',
							'description' => '',
						],
					],
					'number_of_participants' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of participants',
							'description' => '',
						],
					],
					'start_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start date',
							'description' => '',
						],
					],
					'end_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End date',
							'description' => '',
						],
					],
					'state' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'State',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'asset_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'ClassificationofAssest' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Classification of Assest',
							'description' => '',
						],
					],
					'SubCategory' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Sub Category',
							'description' => '',
						],
					],
					'AssetSerialNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Asset Serial No',
							'description' => '',
						],
					],
					'QRBarCode' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'QR & Bar Code',
							'description' => '',
						],
					],
					'AssetNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Asset No',
							'description' => '',
						],
					],
					'PONO' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PO. NO.',
							'description' => '',
						],
					],
					'PODATE' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'P/O Date',
							'description' => '',
						],
					],
					'particulars_of_supplier_name_address' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Partculars of Supplier Vendor Name & Address',
							'description' => '',
						],
					],
					'ItemDescription' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Item Description',
							'description' => '',
						],
					],
					'BillNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bill No.',
							'description' => '',
						],
					],
					'BillDate' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Bill Date',
							'description' => '',
						],
					],
					'QUANTITY' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Quantity',
							'description' => '',
						],
					],
					'CostoftheAssetinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cost of the Asset (in INR)',
							'description' => '',
						],
					],
					'TotalInvoiceValueinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Invoice Value (in INR)',
							'description' => '',
						],
					],
					'CustodyDepartment' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custody Department',
							'description' => '',
						],
					],
					'custodian' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custodian',
							'description' => '',
						],
					],
					'CustodianSignature' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custodian Signature',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'asset_allotment_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'asset_lookup' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Asset Details',
							'description' => '',
						],
					],
					'select_employee' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Select employee',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'alloted_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Alloted by',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'returned_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Returned date',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'sub_asset_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'ClassificationofAssest' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Classification of Assest',
							'description' => '',
						],
					],
					'SubCategory' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Sub Category',
							'description' => '',
						],
					],
					'AssetSerialNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Asset Serial No',
							'description' => '',
						],
					],
					'QRBarCode' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'QR & Bar Code',
							'description' => '',
						],
					],
					'AssetNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Asset No',
							'description' => '',
						],
					],
					'PONO' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PO. NO.',
							'description' => '',
						],
					],
					'PODATE' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'P/O Date',
							'description' => '',
						],
					],
					'particulars_of_supplier_name_address' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Partculars of Supplier Vendor Name & Address',
							'description' => '',
						],
					],
					'ItemDescription' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Item Description',
							'description' => '',
						],
					],
					'BillNo' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bill No.',
							'description' => '',
						],
					],
					'BillDate' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Bill Date',
							'description' => '',
						],
					],
					'QUANTITY' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Quantity',
							'description' => '',
						],
					],
					'CostoftheAssetinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cost of the Asset (in INR)',
							'description' => '',
						],
					],
					'TotalInvoiceValueinINR' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Invoice Value (in INR)',
							'description' => '',
						],
					],
					'CustodyDepartment' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custody Department',
							'description' => '',
						],
					],
					'custodian' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custodian',
							'description' => '',
						],
					],
					'CustodianSignature' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custodian Signature',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'sub_asset_allotment_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'sub_asset_lookup' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Sub Asset Details',
							'description' => '',
						],
					],
					'select_employee' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Select employee',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'alloted_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Alloted by',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'returned_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Returned date',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'it_inventory_app' => [
					'it_inventory_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Description',
							'description' => '',
						],
					],
					'classification_of_asset' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Classification of asset',
							'description' => '',
						],
					],
					'sub_category' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Sub category',
							'description' => '',
						],
					],
					'qty' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Qty',
							'description' => '',
						],
					],
					'asset_serial_number' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Asset serial number',
							'description' => '',
						],
					],
					'qr_and_bar_code' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Qr and bar code',
							'description' => '',
						],
					],
					'custody_department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Custody department',
							'description' => '',
						],
					],
					'custodian' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Custodian',
							'description' => '',
						],
					],
					'custodian_signature' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Custodian signature',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'no_of_years_useful_life_of_assets' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Number of years useful life of assets',
							'description' => '',
						],
					],
					'date_of_useful_life_of_assets_ends' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of useful life of assets ends',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'sactioned_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Sactioned by',
							'description' => '',
						],
					],
					'it_inventory_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'It inventory str',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'it_inventory_billing_details' => [
					'it_inventory_biling_details_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'it_inventory_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'IT inventory ',
							'description' => '',
						],
					],
					'po_no' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'PO Number',
							'description' => '',
						],
					],
					'po_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'PO Date',
							'description' => '',
						],
					],
					'particulars_of_supplier' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Particulars of supplier',
							'description' => '',
						],
					],
					'item_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Item description',
							'description' => '',
						],
					],
					'bill_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bill no',
							'description' => '',
						],
					],
					'bill_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Bill date',
							'description' => '',
						],
					],
					'quantity' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Quantity',
							'description' => '',
						],
					],
					'total_invoice_value' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total invoice value',
							'description' => '',
						],
					],
					'cost_of_the_asset' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Cost of the asset',
							'description' => '',
						],
					],
					'image' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Image',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'it_inventory_allotment_table' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'select_employee' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Select employee',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'inventory_details' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Inventory Details',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'alloted_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Alloted by',
							'description' => '',
						],
					],
					'allotment_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending to allot'",
						'info' => [
							'caption' => 'Allotment Status',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'return_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Not Returned'",
						'info' => [
							'caption' => 'Return status',
							'description' => '',
						],
					],
					'returned_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Returned date',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'computer_details_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'pc_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PC number',
							'description' => '',
						],
					],
					'pc_hostname' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PC hostname',
							'description' => '',
						],
					],
					'pc_mac_address' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PC MAC Address',
							'description' => '',
						],
					],
					'pc_static_ip' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PC Static IP',
							'description' => '',
						],
					],
					'room_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Room number',
							'description' => '',
						],
					],
					'maintained_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Maintained by',
							'description' => '',
						],
					],
					'assigned_to_user' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Assigned to user',
							'description' => '',
						],
					],
					'remote_access' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Remote access',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'computer_user_details' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'pc_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL",
						'info' => [
							'caption' => 'PC ID',
							'description' => '',
						],
					],
					'entry_time' => [
						'appgini' => "TIME NOT NULL",
						'info' => [
							'caption' => 'Entry time',
							'description' => '',
						],
					],
					'exit_time' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Exit time',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'computer_allotment_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'pc_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'PC ID',
							'description' => '',
						],
					],
					'name_of_user' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of user',
							'description' => '',
						],
					],
					'role' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Role',
							'description' => '',
						],
					],
					'from_date' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'From date',
							'description' => '',
						],
					],
					'to_date' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'To date',
							'description' => '',
						],
					],
					'purpose' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Purpose',
							'description' => '',
						],
					],
					'email_d' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email ID',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'emp_details' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Emp details',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'employees_personal_data_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'employee_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Employee type',
							'description' => '',
						],
					],
					'emp_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Emp id',
							'description' => '',
						],
					],
					'date_of_birth' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of birth',
							'description' => '',
						],
					],
					'blood_group' => [
						'appgini' => "VARCHAR(10) NULL",
						'info' => [
							'caption' => 'Blood group',
							'description' => '',
						],
					],
					'email' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email',
							'description' => '',
						],
					],
					'phone_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Phone number',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'date_of_joining' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of joining',
							'description' => '',
						],
					],
					'date_of_exit' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of exit',
							'description' => '',
						],
					],
					'active_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Active status',
							'description' => '',
						],
					],
					'profile_photo' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Profile photo',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'signature' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Signature',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'employee_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Employee str',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'employees_designation_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'employee_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Employee Details',
							'description' => '',
						],
					],
					'designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'date_of_appointment_to_designation' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of appointment to designation',
							'description' => '',
						],
					],
					'active_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Active status',
							'description' => '',
						],
					],
					'reporting_officer' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Reporting Officer',
							'description' => '',
						],
					],
					'reviewing_officer' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Reviewing Officer',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'employees_designation_str' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Employees designation str',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'employees_appraisal_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'employee_designation_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Employee Details',
							'description' => '',
						],
					],
					'current_review_period_from' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Current Review Period From Date',
							'description' => '',
						],
					],
					'current_review_period_to' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Current Review Period To Date',
							'description' => '',
						],
					],
					'roles' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Roles & Responsibilities',
							'description' => '',
						],
					],
					'self_explanation' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Employee Self-explanation',
							'description' => '',
						],
					],
					'upload_file_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload file 1',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: ppt, pptx, pptm, pdf, ppsx, ppsm, pps, odp',
						],
					],
					'upload_file_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload file 2',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: ppt, pptx, pptm, pdf, ppsx, ppsm, pps, odp',
						],
					],
					'upload_file_3' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload file 3',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: ppt, pptx, pptm, pdf, ppsx, ppsm, pps, odp',
						],
					],
					'reporting_officer_feedback' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reporting Officer Feedback on the Employee Responsibilities',
							'description' => '',
						],
					],
					'observations_by_reporting_officer' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Observations by the Reporting Officer',
							'description' => '',
						],
					],
					'overall_rating' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Overall Rating by the Reporting Officer',
							'description' => 'Scale of Rating: 1-Poor | 2-Satisfactory | 3-Average | 4-Good | 5-Excellent',
						],
					],
					'reporting_appraisal_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending'",
						'info' => [
							'caption' => 'Appraisal Feedback Status by Reporting Officer',
							'description' => '',
						],
					],
					'reviewing_officer' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Reviewing officer',
							'description' => '',
						],
					],
					'reviewing_officer_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reviewing Officer Remarks',
							'description' => '',
						],
					],
					'reviewing_appraisal_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending'",
						'info' => [
							'caption' => 'Appraisal Feedback Status by Reviewing Officer',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'beyond_working_hours_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'CEO'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'days_remark' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Days Remark (Mention Day Names like SUN,MON,TUE,WED,THU,FRI,SAT) & Name of Holiday as in TIH Calendar',
							'description' => '',
						],
					],
					'start_datetime' => [
						'appgini' => "DATETIME NOT NULL",
						'info' => [
							'caption' => 'Start Date & Time',
							'description' => '',
						],
					],
					'end_datetime' => [
						'appgini' => "DATETIME NOT NULL",
						'info' => [
							'caption' => 'End Date & Time',
							'description' => '',
						],
					],
					'reason_for_overtime' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reason for Overtime',
							'description' => '',
						],
					],
					'details_of_work_done' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Details of Work Planned/Done (Justify Why Beyond Working Hours was Necessary Indiacating Project Urgency or Orders of Superiors(Designation of Superior) )',
							'description' => '',
						],
					],
					'number_of_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of Hours',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval Remarks',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
				],
				'leave_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'CEO'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Type',
							'description' => '',
						],
					],
					'leave_type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Casual Leave'",
						'info' => [
							'caption' => 'Leave type',
							'description' => '',
						],
					],
					'purpose_of_leave' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Purpose of leave',
							'description' => '',
						],
					],
					'from_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'From Date',
							'description' => '',
						],
					],
					'to_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'To Date & Time',
							'description' => '',
						],
					],
					'upload_img' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Supporting Document (Image)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'upload_pdf' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Supporting Document (PDF)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
				],
				'half_day_leave_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'CEO'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'leave_type' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Morning - Afternoon Shift (1st Half)'",
						'info' => [
							'caption' => 'Leave Type',
							'description' => '',
						],
					],
					'purpose_of_leave' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Purpose of Leave',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval Remarks',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
				],
				'work_from_home_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'CEO'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'work_from_home_purpose' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Purpose of Work From Home',
							'description' => '',
						],
					],
					'from_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'From date',
							'description' => '',
						],
					],
					'to_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'To date',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'upload_img' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Supporting Document (Image)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'upload_pdf' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Supporting Document (PDF)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'work_from_home_tasks_app' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_from' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'CEO'",
						'info' => [
							'caption' => 'Approval From',
							'description' => '',
						],
					],
					'work_from_home_details' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Work From Home Details',
							'description' => '',
						],
					],
					'day' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day',
							'description' => '',
						],
					],
					'hour_from' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Hour From',
							'description' => '',
						],
					],
					'hour_to' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Hour To',
							'description' => '',
						],
					],
					'activity_undertaken' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Activity Undertaken',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'navavishkar_stay_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'full_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Full Name',
							'description' => '',
						],
					],
					'emp_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Employee ID',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'contact_email' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact Email',
							'description' => '',
						],
					],
					'contact_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contact Number',
							'description' => '',
						],
					],
					'room_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Room number',
							'description' => '',
						],
					],
					'check_in_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Check in date',
							'description' => '',
						],
					],
					'checkout_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Checkout date',
							'description' => '',
						],
					],
					'reason_for_stay' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reason for stay',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'navavishkar_stay_payment_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'navavishakr_stay_details' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Navavishakr stay details',
							'description' => '',
						],
					],
					'payment_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Pending'",
						'info' => [
							'caption' => 'Payment status',
							'description' => '',
						],
					],
					'amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Amount (INR)',
							'description' => '',
						],
					],
					'additional_facilities_provided' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Additional Facilities Provided (Optional)',
							'description' => '',
						],
					],
					'payment_img' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload Payment Image',
							'description' => 'Maximum file size allowed: 100 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'email_id_allocation_table' => [
					'email_id_allocation_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'name_of_person' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of person',
							'description' => '',
						],
					],
					'allocated_email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Allocated email id',
							'description' => '',
						],
					],
					'alternative_email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Alternative email id',
							'description' => '',
						],
					],
					'date_of_allocation' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of allocation',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'reporting_manager' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Reporting manager',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'attendence_details_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'enrollment_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Enrollment No.',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name in device scanner',
							'description' => '',
						],
					],
					'mode' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mode of punch',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'in_time' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Punch In Time',
							'description' => '',
						],
					],
					'out_time' => [
						'appgini' => "TIME NULL",
						'info' => [
							'caption' => 'Punch Out Time',
							'description' => '',
						],
					],
					'working_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Working hours',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
				],
				'all_startup_data_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'company_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Company id',
							'description' => '',
						],
					],
					'name_of_the_company' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the company',
							'description' => '',
						],
					],
					'business_sector' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Business sector',
							'description' => '',
						],
					],
					'name_of_the_person' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the person',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'email_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email id',
							'description' => '',
						],
					],
					'mode_of_incubation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mode of incubation',
							'description' => '',
						],
					],
					'date_of_incubation' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of incubation',
							'description' => '',
						],
					],
					'shortlisted_for_fund' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Shortlisted for fund',
							'description' => '',
						],
					],
					'website_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Website link',
							'description' => '',
						],
					],
					'company_logo' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Company logo',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'shortlisted_startups_for_fund_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'startup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Select startup',
							'description' => '',
						],
					],
					'scheme' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Scheme',
							'description' => '',
						],
					],
					'recommended_fund' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Recommended fund (in Lakhs INR)',
							'description' => '',
						],
					],
					'name_of_founder' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of founder',
							'description' => '',
						],
					],
					'email_of_founder' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email of founder',
							'description' => '',
						],
					],
					'phone_number_of_founder' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Phone number of founder',
							'description' => '',
						],
					],
					'due_diligence_start' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Due diligence start',
							'description' => '',
						],
					],
					'terms_agreed' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Terms agreed',
							'description' => '',
						],
					],
					'grant_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Grant amount (in INR)',
							'description' => '',
						],
					],
					'debt_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Debt amount (in INR)',
							'description' => '',
						],
					],
					'ocd_or_ccd_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'OCD/CCD Amount (in INR)',
							'description' => '',
						],
					],
					'equity_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Equity amount (in INR)',
							'description' => '',
						],
					],
					'interest_rate' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Interest rate (in %)',
							'description' => '',
						],
					],
					'period' => [
						'appgini' => "INT(2) NULL",
						'info' => [
							'caption' => 'Period (in Years)',
							'description' => '',
						],
					],
					'conversion_formula' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Conversion formula',
							'description' => '',
						],
					],
					'equity_diluted' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Equity diluted (in %)',
							'description' => '',
						],
					],
					'comments' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Comments',
							'description' => '',
						],
					],
					'remarks_1' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks 1',
							'description' => '',
						],
					],
					'remarks_2' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks 2',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'shortlisted_startups_dd_and_agreement_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'startup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Startup',
							'description' => '',
						],
					],
					'documents' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Documents',
							'description' => '',
						],
					],
					'status_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'comment_1' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Comment',
							'description' => '',
						],
					],
					'link_to_ddr' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Link to DDR',
							'description' => '',
						],
					],
					'status_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'comment_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Comment',
							'description' => '',
						],
					],
					'link_to_agreement' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Link to agreement',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'vikas_startup_applications_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'startup_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Startup name',
							'description' => '',
						],
					],
					'email' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Email',
							'description' => '',
						],
					],
					'incorporation_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Incorporation date',
							'description' => '',
						],
					],
					'website_url' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Website URL (in any)',
							'description' => '',
						],
					],
					'physical_address' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Physical address',
							'description' => '',
						],
					],
					'primary_contact_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Primary contact name',
							'description' => '',
						],
					],
					'email_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Primary Contact Email',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'name_of_founders' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name(s) of Founders(s)',
							'description' => '',
						],
					],
					'number_of_founders' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Founder(s) Mobile Number(s)',
							'description' => '',
						],
					],
					'email_of_founders' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Founders(s) Email Address(es)',
							'description' => '',
						],
					],
					'business_sector' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Business Sector/Industry',
							'description' => '',
						],
					],
					'number_of_employees' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of employees',
							'description' => '',
						],
					],
					'brief_description_of_service' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Brief Description of Product/Service',
							'description' => '',
						],
					],
					'mode_of_incubation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Preferred Mode of Participation: (Please select one)',
							'description' => '',
						],
					],
					'type_of_workspace_desired' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Type of Workspace Desired',
							'description' => '',
						],
					],
					'key_areas_of_support' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Key areas of support',
							'description' => '',
						],
					],
					'declaration_form_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Declaration form link',
							'description' => '',
						],
					],
					'is_your_start_up_dpiit_registered' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Is your start up DPIIT registered',
							'description' => '',
						],
					],
					'incubation_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Incubation status',
							'description' => '',
						],
					],
					'datetime' => [
						'appgini' => "DATETIME NULL",
						'info' => [
							'caption' => 'Datetime',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'programs_table' => [
					'programs_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'title_of_the_program' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Title of the program',
							'description' => '',
						],
					],
					'target_startup' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Target startup',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'evaluation_table' => [
					'evaluation_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'result' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Result',
							'description' => '',
						],
					],
					'select_startup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Select startup',
							'description' => '',
						],
					],
					'recommendation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Recommendation',
							'description' => '',
						],
					],
					'marks' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Marks',
							'description' => '',
						],
					],
					'reason_for_not_recommending' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reason for not recommending',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'problem_statement_table' => [
					'problem_statement_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'select_program_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Select program id',
							'description' => '',
						],
					],
					'program_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Program description',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'evaluators_table' => [
					'evaluator_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'evaluation_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Evaluation lookup',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'qualification' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Qualification',
							'description' => '',
						],
					],
					'self_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Self description',
							'description' => '',
						],
					],
					'role' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Role',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'approval_billing_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'approval_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Approval Details',
							'description' => '',
						],
					],
					'date_of_purchase' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of Purchase',
							'description' => '',
						],
					],
					'total_amount_of_bill' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Amount of Bill',
							'description' => '',
						],
					],
					'items_list' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Items List',
							'description' => 'Example: Pens-6,Paper-2 reams etc',
						],
					],
					'paid_by' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Paid by',
							'description' => '',
						],
					],
					'attach_bill_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Attach bill 1',
							'description' => 'Maximum file size allowed: 150 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'attach_bill_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Attach bill 2',
							'description' => 'Maximum file size allowed: 150 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'attach_bill_3' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Attach bill 3',
							'description' => 'Maximum file size allowed: 150 KB.<br>Allowed file types: txt, doc, docx, docm, odt, pdf, rtf',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'honorarium_claim_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'name_of_advisor' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of Advisor/Expert/Consultant',
							'description' => '',
						],
					],
					'email_advisor' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Eamil ID of Advisor/Consultant',
							'description' => '',
						],
					],
					'department_of_tih' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department of TIH',
							'description' => '',
						],
					],
					'bank_account_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bank Account No.',
							'description' => '',
						],
					],
					'ifsc_code' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'IFSC Code',
							'description' => '',
						],
					],
					'bank_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Bank Name',
							'description' => '',
						],
					],
					'pan' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PAN',
							'description' => '',
						],
					],
					'place_of_work' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Place of work (Visit) / Online',
							'description' => '',
						],
					],
					'date_1' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day 1 Date',
							'description' => '',
						],
					],
					'hours_1' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'No. Hours',
							'description' => '',
						],
					],
					'date_2' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day 2 Date',
							'description' => '',
						],
					],
					'hours_2' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'No. Hours',
							'description' => '',
						],
					],
					'date_3' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day 3 Date',
							'description' => '',
						],
					],
					'hours_3' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'No. Hours',
							'description' => '',
						],
					],
					'date_4' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day 4 Date',
							'description' => '',
						],
					],
					'hours_4' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'No. Hours',
							'description' => '',
						],
					],
					'date_5' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Day 5 Date',
							'description' => '',
						],
					],
					'hours_5' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'No. Hours',
							'description' => '',
						],
					],
					'total_no_of_days' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total No. of Days',
							'description' => '',
						],
					],
					'total_no_of_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total no of hours',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'no_of_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of hours',
							'description' => '',
						],
					],
					'case_reference_email_subject' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Case Reference Email Subject (If Any)',
							'description' => '',
						],
					],
					'activities' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Activities/Deliverables',
							'description' => '',
						],
					],
					'others_if_any' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Others if any (Optional)',
							'description' => '',
						],
					],
					'coordinated_by_tih_user' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Coordinated by TIH User (For Office Use of TIH)',
							'description' => '',
						],
					],
					'payment_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Payment date (For Office Use of TIH)',
							'description' => '',
						],
					],
					'amount_paid' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Amount paid (For Office Use of TIH)',
							'description' => '',
						],
					],
					'transaction_details' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Transaction details (For Office Use of TIH)',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status (For Office Use of TIH)',
							'description' => '',
						],
					],
					'remarks_for_approval' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks for Approval (For Office Use of TIH)',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved At',
							'description' => '',
						],
					],
				],
				'honorarium_Activities' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'honorarium_details' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Honorarium details',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'no_of_hours' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of hours',
							'description' => '',
						],
					],
					'case_reference_email_subject' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Case Reference Email Subject (If Any)',
							'description' => '',
						],
					],
					'activities' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Activities/Deliverables',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By Username',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved At',
							'description' => '',
						],
					],
				],
				'all_bank_account_statement_table' => [
					'all_bank_account_statement_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'statement_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Select statement type',
							'description' => '',
						],
					],
					'txn_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Txn date',
							'description' => '',
						],
					],
					'value_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Value date',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Description',
							'description' => '',
						],
					],
					'ref_no_or_cheque_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Ref No. / Cheque No.',
							'description' => '',
						],
					],
					'branch_code' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Branch code',
							'description' => '',
						],
					],
					'debit' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Debit',
							'description' => '',
						],
					],
					'credit' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Credit',
							'description' => '',
						],
					],
					'balance_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Balance 1',
							'description' => '',
						],
					],
					'balance_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Balance 2',
							'description' => '',
						],
					],
					'remarks_1' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks 1',
							'description' => '',
						],
					],
					'remarks_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Remarks 2',
							'description' => '',
						],
					],
					'category' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Category',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'payment_track_details_table' => [
					'payment_track_details_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'pfms_num' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PFMS Num.',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Description',
							'description' => '',
						],
					],
					'amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Amount (Rs.)',
							'description' => '',
						],
					],
					'requested_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Requested by',
							'description' => '',
						],
					],
					'paid_to' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Paid to',
							'description' => '',
						],
					],
					'paid_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Paid status',
							'description' => '',
						],
					],
					'payment_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Payment date',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks (Recurring / Non-Recurring)',
							'description' => '',
						],
					],
					'upload_scanned_file_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload scanned file (first)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'upload_scanned_file_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Upload scanned file (second)',
							'description' => 'Maximum file size allowed: 10000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'travel_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'first_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'First name',
							'description' => '',
						],
					],
					'last_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last name',
							'description' => '',
						],
					],
					'age' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Age',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'travel_type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Travel type',
							'description' => '',
						],
					],
					'from_place' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'From Place',
							'description' => '',
						],
					],
					'to_place' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'To Place',
							'description' => '',
						],
					],
					'date_from' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date from',
							'description' => '',
						],
					],
					'date_to' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date to',
							'description' => '',
						],
					],
					'travel_description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Travel description',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'approved_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'approved_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'travel_stay_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'first_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'First name',
							'description' => '',
						],
					],
					'last_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last name',
							'description' => '',
						],
					],
					'age' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Age',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'hotel_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Hotel name',
							'description' => '',
						],
					],
					'hotel_address' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Hotel address',
							'description' => '',
						],
					],
					'checkin_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Checkin date',
							'description' => '',
						],
					],
					'checkout_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Checkout date',
							'description' => '',
						],
					],
					'room_preferance' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Room preferance',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'approved_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'travel_local_commute_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'first_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'First name',
							'description' => '',
						],
					],
					'last_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last name',
							'description' => '',
						],
					],
					'age' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Age',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'local_commute_type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Cab'",
						'info' => [
							'caption' => 'Local Commute Type',
							'description' => '',
						],
					],
					'from_place' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'From Place',
							'description' => '',
						],
					],
					'to_place' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'To Place',
							'description' => '',
						],
					],
					'description' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Description',
							'description' => '',
						],
					],
					'approval_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Under Consideration'",
						'info' => [
							'caption' => 'Approval Status',
							'description' => '',
						],
					],
					'approval_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Approval remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'approved_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'approved_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Approved at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'r_and_d_progress' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Username',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'labs' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Labs',
							'description' => '',
						],
					],
					'today_progress' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Current Week Progress',
							'description' => '',
						],
					],
					'tomorrow_plan' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Next Week Plan',
							'description' => '',
						],
					],
					'ceo_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'CEO Remarks',
							'description' => '',
						],
					],
					'pd_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'PD Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'panel_decision_table_tdp' => [
					'panel_decision_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'edition' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Edition',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Project ID',
							'description' => '',
						],
					],
					'date_of_presentation' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of presentation',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'budget_specified' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Budget specified in Rs.',
							'description' => '',
						],
					],
					'final_budget_to_be_allocated' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Final budget to be allocated in Rs.',
							'description' => '',
						],
					],
					'experts_comments' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Experts comments (Consolidated)',
							'description' => '',
						],
					],
					'trl' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'TRL',
							'description' => '',
						],
					],
					'proposal_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Proposal link',
							'description' => '',
						],
					],
					'updated_proposal_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Updated proposal link',
							'description' => '',
						],
					],
					'where_budget_need' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Where budget need / can be revised',
							'description' => '',
						],
					],
					'final_decision' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Final decision',
							'description' => '',
						],
					],
					'notification_mail' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Notification mail',
							'description' => '',
						],
					],
					'call_done' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Call done',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'selected_proposals_final_tdp' => [
					'selected_proposals_id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'breakthrough' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Breakthrough / Novel',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'short_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Short name',
							'description' => '',
						],
					],
					'duration_in_months' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Duration in months',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'stage_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 1 in Rs.',
							'description' => '',
						],
					],
					'stage_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 2 in Rs.',
							'description' => '',
						],
					],
					'stage_3' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 3 in Rs.',
							'description' => '',
						],
					],
					'stage_4' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 4 in Rs.',
							'description' => '',
						],
					],
					'total_budget_specified' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total budget specified in Rs.',
							'description' => '',
						],
					],
					'one_slide_ppt_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'One slide PPT link',
							'description' => '',
						],
					],
					'proposal_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Proposal link',
							'description' => '',
						],
					],
					'existing_trl' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Existing TRL',
							'description' => '',
						],
					],
					'expected_trl' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Expected TRL',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'stage_wise_budget_table_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'mobile_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Mobile number',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'duration_in_months' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Duration in months',
							'description' => '',
						],
					],
					'total_budget_specified' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Budget specified in Rs.',
							'description' => '',
						],
					],
					'first_phase' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'First phase',
							'description' => '',
						],
					],
					'second_phase' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Second phase',
							'description' => '',
						],
					],
					'third_phase' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Third phase',
							'description' => '',
						],
					],
					'fourth_phase' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Fourth phase',
							'description' => '',
						],
					],
					'total' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total',
							'description' => '',
						],
					],
					'final_budget_to_be_allocated' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Final budget to be allocated Rs.',
							'description' => '',
						],
					],
					'proposal_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Proposal link',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'first_level_shortlisted_proposals_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'institution' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institution',
							'description' => '',
						],
					],
					'domain_of_interest' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Domain of interest',
							'description' => '',
						],
					],
					'proposal_link' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Proposal link',
							'description' => '',
						],
					],
					'first_level_comment' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'First level comment',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'budget_table_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'title_of_the_project' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Title of the project',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'date_of_presentation' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date of presentation',
							'description' => '',
						],
					],
					'manpower' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Manpower',
							'description' => '',
						],
					],
					'travel' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Travel',
							'description' => '',
						],
					],
					'infrastructure' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Infrastructure / Equipment',
							'description' => '',
						],
					],
					'consumables' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Consumables',
							'description' => '',
						],
					],
					'contigency' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Contigency',
							'description' => '',
						],
					],
					'overhead' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Overhead',
							'description' => '',
						],
					],
					'any_other' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Any other',
							'description' => '',
						],
					],
					'total_budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total budget in Rs.',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'panel_comments_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'final_budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Final budget in Rs.',
							'description' => '',
						],
					],
					'comments_from_yvn_sir' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Comments from YVN sir',
							'description' => '',
						],
					],
					'comments_from_ramakrishna_sir' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Comments from Ramakrishna sir',
							'description' => '',
						],
					],
					'comments_from_bharat_lohani_sir' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Comments from Bharat Lohani sir',
							'description' => '',
						],
					],
					'remarks_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Remarks 1',
							'description' => '',
						],
					],
					'remarks_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Remarks 2',
							'description' => '',
						],
					],
					'finale_decision' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Finale decision',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'selected_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'name_of_pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of PI',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Budget in Rs.',
							'description' => '',
						],
					],
					'decision' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Decision',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'address_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_id' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project ID::Title',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'short_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Short name',
							'description' => '',
						],
					],
					'pincode' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Pincode',
							'description' => '',
						],
					],
					'lattitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Lattitude',
							'description' => '',
						],
					],
					'longitude' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Longitude',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'summary_table_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_number' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Project number',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'pi' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'PI',
							'description' => '',
						],
					],
					'institute' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Institute',
							'description' => '',
						],
					],
					'duration_in_months' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Duration in months',
							'description' => '',
						],
					],
					'overall_budget' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Overall budget in Rs.',
							'description' => '',
						],
					],
					'number_of_products' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Number of products',
							'description' => '',
						],
					],
					'trl_status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'TRL status',
							'description' => '',
						],
					],
					'sactioned_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Sactioned date',
							'description' => '',
						],
					],
					'ongoing_month_of_project' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Ongoing month of project',
							'description' => '',
						],
					],
					'last_monthly_report' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last monthly report',
							'description' => '',
						],
					],
					'no_of_ug' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of UG',
							'description' => '',
						],
					],
					'no_of_pg' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of PG',
							'description' => '',
						],
					],
					'no_of_phd' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of PhD',
							'description' => '',
						],
					],
					'no_of_postdoc' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'No. of Post Doc',
							'description' => '',
						],
					],
					'first_milestone_amount_and_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => '1st Milestone Amount & Date',
							'description' => '',
						],
					],
					'stage_I_completion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Stage 1 completion',
							'description' => '',
						],
					],
					'second_milestone_amount_and_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => '2nd Milestone Amount & Date',
							'description' => '',
						],
					],
					'stage_2_completion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Stage 2 completion',
							'description' => '',
						],
					],
					'third_milestone_amount_and_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => '3rd Milestone Amount & Date',
							'description' => '',
						],
					],
					'stage_3_completion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Stage 3 completion',
							'description' => '',
						],
					],
					'fourth_milestone_amount_and_date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => '4th Milestone Amount & Date',
							'description' => '',
						],
					],
					'stage_4_completion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Stage 4 completion',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'project_details_tdp' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'project_number' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'Project number',
							'description' => '',
						],
					],
					'stage_1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 1st (12 Months)',
							'description' => '',
						],
					],
					'stage_2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 2nd (12 Months)',
							'description' => '',
						],
					],
					'stage_3' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 3rd (12 Months)',
							'description' => '',
						],
					],
					'stage_4' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Stage 4th (12 Months)',
							'description' => '',
						],
					],
					'total' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total in Rs.',
							'description' => '',
						],
					],
					'details' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Details',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created by',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created at',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated by',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated at',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
				],
				'newsletter_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'section' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Translational R & D'",
						'info' => [
							'caption' => 'Section',
							'description' => '',
						],
					],
					'name_of_event' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name/Title of Events',
							'description' => '',
						],
					],
					'dates_of_events' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Dates of Events',
							'description' => '',
						],
					],
					'writeup_about_event' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Writeup About The Events (Max 200 Words)',
							'description' => '',
						],
					],
					'img1' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'First Image',
							'description' => 'Maximum file size allowed: 1000000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'img2' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Second Image',
							'description' => 'Maximum file size allowed: 1000000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'contact_call_log_table' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'number' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Contact Number',
							'description' => '',
						],
					],
					'query' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Query',
							'description' => '',
						],
					],
					'reply' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Reply for query',
							'description' => '',
						],
					],
					'remarks_ceo' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'CEO Remarks',
							'description' => '',
						],
					],
					'remarks_pd' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'PD Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'r_and_d_monthly_progress_app' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'r_and_d_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'R and D Progress Details',
							'description' => '',
						],
					],
					'month_year' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'January-2025'",
						'info' => [
							'caption' => 'Month-Year',
							'description' => '',
						],
					],
					'Progress_Achieved' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Progress Achieved',
							'description' => '',
						],
					],
					'Plan_for_Next_Month' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Plan for Next Month',
							'description' => '',
						],
					],
					'problem_suggestion' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Problems/Suggestion (If Any)',
							'description' => '',
						],
					],
					'ceo_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Ceo remarks',
							'description' => '',
						],
					],
					'pd_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'PD\'s Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'r_and_d_quarterly_progress_app' => [
					'id' => [
						'appgini' => "INT(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'r_and_d_lookup' => [
						'appgini' => "INT(10) UNSIGNED NULL",
						'info' => [
							'caption' => 'R and D Progress Details',
							'description' => '',
						],
					],
					'date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Date',
							'description' => '',
						],
					],
					'attendees' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Attendees',
							'description' => '',
						],
					],
					'minutes' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Minutes',
							'description' => '',
						],
					],
					'Tech_Mgr_Remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Tech-Mgr Remarks',
							'description' => '',
						],
					],
					'ceo_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Ceo remarks',
							'description' => '',
						],
					],
					'pd_remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'PD\'s Remarks',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
				],
				'projects' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'PRAYAS'",
						'info' => [
							'caption' => 'Category',
							'description' => '',
						],
					],
					'collaboration_partner_type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Institute'",
						'info' => [
							'caption' => 'Collaboration Partner Type',
							'description' => '',
						],
					],
					'collaboration_partner_name' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Collaboration Partner Name',
							'description' => '',
						],
					],
					'project_title' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Project title',
							'description' => '',
						],
					],
					'trl_level' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'TRL 1'",
						'info' => [
							'caption' => 'TRL Level',
							'description' => '',
						],
					],
					'project_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Ongoing'",
						'info' => [
							'caption' => 'Project Status',
							'description' => '',
						],
					],
					'project_commercialized' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'No'",
						'info' => [
							'caption' => 'Project Commercialized',
							'description' => '',
						],
					],
					'brief_of_the_project' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Brief of the Project',
							'description' => '',
						],
					],
					'commercialization_areas' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Commercialization Areas',
							'description' => '',
						],
					],
					'targeted_sdg' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Targeted SDG',
							'description' => '',
						],
					],
					'total_approved_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Approved Amount (In INR)',
							'description' => '',
						],
					],
					'funding_released_2020' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2020-21 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2021' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2021-22 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2022' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2022-23 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2023' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2023-24 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2024' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2024-25 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2025' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2025-26 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2026' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2026-27 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2027' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2027-28(In Lakhs)',
							'description' => '',
						],
					],
					'total_value_released' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Value Released (In Lakhs)',
							'description' => '',
						],
					],
					'external_funding_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'External Funding Amount (In Lakhs)',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_projects_td_intellectual_property' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'ip_category' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Patent'",
						'info' => [
							'caption' => 'IP Category',
							'description' => '',
						],
					],
					'ip_title' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'IP Title',
							'description' => '',
						],
					],
					'technology_area' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'year_field' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Year Field',
							'description' => '',
						],
					],
					'year_granted' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Year Granted',
							'description' => '',
						],
					],
					'patent_id' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Patent ID',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'National'",
						'info' => [
							'caption' => 'Type',
							'description' => '',
						],
					],
					'source_of_ip_category' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'EIR'",
						'info' => [
							'caption' => 'Source of IP Category',
							'description' => '',
						],
					],
					'source_of_ip' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Source of IP',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_projects_td_technology_products' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'tech_product_title' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Tech Product Title',
							'description' => '',
						],
					],
					'tech_produc_type' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Tech Product Type',
							'description' => '',
						],
					],
					'technology_area' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'project_value' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'Project Value (Rs.) In Lakhs',
							'description' => '',
						],
					],
					'status_of_license_transfer' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Status of License Transfer',
							'description' => '',
						],
					],
					'value_of_transfer' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'Value of the Transfer in Lakhs (Rs.)',
							'description' => '',
						],
					],
					'trl_level' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'TRL 1'",
						'info' => [
							'caption' => 'TRL Level',
							'description' => '',
						],
					],
					'commercialised' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Commercialised',
							'description' => '',
						],
					],
					'source_of_ip_category' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'EIR'",
						'info' => [
							'caption' => 'Source of IP Category',
							'description' => '',
						],
					],
					'source_of_ip' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Source of IP',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_publications_and_intellectual_activities' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_publications' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'publications_and_intellectual_activities_details' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Publications and Intellectual Activities Details',
							'description' => '',
						],
					],
					'publication_type' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Publication Type',
							'description' => '',
						],
					],
					'title' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Title',
							'description' => '',
						],
					],
					'technology_area' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'publication_year' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'Publication Year',
							'description' => '',
						],
					],
					'author_names' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Author Names',
							'description' => '',
						],
					],
					'peer_reviewed' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Peer Reviewed',
							'description' => '',
						],
					],
					'link' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Link',
							'description' => '',
						],
					],
					'source_of_ip_category' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'EIR'",
						'info' => [
							'caption' => 'Source of IP Category',
							'description' => '',
						],
					],
					'source_of_ip' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Source of IP',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_ipr' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'publications_and_intellectual_activities_details' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Publications and Intellectual Activities Details',
							'description' => '',
						],
					],
					'title' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Title',
							'description' => '',
						],
					],
					'ipr_ia' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'IPR / Intellectual Activity',
							'description' => '',
						],
					],
					'event_type' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Event type',
							'description' => '',
						],
					],
					'technology_domain' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Domain',
							'description' => '',
						],
					],
					'collaborating_organization' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Collaborating Organization',
							'description' => '',
						],
					],
					'event_venue_address' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Event venue address',
							'description' => '',
						],
					],
					'state' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'State',
							'description' => '',
						],
					],
					'district' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'District',
							'description' => '',
						],
					],
					'start_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'Start date',
							'description' => '',
						],
					],
					'end_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'End date',
							'description' => '',
						],
					],
					'total_number_of_participants' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'Total Number of Participants',
							'description' => '',
						],
					],
					'women_participants' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'Women participants',
							'description' => '',
						],
					],
					'st_participants' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'ST Participants',
							'description' => '',
						],
					],
					'sc_participants' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'SC Participants',
							'description' => '',
						],
					],
					'outcomes' => [
						'appgini' => "TEXT NOT NULL",
						'info' => [
							'caption' => 'Outcomes',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'td_cps_research_base' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'reasearch_name' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Reasearch Name',
							'description' => '',
						],
					],
					'Institution' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Institution',
							'description' => '',
						],
					],
					'department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'technology_area' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'cast_category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'SC'",
						'info' => [
							'caption' => 'Cast Category',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
				],
				'ed_tbi' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'tbi_name' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'TBI Name',
							'description' => '',
						],
					],
					'type' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Type',
							'description' => '',
						],
					],
					'institution' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Institution',
							'description' => '',
						],
					],
					'tbi_facilities' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'TBI Facilities',
							'description' => '',
						],
					],
					'collaboration_date' => [
						'appgini' => "DATE NOT NULL",
						'info' => [
							'caption' => 'Collaboration/TBI Start Date',
							'description' => '',
						],
					],
					'tih_payment' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'TIH Payment for Facilities',
							'description' => '',
						],
					],
					'charging_status' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Is TIH Charging Startups ?',
							'description' => '',
						],
					],
					'charges' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Facility Charged by TIH',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'ed_startup_companies' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'startup_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Startup Name',
							'description' => '',
						],
					],
					'founder_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Founder Name',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'cast_category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'SC'",
						'info' => [
							'caption' => 'Cast Category',
							'description' => '',
						],
					],
					'technology_area' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'deep_tech' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Deep tech',
							'description' => '',
						],
					],
					'product_brief' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Product brief',
							'description' => '',
						],
					],
					'trl_status' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'TRL 1'",
						'info' => [
							'caption' => 'TRL Status',
							'description' => '',
						],
					],
					'product_status' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'Ongoing'",
						'info' => [
							'caption' => 'Product Development Status',
							'description' => '',
						],
					],
					'CommercialisationArea' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Commercialisation Area',
							'description' => '',
						],
					],
					'Is_Commercialized' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Is Commercialized',
							'description' => '',
						],
					],
					'Customer_Details' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Customer Details',
							'description' => '',
						],
					],
					'Total_Approved_Amount' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Total Approved Amount',
							'description' => '',
						],
					],
					'funding_released_2020' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2020-21 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2021' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2021-22 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2022' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2022-23 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2023' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2023-24 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2024' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2024-25 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2025' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2025-26 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2026' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2026-27 (In Lakhs)',
							'description' => '',
						],
					],
					'funding_released_2027' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Released 2027-28(In Lakhs)',
							'description' => '',
						],
					],
					'total_value_released' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Released Amount (In Lakhs)',
							'description' => '',
						],
					],
					'external_funding_amount' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'External Funding Amount (In Lakhs)',
							'description' => '',
						],
					],
					'Funding_Type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding Type',
							'description' => '',
						],
					],
					'Equity_Percentage' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Equity Percentage',
							'description' => '',
						],
					],
					'valuation' => [
						'appgini' => "INT NOT NULL",
						'info' => [
							'caption' => 'Valuation',
							'description' => '',
						],
					],
					'Collaboration_Partner_Type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Collaboration Partner Type',
							'description' => '',
						],
					],
					'Website' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Website',
							'description' => '',
						],
					],
					'CIN_LLP' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'CIN / LLP',
							'description' => '',
						],
					],
					'state' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'State',
							'description' => '',
						],
					],
					'district' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'District',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'Registered_Address' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Registered Address',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'ed_gcc' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NOT NULL",
						'info' => [
							'caption' => 'Name of Competition',
							'description' => '',
						],
					],
					'finalists' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Number of Finalists',
							'description' => '',
						],
					],
					'Number_of_Enrolled_Participants' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Number of Enrolled Participants',
							'description' => '',
						],
					],
					'Technology_Domain' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Technology Domain',
							'description' => '',
						],
					],
					'Start_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start Date',
							'description' => '',
						],
					],
					'End_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End Date',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'Co_Sponsors' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Co-Sponsors',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'ed_eir' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Candidate Name',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Select the Candidate\'s Gender',
							'description' => '',
						],
					],
					'cast_category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'SC'",
						'info' => [
							'caption' => 'Cast Category',
							'description' => '',
						],
					],
					'Technology_Area' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Technology Area',
							'description' => '',
						],
					],
					'Start_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start Date',
							'description' => '',
						],
					],
					'End_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End Date',
							'description' => '',
						],
					],
					'Co_funding_Agency_Type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Co-funding Agency Type',
							'description' => '',
						],
					],
					'Co_funding_Agency_Name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Co-funding Agency Name',
							'description' => '',
						],
					],
					'trl_level' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'TRL 1'",
						'info' => [
							'caption' => 'TRL Level',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'ed_job_creation' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'Name_of_the_Employee' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name of the Employee',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Select the Candidate\'s Gender',
							'description' => '',
						],
					],
					'cast_category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'SC'",
						'info' => [
							'caption' => 'Cast Category',
							'description' => '',
						],
					],
					'Type_of_Employment' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Type of Employment',
							'description' => '',
						],
					],
					'Joining_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Joining Date',
							'description' => '',
						],
					],
					'Designation' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Designation',
							'description' => '',
						],
					],
					'Organisation_Name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Organisation Name',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'hrd_Fellowship' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Name',
							'description' => '',
						],
					],
					'gender' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT 'Male'",
						'info' => [
							'caption' => 'Gender',
							'description' => '',
						],
					],
					'id_no' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Candidate\'s Institute ID Card No.',
							'description' => '',
						],
					],
					'institute_name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Candidate\'s Institute Name',
							'description' => '',
						],
					],
					'Department' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Department',
							'description' => '',
						],
					],
					'Qualification' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Qualification',
							'description' => '',
						],
					],
					'Fellowship_Type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Fellowship Type',
							'description' => '',
						],
					],
					'cast_category' => [
						'appgini' => "VARCHAR(255) NULL DEFAULT 'SC'",
						'info' => [
							'caption' => 'Category',
							'description' => '',
						],
					],
					'Start_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start Date',
							'description' => '',
						],
					],
					'End_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End Date',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'founded_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Founded By',
							'description' => '',
						],
					],
					'Amount_Granted' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Amount Granted',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'hrd_sd' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'Candidate_Type' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Candidate Type',
							'description' => '',
						],
					],
					'Title_of_the_Program' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Title of the Program',
							'description' => '',
						],
					],
					'Total_Number_of_Beneficiaries' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Total Number of Beneficiaries',
							'description' => '',
						],
					],
					'Number_of_Women_Beneficiaries' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Number of Women Beneficiaries',
							'description' => '',
						],
					],
					'Total_Number_of_SC_Beneficiaries' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Number of SC Beneficiaries',
							'description' => '',
						],
					],
					'Total_Number_of_ST_Beneficiaries' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Total Number of ST Beneficiaries',
							'description' => '',
						],
					],
					'category' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Category',
							'description' => '',
						],
					],
					'Start_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start Date',
							'description' => '',
						],
					],
					'End_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End Date',
							'description' => '',
						],
					],
					'Collaborating_Organisation' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Collaborating Organisation',
							'description' => '',
						],
					],
					'Outcomes' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Outcomes of the skill development activity',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
				'it_International_Collaboration' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'year' => [
						'appgini' => "VARCHAR(255) NOT NULL DEFAULT '2020-21'",
						'info' => [
							'caption' => 'Year',
							'description' => '',
						],
					],
					'Collaborating_Institute_Name' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Collaborating Institute Name',
							'description' => '',
						],
					],
					'Country' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Country',
							'description' => '',
						],
					],
					'title_of_the_Program' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Title of the Program/Project',
							'description' => '',
						],
					],
					'Technology_Area_of_Collaboration' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Technology Area of Collaboration',
							'description' => '',
						],
					],
					'Potential_Area_for_Application' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Potential Area for Application',
							'description' => '',
						],
					],
					'Brief_Description_of_Collaboration' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Brief Description of Collaboration/Project',
							'description' => '',
						],
					],
					'RoleofTIH' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Role of TIH/PI to Achieve the Objectives of the Collaboration/Project',
							'description' => '',
						],
					],
					'RoleofCollaborator' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Role of Collaborator/PI to Achieve the Objectives of the Collaboration/Project',
							'description' => '',
						],
					],
					'Funding_From_TIH' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Funding From TIH(In Lakhs)',
							'description' => '',
						],
					],
					'Funding_from_International_Agency' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Funding from International Agency(In Lakhs)',
							'description' => '',
						],
					],
					'Project_Value' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Project Value',
							'description' => '',
						],
					],
					'MoU_Signed_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'MoU Signed Date',
							'description' => '',
						],
					],
					'Start_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Start Date',
							'description' => '',
						],
					],
					'End_Date' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'End Date',
							'description' => '',
						],
					],
					'status' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Status',
							'description' => '',
						],
					],
					'remarks' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Remarks',
							'description' => '',
						],
					],
					'created_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By Username',
							'description' => '',
						],
					],
					'created_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created At',
							'description' => '',
						],
					],
					'last_updated_by_username' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated by Username',
							'description' => '',
						],
					],
					'last_updated_at' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated At',
							'description' => '',
						],
					],
					'last_updated_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Last Updated By',
							'description' => '',
						],
					],
					'created_by' => [
						'appgini' => "VARCHAR(255) NULL",
						'info' => [
							'caption' => 'Created By',
							'description' => '',
						],
					],
				],
			];

			$internalTablesSimple = [
				'appgini_csv_import_jobs' => [
					'id' => "VARCHAR(40) NOT NULL PRIMARY KEY",
					'memberID' => "VARCHAR(100) NOT NULL",
					'config' => "TEXT",
					'insert_ts' => "INT",
					'last_update_ts' => "INT",
					'total' => "INT DEFAULT '99999999'",
					'done' => "INT DEFAULT '0'",
				],
				'appgini_query_log' => [
					'datetime' => "TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
					'statement' => "LONGTEXT",
					'duration' => "DECIMAL(10,2) UNSIGNED DEFAULT '0.00'",
					'error' => "TEXT",
					'memberID' => "VARCHAR(200)",
					'uri' => "VARCHAR(200)",
				],
				'membership_cache' => [
					'request' => "VARCHAR(100) NOT NULL PRIMARY KEY",
					'request_ts' => "INT",
					'response' => "LONGTEXT",
				],
				'membership_grouppermissions' => [
					'permissionID' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
					'groupID' => "INT UNSIGNED",
					'tableName' => "VARCHAR(100)",
					'allowInsert' => "TINYINT NOT NULL DEFAULT '0'",
					'allowView' => "TINYINT NOT NULL DEFAULT '0'",
					'allowEdit' => "TINYINT NOT NULL DEFAULT '0'",
					'allowDelete' => "TINYINT NOT NULL DEFAULT '0'",
				],
				'membership_groups' => [
					'groupID' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
					'name' => "VARCHAR(100) NOT NULL UNIQUE",
					'description' => "TEXT",
					'allowSignup' => "TINYINT",
					'needsApproval' => "TINYINT",
					'allowCSVImport' => "TINYINT NOT NULL DEFAULT '0'",
				],
				'membership_userpermissions' => [
					'permissionID' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
					'memberID' => "VARCHAR(100) NOT NULL",
					'tableName' => "VARCHAR(100)",
					'allowInsert' => "TINYINT NOT NULL DEFAULT '0'",
					'allowView' => "TINYINT NOT NULL DEFAULT '0'",
					'allowEdit' => "TINYINT NOT NULL DEFAULT '0'",
					'allowDelete' => "TINYINT NOT NULL DEFAULT '0'",
				],
				'membership_userrecords' => [
					'recID' => "BIGINT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
					'tableName' => "VARCHAR(100)",
					'pkValue' => "VARCHAR(255)",
					'memberID' => "VARCHAR(100)",
					'dateAdded' => "BIGINT UNSIGNED",
					'dateUpdated' => "BIGINT UNSIGNED",
					'groupID' => "INT UNSIGNED",
				],
				'membership_users' => [
					'memberID' => "VARCHAR(100) NOT NULL PRIMARY KEY",
					'passMD5' => "VARCHAR(255)",
					'email' => "VARCHAR(100)",
					'signupDate' => "DATE",
					'groupID' => "INT UNSIGNED",
					'isBanned' => "TINYINT",
					'isApproved' => "TINYINT",
					'custom1' => "TEXT",
					'custom2' => "TEXT",
					'custom3' => "TEXT",
					'custom4' => "TEXT",
					'comments' => "TEXT",
					'pass_reset_key' => "VARCHAR(100)",
					'pass_reset_expiry' => "INT UNSIGNED",
					'flags' => "TEXT",
					'allowCSVImport' => "TINYINT NOT NULL DEFAULT '0'",
					'data' => "LONGTEXT",
				]
			];

			$internalTables = [];
			// add 'appgini' and 'info' keys to internal tables fields
			foreach($internalTablesSimple as $tableName => $fields) {
				$internalTables[$tableName] = [];
				foreach($fields as $fn => $fd) {
					$internalTables[$tableName][$fn] = ['appgini' => $fd, 'info' => ['caption' => $fn, 'description' => '']];
				}
			}
		}

		if($tn === null && !$include_internal_tables) return $schema;

		if($tn === null) return array_merge($schema, $internalTables);

		return $schema[$tn] ?? $internalTables[$tn] ?? [];
	}
	########################################################################
	function updateField($tn, $fn, $dataType, $notNull = false, $default = null, $extra = null) {
		$sqlNull = $notNull ? 'NOT NULL' : 'NULL';
		$sqlDefault = $default === null ? '' : "DEFAULT '" . makeSafe($default) . "'";
		$sqlExtra = $extra === null ? '' : $extra;

		// get current field definition
		$col = false;
		$eo = ['silentErrors' => true];
		$res = sql("SHOW COLUMNS FROM `{$tn}` LIKE '{$fn}'", $eo);
		if($res) $col = db_fetch_assoc($res);

		// if field does not exist, create it
		if(!$col) {
			sql("ALTER TABLE `{$tn}` ADD COLUMN `{$fn}` {$dataType} {$sqlNull} {$sqlDefault} {$sqlExtra}", $eo);
			return;
		}

		// if field exists, alter it if needed
		if(
			strtolower($col['Type']) != strtolower($dataType) ||
			(strtolower($col['Null']) == 'yes' && $notNull) ||
			(strtolower($col['Null']) == 'no' && !$notNull) ||
			(strtolower($col['Default']) != strtolower($default)) ||
			(strtolower($col['Extra']) != strtolower($extra))
		) {
			sql("ALTER TABLE `{$tn}` CHANGE COLUMN `{$fn}` `{$fn}` {$dataType} {$sqlNull} {$sqlDefault} {$sqlExtra}", $eo);
		}
	}

	########################################################################
	function addIndex($tn, $fields, $unique = false) {
		// if $fields is a string, convert it to an array
		if(!is_array($fields)) $fields = [$fields];

		// reshape fields so that key is field name and value is index length or null for full length
		$fields2 = [];
		foreach($fields as $k => $v) {
			if(is_numeric($k)) {
				$fields2[$v] = null; // $v is field name and index length is full length
				continue;
			}

			$fields2[$k] = $v; // $k is field name and $v is index length
		}
		unset($fields); $fields = $fields2;

		// prepare index name and sql
		$index_name = implode('_', array_keys($fields));
		$sql = "ALTER TABLE `{$tn}` ADD " . ($unique ? 'UNIQUE ' : '') . "INDEX `{$index_name}` (";
		foreach($fields as $field => $length)
			$sql .= "`$field`" . ($length === null ? '' : "($length)") . ',';
		$sql = rtrim($sql, ',') . ')';

		// get current indexes
		$eo = ['silentErrors' => true];
		$res = sql("SHOW INDEXES FROM `{$tn}`", $eo);
		$indexes = [];
		while($row = db_fetch_assoc($res))
			$indexes[$row['Key_name']][$row['Seq_in_index']] = $row;

		// if index does not exist, create it
		if(!isset($indexes[$index_name])) {
			sql($sql, $eo);
			return;
		}

		// if index exists, alter it if needed
		$index = $indexes[$index_name];
		$index_changed = false;
		$index_fields = [];
		foreach($index as $seq_in_index => $info)
			$index_fields[$seq_in_index] = $info['Column_name'];

		if(count($index_fields) != count($fields)) $index_changed = true;
		foreach($fields as $field => $length) {
			// check if field exists in index
			$seq_in_index = array_search($field, $index_fields);
			if($seq_in_index === false) {
				$index_changed = true;
				break;
			}

			// check if field length is different
			if($length !== null && $length != $index[$seq_in_index]['Sub_part']) {
				$index_changed = true;
				break;
			}

			// check index uniqueness
			if(($unique && $index[$seq_in_index]['Non_unique'] == 1) || (!$unique && $index[$seq_in_index]['Non_unique'] == 0)) {
				$index_changed = true;
				break;
			}
		}
		if(!$index_changed) return;

		sql("ALTER TABLE `{$tn}` DROP INDEX `{$index_name}`", $eo);
		sql($sql, $eo);
	}

	########################################################################
	function createTableIfNotExists($tn, $return_schema_without_executing = false) {
		$schema = get_table_fields($tn);
		if(!$schema) return false;

		$create_sql = "CREATE TABLE IF NOT EXISTS `{$tn}` (";
		foreach($schema as $fn => $fd) {
			$create_sql .= "\n  `{$fn}` {$fd['appgini']}, ";
		}
		$create_sql = rtrim($create_sql, ', ') . "\n) CHARSET " . mysql_charset;
		$create_sql = trim($create_sql);

		if($return_schema_without_executing) return $create_sql;

		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];
		sql($create_sql, $eo);
	}

	########################################################################
	function update_membership_groups() {
		$tn = 'membership_groups';
		createTableIfNotExists($tn);

		updateField($tn, 'name', 'VARCHAR(100)', true);
		addIndex($tn, 'name', true);
		updateField($tn, 'allowCSVImport', 'TINYINT', true, '0');
	}
	########################################################################
	function update_membership_users() {
		$tn = 'membership_users';
		createTableIfNotExists($tn);

		updateField($tn, 'pass_reset_key', 'VARCHAR(100)');
		updateField($tn, 'pass_reset_expiry', 'INT UNSIGNED');
		updateField($tn, 'passMD5', 'VARCHAR(255)');
		updateField($tn, 'memberID', 'VARCHAR(100)', true);
		addIndex($tn, 'groupID');
		updateField($tn, 'flags', 'TEXT');
		updateField($tn, 'allowCSVImport', 'TINYINT', true, '0');
		updateField($tn, 'data', 'LONGTEXT');
	}
	########################################################################
	function update_membership_userrecords() {
		$tn = 'membership_userrecords';
		createTableIfNotExists($tn);

		addIndex($tn, ['tableName' => null, 'pkValue' => 100], true);
		addIndex($tn, 'pkValue');
		addIndex($tn, 'tableName');
		addIndex($tn, 'memberID');
		addIndex($tn, 'groupID');
		updateField($tn, 'memberID', 'VARCHAR(100)');
	}
	########################################################################
	function update_membership_grouppermissions() {
		$tn = 'membership_grouppermissions';
		createTableIfNotExists($tn);

		addIndex($tn, ['groupID', 'tableName'], true);
	}
	########################################################################
	function update_membership_userpermissions() {
		$tn = 'membership_userpermissions';
		createTableIfNotExists($tn);

		updateField($tn, 'memberID', 'VARCHAR(100)', true);
		addIndex($tn, ['memberID', 'tableName'], true);
	}
	########################################################################
	function update_membership_usersessions() {
		$tn = 'membership_usersessions';

		// not using createTableIfNotExists() here because we need to add a composite unique index,
		// which is not supported by that function yet
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `$tn` (
				`memberID` VARCHAR(100) NOT NULL,
				`token` VARCHAR(100) NOT NULL,
				`agent` VARCHAR(100) NOT NULL,
				`expiry_ts` INT(10) UNSIGNED NOT NULL,
				UNIQUE INDEX `memberID_token_agent` (`memberID`, `token`(50), `agent`(50)),
				INDEX `memberID` (`memberID`),
				INDEX `expiry_ts` (`expiry_ts`)
			) CHARSET " . mysql_charset,
		$eo);
	}
	########################################################################
	function update_membership_cache() {
		$tn = 'membership_cache';
		createTableIfNotExists($tn);

		updateField($tn, 'response', 'LONGTEXT');
	}
	########################################################################
	function thisOr($this_val, $or = '&nbsp;') {
		return ($this_val != '' ? $this_val : $or);
	}
	########################################################################
	function getUploadedFile($FieldName, $MaxSize = 0, $FileTypes = 'csv|txt', $NoRename = false, $dir = '') {
		if(empty($_FILES) || empty($_FILES[$FieldName]))
			return 'Your php settings don\'t allow file uploads.';

		$f = $_FILES[$FieldName];

		if(!$MaxSize)
			$MaxSize = toBytes(ini_get('upload_max_filesize'));

		@mkdir(__DIR__ . '/csv');

		$dir = (is_dir($dir) && is_writable($dir) ? $dir : __DIR__ . '/csv/');

		if($f['error'] != 4 && $f['name'] != '') {
			if($f['size'] > $MaxSize || $f['error']) {
				return 'File size exceeds maximum allowed of '.intval($MaxSize / 1024).'KB';
			}

			if(!preg_match('/\.('.$FileTypes.')$/i', $f['name'], $ft)) {
				return 'File type not allowed. Only these file types are allowed: '.str_replace('|', ', ', $FileTypes);
			}

			if($NoRename) {
				$n  = str_replace(' ', '_', $f['name']);
			} else {
				$n  = microtime();
				$n  = str_replace(' ', '_', $n);
				$n  = str_replace('0.', '', $n);
				$n .= $ft[0];
			}

			if(!@move_uploaded_file($f['tmp_name'], $dir . $n)) {
				return 'Couldn\'t save the uploaded file. Try chmoding the upload folder "'.$dir.'" to 777.';
			} else {
				@chmod($dir.$n, 0666);
				return $dir.$n;
			}
		}
		return 'An error occurred while uploading the file. Please try again.';
	}
	########################################################################
	function toBytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val) - 1]);

		$val = intval($val);
		switch($last) {
			 case 'g':
					$val *= 1024;
			 case 'm':
					$val *= 1024;
			 case 'k':
					$val *= 1024;
		}

		return $val;
	}
	########################################################################
	function convertLegacyOptions($CSVList) {
		$CSVList=str_replace(';;;', ';||', $CSVList);
		$CSVList=str_replace(';;', '||', $CSVList);
		return trim($CSVList, '|');
	}
	########################################################################
	function getValueGivenCaption($query, $caption) {
		if(!preg_match('/select\s+(.*?)\s*,\s*(.*?)\s+from\s+(.*?)\s+order by.*/i', $query, $m)) {
			if(!preg_match('/select\s+(.*?)\s*,\s*(.*?)\s+from\s+(.*)/i', $query, $m)) {
				return '';
			}
		}

		// get where clause if present
		if(preg_match('/\s+from\s+(.*?)\s+where\s+(.*?)\s+order by.*/i', $query, $mw)) {
			$where = "where ({$mw[2]}) AND";
			$m[3] = $mw[1];
		} else {
			$where = 'where';
		}

		$caption = makeSafe($caption);
		return sqlValue("SELECT {$m[1]} FROM {$m[3]} {$where} {$m[2]}='{$caption}'");
	}
	########################################################################
	function time24($t = false) {
		if($t === false) $t = date('Y-m-d H:i:s'); // time now if $t not passed
		elseif(!$t) return ''; // empty string if $t empty
		return date('H:i:s', strtotime($t));
	}
	########################################################################
	function time12($t = false) {
		if($t === false) $t = date('Y-m-d H:i:s'); // time now if $t not passed
		elseif(!$t) return ''; // empty string if $t empty
		return date('h:i:s A', strtotime($t));
	}
	########################################################################
	function normalize_path($path) {
		// Adapted from https://developer.wordpress.org/reference/functions/wp_normalize_path/

		// Standardise all paths to use /
		$path = str_replace('\\', '/', $path);

		// Replace multiple slashes down to a singular, allowing for network shares having two slashes.
		$path = preg_replace('|(?<=.)/+|', '/', $path);

		// Windows paths should uppercase the drive letter
		if(':' === substr($path, 1, 1)) {
			$path = ucfirst($path);
		}

		return $path;
	}
	########################################################################
	function application_url($page = '', $s = false) {
		if($s === false) $s = $_SERVER;

		$ssl = (
			(!empty($s['HTTPS']) && strtolower($s['HTTPS']) != 'off')
			// detect reverse proxy SSL
			|| (!empty($s['HTTP_X_FORWARDED_PROTO']) && strtolower($s['HTTP_X_FORWARDED_PROTO']) == 'https')
			|| (!empty($s['HTTP_X_FORWARDED_SSL']) && strtolower($s['HTTP_X_FORWARDED_SSL']) == 'on')
		);
		$http = ($ssl ? 'https:' : 'http:');

		$port = $s['SERVER_PORT'];
		$port = ($port == '80' || $port == '443' || !$port) ? '' : ':' . $port;
		// HTTP_HOST already includes server port if not standard, but SERVER_NAME doesn't
		$host = (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'] . $port);

		$uri = config('appURI');
		if(!$uri) $uri = '/';

		// uri must begin and end with /, but not be '//'
		if($uri != '/' && $uri[0] != '/') $uri = "/{$uri}";
		if($uri != '/' && $uri[strlen($uri) - 1] != '/') $uri = "{$uri}/";

		return "{$http}//{$host}{$uri}{$page}";
	}
	########################################################################
	function application_uri($page = '') {
		$url = application_url($page);
		return trim(parse_url($url, PHP_URL_PATH), '/');
	}
	########################################################################
	function is_ajax() {
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}
	########################################################################
	function is_allowed_username($username, $exception = false) {
		$username = trim(strtolower($username));
		if(!preg_match('/^[a-z0-9][a-z0-9 _.@]{3,100}$/', $username) || preg_match('/(@@|  |\.\.|___)/', $username)) return false;

		if($username == $exception) return $username;

		if(sqlValue("select count(1) from membership_users where lcase(memberID)='{$username}'")) return false;
		return $username;
	}
	########################################################################
	/*
		if called without parameters, looks for a non-expired token in the user's session (or creates one if
		none found) and returns html code to insert into the form to be protected.

		if set to true, validates token sent in $_REQUEST against that stored in the session
		and returns true if valid or false if invalid, absent or expired.

		usage:
			1. in a new form that needs csrf proofing: echo csrf_token();
			   >> in case of ajax requests and similar, retrieve token directly
			      by calling csrf_token(false, true);
			2. when validating a submitted form: if(!csrf_token(true)) { reject_submission_somehow(); }
	*/
	function csrf_token($validate = false, $token_only = false) {
		// a long token age is better for UX with SPA and browser back/forward buttons
		// and it would expire when the session ends anyway
		$token_age = 86400 * 2;

		/* retrieve token from session */
		$csrf_token = (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : false);
		$csrf_token_expiry = (isset($_SESSION['csrf_token_expiry']) ? $_SESSION['csrf_token_expiry'] : false);

		if(!$validate) {
			/* create a new token if necessary */
			if($csrf_token_expiry < time() || !$csrf_token) {
				$csrf_token = bin2hex(random_bytes(16));
				$csrf_token_expiry = time() + $token_age;
				$_SESSION['csrf_token'] = $csrf_token;
				$_SESSION['csrf_token_expiry'] = $csrf_token_expiry;
			}

			if($token_only) return $csrf_token;
			return '<input type="hidden" id="csrf_token" name="csrf_token" value="' . $csrf_token . '">';
		}

		/* validate submitted token */
		$user_token = Request::val('csrf_token', false);
		if($csrf_token_expiry < time() || !$user_token || $user_token != $csrf_token) {
			return false;
		}

		return true;
	}
	########################################################################
	function get_plugins() {
		$plugins = [];
		$plugins_path = __DIR__ . '/../plugins/';

		if(!is_dir($plugins_path)) return $plugins;

		$pd = dir($plugins_path);
		while(false !== ($plugin = $pd->read())) {
			if(!is_dir($plugins_path . $plugin) || in_array($plugin, ['projects', 'plugins-resources', '.', '..'])) continue;

			$info_file = "{$plugins_path}{$plugin}/plugin-info.json";
			if(!is_file($info_file)) continue;

			$plugins[] = json_decode(file_get_contents($info_file), true);
			$plugins[count($plugins) - 1]['admin_path'] = "../plugins/{$plugin}";
		}
		$pd->close();

		return $plugins;
	}
	########################################################################
	function maintenance_mode($new_status = '') {
		$maintenance_file = __DIR__ . '/.maintenance';

		if($new_status === true) {
			/* turn on maintenance mode */
			@touch($maintenance_file);
		} elseif($new_status === false) {
			/* turn off maintenance mode */
			@unlink($maintenance_file);
		}

		/* return current maintenance mode status */
		return is_file($maintenance_file);
	}
	########################################################################
	function handle_maintenance($echo = false) {
		if(!maintenance_mode()) return;

		global $Translation;
		$adminConfig = config('adminConfig');

		$admin = getLoggedAdmin();
		if($admin) {
			return ($echo ? '<div class="alert alert-danger" style="margin: 5em auto -5em;"><b>' . $Translation['maintenance mode admin notification'] . '</b></div>' : '');
		}

		if(!$echo) exit;

		exit('<div class="alert alert-danger" style="margin-top: 5em; font-size: 2em;"><i class="glyphicon glyphicon-exclamation-sign"></i> ' . $adminConfig['maintenance_mode_message'] . '</div>');
	}
	#########################################################
	function html_attr($str) {
		if(version_compare(PHP_VERSION, '5.2.3') >= 0) return htmlspecialchars($str, ENT_QUOTES, datalist_db_encoding, false);
		return htmlspecialchars($str, ENT_QUOTES, datalist_db_encoding);
	}
	#########################################################
	function html_attr_tags_ok($str) {
		// use this instead of html_attr() if you don't want html tags to be escaped
		$new_str = html_attr($str);
		return str_replace(['&lt;', '&gt;'], ['<', '>'], $new_str);
	}
	#########################################################
	class Notification{
		/*
			Usage:
			* in the main document, initiate notifications support using this PHP code:
				echo Notification::placeholder();

			* whenever you want to show a notifcation, use this PHP code inside a script tag:
				echo Notification::show([
					'message' => 'Notification text to display',
					'class' => 'danger', // or other bootstrap state cues, 'default' if not provided
					'dismiss_seconds' => 5, // optional auto-dismiss after x seconds
					'dismiss_days' => 7, // optional dismiss for x days if closed by user -- must provide an id
					'id' => 'xyz' // optional string to identify the notification -- must use for 'dismiss_days' to work
				]);
		*/
		protected static $placeholder_id; /* to force a single notifcation placeholder */

		protected function __construct() {} /* to prevent initialization */

		public static function placeholder() {
			if(self::$placeholder_id) return ''; // output placeholder code only once

			self::$placeholder_id = 'notifcation-placeholder-' . rand(10000000, 99999999);

			ob_start();
			?>

			<div class="notifcation-placeholder" id="<?php echo self::$placeholder_id; ?>"></div>
			<script>
				$j(function() {
					if(window.show_notification != undefined) return;

					window.show_notification = function(options) {
						var dismiss_class = '';
						var dismiss_icon = '';
						var cookie_name = 'hide_notification_' + options.id;
						var notif_id = 'notifcation-' + Math.ceil(Math.random() * 1000000);

						/* apply provided notficiation id if unique in page */
						if(options.id != undefined) {
							if(!$j('#' + options.id).length) notif_id = options.id;
						}

						/* notifcation should be hidden? */
						if(localStorage.getItem(cookie_name) != undefined) return;

						/* notification should be dismissable? */
						if(options.dismiss_seconds > 0 || options.dismiss_days > 0) {
							dismiss_class = ' alert-dismissible';
							dismiss_icon = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
						}

						/* remove old dismissed notficiations */
						$j('.alert-dismissible.invisible').remove();

						/* append notification to notifications container */
						$j(
							'<div class="alert alert-' + options['class'] + dismiss_class + '" id="' + notif_id + '">' +
								dismiss_icon +
								options.message +
							'</div>'
						).appendTo('#<?php echo self::$placeholder_id; ?>');

						var this_notif = $j('#' + notif_id);

						/* dismiss after x seconds if requested */
						if(options.dismiss_seconds > 0) {
							setTimeout(function() { this_notif.addClass('invisible'); }, options.dismiss_seconds * 1000);
						}

						/* dismiss for x days if requested and user dismisses it */
						if(options.dismiss_days > 0) {
							var ex_days = options.dismiss_days;
							this_notif.on('closed.bs.alert', function() {
								/* set a cookie not to show this alert for ex_days */
								localStorage.setItem(cookie_name, '1');
							});
						}
					}
				})
			</script>

			<?php

			return ob_get_clean();
		}

		protected static function default_options(&$options) {
			if(!isset($options['message'])) $options['message'] = 'Notification::show() called without a message!';

			if(!isset($options['class'])) $options['class'] = 'default';

			if(!isset($options['dismiss_seconds']) || isset($options['dismiss_days'])) $options['dismiss_seconds'] = 0;

			if(!isset($options['dismiss_days'])) $options['dismiss_days'] = 0;
			if(!isset($options['id'])) {
				$options['id'] = 0;
				$options['dismiss_days'] = 0;
			}
		}

		/**
		 *  Notification::show($options) displays a notification
		 *
		 *  @param $options assoc array
		 *
		 *  @return html code for displaying the notifcation
		 */
		public static function show($options = []) {
			self::default_options($options);

			ob_start();
			?>
			<script>
				$j(function() {
					show_notification(<?php echo json_encode($options); ?>);
				})
			</script>
			<?php

			return ob_get_clean();
		}
	}
	#########################################################
	function addMailRecipients(&$pm, $recipients, $type = 'to') {
		if(empty($recipients)) return;

		$func = [];

		switch(strtolower($type)) {
			case 'cc':
				$func = [$pm, 'addCC'];
				break;
			case 'bcc':
				$func = [$pm, 'addBCC'];
				break;
			case 'to':
			default:
				$func = [$pm, 'addAddress'];
				break;
		}

		// if recipients is a str, arrayify it!
		if(is_string($recipients)) $recipients = [[$recipients]];
		if(!is_array($recipients)) return;

		// if recipients is an array, loop thru and add emails/names
		foreach ($recipients as $rcpt) {
			// if rcpt is string, add as email
			if(is_string($rcpt) && isEmail($rcpt))
				call_user_func_array($func, [$rcpt]);

			// else if rcpt is array [email, name], or just [email]
			elseif(is_array($rcpt) && isEmail($rcpt[0]))
				call_user_func_array($func, [$rcpt[0], empty($rcpt[1]) ? '' : $rcpt[1]]);
		}
	}
	#########################################################
	function sendmail($mail) {
		if(empty($mail['to'])) return 'No recipient defined';

		// convert legacy 'to' and 'name' to new format [[to, name]]
		if(is_string($mail['to']))
			$mail['to'] = [
				[
					$mail['to'],
					empty($mail['name']) ? '' : $mail['name']
				]
			];

		if(!isEmail($mail['to'][0][0])) return 'Invalid recipient email';

		$cfg = config('adminConfig');
		$smtp = ($cfg['mail_function'] == 'smtp');

		$pm = new PHPMailer\PHPMailer\PHPMailer;
		$pm->CharSet = datalist_db_encoding;

		if($smtp) {
			$pm->isSMTP();
			$pm->SMTPDebug = isset($mail['debug']) ? min(4, max(0, intval($mail['debug']))) : 0;
			$pm->Debugoutput = 'html';
			$pm->Host = $cfg['smtp_server'];
			$pm->Port = $cfg['smtp_port'];
			$pm->SMTPAuth = !empty($cfg['smtp_user']) || !empty($cfg['smtp_pass']);
			$pm->SMTPSecure = $cfg['smtp_encryption'];
			$pm->SMTPAutoTLS = $cfg['smtp_encryption'] ? true : false;
			$pm->Username = $cfg['smtp_user'];
			$pm->Password = $cfg['smtp_pass'];
		}

		$pm->setFrom($cfg['senderEmail'], $cfg['senderName']);
		$pm->Subject = isset($mail['subject']) ? $mail['subject'] : '';

		// handle recipients
		addMailRecipients($pm, $mail['to']);
		if(!empty($mail['cc'])) addMailRecipients($pm, $mail['cc'], 'cc');
		if(!empty($mail['bcc'])) addMailRecipients($pm, $mail['bcc'], 'bcc');

		/* if message already contains html tags, don't apply nl2br */
		$mail['message'] = isset($mail['message']) ? $mail['message'] : '';
		if($mail['message'] == strip_tags($mail['message']))
			$mail['message'] = nl2br($mail['message']);

		$pm->msgHTML($mail['message'], realpath(__DIR__ . '/..'));

		/*
		 * pass 'tag' as-is if provided in $mail ..
		 * this is useful for passing any desired values to sendmail_handler
		 */
		if(!empty($mail['tag'])) $pm->tag = $mail['tag'];

		/* if sendmail_handler(&$pm) is defined (in hooks/__global.php) */
		if(function_exists('sendmail_handler')) sendmail_handler($pm);

		if(!$pm->send()) return $pm->ErrorInfo;

		return true;
	}
	#########################################################
	function safe_html($str, $preserveNewLines = false) {
		/* if $str has no HTML tags, apply nl2br */
		if($str == strip_tags($str)) return $preserveNewLines ? $str : nl2br($str);

		$hc = new CI_Input(datalist_db_encoding);
		$str = $hc->xss_clean(bgStyleToClass($str));

		// sandbox iframes if they aren't already
		$str = preg_replace('/(<|&lt;)iframe(\s+sandbox)*(.*?)(>|&gt;)/i', '$1iframe sandbox$3$4', $str);

		return $str;
	}
	#########################################################
	function getLoggedGroupID() {
		return Authentication::getLoggedGroupId();
	}
	#########################################################
	function getLoggedMemberID() {
		$u = Authentication::getUser();
		return $u ? $u['username'] : false;
	}
	#########################################################
	function setAnonymousAccess() {
		return Authentication::setAnonymousAccess();
	}
	#########################################################
	function getMemberInfo($memberID = null) {
		if($memberID === null) {
			$u = Authentication::getUser();
			if(!$u) return [];

			$memberID = $u['username'];
		}

		return Authentication::getMemberInfo($memberID);
	}
	#########################################################
	function get_group_id($user = null) {
		$mi = getMemberInfo($user);
		return $mi['groupID'];
	}
	#########################################################
	/**
	 *  Prepares data for a SET or WHERE clause, to be used in an INSERT/UPDATE query
	 *
	 *  @param [in] $set_array Assoc array of field names => values
	 *  @param [in] $glue optional glue. Set to ' AND ' or ' OR ' if preparing a WHERE clause, or to ',' (default) for a SET clause
	 *  @return string containing the prepared SET or WHERE clause
	 */
	function prepare_sql_set($set_array, $glue = ', ') {
		$fnvs = [];
		foreach($set_array as $fn => $fv) {
			if($fv === null && trim($glue) == ',') { $fnvs[] = "{$fn}=NULL"; continue; }
			if($fv === null) { $fnvs[] = "{$fn} IS NULL"; continue; }

			if(is_array($fv) && trim($glue) != ',') {
				$fnvs[] = "{$fn} IN ('" . implode("','", array_map('makeSafe', $fv)) . "')";
				continue;
			}

			$sfv = makeSafe($fv);
			$fnvs[] = "{$fn}='{$sfv}'";
		}
		return implode($glue, $fnvs);
	}
	#########################################################
	/**
	 *  Inserts a record to the database
	 *
	 *  @param [in] $tn table name where the record would be inserted
	 *  @param [in] $set_array Assoc array of field names => values to be inserted
	 *  @param [out] $error optional string containing error message if insert fails
	 *  @return boolean indicating success/failure
	 */
	function insert($tn, $set_array, &$error = '') {
		$set = prepare_sql_set($set_array);
		if(!$set) return false;

		$eo = ['silentErrors' => true];
		$res = sql("INSERT INTO `{$tn}` SET {$set}", $eo);
		if($res) return true;

		$error = $eo['error'];
		return false;
	}
	#########################################################
	/**
	 *  Updates a record in the database
	 *
	 *  @param [in] $tn table name where the record would be updated
	 *  @param [in] $set_array Assoc array of field names => values to be updated
	 *  @param [in] $where_array Assoc array of field names => values used to build the WHERE clause
	 *  @param [out] $error optional string containing error message if insert fails
	 *  @return boolean indicating success/failure
	 */
	function update($tn, $set_array, $where_array, &$error = '') {
		$set = prepare_sql_set($set_array);
		if(!$set) return false;

		$where = prepare_sql_set($where_array, ' AND ');
		if(!$where) $where = '1=1';

		$eo = ['silentErrors' => true];
		$res = sql("UPDATE `{$tn}` SET {$set} WHERE {$where}", $eo);
		if($res) return true;

		$error = $eo['error'];
		return false;
	}
	#########################################################
	/**
	 *  Set/update the owner of given record
	 *
	 *  @param [in] $tn name of table
	 *  @param [in] $pk primary key value
	 *  @param [in] $user username to set as owner. If not provided (or false), update dateUpdated only
	 *  @return boolean indicating success/failure
	 */
	function set_record_owner($tn, $pk, $user = false) {
		$fields = [
			'memberID' => strtolower($user),
			'dateUpdated' => time(),
			'groupID' => get_group_id($user)
		];

		// don't update user if false
		if($user === false) unset($fields['memberID'], $fields['groupID']);

		$where_array = ['tableName' => $tn, 'pkValue' => $pk];
		$where = prepare_sql_set($where_array, ' AND ');
		if(!$where) return false;

		/* do we have an existing ownership record? */
		$res = sql("SELECT * FROM `membership_userrecords` WHERE {$where}", $eo);
		if($row = db_fetch_assoc($res)) {
			if($row['memberID'] == $user) return true; // owner already set to $user

			/* update owner and/or dateUpdated */
			$res = update('membership_userrecords', backtick_keys_once($fields), $where_array);
			return ($res ? true : false);
		}

		/* add new ownership record */
		$fields = array_merge($fields, $where_array, ['dateAdded' => time()]);
		$res = insert('membership_userrecords', backtick_keys_once($fields));
		return ($res ? true : false);
	}
	#########################################################
	/**
	 *  get date/time format string for use in different cases.
	 *
	 *  @param [in] $destination string, one of these: 'php' (see date function), 'mysql', 'moment'
	 *  @param [in] $datetime string, one of these: 'd' = date, 't' = time, 'dt' = both
	 *  @return string
	 */
	function app_datetime_format($destination = 'php', $datetime = 'd') {
		switch(strtolower($destination)) {
			case 'mysql':
				$date = '%d/%m/%Y';
				$time = '%H:%i:%s';
				break;
			case 'moment':
				$date = 'DD/MM/YYYY';
				$time = 'HH:mm:ss';
				break;
			case 'phps': // php short format
				$date = 'j/n/Y';
				$time = 'H:i:s';
				break;
			default: // php
				$date = 'd/m/Y';
				$time = 'H:i:s';
		}

		$datetime = strtolower($datetime);
		if($datetime == 'dt' || $datetime == 'td') return "{$date} {$time}";
		if($datetime == 't') return $time;
		return $date; // default case of 'd'
	}
	#########################################################
	/**
	 *  perform a test and return results
	 *
	 *  @param [in] $subject string used as title of test
	 *  @param [in] $test callable function containing the test to be performed, should return true on success, false or a log string on error
	 *  @return test result
	 */
	function test($subject, $test) {
		ob_start();
		$result = $test();
		if($result === true) {
			echo "<div class=\"alert alert-success vspacer-sm\" style=\"padding: 0.2em;\"><i class=\"glyphicon glyphicon-ok hspacer-lg\"></i> {$subject}</div>";
			return ob_get_clean();
		}

		$log = '';
		if($result !== false) $log = "<pre style=\"margin-left: 2em; padding: 0.2em;\">{$result}</pre>";
		echo "<div class=\"alert alert-danger vspacer-sm\" style=\"padding: 0.2em;\"><i class=\"glyphicon glyphicon-remove hspacer-lg\"></i> <span class=\"text-bold\">{$subject}</span>{$log}</div>";
		return ob_get_clean();
	}
	#########################################################
	/**
	 *  invoke a method of an object -- useful to call private/protected methods
	 *
	 *  @param [in] $object instance of object containing the method
	 *  @param [in] $methodName string name of method to invoke
	 *  @param [in] $parameters array of parameters to pass to the method
	 *  @return the returned value from the invoked method
	 */
	function invoke_method(&$object, $methodName, array $parameters = []) {
		$reflection = new ReflectionClass(get_class($object));
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs($object, $parameters);
	}
	#########################################################
	/**
	 *  retrieve the value of a property of an object -- useful to retrieve private/protected props
	 *
	 *  @param [in] $object instance of object containing the method
	 *  @param [in] $propName string name of property to retrieve
	 *  @return the returned value of the given property, or null if property doesn't exist
	 */
	function get_property(&$object, $propName) {
		$reflection = new ReflectionClass(get_class($object));
		try {
			$prop = $reflection->getProperty($propName);
		} catch(Exception $e) {
			return null;
		}

		$prop->setAccessible(true);

		return $prop->getValue($object);
	}

	#########################################################
	/**
	 *  invoke a method of a static class -- useful to call private/protected methods
	 *
	 *  @param [in] $class string name of the class containing the method
	 *  @param [in] $methodName string name of method to invoke
	 *  @param [in] $parameters array of parameters to pass to the method
	 *  @return the returned value from the invoked method
	 */
	function invoke_static_method($class, $methodName, array $parameters = []) {
		$reflection = new ReflectionClass($class);
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs(null, $parameters);
	}
	#########################################################
	/**
	 *  @param [in] $app_datetime string, a datetime formatted in app-specific format
	 *  @return string, mysql-formatted datetime, 'yyyy-mm-dd H:i:s', or empty string on error
	 */
	function mysql_datetime($app_datetime, $date_format = null, $time_format = null) {
		$app_datetime = trim($app_datetime);

		if($date_format === null) $date_format = app_datetime_format('php', 'd');
		$date_separator = $date_format[1];
		if($time_format === null) $time_format = app_datetime_format('php', 't');
		$time24 = (strpos($time_format, 'H') !== false); // true if $time_format is 24hr rather than 12

		$date_regex = str_replace(
			array('Y', 'm', 'd', '/', '.'),
			array('([0-9]{4})', '(1[012]|0?[1-9])', '([12][0-9]|3[01]|0?[1-9])', '\/', '\.'),
			$date_format
		);

		$time_regex = str_replace(
			array('H', 'h', ':i', ':s'),
			array(
				'(1[0-9]|2[0-3]|0?[0-9])',
				'(1[012]|0?[0-9])',
				'(:([1-5][0-9]|0?[0-9]))',
				'(:([1-5][0-9]|0?[0-9]))?'
			),
			$time_format
		);
		if(stripos($time_regex, ' a'))
			$time_regex = str_ireplace(' a', '\s*(am|pm|a|p)?', $time_regex);
		else
			$time_regex = str_ireplace( 'a', '\s*(am|pm|a|p)?', $time_regex);

		// extract date and time
		$time = '';
		$mat = [];
		$regex = "/^({$date_regex})(\s+{$time_regex})?$/i";
		$valid_dt = preg_match($regex, $app_datetime, $mat);
		if(!$valid_dt || count($mat) < 5) return ''; // invlaid datetime
		// if we have a time, get it and change 'a' or 'p' at the end to 'am'/'pm'
		if(count($mat) >= 8) $time = preg_replace('/(a|p)$/i', '$1m', trim($mat[5]));

		// extract date elements from regex match, given 1st 2 items are full string and full date
		$date_order = str_replace($date_separator, '', $date_format);
		$day = $mat[stripos($date_order, 'd') + 2];
		$month = $mat[stripos($date_order, 'm') + 2];
		$year = $mat[stripos($date_order, 'y') + 2];

		// convert time to 24hr format if necessary
		if($time && !$time24) $time = date('H:i:s', strtotime("2000-01-01 {$time}"));

		$mysql_datetime = trim("{$year}-{$month}-{$day} {$time}");

		// strtotime handles dates between 1902 and 2037 only
		// so we need another test date for dates outside this range ...
		$test = $mysql_datetime;
		if($year < 1902 || $year > 2037) $test = str_replace($year, '2000', $mysql_datetime);

		return (strtotime($test) ? $mysql_datetime : '');
	}
	#########################################################
	/**
	 *  @param [in] $mysql_datetime string, Mysql-formatted datetime
	 *  @param [in] $datetime string, one of these: 'd' = date, 't' = time, 'dt' = both
	 *  @return string, app-formatted datetime, or empty string on error
	 *
	 *  @details works for formatting date, time and datetime, based on 2nd param
	 */
	function app_datetime($mysql_datetime, $datetime = 'd') {
		$pyear = $myear = substr($mysql_datetime, 0, 4);

		// if date is 0 (0000-00-00) return empty string
		if(!$mysql_datetime || substr($mysql_datetime, 0, 10) == '0000-00-00') return '';

		// strtotime handles dates between 1902 and 2037 only
		// so we need a temp date for dates outside this range ...
		if($myear < 1902 || $myear > 2037) $pyear = 2000;
		$mysql_datetime = str_replace("$myear", "$pyear", $mysql_datetime);

		$ts = strtotime($mysql_datetime);
		if(!$ts) return '';

		$pdate = date(app_datetime_format('php', $datetime), $ts);
		return str_replace("$pyear", "$myear", $pdate);
	}
	#########################################################
	/**
	 *  converts string from app-configured encoding to utf8
	 *
	 *  @param [in] $str string to convert to utf8
	 *  @return utf8-encoded string
	 *
	 *  @details if the constant 'datalist_db_encoding' is not defined, original string is returned
	 */
	function to_utf8($str) {
		if(!defined('datalist_db_encoding')) return $str;
		if(datalist_db_encoding == 'UTF-8') return $str;
		return iconv(datalist_db_encoding, 'UTF-8', $str);
	}
	#########################################################
	/**
	 *  converts string from utf8 to app-configured encoding
	 *
	 *  @param [in] $str string to convert from utf8
	 *  @return string utf8-decoded string
	 *
	 *  @details if the constant 'datalist_db_encoding' is not defined, original string is returned
	 */
	function from_utf8($str) {
		if(!strlen($str)) return $str;
		if(!defined('datalist_db_encoding')) return $str;
		if(datalist_db_encoding == 'UTF-8') return $str;
		return iconv('UTF-8', datalist_db_encoding, $str);
	}
	#########################################################
	/* deep trimmer function */
	function array_trim($arr) {
		if(!is_array($arr)) return trim($arr);
		return array_map('array_trim', $arr);
	}
	#########################################################
	function request_outside_admin_folder() {
		return (realpath(__DIR__) != realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
	}
	#########################################################
	function get_parent_tables($table) {
		/* parents array:
		 * 'child table' => [parents], ...
		 *         where parents array:
		 *             'parent table' => [main lookup fields in child]
		 */
		$parents = [
			'approval_table' => [
				'user_table' => ['person_responsbility'],
			],
			'navavishkar_stay_facilities_table' => [
				'user_table' => ['custodian'],
			],
			'navavishkar_stay_facilities_allotment_table' => [
				'navavishkar_stay_facilities_table' => ['item_lookup'],
				'user_table' => ['alloted_by', 'select_employee'],
			],
			'car_usage_table' => [
				'car_table' => ['car_lookup'],
			],
			'cycle_table' => [
				'user_table' => ['responsible_contact_person'],
			],
			'cycle_usage_table' => [
				'cycle_table' => ['cycle_lookup'],
			],
			'outcomes_expected_table' => [
				'event_table' => ['event_lookup'],
			],
			'event_decision_table' => [
				'outcomes_expected_table' => ['outcomes_expected_lookup'],
				'user_table' => ['decision_actor'],
			],
			'meetings_table' => [
				'visiting_card_table' => ['visiting_card_lookup'],
				'event_table' => ['event_lookup'],
			],
			'agenda_table' => [
				'meetings_table' => ['meeting_lookup'],
			],
			'decision_table' => [
				'agenda_table' => ['agenda_lookup'],
				'user_table' => ['decision_actor'],
			],
			'participants_table' => [
				'event_table' => ['event_lookup'],
				'meetings_table' => ['meeting_lookup'],
			],
			'action_actor' => [
				'user_table' => ['actor'],
			],
			'visiting_card_table' => [
				'user_table' => ['given_by'],
			],
			'mou_details_table' => [
				'user_table' => ['assigned_mou_to'],
			],
			'goal_setting_table' => [
				'user_table' => ['assigned_to', 'supervisor_name'],
			],
			'goal_progress_table' => [
				'goal_setting_table' => ['goal_lookup'],
				'user_table' => ['remarks_by'],
			],
			'task_allocation_table' => [
				'user_table' => ['assigned_to', 'supervisor_name'],
			],
			'task_progress_status_table' => [
				'task_allocation_table' => ['task_lookup'],
			],
			'timesheet_entry_table' => [
				'user_table' => ['reporting_manager'],
			],
			'star_pnt' => [
				'internship_fellowship_details_app' => ['iittnif_id'],
			],
			'asset_allotment_table' => [
				'asset_table' => ['asset_lookup'],
				'user_table' => ['alloted_by', 'select_employee'],
			],
			'sub_asset_allotment_table' => [
				'sub_asset_table' => ['sub_asset_lookup'],
				'user_table' => ['alloted_by', 'select_employee'],
			],
			'it_inventory_app' => [
				'user_table' => ['sactioned_by'],
			],
			'it_inventory_billing_details' => [
				'it_inventory_app' => ['it_inventory_lookup'],
			],
			'it_inventory_allotment_table' => [
				'employees_personal_data_table' => ['select_employee'],
				'user_table' => ['alloted_by'],
			],
			'computer_user_details' => [
				'computer_details_table' => ['pc_id'],
			],
			'computer_allotment_table' => [
				'computer_details_table' => ['pc_id'],
			],
			'employees_designation_table' => [
				'employees_personal_data_table' => ['employee_lookup'],
				'user_table' => ['reviewing_officer', 'reporting_officer'],
			],
			'employees_appraisal_table' => [
				'employees_designation_table' => ['employee_designation_lookup'],
				'user_table' => ['reviewing_officer'],
			],
			'work_from_home_tasks_app' => [
				'work_from_home_table' => ['work_from_home_details'],
			],
			'navavishkar_stay_payment_table' => [
				'navavishkar_stay_table' => ['navavishakr_stay_details'],
			],
			'email_id_allocation_table' => [
				'user_table' => ['reporting_manager'],
			],
			'shortlisted_startups_for_fund_table' => [
				'all_startup_data_table' => ['startup'],
			],
			'shortlisted_startups_dd_and_agreement_table' => [
				'all_startup_data_table' => ['startup'],
			],
			'evaluation_table' => [
				'all_startup_data_table' => ['select_startup'],
			],
			'problem_statement_table' => [
				'programs_table' => ['select_program_id'],
			],
			'evaluators_table' => [
				'evaluation_table' => ['evaluation_lookup'],
			],
			'approval_billing_table' => [
				'approval_table' => ['approval_lookup'],
				'user_table' => ['paid_by'],
			],
			'honorarium_claim_table' => [
				'user_table' => ['coordinated_by_tih_user'],
			],
			'selected_proposals_final_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'stage_wise_budget_table_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'first_level_shortlisted_proposals_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'budget_table_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'panel_comments_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'selected_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'address_tdp' => [
				'panel_decision_table_tdp' => ['project_id'],
			],
			'project_details_tdp' => [
				'summary_table_tdp' => ['project_number'],
			],
			'r_and_d_monthly_progress_app' => [
				'r_and_d_progress' => ['r_and_d_lookup'],
			],
			'r_and_d_quarterly_progress_app' => [
				'r_and_d_progress' => ['r_and_d_lookup'],
			],
			'td_projects_td_intellectual_property' => [
				'projects' => ['source_of_ip'],
			],
			'td_projects_td_technology_products' => [
				'projects' => ['source_of_ip'],
			],
			'td_publications' => [
				'td_publications_and_intellectual_activities' => ['publications_and_intellectual_activities_details'],
				'projects' => ['source_of_ip'],
			],
			'td_ipr' => [
				'td_publications_and_intellectual_activities' => ['publications_and_intellectual_activities_details'],
			],
		];

		return isset($parents[$table]) ? $parents[$table] : [];
	}
	#########################################################
	function backtick_keys_once($arr_data) {
		return array_combine(
			/* add backticks to keys */
			array_map(
				function($e) { return '`' . trim($e, '`') . '`'; },
				array_keys($arr_data)
			),
			/* and combine with values */
			array_values($arr_data)
		);
	}
	#########################################################
	function calculated_fields() {
		/*
		 * calculated fields configuration array, $calc:
		 *         table => [calculated fields], ..
		 *         where calculated fields:
		 *             field => query, ...
		 */
		return [
			'user_table' => [],
			'suggestion' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'approval_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'techlead_web_page' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'navavishkar_stay_facilities_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'navavishkar_stay_facilities_allotment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'car_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'car_usage_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'cycle_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'cycle_usage_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'gym_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'coffee_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'cafeteria_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'event_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'outcomes_expected_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'event_decision_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'meetings_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'agenda_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'decision_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'participants_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'action_actor' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'visiting_card_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'mou_details_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'goal_setting_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'goal_progress_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'task_allocation_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'task_progress_status_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'timesheet_entry_table' => [
				'number_of_hours' => 'SELECT 
					    TIMESTAMPDIFF(
					SECOND, %TABLENAME%.`time_in`, 
					%TABLENAME%.`time_out`)/3600 
					AS DifferenceInSeconds
					FROM %TABLENAME% WHERE id = %ID%;',
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'internship_fellowship_details_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'star_pnt' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'hrd_sdp_events_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'training_program_on_geospatial_tchnologies_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'space_day_school_details_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'space_day_college_student_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'school_list' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'sdp_participants_college_details_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'asset_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'asset_allotment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'sub_asset_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'sub_asset_allotment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'it_inventory_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'it_inventory_billing_details' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'it_inventory_allotment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'computer_details_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'computer_user_details' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'computer_allotment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'employees_personal_data_table' => [
				'employee_str' => 'SELECT CONCAT(
					`employees_personal_data_table`.`name`,
					\':\',`employees_personal_data_table`.`employee_type`,
					\':\',`employees_personal_data_table`.`department`,
					\':\',`employees_personal_data_table`.`active_status`
					) FROM %TABLENAME% WHERE `employees_personal_data_table`.`id` = %ID%',
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'employees_designation_table' => [
				'employees_designation_str' => 'SELECT CONCAT(
					`employees_personal_data_table`.`employee_str`,
					\'::\', employees_designation_table.designation,  
					\':\',`employees_designation_table`.`active_status`
					) 
					FROM employees_personal_data_table
					JOIN employees_designation_table 
					ON `employees_personal_data_table`.`id` = `employees_designation_table`.`employee_lookup`
					WHERE `employees_designation_table`.`id` = %ID%;',
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'employees_appraisal_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'beyond_working_hours_table' => [
				'number_of_hours' => 'SELECT 
					    TIMESTAMPDIFF(
					SECOND, %TABLENAME%.`start_datetime`, 
					%TABLENAME%.`end_datetime`)/3600 
					AS DifferenceInSeconds
					FROM %TABLENAME% WHERE id = %ID%;',
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.id = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.id = %ID%;',
			],
			'leave_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.id = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.id = %ID%;',
			],
			'half_day_leave_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'work_from_home_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'work_from_home_tasks_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'navavishkar_stay_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'navavishkar_stay_payment_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'email_id_allocation_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'attendence_details_table' => [],
			'all_startup_data_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'shortlisted_startups_for_fund_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'shortlisted_startups_dd_and_agreement_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'vikas_startup_applications_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'programs_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'evaluation_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'problem_statement_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'evaluators_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'approval_billing_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'honorarium_claim_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.id = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.id = %ID%;',
			],
			'honorarium_Activities' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.id = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.id = %ID%;',
			],
			'all_bank_account_statement_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'payment_track_details_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'travel_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'travel_stay_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'travel_local_commute_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'r_and_d_progress' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'panel_decision_table_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'selected_proposals_final_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'stage_wise_budget_table_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'first_level_shortlisted_proposals_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'budget_table_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'panel_comments_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'selected_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'address_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'summary_table_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'project_details_tdp' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'newsletter_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'contact_call_log_table' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'r_and_d_monthly_progress_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'r_and_d_quarterly_progress_app' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'projects' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_projects_td_intellectual_property' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_projects_td_technology_products' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_publications_and_intellectual_activities' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_publications' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_ipr' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'td_cps_research_base' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'ed_tbi' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'ed_startup_companies' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'ed_gcc' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'ed_eir' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'ed_job_creation' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'hrd_Fellowship' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'hrd_sd' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
			'it_International_Collaboration' => [
				'created_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.created_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
				'last_updated_by_username' => 'SELECT CONCAT(
					  
					membership_users.memberID, \' : \',
					  
					membership_users.custom1
					
					)
					
					FROM membership_users
					
					INNER JOIN %TABLENAME%
					  
					ON membership_users.memberID = %TABLENAME%.last_updated_by
					WHERE %TABLENAME%.%PKFIELD% = %ID%;',
			],
		];
	}
	#########################################################
	function update_calc_fields($table, $id, $formulas, $mi = false) {
		if($mi === false) $mi = getMemberInfo();
		$pk = getPKFieldName($table);
		$safe_id = makeSafe($id);
		$eo = ['silentErrors' => true];
		$caluclations_made = [];
		$replace = [
			'%ID%' => $safe_id,
			'%USERNAME%' => makeSafe($mi['username']),
			'%GROUPID%' => makeSafe($mi['groupID']),
			'%GROUP%' => makeSafe($mi['group']),
			'%TABLENAME%' => makeSafe($table),
			'%PKFIELD%' => makeSafe($pk),
		];

		foreach($formulas as $field => $query) {
			// for queries that include unicode entities, replace them with actual unicode characters
			if(preg_match('/&#\d{2,5};/', $query)) $query = entitiesToUTF8($query);

			$query = str_replace(array_keys($replace), array_values($replace), $query);
			$calc_value = sqlValue($query);
			if($calc_value  === false) continue;

			// update calculated field
			$safe_calc_value = makeSafe($calc_value);
			$update_query = "UPDATE `{$table}` SET `{$field}`='{$safe_calc_value}' " .
				"WHERE `{$pk}`='{$safe_id}'";
			$res = sql($update_query, $eo);
			if($res) $caluclations_made[] = [
				'table' => $table,
				'id' => $id,
				'field' => $field,
				'value' => $calc_value,
			];
		}

		return $caluclations_made;
	}
	#########################################################
	function existing_value($tn, $fn, $id, $cache = true) {
		/* cache results in records[tablename][id] */
		static $record = [];
		if($cache && !empty($record[$tn][$id])) return $record[$tn][$id][$fn];

		$record[$tn][$id] = getRecord($tn, $id);
		return $record[$tn][$id][$fn];
	}
	#########################################################
	function checkAppRequirements() {
		global $Translation;

		$reqErrors = [];
		$minPHP = '7.0';
		$phpVersion = floatval(phpversion());

		if($phpVersion < $minPHP)
			$reqErrors[] = str_replace(
				['<PHP_VERSION>', '<minPHP>'],
				[$phpVersion, $minPHP],
				$Translation['old php version']
			);

		if(!function_exists('mysqli_connect'))
			$reqErrors[] = str_replace('<EXTENSION>', 'mysqli', $Translation['extension not enabled']);

		if(!function_exists('mb_convert_encoding'))
			$reqErrors[] = str_replace('<EXTENSION>', 'mbstring', $Translation['extension not enabled']);

		if(!function_exists('iconv'))
			$reqErrors[] = str_replace('<EXTENSION>', 'iconv', $Translation['extension not enabled']);

		// end of checks

		if(!count($reqErrors)) return;

		exit(
			'<div style="padding: 3em; font-size: 1.5em; color: #A94442; line-height: 150%; font-family: arial; text-rendering: optimizelegibility; text-shadow: 0px 0px 1px;">' .
				'<ul><li>' .
				implode('</li><li>', $reqErrors) .
				'</li><ul>' .
			'</div>'
		);
	}
	#########################################################
	function getRecord($table, $id) {
		// get PK fieldname
		if(!$pk = getPKFieldName($table)) return false;

		$safeId = makeSafe($id);
		$eo = ['silentErrors' => true];
		$res = sql("SELECT * FROM `{$table}` WHERE `{$pk}`='{$safeId}'", $eo);
		return db_fetch_assoc($res);
	}
	#########################################################
	function guessMySQLDateTime($dt) {
		// extract date and time, assuming a space separator
		list($date, $time, $ampm) = preg_split('/\s+/', trim($dt));

		// if date is not already in mysql format, try mysql_datetime
		if(!(preg_match('/^[0-9]{4}-(0?[1-9]|1[0-2])-([1-2][0-9]|30|31|0?[1-9])$/', $date) && strtotime($date)))
			if(!$date = mysql_datetime($date)) return false;

		// if time
		if($t = time12(trim("$time $ampm")))
			$time = time24($t);
		elseif($t = time24($time))
			$time = $t;
		else
			$time = '';

		return trim("$date $time");
	}
	#########################################################
	function lookupQuery($tn, $lookupField) {
		/*
			This is the query accessible from the 'Advanced' window under the 'Lookup field' tab in AppGini.
			For auto-fill lookups, this is the same as the query of the main lookup field, except the second
			column is replaced by the caption of the auto-fill lookup field.
		*/
		$lookupQuery = [
			'user_table' => [
			],
			'suggestion' => [
			],
			'approval_table' => [
				'person_responsbility' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'techlead_web_page' => [
			],
			'navavishkar_stay_facilities_table' => [
				'custodian' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`name`) || CHAR_LENGTH(`user_table`.`memberID`), CONCAT_WS(\'\', `user_table`.`name`, \' ~ \', `user_table`.`memberID`), \'\') FROM `user_table` ORDER BY 2',
			],
			'navavishkar_stay_facilities_allotment_table' => [
				'item_lookup' => 'SELECT `navavishkar_stay_facilities_table`.`id`, IF(CHAR_LENGTH(`navavishkar_stay_facilities_table`.`type_of_item`) || CHAR_LENGTH(`navavishkar_stay_facilities_table`.`ItemDescription`), CONCAT_WS(\'\', `navavishkar_stay_facilities_table`.`type_of_item`, \' ~ \', `navavishkar_stay_facilities_table`.`ItemDescription`), \'\') FROM `navavishkar_stay_facilities_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`navavishkar_stay_facilities_table`.`custodian` ORDER BY 2',
				'select_employee' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`name`) || CHAR_LENGTH(`user_table`.`memberID`), CONCAT_WS(\'\', `user_table`.`name`, \' ~ \', `user_table`.`memberID`), \'\') FROM `user_table` ORDER BY 2',
				'alloted_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`name`) || CHAR_LENGTH(`user_table`.`memberID`), CONCAT_WS(\'\', `user_table`.`name`, \' ~ \', `user_table`.`memberID`), \'\') FROM `user_table` ORDER BY 2',
			],
			'car_table' => [
			],
			'car_usage_table' => [
				'car_lookup' => 'SELECT `car_table`.`id`, IF(CHAR_LENGTH(`car_table`.`car_number`) || CHAR_LENGTH(`car_table`.`car_model`), CONCAT_WS(\'\', `car_table`.`car_number`, \'::\', `car_table`.`car_model`), \'\') FROM `car_table` ORDER BY 2',
			],
			'cycle_table' => [
				'responsible_contact_person' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'cycle_usage_table' => [
				'cycle_lookup' => 'SELECT `cycle_table`.`id`, IF(CHAR_LENGTH(`cycle_table`.`registration_number`) || CHAR_LENGTH(`cycle_table`.`cycle_model`), CONCAT_WS(\'\', `cycle_table`.`registration_number`, \'::\', `cycle_table`.`cycle_model`), \'\') FROM `cycle_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`cycle_table`.`responsible_contact_person` ORDER BY 2',
			],
			'gym_table' => [
			],
			'coffee_table' => [
			],
			'cafeteria_table' => [
			],
			'event_table' => [
			],
			'outcomes_expected_table' => [
				'event_lookup' => 'SELECT `event_table`.`event_id`, `event_table`.`event_str` FROM `event_table` ORDER BY 2',
			],
			'event_decision_table' => [
				'outcomes_expected_lookup' => 'SELECT `outcomes_expected_table`.`outcomes_expected_id`, `outcomes_expected_table`.`outcomes_expected_str` FROM `outcomes_expected_table` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`outcomes_expected_table`.`event_lookup` ORDER BY 2',
				'decision_actor' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'meetings_table' => [
				'visiting_card_lookup' => 'SELECT `visiting_card_table`.`visiting_card_id`, `visiting_card_table`.`visiting_card_str` FROM `visiting_card_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`visiting_card_table`.`given_by` ORDER BY 2',
				'event_lookup' => 'SELECT `event_table`.`event_id`, `event_table`.`event_str` FROM `event_table` ORDER BY 2',
			],
			'agenda_table' => [
				'meeting_lookup' => 'SELECT `meetings_table`.`meetings_id`, `meetings_table`.`meeting_str` FROM `meetings_table` LEFT JOIN `visiting_card_table` as visiting_card_table1 ON `visiting_card_table1`.`visiting_card_id`=`meetings_table`.`visiting_card_lookup` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`meetings_table`.`event_lookup` ORDER BY 2',
			],
			'decision_table' => [
				'agenda_lookup' => 'SELECT `agenda_table`.`agenda_id`, `agenda_table`.`agenda_str` FROM `agenda_table` LEFT JOIN `meetings_table` as meetings_table1 ON `meetings_table1`.`meetings_id`=`agenda_table`.`meeting_lookup` ORDER BY 2',
				'decision_actor' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'participants_table' => [
				'event_lookup' => 'SELECT `event_table`.`event_id`, `event_table`.`event_str` FROM `event_table` ORDER BY 2',
				'meeting_lookup' => 'SELECT `meetings_table`.`meetings_id`, `meetings_table`.`meeting_str` FROM `meetings_table` LEFT JOIN `visiting_card_table` as visiting_card_table1 ON `visiting_card_table1`.`visiting_card_id`=`meetings_table`.`visiting_card_lookup` LEFT JOIN `event_table` as event_table1 ON `event_table1`.`event_id`=`meetings_table`.`event_lookup` ORDER BY 2',
			],
			'action_actor' => [
				'actor' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'visiting_card_table' => [
				'given_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'mou_details_table' => [
				'assigned_mou_to' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'goal_setting_table' => [
				'supervisor_name' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
				'assigned_to' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'goal_progress_table' => [
				'goal_lookup' => 'SELECT `goal_setting_table`.`goal_id`, IF(CHAR_LENGTH(`goal_setting_table`.`goal_description`) || CHAR_LENGTH(`goal_setting_table`.`goal_duration`), CONCAT_WS(\'\', `goal_setting_table`.`goal_description`, \'::\', `goal_setting_table`.`goal_duration`), \'\') FROM `goal_setting_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`goal_setting_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`goal_setting_table`.`assigned_to` ORDER BY 2',
				'remarks_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'task_allocation_table' => [
				'supervisor_name' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
				'assigned_to' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'task_progress_status_table' => [
				'task_lookup' => 'SELECT `task_allocation_table`.`task_id`, IF(CHAR_LENGTH(`task_allocation_table`.`task_description`) || CHAR_LENGTH(`task_allocation_table`.`assigned_to`), CONCAT_WS(\'\', `task_allocation_table`.`task_description`, \'::\', IF(    CHAR_LENGTH(`user_table2`.`memberID`) || CHAR_LENGTH(`user_table2`.`name`), CONCAT_WS(\'\',   `user_table2`.`memberID`, \'::\', `user_table2`.`name`), \'\')), \'\') FROM `task_allocation_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`task_allocation_table`.`supervisor_name` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`task_allocation_table`.`assigned_to` ORDER BY 2',
			],
			'timesheet_entry_table' => [
				'reporting_manager' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'internship_fellowship_details_app' => [
			],
			'star_pnt' => [
				'iittnif_id' => 'SELECT `internship_fellowship_details_app`.`id`, `internship_fellowship_details_app`.`iittnif_id` FROM `internship_fellowship_details_app` ORDER BY 2',
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
				'asset_lookup' => 'SELECT `asset_table`.`id`, IF(CHAR_LENGTH(`asset_table`.`ClassificationofAssest`) || CHAR_LENGTH(`asset_table`.`ItemDescription`), CONCAT_WS(\'\', `asset_table`.`ClassificationofAssest`, \'::\', `asset_table`.`ItemDescription`), \'\') FROM `asset_table` ORDER BY 2',
				'select_employee' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
				'alloted_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'sub_asset_table' => [
			],
			'sub_asset_allotment_table' => [
				'sub_asset_lookup' => 'SELECT `sub_asset_table`.`id`, IF(CHAR_LENGTH(`sub_asset_table`.`ClassificationofAssest`) || CHAR_LENGTH(`sub_asset_table`.`ItemDescription`), CONCAT_WS(\'\', `sub_asset_table`.`ClassificationofAssest`, \'::\', `sub_asset_table`.`ItemDescription`), \'\') FROM `sub_asset_table` ORDER BY 2',
				'select_employee' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
				'alloted_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'it_inventory_app' => [
				'sactioned_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'it_inventory_billing_details' => [
				'it_inventory_lookup' => 'SELECT `it_inventory_app`.`it_inventory_id`, IF(CHAR_LENGTH(`it_inventory_app`.`it_inventory_str`), CONCAT_WS(\'\', `it_inventory_app`.`it_inventory_str`, \'::\'), \'\') FROM `it_inventory_app` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`it_inventory_app`.`sactioned_by` ORDER BY 2',
			],
			'it_inventory_allotment_table' => [
				'select_employee' => 'SELECT `employees_personal_data_table`.`id`, IF(CHAR_LENGTH(`employees_personal_data_table`.`id`) || CHAR_LENGTH(`employees_personal_data_table`.`name`), CONCAT_WS(\'\', `employees_personal_data_table`.`id`, \'  \', `employees_personal_data_table`.`name`), \'\') FROM `employees_personal_data_table` ORDER BY 2',
				'alloted_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'computer_details_table' => [
			],
			'computer_user_details' => [
				'pc_id' => 'SELECT `computer_details_table`.`id`, IF(CHAR_LENGTH(`computer_details_table`.`pc_number`) || CHAR_LENGTH(`computer_details_table`.`pc_hostname`), CONCAT_WS(\'\', `computer_details_table`.`pc_number`, \'::\', `computer_details_table`.`pc_hostname`), \'\') FROM `computer_details_table` ORDER BY 2',
			],
			'computer_allotment_table' => [
				'pc_id' => 'SELECT `computer_details_table`.`id`, IF(CHAR_LENGTH(`computer_details_table`.`pc_number`) || CHAR_LENGTH(`computer_details_table`.`pc_hostname`), CONCAT_WS(\'\', `computer_details_table`.`pc_number`, \'::\', `computer_details_table`.`pc_hostname`), \'\') FROM `computer_details_table` ORDER BY 2',
			],
			'employees_personal_data_table' => [
			],
			'employees_designation_table' => [
				'employee_lookup' => 'SELECT `employees_personal_data_table`.`id`, IF(CHAR_LENGTH(`employees_personal_data_table`.`name`) || CHAR_LENGTH(`employees_personal_data_table`.`emp_id`), CONCAT_WS(\'\', `employees_personal_data_table`.`name`, \'::\', `employees_personal_data_table`.`emp_id`), \'\') FROM `employees_personal_data_table` ORDER BY 2',
				'reporting_officer' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
				'reviewing_officer' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'employees_appraisal_table' => [
				'employee_designation_lookup' => 'SELECT `employees_designation_table`.`id`, IF(CHAR_LENGTH(`employees_designation_table`.`employees_designation_str`) || CHAR_LENGTH(`employees_designation_table`.`reporting_officer`), CONCAT_WS(\'\', `employees_designation_table`.`employees_designation_str`, \'::\', IF(    CHAR_LENGTH(`user_table1`.`memberID`) || CHAR_LENGTH(`user_table1`.`name`), CONCAT_WS(\'\',   `user_table1`.`memberID`, \'::\', `user_table1`.`name`), \'\')), \'\') FROM `employees_designation_table` LEFT JOIN `employees_personal_data_table` as employees_personal_data_table1 ON `employees_personal_data_table1`.`id`=`employees_designation_table`.`employee_lookup` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`employees_designation_table`.`reporting_officer` LEFT JOIN `user_table` as user_table2 ON `user_table2`.`user_id`=`employees_designation_table`.`reviewing_officer` ORDER BY 2',
				'reviewing_officer' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'beyond_working_hours_table' => [
			],
			'leave_table' => [
			],
			'half_day_leave_table' => [
			],
			'work_from_home_table' => [
			],
			'work_from_home_tasks_app' => [
				'work_from_home_details' => 'SELECT `work_from_home_table`.`id`, IF(CHAR_LENGTH(if(`work_from_home_table`.`from_date`,date_format(`work_from_home_table`.`from_date`,\'%d/%m/%Y\'),\'\')) || CHAR_LENGTH(`work_from_home_table`.`work_from_home_purpose`), CONCAT_WS(\'\', if(`work_from_home_table`.`from_date`,date_format(`work_from_home_table`.`from_date`,\'%d/%m/%Y\'),\'\'), \'~\', `work_from_home_table`.`work_from_home_purpose`), \'\') FROM `work_from_home_table` ORDER BY 2',
			],
			'navavishkar_stay_table' => [
			],
			'navavishkar_stay_payment_table' => [
				'navavishakr_stay_details' => 'SELECT `navavishkar_stay_table`.`id`, IF(CHAR_LENGTH(`navavishkar_stay_table`.`full_name`) || CHAR_LENGTH(`navavishkar_stay_table`.`emp_id`), CONCAT_WS(\'\', `navavishkar_stay_table`.`full_name`, \'::\', `navavishkar_stay_table`.`emp_id`), \'\') FROM `navavishkar_stay_table` ORDER BY 2',
			],
			'email_id_allocation_table' => [
				'reporting_manager' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'attendence_details_table' => [
			],
			'all_startup_data_table' => [
			],
			'shortlisted_startups_for_fund_table' => [
				'startup' => 'SELECT `all_startup_data_table`.`id`, IF(CHAR_LENGTH(`all_startup_data_table`.`company_id`) || CHAR_LENGTH(`all_startup_data_table`.`name_of_the_company`), CONCAT_WS(\'\', `all_startup_data_table`.`company_id`, \'::\', `all_startup_data_table`.`name_of_the_company`), \'\') FROM `all_startup_data_table` ORDER BY 2',
			],
			'shortlisted_startups_dd_and_agreement_table' => [
				'startup' => 'SELECT `all_startup_data_table`.`id`, IF(CHAR_LENGTH(`all_startup_data_table`.`company_id`) || CHAR_LENGTH(`all_startup_data_table`.`name_of_the_company`), CONCAT_WS(\'\', `all_startup_data_table`.`company_id`, \'::\', `all_startup_data_table`.`name_of_the_company`), \'\') FROM `all_startup_data_table` ORDER BY 2',
			],
			'vikas_startup_applications_table' => [
			],
			'programs_table' => [
			],
			'evaluation_table' => [
				'select_startup' => 'SELECT `all_startup_data_table`.`id`, `all_startup_data_table`.`name_of_the_company` FROM `all_startup_data_table` ORDER BY 2',
			],
			'problem_statement_table' => [
				'select_program_id' => 'SELECT `programs_table`.`programs_id`, `programs_table`.`title_of_the_program` FROM `programs_table` ORDER BY 2',
			],
			'evaluators_table' => [
				'evaluation_lookup' => 'SELECT `evaluation_table`.`evaluation_id`, `evaluation_table`.`evaluation_id` FROM `evaluation_table` LEFT JOIN `all_startup_data_table` as all_startup_data_table1 ON `all_startup_data_table1`.`id`=`evaluation_table`.`select_startup` ORDER BY 2',
			],
			'approval_billing_table' => [
				'approval_lookup' => 'SELECT `approval_table`.`id`, IF(CHAR_LENGTH(`approval_table`.`type`) || CHAR_LENGTH(`approval_table`.`description`), CONCAT_WS(\'\', `approval_table`.`type`, \'::\', `approval_table`.`description`), \'\') FROM `approval_table` LEFT JOIN `user_table` as user_table1 ON `user_table1`.`user_id`=`approval_table`.`person_responsbility` ORDER BY 2',
				'paid_by' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`memberID`) || CHAR_LENGTH(`user_table`.`name`), CONCAT_WS(\'\', `user_table`.`memberID`, \'::\', `user_table`.`name`), \'\') FROM `user_table` ORDER BY 2',
			],
			'honorarium_claim_table' => [
				'coordinated_by_tih_user' => 'SELECT `user_table`.`user_id`, IF(CHAR_LENGTH(`user_table`.`name`) || CHAR_LENGTH(`user_table`.`memberID`), CONCAT_WS(\'\', `user_table`.`name`, \'::\', `user_table`.`memberID`), \'\') FROM `user_table` ORDER BY 2',
			],
			'honorarium_Activities' => [
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
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'stage_wise_budget_table_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'first_level_shortlisted_proposals_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'budget_table_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'panel_comments_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'selected_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'address_tdp' => [
				'project_id' => 'SELECT `panel_decision_table_tdp`.`panel_decision_id`, IF(CHAR_LENGTH(`panel_decision_table_tdp`.`project_id`) || CHAR_LENGTH(`panel_decision_table_tdp`.`project_title`), CONCAT_WS(\'\', `panel_decision_table_tdp`.`project_id`, \'::\', `panel_decision_table_tdp`.`project_title`), \'\') FROM `panel_decision_table_tdp` ORDER BY 2',
			],
			'summary_table_tdp' => [
			],
			'project_details_tdp' => [
				'project_number' => 'SELECT `summary_table_tdp`.`id`, `summary_table_tdp`.`project_number` FROM `summary_table_tdp` ORDER BY 2',
			],
			'newsletter_table' => [
			],
			'contact_call_log_table' => [
			],
			'r_and_d_monthly_progress_app' => [
				'r_and_d_lookup' => 'SELECT `r_and_d_progress`.`id`, IF(CHAR_LENGTH(`r_and_d_progress`.`labs`) || CHAR_LENGTH(`r_and_d_progress`.`today_progress`), CONCAT_WS(\'\', `r_and_d_progress`.`labs`, \'::\', `r_and_d_progress`.`today_progress`), \'\') FROM `r_and_d_progress` ORDER BY 2',
			],
			'r_and_d_quarterly_progress_app' => [
				'r_and_d_lookup' => 'SELECT `r_and_d_progress`.`id`, IF(CHAR_LENGTH(`r_and_d_progress`.`labs`) || CHAR_LENGTH(`r_and_d_progress`.`today_progress`), CONCAT_WS(\'\', `r_and_d_progress`.`labs`, \'::\', `r_and_d_progress`.`today_progress`), \'\') FROM `r_and_d_progress` ORDER BY 2',
			],
			'projects' => [
			],
			'td_projects_td_intellectual_property' => [
				'source_of_ip' => 'SELECT `projects`.`id`, IF(CHAR_LENGTH(`projects`.`category`) || CHAR_LENGTH(`projects`.`project_title`), CONCAT_WS(\'\', `projects`.`category`, \' ~ \', `projects`.`project_title`), \'\') FROM `projects` ORDER BY 2',
			],
			'td_projects_td_technology_products' => [
				'source_of_ip' => 'SELECT `projects`.`id`, IF(CHAR_LENGTH(`projects`.`category`) || CHAR_LENGTH(`projects`.`project_title`), CONCAT_WS(\'\', `projects`.`category`, \' ~ \', `projects`.`project_title`), \'\') FROM `projects` ORDER BY 2',
			],
			'td_publications_and_intellectual_activities' => [
			],
			'td_publications' => [
				'publications_and_intellectual_activities_details' => 'SELECT `td_publications_and_intellectual_activities`.`id`, IF(CHAR_LENGTH(`td_publications_and_intellectual_activities`.`year`) || CHAR_LENGTH(`td_publications_and_intellectual_activities`.`created_by_username`), CONCAT_WS(\'\', `td_publications_and_intellectual_activities`.`year`, \'  \', `td_publications_and_intellectual_activities`.`created_by_username`), \'\') FROM `td_publications_and_intellectual_activities` ORDER BY 2',
				'source_of_ip' => 'SELECT `projects`.`id`, IF(CHAR_LENGTH(`projects`.`category`) || CHAR_LENGTH(`projects`.`project_title`), CONCAT_WS(\'\', `projects`.`category`, \' ~ \', `projects`.`project_title`), \'\') FROM `projects` ORDER BY 2',
			],
			'td_ipr' => [
				'publications_and_intellectual_activities_details' => 'SELECT `td_publications_and_intellectual_activities`.`id`, IF(CHAR_LENGTH(`td_publications_and_intellectual_activities`.`year`) || CHAR_LENGTH(`td_publications_and_intellectual_activities`.`created_by_username`), CONCAT_WS(\'\', `td_publications_and_intellectual_activities`.`year`, \'  \', `td_publications_and_intellectual_activities`.`created_by_username`), \'\') FROM `td_publications_and_intellectual_activities` ORDER BY 2',
			],
			'td_cps_research_base' => [
			],
			'ed_tbi' => [
			],
			'ed_startup_companies' => [
			],
			'ed_gcc' => [
			],
			'ed_eir' => [
			],
			'ed_job_creation' => [
			],
			'hrd_Fellowship' => [
			],
			'hrd_sd' => [
			],
			'it_International_Collaboration' => [
			],
		];

		return $lookupQuery[$tn][$lookupField];
	}

	#########################################################
	function pkGivenLookupText($val, $tn, $lookupField, $falseIfNotFound = false) {
		static $cache = [];
		if(isset($cache[$tn][$lookupField][$val])) return $cache[$tn][$lookupField][$val];

		if(!$lookupQuery = lookupQuery($tn, $lookupField)) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		$m = [];

		// quit if query can't be parsed
		if(!preg_match('/select\s+(.*?),\s+(.*?)\s+from\s+(.*)/i', $lookupQuery, $m)) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		list($all, $pkField, $lookupField, $from) = $m;
		$from = preg_replace('/\s+order\s+by.*$/i', '', $from);
		if(!$lookupField || !$from) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		// append WHERE if not already there
		if(!preg_match('/\s+where\s+/i', $from)) $from .= ' WHERE 1=1 AND';

		$safeVal = makeSafe($val);
		$id = sqlValue("SELECT {$pkField} FROM {$from} {$lookupField}='{$safeVal}'");
		if($id !== false) {
			$cache[$tn][$lookupField][$val] = $id;
			return $id;
		}

		// no corresponding PK value found
		if($falseIfNotFound) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		} else {
			$cache[$tn][$lookupField][$val] = $val;
			return $val;
		}
	}
	#########################################################
	function userCanImport() {
		$mi = getMemberInfo();
		$safeUser = makeSafe($mi['username']);
		$groupID = intval($mi['groupID']);

		// admins can always import
		if($mi['group'] == 'Admins') return true;

		// anonymous users can never import
		if($mi['group'] == config('adminConfig')['anonymousGroup']) return false;

		// specific user can import?
		if(sqlValue("SELECT COUNT(1) FROM `membership_users` WHERE `memberID`='{$safeUser}' AND `allowCSVImport`='1'")) return true;

		// user's group can import?
		if(sqlValue("SELECT COUNT(1) FROM `membership_groups` WHERE `groupID`='{$groupID}' AND `allowCSVImport`='1'")) return true;

		return false;
	}
	#########################################################
	function parseTemplate($template) {
		if(trim($template) == '') return $template;

		global $Translation;
		foreach($Translation as $symbol => $trans)
			$template = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $template);

		// Correct <MaxSize> and <FileTypes> to prevent invalid HTML
		$template = str_replace(['<MaxSize>', '<FileTypes>'], ['{MaxSize}', '{FileTypes}'], $template);
		$template = str_replace('<%%BASE_UPLOAD_PATH%%>', getUploadDir(''), $template);

		// strip lines that only contain HTML comments
		$template = preg_replace('/^\s*<!--.*?-->\s*$/m', '', $template);

		// strip lines that only contain whitespace
		$template = preg_replace('/^\s*$/m', '', $template);

		return $template;
	}
	#########################################################
	function getUploadDir($dir = '') {
		if($dir == '') $dir = config('adminConfig')['baseUploadPath'];

		return rtrim($dir, '\\/') . DIRECTORY_SEPARATOR;
	}
	#########################################################
	function bgStyleToClass($html) {
		return preg_replace(
			'/ style="background-color: rgb\((\d+), (\d+), (\d+)\);"/',
			' class="nicedit-bg" data-nicedit_r="$1" data-nicedit_g="$2" data-nicedit_b="$3"',
			$html
		);
	}
	#########################################################
	function assocArrFilter($arr, $func) {
		if(!is_array($arr) || !count($arr)) return $arr;
		if(!is_callable($func)) return false;

		$filtered = [];
		foreach ($arr as $key => $value)
			if(call_user_func_array($func, [$key, $value]) === true)
				$filtered[$key] = $value;

		return $filtered;
	}
	#########################################################
	function setUserData($key, $value = null) {
		$data = [];

		$user = makeSafe(getMemberInfo()['username']);
		if(!$user) return false;

		$dataJson = sqlValue("SELECT `data` FROM `membership_users` WHERE `memberID`='$user'");
		if($dataJson) {
			$data = @json_decode($dataJson, true);
			if(!$data) $data = [];
		}

		$data[$key] = $value;

		return update(
			'membership_users',
			['data' => @json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR)],
			['memberID' => $user]
		);
	}
	#########################################################
	function getUserData($key) {
		$user = makeSafe(getMemberInfo()['username']);
		if(!$user) return null;

		$dataJson = sqlValue("SELECT `data` FROM `membership_users` WHERE `memberID`='$user'");
		if(!$dataJson) return null;

		$data = @json_decode($dataJson, true);
		if(!$data) return null;

		if(!isset($data[$key])) return null;

		return $data[$key];
	}
	#########################################################
	/*
	 Usage:
	 breakpoint(__FILE__, __LINE__, 'message here');
	 */
	function breakpoint($file, $line, $msg) {
		if(!DEBUG_MODE) return;
		if(strpos($_SERVER['PHP_SELF'], 'ajax_check_login.php') !== false) return;
		static $startTs = null;
		static $fp = null;
		if(!$startTs) $startTs = microtime(true);
		if(!$fp) {
			$logFile = __DIR__ . '/breakpoint.csv';
			$isNew = !is_file($logFile);
			$fp = fopen($logFile, 'a');
			if($isNew) fputcsv($fp, [
				'Time offset',
				'Requested script',
				'Running script',
				'Line #',
				'Message',
			]);

			fputcsv($fp, [date('Y-m-d H:i:s'), $_SERVER['REQUEST_URI'], '', '', '']);
		}

		fputcsv($fp, [
			number_format(microtime(true) - $startTs, 3),
			basename($_SERVER['PHP_SELF']),
			str_replace(__DIR__, '', $file),
			$line,
			is_array($msg) ? json_encode($msg) : $msg,
		]);
	}
	#########################################################
	function denyAccess($msg = null) {
		@header($_SERVER['SERVER_PROTOCOL'] . ' 403 Access Denied');
		die($msg);
	}
	#########################################################
	function is_xhr() {
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

	/**
	 * send a json response to the client and terminate
	 *
	 * @param [in] $dataOrMsg mixed, either an array of data to send, or a string error message
	 * @param [in] $isError bool, true if $dataOrMsg is an error message, false if it's data
	 * @param [in] $errorStatusCode int, HTTP status code to send
	 *
	 * @details if $isError is true, $dataOrMsg is assumed to be an error message and $errorStatusCode is sent as the HTTP status code
	 *     example error response: `{"status":"error","message":"Access denied"}`
	 *     if $isError is false, $dataOrMsg is assumed to be data and $errorStatusCode is ignored
	 *     example success response: `{"status":"success","data":{"id":1,"name":"John Doe"}}`
	 */
	function json_response($dataOrMsg, $isError = false, $errorStatusCode = 400) {
		@header('Content-type: application/json');

		if($isError) {
			@header($_SERVER['SERVER_PROTOCOL'] . ' ' . $errorStatusCode . ' Internal Server Error');
			@header('Status: ' . $errorStatusCode . ' Bad Request');

			die(json_encode([
				'status' => 'error',
				'message' => $dataOrMsg,
			]));
		}

		die(json_encode([
			'status' => 'success',
			'data' => $dataOrMsg,
		]));
	}

	/**
	 * Check if a string is alphanumeric.
	 *        We're defining it here in case it's not defined by some PHP installations.
	 *        It's reuired by PHPMailer.
	 *
	 * @param [in] $str string to check
	 * @return bool, true if $str is alphanumeric, false otherwise
	 */
	if(!function_exists('ctype_alnum')) {
		function ctype_alnum($str) {
			return preg_match('/^[a-zA-Z0-9]+$/', $str);
		}
	}

	/**
	 * Perform an HTTP request and return the response, including headers and body, with support to cookies
	 *
	 * @param string $url  URL to request
	 * @param array $payload  payload to send with the request
	 * @param array $headers  headers to send with the request, in the format ['header' => 'value']
	 * @param string $type  request type, either 'GET' or 'POST'
	 * @param string $cookieJar  path to a file to read/store cookies in
	 *
	 * @return array  response, including `'headers'` and `'body'`, or error info if request failed
	 */
	function httpRequest($url, $payload = [], $headers = [], $type = 'GET', $cookieJar = null) {
		// prep raw headers
		if(!isset($headers['User-Agent'])) $headers['User-Agent'] = $_SERVER['HTTP_USER_AGENT'];
		if(!isset($headers['Accept'])) $headers['Accept'] = $_SERVER['HTTP_ACCEPT'];
		$rawHeaders = [];
		foreach($headers as $k => $v) $rawHeaders[] = "$k: $v";

		$payloadQuery = http_build_query($payload);

		// for GET requests, append payload to url
		if($type == 'GET' && strlen($payloadQuery)) $url .= "?$payloadQuery";

		$respHeaders = [];
		$ch = curl_init();
		$options = [
			CURLOPT_URL => $url,
			CURLOPT_POST => ($type == 'POST'),
			CURLOPT_POSTFIELDS => ($type == 'POST' && strlen($payloadQuery) ? $payloadQuery : null),
			CURLOPT_HEADER => false,
			CURLOPT_HEADERFUNCTION => function($curl, $header) use (&$respHeaders) {
				list($k, $v) = explode(': ', $header);
				$respHeaders[trim($k)] = trim($v);
				return strlen($header);
			},
			CURLOPT_HTTPHEADER => $rawHeaders,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,
		];

		/* if this is a localhost request, no need to verify SSL */
		if(preg_match('/^https?:\/\/(localhost|127\.0\.0\.1)/i', $url)) {
			$options[CURLOPT_SSL_VERIFYPEER] = false;
			$options[CURLOPT_SSL_VERIFYHOST] = false;
		}

		if($cookieJar) {
			$options[CURLOPT_COOKIEJAR] = $cookieJar;
			$options[CURLOPT_COOKIEFILE] = $cookieJar;
		}

		if(defined('CURLOPT_TCP_FASTOPEN')) $options[CURLOPT_TCP_FASTOPEN] = true;
		if(defined('CURLOPT_UNRESTRICTED_AUTH')) $options[CURLOPT_UNRESTRICTED_AUTH] = true;

		curl_setopt_array($ch, $options);

		$respBody = curl_exec($ch);

		if($respBody === false) return [
			'error' => curl_error($ch),
			'info' => curl_getinfo($ch),
		];

		curl_close($ch);

		// wait for 0.05 seconds after launching request
		usleep(50000);

		return [
			'headers' => $respHeaders,
			'body' => $respBody,
		];
	}

	/**
	 * Retrieve owner username of the record with the given primary key value
	 *
	 * @param $tn string table name
	 * @param $pkValue string primary key value
	 * @return string|null username of the record owner, or null if not found
	 */
	function getRecordOwner($tn, $pkValue) {
		$tn = makeSafe($tn);
		$pkValue = makeSafe($pkValue);
		$owner = sqlValue("SELECT `memberID` FROM `membership_userrecords` WHERE `tableName`='{$tn}' AND `pkValue`='$pkValue'");

		if(!strlen($owner)) return null;
		return $owner;
	}

	/**
	 * Retrieve lookup field name that determines record owner of the given table
	 *
	 * @param $tn string table name
	 * @return string|null lookup field name, or null if default (record owner is user that creates the record)
	 */
	function tableRecordOwner($tn) {
		$owners = [
		];

		return $owners[$tn] ?? null;
	}

	/**
	 * Retrieve not-nullable fields of the given table
	 *
	 * @param $tn string table name
	 * @return array list of not-nullable fields
	 */
	function notNullFields($tn) {
		$fields = get_table_fields($tn);
		if(!$fields) return [];

		// map $fields based on whether 'appgini' key's value includes 'NOT NULL' or 'PRIMARY KEY' (skipping 'AUTO_INCREMENT' ones) and filter out not-nullable fields
		$notNullFields = array_filter($fields, function($field) {
			return (
					strpos($field['appgini'], 'NOT NULL') !== false // required
					|| strpos($field['appgini'], 'PRIMARY KEY') !== false // or primary key
				) && strpos($field['appgini'], 'AUTO_INCREMENT') === false; // but not auto-increment
		});
		$notNullFields = array_keys(array_map(function($field) { return $field['name']; }, $notNullFields));

		return $notNullFields;
	}

	/**
	 * Get list of available themes
	 *
	 * @return array list of available themes
	 */
	function getThemesList() {
		static $themes = null;
		if($themes !== null) return $themes;
		$themes = [];

		$themeDir = __DIR__ . '/../resources/initializr/css';
		if(!is_dir($themeDir)) return $themes;

		$themeFiles = glob($themeDir . '/*.css');
		if(!$themeFiles) return $themes;

		foreach($themeFiles as $themeFile) {
			// if file size less than 100 KB, it's not a Bootstrap theme
			if(filesize($themeFile) < 100 * 1024) continue;
			$themeName = basename($themeFile, '.css');
			$themes[]= $themeName;
		}

		return $themes;
	}

	/**
	 * Get user's preferred theme
	 *
	 * @return string user's preferred theme, or default theme if not set or theme selection is disabled
	 */
	function getUserTheme() {
		if(NO_THEME_SELECTION || defined('APPGINI_SETUP')) return DEFAULT_THEME;

		$theme = getUserData('theme');
		if($theme) return $theme;

		// if user has no preferred theme, return default theme
		return DEFAULT_THEME;
	}

	/**
	 * Get the user's theme compact preference. If no user preference is set or theme selection is disabled, return the default theme compact preference.
	 *
	 * @return string 'theme-compact' if the user prefers a compact theme, or an empty string otherwise
	 */
	function getUserThemeCompact() {
		if(NO_THEME_SELECTION || defined('APPGINI_SETUP')) return THEME_COMPACT ? 'theme-compact' : '';
		$themeCompact = getUserData('themeCompact');
		if($themeCompact === null) return THEME_COMPACT ? 'theme-compact' : '';
		return $themeCompact ? 'theme-compact' : '';
	}

	/**
	 * Clean up membership_userrecords table by removing records that no longer exist in user-space tables.
	 */
	function cleanUpMembershipUserRecords() {
		// get all user-space tables
		$tables = array_keys(getTableList(true));

		// loop through each table and find the records in membership_userrecords
		// that no longer exist in the user-space table and delete them
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];
		foreach($tables as $table) {
			// get the primary key of the table
			$pk = getPKFieldName($table);

			// get the records in membership_userrecords that no longer exist in the user-space table
			sql("DELETE FROM membership_userrecords WHERE tableName = '$table' AND pkValue NOT IN (SELECT `$pk` FROM `$table`)", $eo);
		}
	}


	/**
	 * Get a link to the Mass Update plugin if the user is an admin and the plugin is not installed
	 *
	 * @return array|null link to the Mass Update plugin, or null if not applicable
	 */
	function adminMassUpdateLink() {
		if(!getLoggedAdmin()) return null;

		$plugins = get_plugins();
		foreach($plugins as $pl) {
			if($pl['title'] == 'Mass Update') return null;
		}

		return [
			'function' => 'linkToMassUpdatePlugin',
			'title' => 'Want easy bulk updates? <i class="glyphicon glyphicon-new-window"></i>',
			'icon' => 'plus-sign',
			'class' => 'text-bold',
		];
	}

