<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function beyond_workingHours_table_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function beyond_workingHours_table_header($contentType, $memberInfo, &$args) {
		$header='';

		switch($contentType) {
			case 'tableview':
				$header='';
				break;

			case 'detailview':
				$header='';
				break;

			case 'tableview+detailview':
				$header='';
				break;

			case 'print-tableview':
				$header='';
				break;

			case 'print-detailview':
				$header='';
				break;

			case 'filters':
				$header='';
				break;
		}

		return $header;
	}

	function beyond_workingHours_table_footer($contentType, $memberInfo, &$args) {
		$footer='';

		switch($contentType) {
			case 'tableview':
				$footer='';
				break;

			case 'detailview':
				$footer='';
				break;

			case 'tableview+detailview':
				$footer='';
				break;

			case 'print-tableview':
				$footer='';
				break;

			case 'print-detailview':
				$footer='';
				break;

			case 'filters':
				$footer='';
				break;
		}

		return $footer;
	}

	function beyond_workingHours_table_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function beyond_workingHours_table_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function beyond_workingHours_table_before_update(&$data, $memberInfo, &$args) {

		// Capturing the Post request
		$fromData = $_POST;

		$id = makeSafe($fromData["SelectedID"]);
		$sql_querry = "SELECT * FROM beyond_workingHours_table WHERE id ='{$id}'";
		$result = sql($sql_querry,$eo);
		if($row = db_fetch_assoc($result)){
			if ($row["approval_status"] == "Approved"){
				WindowMessages::add("Sorry! The form is already approved. It can not be changed.");
				return FALSE;
			}
			else{
				return TRUE;
			}
		}

	}

	function beyond_workingHours_table_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function beyond_workingHours_table_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function beyond_workingHours_table_after_delete($selectedID, $memberInfo, &$args) {

	}

	function beyond_workingHours_table_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function beyond_workingHours_table_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function beyond_workingHours_table_batch_actions(&$args) {

		return [];
	}
