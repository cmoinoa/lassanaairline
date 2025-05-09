// theme.js

// Lire le cookie
function getCookie(name) {
  const cookies = document.cookie.split("; ");
  for (const c of cookies) {
    const [key, value] = c.split("=");
    if (key === name) return value;
  }
  return null;
}

// Écrire un cookie
function setCookie(name, value, days = 30) {
  const d = new Date();
  d.setTime(d.getTime() + (days*24*60*60*1000));
  document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
}

document.addEventListener("DOMContentLoaded", () => {
  const themeLink = document.getElementById("theme-link");
  const toggleBtn = document.getElementById("toggle-theme");

  const theme = getCookie("theme");
  if (theme === "sombre") {
    themeLink.href = "css/sombre.css";
  } else {
    themeLink.href = "css/clair.css";
  }

  toggleBtn.addEventListener("click", () => {
    const current = themeLink.getAttribute("href");
    if (current.includes("clair")) {
      themeLink.href = "css/sombre.css";
      setCookie("theme", "sombre");
    } else {
      themeLink.href = "css/clair.css";
      setCookie("theme", "clair");
    }
  });
});
