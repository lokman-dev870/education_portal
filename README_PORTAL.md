# Portal Educativo para Estudiantes de Ciencias de la Salud

Portal web completo diseñado para estudiantes universitarios de carreras del área de la salud (Medicina, Enfermería, Odontología, Fisioterapia, Nutrición, Farmacia, etc.).

## 🎯 Características Principales

### 1. **Perfiles de Usuario Personalizados**
- Información académica detallada (carrera, semestre, universidad)
- Biografía e intereses
- Avatar personalizado
- Historial de actividad

### 2. **Repositorio de Recursos Académicos**
- Subida y descarga de archivos (apuntes, presentaciones, artículos, guías)
- Sistema de categorización por carrera, materia y semestre
- Sistema de valoraciones y comentarios
- Búsqueda y filtrado avanzado
- Contadores de descargas

### 3. **Foros de Discusión**
- Múltiples foros por categoría
- Creación de temas y respuestas
- Temas fijados y bloqueados
- Marcado de respuestas como solución
- Contador de vistas y respuestas

### 4. **Grupos de Estudio**
- Creación de grupos públicos/privados
- Límite de miembros configurable
- Enlaces de reunión (Zoom, Meet, etc.)
- Gestión de miembros y roles

### 5. **Calendario de Eventos**
- Eventos académicos (exámenes, entregas, seminarios, conferencias)
- Vista de calendario interactivo
- Eventos públicos y privados
- Categorización por colores según tipo
- Sistema de asistentes

### 6. **Noticias y Anuncios**
- Publicación de noticias
- Categorías (General, Académico, Eventos, Importante)
- Noticias destacadas
- Sistema de visualizaciones
- Noticias relacionadas

### 7. **Búsqueda Avanzada**
- Búsqueda global en todo el portal
- Filtros por tipo de contenido
- Búsqueda en recursos, foros, noticias y eventos
- Resultados categorizados

### 8. **Diseño Responsivo**
- Compatible con dispositivos móviles, tablets y desktop
- Modo claro/oscuro
- Interfaz moderna con Tailwind CSS
- Experiencia de usuario optimizada

## 🛠️ Tecnologías Utilizadas

- **Laravel 11** - Framework PHP
- **Livewire 3** - Componentes dinámicos
- **Tailwind CSS** - Estilos y diseño responsivo
- **MySQL/PostgreSQL** - Base de datos
- **Laravel Fortify** - Autenticación

## 📋 Requisitos del Sistema

- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL >= 8.0 o PostgreSQL >= 13
- Apache/Nginx

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
cd education_portal
```

### 2. Instalar dependencias de PHP

```bash
composer install
```

### 3. Instalar dependencias de Node.js

```bash
npm install
```

### 4. Configurar el archivo de entorno

```bash
cp .env.example .env
```

Editar el archivo `.env` y configurar:

```env
APP_NAME="Portal Educativo"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=education_portal
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

### 5. Generar la clave de la aplicación

```bash
php artisan key:generate
```

### 6. Crear la base de datos

Crear una base de datos MySQL llamada `education_portal` o el nombre que configuraste en `.env`.

### 7. Ejecutar las migraciones

```bash
php artisan migrate
```

### 8. Crear el enlace simbólico de storage

```bash
php artisan storage:link
```

### 9. Poblar la base de datos con datos de prueba (opcional)

```bash
php artisan db:seed --class=PortalEducativoSeeder
```

Esto creará:
- Usuario admin: `admin@portal.com` / `password`
- 10 estudiantes de prueba: `estudiante1@portal.com` a `estudiante10@portal.com` / `password`
- Foros con temas y respuestas
- Recursos académicos
- Grupos de estudio
- Eventos
- Noticias

### 10. Compilar assets

```bash
npm run build
```

Para desarrollo con recarga automática:

```bash
npm run dev
```

### 11. Iniciar el servidor

```bash
php artisan serve
```

El portal estará disponible en: `http://localhost:8000`

## 👥 Usuarios de Prueba

Después de ejecutar el seeder, puedes usar:

- **Administrador**: 
  - Email: `admin@portal.com`
  - Password: `password`

- **Estudiantes**: 
  - Email: `estudiante1@portal.com` a `estudiante10@portal.com`
  - Password: `password`

## 📱 Estructura del Proyecto

```
app/
├── Models/              # Modelos Eloquent
│   ├── User.php
│   ├── StudentProfile.php
│   ├── Resource.php
│   ├── Forum.php
│   ├── ForumTopic.php
│   ├── ForumReply.php
│   ├── StudyGroup.php
│   ├── Event.php
│   └── News.php
├── Livewire/           # Componentes Livewire
│   ├── Resources/
│   ├── Forums/
│   ├── StudyGroups/
│   ├── Events/
│   ├── News/
│   ├── Profile/
│   └── Search/
database/
├── migrations/         # Migraciones de base de datos
└── seeders/           # Seeders
resources/
├── views/
│   ├── dashboard.blade.php
│   └── livewire/      # Vistas de componentes Livewire
routes/
└── web.php            # Rutas del portal
```

## 🎨 Características de la UI

- **Dashboard**: Vista general con estadísticas y accesos rápidos
- **Sistema de notificaciones**: Mensajes flash para confirmaciones
- **Modales**: Para creación y edición de contenido
- **Paginación**: En todas las listas
- **Filtros dinámicos**: Sin recargar la página (Livewire)
- **Modo oscuro**: Compatible con temas claro/oscuro

## 🔐 Seguridad

- Autenticación obligatoria para todas las funciones
- Validación de formularios en servidor
- Protección CSRF
- Sanitización de entradas
- Control de acceso basado en usuario

## 🌐 Rutas Principales

- `/dashboard` - Panel principal
- `/resources` - Repositorio de recursos
- `/forums` - Foros de discusión
- `/study-groups` - Grupos de estudio
- `/calendar` - Calendario de eventos
- `/news` - Noticias y anuncios
- `/search` - Búsqueda avanzada
- `/profile/edit-student` - Editar perfil de estudiante

## 📝 Próximas Mejoras

- [ ] Sistema de mensajería privada
- [ ] Notificaciones en tiempo real
- [ ] Sistema de insignias y gamificación
- [ ] Integración con APIs de videoconferencia
- [ ] Sistema de tareas y recordatorios
- [ ] Módulo de evaluaciones y exámenes
- [ ] Chat en tiempo real para grupos
- [ ] Sistema de mentorías
- [ ] Integración con bibliotecas digitales
- [ ] App móvil nativa

## 🤝 Contribuciones

Este proyecto es un portal educativo completo. Para contribuir:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto es de código abierto y está disponible bajo la licencia MIT.

## 🐛 Reporte de Bugs

Si encuentras algún bug, por favor abre un issue en el repositorio.

## 📧 Soporte

Para soporte técnico o preguntas, contacta con el equipo de desarrollo.

---

**Desarrollado con ❤️ para la comunidad estudiantil de Ciencias de la Salud**
