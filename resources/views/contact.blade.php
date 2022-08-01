<x-guest-layout>
    <section class="propertes welcome-home">
        <img src="{{ asset('user/guest/images/contact-bg.png') }}" alt="">
        <h2>Contact Us</h2>
    </section>
    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h3>{{ $data->contents[0]->heading ?? '' }}</h3>
                    <form action="">
                        <div class="row">
                            <div class="col-md-6 col-6 form-row">
                                <label for="">NAME </label>
                                <input type="text" name="" id="" placeholder="fIRST NAME">
                            </div>
                            <div class="col-md-6 col-6 form-row">
                                <label for=""> </label>
                                <input type="text" name="" id="" placeholder="Last NAME">
                            </div>
                            <div class="col-md-12 form-row">
                                <label for="">Email</label>
                                <input type="email" placeholder="example@xyz.com">
                            </div>
                            <div class="col-md-12 form-row">
                                <label for="">Subject</label>
                                <input type="text">
                            </div>
                            <div class="col-md-12 form-row">
                                <label for="">Message</label>
                                <textarea name="" id="" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                        <input type="submit" value="submit" class="pm-btn">
                    </form>
                </div>
                <div class="col-lg-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d29481.55174377444!2d88.3658664!3d22.5344056!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1658269702682!5m2!1sen!2sin"
                        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </section>
</x-guest-layout>