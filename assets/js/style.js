$(document).ready(function(){

$('.menu-display-icon').click(function(){
    $('.container-flex-box .menu').slideDown(500);
    $('.menu-display-icon').hide(500);
    $('.menu-close-icon').show(500);
});
    
$('.menu-close-icon').click(function(){
    $('.container-flex-box .menu').slideUp(500);
    $('.menu-close-icon').hide(500);
    $('.menu-display-icon').show(500);
});
    
$(window).resize(function(){
        if($(window).width() >= 720){
            if($('.container-flex-box .menu').css('display') == 'none') {
                $('.container-flex-box .menu').css('display','block');
            }
        }else{
            if($(window).width() <= 720){
                if($('.container-flex-box .menu').css('display') == 'block') {
                $('.header-menu').css('display','none');
                $('.container-flex-box .menu').css('display','none');
                }
            }
        }
});
       
$('#invoice_tab').DataTable();    
    //dom: 'Bfrtip',
   // buttons: [
      //  'copy'
   // ]
});