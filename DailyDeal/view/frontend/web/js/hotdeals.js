
define([
    'jquery',
    'countdown'
    // 'jquerycountdown'
], function ($) {
    'use strict';

    $(document).ready(function () {
        console.log("hotdeals.js loaded");

        $('[data-countdown]').each(function (index,el) {
             $(this).countdown($(this).data('countdown'), function (event) {
                $(this).html(event.strftime($(this).data('html')));
            });
        });

    });

    // jQuery('[data-countdown]').each(function(){
    //     var $this = $(this), finaldate = jQuery(this).data('countdown');
    //     finaldate = new Date(finaldate);
    //     jQuery(this).countdown({until: finaldate, padZeroes: true});
    // });
    // $('.timer').each(function(){
    //     var $this = $(this), finaldate = $(this).data('countdown');
    //     // finaldate = new Date(finaldate);
    //     console.log(finaldate);
    //     console.log($(this).countdown(finaldate));
    // });


    // console.log($('#timer-3').countdown($('#timer-3').data('countdown')));

});