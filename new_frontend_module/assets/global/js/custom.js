function validateNumber(e) {
    "use strict";
    const pattern = /^[0-9]$/;
    return pattern.test(e.key)
}

function validateDouble($value) {
    "use strict";
    return $value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');
}

function isWhatPercentOf(numA, numB) {
    "use strict";
    return (numA / numB) * 100;
}

function calPercentage(num, percentage) {
    "use strict";
    const result = num * (percentage / 100);
    return parseFloat(result.toFixed(2));
}

function imagePreview() {
    "use strict";
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

        $('.remove-img').removeAttr('hidden');
    });
}

function imagePreviewAdd(title) {
    var base_url = window.location.origin;

    var previewImage = $("#image-old");
    previewImage.css({
        'background-image': 'url(' + base_url + '/assets/' + title + ')'
    });
    previewImage.addClass("file-ok");
}




function tNotify(type, message,title = null) {
    new Notify({
        status: type,
        title: title ?? type,
        text: message,
        effect: 'slide',
        speed: 300,
        customClass: '',
        customIcon: getIcon(type),
        showIcon: true,
        showCloseButton: true,
        autoclose: true,
        autotimeout: 4000,
        gap: 20,
        distance: 20,
        type: 1,
        position: 'right top',
        customWrapper: '',
    })

}

function imageRemoveWithRoute(targetCode=null,route = null,token) {

    $('.remove-img').on('click', function () {

        var target = $(this).data('des');
        $(this).attr('hidden', true);

        $("input[name='" + target + "']").val(null);
        if (null != route){
            $.ajax({
                type: "POST",
                url: route,
                data: {
                    _token: token,
                    target_code: targetCode,
                    field_name: target,
                    type:'img-remove'
                },
                success: function () {
                    imagePreviewRemove(target,'Update Image');
                }
            });
        }
        imagePreviewRemove(target,'Update Image');
    });
}


function imagePreviewRemove(target,title) {
    "use strict";
    var image = $("#"+target)
    image.removeAttr("style");
    image.removeClass("file-ok");
    image.children("span").html(title);

}
function getIcon(type) {
    "use strict";

    let icon;
    switch (type) {
        case 'success':
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><polyline points="20 6 9 17 4 12"/></svg>';
            break;
        case 'info':
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-megaphone"><path d="m3 11 18-5v12L3 14v-3z"/><path d="M11.6 16.8a3 3 0 1 1-5.8-1.6"/></svg>';
            break;
        case 'warning':
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-alert-triangle"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" x2="12" y1="9" y2="13"/><line x1="12" x2="12.01" y1="17" y2="17"/></svg>';
            break;
        case 'error':
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-server-crash"><path d="M6 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2"/><path d="M6 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-2"/><path d="M6 6h.01"/><path d="M6 18h.01"/><path d="m13 6-4 6h6l-4 6"/></svg>';
            break;
        default:
            icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check"><polyline points="20 6 9 17 4 12"/></svg>';
            break;
    }
    return icon;
}

function sumArrayValues(arr) {
    "use strict";
    let sum = 0;
    for (let i = 0; i < arr.length; i++) {
        sum += arr[i];
    }
    return sum;
}

function copyRef(idName) {
    "use strict";
    /* Get the text field */
    var copyApi = document.getElementById(idName);
    /* Select the text field */
    copyApi.select();
    copyApi.setSelectionRange(0, 999999999); /* For mobile devices */
    /* Copy the text inside the text field */
    document.execCommand('copy');
    $('#copy').text($('#copied').val())
}

// Dismiss Notify
$('#notify-dismiss').on('click',function(){
    "use strict";
    var parent = $('.admin-toaster');
    parent.fadeOut("slow", function () {
        $(this).remove();
    });
});

setTimeout(() => {
    var parent = $('.admin-toaster');
    parent.fadeOut("slow", function () {
        $(this).remove();
    });
}, 5000);



