# 07 — Especificación de traducción (DeepSeek)

## 1. Qué se traduce
- Texto visible (contenido principal, headings, párrafos, listas).
- Menús/footers si están en HTML (se recomienda TM para consistencia).
- `<title>` y `<meta name="description">`.
- OG/Twitter (si existen y están habilitados).

## 2. Qué no se traduce
- Scripts, CSS.
- IDs, clases, atributos técnicos (`data-*` salvo lista blanca).
- Contenido de formularios, inputs y textos que puedan contener datos sensibles.
- Áreas privadas excluidas por configuración.

## 3. Segmentación (clave para calidad y coste)
- Traducir por bloques semánticos (no por líneas arbitrarias).
- Normalizar:
  - espacios y saltos
  - entidades HTML
  - comillas tipográficas
- Clave TM recomendada:
  - `lang_from + lang_to + normalized_text + (optional_context_key)`

## 4. Glosario
- Lista de no traducibles:
  - marca, producto, nombres propios
- Traducción fija por término:
  - para términos críticos (p. ej. términos técnicos)

## 5. Consistencia (TM-first)
- Si existe en TM:
  - usar TM, no llamar API
- Si no existe:
  - traducir, validar, guardar en TM
- Misma frase → misma traducción (salvo override explícito)

## 6. Fallos y degradación
- Reintentos con backoff (respetando rate limits).
- Si la API falla:
  - servir caché anterior si existe
  - si no existe: fallback a idioma base
- Registrar:
  - error por URL
  - error por proveedor
  - timestamp y número de reintentos

## 7. Sanitización antes de reinsertar
- El texto traducido no puede introducir HTML no permitido.
- Debe preservarse la estructura DOM.
