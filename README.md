# moodle-feedback-choice-generator
Developing in progress

php src/generate_feedbackimport_as_xml.php 

generates the xml-code for the moodle feedback activity to be used as a first and second selection tool.

The options have to be entered directly in the file.

![image](https://user-images.githubusercontent.com/31856043/142907001-fda899b3-c9ca-443a-9e42-92b719e641ea.png)


# Known bugs:
The generated code is missing on space in the first line:
wrong: <?xml version="1.0" encoding="UTF-8"?>
correct: <?xml version="1.0" encoding="UTF-8" ?>


# todo
- implement it as a moodle-plugin
- generate xml-output as file
- correct the missing space (maybe bug in moodle?)


# Version:
[[v2.1.0]]
- supports export into textarea or into file

[[v2.0.0]]
- support of usage with webserver
- reset-option
- use as many options as needed

[[v1.0.0]] 
first version to start without webserver



