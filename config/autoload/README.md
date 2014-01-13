About this directory:
=====================

By default, this application is configured to load all configs in
`./config/autoload/{,*.}{global,local}.php`. Doing this provides a
location for a developer to drop in configuration override files provided by
modules, as well as cleanly provide individual, application-wide config files
for things like database connections, etc.



Import the schemas for ZfcUser (./vendor/zf-commons/zfc-user/data/schema.sql) and ScnSocialAuth (./vendor/socalnick/scn-social-auth/data/schema.sql).



This application use social network as login lib, it requires:
		"zendframework/zendframework": "2.2.*",
        "zf-commons/zfc-base": "0.*",
        "zf-commons/zfc-user": "dev-master",
        "hybridauth/hybridauth": "dev-master",
        "socalnick/scn-social-auth": "dev-master"
login link is: /user/login



It also needs:

1. local.php (same as local.php.dist with correct username and password)
2. scn-social-auth.local.php (with facebook clientid and secret)
