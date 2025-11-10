document.addEventListener('DOMContentLoaded', function() {
    
    // Function to load HTML components
    const loadComponent = async (componentPath, targetElementId) => {
        const targetElement = document.getElementById(targetElementId);
        if (!targetElement) {
            console.error(`Target element with ID "${targetElementId}" not found.`);
            return;
        }
        try {
            const response = await fetch(componentPath);
            if (!response.ok) {
                throw new Error(`Failed to fetch component: ${response.statusText}`);
            }
            const html = await response.text();
            targetElement.innerHTML = html;
        } catch (error) {
            console.error(`Error loading component from ${componentPath}:`, error);
            targetElement.innerHTML = `<p style="color: red;">Error loading ${targetElementId}.</p>`;
        }
    };

    // Load header and set active nav link
    const loadHeader = async () => {
        await loadComponent('_header.html', 'pageHeader');
        // Set active navigation link
        const currentPage = window.location.pathname.split('/').pop();
        const navLink = document.querySelector(`nav a[data-nav="${currentPage}"]`);
        if (navLink) {
            navLink.classList.add('active');
        }

        // Add header scroll effect after header is loaded
        // Add header scroll effect after header is loaded
const header = document.querySelector('header');
        if (header) {
            window.addEventListener('scroll', () => {
                if (window.scrollY > 80) { // Hide header if scrolled more than 80px
                    header.classList.add('hidden');
                } else { // Show header only when at the top of the page
                    header.classList.remove('hidden');
                }
            });
        }


        // Add hamburger menu functionality after header is loaded
const hamburger = document.getElementById('hamburger');
const navContainer = document.getElementById('navContainer');

if (hamburger && navContainer) {
    // Hide hamburger on desktop
    const toggleHamburgerVisibility = () => {
        if (window.innerWidth > 768) {
            hamburger.style.display = 'none';
            navContainer.classList.remove('active'); // ensure menu isn't open
        } else {
            hamburger.style.display = 'block';
        }
    };

    // Run on load and on window resize
    toggleHamburgerVisibility();
    window.addEventListener('resize', toggleHamburgerVisibility);

    // Mobile menu toggle
    hamburger.addEventListener('click', () => {
        navContainer.classList.toggle('active');
    });
}

    };

    // Load all shared components
    const loadAllComponents = async () => {
        await loadHeader();
        await loadComponent('_footer.html', 'pageFooter');
        await loadComponent('_authModal.html', 'authModal');
        // When auth.js is ready, it can be initialized here
        // initAuth(); 
    }

    loadAllComponents();
});