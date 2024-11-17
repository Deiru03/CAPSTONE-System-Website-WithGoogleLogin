@if (Auth::user()->user_type === 'Admin' || Auth::user()->user_type === 'Program-Head' || Auth::user()->user_type === 'Dean')
    <x-admin-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('About Us') }}
            </h2>
        </x-slot>
        <div class="about-us-container">
            @include('about-us-content')
        </div>
    </x-admin-layout>
@else
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('About Us') }}
            </h2>
        </x-slot>
        <div class="about-us-container">
            @include('about-us-content')
        </div>
    </x-app-layout>
@endif

<style>
.about-us-container {
    padding: 4rem 2rem;
    background: linear-gradient(135deg, #ffffff 0%, #ffffff 100%);
    min-height: 100vh;
}

.about-header {
    text-align: center;
    margin-bottom: 3rem;
    opacity: 0;
    animation: fadeInUp 1s ease forwards;
}

.about-header h1 {
    font-size: 3rem;
    color: #2d3748;
    margin-bottom: 1rem;
    font-weight: 700;
}

.about-header p {
    font-size: 1.2rem;
    color: #4a5568;
    max-width: 600px;
    margin: 0 auto;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 1rem;
    max-width: 1400px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

.team-member-card {
    background: rgba(255, 255, 255, 0.9);
    border-radius: 20px;
    padding: 2rem;
    text-align: center;
    transition: all 0.3s ease;
    opacity: 0;
    animation: fadeInUp 1s ease forwards;
    animation-delay: calc(var(--delay) * 0.2s);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}

.team-member-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.member-avatar {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    margin: 0 auto 1.5rem;
    overflow: hidden;
    border: 5px solid #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.member-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.member-info h3 {
    font-size: 1.5rem;
    color: #2d3748;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.member-role {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 25px;
    font-size: 0.9rem;
    margin-bottom: 1rem;
}

.member-gender {
    font-size: 0.9rem;
    color: #718096;
}

.social-links {
    margin-top: 1.5rem;
    display: flex;
    justify-content: center;
    gap: 1rem;
}

.social-link {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background: #f7fafc;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #4a5568;
    transition: all 0.3s ease;
}

.social-link:hover {
    background: #667eea;
    color: white;
    transform: translateY(-3px);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .about-header h1 {
        font-size: 2.5rem;
    }
    
    .team-grid {
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    }
}

/* Enhanced Responsive Grid System */
.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
    padding: 1rem;
    max-width: 1400px;
    margin: 0 auto;
    transition: all 0.3s ease;
}

/* Responsive Breakpoints with smooth transitions */
@media screen and (max-width: 1400px) {
    .team-grid {
        grid-template-columns: repeat(3, 1fr);
        padding: 1rem;
    }
}

@media screen and (max-width: 1200px) {
    .team-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .about-header h1 {
        font-size: 2.75rem;
    }
}

@media screen and (max-width: 768px) {
    .about-us-container {
        padding: 2rem 1rem;
    }
    
    .team-grid {
        grid-template-columns: repeat(1, 1fr);
        gap: 1.5rem;
    }
    
    .about-header h1 {
        font-size: 2.25rem;
    }
    
    .about-header p {
        font-size: 1.1rem;
        padding: 0 1rem;
    }
    
    .team-member-card {
        padding: 1.5rem;
    }
}

@media screen and (max-width: 480px) {
    .about-header h1 {
        font-size: 2rem;
    }
    
    .member-avatar {
        width: 120px;
        height: 120px;
    }
    
    .member-info h3 {
        font-size: 1.25rem;
    }
}

/* Add smooth transitions for all elements */
* {
    transition: all 0.3s ease-in-out;
}

/* Prevent layout shifts during transitions */
.about-us-container {
    overflow-x: hidden;
    width: 100%;
    position: relative;
}

/* Enhanced card responsiveness */
.team-member-card {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
    height: fit-content;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Improved hover effects with smooth transitions */
.team-member-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

/* Add a container query for modern browsers */
@container (min-width: 400px) {
    .team-member-card {
        padding: 2.5rem;
    }
}

/* Add smooth scrolling for the whole page */
html {
    scroll-behavior: smooth;
}

/* Add resize observer styles */
.resize-animation-stopper * {
    animation: none !important;
    transition: none !important;
}

</style>

<!-- Create a new partial view: resources/views/about-us-content.blade.php -->

<!-- Add this script at the bottom of your file -->
<script>
// Prevent transitions during window resize
let resizeTimer;
window.addEventListener('resize', () => {
    document.body.classList.add('resize-animation-stopper');
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        document.body.classList.remove('resize-animation-stopper');
    }, 400);
});

// Adjust card heights to match
function equalizeCardHeights() {
    const cards = document.querySelectorAll('.team-member-card');
    let maxHeight = 0;
    
    // Reset heights
    cards.forEach(card => {
        card.style.height = 'auto';
        maxHeight = Math.max(maxHeight, card.offsetHeight);
    });
    
    // Set equal heights
    cards.forEach(card => {
        card.style.height = `${maxHeight}px`;
    });
}

// Run on load and resize
window.addEventListener('load', equalizeCardHeights);
window.addEventListener('resize', equalizeCardHeights);

// Intersection Observer for smooth animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '20px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

document.querySelectorAll('.team-member-card').forEach(card => {
    observer.observe(card);
});
</script>
