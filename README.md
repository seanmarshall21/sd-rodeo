# San Diego Rodeo 2027 — splash page

Single static page, no build step. Deploys to Netlify (site `sd-rodeo-2027`) from the repo root.

- `index.html` — the flyer rebuilt as live HTML (top strip, logo, date, Petco Park, footnote) over the
  promo background, plus the email capture. Entrance animation is pure CSS and respects reduced-motion.
- `assets/img/wide/*.webp` — the desktop art as five layers (sky, cowboy, left, bottom-left and top-right paper pieces — `rt` is not used) from
  `BRANDING/Web/Splash`, positioned on a 1917x1039 stage in `index.html` so they can tear in on load.
- `assets/img/tall/` — phone layers: Sean's four paper pieces (`tr`, `tl`, `bl`, `botrt` from `BRANDING/Web/Splash/WebP`) plus
  `sky.webp`, which is an approximation built from the desktop sky (scaled, sat at the bottom, sky extended upward). The phone
  cowboy is the desktop `wide/cowboy.webp` scaled down. Replace `sky.webp` / the cowboy with real `mobile-bkgnd` / `mobile-cowboy`
  exports when they exist — same slots.
- `assets/img/bg-{tall,45}.{webp,jpg}` — flat promo backgrounds (bg-tall now unused; bg-45 drives the tablet layout) with the
  type layers removed. Made from the layered PSD/PSB files: hide the type groups, render with psd-tools,
  then colour-match that render to Sean's real export with a 3D LUT (psd-tools can't do the PSD's
  gradient-map / levels grading on its own). Which one loads depends on the screen's aspect ratio.
- `assets/logo/lockup.svg` — `BRANDING/Brand Elements/Logos/logo-lockup/sdr27--logo-lockup-dk.svg`, per Sean. Note: that export
  has no word spacing in the eyebrow ("OUTRIDERSPRESENT+FINESTCOLLECTIVE"); a fresh export from Figma would fix it.
  Do NOT use the logo smart objects inside the PSDs — their eyebrow wording is out of date.
- `assets/logo/badge.svg` — vector pulled out of the PSD's SECONDARY smart object.
- `assets/logo/petco-park.svg` — from `Rodeo Asset Pack/petco_park_logos.ai` (single-line variant).
- `assets/fonts/SDRodeoSpurVF.woff2` — SD Rodeo Spur variable font (wght 300–900, wdth 80–100).
- `assets/fonts/AcuminPro-{Medium,Semibold}.woff2` — subset from the Padres brand package OTFs (drawer copy).
- `netlify.toml` — publish dir + long cache on assets.

Source artwork: Dropbox › `_CRSSD/_INTERNAL/OUTRIDERS/SAN DIEGO RODEO/2027/` (`PROMOS/STD/PSD` for the
layered files, `BRANDING/Brand Elements` for fonts and palette). Figma also has the logo set:
https://www.figma.com/file/4NUPihRsj8m47iY2mxwyb8?node-id=971:588

The opt-in is a link to the Laylo drop https://laylo.com/sandiegorodeo/SDR2027 (Laylo refuses to be embedded in an iframe,
so it opens in a new tab). Sign-ups live in Laylo, not Netlify.

## Dropping it into rodeosd.com (WordPress)

`wordpress/sd-rodeo-splash.php` is a one-file plugin that registers `[sd_rodeo_splash]`. It outputs a
full-viewport iframe of the Netlify page. Netlify sends `Content-Security-Policy: frame-ancestors` allowing
rodeosd.com and www.rodeosd.com (see `netlify.toml`), so the frame works there and nowhere else.

1. Upload the `wordpress/` folder to `wp-content/plugins/` and activate **SD Rodeo Splash**
   (or paste the function + `add_shortcode` line into a Code Snippets snippet).
2. Make a page with a full-width / blank template (no sidebar, no padding) and put `[sd_rodeo_splash]` in it.
3. Optional: `[sd_rodeo_splash height="80vh"]` if the site header stays visible above it.

No-plugin fallback: a Custom HTML block with
`<iframe src="https://sd-rodeo-2027.netlify.app/" style="width:100%;height:100svh;border:0;display:block"></iframe>`.
