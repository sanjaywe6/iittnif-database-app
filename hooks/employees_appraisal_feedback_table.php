<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function employees_appraisal_feedback_table_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function employees_appraisal_feedback_table_header($contentType, $memberInfo, &$args) {
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

	function employees_appraisal_feedback_table_footer($contentType, $memberInfo, &$args) {
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

	function employees_appraisal_feedback_table_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function employees_appraisal_feedback_table_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function employees_appraisal_feedback_table_before_update(&$data, $memberInfo, &$args) {

		// capturing the post request data
		$formData = $_POST;
		// filter data with id from existing database
		$id = makeSafe($formData["SelectedID"]);
		$sql_querry = "SELECT * FROM employees_appraisal_feedback_table WHERE id='{$id}'";
		$result = sql($sql_querry,$eo);
		if($row = db_fetch_assoc($result)){
			// if already reviewed then block the update
			if ($row["appraisal_feedback_status"] == "Reviewed"){

				if ($memberInfo["groupID"] == 3){
					return TRUE;
				}
				else{
					WindowMessages::add("Sorry! You don't have permission to edit the data. Please contact admin.");
					return FALSE;
				}
			}
			else{
				return TRUE;
			}
		}

	}

	function employees_appraisal_feedback_table_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function employees_appraisal_feedback_table_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function employees_appraisal_feedback_table_after_delete($selectedID, $memberInfo, &$args) {

	}

	function employees_appraisal_feedback_table_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function employees_appraisal_feedback_table_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function employees_appraisal_feedback_table_batch_actions(&$args) {

		return [];
	}
