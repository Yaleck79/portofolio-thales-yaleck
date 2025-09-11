// Typed.js Animation
document.addEventListener("DOMContentLoaded", function () {
    var typed = new Typed(".multiple-text", {
        strings: [
            "Développeur Web", 
            "Créateur de Solutions", 
            "Technicien IT", 
            "Passionné de Code",
            "Barman Professionnel",
            "Musicien"
        ],
        typeSpeed: 100,
        backSpeed: 100,
        backDelay: 1000,
        loop: true,
    });
});

// Custom Cursor
const cursor = document.querySelector('.cursor');
const links = document.querySelectorAll('a, button');

document.addEventListener('mousemove', (e) => {
    cursor.style.left = e.clientX + 'px';
    cursor.style.top = e.clientY + 'px';
});

links.forEach(link => {
    link.addEventListener('mouseenter', () => {
        cursor.classList.add('hover');
    });
    
    link.addEventListener('mouseleave', () => {
        cursor.classList.remove('hover');
    });
});

// Mobile Navigation Toggle
const menuIcon = document.querySelector('#menu-icon');
const navbar = document.querySelector('.navbar');

menuIcon.addEventListener('click', () => {
    navbar.classList.toggle('show');
});

// Smooth Scrolling for Navigation Links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
            navbar.classList.remove('show');
        }
    });
});

// Header Background Change on Scroll
const header = document.querySelector('.header');
const scrollTop = document.querySelector('.scroll-top');

window.addEventListener('scroll', () => {
    if (window.scrollY > 100) {
        header.classList.add('scrolled');
        scrollTop.classList.add('show');
    } else {
        header.classList.remove('scrolled');
        scrollTop.classList.remove('show');
    }
});

// Scroll to Top Functionality
scrollTop.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Active Navigation Link
const sections = document.querySelectorAll('section');
const navLinks = document.querySelectorAll('.navbar a');

window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (scrollY >= (sectionTop - 200)) {
            current = section.getAttribute('id');
        }
    });

    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === '#' + current) {
            link.classList.add('active');
        }
    });
});

// Scroll Reveal Animation
const scrollRevealElements = document.querySelectorAll('.scroll-reveal');

const scrollReveal = () => {
    scrollRevealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const elementVisible = 150;

        if (elementTop < window.innerHeight - elementVisible) {
            element.classList.add('revealed');
        }
    });
};

window.addEventListener('scroll', scrollReveal);
scrollReveal(); // Initial check

// Counter Animation for Stats
const stats = document.querySelectorAll('.stat-number');

const animateCounters = () => {
    stats.forEach(stat => {
        const target = parseInt(stat.getAttribute('data-target'));
        let current = parseInt(stat.textContent);

        if (current < target) {
            const increment = target / 100;
            stat.textContent = Math.ceil(current + increment);
            setTimeout(animateCounters, 20);
        } else {
            stat.textContent = target;
        }
    });
};

// Trigger counter animation when stats section is visible
const statsSection = document.querySelector('.stats');
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateCounters();
            statsObserver.disconnect();
        }
    });
});

if (statsSection) {
    statsObserver.observe(statsSection);
}

// Skills Progress Bar Animation
const skillsSection = document.querySelector('.skills');
const progressBars = document.querySelectorAll('.skill-progress');

const animateSkills = () => {
    progressBars.forEach(bar => {
        const width = bar.getAttribute('data-width');
        bar.style.width = width;
    });
};

const skillsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateSkills();
            skillsObserver.disconnect();
        }
    });
});

if (skillsSection) {
    skillsObserver.observe(skillsSection);
}

// Contact Form Handling
const contactForm = document.querySelector('#contactForm');

contactForm.addEventListener('submit', (e) => {
    e.preventDefault();
    
    // Get form data
    const formData = new FormData(contactForm);
    const name = formData.get('name');
    const email = formData.get('email');
    const subject = formData.get('subject');
    const message = formData.get('message');
    
    // Simple validation
    if (name && email && subject && message) {
        // Simulate form submission
        alert('Merci pour votre message ! Je vous répondrai bientôt.');
        contactForm.reset();
    } else {
        alert('Veuillez remplir tous les champs.');
    }
});

// Parallax Effect for Background Elements
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const rate = scrolled * -0.5;
    
    document.querySelectorAll('.section-bg').forEach(bg => {
        bg.style.transform = `translateY(${rate}px)`;
    });
});

// Contact click handlers
document.addEventListener('DOMContentLoaded', function () {
    const mailDiv = document.querySelector('.contact-mail');
    if (mailDiv) {
        mailDiv.addEventListener('click', function () {
            window.location.href = 'mailto:thalesyaleckmiracle@gmail.com';
        });
    }
});

// Add loading animation
window.addEventListener('load', () => {
    const loader = document.createElement('div');
    loader.id = 'loader';
    loader.innerHTML = `
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <h2>TY.</h2>
            <p>Chargement du portfolio...</p>
        </div>
    `;
    
    const loaderStyles = `
        <style>
            #loader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: var(--bg-color);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10000;
                opacity: 1;
                visibility: visible;
                transition: all 0.5s ease;
            }
            
            #loader.hidden {
                opacity: 0;
                visibility: hidden;
            }
            
            .loader-content {
                text-align: center;
            }
            
            .loader-spinner {
                width: 50px;
                height: 50px;
                border: 3px solid var(--third-bg-color);
                border-top: 3px solid var(--main-color);
                border-radius: 50%;
                animation: spin 1s linear infinite;
                margin: 0 auto 2rem;
            }
            
            .loader-content h2 {
                font-size: 3rem;
                background: var(--gradient-1);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 1rem;
            }
            
            .loader-content p {
                font-size: 1.4rem;
                opacity: 0.8;
            }
            
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        </style>
    `;
    
    document.head.insertAdjacentHTML('beforeend', loaderStyles);
    document.body.prepend(loader);
    
    setTimeout(() => {
        loader.classList.add('hidden');
        setTimeout(() => {
            loader.remove();
        }, 500);
    }, 2000);
});

// Particles effect
function createParticles() {
    const particlesContainer = document.createElement('div');
    particlesContainer.style.cssText = `
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
        overflow: hidden;
    `;
    
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.style.cssText = `
            position: absolute;
            width: 2px;
            height: 2px;
            background: var(--main-color);
            border-radius: 50%;
            opacity: 0.3;
            animation: float-particle ${Math.random() * 15 + 10}s linear infinite;
        `;
        
        particle.style.left = Math.random() * 100 + '%';
        particle.style.animationDelay = Math.random() * 5 + 's';
        
        particlesContainer.appendChild(particle);
    }
    
    document.body.appendChild(particlesContainer);
    
    // Add particle animation styles
    const particleStyles = `
        <style>
            @keyframes float-particle {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 0.3;
                }
                90% {
                    opacity: 0.3;
                }
                100% {
                    transform: translateY(-100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        </style>
    `;
    
    document.head.insertAdjacentHTML('beforeend', particleStyles);
}


// Initialize particles
document.addEventListener('DOMContentLoaded', () => {
    createParticles();
});
// --- Animation Footer au Scroll ---
// --- Animation Footer au Scroll ---
// Animation du footer supprimée à la demande de l'utilisateur
// --- Fin Animation Footer au Scroll ---