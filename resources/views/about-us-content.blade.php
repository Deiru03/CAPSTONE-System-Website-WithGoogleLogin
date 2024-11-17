<div class="text-center mb-12 opacity-0 transform translate-y-4 transition-all duration-1000 ease-out" 
     x-data 
     x-init="setTimeout(() => $el.classList.remove('opacity-0', 'translate-y-4'), 100)">
    <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Meet Our Amazing Team</h1>
    <p class="text-lg text-gray-600 max-w-2xl mx-auto px-4">We are a diverse group of talented individuals working together to create something extraordinary.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-8 px-4 max-w-7xl mx-auto mb-12">
    @foreach($team as $index => $member)
        <div class="bg-white/80 backdrop-blur rounded-xl p-6 
                    transform transition-all duration-500 ease-out
                    hover:bg-white/90 hover:shadow-2xl hover:-translate-y-2 hover:scale-105
                    group cursor-pointer relative overflow-hidden"
             style="--delay: {{ $index }}">
            
            <div class="absolute inset-0 rounded-xl border-2 border-transparent 
                        bg-gradient-to-r from-indigo-500/0 via-purple-500/0 to-pink-500/0
                        group-hover:from-indigo-500/20 group-hover:via-purple-500/20 group-hover:to-pink-500/20 
                        transition-all duration-500"></div>
            
            <div class="relative z-10">
                <div class="member-avatar w-48 h-48 mx-auto mb-6 rounded-full overflow-hidden
                            transform transition-all duration-500 group-hover:shadow-xl">
                    <img src="{{ asset($member['image']) }}" 
                         alt="{{ $member['name'] }}"
                         class="w-full h-full object-cover transition-all duration-500 
                                group-hover:scale-110 group-hover:rotate-3"
                    >
                </div>

                <div class="text-center space-y-3 transform transition-all duration-500 group-hover:scale-105">
                    <h3 class="text-xl font-bold text-gray-800 transition-colors duration-300 
                               group-hover:text-indigo-600">
                        {{ $member['name'] }}
                    </h3>
                    
                    <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold text-white 
                                bg-gradient-to-r from-indigo-500 to-purple-600
                                transform transition-all duration-300 
                                group-hover:shadow-lg group-hover:scale-105">
                        {{ $member['role'] }}
                    </span>
                    
                    <p class="text-gray-600 transition-colors duration-300 group-hover:text-gray-800">
                        {{ $member['gender'] }}
                    </p>
                </div>

                <div class="mt-6 flex justify-center space-x-6 opacity-90 group-hover:opacity-100 
                            transform transition-all duration-500">
                    @if($member['name'] === 'Dale Decain')
                        <a href="{{ $member['social']['github'] }}" 
                           class="social-icon-link relative p-3 rounded-full bg-gradient-to-r from-gray-100 to-gray-200
                                  group/icon hover:from-gray-800 hover:to-gray-900 transition-all duration-300"
                           title="GitHub" 
                           target="_blank">
                            <svg class="w-5 h-5 text-gray-700 group-hover/icon:text-white transition-colors duration-300" 
                                 viewBox="0 0 24 24" 
                                 fill="currentColor">
                                <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                            </svg>
                            <span class="absolute inset-0 rounded-full border border-gray-300 
                                       group-hover/icon:border-gray-700 group-hover/icon:scale-105 
                                       transition-all duration-300"></span>
                        </a>
                    @endif
                    
                    <a href="{{ $member['social']['facebook'] }}" 
                       class="social-icon-link relative p-3 rounded-full bg-gradient-to-r from-gray-100 to-gray-200
                              group/icon hover:from-[#1877f2] hover:to-[#0a66c2] transition-all duration-300"
                       title="Facebook" 
                       target="_blank">
                        <svg class="w-5 h-5 text-gray-700 group-hover/icon:text-white transition-colors duration-300" 
                             viewBox="0 0 24 24" 
                             fill="currentColor">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="absolute inset-0 rounded-full border border-gray-300 
                                   group-hover/icon:border-[#1877f2] group-hover/icon:scale-105 
                                   transition-all duration-300"></span>
                    </a>
                    
                    <a href="{{ $member['social']['google'] }}" 
                       class="social-icon-link relative p-3 rounded-full bg-gradient-to-r from-gray-100 to-gray-200
                              group/icon hover:from-[#EA4335] hover:to-[#DB4437] transition-all duration-300"
                       title="Email" 
                       target="_blank">
                        <svg class="w-5 h-5 text-gray-700 group-hover/icon:text-white transition-colors duration-300" 
                             viewBox="0 0 24 24" 
                             fill="currentColor">
                            <path d="M24 5.457v13.909c0 .904-.732 1.636-1.636 1.636h-3.819V11.73L12 16.64l-6.545-4.91v9.273H1.636A1.636 1.636 0 0 1 0 19.366V5.457c0-2.023 2.309-3.178 3.927-1.964L5.455 4.64 12 9.548l6.545-4.91 1.528-1.145C21.69 2.28 24 3.434 24 5.457z"/>
                        </svg>
                        <span class="absolute inset-0 rounded-full border border-gray-300 
                                   group-hover/icon:border-[#EA4335] group-hover/icon:scale-105 
                                   transition-all duration-300"></span>
                    </a>
                </div>
            </div>

            <div class="absolute top-2 left-2 w-8 h-8 border-t-2 border-l-2 border-transparent 
                        group-hover:border-indigo-500/30 transition-all duration-500 rounded-tl-lg"></div>
            <div class="absolute bottom-2 right-2 w-8 h-8 border-b-2 border-r-2 border-transparent 
                        group-hover:border-purple-500/30 transition-all duration-500 rounded-br-lg"></div>
        </div>
    @endforeach
</div>

<div class="mt-[50px] max-w-7xl mx-auto px-4 mb-12">
    <div class="relative rounded-2xl overflow-hidden shadow-2xl group cursor-pointer">
        <div class="relative aspect-video overflow-hidden">
            <img 
                src="{{ asset('images/devgroup.jpg') }}" 
                alt="Development Team Group Photo" 
                class="w-full h-full object-cover transform transition-all duration-700 
                       group-hover:scale-110 group-hover:rotate-1"
            >
            
            <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-500
                        bg-gradient-to-r from-purple-500/30 via-pink-500/30 to-cyan-500/30 
                        animate-gradient-xy mix-blend-overlay"></div>
            
            <div class="absolute inset-0 opacity-0 group-hover:opacity-20 transition-opacity duration-500
                        bg-[linear-gradient(45deg,transparent_25%,rgba(255,255,255,0.3)_50%,transparent_75%)]
                        bg-[length:200%_200%] animate-shimmer"></div>
        </div>

        <div class="absolute inset-0 flex flex-col justify-end p-6 transform transition-all duration-500">
            <div class="relative transform transition-all duration-500 translate-y-20 group-hover:translate-y-0">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent 
                            backdrop-blur-sm transform transition-all duration-500 scale-y-0 group-hover:scale-y-100 
                            origin-bottom"></div>
                
                <div class="relative z-10 text-white opacity-0 group-hover:opacity-100 
                            transition-all duration-500 delay-100">
                    <h3 class="text-3xl font-bold mb-2 transform translate-y-10 group-hover:translate-y-0 
                               transition-transform duration-500 delay-200">
                        Development Team
                    </h3>
                    <p class="text-lg text-gray-200 transform translate-y-10 group-hover:translate-y-0 
                              transition-transform duration-500 delay-300">
                        Working together to create innovative solutions
                    </p>
                </div>
            </div>
        </div>

        <div class="absolute top-4 left-4 w-10 h-10 border-t-2 border-l-2 border-white/50 opacity-0 
                    group-hover:opacity-100 transition-all duration-500 delay-200 
                    transform -translate-x-2 -translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0"></div>
        <div class="absolute bottom-4 right-4 w-10 h-10 border-b-2 border-r-2 border-white/50 opacity-0 
                    group-hover:opacity-100 transition-all duration-500 delay-200 
                    transform translate-x-2 translate-y-2 group-hover:translate-x-0 group-hover:translate-y-0"></div>
    </div>
</div>

<style>
@keyframes gradient-xy {
    0%, 100% {
        background-position: 0% 0%;
    }
    50% {
        background-position: 100% 100%;
    }
}

@keyframes shimmer {
    0% {
        background-position: -200% -200%;
    }
    100% {
        background-position: 200% 200%;
    }
}

.animate-gradient-xy {
    animation: gradient-xy 15s ease infinite;
}

.animate-shimmer {
    animation: shimmer 3s linear infinite;
}

/* Enhanced name hover effects */
.name-container h3::before {
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: radial-gradient(circle at center, rgba(99, 102, 241, 0.1) 0%, transparent 70%);
    opacity: 0;
    transform: scale(0.8);
    transition: all 0.3s ease;
    z-index: -1;
}

.name-container:hover h3::before {
    opacity: 1;
    transform: scale(1.2);
}

/* Hover card animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0) translateX(-50%);
    }
    50% {
        transform: translateY(-5px) translateX(-50%);
    }
}

.name-container:hover .absolute {
    animation: float 2s ease-in-out infinite;
}

/* Enhanced social links */
.social-link {
    @apply p-2 rounded-full bg-gray-50 text-gray-600 hover:text-white transition-all duration-300;
}

.social-link[title="GitHub"]:hover {
    @apply bg-gray-800;
}

.social-link[title="Facebook"]:hover {
    @apply bg-blue-600;
}

.social-link[title="Email"]:hover {
    @apply bg-red-500;
}

/* Add a subtle pulse animation for the role badge */
@keyframes subtle-pulse {
    0%, 100% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.05);
    }
}

.member-role:hover {
    animation: subtle-pulse 2s infinite;
}

.social-icon-link {
    transform: translateY(0);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.social-icon-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.social-icon-link::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 9999px;
    background: radial-gradient(circle at center, rgba(255,255,255,0.8) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.3s ease;
}

.social-icon-link:hover::after {
    opacity: 0.15;
}

/* Specific hover colors for social icons */
.social-icon-link[title="Facebook"]:hover {
    background-color: #1876f281;
    box-shadow: 0 10px 20px rgba(24, 119, 242, 0.3);
}

.social-icon-link[title="Email"]:hover {
    background-color: #ea443585;
    box-shadow: 0 10px 20px rgba(234, 67, 53, 0.3);
}

.social-icon-link[title="GitHub"]:hover {
    background-color: #8a8a8a80;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
}
</style> 