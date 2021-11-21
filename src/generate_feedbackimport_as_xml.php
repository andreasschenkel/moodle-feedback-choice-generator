<?php
echo '<!------   Erste Zeile muss genau so aussehen              ---->' . PHP_EOL;
echo '<!------  <?xml version="1.0" encoding="UTF-8" ?>          ---->' . PHP_EOL;
echo '<!------  Leerzeichen zwischen " und ?                     ---->' . PHP_EOL;

require_once __DIR__ . '/../vendor/autoload.php';

use \DCarbone\XMLWriterPlus;

require_once __DIR__ . '/helper.php';

$helper = new helper();

/**
 * only for testing and developing purpose some examle options
 */
$optionsArray = ["Auswahlmöglichkeit Option 1", "Auswahlmöglichkeit Option 2", "Auswahlmöglichkeit Option 3", "Auswahlmöglichkeit Option 4",  "Auswahlmöglichkeit Option 5"];

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
