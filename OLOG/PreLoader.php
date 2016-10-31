<?php

namespace OLOG;

class PreLoader
{
	static public function getPreLoaderJsHtml()
	{
		ob_start(); ?>
		<script>
			var PreLoader = {
				init: function () {
					this.preloader = '\
						<div id="preloader" style="z-index: 100000;position: fixed;top: 0;bottom: 0;left: 0;right: 0;display: none;background-color: rgba(255, 255, 255, 0.6);">\
							<svg style="position: absolute;top: 0;bottom: 0;left: 0;right: 0;display: block;width: 100px;height: 100px;margin: auto;" width="100px" height="100px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid" class="uil-ring-alt">\
								<rect x="0" y="0" width="100" height="100" fill="none" class="bk"></rect>\
								<circle cx="50" cy="50" r="40" stroke="rgba(0,0,0,0.5)" fill="none" stroke-width="10" stroke-linecap="round"></circle>\
								<circle cx="50" cy="50" r="40" stroke="#ffffff" fill="none" stroke-width="6" stroke-linecap="round">\
									<animate attributeName="stroke-dashoffset" dur="2s" repeatCount="indefinite" from="0" to="502"></animate>\
									<animate attributeName="stroke-dasharray" dur="2s" repeatCount="indefinite" values="150.6 100.4;1 250;150.6 100.4"></animate>\
								</circle>\
							</svg>\
						</div>\
					';

					this.$preloader = $(this.preloader);
					$('body').append(this.$preloader);
				},

				hide: function () {
					this.$preloader.hide();
				},

				show: function () {
					this.$preloader.show();
				}
			};
			PreLoader.init();
		</script>
		<?php
		$html = ob_get_clean();
		return $html;
	}
}