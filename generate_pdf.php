<?php
require 'vendor/autoload.php'; // Include the Dompdf library

use Dompdf\Dompdf;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["gedicht"])) {
    $message = $_POST["gedicht"];

    // Start building the HTML for Dompdf
    $html = "<html><head><style>
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
                body {
                    font-family: Arial, sans-serif;
                }
            </style></head><body><div class='gedicht-container'><div class='gedicht'>";

    // Split the message into individual characters
    $characters = str_split($message);
    
    foreach ($characters as $character) {
        if ($character === ' ') {
            // Handle spaces
            $html .= "<span class='space'>&nbsp;</span>";
        } else {
            // Generate random RGB values for each character
            $r = mt_rand(0, 255);
            $g = mt_rand(0, 255);
            $b = mt_rand(0, 255);

            // Generate a random font size
            $fontSize = mt_rand(20, 50); // Random font size

            // Generate a random rotation
            $rotation = mt_rand(-30, 30); // Random rotation

            // Random opacity
            $opacity = mt_rand(50, 100) / 100; // Random opacity

            // Apply random styles to each character
            $randomColor = sprintf("rgb(%d, %d, %d)", $r, $g, $b);

            $html .= "<span class='character' style='
                        color: $randomColor;
                        font-size: {$fontSize}px;
                        transform: rotate({$rotation}deg);
                        opacity: {$opacity};
                      '>$character</span>";
        }
    }

    $html .= "</div></div></body></html>";

    // Instantiate Dompdf and load the HTML content
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);

    // Set paper size
    $dompdf->setPaper('A4', 'portrait');

    // Render the PDF
    $dompdf->render();

    // Output the generated PDF (stream it to the browser)
    $dompdf->stream("gedicht.pdf", array("Attachment" => 0)); // 0 for inline, 1 for download
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gedicht PDF</title>
</head>

<body>
    <!-- Form to input text -->
    <form action="" method="POST">
        <textarea name="gedicht" placeholder="Typ hier je gedicht" rows="6" cols="30"><?= isset($message) ? $message : '' ?></textarea><br>
        <input type="submit" value="Preview & Generate PDF">
    </form>

    <!-- Display the preview if a message is set -->
    <?php if (isset($message)): ?>
        <div class="gedicht-container">
            <div class="gedicht">
                <?php
                // Split the message into individual characters and apply random styles
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
        </div>
    <?php endif; ?>
</body>

</html>
