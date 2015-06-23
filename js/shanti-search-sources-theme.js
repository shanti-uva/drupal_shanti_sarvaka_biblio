(function ($) {
  Drupal.behaviors.searchFlyout = {
    attach: function (context, settings) {
      var flyout_status = $.cookie('flyout_status');
      var selector = '.view-biblio-search-api .view-content, .view-biblio-search-api .view-empty, #block-sources-views-custom-sort-filter, .view-biblio-search-api .attachment';
      // Keep search flyout open
      if ($("#search-flyout").length) {
        var status = $.cookie('flyout_status');
        if ($.cookie('flyout_status') && $.cookie('flyout_status') == 'open') {
          openSearchFlyout(selector);
        }
        else {
          closeSearchFlyout(selector);
        }
      }
      $('#search-flyout div.flap').click(function(e) {
        if ($('#search-flyout').attr('isopened')) {
          var flyout_status = 'open';
          openSearchFlyout(selector);
        }
        else {
          var flyout_status = 'close';
          closeSearchFlyout(selector);
        }
        $.cookie('flyout_status', flyout_status);
        e.preventDefault();
      });
    }
  };
  function openSearchFlyout(target) {
    $("#search-flyout").openMbExtruder();
    $(target).animate({width: '74%'});
  }
  function closeSearchFlyout(target) {
    $(target).animate({width: '100%'});
  }
})(jQuery);
