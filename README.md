# moodle-feedback-choice-generator
Developing in progress

php src/generate_feedbackimport_as_xml.php 

generates the xml-code for the moodle feedback activity to be used as a first and second selection tool.

The options have to be entered directly in the file.


# Known bugs:
The generated code is missing on space in the first line:
wrong: <?xml version="1.0" encoding="UTF-8"?>
correct: <?xml version="1.0" encoding="UTF-8" ?>


# todo
- implement it as a moodle-plugin
- generate xml-output as file
- correct the missing space (maybe bug in moodle?)


# Version:
[[v1.0.0]] first version to start without webserver



