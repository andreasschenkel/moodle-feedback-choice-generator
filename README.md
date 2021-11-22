# moodle-feedback-choice-generator
Developing in progress

php src/generate_feedbackimport_as_xml.php 

generates the xml-code for the moodle feedback activity to be used as a first and second selection tool.

The options have to be entered directly in the file.

![image](https://user-images.githubusercontent.com/31856043/142852012-b748d652-c6bc-4a97-befe-207a1617e1bc.png)

![image](https://user-images.githubusercontent.com/31856043/142852196-754b3c23-3edf-4c13-be00-a28af563d1fd.png)


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



