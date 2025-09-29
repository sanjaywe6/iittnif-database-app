<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'work_from_home_tasks_app';

		/* data for selected record, or defaults if none is selected */
		var data = {
			work_from_home_details: <?php echo json_encode(['id' => $rdata['work_from_home_details'], 'value' => $rdata['work_from_home_details'], 'text' => $jdata['work_from_home_details']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for work_from_home_details */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'work_from_home_details' && d.id == data.work_from_home_details.id)
				return { results: [ data.work_from_home_details ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

