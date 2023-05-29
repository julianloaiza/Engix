## Estructura de Archivos del Plugin "Social Share"

Dentro de la carpeta "social-share" del plugin "Social Share" se encuentran los siguientes archivos y carpetas:

- **images/**: Esta carpeta contiene los archivos de imagen utilizados para los logos de las redes sociales e iconos del plugin. Estas imágenes son utilizadas en la interfaz de usuario para representar visualmente las diferentes opciones de compartir en redes sociales.

- **phpqrcode/**: Esta carpeta contiene el código fuente de la librería PHPQRCode, utilizada para generar códigos QR. La librería PHPQRCode permite la generación de imágenes de códigos QR a partir de datos proporcionados. Puedes encontrar más información sobre esta librería en el enlace proporcionado.

- **qr_codes/**: Esta carpeta se utiliza para guardar las imágenes de los códigos QR generados a partir de los perfiles de usuario. Cada imagen de código QR se guarda en esta carpeta utilizando el algoritmo MD5 para generar un nombre único y asociarlo con el perfil correspondiente.

- **frontend.css**: Este archivo contiene los estilos CSS específicos para la parte frontal del plugin "Social Share". Aquí se pueden realizar modificaciones en los estilos visuales para adaptarlos al diseño general de tu sitio web.

- **social-share.php**: En este archivo se realiza el registro del shortcode, la funcionalidad principal y la estructura HTML del plugin "Social Share". Aquí se pueden definir las opciones de compartir en redes sociales, generar códigos QR, y otras funcionalidades relacionadas con el intercambio de perfiles en redes sociales.
