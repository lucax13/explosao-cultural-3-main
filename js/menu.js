document.addEventListener('DOMContentLoaded', function () {
  // Menu hamburguer
  const btn = document.getElementById('menuBtn');
  const menu = document.getElementById('menuNav');

  if (btn && menu) {
    btn.addEventListener('click', function () {
      menu.classList.toggle('show');
    });
  }

  // Modal dos posts
  const postCards = document.querySelectorAll(".post");
  const postModal = document.getElementById('postModal');
  const postModalFechar = document.querySelectorAll('.fechar-modal');

  if (postModal) {
    // Abrir modal ao clicar em cada card, se existir cards e modal
    if (postCards.length > 0) {
      postCards.forEach(card => {
        card.addEventListener('click', function () {
          postModal.style.display = 'block';
          postModal.offsetHeight; // Forçar reflow para animação
          postModal.classList.add('ativo');
          document.body.style.overflow = 'hidden';
        });
      });
    }

    // Função para fechar modal
    function fecharModal() {
      postModal.classList.remove('ativo');
      setTimeout(() => {
        postModal.style.display = 'none';
        document.body.style.overflow = 'auto';
      }, 300);
    }

    // Fechar modal ao clicar nos botões de fechar
    if (postModalFechar.length > 0) {
      postModalFechar.forEach(fechar => {
        fechar.addEventListener('click', fecharModal);
      });
    }

    // Fechar modal clicando fora da área modal
    window.addEventListener('click', function (event) {
      if (event.target === postModal) {
        fecharModal();
      }
    });
  }
});
