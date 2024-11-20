<?php
echo "<div class='main-container'>";
// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gedicht"])) {
    $message = $_POST["gedicht"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gedicht</title>
    <style>
        .gedicht-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .gedicht {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
            margin-top: 15px;
            max-width: 90%;
        }

        .character {
            display: inline-block;
            padding: 0;
            margin: 0;
            text-align: center;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease;
        }

        .character:hover {
            transform: rotate(360deg) scale(1.2);
            opacity: 1;
        }

        .space {
            display: inline-block;
            width: 10px;
            height: 1px;
        }

        /* General body and HTML styling */
        html,
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            height: 100%;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(45deg, #ff7e5f, #feb47b);
        }

        /* Styling for the form */
        form.gedicht {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);

        }

        .gedicht-input {
            width: 80%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
            transition: border 0.3s ease;
            height: 45vh;
        }

        .gedicht-submit {
            padding: 10px 20px;
            background-color: #ff7e5f;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .gedicht-submit:hover {
            background-color: #feb47b;
        }

        .pdf-form {
            margin-top: 15px;
        }

        .pdf-button {
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .pdf-button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <!-- Form to input text -->
    <form class="gedicht" action="gedicht.php" method="POST">
        <textarea name="gedicht" class="gedicht-input" placeholder="Typ hier je gedicht"><?= isset($message) ? $message : '' ?></textarea>
        <input type="submit" class="gedicht-submit" value="Preview">
    </form>

    <!-- Display the preview -->
    <?php if (isset($message)): ?>
        <div class="gedicht-container">
            <div class="gedicht">
                <?php
                // Split the message into individual characters
                $characters = str_split($message);
                foreach ($characters as $character) {
                    if ($character === ' ') {
                        // Render space
                        echo "<span class='space'>&nbsp;</span>";
                    } else {
                        // Apply random styles
                        $r = mt_rand(0, 255);
                        $g = mt_rand(0, 255);
                        $b = mt_rand(0, 255);
                        $fontSize = mt_rand(20, 50); // Random font size
                        $rotation = mt_rand(-30, 30); // Random rotation
                        $opacity = mt_rand(50, 100) / 100; // Random opacity
                        $randomColor = sprintf("rgb(%d, %d, %d)", $r, $g, $b);

                        echo "<span class='character' style='
                                color: $randomColor;
                                font-size: {$fontSize}px;
                                transform: rotate({$rotation}deg);
                                opacity: {$opacity};
                              '>$character</span>";
                    }
                }
                ?>
            </div>

            <!-- Button to generate PDF -->
            <form class="pdf-form" action="generate_pdf.php" method="POST">
                <input type="hidden" name="gedicht" value="<?= htmlspecialchars($message) ?>">
                <input type="submit" class="pdf-button" value="Generate PDF">
            </form>
        </div>
    <?php endif; ?>

    </div>
</body>

</html>