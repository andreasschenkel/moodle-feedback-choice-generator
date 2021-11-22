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
          // Setzen der Inhalte in die Felder
          for ($i = 1; $i <= (int)$size; $i++) {
               $_SESSION['option'][$i] = trim($_POST["option$i"]);
          }

          // Anzahl der Eingabefelder
          echo "<p>How many Options 3-10:<input name='size' value='$size'></p>";

          // Die gewünschte Anzahl der Eingabefelder anlegen
          for ($i = 1; $i <= (int)$size; $i++) {
               //auslesen der Werte
               $option_i = $_SESSION['option'][$i];
               echo "Option $i:<input name='option$i' value='$option_i'></br>";
          }

          echo "<p><input type='submit' value='Generiere XML'>";
          echo "</p>";
          echo "</form>";
          echo "<br>";


          if (!isset($_SESSION['visited'])) {
               $_SESSION['visited'] = true;
               echo "Session wurde neu begonnen.";
          } else {
               //echo "bestehende Session genutzt";
               echo "<a href='reset.php'>Session zurücksetzen</a>";
               echo  "<br>";
          }

          echo  "<br>";
          echo 'Quellcode der Seite enthält den xml-Code ... todo: generiere xml-file';
          echo  "<br>";
          echo 'Fehler in erster Zeile !!!!! Leerzeichen vor ? fehlt   <?xml version=\"1.0\" encoding=\"UTF-8\" ?>';

          $helper = new helper();

          /**
           * only for testing and developing purpose some examle options
           */
          //$optionsArray = ["Auswahlmöglichkeit Option 1", "Auswahlmöglichkeit Option 2", "Auswahlmöglichkeit Option 3", "Auswahlmöglichkeit Option 4",  "Auswahlmöglichkeit Option 5"];

          $optionsArray = $_SESSION['option'];

          // define the itemnumber to start with (maybe later I will set it to 1 instead of 680)
          $itemnumber = 367;

          // we need $itemnumberFirstChoice as reference for the second choice
          $itemnumberFirstChoice = $itemnumber + 1;

          // A. head of document
          $xmlWriterPlus = new XMLWriterPlus();
          $xmlWriterPlus->openMemory();
          $xmlWriterPlus->startDocument();
          $xmlWriterPlus->startElement('FEEDBACK');
          $xmlWriterPlus->startAttribute('VERSION');
          $xmlWriterPlus->text('200701');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('COMMENT');
          $xmlWriterPlus->text('XML-Importfile for mod/feedback');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startElement('ITEMS');

          $helper->generateDocumentHeader($xmlWriterPlus, $itemnumber);

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

          echo $xmlWriterPlus->outputMemory();
