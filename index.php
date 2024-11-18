<?php
// Traitement des données pour le serveur PHP (Conversion de devises)
$montant = $_POST['montant'] ?? 0;
$taux = $_POST['taux'] ?? 1;

function convertirDevise($montant, $taux) {
    return $montant * $taux;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Interactive PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
            overflow: hidden;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            text-align: center;
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background: #0056b3;
        }
        .horloge {
            font-size: 1.5em;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue sur ma page interactive</h1>

        <h2>Horloge en direct</h2>
        <div id="horloge" class="horloge">Chargement...</div>

        <h2>Météo</h2>
        <form id="meteoForm">
            <label for="ville">Entrez une ville :</label>
            <input type="text" id="ville" name="ville" placeholder="Ex: Paris" required>
            <button type="submit">Voir la météo</button>
        </form>
        <p id="resultatMeteo">Veuillez entrer une ville pour voir la météo.</p>

        <h2>Conversion de devises</h2>
        <form method="POST">
            <label for="montant">Montant en euros :</label>
            <input type="number" id="montant" name="montant" placeholder="Ex: 100" step="0.01">
            <label for="taux">Taux de conversion (ex: 1.1 pour USD) :</label>
            <input type="number" id="taux" name="taux" placeholder="Ex: 1.1" step="0.01">
            <button type="submit">Convertir</button>
        </form>
        <p>Montant converti : <strong><?= convertirDevise($montant, $taux); ?> unités</strong></p>
    </div>

    <script>
        // Horloge en direct
        function actualiserHorloge() {
            const horlogeElement = document.getElementById('horloge');
            const maintenant = new Date();
            horlogeElement.textContent = maintenant.toLocaleTimeString('fr-FR');
        }
        setInterval(actualiserHorloge, 1000); // Actualiser chaque seconde
        actualiserHorloge(); // Appeler immédiatement

        // Météo en utilisant OpenWeatherMap
        const apiKey = "6679d0c4c602bb822d14603b613d8388"; // Remplace TA_CLE_API par ta clé OpenWeatherMap
        document.getElementById('meteoForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Empêche le rechargement de la page
            const ville = document.getElementById('ville').value;
            const resultatMeteo = document.getElementById('resultatMeteo');
            
            resultatMeteo.textContent = "Chargement...";
            fetch(`https://api.openweathermap.org/data/2.5/weather?q=${ville}&units=metric&lang=fr&appid=${apiKey}`)
                .then(response => response.json())
                .then(data => {
                    if (data.cod === 200) {
                        const description = data.weather[0].description;
                        const temperature = data.main.temp;
                        resultatMeteo.textContent = `À ${ville}, il fait ${description} avec une température de ${temperature}°C.`;
                    } else {
                        resultatMeteo.textContent = `Erreur : ${data.message}`;
                    }
                })
                .catch(error => {
                    resultatMeteo.textContent = "Une erreur est survenue. Veuillez réessayer.";
                    console.error("Erreur :", error);
                });
        });
    </script>
</body>
</html>
