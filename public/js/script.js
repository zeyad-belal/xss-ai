document.addEventListener('DOMContentLoaded', function() {
    // Toggle mobile menu
    const navbar = document.querySelector('.navbar');
    const menuBtn = document.createElement('button');
    menuBtn.className = 'menu-btn';
    menuBtn.innerHTML = '☰';
    document.querySelector('.header').insertBefore(menuBtn, navbar);

    menuBtn.addEventListener('click', () => {
        navbar.classList.toggle('active');
    });

    // Menu functionality
    const menu = document.querySelector('#menu-btn');
    const headerNavbar = document.querySelector('.header .navbar');

    if (menu && headerNavbar) {
        menu.onclick = () => {
            menu.classList.toggle('fa-times');
            headerNavbar.classList.toggle('active');
        };

        window.onscroll = () => {
            menu.classList.remove('fa-times');
            headerNavbar.classList.remove('active');
        };
    }

    // Form handling with AJAX
    const form = document.querySelector('form');
    if (form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.textContent : '';
        const textarea = form.querySelector('textarea[name="input"]');
        const scannerContainer = document.querySelector('.scanner-container');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            if (submitBtn && textarea) {
                submitBtn.textContent = 'Scanning...';
                submitBtn.disabled = true;

                // Create FormData object
                const formData = new FormData();
                formData.append('input', textarea.value);

                // Send AJAX request
                fetch(window.location.href, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.text())
                .then(html => {
                    // Create a temporary div to parse the HTML
                    const tempDiv = document.createElement('div');
                    tempDiv.innerHTML = html;
                    
                    // Get the new result container from the response
                    const newResultContainer = tempDiv.querySelector('.result-container');
                    
                    if (newResultContainer) {
                        // Find existing result container
                        let resultContainer = scannerContainer.querySelector('.result-container');
                        
                        if (resultContainer) {
                            // Replace existing result container
                            resultContainer.innerHTML = newResultContainer.innerHTML;
                        } else {
                            // Create new result container after the form
                            form.insertAdjacentElement('afterend', newResultContainer);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Create or update error container
                    let resultContainer = scannerContainer.querySelector('.result-container');
                    if (!resultContainer) {
                        resultContainer = document.createElement('div');
                        resultContainer.className = 'result-container';
                        form.insertAdjacentElement('afterend', resultContainer);
                    }
                    resultContainer.innerHTML = '<div class="error">Error: Failed to process request. Please try again.</div>';
                })
                .finally(() => {
                    submitBtn.textContent = originalBtnText;
                    submitBtn.disabled = false;
                });
            }
        });
    }

    // Initialize Swiper sliders
    new Swiper(".home-slider", {
        loop: true,
        spaceBetween: 20,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });

    new Swiper(".services-slider", {
        loop: true,
        spaceBetween: 20,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            450: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
        },
    });

    new Swiper(".reviews-slider", {
        loop: true,
        spaceBetween: 20,
        grabCursor: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            450: {
                slidesPerView: 1,
            },
            768: {
                slidesPerView: 2,
            },
            1000: {
                slidesPerView: 3,
            },
        },
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // Auto-resize textarea
    const textarea = document.querySelector('textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
