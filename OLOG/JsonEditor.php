<?php

namespace OLOG;

class JsonEditor
{

	/**
	 * @return string
	 */
	static public function jsoneditorJsHtml($elem_id = '.js-json-editor')
	{
		static $include_script;

		$html = '';

		if (!isset($include_script)) {

			$include_script = false;

			/*  Нужно установить плаг через компосер
				{
					"repositories": [
						{
							"type": "package",
							"package": {
								"name": "josdejong/jsoneditor",
								"version": "5.5.10",
								"source": {
									"type": "git",
									"url": "https://github.com/josdejong/jsoneditor.git",
									"reference": "v5.5.10"
								}
							}
						}
					],
					"require": {
						"robloach/component-installer": "*",
						"josdejong/jsoneditor": "5.5.*"
					},
					"config": {
						"component-dir": "public/vendor",
						"component-baseurl": "/vendor"
					},
					"extra": {
						"component": {
							"josdejong/jsoneditor": {
								"files": [
									"dist/*",
									"dist/img/*"
								]
							}
						}
					}
				}
			*/

			ob_start(); ?>
			<link href="/vendor/jsoneditor/dist/jsoneditor.min.css" rel="stylesheet" type="text/css">
			<script src="/vendor/jsoneditor/dist/jsoneditor.min.js"></script>
			<script>
				var OLOG = OLOG || {};
				OLOG.jsoneditor = OLOG.jsoneditor || {
						init: function () {
							$(<?= $elem_id ?>).each(OLOG.jsoneditor.initJsonEditor);
						},

						initJsonEditor: function () {

							var $this = $(this);
							var $jsoneditor = $('<div>', {
								style: 'height: 400px;'
							});

							$this.after($jsoneditor);

							var options = {
								onChange: function () {
									$this.val(JSON.stringify(editor.get(), null, 2));
								}
							};

							// set json
							var json = JSON.parse($this.val());
							// get json
							var editor = new JSONEditor($jsoneditor[0], options, json);
						}
					};
				OLOG.jsoneditor.init();
			</script>
			<?php
			$html = ob_get_clean();

		}
		return $html;
	}
}