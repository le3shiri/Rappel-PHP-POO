#!/usr/bin/env php
<?php
declare(strict_types=1);

// /***********************************************
//  * PARTIE THÉORIQUE - TA3RIFAT W MOST IMPORTANT THINGS
//  ***********************************************/

// /* 1. TA3RIFAT ASASIYA (GLOSSAIRE) */
// - UTF-8: Encoding dial n-nss (texte) l-mnst7b, khas tkun bla BOM (Byte Order Mark) bash t-t2akd mn l-compatibilité.
// - JSON_THROW_ON_ERROR: Khiyar f-json_decode aw json_encode yrmi exception (JsonException) ila kan kht2a f-l-JSON.
// - JSON_ENCODE OPTIONS:
//   - JSON_PRETTY_PRINT: Ykhli l-JSON mratb w sah7 l-l-qra2a (formatted).
//   - JSON_UNESCAPED_UNICODE: Ykhli l-caractères Unicode (mthln arabia) bla escape.
//   - JSON_UNESCAPED_SLASHES: Ma ydirsh escape l-/ (slashes) f-l-URLs.
//   - JSON_INVALID_UTF8_SUBSTITUTE: Ybdl l-caractères UTF-8 l-ghaltin b-substitutes.
// - ÉCRITURE SÛRE:
//   - mkdir(..., recursive: true): Ysaweb l-dossiers l-b3idin ila ma kayninsh.
//   - file_put_contents(..., LOCK_EX): Y7bs l-file 7ta ykml l-ktaba bash ma ykunsh t-t3til.
// - I/O: Input/Output, y3ni l-qra2a (lecture) w l-ktaba (écriture) d-l-fichiers.

// /* 2. MOST IMPORTANT THINGS TO MASTER */
// - Centralisation: Tst3ml functions zina zay loadJson() w saveJson() bash t-nadmo l-code w t-rj3o reusable.
// - Robustesse: T2akd mn l-errors b-try-catch w JSON_THROW_ON_ERROR, w ktb messages wadi7a f-STDERR.
// - Validation: Qbl ma tkhzn data, walid title w slug (ma ykunush khawyin) w rm DomainException ila ghalt.
// - Atomic Write: Ktb f-file temporaire (.tmp) w b3d rename bash t-t2akd mn l-ktaba bla t-t3til.
// - CLI Integration: Qbl arguments mn $argv (mthln chemin w 3adad articles) bash t-generi data dynamique.
// - Merge Data: Qra file extra (articles.extra.json) w jm3 data bla doublons d-slug.

// /* 3. FUNCTIONS ASASIYA */
// - loadJson($path): Tqra JSON mn file, t2akd mn l-file kayn w l-JSON s7i7, w trj3 array.
// - saveJson($path, $data): Tktb JSON f-file b-shkl atomic, tsaweb l-dossier ila ma kaynsh, w t2akd mn l-encoding.
// - slugify($value): T7awl string l-slug (mthln: "Salam PHP" -> "salam-php").
// - validateArticle($article): T2akd mn title w slug ma khawyinsh.
// - generateArticles($count): T-generi articles dynamique b-3adad m7dd.
// - mergeArticles($main, $extra): Tjm3 articles mn mra2i w t2akd bla doublons d-slug.

// /***********************************************
//  * EXERCICE - CHALLENGE N1+
//  ***********************************************/
// Objectif: Saweb script CLI kayqra w yktb JSON b-shkl robuste, m3a:
// 1. Atomic write: Ktb f-file tmp w b3d rename.
// 2. Validation: T2akd mn title w slug ma khawyinsh, rm DomainException ila ghalt.
// 3. CLI: Qbl chemin f-$argv[1] w 3adad articles f-$argv[2].
// 4. Import/merge: Qra articles.extra.json w jm3 bla doublons d-slug.

// Thawabit bash n-nadmo l-exit codes
const EXIT_OK = 0; // Njah
const EXIT_USAGE = 2; // Kht2a f-l-usage (mthln: arguments nqsin)
const EXIT_DATA_ERROR = 3; // Kht2a f-l-data (mthln: file aw JSON ghalt)

// Fonction usage(): Tktb l-mos3ada f-STDOUT
function usage(): void {
    $msg = <<<TXT
JSON IO — Khiyarat:
  php json_io.php [chemin] [3adad_articles]
  chemin          Chemin d-l-file JSON (default: storage/seeds/articles.seed.json)
  3adad_articles  3adad l-articles lli n-generiw (default: 2)
  --help          Yktb had l-mos3ada

Mthal:
  php json_io.php storage/seeds/articles.seed.json 3
TXT;
    fwrite(STDOUT, $msg . PHP_EOL);
}

