<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function projects_td_technology_products_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_header($contentType, $memberInfo, &$args) {
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

	function projects_td_technology_products_footer($contentType, $memberInfo, &$args) {
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

	function projects_td_technology_products_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_before_update(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function projects_td_technology_products_after_delete($selectedID, $memberInfo, &$args) {

	}

	function projects_td_technology_products_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function projects_td_technology_products_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function projects_td_technology_products_batch_actions(&$args) {

		return [];
	}
