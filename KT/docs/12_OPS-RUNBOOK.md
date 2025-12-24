# 12 — Operación y mantenimiento (Runbook)

## 1. Observabilidad (logs mínimos)
Por request:
- URL, idioma
- cache hit/miss
- latencia de traducción (si aplica)
- QA score
- estado final (ok/failQA/excluded)

Por builder:
- número de stubs generados por idioma
- número de URLs añadidas a sitemaps
- número de URLs failQA
- tamaño de cada sitemap (URL count + bytes)
- cambios de `lastmod` en index

## 2. Sitemaps: operación diaria (lo que no se puede olvidar)
### 2.1. Regla de oro
- Un sitemap es “vivo”: si cambian URLs o contenido, hay que:
  - regenerar sitemaps
  - actualizar `lastmod`
  - asegurar que no se superan límites

### 2.2. Flujo recomendado
- Cada despliegue o cambio grande:
  1) Ejecutar builder (stubs + cache warmup opcional)
  2) Regenerar sitemaps (index + por idioma)
  3) Verificar accesibilidad pública de `sitemap-index.xml`
  4) Enviar/actualizar en Search Console si procede

### 2.3. Envío a Google (operativo)
- Método recomendado: Search Console -> Sitemaps -> añadir URL del sitemap index.
- Método opcional: robots.txt con `Sitemap: ...` si tienes control.

## 3. Tareas periódicas
- Purga selectiva por idioma/URL:
  - cuando cambian plantillas o se corrige contenido base
- Warmup:
  - pre-generar top URLs para reducir misses
- Retraducción:
  - reprocesar lista de failQA

## 4. Incidencias típicas y resolución rápida
### 4.1. “/en/ da 404”
- Causa típica:
  - builder no ejecutado o stubs faltan
- Acción:
  - ejecutar builder
  - verificar permisos de escritura y rutas

### 4.2. “Google no indexa idiomas”
- Causas típicas:
  - sitemap no enviado / inaccesible
  - hreflang inconsistente (no recíproco)
  - URLs bloqueadas por robots/noindex
- Acción:
  - validar sitemap index y sitemaps por idioma
  - comprobar `hreflang` y canonical
  - revisar exclusiones y QA

### 4.3. “Sitemap demasiado grande”
- Acción:
  - bajar `chunk_max_urls` y regenerar
  - separar por idiomas y/o por secciones

### 4.4. “Sitemap contiene URLs que no deberían”
- Acción:
  - endurecer exclusiones
  - regenerar sitemaps desde estado `ok` únicamente

## 5. Modo emergencia
- Desactivar traducción:
  - servir siempre idioma base
- Mantener selector visible:
  - pero sin generar nuevas traducciones (evita gastos y errores)