// Fonction loadJson(): Tqra JSON mn file b-shkl robuste
function loadJson(string $path): array {
    // T2akd mn l-file kayn
    $raw = @file_get_contents($path);
    if ($raw === false) {
        throw new RuntimeException("File ma kaynsh aw ma nqdrush nqraw: $path");
    }
    // Qra JSON w t2akd mn l-format
    try {
        $data = json_decode($raw, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            throw new RuntimeException("JSON ghalt f-$path: khas ykun array");
        }
        return $data;
    } catch (JsonException $e) {
        throw new RuntimeException("JSON invalide f-$path", 0, $e);
    }
}

// Fonction saveJson(): Tktb JSON b-shkl atomic
function saveJson(string $path, array $data): void {
    // Saweb l-dossier ila ma kaynsh
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Encode JSON m3a l-khiyarat l-mnst7ba
    try {
        $json = json_encode(
            $data,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_INVALID_UTF8_SUBSTITUTE
        );
        if ($json === false) {
            throw new RuntimeException("Kht2a f-l-encodage JSON");
        }
    } catch (Throwable $e) {
        throw new RuntimeException("Ma nqdrush nsaweb JSON", 0, $e);
    }

    // Atomic write: Ktb f-file tmp w b3d rename
    $tmpPath = $path . '.tmp';
    $ok = @file_put_contents($tmpPath, $json . PHP_EOL, LOCK_EX);
    if ($ok === false) {
        throw new RuntimeException("Ma nqdrush nktbu f-$tmpPath");
    }

    if (!rename($tmpPath, $path)) {
        throw new RuntimeException("Ma nqdrush nsmmiw $tmpPath l-$path");
    }
}

// Fonction slugify(): T7awl string l-slug
function slugify(string $value): string {
    $s = strtolower($value);
    $s = preg_replace('/[^a-z0-9]+/i', '-', $s) ?? '';
    return trim($s, '-');
}

// Fonction validateArticle(): Twalid article
function validateArticle(array $article): void {
    if (empty($article['title']) || !is_string($article['title'])) {
        throw new DomainException("Title khas ykun string w ma ykunsh khawi");
    }
    if (empty($article['slug']) || !is_string($article['slug'])) {
        throw new DomainException("Slug khas ykun string w ma ykunsh khawi");
    }
}

// Fonction generateArticles(): T-generi articles dynamique
function generateArticles(int $count): array {
    $articles = [];
    for ($i = 1; $i <= $count; $i++) {
        $title = "Article $i: Intro PHP";
        $articles[] = [
            'id' => $i,
            'title' => $title,
            'slug' => slugify($title),
            'excerpt' => "Description d-article $i sur PHP.",
            'tags' => ['php', "article$i"],
        ];
    }
    return $articles;
}

// Fonction mergeArticles(): Tjm3 articles bla doublons d-slug
function mergeArticles(array $main, array $extra): array {
    $slugs = array_column($main, 'slug');
    $merged = $main;

    foreach ($extra as $article) {
        if (!in_array($article['slug'] ?? '', $slugs)) {
            $merged[] = $article;
            $slugs[] = $article['slug'] ?? '';
        }
    }
    return $merged;
}

// Main program
$opts = getopt('', ['help']);
if (array_key_exists('help', $opts)) {
    usage();
    exit(EXIT_OK);
}

// Qra l-arguments mn CLI
$path = $argv[1] ?? __DIR__ . '/storage/seeds/articles.seed.json';
$count = isset($argv[2]) ? max(1, (int)$argv[2]) : 2;

// Generi articles
$articles = generateArticles($count);

// T2akd mn kul article
foreach ($articles as $article) {
    try {
        validateArticle($article);
    } catch (DomainException $e) {
        fwrite(STDERR, "[ERR] Validation kht2a: " . $e->getMessage() . PHP_EOL);
        exit(EXIT_DATA_ERROR);
    }
}

// Qra w merge mn articles.extra.json ila kayn
$extraPath = __DIR__ . '/storage/seeds/articles.extra.json';
$extraArticles = [];
if (file_exists($extraPath)) {
    try {
        $extraArticles = loadJson($extraPath);
        $articles = mergeArticles($articles, $extraArticles);
    } catch (Throwable $e) {
        fwrite(STDERR, "[ERR] Kht2a f-qra2a articles.extra.json: " . $e->getMessage() . PHP_EOL);
        exit(EXIT_DATA_ERROR);
    }
}

// Ktb l-seed
try {
    saveJson($path, $articles);
    fwrite(STDOUT, "[OK] Seed ktb f-$path\n");

    // Qra w t2akd
    $loaded = loadJson($path);
    fwrite(STDOUT, "[OK] Tqriw: " . count($loaded) . " article(s).\n");
    fwrite(STDOUT, "L-ewl title: " . ($loaded[0]['title'] ?? 'N/A') . PHP_EOL);

    exit(EXIT_OK);
} catch (Throwable $e) {
    fwrite(STDERR, "[ERR] " . $e->getMessage() . PHP_EOL);
    if ($e->getPrevious()) {
        fwrite(STDERR, "Sabab: " . get_class($e->getPrevious()) . " — " . $e->getPrevious()->getMessage() . PHP_EOL);
    }
    exit(EXIT_DATA_ERROR);
}
?>