/**
 * @copyright Copyright (c) 2014-2015 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
if (typeof dosamigos == "undefined" || !dosamigos) {
    var dosamigos = {};
}
dosamigos.semantic = (function ($) {

    var pub = {
        isActive: true,
        init: function () {
            /** Init toggle buttons display on Sidebar widgets **/
            this.showSideBarButtons();
            /** Init toggle buttons display on Modal widgets **/
            this.showModalButtons();
            /** Init popups **/
            this.initPopups();
            /** Init select as dropdowns **/
            this.initDropdowns();
        },
        initPopups: function (selector, settings) {
            $((selector || '[rel="popup"]')).popup((settings || {}));
        },
        initDropdowns: function(selector, settings) {
            $((selector || 'select.ui.dropdown')).dropdown((settings || {}));
        },
        initMessageCloseButtons: function(selector) {
            $((selector || '.ui.message .close')).off('click').on('click', function(){
                $(this).closest('.message').fadeOut();
            });
        },
        showModalButtons: function (selector) {
            $((selector || '[data-toggle="semantic-modal"]')).off('click').on('click', function (e) {
                e.preventDefault();
                var m = $(this).data('target');
                $(m).modal('show');
            });
        },
        showSideBarButtons: function(selector) {
            $((selector || '.ui.launch-sidebar')).off('click').on('click', function(e) {
                e.preventDefault();
                $(this).prev('.ui.sidebar.menu').sidebar('toggle');
            });
        }
    };
    return pub;
})(jQuery);