(function() {
    'use strict';

    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const navLinks = document.querySelectorAll('a[href^="#"]');
    const subjectBtns = document.querySelectorAll('.subject-btn');
    const laptopContent = document.querySelector('.laptop-content-inner');

    function toggleMobileMenu() {
        const isExpanded = mobileMenuBtn.getAttribute('aria-expanded') === 'true';
        
        mobileMenuBtn.setAttribute('aria-expanded', !isExpanded);
        mobileMenu.classList.toggle('active');
        
        const icon = mobileMenuBtn.querySelector('svg');
        if (icon) {
            if (!isExpanded) {
                icon.innerHTML = '<path d="M18 6 6 18"></path><path d="m6 6 12 12"></path>';
            } else {
                icon.innerHTML = '<line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line>';
            }
        }
    }

    function closeMobileMenu() {
        mobileMenu.classList.remove('active');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        
        const icon = mobileMenuBtn.querySelector('svg');
        if (icon) {
            icon.innerHTML = '<line x1="4" x2="20" y1="12" y2="12"></line><line x1="4" x2="20" y1="6" y2="6"></line><line x1="4" x2="20" y1="18" y2="18"></line>';
        }
    }

    function handleAnchorClick(event) {
        const href = this.getAttribute('href');
        
        if (href.startsWith('#') && href.length > 1) {
            event.preventDefault();
            const target = document.querySelector(href);
            
            if (target) {
                if (mobileMenu.classList.contains('active')) {
                    closeMobileMenu();
                }
                
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
                
                history.pushState(null, null, href);
            }
        }
    }

    function toggleSubjectContent(event) {
        const btn = event.currentTarget;
        const contentId = btn.getAttribute('aria-controls');
        const content = document.getElementById(contentId);
        const isExpanded = btn.getAttribute('aria-expanded') === 'true';
        
        subjectBtns.forEach(otherBtn => {
            if (otherBtn !== btn) {
                const otherContentId = otherBtn.getAttribute('aria-controls');
                const otherContent = document.getElementById(otherContentId);
                
                otherBtn.setAttribute('aria-expanded', 'false');
                if (otherContent) {
                    otherContent.hidden = true;
                }
            }
        });
        
        btn.setAttribute('aria-expanded', !isExpanded);
        
        if (content) {
            if (isExpanded) {
                content.hidden = true;
            } else {
                content.hidden = false;
            }
        }
    }

    function init() {
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleMobileMenu);
        }

        document.querySelectorAll('.mobile-nav-link').forEach(link => {
            link.addEventListener('click', closeMobileMenu);
        });

        navLinks.forEach(link => {
            link.addEventListener('click', handleAnchorClick);
        });

        subjectBtns.forEach(btn => {
            btn.addEventListener('click', toggleSubjectContent);
        });

        if (laptopContent) {
            laptopContent.addEventListener('mouseenter', () => {
                laptopContent.style.animationPlayState = 'paused';
            });
            laptopContent.addEventListener('mouseleave', () => {
                laptopContent.style.animationPlayState = 'running';
            });
        }

        document.addEventListener('click', (event) => {
            if (mobileMenu.classList.contains('active') && 
                !mobileMenu.contains(event.target) && 
                !mobileMenuBtn.contains(event.target)) {
                closeMobileMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
                mobileMenuBtn.focus();
            }
        });

        let lastScroll = 0;
        window.addEventListener('scroll', () => {
            const header = document.querySelector('.site-header');
            const currentScroll = window.pageYOffset;
            
            if (currentScroll <= 0) {
                header.style.boxShadow = 'none';
                return;
            }
            
            if (currentScroll > lastScroll && !header.style.boxShadow) {
                header.style.boxShadow = '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)';
            } else if (currentScroll < lastScroll && header.style.boxShadow) {
                header.style.boxShadow = 'none';
            }
            
            lastScroll = currentScroll;
        });

        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.feature-card, .step-card, .exam-card').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                observer.observe(el);
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();