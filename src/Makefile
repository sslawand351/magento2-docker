up:
	bin/magento s:up
	bin/magento s:d:c

wp: 
	chown -R 1000:1000 .
	chmod -R 777 var generated app/etc pub/media
	rm -rf var/cache/* var/page_cache/* var/generation/*

db-whitelist:
	bin/magento setup:db-declaration:generate-whitelist --module-name=Adapty_Blog