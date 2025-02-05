<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'travel_cab_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			travel_details: <?php echo json_encode(['id' => $rdata['travel_details'], 'value' => $rdata['travel_details'], 'text' => $jdata['travel_details']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for travel_details */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'travel_details' && d.id == data.travel_details.id)
				return { results: [ data.travel_details ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

