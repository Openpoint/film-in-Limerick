Apache AUTH for dev site:

.htpass hashfile is in this directory to allow for user: letmein pass: pplease - don't forget to chmod 664
Custom in .htaccess:

AuthUserFile /your/local/path/.htpassword
AuthName "Gatekeeper"
AuthType Basic
require valid-user

SOLR

Drupal 7 (search API SOLR module) requires SOLR 5.4.1 (bugs in later and earlier version prevent functionality)
https://www.drupal.org/node/1999310
https://www.drupal.org/node/2502221
Copy the directory included with this readme: SOLR/server/solr/drupal/conf to [SOLR install dir]/server/solr/drupal/conf and create a new core called 'drupal'
Secure SOLR by your preferred method - easiest way is to create IP whitelist in [SOLR install dir]/server/etc/jetty.xml

XLS downloads

Various pages have a 'download' link for data in xls spreadsheet format. These links have rel=nofollow, but are a potential for abuse. If abnormal server load is detected please check these first and we will have to work around by disabling for anonymous users. (disabled for anon user by client request on 18/07/16)

MEMCACHE

Memcache module has been installed and configured for localhost on port 11211
Customisation as per module instructions done to [site-root]/sites/default/settings.php

SMTP authentication support
Module installed - please configure for your smtp service at /admin/config/system/smtp

SITE INFORMATION
Please adjust global site email at /admin/config/system/site-information
End user is Clare Murray from Innovate Limerick (061 221414). I recommend 'film@limerick.ie' but this will need to be co-ordinated with her and access to the account given.

UPDATE NOTIFICATIONS
Please configure for site maintainer at /admin/reports/updates/settings

WEBSITE CONTACT FORM
Adjust to required email address at /admin/structure/contact/edit/2

SEO
Add third party service verifications at /admin/config/search/verifications
Submit sitemap to third parties at admin/config/search/xmlsitemap/engines

GOOGLE ANALYTICS
configure at admin/config/system/googleanalytics for your account

RECAPTCHA
Create a Google recaptcha API key (https://www.google.com/recaptcha/admin) and enter details at /admin/config/people/captcha/recaptcha



