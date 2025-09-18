<?php
declare(strict_types=1);

class Article {
    public int $id;
    public string $title;
    public ?string $excerpt = null; // nullable avec valeur par défaut
    public int $views = 0;

    public function __construct(int $id, string $title) {
        // ⚠️ Propriétés typées : doivent être initialisées avant usage
        $this->id = $id;
        $this->title = $title;
    }

    public function incrementViews(int $delta = 1): void {
        $this->views += max(0, $delta);
    }
}

$a = new Article(1, 'Intro Laravel');
$a->incrementViews();
