<?php
declare(strict_types=1);

// Exception personnalisée bash n'handlo erreurs I/O
class SeedException extends RuntimeException {}

/** Valider article (title + slug m'frotin y'kono string w machi khawiin) */
function validateArticle(array $a): void {
    if (!isset($a['title']) || !is_string($a['title']) || $a['title'] === '') {
        throw new DomainException("Article machi mzyan: 'title' m'frodtch t'koun khawya.");
    }
    if (!isset($a['slug']) || !is_string($a['slug']) || $a['slug'] === '') {
        throw new DomainException("Article machi mzyan: 'slug' m'frodtch t'koun khawya.");
    }
}

/** Load w decode JSON mn fichier b sécurité */
function loadJson(string $path): array {
    $raw = @file_get_contents($path);
    if ($raw === false) {
        // Stakhdem custom exception
        throw new SeedException("Fichier ma kaynx wla ma t'qrash: $path");
    }

    try {
        /** @var array $data */
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $je) {
        // Log l'erreur w rethrow
        error_log("JSON machi mzyan f $path: " . $je->getMessage(), 3, 'exceptions/logs/seed.log');
        throw new SeedException("JSON machi mzyan f $path", previous: $je);
    }

    if (!is_array($data)) {
        throw new UnexpectedValueException("JSON khass y'koun array f l'base.");
    }
    return $data;
}

/** Point d'entrée CLI */
function main(array $argv): int {
    $path = $argv[1] ?? 'exceptions/seeds/articles.input.json';

    try {
        $articles = loadJson($path); // Y'mken y'throw SeedException
        foreach ($articles as $i => $a) {
            validateArticle($a); // Y'mken y'throw DomainException
        }

        echo "[OK] $path: " . count($articles) . " article(s) valides." . PHP_EOL;
        return 0;
    } catch (Throwable $e) {
        // Log l'erreur
        error_log($e->getMessage(), 3, 'exceptions/logs/seed.log');
        // Afficher erreur f STDERR
        fwrite(STDERR, "[ERREUR] " . $e->getMessage() . PHP_EOL);
        if ($e->getPrevious()) {
            fwrite(STDERR, "Cause: " . get_class($e->getPrevious()) . " — " . $e->getPrevious()->getMessage() . PHP_EOL);
        }
        return 1;
    }
}

// Catch tout f top-level
try {
    exit(main($argv));
} catch (Throwable $e) {
    // Filet d'sécurité
    error_log($e->getMessage(), 3, 'exceptions/logs/seed.log');
    fwrite(STDERR, "[ERREUR] " . $e->getMessage() . PHP_EOL);
    if ($e->getPrevious()) {
        fwrite(STDERR, "Cause: " . get_class($e->getPrevious()) . " — " . $e->getPrevious()->getMessage() . PHP_EOL);
    }
    exit(1);
}
?>