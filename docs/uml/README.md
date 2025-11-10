# UML del proyecto (PlantUML)

Ubicación de los diagramas:

- `docs/uml/class-diagram.puml` — Diagrama de clases (modelos, controladores y relaciones principales).
- `docs/uml/usecase-diagram.puml` — Diagrama de casos de uso (Usuario y Administrador).

## Cómo renderizar

Opciones rápidas:

1) VS Code + extensión “PlantUML” (+ Java):
   - Instala la extensión “PlantUML” de jebbs.
   - Abre el `.puml` y usa “PlantUML: Preview Current Diagram”.

2) Docker (sin instalar Java):
   - `docker run --rm -v "$PWD":/workspace ghcr.io/plantuml/plantuml -tpng docs/uml/class-diagram.puml`
   - `docker run --rm -v "$PWD":/workspace ghcr.io/plantuml/plantuml -tpng docs/uml/usecase-diagram.puml`
   - Los PNG se generan junto a los `.puml`.

3) plantuml.jar (Java local):
   - `java -jar plantuml.jar -tpng docs/uml/*.puml`

## Alcance

- Clases del dominio: `User`, `Product`, `Carrito`, `Venta`, `DetalleVenta` y sus asociaciones.
- Controladores: `ProductController`, `CarritoController`, `VentaController`, `AuthController`, `DashboardController`.
- Middleware: `IsAdmin`.
- Casos de uso: registro, login, catálogo, carrito, checkout (con método de pago), descargas de recibo y administración (CRUD productos, dashboard).

