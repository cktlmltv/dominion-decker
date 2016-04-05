<h4>Parmis <?= count($allActionCards) ?>  cartes "Action"</h4>
<?php
$i = 0;
foreach ($aDeck as $card) {
    if ($i % 5 == 0) {
        echo '<div class="row-cards">';
    }
    ?>

    <div class="cards-cont mix" data-my-order="<?= $cost ?>">
        <img class="img-responsive img-rounded" src='<?= BASE_URL ?>assets/images/cards/<?= strtolower(str_replace(array(' ', "'"), array('', ''), $card['Expansion'])) ?>/<?= strtolower(str_replace(' ', '', $card['Name'])) ?>.jpg' />
    </div>
    <?php
    $i++;
    if ($i % 5 == 0)
        echo "</div><div class='clearfix'></div>";
}
?>