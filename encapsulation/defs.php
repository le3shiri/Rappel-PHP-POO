<?php
declare(strict_types=1); // nshro strict mode bash ntaakdo mn anwaa l-bayanat s7i7a

// **Definition d self::**: self:: katshyr l l-klas lli fih l-method aw l-khasiya mktoba. F had l-mthal, self:: katshyr l Counter, w kays3d bash nwslo l $count li hiya static. Ma katbdlsh b wasf l-klas lli kayst3ml l-method.
// **Mushkil d static mutable state**: l-khasiya $count hiya static w mutable (tqdr tbdl), w hada anti-pattern 7it kaysbb 3sar f l-unit tests w effets de bord. Lo bghiti tbdli $count f shi kayan, kl l-kayanat ghadi yshufu t-tbdil, w hada yqdr ysbab bugs s3b tshrihom.
// **Solution**: badl static mutable state, nst3mlo services injectes (dependency injection) bash ntahkmo f l-7ala (state) b shkl anf w aslm, w nqllo mn l-effets de bord.


// self:: kathd l-klas l-origin (zay Base f had l-mthal), 7ta lo st3mlti l-method mn klas warith. Hadi statik w matbdlsh.
// static:: katakhod l-klas lli kayst3ml l-method (zay Child lo st3mlna mnnu). Hadi dinamik w katnst3ml LSB bash tkon mruna.


class Counter {
    // static w private int, katkhzen 3dd l-kayanat li tnshew, msharka bin kl l-kayanat
    private static int $count = 0; // katbda b 0

    // constructor kayshtghl otomatik lma nnshew kayan jdid
    public function __construct() {
        self::$count++; // kanzido l-qima d $count b wa7d b self:: 7it $count static
    }

    // static w public method katrd l-qima l-7aliya d $count
    public static function count(): int {
        return self::$count; // katrd 3dd l-kayanat li tnshew
    }
}

// nshro kayan jdid mn Counter, constructor ghadi yzid $count b wa7d
new Counter();
// nshro kayan tani, constructor ghadi yzid $count b wa7d tani
new Counter();
// nshriw l-qima d $count b method count, ghadi tji 2 7it nshrna kayanin
echo Counter::count(); 

////////////////////////////////////////////////---------------------- 2-----------/////////////////////////////////////////////////////////////////////////////////////


// declare(strict_types=1); // ndiro strict mode bash ntaakdo mn anwaa l-bayanat s7i7a

// **Definition d self::**: self:: kat3od l l-klas lli fih l-method aw l-khasiya mktoba. Katkhdm bzzaf f static methods aw properties, w matbdlsh b wasf l-klas lli kayst3ml l-method. Y3ni dima kat3od l Base lo knt f Base.
// **Definition d static::**: static:: katnst3ml Late Static Bindings (LSB), y3ni kat3od l l-klas lli kayst3ml l-method b sifa (msh l-klas lli fih l-method mktoba). Lo st3mltiha mn klas warith (zay Child), katshyr l Child.
// **Comparaison**: self:: kathd l-klas lli mktoba fih l-method (Base f had l-mthal), w static:: katakhod l-klas lli kayst3ml l-method (zay Child lo st3mlna mnnu). static:: katkhli l-code aktr mruna f l-waratha 7it katkhdm m3a l-klas l-mst3ml b sifa.

class Base {
    // static w public method katrd string "Base"
    public static function who(): string {
        return 'Base'; // katqol hada l-klas Base
    }
    
    // static method katnst3ml static:: bash tnshe kayan mn l-klas lli kayst3ml l-method (Late Static Bindings)
    public static function make(): static {
        return new static(); // new static katnshe kayan mn l-klas lli st3ml l-method (Child lo mn Child)
    }
    
    // public method katnst3ml static::who() bash tjib l-who d l-klas lli kayst3ml l-method
    public function type(): string {
        return static::who(); // katrd l-who d l-klas l-mst3ml (zay Child lo st3mlna mn kayan Child)
    }
}

// klas Child kawartha mn Base, w kat3awd t3rif l-method who bash trd "Child"
class Child extends Base {
    //     // static w public method kat3awd t3rif who bash trd "Child"
    public static function who(): string {
        return 'Child'; // katqol hada l-klas Child
    }
}

// nshro kayan mn Child w nst3mlo type(), static::who() ghadi tjib who d Child
echo (new Child())->type(); // katrd "Child" 7it static::who() katshyr l Child

// nst3mlo make() mn Child, static:: katnshe kayan mn Child 7it kayst3ml LSB
var_dump(Child::make() instanceof Child); // katrd true 7it l-kayan l-mnshaa huwa mn Child


