## Estructura de Archivos del Plugin "Servicios"

El Plugin "Servicios" consta de los siguientes archivos y carpetas dentro de la carpeta "services-crud-main":

- **inc/archive-service_crud.php**: Este archivo es responsable de mostrar la lista de servicios junto con su paginador. Utiliza un template del tema "Hello Elementor" para la presentación de los servicios en forma de archivo de archivo.

- **inc/loop-service.php**: En este archivo se define la vista individual de cada servicio, mostrando cómo se visualiza la tarjeta del servicio en la lista. Aquí se pueden realizar ajustes y personalizaciones para adaptar la apariencia de los servicios en la página de listado.

- **inc/single-service_crud.php**: Este archivo contiene la vista individual de cada servicio, que se muestra cuando se accede a un servicio específico. Aquí se puede personalizar la presentación y el diseño de los detalles del servicio.

- **frontend.css**: Se trata de un archivo CSS que contiene estilos específicos para la parte frontal del plugin. Puedes realizar modificaciones en los estilos visuales para adaptarlos a tus necesidades y al diseño general de tu sitio web.

- **frontend.js**: En este archivo se encuentra el código JavaScript que utiliza jQuery y Ajax para manejar interacciones y acciones en la interfaz del usuario. Por ejemplo, se puede implementar la funcionalidad de eliminar o editar servicios de manera dinámica.

- **helper.php**: Este archivo contiene una función que permite recuperar el valor de un metadato de usuario. Puedes utilizar esta función en forma de shortcode [um_user] para mostrar metadatos específicos del usuario actual. Este archivo es útil si deseas mostrar información personalizada de los usuarios en relación con los servicios. Recuperado de: https://gist.github.com/champsupertramp/a1ed201cb05ff68bcecac4c7cd5b004b

- **select2.min.css** y **select2.min.js**: Estos archivos corresponden a la librería Select2, que se utiliza para mejorar la experiencia de selección en formularios. Select2 proporciona características avanzadas de selección, como búsqueda en campos desplegables y carga remota de opciones.

- **services-crud.php**: En este archivo se realiza el registro de los shortcodes, propiedades y taxonomías específicas del plugin de Servicios. Aquí se pueden definir las configuraciones generales y personalizaciones relacionadas con los servicios.

- **shortcodes.php**: Este archivo actúa como orquestador de los demás archivos del plugin. Se encarga de gestionar los roles de usuario y la estructura HTML del plugin. Además, permite la interacción con otros componentes del sistema, como la base de datos y la interfaz de usuario.