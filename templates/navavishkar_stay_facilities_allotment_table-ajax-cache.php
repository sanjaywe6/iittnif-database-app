<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'navavishkar_stay_facilities_allotment_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			item_lookup: <?php echo json_encode(['id' => $rdata['item_lookup'], 'value' => $rdata['item_lookup'], 'text' => $jdata['item_lookup']]); ?>,
			select_employee: <?php echo json_encode(['id' => $rdata['select_employee'], 'value' => $rdata['select_employee'], 'text' => $jdata['select_employee']]); ?>,
			alloted_by: <?php echo json_encode(['id' => $rdata['alloted_by'], 'value' => $rdata['alloted_by'], 'text' => $jdata['alloted_by']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for item_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'item_lookup' && d.id == data.item_lookup.id)
				return { results: [ data.item_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for select_employee */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'select_employee' && d.id == data.select_employee.id)
				return { results: [ data.select_employee ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for alloted_by */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'alloted_by' && d.id == data.alloted_by.id)
				return { results: [ data.alloted_by ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

