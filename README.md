# Proyecto final: tienda de ropa dark / neotribal (PHP + MySQL)

## Instalación con XAMPP
1. Copia la carpeta `tribalvoid` dentro de `C:\xampp\htdocs\`.
2. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
3. Abre `http://localhost/phpmyadmin`, ve a *Importar* y sube `database/schema.sql`.
4. Si MySQL tiene contraseña, edita las credenciales en `config/conexion.php`.
5. Abre `http://localhost/tribalvoid/`. La ruta base se detecta automáticamente, incluso si la carpeta del proyecto tiene otro nombre.

## Compartir o mover el proyecto a otro equipo
El catálogo guarda en MySQL rutas relativas, no la ubicación física del equipo. Las fotos deben acompañar al proyecto: comparte la carpeta completa, incluyendo `assets/img/productos/` y `assets/img/libreria de imagenes productos/`.

Para conservar los productos y sus fotos:
1. Comprime y comparte toda la carpeta del proyecto.
2. En phpMyAdmin, exporta la base de datos `marca_dark` completa como SQL, incluyendo estructura y datos. No basta con compartir `database/schema.sql`, porque ese archivo crea las tablas y unos productos de ejemplo, pero no exporta los cambios del catálogo.
3. En el otro equipo, extrae el proyecto dentro de `C:\xampp\htdocs\`, importa el SQL exportado en MySQL y abre `http://localhost/nombre-de-la-carpeta/`.

Cada equipo necesita Apache y MySQL (por ejemplo, XAMPP). Para que otras personas lo vean por Internet o desde sus dispositivos fuera de esa computadora, el sitio debe publicarse en un servidor web; `localhost` solo funciona en el equipo donde se está ejecutando.

## Cargar el catálogo de imágenes
Después de importar el esquema, ejecuta desde PowerShell (ajusta la ruta si la carpeta tiene otro nombre):

```powershell
C:\xampp\php\php.exe C:\xampp\htdocs\tribalvoid\database\importar_catalogo.php
```

El importador agrupa las fotos frontales y traseras, asigna cinco unidades por producto y puede ejecutarse de nuevo sin duplicar productos ni fotos. Los precios se asignan por categoría como referencia y se pueden editar desde el panel de administración.

## Acceso de administrador
- Correo: `admintribalvoid@gmail.com`
- Contraseña: `Admin123` (cámbiala después de iniciar sesión)

## Personalizar
- Nombre de la marca: constante `MARCA` en `config/conexion.php`.
- Colores y tipografías: variables al inicio de `assets/css/estilos.css`.
- Fotos de producto: se suben desde Panel > Productos > Editar.
- Textos de "Nosotros": archivo `nosotros.php`.
