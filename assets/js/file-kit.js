/*!
 * Simple upload file kit based on BlueImp jQuery plugin.
 * Basically it's a simplified version of trntv/yii2-file-kit plugin.
 * Depends on jQuery and jsurl libraries.
 * @see https://github.com/trntv/yii2-file-kit
 * @see https://github.com/Mikhus/jsurl
 * @license MIT
 * @author Vetoni <vetoni.github@gmail.com>
 */

(function ( $ ) {
    jQuery.fn.yiiFileKit = function(options) {

        var $input = this;
        var $container = $input.closest('.file-kit');
        var $preview = $container.find('.preview');
        var $upload = $container.find('.upload');
        var $deleteBtn = $preview.find('a');
        var $hidden = $container.find("input[type='hidden']");
        var $progress = $container.find('.progress-indicator');

        var methods = {
            init: function() {

                if (options.width) {
                    $container.css('width', options.width);
                }
                if (options.height) {
                    $container.css('height', options.height);
                }

                $input.fileupload({
                    name: $input.prop('id'),
                    dataType: 'json',
                    add: function(e, data) {
                        methods.addItem(e, data);
                    },
                    start: function (e, data) {
                        methods.toggleProgress();
                    },
                    done: function(e, data) {
                        methods.afterAddItem(e, data);
                    },
                    fail: function (e, data) {
                        console.log(data.errorThrown);
                    },
                    always: function (e, data) {
                        methods.toggleProgress();
                    },
                    progressall: function (e, data) {
                        methods.sleep(100);
                        var progress = parseInt(data.loaded / data.total * 100, 10);
                        $progress.text(progress + '%');
                    }
                });
                $deleteBtn.on('click', methods.removeItem);
            },
            addItem: function(e, data) {
                var uploadErrors = [];

                var acceptFileTypes = options.acceptFileTypes ?
                    new RegExp(options.acceptFileTypes) : null;

                var maxFileSize = options.maxFileSize ?
                    options.maxFileSize : 5 * 1024 * 1024;

                if(acceptFileTypes && data.originalFiles.length
                    && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                    uploadErrors.push('Not an accepted file type');
                }
                if(data.originalFiles.length && data.originalFiles[0]['size'] > maxFileSize) {
                    uploadErrors.push('Filesize is too big: ' + data.originalFiles[0]['size'] + ' Bytes');
                }
                if(uploadErrors.length > 0) {
                    console.log(uploadErrors.join("\n"));
                } else {
                    data.submit();
                }
            },
            removeItem: function(e) {
                var $this = $(this);
                e.preventDefault();
                $.ajax({
                    url: $this.attr('href'),
                    type: 'GET',
                    success: function() {
                        methods.afterRemoveItem();
                    }
                });
            },
            afterAddItem: function(e, data) {
                $hidden.val(data.result);
                loadImage(
                    data.files[0],
                    function (img) {
                        $preview.find('img').replaceWith(img);
                        methods.togglePreview();
                        var $newUrl = methods.setUrlParam($deleteBtn.attr('href'), 'f', data.result);
                        $deleteBtn.attr('href', $newUrl);
                    }
                );
            },
            afterRemoveItem: function() {
                methods.togglePreview();
                $hidden.val('');
                methods.removeUrlParam($deleteBtn.attr('href'), 'f');
            },
            removeUrlParam: function(path, param) {
                var url = new Url(path);
                delete url.query[param];
                return url;
            },
            setUrlParam: function(path, param, value) {
                var url = new Url(path);
                delete url.query[param];
                url.query[param] = value;
                return url;
            },
            togglePreview: function() {
                $preview.toggleClass('hidden');
                $upload.toggleClass('hidden');
            },
            toggleProgress: function() {
                $upload.children().not('.progress-indicator').toggleClass('hidden');
                $progress.toggleClass('hidden');
            }
        };

        methods.init.apply(this);
        return this;
    }
})(jQuery);
