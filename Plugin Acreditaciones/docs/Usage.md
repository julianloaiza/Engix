### CRUD Acreditaciones

El plugin CRUD Acreditaciones te permite gestionar las acreditaciones profesionales a través de un Custom Post Type en WordPress. Sigue estos pasos para utilizar el plugin:

1. Instala y activa el plugin CRUD Acreditaciones.
2. En el panel de administración de WordPress, encontrarás una nueva opción llamada "Acreditaciones". Haz clic en ella para administrar tus acreditaciones profesionales.
3. Desde la sección de "Acreditaciones", puedes agregar, editar y eliminar acreditaciones según tus necesidades.
4. Además, se proporciona el siguiente shortcode para mostrar el formulario de acreditaciones profesionales en tu sitio web:
   - `[accreditations_crud]`: Muestra el formulario para agregar o editar acreditaciones profesionales.

Recuerda que para utilizar el shortcode `[accreditations_crud]`, debes tener el rol de "Ingeniero". Si deseas cambiar el rol requerido, puedes modificar el archivo `services-crud.php` y cambiar la siguiente línea: 
```php
define( 'crud_plugin_role', 'engineer');
```
