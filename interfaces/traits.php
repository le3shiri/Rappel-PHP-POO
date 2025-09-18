<?php
declare(strict_types=1);

# trait li fih method slugify li kat7awel string l slug
trait Slugify {
  protected function slugify(string $value): string {
    # t7awel kolchi l lowercase
    $s = strtolower($value);

    # kolchi li ma chi [a-z0-9] kaytbdel b tire (-)
    $s = preg_replace('/[^a-z0-9]+/i', '-', $s) ?? '';

    # t7ayad tire (-) men lbdaya w men lakhra
    return trim($s, '-');
  }
}

# class Article katst3ml trait Slugify
class Article {
  use Slugify;

  # method makeSlug katsayeb slug men title
  public function makeSlug(string $title): string {
    return $this->slugify($title);
  }
}

# class Product katst3ml trait Slugify b7al Article
class Product {
  use Slugify;

  # method makeSlug katsayeb slug men smiya dyal product
  public function makeSlug(string $name): string {
    return $this->slugify($name);
  }
}

# -------------------- TEST --------------------

# instance men Article
$article = new Article();
# ghadi ytb3: hello-world
echo $article->makeSlug("Hello World !!") . PHP_EOL;

# instance men Product
$product = new Product();
# ghadi ytb3: nike-air-max-90
echo $product->makeSlug("Nike Air Max 90 !!!") . PHP_EOL;
