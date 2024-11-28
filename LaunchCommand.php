<?php

echo(dirname(__FILE__)."/logs.txt"."\n");
file_put_contents(dirname(__FILE__)."/logs.txt", "exec1");
shell_exec('/usr/local/php8.2/bin/php '.dirname(__FILE__).'/bin/console'.' app:sendEmailAfterBuy');
shell_exec('/usr/local/php8.2/bin/php '.dirname(__FILE__).'/bin/console'.' app:sendBookEmail');
shell_exec('/usr/local/php8.2/bin/php '.dirname(__FILE__).'/bin/console'.' app:removeExpiredToken');