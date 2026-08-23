# Changelog

Todos los cambios notables de este proyecto se documentan en este archivo.

## [1.0.0] - 2026-08-23

Primera version funcional del catalogo turistico con patron MVC en Laravel.

### Added

- Proyecto base Laravel 13 con PHP 8.5, ejecutable con `php artisan serve`.
- Dataset JSON con 10 lugares turisticos de El Salvador (`storage/app/data/lugares.json`).
- Capa de modelo: entidad `TouristPlace` y `TouristPlaceRepository` con lectura de JSON.
- Listado de destinos con cards, badges de categoria y precios de referencia.
- Detalle de lugar con precios, servicios, lugares relacionados y manejo de 404.
- Formulario de contacto con validacion del servidor, CSRF y confirmacion flash.
- Layout Blade compartido con hoja de estilos propia (sin build de Node).
- README con guia de instalacion y documentacion del flujo MVC.
