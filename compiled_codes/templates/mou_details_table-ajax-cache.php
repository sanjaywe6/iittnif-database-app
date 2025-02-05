<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'mou_details_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			assigned_mou_to: <?php echo json_encode(['id' => $rdata['assigned_mou_to'], 'value' => $rdata['assigned_mou_to'], 'text' => $jdata['assigned_mou_to']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for assigned_mou_to */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'assigned_mou_to' && d.id == data.assigned_mou_to.id)
				return { results: [ data.assigned_mou_to ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

