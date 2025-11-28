const showToast = (msg) => {
  const toast = document.createElement("div");
  toast.className = "toast";
  toast.textContent = msg;
  document.body.appendChild(toast);

  setTimeout(() => {
      toast.classList.add("show");
  }, 50);

  setTimeout(() => {
      toast.classList.remove("show");

      setTimeout(() => toast.remove(), 400);

  }, 1000);
};

document.addEventListener("DOMContentLoaded", () => {
  const cards = document.querySelectorAll(".card");
  cards.forEach(card => {
      card.style.opacity = "0";
      card.style.transform = "translateY(10px)";
      
      setTimeout(() => {
          card.style.transition = "0.5s ease";
          card.style.opacity = "1";
          card.style.transform = "translateY(0)";
      }, 150);
  });
});


const inputs = document.querySelectorAll("input, select");

inputs.forEach(input => {
  input.addEventListener("focus", () => {
      input.style.boxShadow = "0 0 8px rgba(90,170,255,0.8)";
      input.style.transition = "0.2s";
  });

  input.addEventListener("blur", () => {
      input.style.boxShadow = "none";
  });
});

const form = document.querySelector("form");
const submitBtn = document.querySelector("button[type='submit']");

if (form && submitBtn) {
  const checkForm = () => {
      let valid = true;

      inputs.forEach(i => {
          if (i.value.trim() === "") valid = false;
      });

      submitBtn.disabled = !valid;
      submitBtn.style.opacity = valid ? "1" : "0.6";
      submitBtn.style.cursor = valid ? "pointer" : "not-allowed";
  };

  inputs.forEach(i => i.addEventListener("input", checkForm));

  checkForm(); 
}
