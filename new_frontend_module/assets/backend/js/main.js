// iDevs Admin
(function ($) {


    'use strict';

    // Lucide Icons Activation
    lucide.createIcons();

    // Side Nav Collapse
    $(".sidebar-toggle").on('click', function () {
        $(".layout").toggleClass("nav-folded");
    });

    // Side Nav Hover
    $(".side-nav").on('mouseenter mouseleave', function () {
        $(".nav-folded .side-nav").toggleClass("side-nav-hover");
    });

    // Side Nav dropdowns
    $('.side-nav-dropdown > .dropdown-link').on('click', function () {
        $(".dropdown-items").slideUp(400);
        if (
            $(this)
                .parent()
                .hasClass("show")
        ) {
            $(".side-nav-dropdown").removeClass("show");
            $(this)
                .parent()
                .removeClass("show");
        } else {
            $(".side-nav-dropdown").removeClass("show");
            $(this)
                .next(".dropdown-items")
                .slideDown(400);
            $(this)
                .parent()
                .addClass("show");
        }
    });


    // Counter For Dashboard Card
    $('.count').counterUp({
        delay: 10,
        time: 2000
    });


// Image Preview
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
                $('.'+ $file.attr('name')).removeAttr('hidden');
            } else {
                $label.removeClass('file-ok');
                $labelText.text(labelDefault);
            }
        });
    });


    // Custom Toaster
    $('.toast__close').on('click', function (e) {
        e.preventDefault();
        var parent = $(this).parent('.site-toaster');
        parent.fadeOut("slow", function () {
            $(this).remove();
        });
    });


// ToolTip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })


    $('.site-nice-select').niceSelect();
    $('.site-select').select2();

    //Text Editor
    $(document).ready(function () {
        $('.summernote').summernote({
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'italic', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['link', 'picture',]],
                ['view',],
            ],
            styleTags: [
                'p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
            ],
            placeholder: 'Write...',
            tabsize: 2,
            height: 220,
            codeviewFilter: false,
            codeviewIframeFilter: true
        });
    });

})(jQuery);
