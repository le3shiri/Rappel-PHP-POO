<?php
// Hna kan-activat strict typing bash n-garantiw array input w array output, w ma n-khaliwsh PHP y-dir automatic type conversions
// [!] T9RA HNA: Strict typing (declare(strict_types=1)) kat-men3 errors dyal type conversion, kat-jbdo array input w array output
declare(strict_types=1);

// Hadi hiya l-function buildArticle li kat-akhod array ($row) w kat-returni array m-nassaqa mzn
function buildArticle(array $row): array {
    // Step 1: Kan-diru default values b-??=
    // [!] T9RA HNA: ??= kat-'ati value default ila l-key ma-kaynsh wlla null, w ma kat-sali-sh l-values li kaynin
    // Ila l-key title ma-kaynsh wlla null, kan-'atiwha l-value 'Sans titre'
    $row['title']     ??= 'Sans titre';
    
    // Ila l-key author ma-kaynsh wlla null, kan-'atiwha l-value 'N/A'
    $row['author']    ??= 'N/A';
    
    // Ila l-key published ma-kaynsh wlla null, kan-'atiwha l-value true
    $row['published'] ??= true;

    // Step 2: Format title
    // [!] T9RA HNA: trim() kat-shil whitespace mn string, w (string) kat-hawwel l-value l string
    // Kan-hawlo l-value dial title l string b (string) w kan-shilou l-whitespace b trim()
    $title = trim((string)$row['title']);
    
    // Step 3: Format excerpt
    // [!] T9RA HNA: isset() kat-shuf wash l-key kayn, w kat-help t-eviti errors undefined key
    // Kan-choufou wash l-key excerpt kayn b isset() bash ma-yji-nash error undefined key
    // Ila kan kayn, kan-hawloha l string w kan-shilou l-whitespace
    // Ila ma-kan-sh kayn, kan-'atiw null
    $excerpt = isset($row['excerpt']) ? trim((string)$row['excerpt']) : null;
    
    // [!] T9RA HNA: Hna kat-tbadl string khawi ('') l null b7al l-metatlbat
    // Ila l-value dial excerpt khawya (''), kan-hawloha l null
    $excerpt = ($excerpt === '') ? null : $excerpt;
    
    // Step 4: Format views
    // [!] T9RA HNA: ?? kat-'ati default value (0 hna) ila l-key ma-kaynsh wlla null
    // Kan-hawlo l-value dial views l int b (int), w ila l-key ma-kaynsh wlla null kan-'atiw 0
    $views = (int)($row['views'] ?? 0);
    
    // [!] T9RA HNA: max(0, $views) kat-garanti l-value int >= 0
    // Kan-choufou wash l-value ma-salbya-sh b max(), y3ni ila kanat -5, kat-sir 0
    $views = max(0, $views);
    
    // Step 5: Format published
    // [!] T9RA HNA: (bool) kat-hawwel l-value l bool (true wlla false)
    // Kan-hawlo l-value dial published l bool b (bool)
    $published = (bool)$row['published'];
    
    // Step 6: Format author
    // Kan-hawlo l-value dial author l string b (string) w kan-shilou l-whitespace b trim()
    $author = trim((string)$row['author']);
    
    // Step 7: Return l-array l-mnassaqa
    // [!] T9RA HNA: L-return array kat-kun bl-structure mtlouba: title (string), excerpt (string|null), views (int>=0), published (bool), author (string)
    // Kan-rj3ou array bl-structure l-metlouba m3a l-values li nsaqna
    return [
        'title'     => $title,     // string clean
        'excerpt'   => $excerpt,   // string wlla null
        'views'     => $views,     // int >= 0
        'published' => $published, // bool
        'author'    => $author     // string clean
    ];
}

// ------------------- Exercise: Test Cases -------------------
// Hna kan-'arfo test cases bash n-testiw l-function m3a scenarios mkhltfa
$testCases = [
    // Test Case 1: Data kamla m3a values valid
    [
        'title'     => '  Test Article  ', // string m3a spaces zaydin
        'excerpt'   => '  Summary  ',      // string m3a spaces
        'views'     => '500',             // number k string
        'published' => false,             // bool
        'author'    => '  John  '         // string m3a spaces
    ],
    // Test Case 2: Keys missing w values null
    [
        'views'     => null,              // views null
        'excerpt'   => ''                 // excerpt khawi
    ],
    // Test Case 3: Values zero w strings khawya
    [
        'title'     => '',                // string khawi
        'views'     => '0',               // zero k string
        'author'    => '   '              // string fih spaces b7al
    ],
    // Test Case 4: Extra case m3a values ma-valid-sh
    [
        'views'     => '-10',             // number salbi
        'excerpt'   => '   ',             // string fih spaces b7al
        'published' => 'yes'              // value ma-bool-sh
    ]
];

// Kan-loopiw 3la kol test case w kan-applyiw l-function w n-printiw l-result
foreach ($testCases as $index => $case) {
    echo "Test Case " . ($index + 1) . ":\n"; // Kan-printiw number dial l-case
    print_r(buildArticle($case));             // Kan-printiw l-output dial l-function
    echo "\n";                                
}
