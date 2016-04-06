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

        $oRes = new \stdClass();
        if (!empty($aPref)) {
            $aDeck = $this->prefSort($allActionCards, $aPref);
        } else {
            $aDeck = $this->randSort($allActionCards);
        }
        usort($aDeck, function ($a, $b) {
            if ($a['Cost'] == $b['Cost']) {
                return 0;
            }
            return ($a['Cost'] < $b['Cost']) ? -1 : 1;
        });
        $oRes->deck = $aDeck;
        $oRes->allActionCards = $allActionCards;
        return $oRes;
    }

    private function prefSort($allActionCards, $aPref) {
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
                $inMain = false;
                $nbPref = 0;
                foreach ($aPref as $pref) {
                    if (isset($actionCard[$pref]) && $actionCard[$pref] == 1) {
                        $inMain = true;
                        $nbPref++;
                    }
                }
                $actionCard['nbPref'] = $nbPref;
                if (!isset($this->aEquilCard[$key])) {
                    $this->aEquilCard[$key] = array('main' => array(), 'pool' => array());
                }
                if ($inMain) {
                    $this->aEquilCard[$key]['main'][] = $actionCard;
                } else {
                    $this->aEquilCard[$key]['pool'][] = $actionCard;
                }
            }
        }
        $aDeck = array();
        $alreadyUse = array();
        foreach ($this->aEquil as $key => $nb) {
            $nbELementMain = count($this->aEquilCard[$key]['main']);
            $nbELementPool = count($this->aEquilCard[$key]['pool']);
            $name = "";
            $i = 0;
            do {
                if (!empty($this->aEquilCard[$key]['main'])) {
                    do {
                        $ind = mt_rand(0, $nbELementMain);
                        if (!empty($this->aEquilCard[$key]['main'][$ind])) {
                            $aDeck[] = $this->aEquilCard[$key]['main'][$ind];
                            $nbELementMain = count($this->aEquilCard[$key]['main']);
                            $name = $this->aEquilCard[$key]['main'][$ind]['Name'];
                            array_push($alreadyUse, $name);
                            unset($this->aEquilCard[$key]['main'][$ind]);
                            $i++;
                        }
                    } while (!in_array($name, $alreadyUse) && $nbELementMain > 1);
                } else {
                    $name = "";
                    do {
                        $ind = mt_rand(0, $nbELementPool);
                        if (isset($this->aEquilCard[$key]['pool'][$ind])) {
                            $aDeck[] = $this->aEquilCard[$key]['pool'][$ind];
                            $nbELementPool = count($this->aEquilCard[$key]['pool']);
                            $name = $this->aEquilCard[$key]['pool'][$ind]['Name'];
                            array_push($alreadyUse, $name);
                            unset($this->aEquilCard[$key]['pool'][$ind]);
                            $i++;
                        }
                    } while (!in_array($name, $alreadyUse) && $nbELementPool > 0);
                }
                
            } while ($i < $nb);
            $alreadyUse = array();
        }
        return $aDeck;
    }

    private function randSort($allActionCards) {
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
