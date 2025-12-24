# 05 — Especificación de configuración

## 1. Configuración mínima (obligatoria)
- `base_lang`: idioma base (ej.: `es`)
- `languages`: idiomas activos (ej.: `["es","en","fr"]`)
- `translation_provider`: `deepseek` (o compatible)
- `api_key`: clave API (preferible en variables de entorno)
- `mode`:
  - `on_demand`: genera al visitar
  - `prebuild`: genera por lista de URLs (builder)

## 2. Descubrimiento de URLs (para stubs y sitemaps)
- `discovery_mode`:
  - `filesystem`: escanea `.php` en rutas permitidas
  - `sitemap`: usa un sitemap existente como entrada
  - `manual`: lista de entrypoints definida por el usuario
- `allowed_paths`: lista blanca de directorios escaneables
- `excluded_paths`: patrones de exclusión

## 3. Exclusiones (seguridad y estabilidad)
### 3.1. Rutas excluidas por patrón
- `/admin`, `/login`, `/private`, `/api`, etc.

### 3.2. Páginas excluidas por nombre
- `checkout.php`, `account.php`, `cart.php`, etc.

### 3.3. Parámetros excluidos
- `utm_*`, `gclid`, `fbclid`, etc.

### 3.4. Regla de sesión (por defecto)
- Si hay señales de usuario logado o sesión relevante:
  - no traducir
  - no cachear
  - no incluir en sitemaps

## 4. SEO (toggles)
- `hreflang.enabled` (default: true)
- `hreflang.x_default` (default: true en home/selector)
- `canonical.strategy`: `self` (default)
- `meta.translate_og`: true/false
- `robots.noindex_on_qafail`: true/false (default: true)

## 5. Sitemaps (config de publicación)
- `sitemaps.enabled`: true
- `sitemaps.base_path`: `/sitemaps/kaiju/`
- `sitemaps.index_name`: `sitemap-index.xml`
- `sitemaps.gzip`: true (recomendado)
- `sitemaps.chunk_max_urls`: 50000 (límite por archivo)
- `sitemaps.chunk_max_bytes_uncompressed`: 50MB (límite por archivo)
- `sitemaps.include_hreflang_in_sitemap`: true/false
- `sitemaps.include_lastmod`: true
- `sitemaps.lastmod_source`:
  - `html_hash_timestamp` (KaijuTranslator)
  - `file_mtime` (filesystem)
  - `custom` (hook/manual)

## 6. QA (calidad)
- `qa.min_score`: umbral 0–100
- `qa.policy_on_fail`:
  - `fallback_base`
  - `serve_translated_noindex` (recomendado)
- `qa.retry_schedule`:
  - reintentar traducción tras X horas/días

## 7. Cache
- `cache.storage`: `filesystem` (default) / `sqlite` (opcional)
- `cache.ttl_days`: recomendado 7–30 según tipo de web
- `cache.invalidate_on_base_hash_change`: true
