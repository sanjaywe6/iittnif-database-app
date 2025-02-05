<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'goal_progress_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			goal_lookup: <?php echo json_encode(['id' => $rdata['goal_lookup'], 'value' => $rdata['goal_lookup'], 'text' => $jdata['goal_lookup']]); ?>,
			remarks_by: <?php echo json_encode(['id' => $rdata['remarks_by'], 'value' => $rdata['remarks_by'], 'text' => $jdata['remarks_by']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for goal_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'goal_lookup' && d.id == data.goal_lookup.id)
				return { results: [ data.goal_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for remarks_by */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'remarks_by' && d.id == data.remarks_by.id)
				return { results: [ data.remarks_by ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

