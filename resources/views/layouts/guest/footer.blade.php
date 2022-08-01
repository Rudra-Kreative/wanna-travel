<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 sub1 ">
                <a href="#" class="footer-logo">
                    <img src="{{ asset('user/guest/images/footer-logo.svg') }}" alt="">
                </a>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <ul class="social">
                    <li><a href="#"><img src="{{ asset('user/guest/images/fb-black.svg') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('user/guest/images/insta-black.svg') }}" alt=""></a></li>
                    <li><a href="#"><img src="{{ asset('user/guest/images/twit-black.svg') }}" alt=""></a></li>
                </ul>
            </div>
            <div class="col-lg-3 sub2 col-6">
                <h4>Contact Us</h4>
                <h5>We All Need A Holiday Limited</h5>
                <ul class="detail">
                    <li>Cocody Mermoz</li>
                    <li>Booker Street Washington</li>
                    <li>Phone: 12432499</li>
                </ul>
            </div>
            <div class="col-lg-2 sub3 col-6">
                <h4>Useful links</h4>
                <ul class="links">
                    <li><a href="{{ route('view',['page'=>'home']) }}">HOME</a></li>
                    <li><a href="javascript:void(0)">PARTNERS</a></li>
                    <li><a href="javascript:void(0)">PROPERTY</a></li>
                    <li><a href="{{ route('view',['page'=>'contact']) }}">CONTACT</a></li>
                </ul>
            </div>
            <div class="col-lg-4 sub4">
                <h4>subscribe to our newsletter</h4>
                <form action="">
                    <input type="text" placeholder="Email Address">
                    <input type="submit" value="Submit">
                </form>
            </div>
        </div>
    </div>
    <div class="COPY">
        <P>©2022 by We All Need A Holiday Limited. UK Registered.</P>
    </div>
    <img class="pattern" src="{{ asset('user/guest/images/pattern.svg') }}" alt="">
</footer>
