/**
 * Wood Expert – interacțiuni (Alpine.js)
 * Build: npm run build:js
 */
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import collapse from '@alpinejs/collapse';

Alpine.plugin(focus);
Alpine.plugin(collapse);

// Stare comună între header, drawer și panoul de căutare.
Alpine.store('ui', {
  drawer: false,
  search: false,
  openDrawer() {
    this.search = false;
    this.drawer = true;
  },
  closeDrawer() {
    this.drawer = false;
  },
  toggleSearch() {
    this.search = !this.search;
  },
});

// Mega-meniul din header (desktop).
Alpine.data('weMega', () => ({
  menu: null,
  closeTimer: null,
  hoverOpened: false,
  open(i) {
    clearTimeout(this.closeTimer);
    this.$store.ui.search = false;
    this.menu = i;
  },
  // Doar mouse-ul deschide la hover; pe touch, atingerea declanșează click (toggle).
  hover(e, i) {
    if (e.pointerType !== 'mouse' || this.menu === i) return;
    this.open(i);
    this.hoverOpened = true;
  },
  // Primul click după ce hover-ul a deschis panoul îl lasă deschis; altfel comută.
  click(i) {
    if (this.menu === i && this.hoverOpened) {
      this.hoverOpened = false;
      return;
    }
    this.toggle(i);
  },
  toggle(i) {
    this.$store.ui.search = false;
    this.hoverOpened = false;
    this.menu = this.menu === i ? null : i;
  },
  close() {
    this.hoverOpened = false;
    this.menu = null;
  },
  // Mică întârziere la ieșirea mouse-ului, ca să nu se închidă la mișcări scurte.
  leave() {
    clearTimeout(this.closeTimer);
    this.closeTimer = setTimeout(() => this.close(), 120);
  },
  // Închide panoul când focusul (tastatură) iese din header.
  focusOut(e) {
    if (!this.$root.contains(e.relatedTarget)) this.close();
  },
}));

// Drawer-ul mobil: o singură secțiune deschisă la un moment dat.
Alpine.data('weDrawer', () => ({
  section: null,
  toggle(i) {
    this.section = this.section === i ? null : i;
  },
}));

// Formularul de newsletter: încă nu are backend (vezi docs/progres.md).
// Nu trimitem nimic: afișăm doar un mesaj, ca să nu pară că abonarea a reușit.
Alpine.data('weNewsletter', () => ({
  notice: false,
  submit() {
    this.notice = true;
  },
}));

window.Alpine = Alpine;
Alpine.start();
