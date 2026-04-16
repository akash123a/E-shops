@extends('frontend.layouts.app')

@section('content')

         

<!-- Beautiful Slider Section -->
<div class="slider-container">
    <div class="slider">
        <div class="slides-wrapper">
            @foreach($sliders as $index => $slide)
                <div class="slide {{ $loop->first ? 'active' : '' }}" 
                     style="background-image: url('{{ asset('uploads/sliders/'.$slide->image) }}');">
                    <div class="slide-overlay"></div>
                    <div class="slide-content">
                        <h2>{{ $slide->title ?? 'Welcome to Our Store' }}</h2>
                        <p>{{ $slide->description ?? 'Discover amazing products at great prices. Shop with confidence and enjoy fast delivery.' }}</p>
                        <a href="{{ $slide->button_link ?? '/products' }}" class="slide-btn">
                            Shop Now <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Navigation Arrows -->
        <div class="slider-arrow arrow-prev" id="prevSlide">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="slider-arrow arrow-next" id="nextSlide">
            <i class="fas fa-chevron-right"></i>
        </div>

        <!-- Dots Navigation -->
        <div class="slider-dots" id="sliderDots">
            @foreach($sliders as $index => $slide)
                <div class="dot {{ $loop->first ? 'active' : '' }}" data-index="{{ $index }}"></div>
            @endforeach
        </div>
    </div>
</div>

<!-- Hero Section -->
<div class="hero-section">

<div style="text-align: right; padding: 10px;">
    @guest
        <a href="{{ route('login') }}" class="btn btn-success">Login</a>
        <a href="{{ route('register') }}" class="btn btn-success">Register</a>
        
        
    @endguest

    @auth
        <a href="{{ route('dashboard') }}" class="btn btn-dark">Dashboard</a>

        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    @endauth
</div>
    <h2>Welcome to Our Store</h2>
    <p>Discover amazing products at great prices. Shop with confidence and enjoy fast delivery.</p>
</div>


<h2>Your Groups</h2>

<form method="POST" action="{{ route('group.index') }}">
    @csrf
    <input type="text" name="name" placeholder="Group Name">
    <button>Create</button>
</form>

@foreach($groups as $group)
    <p>
        {{ $group->name }}
        <a href="/balance/{{ $group->id }}">View Balance</a>

        
@if(!empty($settlements))
    @foreach($settlements as $s)
        <p>
    {{ optional($group->users->find($s['from']))->name ?? 'Unknown' }}
    pays ₹{{ $s['amount'] }} to
    {{ optional($group->users->find($s['to']))->name ?? 'Unknown' }}
</p>
    @endforeach
@else
    <p>No settlements yet</p>
@endif
    </p>
@endforeach


<h2>Hisab (Balances)</h2>

@foreach($balances as $user => $amount)
    <p>User {{ $user }} : ₹ {{ $amount }}</p>
@endforeach
 


<script>
    // Beautiful Slider Functionality
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const totalSlides = slides.length;
    let autoSlideInterval;

    // Function to show slide by index
    function showSlide(index) {
        // Remove active class from all slides
        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        
        // Remove active class from all dots
        dots.forEach(dot => {
            dot.classList.remove('active');
        });
        
        // Add active class to current slide and dot
        slides[index].classList.add('active');
        if (dots[index]) {
            dots[index].classList.add('active');
        }
        
        currentIndex = index;
    }

    // Next slide function
    function nextSlide() {
        let newIndex = currentIndex + 1;
        if (newIndex >= totalSlides) {
            newIndex = 0;
        }
        showSlide(newIndex);
        resetAutoSlide();
    }

    // Previous slide function
    function prevSlide() {
        let newIndex = currentIndex - 1;
        if (newIndex < 0) {
            newIndex = totalSlides - 1;
        }
        showSlide(newIndex);
        resetAutoSlide();
    }

    // Reset auto-slide timer
    function resetAutoSlide() {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(nextSlide, 5000);
    }

    // Event listeners for arrows
    const prevBtn = document.getElementById('prevSlide');
    const nextBtn = document.getElementById('nextSlide');
    
    if (prevBtn) {
        prevBtn.addEventListener('click', prevSlide);
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', nextSlide);
    }
    
    // Event listeners for dots
    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => {
            showSlide(index);
            resetAutoSlide();
        });
    });

    // Pause auto-slide on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(autoSlideInterval);
        });
        
        sliderContainer.addEventListener('mouseleave', () => {
            autoSlideInterval = setInterval(nextSlide, 5000);
        });
    }

    // Start auto-slide
    autoSlideInterval = setInterval(nextSlide, 5000);

    // Optional: Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            prevSlide();
        } else if (e.key === 'ArrowRight') {
            nextSlide();
        }
    });

    // Add image loading fallback
    slides.forEach(slide => {
        const bgImage = slide.style.backgroundImage;
        if (bgImage && bgImage !== 'url("")') {
            const img = new Image();
            img.src = bgImage.slice(5, -2);
            img.onerror = () => {
                slide.style.backgroundImage = 'url("/images/fallback-image.jpg")';
            };
        }
    });
</script>

@endsection