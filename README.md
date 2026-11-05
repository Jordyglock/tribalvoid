# Proyecto final: tienda de ropa dark / neotribal (PHP + MySQL)

## Instalación con XAMPP
1. Copia la carpeta `tribalvoid` dentro de `C:\xampp\htdocs\`.
2. Inicia **Apache** y **MySQL** desde el panel de XAMPP.
3. Abre `http://localhost/phpmyadmin`, ve a *Importar* y sube `database/schema.sql`.
4. Si tu carpeta tiene otro nombre o MySQL tiene contraseña, edita `config/conexion.php`.
5. Abre `http://localhost/tribalvoid/`.

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
