<?php
require_once __DIR__ . '/../vendor/autoload.php';

use \DCarbone\XMLWriterPlus;

class helper
{

     /**
      * @return string with all options without the $selectedoption
      * if $selectedoption is "" for first choice with ALL Options
      */
     function generateOptionsList($options, $selectedoption)
     {
          $htmloutput = '';
          $last = count($options) - 1;
          $counter = 0;
          foreach ($options as $option) {
               if ($option != $selectedoption) {
                    if ($counter != 0) {
                         $htmloutput = $htmloutput . "|";
                    }
                    $counter++;
                    $htmloutput = $htmloutput . $option . "\n";
               }
          }
          return $htmloutput;
     }

     /**
      * @param $xmlWriterPlus      
      * @param int $itemnumber     The number of the actual xml-component to be generated
      */
     function generateDocumentHeader($xmlWriterPlus, $itemnumber, $exportpath, $filename)
     {

          $exportfile = "$exportpath/$filename" . ".xml";
          $xmlWriterPlus->openMemory();
          if ($filename !== "") {
               $xmlWriterPlus->openURI($exportfile);
          } else {
               $xmlWriterPlus->openMemory();
          }

          $xmlWriterPlus->startDocument();
          $xmlWriterPlus->startElement('FEEDBACK');
          $xmlWriterPlus->startAttribute('VERSION');
          $xmlWriterPlus->text('200701');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('COMMENT');
          $xmlWriterPlus->text('XML-Importfile for mod/feedback');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startElement('ITEMS');

          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->startElement('ITEM');
          $xmlWriterPlus->startAttribute('TYPE');
          $xmlWriterPlus->text('info');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('REQUIRED');
          $xmlWriterPlus->text('0');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('ITEMID', "$itemnumber");
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('ITEMTEXT', '');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('ITEMLABEL', '');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('PRESENTATION', '1');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('OPTIONS', '');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('DEPENDITEM', '0');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('DEPENDVALUE', '');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->endElement();
          $xmlWriterPlus->text("\n");
     }

     /**
      * @param $xmlWriterPlus      
      * @param int $itemnumber     The number of the actual xml-component to be generated
      */
     function generatePagebreak($xmlWriterPlus, $itemnumber)
     {
          $xmlWriterPlus->startElement('ITEM');
          $xmlWriterPlus->startAttribute('TYPE');
          $xmlWriterPlus->text('pagebreak');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('REQUIRED');
          $xmlWriterPlus->text('0');
          $xmlWriterPlus->endAttribute();

          $xmlWriterPlus->writeCDataElement('ITEMID', "$itemnumber");
          $xmlWriterPlus->writeCDataElement('ITEMTEXT', '');
          $xmlWriterPlus->writeCDataElement('ITEMLABEL', '');
          $xmlWriterPlus->writeCDataElement('PRESENTATION', '');
          $xmlWriterPlus->writeCDataElement('OPTIONS', '');
          $xmlWriterPlus->writeCDataElement('DEPENDITEM', '0');
          $xmlWriterPlus->writeCDataElement('DEPENDVALUE', '');
          $xmlWriterPlus->endElement();
          $xmlWriterPlus->text("\n");
     }

     /**
      * @param integer $level      indicates if first choice oder second choise
      * @param $xmlWriterPlus      
      * @param int $itemnumber     The number of the actual xml-component to be generated
      * @param int $itemnumbererstwahl Number for to reference to in the second second choice
      * @param string $allOptionsToAdd  
      * @param string $option      DEPENDVALUE
      */
     function generateSelectionOverview($level, $xmlWriterPlus, $itemnumber, $itemnumbererstwahl, $allOptionsToAdd, $option)
     {
          if ($level === 1) {
               $wahlnummertext = '1. Wahl';
               $itemnumbererstwahl = 0;
          } else {
               $wahlnummertext = '2. Wahl';
          }
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->startElement('ITEM');
          $xmlWriterPlus->startAttribute('TYPE');
          $xmlWriterPlus->text('multichoice');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('REQUIRED');
          $xmlWriterPlus->text('0');
          $xmlWriterPlus->endAttribute();

          $xmlWriterPlus->writeCDataElement('ITEMID', "$itemnumber");
          $xmlWriterPlus->writeCDataElement('ITEMTEXT', "$wahlnummertext");
          $xmlWriterPlus->writeCDataElement('ITEMLABEL', "$wahlnummertext auswählen");
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('PRESENTATION', 'r>>>>>' . "$allOptionsToAdd");
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('OPTIONS', 'h');
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('DEPENDITEM', "$itemnumbererstwahl");
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->writeCDataElement('DEPENDVALUE', "$option");
          $xmlWriterPlus->endElement();
          $xmlWriterPlus->text("\n");
     }

     /**
      * @param $xmlWriterPlus      
      * @param int $itemnumber     The number of the actual xml-component to be generated
      * @param int $itemnumbererstwahl Number for to reference to in the second second choice
      * @param string $option      DEPENDVALUE
      */
     function generateLabel($xmlWriterPlus, $itemnumber, $itemnumbererstwahl, $option)
     {
          $xmlWriterPlus->text("\n");
          $xmlWriterPlus->startElement('ITEM');
          $xmlWriterPlus->startAttribute('TYPE');
          $xmlWriterPlus->text('label');
          $xmlWriterPlus->endAttribute();
          $xmlWriterPlus->startAttribute('REQUIRED');
          $xmlWriterPlus->text('0');
          $xmlWriterPlus->endAttribute();

          $xmlWriterPlus->writeCDataElement('ITEMID', "$itemnumber");
          $xmlWriterPlus->writeCDataElement('ITEMTEXT', '');
          $xmlWriterPlus->writeCDataElement('ITEMLABEL', '');
          $xmlWriterPlus->writeCDataElement('PRESENTATION', "$option als Erstwahl");
          $xmlWriterPlus->writeCDataElement('OPTIONS', '');
          $xmlWriterPlus->writeCDataElement('DEPENDITEM', "$itemnumbererstwahl");
          $xmlWriterPlus->writeCDataElement('DEPENDVALUE', "$option");
          $xmlWriterPlus->endElement();
     }

     /**
      * 
      */
     /*function generateOptionsListCompletexxxxxxx($options)
     {
          $htmloutput = '';
          $last = count($options) - 1;
          $counter = 0;
          foreach ($options as $option) {
               $htmloutput = $htmloutput . $option . "\n";
               if ($last != $counter) {
                    $htmloutput = $htmloutput . "|";
               }
               $counter++;
          }
          return $htmloutput;
     }*/
}
