# 11 — Plan de pruebas

## 1. Matriz de sitios
- Sitio A: multipágina `.php` (varios entrypoints directos)
- Sitio B: plantilla común con includes
- Sitio C: rutas en carpetas con `index.php`
- Sitio D: contenidos largos + listas + tablas simples

## 2. Pruebas funcionales
- Selector de idioma:
  - enlaces correctos a `/en/...`
- Stubs:
  - existen físicamente y devuelven 200
- Cache:
  - primera visita genera (miss), segunda sirve (hit)
- Exclusiones:
  - rutas excluidas no se traducen ni se cachean
- QA:
  - forzar fallo y comprobar `noindex` + exclusión de sitemap

## 3. Pruebas SEO
- Canonical por idioma:
  - base y traducidas correctas
- Hreflang recíproco:
  - self incluido
- Sitemaps:
  - index presente
  - sitemaps por idioma presentes
  - no exceden límites (URLs/size)
  - `lastmod` se actualiza al regenerar
  - no incluyen URLs excluidas o failQA

## 4. Rendimiento
- TTFB cache hit bajo
- Latencia cache miss razonable
- Concurrencia:
  - peticiones simultáneas a misma URL no deben multiplicar traducciones

## 5. Resiliencia
- API caída:
  - fallback a cache anterior o idioma base
- Permisos de escritura:
  - error manejado sin romper la web
- Sitemap generator:
  - si no puede escribir, debe registrar error y no dejar archivos corruptos
