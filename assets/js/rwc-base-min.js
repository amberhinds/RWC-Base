/**
 * RWC Base entry point.
 *
 * @package RWC Base JS
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 */
var rwcBase=function(e){"use strict";var t=window.navigator.userAgent,i,n;/MSIE|Trident/.test(t)&&(confirm("You are using an outdated browser. Please upgrade your browser to improve your experience.")&&(window.location="http://browsehappy.com"));var r=function(){var t=0;"fixed"===e(".site-header").css("position")&&(t=e(".site-header").outerHeight()),e(".site-inner").css("margin-top",t)},o=function(){r(),e(window).resize((function(){r()})),"undefined"!=typeof wp&&void 0!==wp.customize&&wp.customize.bind("change",(function(e){setTimeout((function(){r()}),1500)}))};return e(".nav-primary .search-toggle").click((function(t){t.preventDefault(),e(this).parent().toggleClass("active").find('input[type="search"]').focus()})),e(".search-submit").click((function(t){""==e(this).parent().find(".search-field").val()&&(t.preventDefault(),e(this).parent().parent().removeClass("active"))})),{load:o}}(jQuery);jQuery(window).on("load",rwcBase.load);