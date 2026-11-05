// Menú móvil
const burger = document.getElementById('burger');
const nav = document.getElementById('nav');
if (burger && nav) burger.addEventListener('click', () => nav.classList.toggle('open'));

// Cursor personalizado (solo con mouse)
if (matchMedia('(pointer:fine)').matches) {
  const c = document.createElement('div');
  c.className = 'cursor';
  document.body.appendChild(c);
  addEventListener('mousemove', e => { c.style.left = e.clientX + 'px'; c.style.top = e.clientY + 'px'; });
  document.addEventListener('mouseover', e => {
    c.classList.toggle('grande', !!e.target.closest('a,button,label,.card'));
  });
}

// Confirmación en acciones destructivas
document.querySelectorAll('[data-confirmar]').forEach(el => {
  el.addEventListener('click', ev => { if (!confirm(el.dataset.confirmar)) ev.preventDefault(); });
});
