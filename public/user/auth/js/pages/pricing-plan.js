$(document).on('click','.planSelectBtn',function(){
    $('.price-box').removeClass('recom');
    $(this).closest('.price-box').addClass('recom');
    $('.planSelectBtn').removeClass('select');
    $(this).addClass('select');
});