This repo contains the RHAPSODY website.

* Installation:
  - Install rhapsody from git or pip
  - run rhapsody.initialSetup() to configure the program
  - run bin/config.sh to configure the right Python version

* To test locally:
  $ php -S localhost:8000
  $ firefox http://localhost:8000/

* check configuration by visiting the webpage:
  http://rhapsody.csb.pitt.edu/phpinfo.php

* check memory limits in php.ini file:
  $ sudo vi /etc/php/7.0/apache2/php.ini
  then edit lines:
    post_max_size = 25M
    upload_max_filesize = 25M

* if needed, restart apache server with:
  $ sudo apachectl graceful

* log files are usually located in: /var/log/apache2