////////////////////////////////////////////////---------------------- EXEMPLE -----------/////////////////////////////////////////////////////////////////////////////////////


// Satr 1: nshro strict mode bash ntaakdo mn anwaa l-bayanat s7i7a

// **Definition d self::**: self:: katshyr l l-klas lli fih l-method aw l-khasiya mktoba (Article f had l-mthal). Katkhdm m3a static properties aw methods w matbdlsh b wasf l-klas l-mst3ml.
// **Definition d static::**: static:: katnst3ml Late Static Bindings (LSB), katshyr l l-klas lli kayst3ml l-method (Article aw FeaturedArticle). Katkhli l-code mrn f l-waratha.
// **Comparaison**: self:: kat7dd l-klas l-origin (Article), static:: katshyr l-klas l-mst3ml (zay FeaturedArticle). static:: mziana f l-waratha.
// **Anti-pattern d static mutable state**: $count static w mutable, hada anti-pattern 7it kaysbb 3sar f unit tests w effets de bord. L-7ll: nst3mlo services injectes.

class Article {
    // Satr 2: readonly int $id, katkhzen l-id dial l-article, ma tqdrsh tbdlih ba3d l-constructor
    public readonly int $id; // l-hedef: n7ddo id l-article w n7mih mn t-tbdil ba3d l-initialisation

    // Satr 3: private string $title, katkhzen l-3unwan dial l-article
    private string $title; // l-hedef: nkhbbiw l-3unwan w n7mih mn l-wsol mn barra l-klas (encapsulation)

    // Satr 4: private string $slug, katkhzen l-slug (URL-friendly version d l-3unwan)
    private string $slug; // l-hedef: nkhbbiw l-slug w n7mih mn t-tbdil l-mbshr (encapsulation)

    // Satr 5: private array $tags, katkhzen lista d l-tags dial l-article
    private array $tags = []; // l-hedef: nkhbbiw l-tags w n7mihom mn l-wsol l-mbshr, nkhliwha khawya f l-bda

    // Satr 6: static int $count, katkhzen 3dd l-articles li tnshew
    private static int $count = 0; // l-hedef: nkhli 3ddad mshrk bin kl l-articles, w n7mih mn l-wsol mn barra

    // Satr 7: constructor kayshtghl lma nnshew article jdid
    public function __construct(int $id, string $title, array $tags = []) { // l-hedef: n-initializw l-article b id, title, w tags
        // Satr 8: nt2kdo mn l-id wash akbr mn 0
        if ($id <= 0) throw new InvalidArgumentException("id > 0 requis."); // l-hedef: n7miw l-id mn l-qiyam s-salbia
        // Satr 9: n3tiw l-id l l-khasiya readonly
        $this->id = $id; // l-hedef: n-initializw l-id l-immuable
        // Satr 10: nst3mlo setTitle bash nbdlo l-3unwan m3a validation
        $this->setTitle($title); // l-hedef: n-initializw l-title w l-slug b shkl amn
        // Satr 11: n3tiw l-tags l l-khasiya tags
        $this->tags = $tags; // l-hedef: n-initializw l-tags lo kanu mwjodin
        // Satr 12: nzido l-3ddad d l-articles b wa7d
        self::$count++; // l-hedef: n7sbo 3dd l-articles li tnshew b static count
    }

    // Satr 13: static method (usine) katnst3ml LSB bash tnshe article mn title
    public static function fromTitle(int $id, string $title): static { // l-hedef: nsahlo nshaa l-articles b shkl mrn
        // Satr 14: nshro article jdid b id w title
        return new static($id, $title); // l-hedef: nrj3o kayan mn l-klas l-mst3ml (Article aw FeaturedArticle)
    }

    // Satr 15: getter method katrd l-3unwan
    public function title(): string { // l-hedef: nsm7o b l-wsol l l-title b shkl amn
        // Satr 16: nrj3o l-title
        return $this->title; // l-hedef: nrj3o l-3unwan l-mkhzn
    }

    // Satr 17: getter method katrd l-slug
    public function slug(): string { // l-hedef: nsm7o b l-wsol l l-slug b shkl amn
        // Satr 18: nrj3o l-slug
        return $this->slug; // l-hedef: nrj3o l-slug l-mkhzn
    }

    // Satr 19: getter method katrd l-tags
    public function tags(): array { // l-hedef: nsm7o b l-wsol l l-tags b shkl amn
        // Satr 20: nrj3o l-tags
        return $this->tags; // l-hedef: nrj3o lista d l-tags l-mkhzna
    }

