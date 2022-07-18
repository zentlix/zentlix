$(document).ready(function () {
    initHTMLEditors();

    $('.collapse').on('show.coreui.collapse', function(){
        $('a[href="#' + $(this).attr('id') + '"]')
            .find('.c-icon')
            .toggleClass('cil-chevron-bottom cil-chevron-top');
    }).on('hide.coreui.collapse', function() {
        $('a[href="#' + $(this).attr('id') + '"]')
            .find('.c-icon')
            .toggleClass('cil-chevron-top cil-chevron-bottom');
    });

    $('.accordion i').on('click', function (e) {
        e.preventDefault();
    });
});

function initHTMLEditors() {
    var lang = document.documentElement.lang;

    switch (document.documentElement.lang) {
        case 'ua':
            lang = 'uk';
            break;
        // Other variants document.documentElement.lang !== language in ske
    }

    $('.cke-editor').each(function (index, element) {
        ClassicEditor.create(element, {
            language: lang,
            simpleUpload: {
                uploadUrl: '/backend/file/upload',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            },
        });
    });
}

function getFileSize(url) {
    var fileSize = '';
    var http = new XMLHttpRequest();
    http.open('HEAD', url, false);

    http.send(null);

    if (http.status === 200) {
        fileSize = http.getResponseHeader('content-length');
    }

    return fileSize;
}