jQuery(function ($) {

    $('.td-gallery-button').on('click', function (e) {
        e.preventDefault();

        const frame = wp.media({
            title: 'Select Images',
            multiple: true
        });

        frame.on('select', function () {
            const ids = frame.state()
                .get('selection')
                .map(a => a.id)
                .join(',');

            $('#td_gallery').val(ids);
        });

        frame.open();
    });

});
