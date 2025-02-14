			<!-- Add footer template above here -->
			
			<div class="clearfix">
				</div>
				<?php if(!Request::val('Embedded')) { ?>
					<div style="height: 70px;" class="hidden-print"></div>
					<?php } ?>
					
				</div> <!-- /div class="container" -->

					<!-- IT Administrator Code -->

					<div style="background-color:#363839; display:flex; justify-content:center; align-items:center; text-alignment:center; padding:20px 20px; color:white;">
						<span style="font-size:15px;"><b>© 2024 | IIT Tirupati Navavishkar I-HUB Foundation (IITTNiF) | All Rights Reserved.</span></p>
					</div>
				<div class="container"><div class="row"><div id="sp-footer1" class="col-sm-12 col-md-12"><div class="sp-column"><span class="sp-copyright"></span></div></div></div></div>


		<?php if(!defined('APPGINI_SETUP') && is_file(__DIR__ . '/hooks/footer-extras.php')) { include(__DIR__ . '/hooks/footer-extras.php'); } ?>
		<script src="<?php echo PREPEND_PATH; ?>resources/lightbox/js/lightbox.min.js"></script>
	</body>
</html>