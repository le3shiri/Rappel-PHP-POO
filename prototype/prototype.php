<?php

if ($argc !== 2) {
    echo "Usage: php PROTOTYPE.php <nombre>\n";
    exit(1);
}

$nombre = $argv[1];

if (!is_numeric($nombre)) {
    echo "Erreur : Veuillez entrer un nombre entier\n";
    exit(1);
}

$nombre = (int)$nombre;

$binaire = decbin($nombre);
$hexa = strtoupper(dechex($nombre));

echo "Décimal : $nombre\n";
echo "Binaire : $binaire\n";
echo "Hexa    : {$hexa}Hexa\n";