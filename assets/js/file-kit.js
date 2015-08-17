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
            sleep: function (ms) {
                ms += new Date().getTime();
                while (new Date() < ms){}
            },
            init: function() {
                $deleteBtn.on('click', methods.removeItem);
                $input.fileupload({
                    name: $input.prop('id'),
                    dataType: 'json',
                    //add: function(e, data) {
                    //    var uploadErrors = [];
                    //    var acceptFileTypes = /^image\/(gif|jpe?g|png)$/i;
                    //    if(data.originalFiles[0]['type'].length && !acceptFileTypes.test(data.originalFiles[0]['type'])) {
                    //        uploadErrors.push('Not an accepted file type');
                    //    }
                    //    if(data.originalFiles[0]['size'].length && data.originalFiles[0]['size'] > 5000000) {
                    //        uploadErrors.push('Filesize is too big');
                    //    }
                    //    if(uploadErrors.length > 0) {
                    //        alert(uploadErrors.join("\n"));
                    //    } else {
                    //        data.submit();
                    //    }
                    //},
                    start: function (e, data) {
                        methods.toggleProgress();
                    },
                    done: function(e, data) {
                        methods.afterAddItem(e, data);
                    },
                    fail: function (e, data) {
                        console.log(data);
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
            afterRemoveItem: function() {
                methods.togglePreview();
                $hidden.val('');
            },
            afterAddItem: function(e, data) {
                $hidden.val(data.result);
                loadImage(
                    data.files[0],
                    function (img) {
                        $preview.find('img').replaceWith(img);
                        methods.togglePreview();
                        $deleteBtn.attr('href', options.deleteUrl + '?f=' + data.result);
                    }
                );
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
