<?php

$row = [
    'views' => '0', // string zero
    'excerpt' => '' // string khawi
];

// Test b ??
echo $row['views'] ?? 'default'; // Ghadi y-printi '0'
echo "\n";
echo $row['excerpt'] ?? 'default'; // Ghadi y-printi ''
echo "<br>";

// Test b ?:
echo $row['views'] ?: 'default'; // Ghadi y-printi 'default' hita '0' falsy
echo "<br>";
echo $row['excerpt'] ?: 'default'; // Ghadi y-printi 'default' hita '' falsy
echo "<br>";


/*
 * Table dial l-farq bin ?? w ?:
 * 
 * | Operator | Sho kat-shuf         | Mté kat-akhod default value                     | Exemple                                       |
 * |----------|---------------------|-----------------------------------------------|-----------------------------------------------|
 * | ??       | Null wlla undefined | Ila l-value null wlla l-key ma-kaynsh         | $row['views'] ?? 0 → y-rja3 0 ila views null wlla m-f9ud |
 * | ?:       | Truthy/Falsy        | Ila l-value falsy (null, 0, '', false, etc.)   | $row['views'] ?: 0 → y-rja3 0 ila views falsy (7ta lo kan 0) |
 * 
 */