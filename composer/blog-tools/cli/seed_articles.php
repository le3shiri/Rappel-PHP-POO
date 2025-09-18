#!/usr/bin/env php
<?php
require __DIR__ . '/../vendor/autoload.php';

// /***********************************************
//  * PARTIE THÉORIQUE - TA3RIFAT W MOST IMPORTANT THINGS
//  ***********************************************/

// /* 1. TA3RIFAT ASASIYA (GLOSSAIRE) */
// - Composer: Adat t-tadbir dial l-dependencies f-PHP w t-saweb l-autoload d-l-classes.
// - Autoload: Tchajr l-classes otomatik bla ma t-dir require manual.
// - PSR-4: Standard yrbtt namespace (mthln App\) m3a dossier (mthln src/) bash l-autoload ykhddm.
// - Scripts Composer: Awamer qssarin tshghlhom b-`composer run <script>` (mthln php aw binaires).

// /* 2. MOST IMPORTANT THINGS TO MASTER */
// - Initialisation: Saweb projet b-`composer init` aw b-`composer.json` direct.
// - Autoload PSR-4: Nddm `App\` -> `src/` f-composer.json, w b3d `composer dump-autoload` bash tsaweb vendor/autoload.php.
// - Scripts: Saweb awamer zina zay `start`, `seed`, `clean` f-`scripts` section, tshghlhom b-`composer run`.
// - Robustesse: T2akd mn l-files kaynin w JSON s7i7, w t3aml m3a l-errors b-messages wadi7a.
// - Fil Rouge: Had script kay-saweb articles.seed.json lli ghadi ytkhdm f-Laravel (seeders w API).

// /* 3. FUNCTIONS ASASIYA (f-had l-projet) */
// - App\Support\Str::slug(): T7awl string l-slug (mthln "Salam PHP" -> "salam-php").
// - App\Support\Str::excerpt(): Tqssr n-nss w tshil HTML tags.
// - App\Seed\ArticleFactory::make($count): T-generi array d-articles b-data dynamique.

// /***********************************************
//  * EXERCICE - SCRIPT SEED_ARTICLES.PHP
//  ***********************************************/
// Objectif: Saweb script CLI kay-generi JSON seed l-articles w ykhzno f-file.
// Exigences:
// 1. Script clean: Yms7 l-file d-seed (f-composer.json).
// 2. ArticleFactory: T-generi 1 tag l-l-7d l-2sasi l-kul article.
// 3. Khiyar --topic: Y-biasi l-titres l-thème m7dd (mthln Laravel).

use App\Seed\ArticleFactory;

// Qra l-khiyarat mn CLI
$options = getopt('', ['count::', 'out::', 'topic::']);
$count = isset($options['count']) ? max(1, (int)$options['count']) : 10;
$out = $options['out'] ?? 'storage/articles.seed.json';
$topic = $options['topic'] ?? null;

// Saweb l-dossier ila ma kaynsh
$dir = dirname($out);
if (!is_dir($dir)) {
    if (!mkdir($dir, 0777, true) && !is_dir($dir)) {
        fwrite(STDERR, "Kht2a: Ma nqdrush nsaweb l-dossier $dir\n");
        exit(1);
    }
}

// Generi articles
$factory = new ArticleFactory();
$articles = $factory->make($count, $topic);

// Ktb JSON
$json = json_encode($articles, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
if ($json === false) {
    fwrite(STDERR, "Kht2a JSON: " . json_last_error_msg() . "\n");
    exit(1);
}
file_put_contents($out, $json);

echo "✅ Seed tsaweb f-$out (" . count($articles) . " articles)\n";
exit(0);
?>