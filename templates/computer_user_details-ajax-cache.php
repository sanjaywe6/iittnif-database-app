<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'computer_user_details';

		/* data for selected record, or defaults if none is selected */
		var data = {
			pc_id: <?php echo json_encode(['id' => $rdata['pc_id'], 'value' => $rdata['pc_id'], 'text' => $jdata['pc_id']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for pc_id */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'pc_id' && d.id == data.pc_id.id)
				return { results: [ data.pc_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

