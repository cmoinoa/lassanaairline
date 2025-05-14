document.addEventListener("DOMContentLoaded", () => {
  document.querySelectorAll(".toggle-vip").forEach(checkbox => {
    checkbox.addEventListener("change", () => {
      const user = checkbox.dataset.user;
      const isChecked = checkbox.checked;

      const row = checkbox.closest("tr");
      const spinner = row.querySelector(".spinner");
      const success = row.querySelector(".success");
      const error = row.querySelector(".error");

      spinner.style.display = "inline";
      success.style.display = "none";
      error.style.display = "none";

      fetch("update_vip.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `user=${encodeURIComponent(user)}&vip=${isChecked ? 1 : 0}`
      })
      .then(res => res.json())
      .then(data => {
        spinner.style.display = "none";
        if (data.success) {
          success.style.display = "inline";
        } else {
          error.style.display = "inline";
          checkbox.checked = !isChecked;
        }
      })
      .catch(() => {
        spinner.style.display = "none";
        error.style.display = "inline";
        checkbox.checked = !isChecked;
      });
    });
  });
});
