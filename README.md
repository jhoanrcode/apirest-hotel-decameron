# API-REST Hotel Decameron
Simple API REST desarrollado en PHP basado en Laravel11 utilizando los métodos HTTP apropiados (GET, POST, PUT, DELETE).
El objetivo de esta API es registrar los hoteles de una cadena hotelera y asi mismo configurar la cantidad de habitaciones de ada sede.

#### Tecnologias Utilizadas:
- Laravel 11, PHP 8, Composer, PostgresSQL.

#### Como instalar:
Para explorar e utilizar este repositório:

1. **Clonar repositorio**: Clone este mismo repositorio en su máquina local.

   ```
   git clone https://github.com/jhoanrcode/apirest-hotel-decameron.git
   ```

2. **Instalación de dependencias**: Utilice Composer para instalar todas las dependencias del proyecto Laravel.

   ```
   composer install
   ```

3. **Configuración de ambiente**: Cree el archivo `.env` y modifíquelo usando el archivo `.env.example` y actualice la información de conexion a base de datos. (BD PostgresSQL)

4. **Ejecutar migraciones**: Ejecute las migraciones de Laravel para crear las tablas necesarias en base de datos.

   ```
   php artisan migrate
   ```

5. **Ejecutar el servidor**: 

   ```
   php artisan serve
   ```

### Como consumir API:
- Listado de hoteles: `GET /api/sedes`
- Listado de habitaciones de hotel: `GET /api/habitaciones/{idsede}`
