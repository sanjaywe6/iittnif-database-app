<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'r_and_d_quarterly_progress_app';

		/* data for selected record, or defaults if none is selected */
		var data = {
			r_and_d_lookup: <?php echo json_encode(['id' => $rdata['r_and_d_lookup'], 'value' => $rdata['r_and_d_lookup'], 'text' => $jdata['r_and_d_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for r_and_d_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'r_and_d_lookup' && d.id == data.r_and_d_lookup.id)
				return { results: [ data.r_and_d_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

