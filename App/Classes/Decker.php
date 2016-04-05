<?php

namespace App\Classes;

class Decker {

    /**
     * Par défaut on prends :
     *  - 3 cartes inférieur ou égale à 3 piéce d'achat
     *  - 4 cartes égale à 4 piéce d'achat
     *  - 3 cartes supérieur à 4 piéce d'achat
     */
    private $aEquil;
    private $aEquilCard;
    private $aCards;

    public function __construct($aCards = array()) {
        $this->aCards = $aCards;
        $this->aEquil = array("3" => 3, "4" => 4, "5" => 3);
        $this->aEquilCard = array();
    }

    public function sortDeck($allActionCards, $aPref = array()) {
        $equil = array("3" => 3, "4" => 4, "5" => 3);
        $sortArray = array();
        foreach ($allActionCards as $actionCard) {
            $key = 3;
            if (isset($actionCard['Cost'])) {
                $cost = ( (float) str_replace("$", "", $actionCard['Cost']));
                switch ($cost) {
                    case $cost <= 3:
                        $key = 3;
                        break;
                    case $cost == 4:
                        $key = 4;
                        break;
                    case $cost > 4:
                        $key = 5;
                        break;
                    default:
                        $key = 3;
                        break;
                }
                if (!isset($this->aEquilCard[$key])) {
                    $this->aEquilCard[$key] = array();
                }
                $this->aEquilCard[$key][] = $actionCard;
            }
        }
        $oRes = new \stdClass();
        if (count($aPref) > 1) {
            $aDeck = array();
        } else {
            $aDeck = $this->randSort($allActionCards);
        }
        $oRes->deck = $aDeck;
        $oRes->allActionCards = $allActionCards;
        return $oRes;
    }

    private function stdSord($allActionCards) {
        $aDeck = array();
        $alreadyUse = array("");
        foreach ($this->aEquil as $key => $nb) {
            $nbELement = count($this->aEquilCard[$key]);
            for ($i = 0; $i < $nb; $i++) {
                do {
                    $name = "";
                    $ind = mt_rand(0, $nbELement);
                    if (isset($this->aEquilCard[$key][$ind])) {
                        $aDeck[] = $this->aEquilCard[$key][$ind];
                        $nbELement = count($this->aEquilCard[$key]);
                        array_push($alreadyUse, $ind);
                        unset($this->aEquilCard[$key][$ind]);
                    }
                } while (!in_array($ind, $alreadyUse));
                $alreadyUse = array();
            }
        }
        usort($aDeck, function($a, $b) {
            if ($a['Cost'] == $b['Cost']) {
                return 0;
            }
            return ($a['Cost'] < $b['Cost']) ? -1 : 1;
        });
    }

    private function randSort($allActionCards) {
        $aDeck = array();
        $alreadyUse = array("");
        foreach ($this->aEquil as $key => $nb) {
            $nbELement = count($this->aEquilCard[$key]);
            for ($i = 0; $i < $nb; $i++) {
                do {
                    $name = "";
                    $ind = mt_rand(0, $nbELement);
                    if (isset($this->aEquilCard[$key][$ind])) {
                        $aDeck[] = $this->aEquilCard[$key][$ind];
                        $nbELement = count($this->aEquilCard[$key]);
                        array_push($alreadyUse, $ind);
                        unset($this->aEquilCard[$key][$ind]);
                    }
                } while (!in_array($ind, $alreadyUse));
                $alreadyUse = array();
            }
        }
        usort($aDeck, function($a, $b) {
            if ($a['Cost'] == $b['Cost']) {
                return 0;
            }
            return ($a['Cost'] < $b['Cost']) ? -1 : 1;
        });

        return $aDeck;
    }

    public function __get($name) {
        return $this->$name;
    }

    public function __set($name, $value) {
        $this->$name = $value;
        return $this->$name;
    }

}
