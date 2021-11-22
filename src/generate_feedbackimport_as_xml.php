<?php session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/helper.php';

use \DCarbone\XMLWriterPlus;
?>

<!DOCTYPE HTML>
<html>

<body>

     <?php
     echo '<!------   Erste Zeile muss genau so aussehen              ---->' . PHP_EOL;
     echo '<!------  <?xml version="1.0" encoding="UTF-8" ?>          ---->' . PHP_EOL;
     echo '<!------  Leerzeichen zwischen " und ?                     ---->' . PHP_EOL;

     ?>

     <form action='generate_feedbackimport_as_xml.php' method='post'>

          <?php
          $size = trim($_POST["size"]);
          if ($size === '') {
               $size = 5;
          }

          $filename = trim($_POST["filename"]);


          // Setzen der Inhalte in die Felder
          for ($i = 1; $i <= (int)$size; $i++) {
               $_SESSION['option'][$i] = trim($_POST["option$i"]);
          }

          echo "<h2>1. Wahl und 2. Wahl</h2>";
          echo "<h3>Ein Generator für die Aktivität Feedback</h3>";

          // Anzahl der Eingabefelder
          echo "<p>Anzahl der Optionen: <input name='size' value='$size'></p>";
          // Dateiname, falls export in Datei gewünscht
          echo "<p>Dateiname (wenn leer, dann wird in die HTML-Seite generiert): <input name='filename' value='$filename'>.xml</p>";

          // Die gewünschte Anzahl der Eingabefelder anlegen
          for ($i = 1; $i <= (int)$size; $i++) {
               $option_i = $_SESSION['option'][$i];
               echo "Option $i: <input name='option$i' value='$option_i'></br>";
          }

          echo "<p><input type='submit' value='Generiere XML'>";
          echo "</p>";
          echo "</form>";
          echo "<br>";


          if (!isset($_SESSION['visited'])) {
               $_SESSION['visited'] = true;
               echo "Session wurde neu begonnen.<br><br>";
          } else {
               echo "<a href='reset.php'>Session zurücksetzen</a><br><br>";
          }
          if ($filename !== '') {
               $exportfile = "../exports/$filename" . ".xml";
               echo "<a href='$exportfile'>Generierte Datei anzeigen oder download</a><br>";
          } else {
               echo 'Der xml-Quellcode wurde in diese HTML-Seite hineingeneriert und kann über "Quellcode anzeigen" in eine Datei kopiert und als xml-File gespeichert werden.<br><br>';
               echo 'Fehler in erster Zeile !!!!! Leerzeichen vor ? fehlt   <?xml version=\"1.0\" encoding=\"UTF-8\" ?><br><br>';
          }

          echo '<textarea id="textarea" name="textarea" rows="50" cols="100">';
          $helper = new helper();

          // only for testing and developing purpose some examle options
          // $optionsArray = ["Auswahlmöglichkeit Option 1", "Auswahlmöglichkeit Option 2", "Auswahlmöglichkeit Option 3", "Auswahlmöglichkeit Option 4",  "Auswahlmöglichkeit Option 5"];
          $optionsArray = $_SESSION['option'];

          // define the itemnumber to start with (maybe later I will set it to 1 instead of 680)
          $itemnumber = 367;

          // we need $itemnumberFirstChoice as reference for the second choice
          $itemnumberFirstChoice = $itemnumber + 1;

          $exportpath = "../exports/";


          $xmlWriterPlus = new XMLWriterPlus();


          // A. head of document
          $helper->generateDocumentHeader($xmlWriterPlus, $itemnumber, $exportpath, $filename);

          // B. generate first choice
          $selectedoption = "alleOptionenNutzenFürErstwahl"; // bei der erstwahl ist keine auswahl vorhanden, also werden dann einfach alle genutzt
          $level = 1; // first selectionoverview with all options
          $helper->generateSelectionOverview(
               $level,
               $xmlWriterPlus,
               ++$itemnumber,
               $itemnumberFirstChoice,
               $helper->generateOptionsList($optionsArray, $selectedoption),
               $option
          );

          // C. generate pagebreak to seperate first choice
          $helper->generatePagebreak($xmlWriterPlus, ++$itemnumber);

          // D. generate second choice
          foreach ($optionsArray as $option) {
               $xmlWriterPlus->text("\n");
               $helper->generateLabel($xmlWriterPlus, ++$itemnumber, $itemnumberFirstChoice, $option);
               $selectedoption = $option;
               $level = 2; // second selectionoverview
               $helper->generateSelectionOverview(
                    $level,
                    $xmlWriterPlus,
                    ++$itemnumber,
                    $itemnumberFirstChoice,
                    $helper->generateOptionsList($optionsArray, $selectedoption),
                    $option
               );

               $helper->generatePagebreak($xmlWriterPlus, ++$itemnumber);
          }
          $xmlWriterPlus->endElement(); // Items
          $xmlWriterPlus->endElement(); // Feedback

          if ($filename !== '') {
               $xmlWriterPlus->flush();
          } else {
               echo $xmlWriterPlus->outputMemory();
          }


          ?>

</textarea>         
</body>

</html>