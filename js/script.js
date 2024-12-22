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

    // Form handling with direct ML service communication
    const form = document.querySelector('#scanForm');
    if (form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn ? submitBtn.textContent : '';
        const textarea = form.querySelector('textarea[name="input"]');
        const resultContainer = document.querySelector('.result-container');
        const resultContent = document.querySelector('#resultContent');

        form.addEventListener('submit', async function(e) {
            e.preventDefault();

            if (submitBtn && textarea) {
                submitBtn.textContent = 'Scanning...';
                submitBtn.disabled = true;

                try {
                    // Send request to ML service
                    const response = await fetch('http://localhost:5001/analyze', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ input: textarea.value })
                    });

                    if (!response.ok) {
                        throw new Error('ML service returned error');
                    }

                    const result = await response.json();

                    // Show result container
                    resultContainer.style.display = 'block';

                    // Update result content
                    if (result.error) {
                        resultContent.innerHTML = `
                            <div class="error">Error: ${result.error}</div>
                        `;
                    } else {
                        resultContent.innerHTML = `
                            <div class="result ${result.is_xss ? 'danger' : 'safe'}">
                                <p>Status: ${result.is_xss ? 'Potential XSS Detected!' : 'Safe'}</p>
                                <p>Confidence: ${(result.confidence * 100).toFixed(2)}%</p>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Error:', error);
                    resultContainer.style.display = 'block';
                    resultContent.innerHTML = `
                        <div class="error">Error: Failed to process request. Please try again.</div>
                    `;
                } finally {
                    submitBtn.textContent = originalBtnText;
                    submitBtn.disabled = false;
                }
            }
        });
    }

    // Auto-resize textarea
    const textarea = document.querySelector('textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }
});
