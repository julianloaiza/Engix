## Estructura de Archivos del Plugin "Acreditaciones"

El Plugin "Acreditaciones" consta de los siguientes archivos y carpetas dentro de la carpeta "accreditations-crud-main":

- **base/**: Esta carpeta es utilizada para almacenar los archivos PDF de las acreditaciones que son subidas a través del plugin. Los archivos PDF se guardan en esta carpeta para su posterior procesamiento y visualización.

- **frontend.css**: Este archivo CSS contiene estilos específicos para la parte frontal del plugin "Acreditaciones". Puedes realizar modificaciones en los estilos visuales para adaptarlos a tus necesidades y al diseño general de tu sitio web.

- **frontend.js**: En este archivo se encuentra el código JavaScript que utiliza jQuery y Ajax para manejar interacciones y acciones en la interfaz del usuario. Por ejemplo, se puede implementar la funcionalidad de eliminar o editar acreditaciones de manera dinámica.

- **select2.min.css** y **select2.min.js**: Estos archivos corresponden a la librería Select2, que se utiliza para mejorar la experiencia de selección en formularios. Select2 proporciona características avanzadas de selección, como búsqueda en campos desplegables y carga remota de opciones.

- **accreditations-crud.php**: En este archivo se realiza el registro de los shortcodes, propiedades y taxonomías específicas del plugin de Acreditaciones. Aquí se pueden definir las configuraciones generales y personalizaciones relacionadas con las acreditaciones.

- **shortcodes.php**: Este archivo actúa como orquestador de los demás archivos del plugin. Se encarga de gestionar los roles de usuario y la estructura HTML del plugin. Además, permite la interacción con otros componentes del sistema, como la base de datos y la interfaz de usuario.
