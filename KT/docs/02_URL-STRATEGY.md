# 02 — Estrategia de URLs (sin reescrituras) — Subcarpetas físicas (sin slugs)

## 1. Formato de URLs
- Idioma base: `https://dominio.com/lo-que-sea`
- Idiomas: `https://dominio.com/en/lo-que-sea`, `https://dominio.com/fr/lo-que-sea`

Nota: el “slug” es el mismo en todos los idiomas (no se traduce).

## 2. Restricción clave: sin reescrituras
Sin reglas del servidor, `/en/lo-que-sea` solo funciona si existe **físicamente** una ruta dentro de `/en/`.

Solución: **carpetas por idioma + stubs físicos**.

## 3. Stubs físicos (concepto)
Para cada página/entrypoint traducible del sitio, KaijuTranslator crea un archivo espejo dentro de cada idioma que:
- establece `KT_LANG` (por ejemplo `en`)
- carga el core de KaijuTranslator
- captura la versión base equivalente (sin idioma)
- sirve HTML traducido desde caché o lo genera y lo cachea

### 3.1. Qué se considera “entrypoint”
- Archivo PHP accesible directamente (por ejemplo `about.php`)
- Carpetas con `index.php` accesible directamente
- URLs listadas en sitemap (si el sitio tiene sitemap)

## 4. Cómo se generan las URLs traducidas (plug & play)
### Modo recomendado: Builder
- Escanea el sitio (filesystem o sitemap).
- Genera subcarpetas de idioma: `/en/`, `/fr/`, etc.
- Copia/genera stubs solo para entrypoints traducibles.

### Modo alternativo: Manual
- El usuario define la lista de entrypoints en un archivo de configuración.
- El builder solo crea los stubs para esa lista.

## 5. Parámetros y duplicados
Regla por defecto (segura para SEO):
- No indexar URLs con parámetros salvo lista blanca.
- Si se permiten parámetros, KaijuTranslator debe:
  - normalizar la URL (orden/limpieza)
  - decidir canonical sin parámetros tracking
  - limitar combinaciones (evitar infinitos)

## 6. Canonical
- Cada idioma se autocanoniza:
  - `/en/ruta` canonical → `/en/ruta`
  - `/ruta` canonical → `/ruta`
- Parámetros de tracking (utm/gclid/etc.): canonical limpio.

## 7. Hreflang
- Cada URL debe listar:
  - su propia URL (self)
  - todas las alternates
  - opcional `x-default` (ideal en home/selector)

## 8. Sitemaps (encaje con esta estrategia)
Esta estrategia exige que el **sitemap incluya las URLs reales traducidas** (las que existen como archivos/stubs):
- `/en/about.php`
- `/fr/about.php`
- etc.

KaijuTranslator genera:
- un sitemap index (si hay más de un sitemap o si se trocean por límites)
- sitemaps por idioma, listando URLs absolutas

Recomendación de “ruta estándar” (para que sea universal):
- `/sitemaps/kaiju/sitemap-index.xml`
- `/sitemaps/kaiju/sitemap-es-0001.xml.gz`
- `/sitemaps/kaiju/sitemap-en-0001.xml.gz`
- etc.
