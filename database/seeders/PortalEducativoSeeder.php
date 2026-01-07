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
        
        // Usuario admin
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@portal.com',
            'password' => bcrypt('password'),
        ]);
        
        StudentProfile::create([
            'user_id' => $admin->id,
            'career' => 'Medicina',
            'university' => 'Universidad Nacional',
            'semester' => 8,
            'bio' => 'Estudiante de medicina apasionado por la enseñanza.',
            'interests' => ['Cirugía', 'Pediatría', 'Investigación'],
        ]);
        
        $users[] = $admin;

        // Crear más usuarios
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => 'Estudiante ' . $i,
                'email' => 'estudiante' . $i . '@portal.com',
                'password' => bcrypt('password'),
            ]);
            
            $careers = ['Medicina', 'Enfermería', 'Odontología', 'Fisioterapia', 'Nutrición'];
            
            StudentProfile::create([
                'user_id' => $user->id,
                'career' => $careers[array_rand($careers)],
                'university' => 'Universidad Nacional',
                'semester' => rand(1, 10),
                'bio' => 'Estudiante comprometido con el aprendizaje.',
                'interests' => ['Anatomía', 'Fisiología', 'Práctica Clínica'],
            ]);
            
            $users[] = $user;
        }

        // Crear foros
        $forums = [
            [
                'name' => 'General',
                'description' => 'Discusiones generales sobre temas académicos y universitarios',
                'category' => 'general',
                'icon' => '💬',
            ],
            [
                'name' => 'Medicina',
                'description' => 'Foro dedicado a estudiantes de medicina',
                'category' => 'Medicina',
                'icon' => '⚕️',
            ],
            [
                'name' => 'Enfermería',
                'description' => 'Espacio para estudiantes de enfermería',
                'category' => 'Enfermería',
                'icon' => '🩺',
            ],
            [
                'name' => 'Odontología',
                'description' => 'Discusiones sobre odontología y salud oral',
                'category' => 'Odontología',
                'icon' => '🦷',
            ],
            [
                'name' => 'Ayuda y Dudas',
                'description' => 'Pregunta y resuelve tus dudas académicas',
                'category' => 'ayuda',
                'icon' => '❓',
            ],
        ];

        foreach ($forums as $forumData) {
            $forum = Forum::create($forumData);
            
            // Crear algunos temas en cada foro
            for ($i = 1; $i <= rand(3, 6); $i++) {
                $topic = ForumTopic::create([
                    'forum_id' => $forum->id,
                    'user_id' => $users[array_rand($users)]->id,
                    'title' => 'Tema de ejemplo ' . $i . ' en ' . $forum->name,
                    'content' => 'Este es el contenido del tema de ejemplo. Aquí se discuten diversos temas relacionados con ' . $forum->name . '.',
                    'views' => rand(10, 500),
                ]);
                
                // Crear algunas respuestas
                for ($j = 1; $j <= rand(1, 5); $j++) {
                    ForumReply::create([
                        'topic_id' => $topic->id,
                        'user_id' => $users[array_rand($users)]->id,
                        'content' => 'Esta es una respuesta de ejemplo al tema. Gracias por compartir esta información.',
                    ]);
                }
                
                $topic->update(['replies_count' => $topic->replies()->count()]);
            }
            
            $forum->update([
                'topics_count' => $forum->topics()->count(),
                'posts_count' => $forum->topics()->sum('replies_count'),
            ]);
        }

        // Crear recursos
        $resourceTypes = ['apuntes', 'presentacion', 'articulo', 'guia', 'examen'];
        $subjects = ['Anatomía', 'Fisiología', 'Bioquímica', 'Farmacología', 'Patología', 'Microbiología'];
        
        for ($i = 1; $i <= 30; $i++) {
            Resource::create([
                'user_id' => $users[array_rand($users)]->id,
                'title' => 'Recurso educativo ' . $i,
                'description' => 'Descripción del recurso educativo sobre diversos temas de ciencias de la salud.',
                'type' => $resourceTypes[array_rand($resourceTypes)],
                'file_path' => 'resources/ejemplo' . $i . '.pdf',
                'file_name' => 'documento_' . $i . '.pdf',
                'file_type' => 'pdf',
                'file_size' => rand(100000, 5000000),
                'career' => ['Medicina', 'Enfermería', 'Odontología'][array_rand(['Medicina', 'Enfermería', 'Odontología'])],
                'subject' => $subjects[array_rand($subjects)],
                'semester' => rand(1, 10),
                'tags' => ['estudio', 'examen', 'repaso'],
                'downloads' => rand(0, 100),
                'is_approved' => true,
            ]);
        }

        // Crear grupos de estudio
        for ($i = 1; $i <= 15; $i++) {
            $group = StudyGroup::create([
                'user_id' => $users[array_rand($users)]->id,
                'name' => 'Grupo de estudio ' . $i,
                'description' => 'Grupo para estudiar y compartir conocimientos.',
                'subject' => $subjects[array_rand($subjects)],
                'career' => ['Medicina', 'Enfermería', 'Odontología'][array_rand(['Medicina', 'Enfermería', 'Odontología'])],
                'max_members' => rand(5, 15),
                'is_public' => true,
            ]);
            
            // Agregar algunos miembros
            $members = array_rand(array_flip(range(0, count($users) - 1)), rand(2, 5));
            foreach ((array)$members as $memberIndex) {
                $group->members()->attach($users[$memberIndex]->id, ['role' => 'member']);
            }
        }

        // Crear eventos
        $eventTypes = ['examen', 'entrega', 'seminario', 'conferencia'];
        
        for ($i = 1; $i <= 20; $i++) {
            Event::create([
                'user_id' => $users[array_rand($users)]->id,
                'title' => 'Evento ' . $i,
                'description' => 'Descripción del evento académico.',
                'type' => $eventTypes[array_rand($eventTypes)],
                'location' => 'Aula ' . rand(100, 500),
                'start_date' => now()->addDays(rand(-10, 30)),
                'end_date' => now()->addDays(rand(31, 60)),
                'color' => ['#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6'][array_rand(['#ef4444', '#f59e0b', '#3b82f6', '#8b5cf6'])],
                'career' => ['Medicina', 'Enfermería', 'Odontología'][array_rand(['Medicina', 'Enfermería', 'Odontología'])],
                'subject' => $subjects[array_rand($subjects)],
                'is_public' => true,
            ]);
        }

        // Crear noticias
        $categories = ['general', 'academico', 'evento', 'importante'];
        
        for ($i = 1; $i <= 15; $i++) {
            News::create([
                'user_id' => $admin->id,
                'title' => 'Noticia ' . $i . ': Información importante para estudiantes',
                'excerpt' => 'Resumen de la noticia que proporciona información relevante.',
                'content' => 'Contenido completo de la noticia con toda la información detallada sobre el tema en cuestión. Esta noticia es de gran importancia para la comunidad estudiantil.',
                'category' => $categories[array_rand($categories)],
                'is_featured' => $i <= 3,
                'is_published' => true,
                'published_at' => now()->subDays(rand(0, 30)),
                'views' => rand(10, 500),
            ]);
        }

        $this->command->info('Portal educativo poblado con datos de prueba exitosamente!');
    }
}
