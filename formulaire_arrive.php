<?php
include('connectionbdd.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des valeurs du formulaire
    $heureDepartReelle = $_POST['heure-depart-reelle'];
    $heureArriveeReelle = $_POST['heure-arrivee-reelle'];
    $signature = $_POST['signature'];
    $infoSupplementaire = $_POST['info-supplementaire'];
    $photoEnfant = $_POST['photo_enfant'];
    $heureDepartTheorique = $_POST['heure-depart-theorique'];
    $heureArriveeTheorique = $_POST['heure-arrivee-theorique'];

    // Insertion des données dans la base de données
    $insertionBDD = $bdd->prepare("INSERT INTO formulaire_chauffeurs (signature, photo, heure_depart_theorique_formulaire, heure_arrivee_theorique_formulaire, heure_depart_reel_formulaire, heure_arrivee_reel_formulaire, info_supp_formulaire) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $insertionBDD->execute(array($signature, $photoEnfant, $heureDepartTheorique, $heureArriveeTheorique, $heureDepartReelle, $heureArriveeReelle, $infoSupplementaire));
}

?>

<html>

<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <meta charset="UTF-8" />
    <title>Chauffeur</title>
    <link rel="stylesheet" media="screen" type="text/css" href="formulaire_arrive.css" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
</head>

<body class="body_formulaire">
    <form class="formulaire_arrive" method="POST" onsubmit="return validateForm();">
        <table>
            <tr>
                <td>
                    <label class="nom_element_formulaire_arrive">Nom de l'enfant :</label>
                    <input type="text" name="nom-enfant" value="<?php echo $_GET['nom']; ?>" readonly>
                </td>
            </tr>
            <tr>
                <td>
                    <label class="nom_element_formulaire_arrive">Prénom enfant :</label>
                    <input type="text" name="prenom-enfant" value="<?php echo $_GET['prenom']; ?>" readonly>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="heure_formulaire_arrive">
                        <div>
                            <label class="nom_element_formulaire_arrive">Heure de départ :</label>
                            <input type="time" name="heure-depart-theorique"
                                value="<?php echo $_GET['heure_depart'] . ':' . $_GET['minute_depart']; ?>" readonly>
                        </div>
                        <div>
                            <label class="nom_element_formulaire_arrive">Heure d'arrivée :</label>
                            <input type="time" name="heure-arrivee-theorique"
                                value="<?php echo $_GET['heure_arrivee'] . ':' . $_GET['minute_arrivee']; ?>" readonly>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="heure_formulaire_arrive">
                        <div>
                            <label class="nom_element_formulaire_arrive">Heure de départ :</label>
                            <input type="time" name="heure-depart-reelle" />
                        </div>
                        <div>
                            <label class="nom_element_formulaire_arrive">Heure d'arrivée :</label>
                            <input type="time" name="heure-arrivee-reelle" />
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="signature_formulaire_arrive">
                        <label class="nom_element_formulaire_arrive">Signature :</label>
                        <div>
                            <canvas name="signature" id="signatureCanvas"></canvas>
                        </div>
                    </div>
                    <button id="clearButton" type="button">Effacer</button>
                </td>
            </tr>

            <input type="hidden" id="signature_id" name="signature" />


            <tr>
                <td colspan="2" style="text-align: center">
                    <div class="text">
                        <label class="nom_element_formulaire_arrive">Et / ou</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div class="document_formulaire_arrive">
                        <label class="nom_element_formulaire_arrive">Photo :</label>
                        <div>
                            <input type="file" name="photo" id="photo" accept="image/*" />
                        </div>
                    </div>
                </td>
            </tr>

            <input type="hidden" id="photo_enfant_id" name="photo_enfant" />

            <tr>
                <td colspan="2">
                    <div class="depôt_formulaire_arrive">
                        <label class="nom_element_formulaire_arrive">Info supp sur la route :</label>
                        <div>
                            <textarea name="info-supplementaire" rows="3" style="width: 100%"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center">
                    <button id="ok-button" type="submit">OK</button>
                </td>
            </tr>
        </table>
    </form>
</body>
<script type="text/javascript" src="formulaire_arrive.js"></script>
<script type="text/javascript">
    function validateForm() {
        var heureDepartReelle = document.getElementsByName("heure-depart-reelle")[0].value;
        var heureArriveeReelle = document.getElementsByName("heure-arrivee-reelle")[0].value;
        var signature = document.getElementsByName("signature")[0].value;
        var photo = document.getElementsByName("photo")[0].value;

        // Vérifier si les champs liés à la date sont remplis
        if (heureDepartReelle === "" || heureArriveeReelle === "") {
            alert("Veuillez remplir les champs d'heure de départ et d'heure d'arrivée.");
            return false;
        }

        // Vérifier si la signature ou la photo est présente
        if (signature === "" && photo === "") {
            alert("Veuillez fournir une signature et/ou une photo.");
            return false;
        }

        // Vérifier si la signature est vide et qu'il n'y a pas d'image
        if (signature === "" && !photo) {
            alert("Veuillez fournir une signature et/ou une photo.");
            return false;
        }

        return true;
    }
</script>



</html>