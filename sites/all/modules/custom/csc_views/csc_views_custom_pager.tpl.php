<div class="custom-footer-pager">
  <div class="custom-footer-pager-left">
    Displaying <?php print $value['current_row_list']; ?> of <?php print $value['total_items']; ?> found
  </div>
  <div class="custom-footer-pager-right">
    <?php print $value['first_page_link'] . ' ' . $value['prev_page_link']; ?><span>Page</span>
    <input type="text" name="pager-input" id="pager-input" value="<?php print $value['current_page']; ?>"/>
    of <?php print $value['max_page'] . ' ' . $value['next_page_link'] . ' ' . $value['last_page_link']; ?> 
  </div>
  <input type="hidden" value="<?php print $value['max_page']; ?>" id="max-page-input">
</div>
<?php print $value['min_max_year']; ?>