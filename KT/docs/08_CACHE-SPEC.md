# 08 — Especificación de caché

## 1. Qué se cachea
- Caché de página:
  - HTML final traducido (head+body)
- Caché TM:
  - segmento normalizado → traducción
- Estado:
  - URL+idioma → status + timestamps + base_hash

## 2. Clave de caché de página
Debe incluir:
- `lang`
- `normalized_path` (sin prefijo de idioma)
- `base_hash` (hash del HTML base normalizado)
- (opcional) `variant` si el HTML difiere por dispositivo

## 3. Invalidation
### 3.1. Por hash (preferente)
- Si cambia `base_hash`, el cache se invalida y se regenera.

### 3.2. Por TTL (opcional)
- TTL para refresco preventivo (por ejemplo 14 días).

## 4. Seguridad y anti-poisoning
- No cachear si:
  - hay sesión/logado
  - hay cookies que alteran contenido
  - la URL está en exclusiones
- Normalizar:
  - host canonical
  - parámetros (limpiar tracking)
- Evitar loops:
  - marcar requests internos de captura base

## 5. Relación con sitemaps
- KaijuTranslator solo añade al sitemap URLs en estado `ok`.
- Cuando una URL cambia de `pending` a `ok`, se actualiza `lastmod`.
