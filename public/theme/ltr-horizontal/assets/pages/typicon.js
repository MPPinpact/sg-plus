'use strict';
$(document).ready(function() {  
  $('.icon-list-demo div div').on('click',function(){
      var font_class= ($(this).children('.typcn').attr('class'));
      if(!$(this).hasClass('svg-icon')){
        $('#myModal').modal('show');
        $('#icon').removeClass();
        $('#icon').addClass(font_class);
        $('#icon').addClass('fa-lg');
        $('#name').val(font_class);
        $('#code').val('<i class="'+font_class+'"></i>');
    }
  });
});

