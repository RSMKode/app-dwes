# app-dwes-roger-jonathan
Ejercicio evaluable de la asignatura Desarrollo en Entorno Servidor - 2º DAW.

Las características de la aplicación se detallan en:
[Evaluable DWES semipresencial.pdf](https://github.com/RSMKode/app-dwes-roger-jonathan/files/13383127/Evaluable.DWES.semipresencial.pdf)

## Instrucciones y aclaraciones:
La app utiliza el valor de la constante $_SERVER['DOCUMENT_ROOT'] definida en la configuración de Apache de XAMPP para las rutas absolutas.

Para que todo funcione correctamente:
- Asegurarse que la carpeta del repositorio clonado en su PC y el valor de la constante APP_ROOT de /libs/config.php tengan el mismo nombre.
- Además, el valor de la constante ha de empezar y terminar con una barra.
```PHP
"const APP_ROOT = "/app-dwes-roger-jonathan/";
```
- Ignorar la carpeta modif y sus archivos. La modificación de la información de usuario se implementarás más adelante.

---

-----
Habéis trabajado mucho y el resultado no es malo pero os detallo lo que se puede mejorar:
-Os he comentado en varios sitios que las comprobaciones de seguridad de sesiones sólo se hacen en la parte privada.
-Os he incluido como bloquear para que un usuario no haga algo privado sin estar logueado, es lo mismo que tenéis en los ejemplos.
-En algunos sitios ponéis echos que podráis quitar y organizar de otra manera
-La organización del código del proyecto creo que es más sencilla si seguis las indicaciones que os puse sobre todo: por una parte las vistas o templates y por otra el código que controla los datos (php)
A continuación os copio la estructura que os puse en AULES:

•	La carpeta app contiene el núcleo, la lógica de la aplicación:
o	libs: Aquí se almacenaremos tanto las librerías de configuración como las de funciones reutilizables.
o	manejadoresForm: Este directorio contiene los ficheros que gestionan la lógica de la aplicación. En la mayoría de los casos ficheros que gestionan la lógica de los formularios.
o	logs: Aquí se guardan los ficheros log para guardar los errores controlados.
o	vistas: La carpeta vistas contiene las vistas, en concreto serán los formularios y otros ficheros que no contienen lógica. Podemos dividirla en forms y templates.
o	Ficheros: Guardamos los ficheros de texto que usamos para almacenar datos.
•	La carpeta public generalmente contiene los archivos y recursos que son accesibles de manera pública a través del servidor web. Esto incluye todos los archivos que los navegadores web pueden solicitar directamente, CSS, JavaScript, imágenes y otros recursos estáticos.



