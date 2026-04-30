# KME Inventario y Ventas

Sistema web simple desarrollado con **PHP, HTML, CSS y JavaScript**, orientado a la gestión básica de productos y al registro de ventas.  
Este proyecto forma parte de una actividad académica de **Programación Web**, aplicando estructura organizada, validaciones, almacenamiento local y control de versiones con GitHub.

---

## Descripción del sistema

**KME Inventario y Ventas** es un sistema web diseñado para:

- administrar productos
- validar datos ingresados
- visualizar productos registrados
- editar y eliminar productos
- preparar la estructura para el módulo de ventas

En esta etapa del proyecto, el sistema ya cuenta con una base funcional para el **CRUD de productos**, utilizando `localStorage` como mecanismo de almacenamiento en el navegador.

---

## Tecnologías utilizadas

- **PHP**
- **HTML5**
- **CSS3**
- **JavaScript**
- **LocalStorage**
- **GitHub**

---

## Funcionalidades implementadas en este avance

### Módulo de productos

- Crear producto
- Listar productos
- Editar producto
- Eliminar producto

### Validaciones aplicadas

- Nombre no vacío
- Precio mayor a 0
- Stock mayor o igual a 0
- No permitir stock negativo

### Características adicionales

- Campo de categoría
- Generación de identificador único
- Estado visual de stock
- Mensajes de confirmación y error
- Resumen de productos en la página principal

---

## Estructura del proyecto

```text
kme-inventario-ventas/
├── public/
│   ├── index.php
│   ├── productos.php
│   ├── ventas.php
│   └── assets/
│       ├── css/
│       │   └── style.css
│       └── js/
│           ├── productos.js
│           └── ventas.js
├── config/
├── models/
├── controllers/
├── services/
├── database/
└── README.md
```
