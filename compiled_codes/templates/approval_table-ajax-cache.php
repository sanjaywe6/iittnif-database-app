<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'approval_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			person_responsbility: <?php echo json_encode(['id' => $rdata['person_responsbility'], 'value' => $rdata['person_responsbility'], 'text' => $jdata['person_responsbility']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for person_responsbility */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'person_responsbility' && d.id == data.person_responsbility.id)
				return { results: [ data.person_responsbility ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

