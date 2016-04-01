<?php

namespace App\Models;

use ORM;

class Cards {

    public function __construct() {
        
    }

    public function getExpansion() {
        return ORM::for_table('cards')->distinct()->select('expansion')->find_array();
    }

    public function generateDeck() {
        $req = ORM::for_table('cards');
        if (!empty($_POST['expansion']) && is_array($_POST['expansion'])) {
            $restrict = array();
            foreach ($_POST['expansion'] as $expName) {
                array_push($restrict, array("Expansion" => $expName));
            }
            $req->where_any_is($restrict);
        }
        $req->where("Action", "1");
        $req->order_by_asc("Cost");
        $allActionCards = $req->find_array();

        /**
         * Algo deck
         */
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
                    case $cost >= 5:
                        $key = 5;
                        break;
                    default:
                        $key = 3;
                        break;
                }
                if (!isset($sortArray[$key])) {
                    $sortArray[$key] = array();
                }
                $sortArray[$key][] = $actionCard;
            }
        }
        $aDeck = array();
        $alreadyUse = array("");
        foreach ($equil as $key => $nb) {
            $nbELement = count($sortArray[$key]);
            for ($i = 0; $i < $nb; $i++) {
                do {
                    $name = "";
                    $ind = mt_rand(0, $nbELement);
                    if (isset($sortArray[$key][$ind])) {
                        $aDeck[] = $sortArray[$key][$ind];

                        unset($sortArray[$key][$ind]);
                        $nbELement = count($sortArray[$key]);
                        array_push($alreadyUse, $ind);
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

        $oRes = new \stdClass();
        $oRes->deck = $aDeck;
        $oRes->allActionCards = $allActionCards;

        return $oRes;
    }

}
