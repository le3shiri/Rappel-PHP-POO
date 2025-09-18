<?php
declare(strict_types=1);

# 1. interface = l3qd
interface Logger {
  public function info(string $msg): void;
}

# 2. Logger kaykteb f console
class StdoutLogger implements Logger {
  public function info(string $msg): void {
    echo "[INFO] $msg" . PHP_EOL;
  }
}

# 3. Logger ma kaydir walo
class NullLogger implements Logger {
  public function info(string $msg): void {
    // makayn 7tta 7aja hna
  }
}

# 4. function katkhadam service o kat7taj logger
function run(Logger $logger): void {
  $logger->info("🚀 Demarrage du programme...");
  
  for ($i = 1; $i <= 3; $i++) {
    $logger->info("Traitement etape $i...");
  }
  $logger->info("✅ Fin du programme !");
}

# -------------------------------
# 5. isti3mal logger li kayban f console
echo "=== Avec StdoutLogger ===\n";
run(new StdoutLogger());

# 6. isti3mal logger li ma kayban-ch
echo "\n=== Avec NullLogger ===\n";
run(new NullLogger());
