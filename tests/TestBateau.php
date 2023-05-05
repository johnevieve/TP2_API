<?php

use Tests\TestCase;

class PartieControllerTest extends TestCase
{
    public function testPlacerBateaux()
    {
        $partieController = new PartieController();

        $bateaux = $partieController->placerBateaux();

// Vérifie que $bateaux est un tableau associatif contenant 5 clés: porte-avions, cuirassé, destroyer, sous-marin et patrouilleur
        $this->assertIsArray($bateaux);
        $this->assertCount(5, $bateaux);
        $this->assertArrayHasKey('porte-avions', $bateaux);
        $this->assertArrayHasKey('cuirassé', $bateaux);
        $this->assertArrayHasKey('destroyer', $bateaux);
        $this->assertArrayHasKey('sous-marin', $bateaux);
        $this->assertArrayHasKey('patrouilleur', $bateaux);

// Vérifie que chaque bateau a été placé sur la grille (chaque valeur est un tableau non vide)
        foreach ($bateaux as $bateau) {
            $this->assertIsArray($bateau);
            $this->assertNotEmpty($bateau);
        }
    }
}
