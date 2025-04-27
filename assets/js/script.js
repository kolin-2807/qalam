document.addEventListener("DOMContentLoaded", function () {
    function showForm(formId) {
        document.querySelectorAll(".form-box").forEach(form => form.classList.remove("active"));
        document.getElementById(formId).classList.add("active");

        const image = document.querySelector(".form-image");
        if (formId === "register-form") {
            image.style.setProperty("top", "-40px", "important"); 
        } else {
            image.style.setProperty("top", "40px", "important");
        }        
    }

    window.showForm = showForm;
});

let lastScrollTop = 0;
const footer = document.querySelector('.footer');

window.addEventListener('scroll', function() {
    let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

    if (currentScroll > lastScrollTop) {
        // Скроллим вниз — скрыть футер
        footer.classList.add('hidden');
    } else {
        // Скроллим вверх — показать футер
        footer.classList.remove('hidden');
    }

    lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; // Для предотвращения отрицательных значений
});
