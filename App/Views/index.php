<?php
require __DIR__ . '/../Tpl/header.php';
?>
<div class="container-fluid">
    <div class="row">
        <div class="content col-md-2">
            <h3>
                Amateur de scénario dominions mais t'en a plus sous le coude? <br/>
                <br/>
                Génère ton deck parmis les cartes actions dont tu dispose. <br/>
            </h3>
            <h4>Sélectionne tes préférences : (ou pas)</h4>
            <div class="btn-group-vertical center-block" data-toggle="buttons">
                <?php
                $i = 1;
                foreach ($expansion as $exp) {
                    $name = $exp['expansion'];
                    ?>
                    <label class="btn btn-primary">
                        <input name="expansions" type="checkbox" autocomplete="off" value="<?= $name ?>"><?= $name ?>
                    </label>
                    <?php
                    $i++;
                }
                ?>
            </div>
            <br>
            <h4>Sélectionne tes extensions : (ou pas)</h4>
            <div class="btn-group-vertical center-block" data-toggle="buttons">
                <label class="btn btn-default dominion-text-attack">
                    <input name="prefs" type="checkbox" autocomplete="off" value="Attack">Attaque
                </label>
                <label class="btn btn-default dominion-text-reaction">
                    <input name="prefs" type="checkbox" autocomplete="off" value="Reaction">Reaction
                </label>
                <label class="btn btn-default dominion-text-tresor">
                    <input name="prefs" type="checkbox" autocomplete="off" value="Treasure">Trésor
                </label>
                <label class="btn btn-default dominion-text-duration">
                    <input name="prefs" type="checkbox" autocomplete="off" value="Duration">Durée
                </label>
                <label class="btn btn-default dominion-text-victory">
                    <input name="prefs" type="checkbox" autocomplete="off" value="Victory">Victoire
                </label>
            </div>
            <br>
            <br>
            <span id="btn-gen" class="btn btn-lg btn-default" >Genére ton deck !</span> 
        </div>
        <div class="col-md-10  deck"></div>
    </div>
</div>
<?php
require __DIR__ . '/../Tpl/footer.php';
?>