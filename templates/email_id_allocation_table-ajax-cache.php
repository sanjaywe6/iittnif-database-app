<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'email_id_allocation_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			reporting_manager: <?php echo json_encode(['id' => $rdata['reporting_manager'], 'value' => $rdata['reporting_manager'], 'text' => $jdata['reporting_manager']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for reporting_manager */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'reporting_manager' && d.id == data.reporting_manager.id)
				return { results: [ data.reporting_manager ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

