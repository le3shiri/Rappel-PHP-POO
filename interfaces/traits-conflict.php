<?php
declare(strict_types=1);

# trait A fih method ping
trait A { 
  public function ping() { 
    echo 'A'; 
  } 
}

# trait B fih method ping b7al A
trait B { 
  public function ping() { 
    echo 'B'; 
  } 
}

class X {
  # hna ghadi nst3ml trait A w trait B
  use A, B {
    # insteadof = khoud method men A w tignore li f B
    A::ping insteadof B;

    # as = dir alias l method li f B b smiya okhra
    B::ping as pingB;
  }
}

# test
$obj = new X();

# hna kayn ping() men A
$obj->ping();   // A

# w hna kayn pingB() alias dyal B::ping
$obj->pingB();  // B
