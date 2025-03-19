<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'cycle_table';

		/* data for selected record, or defaults if none is selected */
		var data = {
			responsible_contact_person: <?php echo json_encode(['id' => $rdata['responsible_contact_person'], 'value' => $rdata['responsible_contact_person'], 'text' => $jdata['responsible_contact_person']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for responsible_contact_person */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'responsible_contact_person' && d.id == data.responsible_contact_person.id)
				return { results: [ data.responsible_contact_person ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

