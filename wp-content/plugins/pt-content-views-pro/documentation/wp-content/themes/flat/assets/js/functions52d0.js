(function($){
  $(document).ready(function() {
    $('.toggle-sidebar').click(function() {
      $('.row-offcanvas').toggleClass('active');
    });

    $('.toggle-navigation').click(function() {
      $(this).toggleClass('open').next('#site-navigation').slideToggle(300);
    });
	
	// Toggle Search form
    $('.toggle-search').click(function() {
      $('#form-search').toggle();
    });
	
	// Toogle Youtube video
	$('#output-toggle').click(function(){
		$(this).parent().html('<iframe src="//www.youtube.com/embed/CupNiWrEceY?rel=0&amp;controls=2&amp;theme=light&amp;hd=1&amp;vq=hd720&amp;showinfo=0&amp;autohide=1&amp;modestbranding=1&autoplay=1" width="540" height="360" frameborder="0" allowfullscreen="allowfullscreen"></iframe>');
	});
	
	$('#responsive-toggle').click(function(){
		$(this).parent().html('<iframe src="//www.youtube.com/embed/87Z6YJXJKgo?rel=0&amp;controls=2&amp;theme=light&amp;hd=1&amp;vq=hd720&amp;showinfo=0&amp;autohide=1&amp;modestbranding=1&autoplay=1" width="540" height="360" frameborder="0" allowfullscreen="allowfullscreen"></iframe>');
	});
	
	// bbPress: Change class for button
	$('.bbpress .entry-content :submit').each(function(){
		$(this).addClass('btn btn-info');
	});	

    $('#site-navigation .sub-menu, #site-navigation .children').before('<i class="fa fa-caret-right"></i>');

    if(!!('ontouchstart' in window)){
      $('#site-navigation .menu-item-has-children .fa, #site-navigation .page_item_has_children .fa')
      .click(function() {
        $(this).toggleClass('open').next('ul').slideToggle(300);
      });
    } else {
      $('#site-navigation .menu-item-has-children, #site-navigation .page_item_has_children')
      .not('.current-menu-parent, .current_page_parent, .current_page_ancestor, .current-menu-ancestor')
      .hover(function() {
        $(this).children('.fa').toggleClass('open').next('ul').stop(true, true).delay(200).slideDown();
      },function() {
        $(this).children('.fa').toggleClass('open').next('ul').stop(true, true).delay(500).slideUp();
      });
    }
  });
})(jQuery);