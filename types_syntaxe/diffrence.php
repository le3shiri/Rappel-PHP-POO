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
