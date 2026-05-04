<header class="site-header">
    <div class="container header-container">
        <a href="{{ url('/') }}" class="logo" aria-label="The Entry Pass Home">
            <img src="{{ asset('images/logo.jpeg') }}" alt="The Entry Pass Logo" class="logo-icon">
            <span class="logo-text">The Entry Pass</span>
        </a>
        <nav class="nav-desktop" aria-label="Main Navigation">
            <a href="#exams" class="nav-link">Exams</a>
            <a href="#why" class="nav-link">Features</a>
            <a href="#" target="_blank" rel="noopener noreferrer" class="nav-link">Resources</a>
            <a href="#exams" class="btn btn-primary btn-sm">Get Started</a>
        </nav>
        <button id="mobile-menu-btn" class="mobile-menu-btn" aria-label="Toggle menu" aria-expanded="false" aria-controls="mobile-menu">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <line x1="4" x2="20" y1="12" y2="12"></line>
                <line x1="4" x2="20" y1="6" y2="6"></line>
                <line x1="4" x2="20" y1="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <div id="mobile-menu" class="mobile-menu" role="dialog" aria-modal="true">
        <nav class="mobile-nav" aria-label="Mobile Navigation">
            <a href="#exams" class="mobile-nav-link">Exams</a>
            <a href="#why" class="mobile-nav-link">Features</a>
            <a href="#" class="mobile-nav-link">Blog Resources</a>
        </nav>
    </div>
</header>