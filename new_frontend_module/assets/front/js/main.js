// Digital Bank main jQuery

(function ($) {
    'use strict';
    // preloader Active
    $(window).on('load', function (event) {
        $('.preloader').delay(500).fadeOut(500);
    });

    // Lucide Icons Activation
    lucide.createIcons();

    // Nice Select
    $('.langu-swit').niceSelect();
    $('.page-count').niceSelect();

    //Sidebar Toggle
    $(".offcanvas-close,.offcanvas-overlay").on("click", function () {
        $(".offcanvas-area").removeClass("info-open");
        $(".offcanvas-overlay").removeClass("overlay-open");
    });

    $(".sidebar-toggle").on("click", function () {
        $(".offcanvas-area").addClass("info-open");
        $(".offcanvas-overlay").addClass("overlay-open");
    });

    //Body overlay Js
    $(".body-overlay").on("click", function () {
        $(".offcanvas-area").removeClass("opened");
        $(".body-overlay").removeClass("opened");
    });

    // Header sticky
    $(window).scroll(function () {
        if ($(this).scrollTop() > 250) {
            $("#header-sticky").addClass("active-sticky");
        } else {
            $("#header-sticky").removeClass("active-sticky");
        }
    });

    // For language
    $(document).on('click', '#header-language-toggle', function (e) {
        e.stopPropagation(); // Prevent the event from bubbling up
        $(".header-language ul").toggleClass("lang-list-open");
    });

    // Click outside handler
    $(document).on('click', function (e) {
        // Check if the click occurred outside the currency toggle and its associated ul
        if (!$(e.target).closest('#header-currency-toggle').length && !$(e.target).closest('.header-currency ul').length) {
            $(".header-currency ul").removeClass("lang-list-open");
        }
        // Check if the click occurred outside the language toggle and its associated ul
        if (!$(e.target).closest('#header-language-toggle').length && !$(e.target).closest('.header-language ul').length) {
            $(".header-language ul").removeClass("lang-list-open");
        }
    });

    // Data Css js
    $("[data-background").each(function () {
        $(this).css(
            "background-image",
            "url( " + $(this).attr("data-background") + "  )"
        );
    });

    $("[data-width]").each(function () {
        $(this).css("width", $(this).attr("data-width"));
    });

    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

    // Enabling Tooltip
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

    // Side Nav Toggle
    $(".site-sidebar-toggle").on('click', function () {
        $(".user-sidebar").toggleClass("nav-unfolded");
    });

    // Invoice Options
    $('.add-new-option').on('click', function () {
        var optionss =
            `<div class="row">
          <div class="col-xl-8">
            <div class="input-group">
              <input type="text" class="form-control itemname"  name="name[]" placeholder="Item Name">
            </div>
          </div>
          <div class="col-xl-3">
            <div class="input-group">
              <input type="text" class="form-control amount"  name="amount[]" placeholder="Amount">
            </div>
          </div>
          <div class="col-xl-1">
            <button type="button" class="invoice-option-btn add-new-option remove-optionss"><i class="anticon anticon-minus"></i></button>
          </div>
      </div>`
        $('.optionss').append(optionss);
    });

    // Invoice Options Remove
    $(document).on('click', '.remove-optionss', function () {
        $(this).closest('.row').remove();
    });


    $('.currency').on('change', function () {
        var selected = $('.currency option:selected')
        if (selected.val() == '') {
            $('.itemname').attr('disabled', true)
            $('.amount').attr('disabled', true)
            $('.add-new-option').addClass('disabled')
            return false
        } else {
            $('.itemname').attr('disabled', false)
            $('.amount').attr('disabled', false)
            $('.add-new-option').removeClass('disabled')
        }
        $('.currencyCode').text(selected.data('code'))
    })



    $(document).on('keyup', '.amount', function () {
        var total = 0;
        $('.amount').each(function (e) {
            if ($(this).val() != '') {
                total += parseFloat($(this).val());
            }
            $('.totalAmount').text(total.toFixed(2))
        })
    })

})(jQuery);

// Image Preview
function runImagePreviewer() {
    $('input[type="file"]').each(function () {
        // Refs
        var $file = $(this),
            $label = $file.next('label'),
            $labelText = $label.find('span'),
            labelDefault = $labelText.text();

        // When a new file is selected
        $file.on('change', function (event) {
            var fileName = $file.val().split('\\').pop(),
                tmppath = URL.createObjectURL(event.target.files[0]);
            //Check successfully selection
            if (fileName) {
                $label
                    .addClass('file-ok')
                    .css('background-image', 'url(' + tmppath + ')');
                $labelText.text(fileName);
            } else {
                $label.removeClass('file-ok');
                $labelText.text(labelDefault);
            }
        });
    });
}

runImagePreviewer();
