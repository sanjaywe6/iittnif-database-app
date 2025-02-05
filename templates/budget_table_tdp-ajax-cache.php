<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'budget_table_tdp';

		/* data for selected record, or defaults if none is selected */
		var data = {
			project_id: <?php echo json_encode(['id' => $rdata['project_id'], 'value' => $rdata['project_id'], 'text' => $jdata['project_id']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for project_id */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'project_id' && d.id == data.project_id.id)
				return { results: [ data.project_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

