(function ($) {
  Drupal.behaviors.initializeSearchFlyout = {
    attach: function (context, settings) {
      var flyout_status = $.cookie('flyout_status');
      var selector = searchFlyoutSelector();

      if ($.cookie('flyout_status') && $.cookie('flyout_status') == 'open') {
        openSearchFlyout(selector);
      }
      else {
        closeSearchFlyout(selector);
      }
    }
  };

  Drupal.behaviors.updateSearchFlyout = {
    attach: function (context, settings) {
      var flyout_status = $.cookie('flyout_status');
      var selector = searchFlyoutSelector();

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

  function searchFlyoutSelector() {
    var widget_elements = [
      '.view-biblio-search-api .view-content',
      '.view-biblio-search-api .view-empty',
      '#block-sources-views-custom-sort-filter',
      '.view-biblio-search-api .attachment',
    ];
    var selector = widget_elements.join(', ');
    return selector;
  }

  function openSearchFlyout(target) {
    $("#search-flyout").openMbExtruder();
    $(target).animate({width: '74%'});
  }

  function closeSearchFlyout(target) {
    $(target).animate({width: '100%'});
  }
})(jQuery);
