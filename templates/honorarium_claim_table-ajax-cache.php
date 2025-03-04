<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'honorarium_claim_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			coordinated_by_tih_user: <?php echo json_encode(['id' => $rdata['coordinated_by_tih_user'], 'value' => $rdata['coordinated_by_tih_user'], 'text' => $jdata['coordinated_by_tih_user']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for coordinated_by_tih_user */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'coordinated_by_tih_user' && d.id == data.coordinated_by_tih_user.id)
				return { results: [ data.coordinated_by_tih_user ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

