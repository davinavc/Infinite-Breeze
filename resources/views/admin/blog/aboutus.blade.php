@extends('layouts.app-blog')

@section('content')
    <section>
        <div class="main-container">
            <div class="image" data-aos="zoom-out" data-aos-duration="1500" data-aos-delay="100">
                <img src="{{ asset('img/LOGO-02.png') }}" alt="">
            </div>
            <div class="content ms-auto me-auto">
                <h1 data-aos="fade-left" data-aos-duration="1500" data-aos-delay="700">
                    Infinite Organizer <br>
                    <span>PT. Infinite Karya Makmur</span>
                </h1>
                <p data-aos="fade-flip-down" data-aos-duration="1500" data-aos-delay="1100">Infinite Event organizer berdiri pada Desember 2013, di mulai dari mengerjakan Event Event Perusahaan atau Brand, dan pada tahun 2014 Infinite Event organizer mulai membuat Event/ bazaar/ pameran dari mall ke mall dengan Konsep “Tematik Event”.</p>
            </div>
            
        </div>
    </section>

    <section class="about" id="about">
        <div class="content">
            <div class="title" data-aos="fade-up" data-aos-duration="1500">
                <span>Vision & Mission</span>
            </div>
            <div class="about-details">
                <div class="left" data-aos="fade-right" data-aos-duration="1500" data-aos-delay="200">
                    <img src="{{ asset('img/infinite_team.jpeg') }}" alt="">
                </div>
                <div class="right">
                    <div class="topic" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="200">Vision & Mission</div>
                    <p data-aos="flip-down" data-aos-duration="1500" data-aos-delay="300">Mengadakan Event dengan konsep One Stop Exhibition, Dimana para visitor yang berkunjung ke Event Infinite dapat berbelanja, mendapatkan edukasi dan hiburan melalui program acara yang di adakan dalam Event. Infinite Event organizer juga memiliki misi dapat memperluas skala area Event dari seluruh Indonesia sampai ke skala Internasional.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="skills" id="skills">
        <div class="content">
            <div class="title" data-aos="fade-up" data-aos-duration="1200">
                <span>Portofolio</span>
            </div>
            <div class="skills-details">
                <div class="text">
                    <div class="topic" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="200">
                        Our Portofolio
                    </div>
                    <p data-aos="fade-right" data-aos-duration="1200" data-aos-delay="400">Trusted by Numerous Clients for</p>
                    <div class="experience" data-aos="fade-up" data-aos-duration="1200" data-aos-delay="600">
                        <div class="num">10+</div>
                        <div class="exp">years of <br>experience</div>
                    </div>
                </div>
                <div class="boxes">
                    <div class="box">
                        <div class="topic" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="150">Events</div>
                        <div class="per" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="300">100+</div>
                    </div>
                    <div class="box">
                        <div class="topic" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="450">Malls</div>
                        <div class="per" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="600">20+</div>
                    </div>
                    <div class="box">
                        <div class="topic" data-aos="fade-right" data-aos-duration="1200" data-aos-delay="450">Tenant</div>
                        <div class="per" data-aos="zoom-in" data-aos-duration="1200" data-aos-delay="600">300+</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="services" id="services">
        <div class="content">
            <div class="title" data-aos="fade-up" data-aos-duration="1200">
                <span>Our Services</span>
            </div>
            <div class="boxes">
                <div class="box" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="200">
                    <div class="icon">
                        <span class="material-symbols-outlined">apartment</span>
                    </div>
                    <div class="topic">Company Event</div>
                    <p>Professional event solutions for meetings, gatherings, product launches, and corporate celebrations — executed with precision and impact.</p>
                </div>
                <div class="box" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="400">
                    <div class="icon">
                        <span class="material-symbols-outlined">point_of_sale</span>
                    </div>
                    <div class="topic">Tematic Event</div>
                    <p>Creative and custom-themed events that bring your ideas to life — from concept to execution.</p>
                </div>
                <div class="box" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="600">
                    <div class="icon">
                        <span class="material-symbols-outlined">point_of_sale</span>
                    </div>
                    <div class="topic">Wedding</div>
                    <p>Making your dream wedding come true — elegant, heartfelt, and flawlessly executed from start to finish.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Me -->
     <section class="contact" id="contact">
        <div class="contact-text" data-aos="fade-up" data-aos-duration="1500">
            <h2>Contact Us</h2>
            <h4>Lets Work </h4>
            <p>Infinite Event organizer berdiri pada Desember 2013, di mulai dari mengerjakan Event Event Perusahaan atau Brand, dan pada tahun 2014 Infinite Event organizer mulai membuat Event/ bazaar/ pameran dari mall ke mall dengan Konsep “Tematik Event”. Mall yang bekerja sama dengan Infinite Organizer, seperti Emporium Pluit Mall, Lippo Mall Puri, Taman Anggrek, Central Park, Summarecon Mall Serpong, Sedayu Group dan masih banyak Lagi </p>
            <div class="contact-list">
                <li><i class="bi bi-envelope"></i><p>Test@gmail.com</p></li>
                <li><i class="bi bi-telephone"></i><p>0129321817</p></li>
            </div>
            <div class="contact-icons">
                <a href="https://www.instagram.com/infinite_organizer/" target="_blank"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
        <div class="contact-form">
            <form action="">
                <input type="text" placeholder="Enter Your Name" Required data-aos="fade-left" data-aos-duration="1500" data-aos-delay="100">
                <input type="email" placeholder="Enter Your Email" Required data-aos="fade-left" data-aos-duration="1500" data-aos-delay="300">
                <input type="text" placeholder="Enter Your Subject" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="500">
                <textarea name="" id="" cols="40" rows="10" placeholder="Enter Your Message" data-aos="fade-left" data-aos-duration="1500" data-aos-delay="600"></textarea>
                <input type="submit" value="SUBMIT" class="send" data-aos="fade-up" data-aos-duration="1500" data-aos-delay="500">
            </form>
        </div>
     </section>

    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

@endsection
