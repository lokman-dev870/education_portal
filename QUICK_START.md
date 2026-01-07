# 🚀 Inicio Rápido - Portal Educativo

## ✅ Instalación Completa

El portal educativo para estudiantes de ciencias de la salud ha sido instalado exitosamente con todas las funcionalidades.

## 📦 Lo que se ha Implementado

### ✨ Funcionalidades Principales

1. **✅ Sistema de Perfiles de Usuario**
   - Perfiles personalizados con información académica
   - Foto de perfil, biografía, intereses
   - Carrera, universidad, semestre

2. **✅ Repositorio de Recursos**
   - Subida y descarga de archivos (PDF, DOCX, PPTX, etc.)
   - Categorización por tipo, carrera, materia, semestre
   - Sistema de valoraciones y comentarios
   - Filtros avanzados de búsqueda
   - Contador de descargas

3. **✅ Foros de Discusión**
   - Múltiples foros categorizados
   - Creación de temas y respuestas
   - Temas fijados y bloqueados
   - Respuestas anidadas
   - Marcado de soluciones

4. **✅ Grupos de Estudio**
   - Creación de grupos públicos/privados
   - Gestión de miembros
   - Enlaces a videoconferencias
   - Límite de miembros configurable

5. **✅ Calendario de Eventos**
   - Eventos académicos (exámenes, entregas, seminarios, conferencias)
   - Vista de calendario mensual
   - Categorización por colores
   - Eventos públicos y privados

6. **✅ Noticias y Anuncios**
   - Sistema de publicación de noticias
   - Categorías (General, Académico, Eventos, Importante)
   - Noticias destacadas
   - Contador de visualizaciones

7. **✅ Búsqueda Avanzada**
   - Búsqueda global en todo el portal
   - Filtros por tipo de contenido
   - Resultados categorizados

8. **✅ Diseño Responsivo**
   - Compatible con móvil, tablet y desktop
   - Modo oscuro/claro
   - Interfaz moderna con Tailwind CSS

## 🗄️ Base de Datos

### Tablas Creadas:
- `users` - Usuarios del sistema
- `student_profiles` - Perfiles de estudiantes
- `resources` - Recursos académicos
- `resource_ratings` - Valoraciones de recursos
- `forums` - Foros de discusión
- `forum_topics` - Temas de foros
- `forum_replies` - Respuestas a temas
- `study_groups` - Grupos de estudio
- `study_group_members` - Miembros de grupos
- `events` - Eventos del calendario
- `event_attendees` - Asistentes a eventos
- `news` - Noticias y anuncios

### Datos de Prueba Incluidos:
- ✅ 1 usuario administrador
- ✅ 10 estudiantes de prueba
- ✅ 5 foros con temas y respuestas
- ✅ 30 recursos académicos
- ✅ 15 grupos de estudio
- ✅ 20 eventos
- ✅ 15 noticias

## 👤 Credenciales de Acceso

### Administrador:
```
Email: admin@portal.com
Password: password
```

### Estudiantes (1-10):
```
Email: estudiante1@portal.com a estudiante10@portal.com
Password: password
```

## 🎯 Cómo Iniciar el Servidor

```bash
# En el directorio del proyecto
cd /home/automata/projects/educational_portal/education_portal

# Iniciar el servidor de desarrollo
php artisan serve
```

El portal estará disponible en: **http://localhost:8000**

## 🔗 Rutas Principales

Una vez iniciado el servidor, podrás acceder a:

- **Dashboard**: http://localhost:8000/dashboard
- **Recursos**: http://localhost:8000/resources
- **Foros**: http://localhost:8000/forums
- **Grupos de Estudio**: http://localhost:8000/study-groups
- **Calendario**: http://localhost:8000/calendar
- **Noticias**: http://localhost:8000/news
- **Búsqueda**: http://localhost:8000/search
- **Mi Perfil**: http://localhost:8000/profile/edit-student

## 📝 Próximos Pasos

### Para usar el portal:

1. **Inicia el servidor**:
   ```bash
   php artisan serve
   ```

2. **Accede al portal**: http://localhost:8000

3. **Inicia sesión** con cualquiera de las credenciales de prueba

4. **Explora las funcionalidades**:
   - Crea tu perfil de estudiante
   - Sube recursos académicos
   - Participa en los foros
   - Únete a grupos de estudio
   - Crea eventos en el calendario
   - Lee las noticias

### Para desarrollo:

Si necesitas hacer cambios y ver actualizaciones en tiempo real:

```bash
# Terminal 1: Servidor PHP
php artisan serve

# Terminal 2: Compilación de assets (en otra terminal)
npm run dev
```

## 🎨 Personalización

### Modificar configuraciones:
- Archivo principal: `.env`
- Rutas: `routes/web.php`
- Componentes Livewire: `app/Livewire/`
- Vistas: `resources/views/`
- Estilos: `resources/css/app.css`

### Agregar nuevas carreras:
Edita los arrays de carreras en los componentes Livewire correspondientes.

## 🔒 Seguridad

- Todas las rutas requieren autenticación
- CSRF protection habilitado
- Validación de formularios
- Sanitización de entradas

## 📚 Documentación Completa

Para más detalles, consulta el archivo **README_PORTAL.md** en el directorio del proyecto.

## ⚡ Comandos Útiles

```bash
# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recrear la base de datos
php artisan migrate:fresh --seed

# Ver rutas disponibles
php artisan route:list
```

## 🐛 Solución de Problemas

### Error de conexión a la base de datos:
Verifica el archivo `.env` y asegúrate de que las credenciales sean correctas.

### Error de permisos en storage:
```bash
chmod -R 775 storage bootstrap/cache
```

### Assets no se cargan:
```bash
npm install
npm run build
```

## 💡 Características Destacadas

- ⚡ **Livewire**: Interactividad sin JavaScript personalizado
- 🎨 **Tailwind CSS**: Diseño moderno y responsivo
- 🔐 **Laravel Fortify**: Autenticación robusta
- 📱 **Responsive**: Funciona en todos los dispositivos
- 🌙 **Dark Mode**: Soporte para tema oscuro
- 🔍 **Búsqueda avanzada**: Encuentra contenido rápidamente

---

**¡El portal está listo para usar! 🎉**

Para iniciar, ejecuta `php artisan serve` y accede a http://localhost:8000
