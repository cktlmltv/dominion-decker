<div class="row">
    <div class="col-md-12 text-center">
        <h4 class="text-danger">Deck parmis <?= count($allActionCards) ?>  cartes</h4>
        <table class="table table-condensed table-hover">
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Carte</th>
                    <th>Extension</th>
                    <th>Type</th>
                    <th>Couts</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                foreach ($aDeck as $card) {
                    if (isset($card['Cost'])) {
                        $cost = (int) (str_replace(array('+', "$"), array("", ""), $card['Cost']));
                        switch ($cost) {
                            case $cost <= 3:
                                $cssClass = "btn-info";
                                break;
                            case $cost == 4:
                                $cssClass = "btn-warning";
                                break;
                            case $cost >= 5:
                                $cssClass = "btn-danger";
                                break;
                            default:
                                $cssClass = "btn-info";
                                break;
                        }
                    }
                    ?>
                    <tr class="cards <?= $cssClass ?>" data-name="<?= md5($card['Name']) ?>">
                        <td><?= $i ?></td>
                        <td><?= $card['Name'] ?></td>
                        <td><?= $card['Expansion'] ?></td>
                        <td>  <?php
                            $aType = array();

                            if ($card['Action'] == 1) {
                                $aType[] = "Action";
                            }
                            if ($card['Attack'] == 1) {
                                $aType[] = "Attaque";
                            }
                            if ($card['Curse'] == 1) {
                                $aType[] = "Malédiction";
                            }
                            if ($card['Duration'] == 1) {
                                $aType[] = "Durée";
                            }
                            if ($card['Reaction'] == 1) {
                                $aType[] = "Réaction";
                            }
                            if ($card['Treasure'] == 1) {
                                $aType[] = "Trésor";
                            }
                            if ($card['Victory'] == 1) {
                                $aType[] = "Victoire";
                            }

                            echo implode("/", $aType);
                            ?>
                        </td>
                        <td><?= (str_replace(array('+', "$"), array("", ""), $card['Cost'])) ?></td>

                    </tr>
                    <tr id="<?= md5($card['Name']) ?>-desc" class="desc hidden">
                        <td colspan="5">
                            <p>
                                <?php
                                if ($card['Text']) {
                                    echo $card['Text'] . "<hr>";
                                }

                                /* (str_replace(array('+', "p"), array("", ""), $card['Pot'])) */
                                if ((isset($card['Actiontodo'])) && (!empty($card['Actiontodo'])))
                                    echo (str_replace("a", "", $card['Actiontodo'])) . " action(s) <br/>";
                                if ((isset($card['Buy'])) && (!empty($card['Buy'])))
                                    echo (str_replace("b", "", $card['Buy'])) . " achat(s) <br/>";
                                if ((isset($card['Card'])) && (!empty($card['Card'])))
                                    echo (str_replace("c", "", $card['Card'])) . " carte(s) <br/>";
                                if ((isset($card['Coin'])) && (!empty($card['Coin'])))
                                    echo (str_replace("$", "", $card['Coin'])) . " piéces(s) <br/>";
                                if ((isset($card['VP'])) && (!empty($card['VP'])))
                                    echo (str_replace("v", "", $card['VP'])) . " point(s) de victoire <br/>";
                                ?>
                            </p>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
                ?>
                <tr>

                </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    /* $("tr.cards")
     .mouseenter(function () {
     var name = $(this).data('name');
     if (!elemDisplay) {
     $("#" + name + "-desc").removeClass("hidden")
     $("#" + name + "-desc").fadeIn();
     elemDisplay = true;
     }
     })
     .mouseleave(function () {
     if (elemDisplay) {
     var name = $(this).data('name');
     $("#" + name + "-desc").fadeOut();
     elemDisplay = false;
     }
     });*/

    $("tr.cards")
            .click(function () {
                var name = $(this).data('name');
                if ($("#" + name + "-desc").hasClass("hidden")) {
                    $("#" + name + "-desc").removeClass("hidden");
                    $("#" + name + "-desc").fadeIn();
                } else {
                    $("#" + name + "-desc").fadeOut();
                    $("#" + name + "-desc").addClass("hidden");
                }
            });

</script>