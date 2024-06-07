
// membuat perpindahan section lebih smooth
document.addEventListener('DOMContentLoaded', () => {
    const links = document.querySelectorAll('.navbar-menu a');

    for (const link of links) {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            const targetId = link.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);

            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - document.querySelector('header').offsetHeight,
                    behavior: 'smooth'
                });
            }
        });
    }
});





document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('section'); 
window.addEventListener('scroll', () => {
    let current = '';

    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        if (pageYOffset >= sectionTop - sectionHeight / 3) {
            current = section.getAttribute('id');
        }
    });

    const navLinks = document.querySelectorAll('.navbar-menu a');
    navLinks.forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').substring(1) === current) {
            link.classList.add('active');
        }
    });
});
});







const loginBtn = document.getElementById('loginBtn');
    const loginFormContainer = document.getElementById('loginFormContainer');
    const createAccountBtn = document.getElementById('createAccountBtn');
    const backToLoginBtn = document.getElementById('backToLoginBtn');
    const loginForm = document.getElementById('loginForm');
    const createAccountForm = document.getElementById('createAccountForm');

    loginBtn.addEventListener('click', (event) => {
        event.preventDefault();
        loginFormContainer.style.display = loginFormContainer.style.display === 'block' ? 'none' : 'block';
        createAccountForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });

    createAccountBtn.addEventListener('click', (event) => {
        event.preventDefault();
        loginForm.style.display = 'none';
        createAccountForm.style.display = 'flex';
    });

    backToLoginBtn.addEventListener('click', (event) => {
        event.preventDefault();
        createAccountForm.style.display = 'none';
        loginForm.style.display = 'flex';
    });

    document.addEventListener('click', (event) => {
        if (!loginFormContainer.contains(event.target) && event.target !== loginBtn) {
            loginFormContainer.style.display = 'none';
        }
    });





  

