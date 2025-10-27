<?php
	include_once(__DIR__ . '/lib.php');

	// upload paths
	$p = [
		'suggestion' => [
			'attachment' => getUploadDir(''),
			'primary key' => 'suggestion_id'
		],
		'approval_table' => [
			'image' => getUploadDir(''),
			'other_file' => getUploadDir(''),
			'primary key' => 'id'
		],
		'techlead_web_page' => [
			'img1' => getUploadDir(''),
			'img2' => getUploadDir(''),
			'primary key' => 'id'
		],
		'visiting_card_table' => [
			'front_img' => getUploadDir(''),
			'back_img' => getUploadDir(''),
			'primary key' => 'visiting_card_id'
		],
		'mou_details_table' => [
			'upload_mou' => getUploadDir(''),
			'primary key' => 'id'
		],
		'asset_table' => [
			'CustodianSignature' => getUploadDir(''),
			'primary key' => 'id'
		],
		'sub_asset_table' => [
			'CustodianSignature' => getUploadDir(''),
			'primary key' => 'id'
		],
		'it_inventory_app' => [
			'custodian_signature' => getUploadDir(''),
			'primary key' => 'it_inventory_id'
		],
		'it_inventory_billing_details' => [
			'image' => getUploadDir(''),
			'primary key' => 'it_inventory_biling_details_id'
		],
		'employees_personal_data_table' => [
			'profile_photo' => getUploadDir(''),
			'signature' => getUploadDir(''),
			'primary key' => 'id'
		],
		'employees_appraisal_table' => [
			'upload_file_1' => getUploadDir(''),
			'upload_file_2' => getUploadDir(''),
			'upload_file_3' => getUploadDir(''),
			'primary key' => 'id'
		],
		'leave_table' => [
			'upload_img' => getUploadDir(''),
			'upload_pdf' => getUploadDir(''),
			'primary key' => 'id'
		],
		'work_from_home_table' => [
			'upload_img' => getUploadDir(''),
			'upload_pdf' => getUploadDir(''),
			'primary key' => 'id'
		],
		'navavishkar_stay_payment_table' => [
			'payment_img' => getUploadDir(''),
			'primary key' => 'id'
		],
		'all_startup_data_table' => [
			'company_logo' => getUploadDir(''),
			'primary key' => 'id'
		],
		'approval_billing_table' => [
			'attach_bill_1' => getUploadDir(''),
			'attach_bill_2' => getUploadDir(''),
			'attach_bill_3' => getUploadDir(''),
			'primary key' => 'id'
		],
		'payment_track_details_table' => [
			'upload_scanned_file_1' => getUploadDir(''),
			'upload_scanned_file_2' => getUploadDir(''),
			'primary key' => 'payment_track_details_id'
		],
		'newsletter_table' => [
			'img1' => getUploadDir(''),
			'img2' => getUploadDir(''),
			'primary key' => 'id'
		],
	];

	if(!count($p)) getLink();

	// default links
	$dL = [
	];

	// receive user input
	$t = Request::val('t'); // table name
	$f = Request::val('f'); // field name
	$i = makeSafe(Request::val('i')); // id

	// validate input
	if(!in_array($t, array_keys($p))) getLink();
	if(!in_array($f, array_keys($p[$t])) || $f == 'primary key') getLink();
	if(!$i && !$dL[$t][$f]) getLink();

	// user has view access to the requested table?
	if(!check_record_permission($t, Request::val('i'))) getLink();

	// send default link if no id provided, e.g. new record
	if(!$i) {
		$path = $p[$t][$f];
		if(preg_match('/^(http|ftp)/i', $dL[$t][$f])) $path = '';
		@header("Location: {$path}{$dL[$t][$f]}");
		exit;
	}

	getLink($t, $f, $p[$t]['primary key'], $i, $p[$t][$f]);

	function getLink($table = '', $linkField = '', $pk = '', $id = '', $path = '') {
		if(!$id || !$table || !$linkField || !$pk) // default link to return
			exit;

		if(preg_match('/^Lookup: (.*?)::(.*?)::(.*?)$/', $path, $m)) {
			$linkID = makeSafe(sqlValue("SELECT `$linkField` FROM `$table` WHERE `$pk`='$id'"));
			$link = sqlValue("SELECT `{$m[3]}` FROM `{$m[1]}` WHERE `{$m[2]}`='$linkID'");
		} else {
			$link = sqlValue("SELECT `$linkField` FROM `$table` WHERE `$pk`='$id'");
		}

		if(!$link) exit;

		if(preg_match('/^(http|ftp)/i', $link)) {    // if the link points to an external url, don't prepend path
			$path = '';
		} elseif(!is_file(__DIR__ . "/{$path}{$link}")) {    // if the file doesn't exist in the given path, try to find it without the path
			$path = '';
		}

		@header("Location: $path$link");
		exit;
	}