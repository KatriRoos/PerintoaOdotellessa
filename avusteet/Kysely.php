<?php
require_once 'tietokantayhteys.php';
class Kysely {
    private $_pdo;

    public function __construct($pdo) {
        $this->_pdo = $pdo;
    }
    
    protected function valmistele($sqllause) {
        return $this->_pdo->prepare($sqllause);
    }

}

