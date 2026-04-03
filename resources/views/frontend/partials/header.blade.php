<header class="ecommerce-header">
    <div class="header-container">
        <div class="header-content">
            <!-- Logo / Site Title -->
            <a href="/" class="logo">
                <div class="logo-icon">
                    <i class="fas fa-store"></i>
                </div>
                <span class="logo-text">My E-commerce Website</span>
            </a>

            <!-- Navigation Menu (Desktop + Mobile) -->
            <nav class="nav-menu" id="navMenu">
                <a href="/" class="nav-link active">
                    <i class="fas fa-home"></i>
                    Home
                </a>
                <a href="/products" class="nav-link">
                    <i class="fas fa-box-open"></i>
                    Products
                </a>
                <a href="/cart" class="nav-link cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    Cart
                    <span class="cart-badge">3</span>
                </a>
            </nav>

            <!-- Right Side Actions -->
            <div class="header-actions">
                <button class="search-btn" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
                <button class="user-btn" aria-label="User Account">
                    <i class="fas fa-user"></i>
                </button>
                <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Menu">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </div>
</header>


<script>
    // Mobile menu toggle functionality
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navMenu = document.getElementById('navMenu');
    let isMenuOpen = false;

    mobileMenuBtn.addEventListener('click', () => {
        navMenu.classList.toggle('open');
        isMenuOpen = !isMenuOpen;
        
        // Change icon based on menu state
        const icon = mobileMenuBtn.querySelector('i');
        if (isMenuOpen) {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        } else {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        }
    });

    // Close menu when clicking on a link (for better UX)
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            navMenu.classList.remove('open');
            isMenuOpen = false;
            const icon = mobileMenuBtn.querySelector('i');
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        });
    });

    // Set active link based on current page (simple demo)
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(link => {
        const href = link.getAttribute('href');
        if (href === currentPath || (currentPath === '/' && href === '/')) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
</script>