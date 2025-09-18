<?php
// <!-- “Class” bhal chi plan dyal jouet. Hadi hia l’blueprint li tqul lik kifash tbnaw chi robot o chnu smiyto, chnu l’ma3lumat li 3ndo, o chnu li yqdr ydir. Msln, smiyya had l’jouet “Article” (bhal chi article f’blog). Had l’article 3ndo:

// ID: nmero dyalo, bhal “Robot #1”.
// Title: smiyto, bhal “Maghreb Adventure”.
// Excerpt: chi ktiba sghira 3la l’article (ila ma kanetch, mashi moshkil).
// Views: qddash mn marra nass chafu l’article. -->

class Article {
    public int $id; // Nmero dyal l’article
    public string $title; // Smia dyalo
    public ?string $excerpt = null; // Chi ktiba sghira, ila ma kanetch mashi moshkil
    public int $views = 0; // Qddash mn marra tshaf
}

// “Constructeur” bhal chi ktab d’instructions li tqul lik kifash tkhalli l’jouet.
//  Wqt tqul “bnili chi article jdid”, l’constructeur huwa li yqul, “Okay, ghadi nkhaddm hada l’ID o hadi smia.
class Article {
    public int $id;
    public string $title;

    public function __construct(int $id, string $title) {
        $this->id = $id; // Hada l’ID dyal l’jouet
        $this->title = $title; // Hadi smiyto
    }
}
// ’PHP 8.0 o juj, kayn chi shortcut smiyto “promotion de propriétés”. Hada bhal la tqul, “Makaynsh l’fayda nktbo l’ma3lumat o l’instructions b’joj.
//  Yallah, nkhaddmo kulchi f’wahed!” Makanesh l’fayda nktbo $id o $title brra o b3d njiw nsta3mluhum f’l’constructeur.

class Article {
    public function __construct(
        public int $id, // Nmero o type f’wahed!
        public string $title,
        public ?string $excerpt = null, // Yqdr ykun khawi
        public int $views = 0 // Ybda b’zero
    ) {}
}
// Chnu huwa Nullable? (Chi hwayj mashi dima lzmhum)
// F’chi wqt, l’jouet mashi dima l’fayda 3ndo kulchi. Msln, l’excerpt (ktiba sghira) yqdr ykun khawi (wlla “null”). F’PHP, nsta3mlo ?string bash nqulo, “Hadi tqdr tkun chi ktiba, wlla tqdr tkun khawya.” Bhal la tqul chi jouet yqdr ykun 3ndo chi cape, wlla mashi dima lzmha.

// Kifash ndiro l’jouet ydir chi tricks? (Methods)
// L’jouet dyalna yqdr ydir chi tricks zwinin! Hadu smiyyathom “methods”, bhal chi boutons tdir 3lihum o l’jouet ydir chi haja. Msln, l’Article yqdr ydir chi “slug” (smia sghira o mbssta bash tsta3mlha f’website):
// public function slug(): string {
//     $s = strtolower($this->title); // Nkhaliw smia kulha sghira
//     $s = preg_replace('/[^a-z0-9]+/i', '-', $s); // Nbdlo l’ktiba l’mochkla b’-’
//     return trim($s, '-'); // Nnaddfo l’ktiba
// }
