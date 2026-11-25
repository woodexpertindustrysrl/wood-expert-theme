# Progres – tema Wood Expert

Ultima actualizare: 25.11.2026

## Pe scurt

| Fază | Stare |
|---|---|
| 1. Fundație | **În lucru** (ramura `faza-1-fundatie`, codul e scris, încă netestat pe staging) |
| 2. Homepage | De făcut |
| 3. WooCommerce | De făcut |
| 4. Șabloane restante | De făcut |
| 5. Formular de ofertă nativ + endpoint REST | De făcut |
| 6. Compatibilitate și migrare | De făcut |
| 7. SEO și performanță | De făcut |
| 8. Lansare și curățare | De făcut |

## Faza 1: Fundație

### Ce e făcut
- **Structura temei** în rădăcina repo-ului: `style.css`, `functions.php`, `index.php`, `header.php`, `footer.php`, `inc/`, `template-parts/`, `assets/`.
- **Build:** Tailwind CSS v4 (`@tailwindcss/cli`) și esbuild pentru JS. Comenzi: `npm install`, apoi `npm run build` (sau `watch:css` / `watch:js` în dezvoltare). Fișierele generate (`assets/css/theme.css`, `assets/js/theme.js`) sunt comise, ca tema să meargă urcată direct pe server, fără Node.
- **Tokeni din `design/light.css`** mutați în `@theme` (`assets/css/src/main.css`): culori (`maro`, `or`, `vd`, `ol`, `cr`, `alb`, `sand-*`, `line`, `tx`, `tx-2`, `mut`), umbre `xs/sm/lg/xl`, font Inter Tight, breakpoint-uri `tab` (761px) și `desk` (1181px), ca în design. Paleta implicită Tailwind e eliminată, deci nu există `black` sau alte culori din afara brandului.
- **Componente CSS:** `wrap`, `btn` + `btn-primary` / `btn-ghost` / `btn-accent`, `ico-btn`, `eyebrow`, `chip`, `field`, `icon`. Butonul accent e portocaliu cu text maro.
- **Alpine.js** (+ pluginurile `focus` și `collapse`): store comun `ui` (drawer, căutare), componentele `weMega`, `weDrawer`, `weNewsletter`.
- **Bara de sus** (maro): anunț, telefon, e-mail, „Zonă clienți” (apare doar dacă e setat URL-ul).
- **Header sticky** cu logo, navigare, căutare, buton „Cere ofertă” și burger sub 1180px.
- **Mega-meniu:** se deschide la hover cu mouse-ul și la click/Enter, se închide cu Esc, la ieșirea mouse-ului sau când focusul iese din header. Pe touch, atingerea comută panoul. Panoul are lista de categorii cu badge (numărul de produse, calculat automat pentru categoriile WooCommerce) și cardul cu imagine, etichetă și titlu.
- **Drawer mobil:** panou din dreapta cu secțiuni pliabile, focus blocat în drawer (`x-trap`), scroll blocat pe pagină, închidere cu Esc sau click pe fundal, CTA și buton de apel.
- **Panou de căutare** sub header (caută în produse dacă WooCommerce e activ).
- **Footer:** logo, descriere, newsletter, trei coloane de linkuri, contact (adresă, telefon, e-mail, Google Maps, Waze), Companie, rețele sociale, linkuri ANPC/SOL, copyright, linkuri legale, cuvântul decorativ „WOOD EXPERT”.
- **Buton plutitor WhatsApp** (apare doar dacă numărul e setat).
- **ACF Pro**, câmpuri înregistrate din cod (versionate):
  - pagina **„Setări temă”**: contact, bara de sus, CTA header, text footer, newsletter, rețele sociale, WhatsApp;
  - pe elementele meniului principal: imaginea, eticheta și titlul cardului din mega-meniu, plus un badge opțional.
