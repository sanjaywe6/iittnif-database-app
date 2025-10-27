<?php
	include_once(__DIR__ . '/lib.php');

	handle_maintenance();

	// image paths
	$p = [
		'approval_table' => [
			'image' => getUploadDir(''),
		],
		'techlead_web_page' => [
			'img1' => getUploadDir(''),
			'img2' => getUploadDir(''),
		],
		'visiting_card_table' => [
			'front_img' => getUploadDir(''),
			'back_img' => getUploadDir(''),
		],
		'it_inventory_app' => [
			'custodian_signature' => getUploadDir(''),
		],
		'it_inventory_billing_details' => [
			'image' => getUploadDir(''),
		],
		'employees_personal_data_table' => [
			'profile_photo' => getUploadDir(''),
			'signature' => getUploadDir(''),
		],
		'leave_table' => [
			'upload_img' => getUploadDir(''),
		],
		'work_from_home_table' => [
			'upload_img' => getUploadDir(''),
		],
		'payment_track_details_table' => [
			'upload_scanned_file_1' => getUploadDir(''),
			'upload_scanned_file_2' => getUploadDir(''),
		],
		'newsletter_table' => [
			'img1' => getUploadDir(''),
			'img2' => getUploadDir(''),
		],
	];

	if(!count($p)) exit;

	// receive user input
	$t = Request::val('t'); // table name
	$f = Request::val('f'); // field name
	$v = Request::val('v'); // thumbnail view type: 'tv' or 'dv'
	$i = Request::val('i'); // original image file name

	// validate input
	if(!in_array($t, array_keys($p)))  getImage();
	if(!in_array($f, array_keys($p[$t])))  getImage();
	if(!preg_match('/^[a-z0-9_-]+\.(jpg|jpeg|gif|png|webp)$/i', $i, $m)) getImage();
	if($v != 'tv' && $v != 'dv')   getImage();
	if($i == 'blank.gif') getImage();

	$img = $p[$t][$f] . $i;
	$thumb = str_replace(".{$m[1]}ffffgggg", "_$v.{$m[1]}", $img . 'ffffgggg');

	// if thumbnail exists and the user is not admin, output it without rebuilding the thumbnail
	if(getImage($thumb) && !getLoggedAdmin())  exit;

	// otherwise, try to create the thumbnail and output it
	if(!Thumbnail::create($img, getThumbnailSpecs($t, $f, $v)))  getImage();
	if(!getImage($thumb))  getImage();

	function getImage($img = '') {
		if(!$img) { // default image to return
			$img = './photo.gif';
			$exit = true;
		}

		/* force caching */
		$last_modified = @filemtime($img);
		if($last_modified) {
			$last_modified_gmt = gmdate('D, d M Y H:i:s', $last_modified) . ' GMT';
			$expires_gmt = gmdate('D, d M Y H:i:s', $last_modified + 864000) . ' GMT';
			$headers = (function_exists('getallheaders') ? getallheaders() : $_SERVER);
			if(isset($headers['If-Modified-Since']) && (strtotime($headers['If-Modified-Since']) == $last_modified)) {
				@header("Last-Modified: {$last_modified_gmt}", true, 304);
				@header("Cache-Control: private, max-age=864000", true);
				@header("Expires: {$expires_gmt}");
				exit;
			}
		}

		$thumbInfo = @getimagesize($img);
		$fp = @fopen($img, 'rb');
		if($thumbInfo && $fp) {
			$file_size = filesize($img);
			@header("Last-Modified: {$last_modified_gmt}", true, 200);
			@header("Cache-Control: private, max-age=864000", true);
			@header("Content-type: {$thumbInfo['mime']}");
			@header("Content-Length: {$file_size}");
			@header("Expires: {$expires_gmt}");
			ob_end_clean();
			@fpassthru($fp);
			if(!$exit) return true; else exit;
		}

		if(!$exit) return false; else exit;
	}
