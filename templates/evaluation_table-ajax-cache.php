<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'evaluation_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			select_startup: <?php echo json_encode(['id' => $rdata['select_startup'], 'value' => $rdata['select_startup'], 'text' => $jdata['select_startup']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for select_startup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'select_startup' && d.id == data.select_startup.id)
				return { results: [ data.select_startup ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

