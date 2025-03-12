<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'employee_appraisal_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			employee_name: <?php echo json_encode(['id' => $rdata['employee_name'], 'value' => $rdata['employee_name'], 'text' => $jdata['employee_name']]); ?>,
			reporting_officer: <?php echo json_encode(['id' => $rdata['reporting_officer'], 'value' => $rdata['reporting_officer'], 'text' => $jdata['reporting_officer']]); ?>,
			reviewing_officer: <?php echo json_encode(['id' => $rdata['reviewing_officer'], 'value' => $rdata['reviewing_officer'], 'text' => $jdata['reviewing_officer']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for employee_name */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'employee_name' && d.id == data.employee_name.id)
				return { results: [ data.employee_name ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for reporting_officer */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'reporting_officer' && d.id == data.reporting_officer.id)
				return { results: [ data.reporting_officer ], more: false, elapsed: 0.01 };
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

