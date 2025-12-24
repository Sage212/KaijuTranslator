# 04 — Instalación (sin rewrites) — Plug and Play

## 1. Requisitos
- PHP estándar (hosting compartido)
- Permiso de escritura en:
  - `/kaiju-translator/cache/`
  - `/kaiju-translator/state/`
  - `/sitemaps/kaiju/` (o ruta elegida para sitemaps)
- Clave API del traductor (DeepSeek o compatible)

## 2. Instalación (mínima)
1) Subir carpeta:
- `/kaiju-translator/`

2) Insertar el widget en plantilla común:
- en header o footer global
- responsabilidades:
  - imprimir selector de idioma
  - cargar loader de KaijuTranslator

3) Configurar:
- idiomas activos, exclusiones, SEO, sitemaps (ver 05 y 06)

4) Ejecutar builder:
- crea `/en/`, `/fr/`, etc.
- genera stubs físicos para entrypoints detectados
- genera sitemaps (index + por idioma) en `/sitemaps/kaiju/`

## 3. Validación rápida (checklist)
- Probar:
  - `/` (idioma base)
  - `/en/` (home traducida)
  - `/en/una-pagina.php` (otra traducción)
- Confirmar:
  - 200 OK
  - HTML completo (head y body)
  - `hreflang` presente
  - canonical correcto
  - sitemap index accesible en la ruta configurada

## 4. Publicación del sitemap (muy importante)
KaijuTranslator generará los archivos, pero el sitio debe “anunciarlos”:

Opciones:
- Subirlos y enviarlos por Search Console (recomendado).
- Añadir referencia en `robots.txt` (si tienes acceso):
  - `Sitemap: https://dominio.com/sitemaps/kaiju/sitemap-index.xml`

Recomendación:
- Mantener el sitemap bajo una ruta estable (no cambiarla cada versión).

## 5. Desinstalación
- Quitar include del widget
- Borrar `/kaiju-translator/`
- (Opcional) borrar `/en/`, `/fr/` generados
- (Opcional) borrar `/sitemaps/kaiju/` si ya no aplica
