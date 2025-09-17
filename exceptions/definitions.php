<?php
declare(strict_types=1);

// Définition: Exception
// Hadchi howa objet li y'signaler situation anormale (zay fichier m'kaynx wla JSON cassé).
// Y'mken t'catchiha w t'trait'ha b try/catch.

// Définition: Throwable
// Interface l'kbira li t'ghatti Exception w Error f PHP 7+.
// Y'slah ghi f top-level (zay script CLI) bash t'kontroli kolchi w ma y'crashich.

// Définition: try/catch/finally
// try: Hna t'dir l'code li ymken y'generer erreur (risky code).
// catch: T'catchi exception spécifique w t'trait'ha (zay afficher message d'erreur).
// finally: Y'tnafad dima, swa kan erreur wla la, bash t'netfi ressources (zay fermer fichier).

// Définition: Exceptions standard
// - RuntimeException: Erreur générale f runtime (zay fichier m'kaynx).
// - InvalidArgumentException: Input machi mzyan (zay division b zéro).
// - DomainException: Erreur f business logic (zay title khawi f article).
// - JsonException: Erreur f parsing JSON.

// Définition: Propagation / Rethrow
// Kan t'catchi exception, t'qder t'rethrow'ha b ajout context (zay path dyal fichier) b l'usage dyal previous.

// Exemple: try/catch/finally
function riskyDivide(int $a, int $b): float {
    // Vérifier ida l'input b zéro
    if ($b === 0) {
        throw new InvalidArgumentException('Division b zéro mam7dudach!');
    }
    return $a / $b;
}

// Exemple d'usage
try {
    echo riskyDivide(10, 0);
} catch (InvalidArgumentException $e) {
    echo "[ATTENTION] " . $e->getMessage() . PHP_EOL;
} finally {
    echo "Hadchi y'tnafad dima (zay t'netfiya dyal ressources)." . PHP_EOL;
}

// Exemple: Multi-catch
try {
    // Code li ymken y'generer JsonException wla InvalidArgumentException
} catch (JsonException|InvalidArgumentException $e) {
    // Traitement commun (zay log erreur)
} catch (Exception $e) {
    // Filet d'sécurité bash t'catchi exceptions lokhrin
}

// Exemple: Rethrow b ajout context
function loadConfig(string $path): array {
    try {
        $json = file_get_contents($path);
        if ($json === false) {
            throw new RuntimeException("Ma qdrtsh n'qra l'fichier: $path");
        }
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    } catch (JsonException $e) {
        // Rethrow b context zayd
        throw new RuntimeException("JSON machi mzyan f $path", previous: $e);
    }
}

// Exemple: Convertir warnings/notice l exceptions
set_error_handler(function (int $severity, string $message, string $file, int $line) {
    throw new ErrorException($message, 0, $severity, $file, $line);
});

// Note: JSON_THROW_ON_ERROR
// Y'khli json_decode y'throw JsonException f blass null kan erreur, y'faciliti gestion d'erreurs.

// Note: Hiérarchie
// Throwable
// ├─ Error (erreurs fatales zay TypeError)
// └─ Exception (exceptions classiques li t'qder t'handle'hom)
// Catch dima l'spécifiques l'awwel, ba3d l'génériques.

// Note: CLI Best Practices
// - Catch Throwable f top-level bash t'kontroli crash.
// - Écrire erreurs f STDERR b fwrite(STDERR, message).
// - Rja3 exit code 0 ida success, 1 ida erreur.
?>