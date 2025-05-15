// resources/js/carousel.js

document.addEventListener('DOMContentLoaded', () => {
  const prevBtn = document.querySelector('.section-platillos .nav-button.prev');
  const nextBtn = document.querySelector('.section-platillos .nav-button.next');
  const container = document.querySelector('.section-platillos .platillos-container');
  const cards = Array.from(container.querySelectorAll('.platillo-card'));
  if (!prevBtn || !nextBtn || cards.length === 0) return;

  // Calcula ancho de tarjeta (incluye márgenes)
  const style = getComputedStyle(cards[0]);
  const cardWidth = cards[0].getBoundingClientRect().width +
    parseFloat(style.marginLeft) + parseFloat(style.marginRight);

  let visibleCount = Math.floor(container.parentElement.offsetWidth / cardWidth);
  let index = 0;

  // Actualiza índice en botones y efecto de elevación
  function updateUI() {
    // Limita índice
    const maxIndex = cards.length - visibleCount;
    index = Math.max(0, Math.min(index, maxIndex));

    // Mueve carrusel
    container.style.transform = `translateX(-${index * cardWidth}px)`;

    // Actualiza data-index y texto en botones (opcional)
    prevBtn.dataset.index = index;
    nextBtn.dataset.index = index;

    // Efecto selected: agrega clase a tarjetas visibles
    cards.forEach((card, i) => {
      if (i >= index && i < index + visibleCount) {
        card.classList.add('selected');
      } else {
        card.classList.remove('selected');
      }
    });
  }

  // Eventos de navegación
  prevBtn.addEventListener('click', () => {
    index -= visibleCount;
    updateUI();
  });
  nextBtn.addEventListener('click', () => {
    index += visibleCount;
    updateUI();
  });

  // Recalcula al redimensionar
  window.addEventListener('resize', () => {
    visibleCount = Math.floor(container.parentElement.offsetWidth / cardWidth);
    index = 0;
    updateUI();
  });

  // Inicializa UI
  updateUI();
});
