# 📌 Proyecto Final – Plataforma de Gestión de Eventos

## 📖 Descripción general

Este proyecto es una aplicación web desarrollada como trabajo final, inspirada en el proyecto **“Galería de imágenes”** realizado con Symfony durante el segundo trimestre, pero con una **temática diferente y de libre elección**.

La aplicación permite a los usuarios **publicar eventos**, **operar con ellos** (por ejemplo, apuntarse a eventos) y **gestionar su información**, diferenciando claramente entre **front-office** y **back-office**, así como entre **usuarios normales y administradores**.

---

## 🧩 Estructura del proyecto

El proyecto está dividido en dos grandes partes:

### 🔓 Front-office (zona pública)
Accesible para cualquier usuario, incluso sin estar registrado.

### 🔐 Back-office (zona privada)
Accesible únicamente tras iniciar sesión, con diferentes permisos según el tipo de usuario.

---

## 👥 Tipos de usuarios

### 👤 Usuario anónimo
- Acceso a la página principal
- Login
- Registro
- Visualización de eventos publicados

### 👤 Usuario normal
- Acceso al back-office
- Crear, editar y eliminar **solo sus propios eventos**
- Ver los eventos con los que ha operado
- Acceder y modificar su perfil
- Logout (mostrando su nombre)

### 🛡️ Usuario administrador
- Todas las funcionalidades del usuario normal
- Gestión completa de eventos de todos los usuarios
- Gestión de usuarios:
  - Cambiar tipo de usuario
  - Eliminar usuarios (si no tienen datos asociados)

---

## 🧭 Menú dinámico

El menú principal varía según el estado del usuario:

### Antes de hacer login
- Página principal
- Login
- Registro

### Usuario normal
- Página principal
- Mis eventos
- Mis operaciones
- Mi perfil
- Logout

### Usuario administrador
- Todas las opciones del usuario normal
- Gestión de usuarios

---

## 🌐 Front-office

### 🔑 Login
- Formulario con email y contraseña
- Redirección automática al área privada tras un login correcto
- No se permite acceder al login si el usuario ya está logueado

### 📝 Registro
- Registro de usuarios normales
- Campos:
  - Nombre de usuario
  - Email
  - Contraseña (con verificación)
  - CAPTCHA numérico
- Login automático tras registro correcto

### 🏠 Página principal
- Listado de eventos ordenados por fecha
- Información mostrada por evento:
  - Imagen (o imagen por defecto)
  - Título
  - Fecha
  - Usuario creador
  - Opción “Ver más”
- Filtros:
  - Por categoría
  - Entre dos fechas
- Búsqueda por texto en título y descripción

### 📄 Página de detalles
- Imagen en grande
- Título
- Fecha
- Descripción
- Usuario creador (enlace a sus eventos)

### 🔄 Operaciones sobre eventos
- El usuario debe estar logueado
- Ejemplo: apuntarse a un evento
- Se guarda la relación usuario–evento
- El creador del evento recibe un correo electrónico notificando la operación

---

## 🧑‍💼 Back-office

### 📋 Mis eventos
- Tabla con los eventos creados por el usuario
- Acciones:
  - Ver
  - Editar
  - Eliminar (solo si no existen datos asociados)

### 📦 Mis operaciones
- Lista de eventos con los que el usuario ha interactuado

### ➕ Crear evento
- Formulario con todos los datos necesarios
- Subida de imagen incluida

### 👤 Mi perfil
- Visualización de datos del usuario
- Operaciones independientes:
  - Cambiar contraseña
  - Cambiar avatar
    - Tamaño máximo: 10KB
    - Resolución: 100x100 px
    - Formato: JPG o PNG
- Avatar por defecto al registrarse

### 🛠️ Gestión de usuarios (Administrador)
- Tabla con todos los usuarios
- Funcionalidades:
  - Cambiar tipo de usuario
  - Eliminar usuarios (si no tienen datos asociados)
- Filtro por tipo de usuario

---

## 🔐 Control de acceso

- Todas las páginas privadas requieren login
- Redirección automática al login si no hay sesión activa
- Control de permisos según el rol del usuario

---

## 🗄️ Base de datos

- Base de datos en **MariaDB**
- Acceso mediante **PDO**
- Uso de consultas preparadas para evitar **SQL Injection**
- Contraseñas encriptadas con **bcrypt**
- Usuario administrador por defecto:
  - Usuario: `admin`
  - Contraseña: `admin`
- Se incluye un script SQL con:
  - Creación de la base de datos
  - Creación del usuario de la BBDD
  - Estructura de tablas
  - Datos de ejemplo

---

## ✅ Validaciones y seguridad

- Validación completa en el servidor
- Campos obligatorios correctamente validados
- CAPTCHA en el registro
- Control de tamaño y formato de imágenes
- El proyecto funciona correctamente sin validación en cliente

---

## 🎨 Diseño

- Uso de plantilla externa o diseño propio
- Interfaz coherente con la temática
- Diseño responsive
- Uso moderado de imágenes para no exceder el tamaño de entrega

---

## 🚀 Tecnologías utilizadas

- PHP
- Symfony
- MariaDB
- PDO
- HTML5 / CSS3
- JavaScript
- Tailwind / Bootstrap
- Git / GitHub

---

## 📂 Entrega

El repositorio incluye:
- Código fuente completo
- Script SQL de la base de datos
- Usuario administrador por defecto
- Este archivo README.md
