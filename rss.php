<?php

$status = exec("/var/www/html/dev/garage.sh status 2>&1");

?>
<?xml version="1.0" encoding="utf-8"?><rss version="2.0">
<channel>
<title>Garage status</title> 
<link>http:\/\/www.n5jlc.com</link>
<description></description>
<pubDate>Thu, 1 May 2008 17:03:32 -0800</pubDate>
<lastBuildDate>Thu, 1 May 2008 17:03:32 -0800</lastBuildDate>
<item><title><?= $status ?></title> <link>http:\/\/www.n5jlc.com</link>
<description>Garage status</description> <pubDate>Thu, 1 May 2008 17:03:32 -0800</pubDate>
</item></channel></rss>
