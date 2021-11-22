<?php
session_start();
session_destroy();
echo "Logout erfolgreich";
echo "<br>";
echo "<a href=\"generate_feedbackimport_as_xml.php\">zurück zur Eingabe</a>";
echo "<br>";

?>