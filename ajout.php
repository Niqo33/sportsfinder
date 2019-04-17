<?php

$lieu = $_POST['lieu_act'];
$adresse = $_POST['add_act'];
$sport = $_POST['sport'];
$ville = $_POST['ville'];
$latitude = $_POST['lt'];
$longitude = $_POST['lg'];


try
    {
    	$bdd = new PDO('mysql:host=localhost;dbname=c9;charset=utf8', 'root', '');
    }
    
catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }

    //Récuperation ID Sport
    $num_sport = $bdd->query("SELECT ID_Sport FROM Sport
    WHERE Nom_Sport='".$sport."'
    ");

    while($n_sport = $num_sport->fetch())
    {
    $numF_sport = $n_sport['ID_Sport'];
    };
    
    //Récuperation ID Ville
    $num_ville = $bdd->query("SELECT ID_Ville FROM Ville
    WHERE Nom_Ville='".$ville."'
    ");

    while($n_ville = $num_ville->fetch())
    {
    $numF_ville = $n_ville['ID_Ville'];
    };
    
    
    //Ajout Nouvelle entrée en BD
    $requete = $bdd->prepare("INSERT INTO `c9`.`Activité` (
    `ID_Sport`,
    `ID_Ville`,
    `Nom_Activité`,
    `Adresse_Activité`,
    `Longitude`,
    `Latitude`
    
    )
    VALUES('$numF_sport','$numF_ville','$lieu','$adresse','$latitude','$longitude'
    );");
    
    $requete->execute();
    
    header('Location: ajout.html');
    
?>