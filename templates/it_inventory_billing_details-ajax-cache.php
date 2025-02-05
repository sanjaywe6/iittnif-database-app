<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'it_inventory_billing_details';

		/* data for selected record, or defaults if none is selected */
		var data = {
			it_inventory_lookup: <?php echo json_encode(['id' => $rdata['it_inventory_lookup'], 'value' => $rdata['it_inventory_lookup'], 'text' => $jdata['it_inventory_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for it_inventory_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'it_inventory_lookup' && d.id == data.it_inventory_lookup.id)
				return { results: [ data.it_inventory_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

