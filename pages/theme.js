// theme.js

function getCookie(name) {
  const cookies = document.cookie.split("; ");
  for (const c of cookies) {
    const [key, value] = c.split("=");
    if (key === name) return value;
  }
  return null;
}

function setCookie(name, value, days = 30) {
  const d = new Date();
  d.setTime(d.getTime() + (days*24*60*60*1000));
  document.cookie = `${name}=${value}; expires=${d.toUTCString()}; path=/`;
}

document.addEventListener("DOMContentLoaded", () => {
  const body = document.body;
  const toggleBtn = document.getElementById("toggle-theme");

  const theme = getCookie("theme");

  if (theme === "light") {
    body.classList.add("light");
  } else {
    body.classList.add("dark"); // par défaut sombre
  }

  toggleBtn.addEventListener("click", () => {
    if (body.classList.contains("dark")) {
      body.classList.replace("dark", "light");
      setCookie("theme", "light");
    } else {
      body.classList.replace("light", "dark");
      setCookie("theme", "dark");
    }
  });
});

