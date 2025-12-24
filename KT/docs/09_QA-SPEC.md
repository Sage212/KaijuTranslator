# 09 — QA automático (Quality Gate)

## 1. Objetivo
No indexar traducciones rotas y mantener credibilidad del sistema.

## 2. Checks mínimos (por URL traducida)
- Integridad HTML:
  - `<head>` y `<body>` presentes
  - tags esenciales no desaparecen
- Detección de idioma:
  - la salida debe ser mayoritariamente idioma destino
- Ratio “sin traducir”:
  - si queda demasiado texto base, falla
- Preservación estructural:
  - nav/main/footer no deben desaparecer por error
- Metadatos:
  - title y description no vacíos

## 3. Score y umbral
- Score 0–100
- Umbral configurable por idioma

## 4. Política si falla
- `serve_translated_noindex` (recomendado):
  - servir traducción para debug
  - añadir `noindex, follow`
  - excluir de sitemap
- Alternativa:
  - `fallback_base`: servir idioma base directamente

## 5. Retraducción
- Una URL `failQA` se marca para retraducción.
- El builder puede reintentar en lote.

## 6. Impacto en sitemaps
- URLs `failQA` NO entran en sitemaps (por defecto).
- URLs `ok` sí entran y actualizan `lastmod`.
