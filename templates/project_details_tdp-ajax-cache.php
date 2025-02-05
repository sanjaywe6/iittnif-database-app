<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'project_details_tdp';

		/* data for selected record, or defaults if none is selected */
		var data = {
			project_number: <?php echo json_encode(['id' => $rdata['project_number'], 'value' => $rdata['project_number'], 'text' => $jdata['project_number']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for project_number */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'project_number' && d.id == data.project_number.id)
				return { results: [ data.project_number ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

