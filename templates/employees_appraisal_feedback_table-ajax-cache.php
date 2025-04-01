<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'employees_appraisal_feedback_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			employees_appraisal_lookup: <?php echo json_encode(['id' => $rdata['employees_appraisal_lookup'], 'value' => $rdata['employees_appraisal_lookup'], 'text' => $jdata['employees_appraisal_lookup']]); ?>,
			reviewing_officer: <?php echo json_encode(['id' => $rdata['reviewing_officer'], 'value' => $rdata['reviewing_officer'], 'text' => $jdata['reviewing_officer']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for employees_appraisal_lookup */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'employees_appraisal_lookup' && d.id == data.employees_appraisal_lookup.id)
				return { results: [ data.employees_appraisal_lookup ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for reviewing_officer */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'reviewing_officer' && d.id == data.reviewing_officer.id)
				return { results: [ data.reviewing_officer ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

