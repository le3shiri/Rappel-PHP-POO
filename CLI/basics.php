#!/usr/bin/env php
<?php
declare(strict_types=1);

/**
 * CLI Basics b-Darija Maghribia
 * Had s-sfiha tashmel ta3rifat w mthal dial l-kurs 3.0.7 (Scripts CLI, entrée/sortie)
 * Objectif: Tfhm kifash tsaweb scripts CLI b-PHP, tqra l-mdkhlat, tktb l-mkhrjat, w tdir exit codes.
 */

// 1. Ta3rifat (Definitions) b-Darija
// CLI: Interface dial s-satr d-l-awamer (Command Line), tshghl script b-`php script.php ...`.
// $argv: Array (mssfufa) dial l-awamer lli kjiw m3a s-script (mthln: `php script.php Amina` -> $argv[1] = 'Amina').
// $argc: 3adad l-awamer (yshaml smiya d-s-script).
// getopt: Adat tqra l-khiyarat (options) qssira (mthln: -v) aw twila (mthln: --input=file.json).
// STDIN: L-mdkhl (input) mn keyboard aw file (mthln: `cat file | php script.php`).
// STDOUT: L-mkhrj (output) l-3adi dial n-natija (mthln: echo aw fwrite(STDOUT, ...)).
// STDERR: L-mkhrj dial l-kht2a (errors) (mthln: fwrite(STDERR, "Kht2a: file ma kaynsh\n")).
// Exit Codes: 0 = njah, >0 = kht2a (mthln: 1 = kht2a 3am, 2 = kht2a f-l-usage).

// 2. Mthal 1: Qra l-awamer b-$argv
// Mthal: php cli_basics.php Amina -> tshuf "Salam Amina"
echo "=> Mthal 1: Qra l-awamer b-\$argv\n";
echo "Salam " . ($argv[1] ?? 'Wld n-nas') . "\n";
echo "3adad l-awamer (argc): $argc\n";


// 3. Mthal 2: Qra l-khiyarat b-getopt
// Mthal: php cli_basics.php -v --input=data.json --limit=3
echo "\n=> Mthal 2: Qra l-khiyarat b-getopt\n";
$short = 'v'; // -v (boolean: kayn = true)
$long = ['input:', 'limit::', 'help', 'dry-run'];
$opts = getopt($short, $long);

$verbose = array_key_exists('v', $opts);
$input = $opts['input'] ?? null;
$limit = isset($opts['limit']) ? (int)$opts['limit'] : null;
$help = array_key_exists('help', $opts);
$dryRun = array_key_exists('dry-run', $opts);

if ($help) {
    fwrite(STDOUT, "Usage: php cli_basics.php --input=PATH|- [--limit=N] [-v] [--dry-run] [--help]\n");
    exit(0);
}
if ($verbose) {
    fwrite(STDOUT, "[Verbose] L-khiyarat lli tjina: " . print_r($opts, true) . "\n");
}
if ($input) {
    fwrite(STDOUT, "Input: $input\n");
}
if ($limit !== null) {
    fwrite(STDOUT, "Limit: $limit\n");
}
if ($dryRun) {
    fwrite(STDOUT, "[Dry-run] Ma ghadi nshriw walo.\n");
}

// 4. Mthal 3: STDIN, STDOUT, STDERR
// Mthal: echo '{"id":1}' | php cli_basics.php --input=-
echo "\n=> Mthal 3: STDIN, STDOUT, STDERR\n";
const EXIT_OK = 0;
const EXIT_USAGE = 2;
const EXIT_DATA_ERROR = 3;