- **Locații de meniu:** `primary`, `footer-primara`, `footer-secundara`, `footer-producatori`, `footer-companie`, `legal`. Cât timp o locație nu are meniu atribuit, se afișează structura din design (cu linkuri `#`), ca să se poată vedea layout-ul pe staging.
- **Accesibilitate:** link „Sari la conținut”, `aria-expanded` / `aria-controls` pe meniuri, etichete pentru butoanele cu iconițe, `prefers-reduced-motion` respectat, ținte de atingere de 44px.
- **`.gitignore`** (secrete, `wp-config.php`, chei, dump-uri SQL, `.env`) și **`.distignore`** (ce nu se urcă pe server: `design/`, `docs/`, `node_modules/`, sursele CSS/JS).

### Abateri mici de la design, intenționate
- Titlul portocaliu din mega-meniu folosește `or-ink` (#9A5B1E), un portocaliu mai închis, pentru contrast AA pe alb. În design era `#F39438` cu `brightness(.72)`, care nu trecea pragul AA la 14px.
- Iconițele rețelelor sociale rămân abrevieri text („Fb”, „Ig”...), ca în design.
- La mouse, mega-meniul se închide cu o întârziere de 120 ms, ca să nu dispară la mișcări scurte ale cursorului.

### Ce rămâne în Faza 1
- [ ] Adăugarea fișierelor de logo în `assets/logo/` (vezi `assets/logo/README.md`).
- [ ] Test pe staging: activarea temei, configurarea meniurilor și a „Setări temă”, verificare desktop și mobil (Chrome, Safari iOS, Android).
- [ ] Verificare vizuală față de `design/Light.dc.html` și `design/LightMobile.dc.html`.
- [ ] Pull request `faza-1-fundatie` → `main`, după verificarea pe staging.

### Neverificat încă
- PHP-ul nu a fost rulat: pe mașina locală nu există PHP, iar pornirea unui WordPress local (WordPress Playground) a fost blocată de permisiunile sesiunii. Codul a fost revizuit manual. Prima rulare reală va fi pe staging.
- Build-ul CSS/JS rulează fără erori, iar clasele folosite în șabloane apar în CSS-ul generat.

## Întrebări deschise
1. **Lipsesc fișiere de referință** menționate în CLAUDE.md: `design/LightMobile.dc.html`, `docs/producatori.md`, `docs/glosar.md` și conținutul din `assets/logo/`. Până le primim:
   - versiunea mobilă urmează regulile responsive din `design/light.css`;
   - lista de producători din footer e cea din `Light.dc.html` (Nanxing, Primultini, Paul Maschinenfabrik, Baschild, Giardina Group, O.M.A.R., Nova Pellet, Wravor) și trebuie verificată cu `docs/producatori.md`;
   - în locul logo-ului apare un spațiu rezervat cu textul „Logo lipsă”. Logo-ul nu e reconstruit din text.
2. **Newsletter:** ce serviciu folosim (de ex. Brevo)? Deocamdată formularul nu trimite nimic și afișează „Abonarea la newsletter va fi disponibilă în curând”.
3. **WhatsApp:** pe ce număr? Butonul plutitor apare doar după ce numărul e completat în „Setări temă”.
4. **Rețele sociale:** URL-urile oficiale (Facebook, Instagram, LinkedIn, YouTube, TikTok, Pinterest). Se afișează doar cele completate.
5. **URL „Cere ofertă”:** implicit `/cere-oferta/`. Pagina și formularul nativ vin în Faza 5; confirmăm slug-ul.
6. **Anunțul din bara de sus:** textul implicit e cel din design (BIFE-SIM 2026). Se schimbă din „Setări temă”.
7. **Font:** acum se încarcă din Google Fonts. Propunere: îl găzduim local în Faza 7 (performanță și GDPR).
8. **Litespeed Cache sau Perfmatters:** de ales după testarea pe staging (din CLAUDE.md).
9. **Pluginurile proprii** `linie-debitare`, `we-hero-triptych`, `dropdown-buttons`, `banner-insert`: logica se păstrează, shortcode-urile se mută în temă (Faza 6).
