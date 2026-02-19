API Blog

Proyecto API REST para un blog construido con Laravel.

**Descripción**

- API sencilla para gestionar usuarios, posts y comentarios.
- Autenticación por tokens con Laravel Sanctum.

**Requisitos**

- PHP 8.1+ (según composer.json)
- Composer
- MySQL / MariaDB (o la base de datos que prefieras)
- Node.js + npm (para assets con Vite)
- XAMPP (opcional en Windows) o servidor web equivalente

**Instalación rápida**

1. Clona el repositorio:

```bash
git clone <repositorio> && cd api-blog
```

2. Instala dependencias PHP:

```bash
composer install
```

3. Copia el archivo de entorno y genera la clave de la aplicación:

```bash
cp .env.example .env    # En Windows PowerShell: Copy-Item .env.example .env
php artisan key:generate
```

4. Configura la conexión a la base de datos en el archivo `.env` (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

5. Ejecuta migraciones y seeders:

```bash
php artisan migrate --seed
```

6. (Opcional) Instala dependencias JS y compila assets:

```bash
npm install
npm run dev    # o `npm run build` para producción
```

**Ejecutar en local**

```bash
php artisan serve
```

o configura tu servidor (XAMPP) apuntando la carpeta `public`.

**Rutas API principales**

La API expone las siguientes rutas (archivo de rutas: routes/api.php):

- `POST /api/register` — Registrar nuevo usuario
- `POST /api/login` — Iniciar sesión (devuelve token)
- `GET /api/posts` — Listar posts públicos
- `GET /api/posts/{post}` — Ver post por id
- `GET /api/user` — Obtener usuario autenticado (requiere `auth:sanctum`)

Rutas protegidas (requieren token - `auth:sanctum`):

- `POST /api/logout` — Cerrar sesión
- `POST /api/posts` — Crear post
- `PUT /api/posts/{post}` — Actualizar post
- `DELETE /api/posts/{post}` — Eliminar post
- `POST /api/posts/{posts}/comment` — Crear comentario en un post

**Autenticación**

La aplicación utiliza Laravel Sanctum para autenticación por tokens personales. Tras autenticarse (login), incluye el token en el header `Authorization: Bearer <token>` en las peticiones protegidas.

**Ejemplos (curl)**

Registrar:

```bash
curl -X POST http://localhost:8000/api/register \
	-H "Content-Type: application/json" \
	-d '{"name":"Usuario","email":"user@example.com","password":"secret","password_confirmation":"secret"}'
```

Login:

```bash
curl -X POST http://localhost:8000/api/login \
	-H "Content-Type: application/json" \
	-d '{"email":"user@example.com","password":"secret"}'
```

Obtener posts públicos:

```bash
curl http://localhost:8000/api/posts
```

Crear post (ejemplo con token):

```bash
curl -X POST http://localhost:8000/api/posts \
	-H "Authorization: Bearer <TOKEN>" \
	-H "Content-Type: application/json" \
	-d '{"title":"Título","body":"Contenido del post"}'
```

**Tests**

Ejecutar pruebas:

```bash
php artisan test
# o
vendor/bin/phpunit
```

**Modelos principales**

- `User` — Usuarios
- `Post` — Entradas del blog
- `Comment` — Comentarios de posts

**Contribuir**

- Abre un issue para discutir cambios o mejoras.
- Envía pull requests con descripciones claras.

**Licencia**

Proyecto con licencia abierta; añade el archivo `LICENSE` si deseas especificar una licencia.