    // Satr 21: setter method katbdl l-title w l-slug m3a validation
    public function setTitle(string $title): void { // l-hedef: nbdlo l-3unwan w ntaakdo mn shihtha
        // Satr 22: n-nqiw l-title mn l-faraghat l-zayda
        $title = trim($title); // l-hedef: n7ido l-spaces l-zaydin mn l-title
        // Satr 23: nt2kdo wash l-title khawi
        if ($title === '') throw new InvalidArgumentException("Titre requis."); // l-hedef: nrmiw erreur lo l-title khawi
        // Satr 24: n3tiw l-title l l-khasiya title
        $this->title = $title; // l-hedef: nkhzno l-title l-jdid
        // Satr 25: nbdlo l-slug b method slugify
        $this->slug = static::slugify($title); // l-hedef: njnriw slug jdid mn l-title b static:: (LSB)
    }

    // Satr 26: method katzid tag l l-lista d l-tags
    public function addTag(string $tag): void { // l-hedef: nsm7o b ziada d tag jdid
        // Satr 27: n-nqiw l-tag mn l-faraghat l-zayda
        $t = trim($tag); // l-hedef: n7ido l-spaces l-zaydin mn l-tag
        // Satr 28: nt2kdo wash l-tag khawi
        if ($t === '') throw new InvalidArgumentException("Tag vide."); // l-hedef: nrmiw erreur lo l-tag khawi
        // Satr 29: nzido l-tag l l-lista d l-tags
        $this->tags[] = $t; // l-hedef: nkhzno l-tag l-jdid f l-lista
    }

    // Satr 30: static method katrd 3dd l-articles li tnshew
    public static function count(): int { // l-hedef: nsm7o b l-wsol l 3dd l-articles
        // Satr 31: nrj3o l-qima d $count
        return self::$count; // l-hedef: nrj3o 3dd l-articles l-mkhzn f static count
    }

    // Satr 32: protected static method kat7wl string l slug (URL-friendly)
    protected static function slugify(string $value): string { // l-hedef: njnriw slug mn string l URL-friendly
        // Satr 33: n7wlo l-value l lowercase
        $s = strtolower($value); // l-hedef: nkhliwu l-klam klh b 7rof sghar
        // Satr 34: nbdlo kl shi msh a-z aw 0-9 b "-"
        $s = preg_replace('/[^a-z0-9]+/i', '-', $s) ?? ''; // l-hedef: n7ido kl shi msh 7rof aw arqam w n3tiw "-"
        // Satr 35: n-nqiw l-"-" l-zaydin mn l-bda w l-nhaya
        return trim($s, '-'); // l-hedef: nrj3o slug nqi w URL-friendly
    }
}

// Satr 36: sous-classe kawartha mn Article, kat3awd t3rif slugify
class FeaturedArticle extends Article { // l-hedef: nshro klas ytzid features 3la Article
    // Satr 37: protected static method kat3awd t3rif slugify bash tzid "featured-"
    protected static function slugify(string $value): string { // l-hedef: nbdlo s-suluk d slugify f l-sous-classe
        // Satr 38: nzido "featured-" qbl ma nst3mlo slugify d Article
        return 'featured-' . parent::slugify($value); // l-hedef: nrj3o slug m3 "featured-" f lbda
    }
}

// Satr 39: nshro article jdid b usine fromTitle
$a = Article::fromTitle(1, 'Encapsulation & visibilité en PHP'); // l-hedef: nshro article b id=1 w title m3yn
// Satr 40: nshro featured article jdid b usine fromTitle
$b = FeaturedArticle::fromTitle(2, 'Lire moins, comprendre plus'); // l-hedef: nshro featured article b id=2 w title m3yn
// Satr 41: nzido tag "best" l l-featured article
$b->addTag('best'); // l-hedef: nzido tag l l-article $b
// Satr 42: nshriw l-slug dial l-article $a
echo $a->slug() . PHP_EOL; // l-hedef: ntb3o l-slug dial $a (encapsulation-visibilite-en-php)
// Satr 43: nshriw l-slug dial l-featured article $b
echo $b->slug() . PHP_EOL; // l-hedef: ntb3o l-slug dial $b (featured-lire-moins-comprendre-plus)
// Satr 44: nshriw 3dd l-articles li tnshew
echo Article::count() . PHP_EOL; // l-hedef: ntb3o 3dd l-articles (2)




// Encapsulation katkhbbi l-bayanat l-dakhiliya d l-klas (zay private properties)
//  w katsm7 b l-wsol liyha ghi 3bra getters w setters m3 validation.
//  L-hedef huwa n7miw l-bayanat mn t-tbdil ghyr l-mrghub w nkhliwu l-code anf w m