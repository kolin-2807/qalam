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
