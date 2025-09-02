document.addEventListener("DOMContentLoaded", function () {
  const lightbox = document.getElementById("lightbox");
  const closeBtn = document.querySelector(".close-btn");
  const lightboxTitle = document.getElementById("lightbox-title");
  const lightboxImage = document.getElementById("lightbox-image");
  const lightboxDescription = document.getElementById("lightbox-description");
  const lightboxPrice = document.getElementById("lightbox-price");

  // Abre lightbox com dados do botão clicado
  document.querySelectorAll(".view-details").forEach((button) => {
    button.addEventListener("click", () => {
      lightboxTitle.textContent = button.dataset.name;
      lightboxImage.src = button.dataset.image;
      lightboxImage.alt = button.dataset.name;
      lightboxDescription.textContent = button.dataset.description;
      lightboxPrice.textContent = `Preço: €${button.dataset.price}`;
      lightbox.style.display = "flex";
    });
  });

  // Fecha lightbox
  closeBtn.addEventListener("click", () => {
    lightbox.style.display = "none";
  });

  // Fecha clicando fora do conteúdo
  window.addEventListener("click", (e) => {
    if (e.target === lightbox) {
      lightbox.style.display = "none";
    }
  });
});