function readJsonFrom(string $input): array {
    $json = '';
    if ($input === '-') {
        $json = stream_get_contents(STDIN);
    } else {
        if (!is_file($input)) {
            fwrite(STDERR, "Kht2a: L-file $input ma kaynsh\n");
            exit(EXIT_DATA_ERROR);
        }
        $json = file_get_contents($input);
    }
    try {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($data)) {
            fwrite(STDERR, "Kht2a: Format JSON ghalt\n");
            exit(EXIT_DATA_ERROR);
        }
        return $data;
    } catch (Throwable $e) {
        fwrite(STDERR, "Kht2a JSON: " . $e->getMessage() . "\n");
        exit(EXIT_DATA_ERROR);
    }
}

if ($input === null) {
    fwrite(STDERR, "Kht2a: --input khas ikun mwjod (file aw '-')\n");
    exit(EXIT_USAGE);
}

$data = readJsonFrom($input);
fwrite(STDOUT, "Data lli tqriw: " . print_r($data, true) . "\n");

// 5. Mthal 4: Normalisation dial l-data
// Mthal: nakhud JSON w nnadmo l-data
echo "\n=> Mthal 4: Normalisation dial l-data\n";
function normalizeArticle(array $a): array {
    return [
        'id' => (int)($a['id'] ?? 0),
        'title' => trim((string)($a['title'] ?? 'Bla smiya')),
        'views' => (int)($a['views'] ?? 0),
        'published' => (bool)($a['published'] ?? true),
        'author' => (string)($a['author'] ?? 'N/A'),
    ];
}

$normalized = array_map('normalizeArticle', $data);
fwrite(STDOUT, "Data mn b3d normalisation: " . print_r($normalized, true) . "\n");

// 6. Mthal 5: CSV l-JSON (mthal mn l-exercice)
echo "\n=> Mthal 5: CSV l-JSON\n";
function csvToJson(string $input, bool $publishedOnly = false, ?int $limit = null): void {
    $fh = ($input === '-') ? STDIN : @fopen($input, 'r');
    if (!$fh) {
        fwrite(STDERR, "Kht2a: Ma nqdrush nfthu l-input\n");
        exit(EXIT_DATA_ERROR);
    }

    $rows = [];
    $header = fgetcsv($fh);
    while (($line = fgetcsv($fh)) !== false) {
        $rows[] = array_combine($header, $line);
    }
    if ($fh !== STDIN) fclose($fh);

    $items = array_map(function(array $r): array {
        return [
            'title' => trim((string)($r['title'] ?? 'Bla smiya')),
            'excerpt' => ($r['excerpt'] ?? null) !== '' ? (string)$r['excerpt'] : null,
            'views' => (int)($r['views'] ?? 0),
            'published' => in_array(strtolower((string)($r['published'] ?? 'true')), ['1', 'true', 'yes', 'y', 'on'], true),
            'author' => (string)($r['author'] ?? 'N/A'),
        ];
    }, $rows);

    if ($publishedOnly) {
        $items = array_values(array_filter($items, fn($a) => $a['published']));
    }
    if ($limit !== null) {
        $items = array_slice($items, 0, max(1, $limit));
    }

    fwrite(STDOUT, json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n");
}

if (isset($opts['csv'])) {
    $publishedOnly = array_key_exists('published-only', $opts);
    csvToJson($input, $publishedOnly, $limit);
    exit(EXIT_OK);
}

// 7. Final: Rapport simple
echo "\n=> Rapport Final\n";
$published = array_values(array_filter($normalized, fn($a) => $a['published']));
usort($published, fn($a, $b) => $b['views'] <=> $a['views']);
if ($limit !== null) {
    $published = array_slice($published, 0, $limit);
}

$total = count($normalized);
$countP = count($published);
$views = array_reduce($published, fn($acc, $a) => $acc + $a['views'], 0);

fwrite(STDOUT, "Articles mnshurin (top" . ($limit ? " $limit" : "") . "):\n");
foreach ($published as $a) {
    fwrite(STDOUT, "- {$a['title']} ({$a['views']} vues) — {$a['author']}\n");
}
fwrite(STDOUT, "Khasa: total=$total, mnshurin=$countP, vues_total=$views\n");

exit(EXIT_OK);
?>