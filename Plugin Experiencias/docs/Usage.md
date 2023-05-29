### CRUD Experiencias

El plugin CRUD Experiencias te permite administrar experiencias laborales a través de un Custom Post Type en WordPress. Sigue estos pasos para utilizar el plugin:

1. Instala y activa el plugin CRUD Experiencias.
2. En el panel de administración de WordPress, encontrarás una nueva opción llamada "Experiencias". Haz clic en ella para administrar tus experiencias laborales.
3. Desde la sección de "Experiencias", puedes agregar, editar y eliminar experiencias según sea necesario.
4. Además, se proporciona el siguiente shortcode para mostrar el formulario de experiencias laborales en tu sitio web:
   - `[experiences_crud]`: Muestra el formulario para agregar o editar experiencias laborales.

Recuerda que para utilizar el shortcode `[experiences_crud]`, debes tener el rol de "Ingeniero". Si deseas cambiar el rol requerido, puedes modificar el archivo `services-crud.php` y cambiar la siguiente línea: 
```php
define( 'crud_plugin_role', 'engineer');
```
