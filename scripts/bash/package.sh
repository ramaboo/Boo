#!/bin/bash
cd /var/www/
tar -cvzf  Boo-2.0.0.tar.gz --exclude=.svn --exclude=.cache --exclude=.project --exclude=.settings Boo-2.0.0
chmod 777 /var/www/Boo-2.0.0.tar.gz