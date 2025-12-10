<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'td_projects_td_intellectual_property';

		/* data for selected record, or defaults if none is selected */
		var data = {
			source_of_ip: <?php echo json_encode(['id' => $rdata['source_of_ip'], 'value' => $rdata['source_of_ip'], 'text' => $jdata['source_of_ip']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for source_of_ip */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'source_of_ip' && d.id == data.source_of_ip.id)
				return { results: [ data.source_of_ip ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

