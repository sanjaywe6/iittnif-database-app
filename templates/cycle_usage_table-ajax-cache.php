<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'cycle_usage_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			cycle_lookup: <?php echo json_encode(['id' => $rdata['cycle_lookup'], 'value' => $rdata['cycle_lookup'], 'text' => $jdata['cycle_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for cycle_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'cycle_lookup' && d.id == data.cycle_lookup.id)
				return { results: [ data.cycle_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

