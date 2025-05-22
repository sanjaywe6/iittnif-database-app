<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function navavishkar_stay_table_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function navavishkar_stay_table_header($contentType, $memberInfo, &$args) {
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

	function navavishkar_stay_table_footer($contentType, $memberInfo, &$args) {
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

	function navavishkar_stay_table_before_insert(&$data, $memberInfo, &$args) {

		return approvalBeforeInsert($data, $memberInfo);
	}

	function navavishkar_stay_table_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function navavishkar_stay_table_before_update(&$data, $memberInfo, &$args) {
		return approvalBeforeUpdate($data, $memberInfo, "navavishkar_stay_table");
	}

	function navavishkar_stay_table_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function navavishkar_stay_table_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function navavishkar_stay_table_after_delete($selectedID, $memberInfo, &$args) {

	}

	function navavishkar_stay_table_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function navavishkar_stay_table_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function navavishkar_stay_table_batch_actions(&$args) {

		return [];
	}
