<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'file_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			data_str_key: <?php echo json_encode(['id' => $rdata['data_str_key'], 'value' => $rdata['data_str_key'], 'text' => $jdata['data_str_key']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for data_str_key */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'data_str_key' && d.id == data.data_str_key.id)
				return { results: [ data.data_str_key ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

