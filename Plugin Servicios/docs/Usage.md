## Uso de los Plugins

### CRUD Servicios

El plugin CRUD Servicios te permite administrar servicios a través de un Custom Post Type en WordPress. Para utilizar este plugin, sigue los siguientes pasos:

1. Instala y activa el plugin CRUD Servicios.
2. En el panel de administración de WordPress, verás una nueva opción llamada "Servicios". Haz clic en ella para administrar tus servicios.
3. Desde la sección de "Servicios", puedes agregar, editar y eliminar servicios según tus necesidades.
4. Además, se proporcionan los siguientes shortcodes para mostrar los servicios en tu sitio web:
   - `[services_crud]`: Muestra el formulario para agregar o editar servicios.
   - `[services_crud_list]`: Muestra una lista de servicios en tu sitio web.

Ten en cuenta que para utilizar los shortcodes mencionados anteriormente, necesitas tener el rol de "Ingeniero". Si deseas cambiar el rol requerido, puedes modificar el archivo `services-crud.php` y cambiar la siguiente línea: 
```php
define( 'crud_plugin_role', 'engineer');
```