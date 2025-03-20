<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function login_ok($memberInfo, &$args) {

		return '';
	}

	function login_failed($attempt, &$args) {

	}

	function member_activity($memberInfo, $activity, &$args) {
		switch($activity) {
			case 'pending':
				break;

			case 'automatic':
				break;

			case 'profile':
				break;

			case 'password':
				break;

		}
	}

	function sendmail_handler(&$pm) {

	}

	function child_records_config($childTable, $childLookupField, &$config) {

	}


	// function for approval from techleads

	function restrictApprovalForApproved($data, $memberInfo, $tablename){

		// Capturing the Post request
		$fromData = $_POST;

		$id = makeSafe($fromData["SelectedID"]);
		$sql_querry = "SELECT * FROM {$tablename} WHERE id ='{$id}'";
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


	// function for approval
	function approvalBeforeInsert($data, $memberInfo){

		// capturing the post request data
		$formData = $_POST;

		// loop to verify the valid user for approval
		if ($formData["approval_status"]=="Approved by CEO" xor $formData["approval_status"]=="Not Approved by CEO" xor $formData["approval_status"]=="Approved by PD" xor $formData["approval_status"]=="Not Approved by PD" ){
			if ($memberInfo["groupID"] == 3){
				return TRUE;
			}
			else{
				WindowMessages::add("Sorry! You don't have permission to Approve or Disapprove the approval. For more information, Please contact admin.");
				return FALSE;
			}
		}

		else{
			return TRUE;
		}
	
	}

	function approvalBeforeUpdate($data, $memberInfo, $tablename){


		// capturing the post request data
		$formData = $_POST;

		// loop to verify the valid user for approval
		if ($formData["approval_status"]=="Approved by CEO" xor $formData["approval_status"]=="Not Approved by CEO" xor $formData["approval_status"]=="Approved by PD" xor $formData["approval_status"]=="Not Approved by PD" ){
			if ($memberInfo["groupID"] == 3){
				return TRUE;
			}
			else{
				WindowMessages::add("Sorry! You don't have permission to Approve or Disapprove the approval. For more information, Please contact admin.");
				return FALSE;
			}
		}

		else{
			// filter data with id from existing database
			$id = makeSafe($formData["SelectedID"]);
			$sql_querry = "SELECT * FROM {$tablename} WHERE id='{$id}'";
			$result = sql($sql_querry,$eo);
			if($row = db_fetch_assoc($result)){
				// if already approved then block the update
				if ($row["approval_status"] == "Approved by CEO" xor $row["approval_status"] == "Not Approved by CEO" xor $row["approval_status"] == "Approved by PD" xor $row["approval_status"] == "Not Approved by PD"){

					if ($memberInfo["groupID"] == 3){
						return TRUE;
					}
					else{
						WindowMessages::add("Sorry! You don't have permission to Approve or Disapprove the approval. For more information, Please contact admin.");
						return FALSE;
					}
				}
				else{
					return TRUE;
				}
			}
		}

	}
