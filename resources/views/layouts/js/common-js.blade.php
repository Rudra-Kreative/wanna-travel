<script src="{{ asset('user/guest/js/bootstrap.min.js')}}"></script>
<script src="{{ asset('user/guest/js/jquery.min.js') }}"></script>
<script src="{{ asset('user/guest/js/jquery.slimNav_sk78.min.js') }}"></script>
<script src="{{ asset('user/guest/js/owl.carousel.js') }}"></script>
<script src="{{ asset('user/guest/js/custom.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
$('#navigation nav').slimNav_sk78();
$('.home-slider').owlCarousel({
 loop: true,
 margin: 10,
 nav: false,
 dots: true,
 autoplay: false,
 smartSpeed: 1500,
 autoplayTimeout: 4000,
 responsive: {
     0: {
         items: 1
     },
     600: {
         items: 1
     },
     1000: {
         items: 1
     }
 }
})

//login slider

$('.login-slider').owlCarousel({
 loop: true,
 dots: false,
 autoplay: true,
 smartSpeed: 1500,
 autoplayTimeout: 2000,
 responsive: {
     0: {
         items: 1
     },
     600: {
         items: 1
     },
     1000: {
         items: 1
     }
 }
})

});


$(document).ready(function() {
$('.f-accordian').find('.accordion-toggle').click(function() {
 $(this).next().slideToggle('600');
 $(".accordion-content").not($(this).next()).slideUp('600');
});
$('.accordion-toggle').on('click', function() {
 $(this).toggleClass('active').siblings().removeClass('active');
});
});


$(function() {
// Multiple images preview in browser
var imagesPreview = function(input, placeToInsertImagePreview) {

 if (input.files) {
     var filesAmount = input.files.length;

     for (i = 0; i < filesAmount; i++) {
         var reader = new FileReader();

         reader.onload = function(event) {
             $($.parseHTML('<img>')).attr('src', event.target.result).appendTo(
                 placeToInsertImagePreview);
         }

         reader.readAsDataURL(input.files[i]);
     }
 }

};

$('#gallery-photo-add').on('change', function() {
 imagesPreview(this, 'div.gallery');
});
});



</script>