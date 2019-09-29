<?php
require __DIR__ . "/vendor/autoload.php";

## ETAPE 0

## CONNECTEZ VOUS A VOTRE BASE DE DONNEE

## ETAPE 1

## POUVOIR SELECTIONER UN PERSONNE DANS LE PREMIER SELECTEUR

## ETAPE 2

## POUVOIR SELECTIONER UN PERSONNE DANS LE DEUXIEME SELECTEUR

## ETAPE 3

## LORSQUE LON APPPUIE SUR LE BOUTON FIGHT, RETIRER LES PV DE CHAQUE PERSONNAGE PAR RAPPORT A LATK DU PERSONNAGE QUIL COMBAT

## ETAPE 4

## UNE FOIS LE COMBAT LANCER (QUAND ON APPPUIE SUR LE BTN FIGHT) AFFICHER en dessous du formulaire
# pour le premier perso PERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)
# pour le second persoPERSONNAGE X (name) A PERDU X PV (l'atk du personnage d'en face)

## ETAPE 5

## N'AFFICHER DANS LES SELECTEUR QUE LES PERSONNAGES QUI ONT PLUS DE 10 PV

$pdo = new PDO('mysql:host=127.0.0.1;dbname=rendu', "root", "");
$personnages=$pdo->prepare("SELECT name,pv FROM personnage");
$personnages->execute();

$data = $personnages->fetchAll(PDO::FETCH_OBJ);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rendu Php</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="nav mb-3">
    <a href="./rendu.php" class="nav-link">Acceuil</a>
    <a href="./personnage.php" class="nav-link">Mes Personnages</a>
    <a href="./combat.php" class="nav-link">Combats</a>
</nav>
<h1>Combats</h1>
<div class="w-100 mt-5">

    <form action="" method="post">
        <div class="form-group">
            <select name="typer1" id="typer1">
                <?php
                foreach($data as $key => $value):
                ;?>
                <option value="<?php
                // J'affiche uniquement les personnages ayant + ou = a 10 PV
                if ($value->pv >= 10) {
                    echo $value->name;
                }
                ?>"><?php
                    if ($value->pv >= 10) {
                        echo $value->name;
                            }
                    ?>


                    <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <select name="typer2" id="typer2">
                <?php
                foreach($data as $key => $value):
                ;?>
                <option value="<?php

                // J'affiche uniquement les personnages ayant + ou = a 10 PV
                if ($value->pv >= 10) {
                    echo $value->name;
                }
                ?>"><?php
                    if ($value->pv >= 10) {
                        echo $value->name;
                    }
                    ?>


                    <?php endforeach; ?>
            </select>
        </div>

        <button class="btn">Fight</button>
    </form>

    <?php
    // je récupère mes classes et je les mets dans des variables

    if (!empty($_POST["typer1"] && $_POST["typer2"])) {
        $classe1 = $_POST["typer1"];
        $classe2 = $_POST["typer2"];

// je récupère pv et attaque du premier champs

        $typo = $pdo->prepare("SELECT pv FROM personnage WHERE name = '$classe1'");
        $typo->execute();

        $up = $typo->fetchAll(PDO::FETCH_OBJ);

        foreach ($up as $clé => $element) {
            $pvperso = $element->pv;
        }

        $typo2 = $pdo->prepare("SELECT atk FROM personnage WHERE name = '$classe1'");
        $typo2->execute();

        $up2 = $typo2->fetchAll(PDO::FETCH_OBJ);

        foreach ($up2 as $clé2 => $element2) {
            $atkperso = $element2->atk;
        }

        // je récupère pv et attaque du deuxieme champs

        $typo3 = $pdo->prepare("SELECT pv FROM personnage WHERE name = '$classe2'");
        $typo3->execute();

        $up3 = $typo3->fetchAll(PDO::FETCH_OBJ);

        foreach ($up3 as $clé3 => $element3) {
            $pvperso2 = $element3->pv;
        }

        $typo4 = $pdo->prepare("SELECT atk FROM personnage WHERE name = '$classe2'");
        $typo4->execute();

        $up4 = $typo4->fetchAll(PDO::FETCH_OBJ);

        foreach ($up4 as $clé4 => $element4) {
            $atkperso2 = $element4->atk;
        }

        // J'opère

        $newpv = $pvperso - $atkperso2;
        $newpv2 = $pvperso2 - $atkperso;

        // J'update

        $maj = $pdo->prepare("UPDATE personnage SET pv = '$newpv' WHERE name = '$classe1'");
        $maj->execute();

        $maj2 = $pdo->prepare("UPDATE personnage SET pv = '$newpv2' WHERE name = '$classe2'");
        $maj2->execute();

        //on ecrit sur la page combien de PV tel perso a perdu

        echo $classe1 . " à perdu " . $atkperso2 . " PV";
        ?>
        <br>
        <?php
        echo $classe2 . " à perdu " . $atkperso . " PV";
    }
?>



</div>

</body>
</html>
