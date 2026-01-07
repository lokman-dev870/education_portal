<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Forum;
use App\Models\ForumTopic;
use App\Models\ForumReply;
use App\Models\Resource;
use App\Models\StudyGroup;
use App\Models\Event;
use App\Models\News;
use App\Models\User;
use App\Models\StudentProfile;

class PortalEducativoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios de prueba
        $users = [];
        $names = ['Ana García', 'Carlos Ruiz', 'María López', 'Juan Pérez', 'Laura Martín', 'Diego Sánchez', 'Sofia Torres', 'Miguel Ángel', 'Carmen Díaz', 'Fernando Castro', 'Isabella Romero', 'Alejandro Morales', 'Valentina Cruz', 'Santiago Herrera', 'Camila Reyes', 'Mateo Flores', 'Lucía Navarro', 'Daniel Vargas', 'Victoria Mendoza', 'Gabriel Silva', 'Emma Ortiz', 'Lucas Ramírez', 'Mía Guerrero', 'Sebastián Rojas', 'Paula Jiménez', 'Andrés Medina', 'Daniela Castro', 'Nicolás Vega', 'Antonia Muñoz', 'Tomás Parra'];
        
        // Usuario admin
        $admin = User::create([
            'name' => 'Dr. Roberto Méndez',
            'email' => 'admin@portal.com',
            'password' => bcrypt('password'),
        ]);
        
        StudentProfile::create([
            'user_id' => $admin->id,
            'career' => 'Medicina',
            'university' => 'Universidad Nacional',
            'semester' => 10,
            'bio' => '🔬 Apasionado por la medicina y la enseñanza | 📚 Siempre dispuesto a ayudar | 💊 Medicina basada en evidencia',
            'interests' => ['Cirugía', 'Cardiología', 'Investigación Clínica', 'Docencia'],
        ]);
        
        $users[] = $admin;

        // Crear MUCHOS más usuarios para actividad constante
        for ($i = 0; $i < 30; $i++) {
            $user = User::create([
                'name' => $names[$i] ?? 'Estudiante ' . ($i + 1),
                'email' => 'estudiante' . ($i + 1) . '@portal.com',
                'password' => bcrypt('password'),
                'created_at' => now()->subDays(rand(0, 30)),
            ]);
            
            $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición', 'Farmacia', 'Psicología'];
            $emojis = ['🎓', '📚', '💊', '🔬', '🩺', '⚕️', '💉', '🧬', '🦷', '❤️', '🧠', '💪', '🌟'];
            $bios = [
                '🎯 Futuro médico comprometido | 📖 Amante del aprendizaje continuo',
                '💪 Apasionado por salvar vidas | 🏥 Enfermería es mi vocación',
                '✨ Estudiante dedicado | 🌍 Salud para todos',
                '🔥 Medicina basada en evidencia | 📊 Data-driven healthcare',
                '🧠 Neurofisiología es mi pasión | 💡 Siempre aprendiendo',
                '🦷 Sonrisas saludables | 😁 Odontología preventiva',
                '🏃 Fisioterapia y movimiento | ⚡ Recuperación activa',
                '🥗 Nutrición y bienestar | 🍎 Comida como medicina',
                '💊 Farmacología clínica | 🧪 Química farmacéutica',
                '🌈 Salud mental importa | 🧘 Psicología positiva'
            ];
            
            StudentProfile::create([
                'user_id' => $user->id,
                'career' => $careers[array_rand($careers)],
                'university' => ['Universidad Nacional', 'Universidad Central', 'U. Autónoma', 'Instituto Médico'][array_rand(['Universidad Nacional', 'Universidad Central', 'U. Autónoma', 'Instituto Médico'])],
                'semester' => rand(1, 12),
                'bio' => $bios[array_rand($bios)] . ' ' . $emojis[array_rand($emojis)],
                'interests' => array_rand(array_flip(['Anatomía', 'Fisiología', 'Práctica Clínica', 'Investigación', 'Cirugía', 'Pediatría', 'Geriatría', 'Emergencias', 'Salud Pública', 'Farmacología']), rand(2, 4)),
            ]);
            
            $users[] = $user;
        }

        // Crear foros con más variedad
        $forums = [
            [
                'name' => '🔥 Trending Ahora',
                'description' => 'Los temas más candentes y discutidos del momento',
                'category' => 'trending',
                'icon' => '🔥',
            ],
            [
                'name' => '💬 General',
                'description' => 'Discusiones generales sobre temas académicos y universitarios',
                'category' => 'general',
                'icon' => '💬',
            ],
            [
                'name' => '⚕️ Medicina',
                'description' => 'Foro dedicado a estudiantes de medicina',
                'category' => 'Medicina',
                'icon' => '⚕️',
            ],
            [
                'name' => '🩺 Enfermería',
                'description' => 'Espacio para estudiantes de enfermería',
                'category' => 'Enfermería',
                'icon' => '🩺',
            ],
            [
                'name' => '🦷 Odontología',
                'description' => 'Discusiones sobre odontología y salud oral',
                'category' => 'Odontología',
                'icon' => '🦷',
            ],
            [
                'name' => '❓ Ayuda y Dudas',
                'description' => 'Pregunta y resuelve tus dudas académicas',
                'category' => 'ayuda',
                'icon' => '❓',
            ],
            [
                'name' => '💡 Tips y Trucos',
                'description' => 'Comparte tus mejores consejos de estudio',
                'category' => 'tips',
                'icon' => '💡',
            ],
            [
                'name' => '🎉 Celebraciones',
                'description' => '¡Comparte tus logros y celebra con la comunidad!',
                'category' => 'celebraciones',
                'icon' => '🎉',
            ],
        ];

        foreach ($forums as $forumData) {
            $forum = Forum::create($forumData);
            
            // Títulos atractivos con emojis para los temas
            $topicTitles = [
                '🔥 ¡URGENTE! ¿Alguien más con problemas en este tema?',
                '💡 Encontré un método de estudio INCREÍBLE',
                '❓ Ayuda con anatomía - ¡Examen mañana!',
                '🎯 Tips que me ayudaron a sacar 10 en el parcial',
                '😱 No puedo creer lo difícil que fue este tema',
                '✨ Recursos GRATIS que debes conocer',
                '🚨 ALERTA: Cambios en el programa de estudios',
                '🎉 ¡Aprobé! Gracias a todos por la ayuda',
                '💪 Motivación para los que están batallando',
                '🤔 ¿Por qué nadie habla de esto?',
                '⚡ Técnica rápida para memorizar conceptos',
                '📚 Los mejores libros según mi experiencia',
                '🌟 Este profesor explica INCREÍBLE',
                '😤 Frustrado con este tema, necesito ayuda',
                '🔬 Experimento interesante que quiero compartir',
                '💊 Casos clínicos para practicar',
                '🎓 Consejos para el internado',
                '🏥 Mi primera experiencia en el hospital',
                '👀 Esto cambió mi forma de estudiar',
                '🚀 Acelera tu aprendizaje con esto',
                '❤️ Agradecimiento a esta comunidad',
                '🧠 Neuroanatomía: mi método paso a paso',
                '⏰ Gestión del tiempo durante exámenes',
                '💯 Cómo mejoré mis calificaciones en 1 mes',
                '🤝 ¿Alguien para formar grupo de estudio?',
            ];
            
            $topicContents = [
                'He estado investigando sobre este tema y encontré información muy interesante que quiero compartir con todos ustedes. ¿Qué opinan al respecto?',
                'Después de varias semanas practicando, finalmente entendí este concepto. Aquí les comparto mi experiencia y algunos consejos que me funcionaron.',
                'Estoy teniendo dificultades para entender este tema. ¿Alguien me puede explicar de forma sencilla? ¡Agradezco cualquier ayuda!',
                'Les quiero contar mi experiencia con esta materia. Al principio fue difícil, pero con estos métodos logré mejorar significativamente.',
                'Encontré este recurso increíble que me ha ayudado muchísimo. ¡Espero que a ustedes también les sirva!',
                '¿Alguien más está preparándose para el examen? Podemos compartir apuntes y resolver dudas juntos.',
                'Quiero compartir esta técnica de estudio que me recomendó un profesor. Ha sido un cambio total en mi forma de aprender.',
                'Acabo de terminar esta unidad y tengo algunas reflexiones que me gustaría discutir con la comunidad.',
            ];
            
            // Crear muchos más temas por foro (10-20)
            for ($i = 1; $i <= rand(10, 20); $i++) {
                $hoursAgo = rand(1, 72); // Temas de las últimas 72 horas
                $topic = ForumTopic::create([
                    'forum_id' => $forum->id,
                    'user_id' => $users[array_rand($users)]->id,
                    'title' => $topicTitles[array_rand($topicTitles)],
                    'content' => $topicContents[array_rand($topicContents)],
                    'views' => rand(10, 1500),
                    'views' => rand(10, 1500),
                    'created_at' => now()->subHours($hoursAgo),
                    'updated_at' => now()->subHours($hoursAgo),
                ]);
                
                $replyContents = [
                    '¡Totalmente de acuerdo! A mí también me funcionó 👍',
                    'Gracias por compartir, esto me ayudó mucho 🙏',
                    'No estoy seguro de esto... ¿podrías dar más detalles?',
                    'Interesante punto de vista! Lo voy a probar ✨',
                    'Esto contradice lo que vi en clase, ¿alguna fuente?',
                    'Me salvaste el parcial con esta info 🎉',
                    '¿Alguien tiene recursos adicionales sobre esto? 📚',
                    'Yo también estaba batallando con esto, muchas gracias!',
                    'Excelente explicación, mejor que la del libro 💡',
                    'Tengo una duda relacionada... 🤔',
                ];
                
                // Crear muchas más respuestas (3-15)
                for ($j = 1; $j <= rand(3, 15); $j++) {
                    $replyHoursAgo = rand(1, $hoursAgo);
                    ForumReply::create([
                        'topic_id' => $topic->id,
                        'user_id' => $users[array_rand($users)]->id,
                        'content' => $replyContents[array_rand($replyContents)],
                        'created_at' => now()->subHours($replyHoursAgo),
                        'updated_at' => now()->subHours($replyHoursAgo),
                    ]);
                }
                
                $topic->update(['replies_count' => $topic->replies()->count()]);
            }
            
            $forum->update([
                'topics_count' => $forum->topics()->count(),
                'posts_count' => $forum->topics()->sum('replies_count'),
            ]);
        }

        // Crear recursos con títulos atractivos
        $resourceTypes = ['apuntes', 'presentacion', 'articulo', 'guia', 'examen'];
        $subjects = ['Anatomía', 'Fisiología', 'Bioquímica', 'Farmacología', 'Patología', 'Microbiología', 'Histología', 'Neurología'];
        
        $resourceTitles = [
            '📝 Apuntes completos - Mejor que el libro',
            '🔥 Resumen que me sacó 10 en el examen',
            '✨ Guía práctica paso a paso',
            '💯 Todo lo que necesitas saber',
            '⚡ Repaso exprés pre-examen',
            '🎯 Conceptos clave simplificados',
            '💊 Casos clínicos resueltos',
            '🧠 Mapas mentales súper útiles',
            '📊 Tablas comparativas definitivas',
            '🔬 Procedimientos con imágenes',
            '💡 Tips que nadie te cuenta',
            '🎓 Material exclusivo del profesor',
            '⭐ Explicación mejor que las clases',
            '🚀 Técnicas avanzadas',
            '📚 Bibliografía actualizada 2025',
        ];
        
        // Crear 80+ recursos
        for ($i = 1; $i <= 80; $i++) {
            $daysAgo = rand(0, 30);
            Resource::create([
                'user_id' => $users[array_rand($users)]->id,
                'title' => $resourceTitles[array_rand($resourceTitles)],
                'description' => 'Material de estudio verificado y actualizado. Incluye conceptos clave, ejemplos prácticos y ejercicios resueltos.',
                'type' => $resourceTypes[array_rand($resourceTypes)],
                'file_path' => 'resources/ejemplo' . $i . '.pdf',
                'file_name' => 'documento_' . $i . '.pdf',
                'file_type' => 'pdf',
                'file_size' => rand(100000, 5000000),
                'career' => ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición'][array_rand(['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición'])],
                'subject' => $subjects[array_rand($subjects)],
                'semester' => rand(1, 10),
                'tags' => ['estudio', 'examen', 'repaso', 'importante', 'recomendado'][array_rand(['estudio', 'examen', 'repaso', 'importante', 'recomendado'])],
                'downloads' => rand(5, 350),
                'is_approved' => true,
                'created_at' => now()->subDays($daysAgo),
                'updated_at' => now()->subDays($daysAgo),
            ]);
        }

        // Crear grupos de estudio con nombres atractivos
        $groupNames = [
            '🔥 Squad de Anatomía',
            '💪 Guerreros del Examen Final',
            '🧠 Neurociencia Colectiva',
            '⚡ Repaso Intensivo',
            '🎯 Aprobamos o Aprobamos',
            '✨ Círculo de Estudio Premium',
            '💡 Mentes Brillantes',
            '🚀 Camino a la Excelencia',
            '📚 Bibliofilia Médica',
            '🏆 Top Estudiantes',
            '💊 Club de Farmacología',
            '🔬 Lab Rats Unidos',
            '🎓 Futuros Profesionales',
            '⭐ Estrellas del Semestre',
            '🤝 Apoyo Mutuo Académico',
        ];
        
        for ($i = 1; $i <= 25; $i++) {
            $group = StudyGroup::create([
                'user_id' => $users[array_rand($users)]->id,
                'name' => $groupNames[array_rand($groupNames)],
                'description' => '¡Únete a nuestro grupo! Compartimos apuntes, resolvemos dudas y nos motivamos mutuamente. Ambiente friendly y colaborativo 🎉',
                'subject' => $subjects[array_rand($subjects)],
                'career' => ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia'][array_rand(['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia'])],
                'max_members' => rand(8, 20),
                'is_public' => true,
            ]);
            
            // Agregar más miembros (3-8)
            $members = array_rand(array_flip(range(0, count($users) - 1)), rand(3, 8));
            foreach ((array)$members as $memberIndex) {
                $group->members()->attach($users[$memberIndex]->id, ['role' => 'member']);
            }
        }

        // Crear eventos con títulos llamativos
        $eventTypes = ['examen', 'entrega', 'seminario', 'conferencia'];
        
        $eventTitles = [
            '🚨 EXAMEN FINAL - No faltar!',
            '📝 Entrega de Trabajo Práctico',
            '🎓 Seminario: Casos Clínicos',
            '⚡ Conferencia de Último Momento',
            '🔥 Workshop Práctico Intensivo',
            '💡 Charla con Especialista',
            '🏥 Visita al Hospital Universitario',
            '🧬 Simposio de Investigación',
            '⭐ Presentación de Proyectos',
            '🎯 Simulacro de Examen',
            '📚 Sesión de Estudio Grupal',
            '🔬 Práctica de Laboratorio',
            '💊 Taller de Farmacología',
            '🎉 Ceremonia de Graduación',
            '⏰ URGENTE: Cambio de Horario',
        ];
        
        // Crear 50+ eventos (pasados, presentes y futuros)
        for ($i = 1; $i <= 50; $i++) {
            $daysOffset = rand(-15, 45); // Eventos en rango de 60 días
            $startDate = now()->addDays($daysOffset)->addHours(rand(8, 18));
            
            Event::create([
                'user_id' => $users[array_rand($users)]->id,
                'title' => $eventTitles[array_rand($eventTitles)],
                'description' => 'Evento importante para estudiantes. Se recomienda asistencia puntual. ¡No te lo pierdas!',
                'type' => $eventTypes[array_rand($eventTypes)],
                'location' => ['Aula ' . rand(100, 500), 'Auditorio Principal', 'Lab ' . rand(1, 10), 'Sala Virtual', 'Campus Central'][array_rand(['Aula ' . rand(100, 500), 'Auditorio Principal', 'Lab ' . rand(1, 10), 'Sala Virtual', 'Campus Central'])],
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addHours(rand(2, 4)),
                'color' => ['#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#ec4899'][array_rand(['#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6', '#10b981', '#ec4899'])],
                'career' => ['Medicina', 'Enfermería', 'Odontología', 'Todas las carreras'][array_rand(['Medicina', 'Enfermería', 'Odontología', 'Todas las carreras'])],
                'subject' => $subjects[array_rand($subjects)],
                'is_public' => true,
            ]);
        }

        // Crear noticias con titulares llamativos
        $categories = ['general', 'academico', 'evento', 'importante', 'urgente'];
        
        $newsTitles = [
            '🔥 ÚLTIMA HORA: Cambios importantes en el plan de estudios',
            '⚡ BREAKING: Nueva biblioteca digital disponible',
            '🎉 ¡INCREÍBLE! Estudiante logra beca completa',
            '🚨 ALERTA: Fechas de exámenes actualizadas',
            '💡 Descubre esta nueva técnica de estudio',
            '⭐ Reconocimiento a mejores promedios del semestre',
            '🏥 Hospital Universitario abre nuevas plazas',
            '📚 Nuevos recursos disponibles en la biblioteca',
            '🔬 Avance científico: Investigación universitaria',
            '💊 Importante: Protocolo de seguridad actualizado',
            '🎓 Ceremonia de graduación - Detalles',
            '⏰ URGENTE: Cambio de horarios para esta semana',
            '🌟 Historia de éxito: Ex-alumno comparte su experiencia',
            '💪 Programa de apoyo académico ampliado',
            '🎯 Tips de profesores para el examen final',
        ];
        
        $newsExcerpts = [
            '¡No te pierdas esta información crucial! Entérate de todos los detalles aquí 👀',
            'Esto va a cambiar tu forma de estudiar. Lee más para descubrir cómo ✨',
            'La comunidad está en shock con esta noticia. Conoce todos los detalles 🔥',
            'Información verificada y actualizada. Comparte con tus compañeros 📢',
            'Todos están hablando de esto. ¿Ya te enteraste? 💬',
        ];
        
        // Crear 60+ noticias recientes
        for ($i = 1; $i <= 60; $i++) {
            $hoursAgo = rand(1, 720); // Noticias de las últimas 30 días
            News::create([
                'user_id' => $admin->id,
                'title' => $newsTitles[array_rand($newsTitles)],
                'excerpt' => $newsExcerpts[array_rand($newsExcerpts)],
                'content' => 'Contenido completo de la noticia con toda la información detallada. Esta actualización es muy importante para toda la comunidad estudiantil. Asegúrate de leer hasta el final para no perderte ningún detalle. La administración recomienda compartir esta información con todos tus compañeros.',
                'category' => $categories[array_rand($categories)],
                'is_featured' => $i <= 8, // Más noticias destacadas
                'is_published' => true,
                'published_at' => now()->subHours($hoursAgo),
                'created_at' => now()->subHours($hoursAgo),
                'updated_at' => now()->subHours($hoursAgo),
                'views' => rand(50, 1200),
            ]);
        }

        $this->command->info('🎉 Portal educativo poblado con TONELADAS de datos de prueba!');
        $this->command->info('📊 Estadísticas:');
        $this->command->info('   - 30 usuarios activos');
        $this->command->info('   - 100+ temas de foro con cientos de respuestas');
        $this->command->info('   - 80+ recursos educativos');
        $this->command->info('   - 25 grupos de estudio');
        $this->command->info('   - 50 eventos programados');
        $this->command->info('   - 60+ noticias recientes');
        $this->command->info('✨ ¡El portal está SÚPER activo!');
    }
}
