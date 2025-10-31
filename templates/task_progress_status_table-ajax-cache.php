<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'task_progress_status_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			task_lookup: <?php echo json_encode(['id' => $rdata['task_lookup'], 'value' => $rdata['task_lookup'], 'text' => $jdata['task_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for task_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'task_lookup' && d.id == data.task_lookup.id)
				return { results: [ data.task_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

