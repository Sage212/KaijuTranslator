# 10 — Seguridad y privacidad

## 1. Qué datos se envían al traductor
- Solo texto extraído del HTML final y metadatos necesarios (title/description).
- Nunca se envían datos de formularios ni inputs.

## 2. Exclusión de zonas sensibles (default safe)
- `/admin`, `/login`, `/account`, `/checkout`, `/private`, etc.
- Páginas con sesión o usuario logado: no traducir, no cachear, no sitemap.

## 3. Gestión de claves API
- No hardcodear en repo.
- Prioridad:
  1) Variables de entorno
  2) Archivo local no versionado
- Rotación documentada.

## 4. Riesgos y mitigaciones
### 4.1. Cachear contenido privado
- Mitigación:
  - detección de sesión/cookies relevantes
  - exclusiones por defecto
  - “deny-by-default” para rutas sensibles

### 4.2. Inyección vía traducción
- Mitigación:
  - sanitizar texto antes de reinsertar
  - prohibir HTML nuevo desde traducción salvo lista blanca
  - validar DOM final

### 4.3. Loops internos
- Mitigación:
  - flag interno de captura base
  - bloquear captura de URLs con prefijo de idioma

## 5. Sitemaps y seguridad
- No incluir nunca URLs privadas en sitemaps.
- No incluir endpoints internos (`/kaiju-translator/*`), ni cache paths, ni paneles.
