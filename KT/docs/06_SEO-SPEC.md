# 06 — Especificación SEO internacional (incluye sitemaps en profundidad)

## 1. Objetivo SEO de KaijuTranslator
- Evitar duplicados y canibalización.
- Señalizar alternates correctamente para cada idioma.
- Facilitar el descubrimiento y crawling de todos los idiomas.
- Controlar indexación cuando QA falla o hay URLs “infinitas”.

KaijuTranslator usa dos “pilares”:
1) `hreflang` (en HTML y, opcionalmente, en sitemap).
2) Sitemaps (index + por idioma) como fuente de descubrimiento.

---

## 2. Hreflang (reglas estrictas)
### 2.1. Principios
- Debe ser recíproco: si A apunta a B, B debe apuntar a A.
- Cada página debe listarse a sí misma (self hreflang).
- Alternates siempre con URLs absolutas (https completo).
- `x-default` recomendado para home/selector o fallback global.

### 2.2. Implementación elegida
- KaijuTranslator inyecta en HTML:
  - `<link rel="alternate" hreflang="en" href="...">`
  - para cada idioma, incluido self
- Opción adicional:
  - duplicar hreflang en sitemap (útil si el HTML es difícil o si quieres un “mapa central”).

Nota operativa: Google considera equivalentes los métodos HTML, HTTP headers y sitemap; conviene escoger uno principal y no mantener 3 variantes diferentes. (En KaijuTranslator, el principal es HTML; el sitemap hreflang es opcional).

---

## 3. Canonical (política anti-duplicados)
### 3.1. Regla base (simple y robusta)
- Autocanonical por idioma:
  - `/ruta` -> canonical `/ruta`
  - `/en/ruta` -> canonical `/en/ruta`

### 3.2. Limpieza de parámetros
- Canonical debe eliminar parámetros de tracking:
  - `utm_*`, `gclid`, `fbclid`, etc.
- URLs con parámetros no soportados:
  - `noindex` por defecto (ver 5).

---

## 4. Robots & control de indexación (para no destruir el SEO)
### 4.1. QA fail
Si la traducción no pasa QA:
- servir la página (para usuario y debug)
- **no indexar** esa URL traducida:
  - `noindex, follow`

### 4.2. URLs infinitas (búsquedas, filtros, paginación sin control)
- No se añaden a sitemaps.
- Meta robots `noindex` por defecto salvo lista blanca.

---

## 5. Sitemaps — especificación completa (KaijuTranslator)

### 5.1. Qué es un sitemap y qué promete (realista)
- Un sitemap ayuda a que los buscadores descubran URLs y las rastreen con más eficiencia.
- No garantiza indexación de todo, pero suele mejorar crawling en webs grandes, nuevas o complejas.

### 5.2. Límites y por qué importan
Reglas de tamaño por archivo:
- Máximo **50.000 URLs** por sitemap.
- Máximo **50MB (sin comprimir)** por sitemap.

Implicación:
- Si superas cualquiera de los dos límites, hay que partir en varios sitemaps y usar un **sitemap index**.

### 5.3. Estructura de ficheros (recomendación plug & play)
Ruta estable:
- `/sitemaps/kaiju/`

Archivos:
- `sitemap-index.xml`
- `sitemap-es-0001.xml.gz`
- `sitemap-en-0001.xml.gz`
- `sitemap-fr-0001.xml.gz`
- etc.

Ventajas:
- Fácil de versionar.
- Fácil de cachear en CDN.
- No interfiere con sitemaps previos del sitio (si existen).

### 5.4. Sitemap index (cuando y cómo)
Se usa cuando:
- hay más de 1 sitemap, o
- quieres separar por idioma/tipo, o
- necesitas trocear por límites.

Reglas prácticas:
- Cada `<sitemap>` lleva:
  - `<loc>` (URL absoluta del sitemap hijo)
  - `<lastmod>` (cuando se actualizó el sitemap hijo)
- El index no debe listar sitemaps fuera de su directorio (recomendación: mantener jerarquía “misma carpeta o más profundo”).

Operación:
- KaijuTranslator recalcula `lastmod` del index siempre que:
  - cambie un sitemap hijo, o
  - cambie el set de idiomas, o
  - cambie el número de chunks.

### 5.5. Sitemap por idioma (contenido)
Cada sitemap de idioma lista las URLs traducidas reales (las que existen como stubs/archivos en `/en/…`, etc.).
Por cada `<url>`:
- `<loc>`: URL absoluta
- `<lastmod>`: recomendado (si tienes señal fiable)
- (opcional) `changefreq`, `priority`:
  - KaijuTranslator los puede emitir, pero no se basa en que Google los respete.

Recomendación de inclusión:
- Incluir solo URLs “buenas”:
  - 200 OK
  - no privadas
  - no resultantes de búsquedas/filtros infinitos
  - no QA-fail (o, si se incluyen, con estrategia muy controlada; en KaijuTranslator se recomienda no incluirlas)

### 5.6. Hreflang dentro del sitemap (opcional)
KaijuTranslator puede anotar alternates en el sitemap usando `xhtml:link` dentro de cada `<url>`.

Reglas:
- Declarar el namespace `xhtml`.
- En cada `<url>`, añadir una línea `<xhtml:link ...>` por cada variante, incluyendo la propia.
- Cada variante debe ser recíproca: si una variante existe, debe participar de forma consistente.

Cuándo activarlo:
- Si no puedes tocar fácilmente el `<head>` del HTML final (casos legacy raros).
- Si quieres una “fuente central” de alternates para depurar.
- Si estás seguro de mantenerlo consistente con el HTML (si usas ambos).

Cuándo NO activarlo:
- Si ya inyectas hreflang en HTML y no quieres duplicar señales (más mantenimiento).

### 5.7. Compresión y entrega
- KaijuTranslator genera `.xml.gz` (recomendado) para reducir transferencia.
- Ojo: el límite de 50MB se refiere al tamaño **sin comprimir**.

### 5.8. Ubicación y alcance
- Recomendación: sitemaps en una ruta que “cubra” el sitio (idealmente cercano al root).
- Si el sitio no puede poner el sitemap en root, se recomienda enviar el sitemap por Search Console igualmente.

### 5.9. Publicación y envío
KaijuTranslator genera los archivos. Para que Google los use:
- Enviar por Search Console (método principal recomendado).
- Opcional: referencia en `robots.txt` con línea `Sitemap:`.

### 5.10. Estrategia de actualización (para que sea fiable)
KaijuTranslator mantiene un “estado” por URL:
- `status`: ok / pending / failQA / excluded
- `base_hash`: hash del HTML base
- `translated_at`: timestamp

Regla de regeneración:
- Si cambia `base_hash`, KaijuTranslator marca la URL para regeneración y actualiza `lastmod` al completar.

---

## 6. Checklist SEO (mínimo para producción)
- Canonical correcto en base y en idiomas.
- Hreflang recíproco con self incluido.
- Sitemaps generados:
  - index + per-language
  - sin exceder límites
  - sin URLs privadas/infinitas
- QA fail -> `noindex, follow` y fuera del sitemap.
