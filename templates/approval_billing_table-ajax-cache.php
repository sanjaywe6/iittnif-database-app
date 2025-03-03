<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'approval_billing_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			approval_lookup: <?php echo json_encode(['id' => $rdata['approval_lookup'], 'value' => $rdata['approval_lookup'], 'text' => $jdata['approval_lookup']]); ?>,
			paid_by: <?php echo json_encode(['id' => $rdata['paid_by'], 'value' => $rdata['paid_by'], 'text' => $jdata['paid_by']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for approval_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'approval_lookup' && d.id == data.approval_lookup.id)
				return { results: [ data.approval_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for paid_by */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'paid_by' && d.id == data.paid_by.id)
				return { results: [ data.paid_by ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

