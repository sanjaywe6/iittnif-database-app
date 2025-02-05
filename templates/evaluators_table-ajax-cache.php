<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'evaluators_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			evaluation_lookup: <?php echo json_encode(['id' => $rdata['evaluation_lookup'], 'value' => $rdata['evaluation_lookup'], 'text' => $jdata['evaluation_lookup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for evaluation_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'evaluation_lookup' && d.id == data.evaluation_lookup.id)
				return { results: [ data.evaluation_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

