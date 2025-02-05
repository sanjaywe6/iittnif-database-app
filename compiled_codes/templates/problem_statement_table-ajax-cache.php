<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'problem_statement_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			select_program_id: <?php echo json_encode(['id' => $rdata['select_program_id'], 'value' => $rdata['select_program_id'], 'text' => $jdata['select_program_id']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for select_program_id */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'select_program_id' && d.id == data.select_program_id.id)
				return { results: [ data.select_program_id ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

