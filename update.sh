#!/bin/sh
#!/bin/bash
#!/usr/bin/perl
#!/usr/bin/tcl
#!/bin/sed -f
#!/usr/awk -f

echo "start"

find ./ -type f -exec chmod 664 {} \;
find ./ -type d -exec chmod 775 {} \;
chmod -R 555 ./update.sh;
chmod -R 777 ./protected/yiic;
chmod -R 777 ./www/assets/;
chmod -R 777 ./www/uploads/;
chmod -R 777 ./protected/runtime/;
#chmod -R 777 ./bash/;

chown -R saitis:saitis ./
chown -R root:root ./.hg

echo "finish"
