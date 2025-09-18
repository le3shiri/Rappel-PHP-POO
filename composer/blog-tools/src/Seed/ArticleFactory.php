<?php
namespace App\Seed;

use App\Support\Str;

// Class ArticleFactory: T-generi articles l-seed JSON
final class ArticleFactory
{
    /** @var string[] */
    private array $authors = ['Amine', 'Sara', 'Youssef', 'Nadia'];
    /** @var string[] */
    private array $topics = ['PHP', 'Laravel', 'Mobile', 'UX', 'MySQL'];

    /**
     * T-generi array d-articles
     * @param int $count 3adad l-articles
     * @param string|null $topic Thème l-bias (ila kayn)
     * @return array<int, array<string, mixed>>
     */
    public function make(int $count, ?string $topic = null): array
    {
        $titles = [
            'Bonnes pratiques ' . ($topic ?? 'PHP'),
            'Découvrir ' . ($topic ?? 'Eloquent'),
            'API REST l-' . ($topic ?? 'PHP'),
            'Pagination w l-filtres',
            'Exceptions zwinin'
        ];

        $used = [];
        $rows = [];

        for ($i = 1; $i <= $count; $i++) {
            $title = $titles[($i - 1) % count($titles)] . " #$i";
            $slug = Str::slug($title);

            // T2akd mn l-unicité d-slug
            $base = $slug;
            $n = 2;
            while (isset($used[$slug])) {
                $slug = $base . '-' . $n++;
            }
            $used[$slug] = true;

            $content = "Contenu d-exemple l-« $title ». " .
                       "Had l-article kay-illustrer l-génération d-seed JSON f-CLI.";

            // T2akd mn 1 tag l-l-7d l-2sasi
            $tags = array_unique(array_filter([
                $this->topics[array_rand($this->topics)],
                rand(0, 1) ? $this->topics[array_rand($this->topics)] : null,
                rand(0, 1) ? $this->topics[array_rand($this->topics)] : null
            ]));

            $rows[] = [
                'title' => $title,
                'slug' => $slug,
                'excerpt' => Str::excerpt($content, 180),
                'content' => $content,
                'author' => $this->authors[array_rand($this->authors)],
                'published_at' => date('c', time() - rand(0, 60 * 60 * 24 * 30)),
                'tags' => $tags
            ];
        }

        return $rows;
    }
}
?>