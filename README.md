# Catalogo Turistico SV - Patron MVC en Laravel

Aplicacion web de catalogo de lugares turisticos de El Salvador desarrollada para demostrar la implementacion del patron arquitectonico **Modelo-Vista-Controlador (MVC)** en Laravel.

La aplicacion permite:

- Explorar el listado de destinos turisticos disponibles.
- Visualizar la informacion detallada de cada lugar (titulo, departamento, categoria, precios, servicios).
- Enviar un formulario de contacto para solicitar mas informacion (con validacion del lado del servidor).

Los datos provienen de un archivo JSON creado como fuente de datos de prueba, lo que permite observar con claridad como fluye la informacion entre las capas MVC sin depender de una base de datos.

---

## Requisitos

| Herramienta | Version |
| ----------- | ------- |
| PHP         | >= 8.2  |
| Composer    | >= 2.x  |

No se requiere base de datos ni servidores externos: la app corre con `php artisan serve`.

## Instalacion

```bash
# 1. Clonar el repositorio
git clone https://github.com/DJeovannyZ/mvc-laravel-turismo.git
cd mvc-laravel-turismo

# 2. Instalar dependencias
composer install

# 3. Crear el archivo de entorno
cp .env.example .env

# 4. Generar la clave de la aplicacion
php artisan key:generate

# 5. Iniciar el servidor de desarrollo
php artisan serve
```

Abrir `http://127.0.0.1:8000` en el navegador.

> Si al iniciar aparece un error sobre la base de datos SQLite (Laravel la usa para sesiones), crearla y migrarla:
>
> ```bash
> touch database/database.sqlite
> php artisan migrate
> ```

---

## Flujo MVC implementado

### Ciclo de vida de una peticion

```
Navegador (peticion HTTP)
        |
        v
public/index.php ................ punto de entrada unico
        |
        v
bootstrap/app.php ............... inicializa el framework
        |
        v
routes/web.php .................. enrutamiento: asocia URL + metodo HTTP con un controlador
        |
        v
app/Http/Controllers/... ........ CONTROLADOR: recibe la peticion,
        |                         coordina y decide que responder
        v
app/Models/ TouristPlace ........ MODELO: entidad de dominio del lugar turistico
app/Repositories/ ...Repository . acceso a datos: lee storage/app/data/lugares.json
        |
        v
resources/views/ ...blade.php ... VISTA: plantilla Blade que renderiza HTML
        |
        v
Respuesta HTTP al navegador
```

### Rutas definidas (`routes/web.php`)

| Metodo | URI               | Accion                     | Vista            |
| ------ | ----------------- | -------------------------- | ---------------- |
| GET    | `/`               | `PlaceController@index`    | `places/index`   |
| GET    | `/lugares/{slug}` | `PlaceController@show`     | `places/show`    |
| GET    | `/contacto`       | `ContactController@create` | `contact/create` |
| POST   | `/contacto`       | `ContactController@store`  | redirect + flash |

### Explicacion por capas

**Enrutamiento.** `routes/web.php` registra rutas nombradas que mapean cada URL a un metodo de controlador. Es el primer punto donde Laravel despacha la peticion entrante.

**Controladores** (`app/Http/Controllers`). Reciben la peticion, solicitan datos a la capa de modelo (mediante inyeccion de dependencias del repositorio) y devuelven una respuesta: una vista renderizada o un redirect con mensajes flash. No contienen logica de acceso a datos ni presentacion.

**Modelo.** Como la fuente de datos es un archivo JSON, la capa de modelo se compone de:

- `app/Models/TouristPlace.php`: entidad de dominio inmutable con los campos del lugar (id, slug, titulo, departamento, categoria, descripcion, precios, servicios, imagen). Expone metodos de dominio como `precioDesde()` y `hasFreeEntry()`.
- `app/Repositories/TouristPlaceRepository.php`: encapsula el acceso al archivo `storage/app/data/lugares.json`. Ofrece `all()`, `featured()`, `findBySlug()` y `categories()`. Esta registrado como singleton en `AppServiceProvider`, por lo que cualquier controlador lo recibe por inyeccion de dependencias.

Esto demuestra que el rol "Model" del patron MVC no depende de Eloquent ni de una base de datos: es la capa responsable de los datos y las reglas de negocio.

**Vistas** (`resources/views`). Plantillas Blade que solo se ocupan de la presentacion:

- `layouts/app.blade.php`: layout compartido (header, nav, footer).
- `places/index.blade.php`: grid de cards con todos los destinos.
- `places/show.blade.php`: ficha detallada del destino.
- `contact/create.blade.php`: formulario de contacto.

**Flujo de datos del formulario de contacto.**

1. El usuario envia `POST /contacto` con el token CSRF (`@csrf`).
2. `ContactController@store` valida con reglas (`nombre`, `email`, `lugar`, `mensaje`) y mensajes personalizados en espanol.
3. Si falla: Laravel redirige de vuelta con los errores y valores previos (`old()`), que la vista muestra.
4. Si es valido: redirige con mensaje flash de confirmacion.

### Fuente de datos JSON

`storage/app/data/lugares.json` contiene 10 destinos turisticos reales de El Salvador (Playa El Tunco, Ruta de las Flores, Volcan de Santa Ana, Suchitoto, Joya de Ceren, etc.) con esta estructura:

```json
{
    "id": 1,
    "slug": "playa-el-tunco",
    "titulo": "Playa El Tunco",
    "departamento": "La Libertad",
    "categoria": "Playa",
    "descripcion": "...",
    "precio_entrada": 1.0,
    "precio_tour": 35.0,
    "servicios": ["Surf", "Restaurantes"],
    "imagen": "/images/places/playa-el-tunco.svg",
    "destacado": true
}
```

---

## Capturas de pantalla

> Se agregaran en la fase release con el sistema funcionando:
>
> 1. Listado de lugares (home)
> 2. Detalle de un lugar turistico
> 3. Formulario de contacto
> 4. Confirmacion de envio del formulario

---

## Estado del proyecto

- [x] F01 - Scaffold Laravel
- [x] F02 - Datos JSON y capa de modelo
- [x] F03 - Listado de lugares
- [x] F04 - Detalle de lugar
- [x] F05 - Formulario de contacto
- [x] F06 - Layout e interfaz
- [ ] F07 - Documentacion README
- [ ] Release 1.0.0
