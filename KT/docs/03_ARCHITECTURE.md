# 03 — Arquitectura técnica (alto nivel)

## 1. Capas
### 1) Integración
- Widget/loader
- Detección de idioma por subcarpeta
- Modo “no tocar la web”: solo un include en plantilla

### 2) Core KaijuTranslator
- Router de idioma (KT_LANG)
- Captura de HTML base (loopback HTTP preferente)
- Extracción/segmentación DOM
- Traducción (proveedor) + glosario + TM
- QA gate (calidad)
- Cache store (página + TM + estado)
- SEO injector (hreflang, canonical, metas)
- Sitemap generator (index + per-language + rotación)

### 3) Storage
- Caché páginas (HTML final)
- TM segmentos (texto normalizado → traducción)
- Estado (URL+idioma: ok/pending/failQA + timestamps + hashes)

## 2. Flujo de request (runtime)
1) Petición llega a `/en/ruta`
2) Loader detecta idioma -> `KT_LANG=en`
3) Cache lookup (en + ruta + hash base)
4) Hit: devolver HTML traducido final
5) Miss:
   - Capturar HTML base equivalente (`/ruta`)
   - Extraer bloques traducibles + metas
   - Traducir con TM+glosario
   - QA
   - Guardar caché y estado
   - Inyectar SEO
   - Responder

## 3. Captura HTML base (modo universal)
Loopback HTTP:
- KaijuTranslator solicita a su propio dominio la versión base (`/ruta`) para obtener el HTML final tal cual lo entrega la web.

Requisito crítico:
- Evitar loops: una URL traducida nunca captura otra URL traducida.
- Forzar cabecera/flag interno para “captura base” si hace falta.

## 4. Arquitectura del builder (offline / mantenimiento)
El builder:
- Descubre URLs (filesystem/sitemap/lista manual)
- Genera stubs físicos por idioma
- Genera o actualiza sitemaps
- Opcional: warmup/prebuild de páginas top

## 5. Puntos críticos de diseño
- No cachear páginas personalizadas (sesiones, usuario logado).
- Normalización agresiva para maximizar TM y reducir costes.
- QA como “puerta”: si se indexa basura, el proyecto pierde credibilidad.
- Sitemaps como “motor de indexación”: si el sitemap es malo, Google no descubrirá bien los idiomas.
