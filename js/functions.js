$(window).scroll(function(){

  var winScroll = $(this).scrollTop();

  if(winScroll > $('.CircleHolder1').offset().top - $(window).height()){
    $('.CircleHolder1').css({'background-position':'right center '+
    (winScroll- $('.CircleHolder1').offset().top) +'px'});
  }

  if(winScroll > $('.CircleHolder2').offset().top - $(window).height()){
    $('.CircleHolder2').css({'background-position':'right center '+
    (winScroll- $('.CircleHolder2').offset().top) +'px'});
  }

  if(winScroll > $('.CircleHolder3').offset().top - $(window).height()){
    $('.CircleHolder3').css({'background-position':'right center '+
    (winScroll- $('.CircleHolder3').offset().top) +'px'});
  }

});
