# Wood Expert Industry – tema WordPress (frontend)

## Obiectiv
Tema custom pentru woodexpert.ro. Înlocuiește Flatsome și păstrează WordPress, WooCommerce, Rank Math Pro și ACF Pro ca backend. Design light, curat, inspirat din Untitled UI. Referința vizuală este în `design/Light.dc.html` (desktop) și `design/LightMobile.dc.html` (mobil), iar tokenii sunt în `design/light.css`.

## Reguli obligatorii
- **Fără Flatsome** în tema nouă. Niciun shortcode `[ux_*]`, `[col]`, `[row]`, `[section]`, `[gap]`, `[divider]` în cod.
- **Fără Gravity Forms.** Nicio referință la `gravityform`, `gform_`, `GFForms` sau `gravityforms` în repo. Formularele vechi nu mai există și nu se reintroduc.
- **Formularul de ofertă este nativ**, nu iframe. Datele se salvează în WordPress. CRM-ul le trage printr-un endpoint REST protejat cu autentificare. Nu trimitem date direct din browser către CRM.
- **Limba română.** Adresare la „tu”. Diacritice corecte: ș și ț cu virgulă dedesubt, nu sedilă.
- **Terminologie tehnică** (din `docs/glosar.md`): „mașină de aplicat cant” (nu „placare cant”), „cant” (nu „rost”), „muchie” (nu „colț”), „batiu” (nu „corp”), „volante din fontă” (nu „volanți”).
- **Culori:** maro `#461D03` (text principal, secțiuni închise), portocaliu `#F39438` (accente și CTA), verde `#3FB353` (în stoc, bife), oliv `#A6A867`, crem `#E3DC95`, alb cald `#F9F9F9`. Fără `#000000`. Pe portocaliu, verde, oliv și crem, textul e maro, niciodată alb.
- **Font:** Inter Tight, din Google Fonts sau self-hosted.
- **Logo:** doar fișierele din `assets/logo/`. Nu se deformează, nu se recolorează, nu se reconstruiește cu font. Sloganul „Limitless technology” nu se traduce.
- **Producători:** doar cei din `docs/producatori.md`. Sceat și Storti nu mai apar nicăieri.
- **Regiuni:** pe Vest și Nord-Vest, consultantul este Radu Munteanu.
- **Date de contact:** 0732.672.147, office@woodexpert.ro, Str. Albinelor nr. 7, sector 4, 040431 București.

## Secrete și siguranță
- Nu comite niciodată parole, chei SSH (`.pem`, `.ppk`, `id_*`), `wp-config.php`, dump-uri SQL sau fișiere `.env`. Verifică `.gitignore` înainte de primul commit.
- **Lucrăm doar pe staging** până la confirmarea explicită a lansării. Nu facem deploy pe producție fără aprobare.
- Înainte de orice comandă `wp` care modifică date (`search-replace`, `db import`, `plugin delete`), rulăm întâi backup și dry-run. Pe producție, doar cu confirmare.

## Stiva tehnică
- PHP 8.x, WordPress, WooCommerce, ACF Pro, Rank Math Pro.
- Tailwind CSS (build cu npm), Alpine.js pentru interacțiuni: mega-meniu, slider hero, taburi, FAQ, drawer mobil.
- Secțiuni editabile ca blocuri ACF. Șabloane PHP pentru header, footer, homepage, categorii, produs, producători, montaje, blog.
- Pregătit pentru un eventual frontend headless: date structurate în ACF și WPGraphQL activ.

## Structură repo
```
wood-expert-theme/
  style.css, functions.php, index.php
  inc/            setup, enqueue, acf, woocommerce, seo, quote-endpoint
  template-parts/ header, footer, mega-menu, hero, stats, clients, ...
  blocks/         blocuri ACF
  templates/      homepage, categorie, produs, producători, montaje, blog
  assets/         logo/, img/, css/, js/
  design/         referința din canvas (doar pentru citire)
  docs/           producatori.md, glosar.md, progres.md
  plugins/we-legacy-shortcodes/   TEMPORAR, se șterge la lansare
```

## Mod de lucru
- O ramură pe fază. Un pull request pentru fiecare fază.
- Fiecare fază se verifică pe staging, pe subdomeniul de test, înainte de merge.
- Ținem `docs/progres.md` la zi: ce e făcut, ce e în lucru, ce rămâne, întrebările deschise.
- Când o cerință din acest fișier intră în conflict cu o cerere punctuală, întrebăm înainte să modificăm.

## Faze
1. **Fundație:** tema, Tailwind, Alpine, tokenii din `design/light.css`, header cu mega-meniu, drawer mobil, footer.
2. **Homepage:** blocuri ACF pentru hero slider, cifre, clienți, taburi utilaje, secțiunea „De ce Wood Expert”, montaje, producători, cataloage, regiuni, FAQ, CTA.
3. **WooCommerce:** șablon de categorie, fișă de produs cu butonul de ofertă, grila de producători.
4. **Șabloane restante:** montaje, blog, pagini generale.
5. **Formular de ofertă nativ** și endpoint REST protejat pentru CRM.
6. **Compatibilitate și migrare:** pluginul temporar `we-legacy-shortcodes` pentru shortcode-urile Flatsome, apoi conversia conținutului din articole, produse și pagini. Script pe staging, cu backup.
7. **SEO și performanță:** Rank Math (meta, schema, sitemap), viteză, redirect-uri dacă e necesar.
8. **Lansare și curățare:** comutarea temei pe producție, ștergerea pluginului temporar, a tabelelor și a opțiunilor Gravity Forms. La final, `grep -ri "gravity\|gform\|flatsome\|\[ux_\|\[col\|\[row\|\[section" wood-expert-theme/` trebuie să returneze zero rezultate.

## Întrebări deschise
- Plugin SEO: Rank Math Pro (confirmat). Rank Math gratuit se dezinstalează.
- Litespeed Cache sau Perfmatters: de ales unul după testarea pe staging.
- Pluginurile `linie-debitare`, `we-hero-triptych`, `dropdown-buttons` și `banner-insert` sunt proprii. Logica lor se păstrează, shortcode-urile se mută în temă.
