<?php

$row = [
    'views' => '0', // string zero
    'excerpt' => '' // string khawi
];

// Test b ??
echo $row['views'] ?? 'default'; // Ghadi y-printi '0'
echo "\n";
echo $row['excerpt'] ?? 'default'; // Ghadi y-printi ''
echo "\n";

// Test b ?:
echo $row['views'] ?: 'default'; // Ghadi y-printi 'default' hita '0' falsy
echo "\n";
echo $row['excerpt'] ?: 'default'; // Ghadi y-printi 'default' hita '' falsy
echo "\n";


/*
 * Table dial l-farq bin ?? w ?:
 * 
 * | Operator | Sho kat-shuf         | Mté kat-akhod default value                     | Exemple                                       |
 * |----------|---------------------|-----------------------------------------------|-----------------------------------------------|
 * | ??       | Null wlla undefined | Ila l-value null wlla l-key ma-kaynsh         | $row['views'] ?? 0 → y-rja3 0 ila views null wlla m-f9ud |
 * | ?:       | Truthy/Falsy        | Ila l-value falsy (null, 0, '', false, etc.)   | $row['views'] ?: 0 → y-rja3 0 ila views falsy (7ta lo kan 0) |
 * 
 * 
 */

 /*
 * Definition dial Union Types:
 * [!]  Union types kat-khli variable wlla parameter y-kun mn akther mn type wahed (mthlan string|int)
 * - Union types jao m3a PHP 8.0, kat-khlik t-definiw an shi variable, parameter, wlla return value y-kun mn types mkhltfa
 * - Mthlan: function test(string|int $value): string|bool {...} kateama an $value y-kun string wlla int, w l-return y-kun string wlla bool
 * - Kan-st3mluha bash n-dir code flexible w m3a strict typing n-garantiw type safety
 * - Syntax: Kan-ktbo types m-freqa b pipe | (mthlan string|int|float)
 * Exemple:
 * function getId(string|int $id): string|int {
 *     return $id;
 * }
 * $result = getId('abc'); // string
 * $result = getId(123);   // int
 */