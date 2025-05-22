<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function techlead_web_page_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function techlead_web_page_header($contentType, $memberInfo, &$args) {
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

	function techlead_web_page_footer($contentType, $memberInfo, &$args) {
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

	function techlead_web_page_before_insert(&$data, $memberInfo, &$args) {

		return approvalBeforeInsert($data, $memberInfo);
	}

	function techlead_web_page_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function techlead_web_page_before_update(&$data, $memberInfo, &$args) {

		return approvalBeforeUpdate($data, $memberInfo, "techlead_web_page");
	}

	function techlead_web_page_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function techlead_web_page_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function techlead_web_page_after_delete($selectedID, $memberInfo, &$args) {

	}

	function techlead_web_page_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function techlead_web_page_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function techlead_web_page_batch_actions(&$args) {

		return [];
	}
