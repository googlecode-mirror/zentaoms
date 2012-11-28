tar zxvf $1/xampp.tar.gz
cd lampp

# rm useless files.
rm -fr RELEASENOTES
rm -fr  error
rm -fr icons
rm -fr logs/*
rm -fr htdocs/*
rm -fr cgi-bin
rm -fr libexec
rm -fr php
rm -fr tmp/*
chmod -R 777 tmp

# rm useless settings.
rm -fr etc/proftpd.conf
rm -fr etc/webalizer.conf*
rm -fr etc/freetds.conf
rm -fr etc/openssl.cnf
rm -fr etc/php.ini-pre1.7.2
rm -fr etc/pear.conf
rm -fr etc/pool.conf
rm -fr etc/openldap
rm -fr etc/original
rm -fr etc/httpd.conf.bak
rm -fr etc/lampp/startftp
rm -fr etc/ssl*
rm -fr etc/extra/httpd-dav.conf
rm -fr etc/extra/httpd-info.conf
rm -fr etc/extra/httpd-manual.conf
rm -fr etc/extra/httpd-ssl.conf
rm -fr etc/extra/httpd-manual.conf
rm -fr etc/extra/httpd-userdir.conf
rm -fr etc/extra/httpd-multilang-errordoc.conf
rm -fr etc/lampp/startssl

# process httpd conf
cp ../httpd.conf etc/httpd.conf

# process my.cnf
grep -v '^innodb' etc/my.cnf| \
sed -e 's/#skip-innodb/default-storage-engine=MyISAM\nskip-innodb/' | \
grep -v '^#' | \
grep -v '^$' > etc/my.cnf.new
mv etc/my.cnf.new etc/my.cnf

# process php.ini
echo 'zend_extension = /opt/lampp/lib/php/extensions/no-debug-non-zts-20100525/ioncube_loader_lin_5.4.so' > etc/php.ini.new
grep -v '^;' etc/php.ini |\
grep -v '^$' |\
grep -v 'sqlite.so' |\
grep -v 'radius.so' |\
grep -v 'pgsql.so' |\
grep -v 'ming.so' |\
grep -v 'ncurses.so' >> etc/php.ini.new 
mv etc/php.ini.new etc/php.ini

# rm useless binaries.
mv bin bin.bak
mkdir bin
cd bin.bak 
cp htpasswd apachectl apxs my_print_defaults mysql mysql.server mysqld_safe mysqldump php php-config phpize httpd ../bin/
cd ../
rm -fr bin.bak

# fix bug of the mysqld_safe
sed -e 's/\/opt\/lampp\/\/opt\/lampp\/sbin/\/opt\/lampp\/sbin/g' bin/mysqld_safe > bin/mysqld_safe.new
mv bin/mysqld_safe.new bin/mysqld_safe
chmod a+rx bin/mysqld_safe

# rm useless binaries at sbin directory, keep mysqld.
mv sbin sbin.bak
mkdir sbin
mv sbin.bak/mysqld sbin/
rm -fr sbin.bak

# process share directory. keep english and lampp directory.
mv share share.bak
mkdir share
mv share.bak/english share/
mv share.bak/lampp share
echo >share/lampp/allons
rm -fr share.bak

rm -fr share/lampp/alladdons
touch share/lampp/alladdons
chmod a+rx share/lampp/alladdons

# process lib directory.
mv lib/php/extensions lib/phpextensions
rm -fr lib/php
mkdir lib/php
mv lib/phpextensions lib/php/extensions
rm -fr lib/php/extensions/no-debug-non-zts-20090626/interbase.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/ming.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/ncurses.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/oci8.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/pgsql.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/radius.so
rm -fr lib/php/extensions/no-debug-non-zts-20090626/sqlite.so
rm -fr lib/perl5
rm -fr lib/proftpd
rm -fr lib/fonts
rm -fr apr-util-1
rm -fr apr.exp
rm -fr aprutil.exp
rm -fr engines
rm -fr fips_premain.c
rm -fr fips_premain.c.sha1
rm -fr gettext
rm -fr icu
rm -fr libapr-1*
rm -fr libapreq2*
rm -fr libdb.so.3
rm -fr libform.so*
rm -fr libicule.so*
rm -fr libiculx.*
rm -fr libicutu.*
rm -fr liblber*
rm -fr libldap_r*
rm -fr libmcrypt
rm -fr libmenu.so*
rm -fr libming.so*
rm -fr libmysqlclient.*
rm -fr libncurses.so*
rm -fr libpanel.so*
rm -fr libpbmscl.so*
rm -fr libpng.so*
rm -fr libsablot.so*
rm -fr libsqlite*
rm -fr libtds.so*
rm -fr libtdssrv.so*
rm -fr libxslt-plugins
rm -fr libzzip-0*
rm -fr libzzipwrap*
rm -fr pkgconfig
rm -fr plugin
rm -fr stjR6sfX
rm -fr terminfo
rm -fr xml2Conf.sh
rm -fr xsltConf.sh

# process var directory.
rm -fr var/perl
rm -fr var/proftpd*
rm -fr var/mysql/cdcol
rm -fr var/mysql/*.err
rm -fr var/mysql/ib*
rm -fr var/mysql/test
chmod -R 777 var/mysql

# process modules directory.
rm -fr modules/mod_perl.so
rm -fr modules/mod_actions.so
rm -fr modules/mod_asis.so
rm -fr modules/mod_authn_dbm
rm -fr modules/mod_authn_anon
rm -fr modules/mod_authn_dbd
rm -fr modules/mod_authn_default
rm -fr modules/mod_authz_dbm.so
rm -fr modules/mod_authz_default.so
rm -fr modules/mod_authz_groupfile.so
rm -fr modules/mod_authz_owner.so
rm -fr modules/mod_bucketeer.so
rm -fr modules/mod_cache*
rm -fr modules/mod_case**
rm -fr modules/mod_cern_meta.so
rm -fr modules/mod_cgi*
rm -fr modules/mod_charset_lite.so
rm -fr modules/mod_dav*.so
rm -fr modules/mod_dbd.so
rm -fr modules/mod_disk_cache.so
rm -fr modules/mod_dumpio.so
rm -fr modules/mod_ext_filter.so
rm -fr modules/mod_file_cache.so
rm -fr modules/mod_headers.so
rm -fr modules/mod_ident.so
rm -fr modules/mod_imagemap.so
rm -fr modules/mod_include.so
rm -fr modules/mod_info.so
rm -fr modules/mod_ldap.so
rm -fr modules/mod_log*.so
rm -fr modules/mod_mem_cache.so
rm -fr modules/mod_negotiation.so
rm -fr modules/mod_proxy*
rm -fr modules/mod_reqtimeout.so
rm -fr modules/mod_speling.so
rm -fr modules/mod_ssl.so
rm -fr modules/mod_status.so
rm -fr modules/mod_substitute.so
rm -fr modules/mod_suexec.so
rm -fr modules/mod_unique_id.so
rm -fr modules/mod_userdir.so
rm -fr modules/mod_usertrack.so
rm -fr modules/mod_version.so

# copy customized xmapp config to etc/extra
cp ../zentao.conf etc/extra/httpd-xampp.conf

# copy the zentao code.
mv ../../../zentaopms ./zentao

# copy needed files.
cp ../Makefile .
cp ../start .
cp ../start88 .
cp ../stop .
cp ../../windows/xampp/index.php htdocs/

# make the auth file
mkdir auth
touch auth/users
echo 'use "../bin/htpasswd -b users username password" to add a new user.' > auth/readme

# process the phpmyadmin
7z x $1/phpmyadmin.7z
mkdir admin
mv phpMyAdmin-3.5.4-all-languages admin/phpmyadmin
mv admin/phpmyadmin/locale admin/phpmyadmin/locale.bak
mkdir admin/phpmyadmin/locale
mv admin/phpmyadmin/locale.bak/en_GB admin/phpmyadmin/locale
mv admin/phpmyadmin/locale.bak/zh_* admin/phpmyadmin/locale
rm -fr admin/phpmyadmin/locale.bak
cp ../phpmyadmin.php admin/phpmyadmin/config.inc.php

# copy the ioncube loader.
cp ../ioncube_loader_lin_5.4.so lib/php/extensions/no-debug-non-zts-20100525/
