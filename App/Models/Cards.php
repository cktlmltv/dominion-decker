<?php

namespace App\Models;

use ORM;

class Cards {

    public function __construct() {
        
    }

    public function getExpansion() {
        return ORM::for_table('cards')->distinct()->select('expansion')->find_array();
    }

    public function generateDeck($aExpansions) {
        $req = ORM::for_table('cards');
        if (!empty($aExpansions) && is_array($aExpansions)) {
            $restrict = array();
            foreach ($aExpansions as $expName) {
                array_push($restrict, array("Expansion" => $expName));
            }
            $req->where_any_is($restrict);
        }
        $req->where("Action", "1");
        $req->order_by_asc("Cost");
        $allActionCards = $req->find_array();
        return $allActionCards;
    }

}
