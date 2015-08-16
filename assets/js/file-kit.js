(function ( $ ) {
    jQuery.fn.yiiFileKit = function(options) {

        var $input = this;
        var $container = $input.closest('.file-kit');
        var $preview = $container.find('.preview');
        var $upload = $container.find('.upload');
        var $removeBtn = $preview.find('a');
        var $image = $preview.find('img');
        var $hidden = $container.find("input[type='hidden']");

        var methods = {
            init: function() {
                $removeBtn.on('click', methods.removeItem);
                $input.fileupload({
                    name: $input.prop('id'),
                    dataType: 'json',
                    done: function(e, data) { methods.afterAddItem(e, data); }
                });
            },
            removeItem: function(e) {
                var $this = $(this);
                e.preventDefault();
                $.ajax({ url: $this.attr('href'), type: 'GET', success: function() { methods.afterRemoveItem(); }});
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
                        $image.replaceWith(img);
                        methods.togglePreview();
                        $removeBtn.attr('href', options.removeUrl + '?f=' + data.result);
                    },
                    {maxWidth: 600}
                );
            },
            togglePreview: function() {
                $preview.toggleClass('hidden');
                $upload.toggleClass('hidden');
            }
        };

        methods.init.apply(this);
        return this;
    }
})(jQuery);
