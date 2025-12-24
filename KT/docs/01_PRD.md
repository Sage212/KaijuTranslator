# 01 — KaijuTranslator (PHP) — PRD (Product Requirements)

## 1. Visión
KaijuTranslator convierte una web PHP existente en multidioma con URLs por subcarpeta (por ejemplo `/en/`, `/fr/`) de forma **muy plug and play**, generando HTML traducido **indexable** y estable, **sin traducir slugs** (por ahora).

## 2. Objetivos
- Idiomas por **subcarpetas físicas** (no depende de cookies ni `Accept-Language`).
- Servir HTML completo traducido en servidor, con caché persistente.
- SEO internacional correcto: `hreflang`, canonical coherente, sitemaps i18n generados.
- Instalación rápida: “subir carpeta + pegar widget + ejecutar builder” (sin tocar servidor).

## 3. Alcance y límites (decisiones de producto)
### Incluido
- Render servidor: HTML final traducido (head + body).
- Caché de páginas y memoria de traducción (TM) por segmentos.
- QA automático: evitar indexar traducciones rotas.
- Generación de stubs físicos en `/en/` y demás idiomas (sin rewrites).
- Generación y mantenimiento de sitemaps (incluido sitemap index, rotación por tamaño y `lastmod`).

### Excluido (por ahora)
- Traducción de slugs y reescritura avanzada de enlaces para slugs.
- Integración con WordPress u otros CMS.
- Traducción de zonas privadas (login, cuenta, checkout, admin).
- Soporte completo de SPAs donde el contenido se genera en cliente.

## 4. Requisitos funcionales
### 4.1. Selector de idioma (widget)
- Debe imprimir un selector simple (p. ej. idiomas activos).
- Debe enlazar a la versión por subcarpeta: `/en/ruta-actual`.

### 4.2. Resolución de rutas (sin rewrites)
- Base: `/ruta`
- Idioma: `/en/ruta` (misma ruta/slug que el idioma base)
- La existencia de la URL traducida se consigue con:
  - subcarpeta física `/en/`
  - stubs físicos para entrypoints traducibles (generados por builder)

### 4.3. Traducción
- Extracción de texto visible + metadatos SEO (`title`, `description`, OG/Twitter si existen).
- Traducción con proveedor (DeepSeek o compatible), usando:
  - glosario (términos obligatorios / no traducibles)
  - TM (memoria de traducción) para consistencia y ahorro

### 4.4. Caché y QA
- Caché de HTML final traducido por (URL+idioma+hash contenido base).
- QA automático: si falla, no indexar esa URL traducida hasta corregir.
- Degradación segura si falla API:
  - servir idioma base, o
  - servir última traducción válida cacheada

### 4.5. SEO y sitemaps
- Inyectar `hreflang` recíproco.
- Canonical autoconsistente por idioma.
- Generar:
  - sitemap index
  - sitemaps por idioma (y, opcionalmente, por tipo si el sitio crece)
  - `lastmod` correcto en índice y en URLs
- Compatibilidad con límites de tamaño de sitemaps.

## 5. Requisitos no funcionales
- Compatible con hosting compartido (PHP estándar).
- No depender de cron (pero soportar “prebuild” si hay cron).
- Seguridad:
  - no cachear contenido personalizado por usuario
  - no enviar datos sensibles a la API

## 6. Criterios de éxito
- Instalación típica: 10–20 min en una web PHP con plantilla común.
- URLs `/en/...` devuelven 200 y HTML completo estable tras primera generación.
- Sitemaps generados sin superar límites y listos para Search Console.
- Traducciones consistentes gracias a TM + glosario.
