<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'leave_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			approved_by: <?php echo json_encode(['id' => $rdata['approved_by'], 'value' => $rdata['approved_by'], 'text' => $jdata['approved_by']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for approved_by */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'approved_by' && d.id == data.approved_by.id)
				return { results: [ data.approved_by ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

