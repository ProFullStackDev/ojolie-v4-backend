<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var segment = '{{request()->segment(1)}}';
    var segment_2 = '{{request()->segment(2)}}';
    var segment_3 = '{{request()->segment(3)}}';

    var host = window.location.origin;

    if(segment_2)
        var href = host+"/"+segment+"/"+segment_2;
    else
        var href = host+"/"+segment;
    
    // var window_location = window.location;
    // if (window_location.toString().indexOf('?') > 0) {
    //   var href = subStrAfterChars(window_location.toString());
    // }else{
    //   var window_location_href = window_location;
    //   var findHref = $(".sidebar-menu a[href$='"+window_location_href+"']").length;
    //   if (findHref == 1) {
    //     var href = window_location_href;
    //   }else{
    //     var href = $('.content-header ol.breadcrumb').find('li.active').prev('li').find('a').attr('href');
    //   }
    // }
    
    active_current(href);
  });

  // function subStrAfterChars(window_location){
  //   return window_location.substring(0, window_location.indexOf('?'));
  // }

  function active_current(href){
    $('.sidebar-menu  a[href="'+href+'"]').parent().addClass('active');
    $('.sidebar-menu  a[href="'+href+'"]').closest('ul').css({'display':'block'});
    $('.sidebar-menu  a[href="'+href+'"]').closest('.treeview').addClass('menu-open active');
    $('.menu-open').closest('.treeview-menu').css({'display':'block'}).parent().addClass('menu-open active');
    $('.menu-open').parent('.treeview-menu').closest('.treeview').addClass('menu-open active');
    $('.menu-open').closest('.treeview-menu').css({'display':'block'}).parent().closest('.treeview-menu').css({'display':'block'}).closest('.treeview-menu').css({'display':'block'}).closest('.treeview').addClass('menu-open active');
  }
</script>

@stack('js')