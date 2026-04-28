<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Patel Perfumes - Luxury Fragrances')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <style>
        :root {
            --primary: #8B6F47;
            --secondary: #F5E6D3;
            --accent: #D4AF37;
            --dark: #2C2C2C;
            --light: #FAFAF8;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--dark);
            background-color: var(--light);
        }

        .text-primary { color: var(--primary); }
        .bg-primary { background-color: var(--primary); }
        .text-accent { color: var(--accent); }
        .bg-accent { background-color: var(--accent); }
        .text-secondary { color: var(--secondary); }
        .bg-secondary { background-color: var(--secondary); }

        /* Scroll animations setup */
        .scroll-animate {
            opacity: 0;
        }

        .scroll-animate.active {
            opacity: 1;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .fade-in-up { animation: fadeInUp 0.6s ease-out; }
        .fade-in-left { animation: fadeInLeft 0.6s ease-out; }
        .fade-in-right { animation: fadeInRight 0.6s ease-out; }
    </style>
    @yield('styles')
</head>
<body>
    @include('layouts.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <script>
        gsap.registerPlugin(ScrollTrigger);

        // Initialize scroll animations
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in animations
            gsap.utils.toArray('[data-scroll-fade]').forEach((element) => {
                gsap.to(element, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Scale animations
            gsap.utils.toArray('[data-scroll-scale]').forEach((element) => {
                gsap.to(element, {
                    scale: 1,
                    opacity: 1,
                    duration: 0.8,
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 75%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });

            // Counter animations
            gsap.utils.toArray('[data-counter]').forEach((element) => {
                const endValue = parseInt(element.getAttribute('data-counter'));
                gsap.to(element, {
                    textContent: endValue,
                    duration: 2,
                    snap: { textContent: 1 },
                    scrollTrigger: {
                        trigger: element,
                        start: 'top 80%',
                        once: true
                    }
                });
            });

            // Staggered animations
            gsap.utils.toArray('[data-scroll-stagger]').forEach((container) => {
                const items = container.querySelectorAll('[data-stagger-item]');
                gsap.to(items, {
                    opacity: 1,
                    y: 0,
                    duration: 0.6,
                    stagger: 0.1,
                    scrollTrigger: {
                        trigger: container,
                        start: 'top 75%',
                        toggleActions: 'play none none reverse'
                    }
                });
            });
        });
    </script>
    @yield('scripts')
</body>
</html>
