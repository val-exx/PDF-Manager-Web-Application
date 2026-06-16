/* ============================================================
   Gestiva — interazioni (vanilla JS, nessuna dipendenza)
   ============================================================ */
(function () {
  'use strict';

  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---- Menu mobile ---- */
  function initMenu() {
    var btn = document.getElementById('menuBtn');
    var sidebar = document.getElementById('sidebar');
    var scrim = document.getElementById('scrim');
    if (!btn || !sidebar) return;
    function open() { sidebar.classList.add('open'); if (scrim) scrim.classList.add('show'); }
    function close() { sidebar.classList.remove('open'); if (scrim) scrim.classList.remove('show'); }
    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      sidebar.classList.contains('open') ? close() : open();
    });
    if (scrim) scrim.addEventListener('click', close);
    sidebar.querySelectorAll('a').forEach(function (a) { a.addEventListener('click', close); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') close(); });
  }

  /* ---- Contatori animati ---- */
  function formatNumber(n, dec) {
    var s = (dec > 0) ? n.toFixed(dec) : String(Math.round(n));
    var parts = s.split('.');
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    return parts.length > 1 ? parts[0] + ',' + parts[1] : parts[0];
  }

  function animateCount(el) {
    if (el.dataset.done) return;
    el.dataset.done = '1';
    var to = parseFloat(el.dataset.to) || 0;
    var dec = parseInt(el.dataset.dec || '0', 10);
    var suffix = el.dataset.suffix || '';
    if (reduce || to === 0) { el.textContent = formatNumber(to, dec) + suffix; return; }
    var dur = 900, start = null;
    function step(ts) {
      if (start === null) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      el.textContent = formatNumber(to * eased, dec) + suffix;
      if (p < 1) requestAnimationFrame(step);
      else el.textContent = formatNumber(to, dec) + suffix;
    }
    requestAnimationFrame(step);
  }

  function initCounters() {
    var counts = Array.prototype.slice.call(document.querySelectorAll('.count'));
    if (!counts.length) return;
    if (!('IntersectionObserver' in window)) { counts.forEach(animateCount); return; }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) { animateCount(entry.target); io.unobserve(entry.target); }
      });
    }, { threshold: 0.4 });
    counts.forEach(function (c) { io.observe(c); });
  }

  /* ---- Chiudi i mini-menu (details) cliccando fuori ---- */
  function initMenusDismiss() {
    document.addEventListener('click', function (e) {
      document.querySelectorAll('details.mini-menu[open]').forEach(function (d) {
        if (!d.contains(e.target)) d.removeAttribute('open');
      });
    });
  }

  /* ---- Apri il pannello "nuovo" se il form ha errori? (no-op base) ---- */

  function init() {
    initMenu();
    initCounters();
    initMenusDismiss();
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
