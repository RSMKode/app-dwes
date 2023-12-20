# app-dwes

 - Roger
 - Jonathan
 - Samuel

Ejercicio evaluable de la asignatura Desarrollo en Entorno Servidor - 2º DAW.

Las características de la aplicación se detallan en:
[Evaluable DWES semipresencial.pdf](https://github.com/RSMKode/app-dwes/files/13383127/Evaluable.DWES.semipresencial.pdf)

## Instrucciones y aclaraciones:
La app utiliza el valor de la constante $_SERVER['DOCUMENT_ROOT'] definida en la configuración de Apache de XAMPP para las rutas absolutas.

Para que todo funcione correctamente:
- Asegurarse que la carpeta del repositorio clonado en su PC y el valor de la constante APP_ROOT de /libs/config.php tengan el mismo nombre.
- Además, el valor de la constante ha de empezar y terminar con una barra.
```PHP
"const APP_ROOT = "/app-dwes/";
```
- Ignorar la carpeta modif y sus archivos. La modificación de la información de usuario se implementarás más adelante.

---
