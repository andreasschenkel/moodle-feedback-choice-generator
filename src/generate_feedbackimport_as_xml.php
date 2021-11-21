<?php session_start() ?>
<!DOCTYPE HTML>
<html>
<body>



<?php
require_once __DIR__ . '/../vendor/autoload.php';
use \DCarbone\XMLWriterPlus;
require_once __DIR__ . '/helper.php';
echo '<!------   Erste Zeile muss genau so aussehen              ---->' . PHP_EOL;
echo '<!------  <?xml version="1.0" encoding="UTF-8" ?>          ---->' . PHP_EOL;
echo '<!------  Leerzeichen zwischen " und ?                     ---->' . PHP_EOL;
?>

<form action='generate_feedbackimport_as_xml.php' method='post'>

<?php
$option1 = trim($_POST["option1"]);
$option2 = trim($_POST["option2"]);
$option3 = trim($_POST["option3"]);
$option4 = trim($_POST["option4"]);
$option5 = trim($_POST["option5"]);

echo "Bisher eingegebene Optionen:<br>";
echo '$option1 ' . $option1 . "<br>";
echo '$option2 ' . $option2 . "<br>";
echo '$option3 ' . $option3 . "<br>";
echo '$option4 ' . $option4 . "<br>";
echo '$option5 ' . $option5 . "<br>";


echo "<p>Option 1:<input name='option1' value='$option1'></p>";
echo "<p>Option 2:<input name='option2' value='$option2'></p>";
echo "<p>Option 3:<input name='option3' value='$option3'></p>";
echo "<p>Option 4:<input name='option4' value='$option4'></p>";
echo "<p>Option 5:<input name='option5' value='$option5'></p>";
echo "<p><input type='submit'>";
echo "    <input type='reset'>";
echo "</p>";
echo "</form>";
echo "<br>";echo  "<br>";
echo 'Quellcode der Seite enthält den xml-Code ... todo: generiere xml-file';echo  "<br>";
echo 'Fehler in erster Zeile !!!!! Leerzeichen vor ? fehlt   <?xml version=\"1.0\" encoding=\"UTF-8\" ?>';   


$helper = new helper();

/**
 * only for testing and developing purpose some examle options
 */
$optionsArray = ["Auswahlmöglichkeit Option 1", "Auswahlmöglichkeit Option 2", "Auswahlmöglichkeit Option 3", "Auswahlmöglichkeit Option 4",  "Auswahlmöglichkeit Option 5"];
$optionsArray = ["$option1", "$option2", "$option3", "$option4",  "$option5"];

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
