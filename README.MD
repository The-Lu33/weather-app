# WeatherApp

WeatherApp es una aplicación web moderna para consultar el clima en tiempo real, gestionar ciudades favoritas y acceder al historial de búsquedas del usuario. Está construida con **Laravel** (backend/API) y **React** (frontend), integrando autenticación, documentación interactiva y una interfaz adaptable.

## Características principales

- Consulta del clima actual por ciudad.
- Gestión de ciudades favoritas.
- Historial de búsquedas del usuario autenticado.
- Autenticación de usuarios (registro, login, logout).
- Interfaz responsiva y atractiva.
- Documentación de la API disponible en dos formatos: Swagger y UI personalizada.

## Instalación

### Requisitos

- PHP >= 8.2
- Node.js y npm
- Composer
- **API Key de [WeatherAPI](https://www.weatherapi.com/)** (obligatoria para el funcionamiento del clima)

### Pasos

1. **Clonar el repositorio**

   ```sh
   git clone https://github.com/The-Lu33/weather-app.git
   cd weather-app
   ```

2. **Instalar dependencias backend**

   ```sh
   composer install
   ```

3. **Instalar dependencias frontend**

   ```sh
   npm install
   ```

4. **Configurar variables de entorno**

   Copia `.env.example` a `.env` y configura tus credenciales.

   > **Importante:** Debes agregar tu API Key de WeatherAPI `https://weatherapi.com/docs/` en el archivo `.env` en la variable correspondiente, por ejemplo:
   >
   > ```
   > WEATHERAPI_KEY=tu_api_key_aqui
   > ```

   ```sh
   cp .env.example .env
   ```

5. **Generar clave de aplicación**

   ```sh
   php artisan key:generate
   ```

6. **Migrar la base de datos**

   ```sh
   php artisan migrate
   ```

7. **Levantar el backend (API)**

   ```sh
   php artisan serve
   ```

8. **Levantar el frontend (opcional, para documentación UI y demo visual)**

   ```sh
   npm run dev
   ```

## Uso de la API

Una vez levantado el backend, puedes consumir la API directamente desde tus aplicaciones o herramientas como Postman.

- **Documentación Swagger:**  
  Accede a `http://localhost:8000/api/documentation` para ver y probar los endpoints de la API con Swagger.

- **Documentación UI personalizada (opcional):**  
  Si también levantas el frontend (`npm run dev`), puedes acceder a una documentación visual e interactiva en `http://localhost:5173/docs-ui`.

## Scripts útiles

- Ejecutar tests backend:  
  ```sh
  php artisan test
  ```
- Compilar assets para producción:  
  ```sh
  npm run build
  ```

## Tecnologías utilizadas

- **Backend:** Laravel, Sanctum, L5 Swagger
- **Frontend:** React, Vite, TailwindCSS, Radix UI
- **Documentación:** Swagger, Documentación UI personalizada

## Contribución

¡Las contribuciones son bienvenidas! Por favor, abre un issue o pull request en [GitHub](https://github.com/The-Lu33/weather-app).

---

Desarrollado con ❤️ para mi prueba técnica.