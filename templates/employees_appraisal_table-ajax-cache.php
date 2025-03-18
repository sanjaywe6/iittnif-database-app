<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'employees_appraisal_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			employee_details: <?php echo json_encode(['id' => $rdata['employee_details'], 'value' => $rdata['employee_details'], 'text' => $jdata['employee_details']]); ?>,
			employee_designation_reporting: <?php echo json_encode(['id' => $rdata['employee_designation_reporting'], 'value' => $rdata['employee_designation_reporting'], 'text' => $jdata['employee_designation_reporting']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for employee_details */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'employee_details' && d.id == data.employee_details.id)
				return { results: [ data.employee_details ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for employee_designation_reporting */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'employee_designation_reporting' && d.id == data.employee_designation_reporting.id)
				return { results: [ data.employee_designation_reporting ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

