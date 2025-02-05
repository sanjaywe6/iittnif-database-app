<?php
	// For help on using hooks, please refer to https://bigprof.com/appgini/help/advanced-topics/hooks/

	function action_actor_init(&$options, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_header($contentType, $memberInfo, &$args) {
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

	function action_actor_footer($contentType, $memberInfo, &$args) {
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

	function action_actor_before_insert(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_after_insert($data, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_before_update(&$data, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_after_update($data, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_before_delete($selectedID, &$skipChecks, $memberInfo, &$args) {

		return TRUE;
	}

	function action_actor_after_delete($selectedID, $memberInfo, &$args) {

	}

	function action_actor_dv($selectedID, $memberInfo, &$html, &$args) {

	}

	function action_actor_csv($query, $memberInfo, &$args) {

		return $query;
	}
	function action_actor_batch_actions(&$args) {

		return [];
	}
