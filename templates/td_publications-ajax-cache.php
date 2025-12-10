<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'td_publications';

		/* data for selected record, or defaults if none is selected */
		var data = {
			publications_and_intellectual_activities_details: <?php echo json_encode(['id' => $rdata['publications_and_intellectual_activities_details'], 'value' => $rdata['publications_and_intellectual_activities_details'], 'text' => $jdata['publications_and_intellectual_activities_details']]); ?>,
			source_of_ip: <?php echo json_encode(['id' => $rdata['source_of_ip'], 'value' => $rdata['source_of_ip'], 'text' => $jdata['source_of_ip']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for publications_and_intellectual_activities_details */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'publications_and_intellectual_activities_details' && d.id == data.publications_and_intellectual_activities_details.id)
				return { results: [ data.publications_and_intellectual_activities_details ], more: false, elapsed: 0.01 };
			return false;
		});

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

