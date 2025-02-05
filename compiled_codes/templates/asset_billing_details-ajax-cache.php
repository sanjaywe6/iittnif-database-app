<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'asset_billing_details';

		/* data for selected record, or defaults if none is selected */
		var data = {
			asset_lookup: <?php echo json_encode(['id' => $rdata['asset_lookup'], 'value' => $rdata['asset_lookup'], 'text' => $jdata['asset_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for asset_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'asset_lookup' && d.id == data.asset_lookup.id)
				return { results: [ data.asset_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

