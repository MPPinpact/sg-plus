/*Template Name: Able Pro Responsive Bootstrap 4 Admin Template
 Author: Phoenixcoded
 Email: phoenixcoded@gmail.com
 File: main.js
 */
'use strict';
$(window).on('load', function() {
    var $window = $(window);
    $('.loader-bar').animate({ width:$window.width()},2000);
    
    setTimeout(function() {
        while ($('.loader-bar').width() == $window.width()) {
            removeloader();
            break;
        }
    }, 2500);

    //Welcome Message (not for login page)
    function notify(message, type) {
        $.growl({
            message: message
        }, {
            type: type,
            allow_dismiss: false,
            label: 'Cancel',
            className: 'btn-xs btn-inverse',
            placement: {
                from: 'bottom',
                align: 'right'
            },
            delay: 2500,
            animate: {
                enter: 'animated fadeInRight',
                exit: 'animated fadeOutRight'
            },
            offset: {
                x: 30,
                y: 30
            }
        });
    };

    notify('Bienvenidos a SGG Plus', 'inverse');
    $('.loader-bg').fadeOut('slow');

});

function removeloader(){
    $('.loader-bg').fadeOut('slow', function() {
        $('.loader-bg').remove();
    });
};

$(document).ready(function() {


});

// toggle full screen
function toggleFullScreen() {
    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
}


// Start [ Menu-bottom ]
$(document).ready(function() {
    $(".dropup-mega, .dropup").hover(function() {
        var dropdownMenu = $(this).children(".dropdown-menu");
        $(this).toggleClass("open");
    });
});
// End [ Menu ]