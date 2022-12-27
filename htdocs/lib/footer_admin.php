	        </div>
		</div>
		<!-- End Body Content -->

        <!-- Start Footer -->
        <div class="kt-footer kt-grid__item" id="kt_footer">
	        <div class="kt-container ">
		        <div class="kt-footer__wrapper">
			        <div class="kt-footer__copyright">
				        Copyright &copy; 2020&nbsp;&nbsp; <a href="<?php echo $config['web']['url'] ?>" target="_blank" class="kt-link"><?php echo $data['short_title']; ?></a>.
			        </div>
		        </div>
	        </div>
		</div>
		<!-- End Footer -->

		<!-- Global Config (global config for global JS sciprts) -->
		<script>
            var KTAppOptions = {"colors":{"state":{"brand":"#366cf3","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
		</script>
		<!-- End Global Config -->

		<!-- Global Theme Bundle (used by all pages) -->
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/global/plugins-2.bundle.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/scripts-2.bundle.js" type="text/javascript"></script>
		<!-- End Global Theme Bundle -->

		<!-- Page Vendors (used by this page) -->
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/custom/fullcalendar/fullcalendar.bundle.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/plugins/custom/gmaps/gmaps.js" type="text/javascript"></script>
		<!-- End Page Vendors -->

		<!-- Page Scripts (used by this page) -->
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/custom/chat/chat.js" type="text/javascript"></script>
		<script src="<?php echo $config['web']['url'] ?>assets/js/pages/dashboard-2.js" type="text/javascript"></script>
		<!-- End Page Scripts -->

		</body>

</html>