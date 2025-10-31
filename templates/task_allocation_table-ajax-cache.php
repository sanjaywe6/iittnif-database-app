<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'task_allocation_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			supervisor_name: <?php echo json_encode(['id' => $rdata['supervisor_name'], 'value' => $rdata['supervisor_name'], 'text' => $jdata['supervisor_name']]); ?>,
			assigned_to: <?php echo json_encode(['id' => $rdata['assigned_to'], 'value' => $rdata['assigned_to'], 'text' => $jdata['assigned_to']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for supervisor_name */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'supervisor_name' && d.id == data.supervisor_name.id)
				return { results: [ data.supervisor_name ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for assigned_to */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'assigned_to' && d.id == data.assigned_to.id)
				return { results: [ data.assigned_to ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

