$(document).ready(function() {

    let show_item = '.news-pagination__show-item';

    if ($(show_item).attr('data-page-end') === $(show_item).attr('data-page')) {
        $(show_item).hide();
    }

    $(show_item).click(function() {

        let page = parseInt($(this).attr('data-page'));
        let number = parseInt($(this).attr('data-number'));
        let end = parseInt($(this).attr('data-page-end'));

        if (!number) {
            number = ++page;
        } else {
            ++number;
        }

        if (end === page || end === number) {
            $(show_item).hide();
            return false;
        }

        $.ajax({
            url:   '?page=' + number,
            dataType: "html",
            success: function(data) {

                $('.news-block').append($(data).find('.news-block').html());
                $(show_item).attr('data-number', number);
            }
        });

        return false;
    })

})
