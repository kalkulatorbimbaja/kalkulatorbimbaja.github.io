<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>eFootball Defender Calculator</title>
    <!-- Dodaj linki do Bootstrap (CSS i JS) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }

        #welcome-banner {
            text-align: center;
            background-color: #f0f0f0;
            padding: 10px;
        }

        #welcome-banner img {
            max-width: 100%;
            height: auto;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        #calculator {
            max-width: 800px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin: 10px 0;
        }

        .form-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: -10px;
        }

        .column {
            flex: calc(48% - 5px);
            margin-bottom: 10px;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
        }

        button {
            display: block;
            margin: 20px auto;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }

        #result {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
        }

        /* Dodaj kolorowanie do formy */
        #form option[value="C"] {
            color: #FFD700; 
        }

        #form option[value="B"] {
            color: #FFFF00; 
        }

        #form option[value="A"] {
            color: #7FFF00;
        }

        /* Dodaj styl do linków */
        #social-links {
            text-align: center;
            margin-top: 10px;
        }

        #social-links a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        #social-links a:hover {
            color: #4CAF50;
        }

        /* Dodaj styl do linków */
        #local-links {
            text-align: center;
            margin-top: 10px;
        }

        #local-links a {
            margin: 0 10px;
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }

        #local-links a:hover {
            color: #4CAF50;
        }

        /* Dodaj styl do tabeli */
        #vip-table {
            margin-top: 20px;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }

        #vip-table table {
            width: 100%;
            border-collapse: collapse;
        }

        #vip-table th, #vip-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #vip-table th {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Dodaj baner powitalny -->
    <div id="welcome-banner">
        <a>
            <img src="pic.jpg" alt="Welcome Banner">
        </a>
        <!-- Dodaj linki do social media -->
        <div id="social-links">
            <a href="https://www.twitch.tv/coach_bimbaj" target="_blank">Twitch</a>
            <a href="https://www.youtube.com/@Coach_Bimbaj" target="_blank">YouTube</a>
            <a href="https://discord.com/invite/PuRtWtAjeh" target="_blank">Discord</a>
        </div>
        <div id="local-links">
            <a href="http://coachbimbaj.cba.pl/index.html">Defenders</a>
            <a href="http://coachbimbaj.cba.pl/home.html">Skills</a>
        </div>
    </div>

    <div id="vip-table">
        <h2 class="mt-5">Vip dnia</h2>
        <?php
        $servername = "127.0.0.1";
        $username = "coachbimbaj";
        $password = "AraujoTopCB1";
        $dbname = "coachbimbaj";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT nick, vip FROM Vipdnia";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Nick</th><th>vip</th></tr></thead>";
            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["nick"]. "</td><td>" . $row["vip"]. "</td></tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "0 results";
        }
        $conn->close();
        ?>
    </div>

</body>
</html>
