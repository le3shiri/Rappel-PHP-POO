<?php
declare(strict_types=1);

class User {
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?string $bio = null,
        public int $articlesCount = 0,
    ) {}

    public function initials(): string {
        $parts = preg_split('/\s+/', trim($this->name));
        $letters = array_map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1)), $parts);
        return implode('', $letters);
    }

    public function toArray(): array {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'bio'           => $this->bio,
            'articlesCount' => $this->articlesCount,
            'initials'      => $this->initials(),
        ];
    }
}

class UserFactory {
    public static function fromArray(array $u): User {
        $id    = max(1, (int)($u['id'] ?? 0));
        $name  = trim((string)($u['name'] ?? 'Inconnu'));
        $email = trim((string)($u['email'] ?? ''));
        if ($email === '') {
            throw new InvalidArgumentException('email requis');
        }
        $bio   = isset($u['bio']) ? (string)$u['bio'] : null;
        $count = (int)($u['articlesCount'] ?? 0);

        return new User($id, $name, $email, $bio, $count);
    }
}
