document.addEventListener("DOMContentLoaded", () => {
    const forms = document.querySelectorAll("form");

    forms.forEach(form => {
        form.addEventListener("submit", function(event) {
            event.preventDefault();

            const button = form.querySelector("button");
            const select = form.querySelector("select");

            // Désactiver le bouton et le select
            button.disabled = true;
            select.disabled = true;

            const originalContent = button.innerHTML;
            button.innerHTML = `<span class="spinner"></span> Mise à jour...`;

            setTimeout(() => {
                button.innerHTML = originalContent;
                form.submit();
            }, 2000);
        });
    });
});
