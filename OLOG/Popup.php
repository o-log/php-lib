<?php

namespace OLOG;

class Popup
{
    static public function popupJsHtml($namespace = 'OLOG')
    {
        static $include_script;

        $html = '';

        if (!isset($include_script)) {

            $include_script = false;

            ob_start(); ?>
			<script>
                var <?= $namespace ?> = <?= $namespace ?> || {};
                <?= $namespace ?>.popup = new function () {
                    var popup_this = this;

                    this.conf = {
                        popup_id: 'layout_popup',
                        popup_class: 'layout-popup',
                        content_class: 'popup-content',
                        wrapper_class: 'popup-wrapper',
                        close_btn_class: 'popup-close',
                        msg_class: 'popup-msg'
                    };

                    this.$popup_box = '';

                    this.show = function (content_obj, callback) {
                        if (popup_this.$popup_box != '') {
                            popup_this.hide();
                        }

                        $(window).trigger('popup.beforeShow');

                        if (typeof content_obj != 'object') {
                            var content_obj = $(content_obj);
                        }

                        var $content = $('<div>', {
                            class: popup_this.conf.content_class,
                            html: $.merge(popup_this.closeBtn(), content_obj)
                        });

                        var $wrapper = $('<div>', {
                            class: popup_this.conf.wrapper_class,
                            html: $content
                        });

                        popup_this.$popup_box = $('<div>', {
                            id: popup_this.conf.popup_id,
                            class: popup_this.conf.popup_class,
                            html: $wrapper
                        });

                        popup_this.$popup_box.appendTo('body');

                        popup_this.$popup_box.find($content).on('click', function (e) {
                            e.stopPropagation();
                        });

                        popup_this.$popup_box.unbind('click').on('click', function (e) {
                            popup_this.hide();
                        });

                        $('html').addClass('popup-show');

                        if (callback) {
                            callback();
                        }

                        $(window).trigger('popup.afterShow');
                    };

                    this.hide = function (callback) {
                        if (popup_this.$popup_box == '') {
                            return;
                        }

                        $(window).trigger('popup.beforeHide');

                        $('html').removeClass('popup-show');
                        popup_this.$popup_box.remove();
                        popup_this.$popup_box = '';

                        if (callback) {
                            callback();
                        }

                        $(window).trigger('popup.afterHide');
                    };

                    this.closeBtn = function () {
                        var $btn = $('<div>', {
                            class: popup_this.conf.close_btn_class
                        });
                        return $btn.on('click', function (e) {
                            e.preventDefault();
                            popup_this.hide();
                        });
                    };

                    this.showMsg = function (msg) {
                        if (msg == '') {
                            return false;
                        }

                        var $msg = $('<div>', {
                            class: popup_this.conf.msg_class,
                            html: msg
                        });

                        popup_this.show($msg);
                    };
                };
			</script>
            <?php
            $html = ob_get_clean();

        }
        return $html;
    }
}