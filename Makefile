VERSION=$(shell head -n 1 VERSION)

all: tgz
sae: tgz build4sae
linux: tgz build4linux

clean:
	rm -fr zentaopms
	rm -fr *.tar.gz
	rm -fr *.zip
	rm -fr api*
	rm -fr build/linux/lampp
tgz:
	# make the directories.
	mkdir -p zentaopms/lib
	mkdir -p zentaopms/db
	mkdir -p zentaopms/bin
	mkdir -p zentaopms/config
	mkdir -p zentaopms/www/data/upload
	mkdir -p zentaopms/tmp/cache
	mkdir -p zentaopms/tmp/log
	mkdir -p zentaopms/tmp/model
	mkdir -p zentaopms/tmp/extension
	# copy files.
	cp -fr framework zentaopms/
	cp -fr lib/ zentaopms/
	cp -fr config/config.php zentaopms/config/
	cp -fr module zentaopms/
	cp -fr www/*.ico www/fusioncharts www/*.php www/js www/*.txt www/theme www/.htaccess zentaopms/www
	cp bin/ztc* bin/computeburn.php bin/getbugs.php bin/initext.php bin/todo.php bin/convertopt.php zentaopms/bin
	cp -fr db zentaopms/
	cp -fr doc/* zentaopms/
	cp VERSION zentaopms/
	# create my.min.js
	rm zentaopms/www/js/my.min.js
	java -jar ~/bin/yuicompressor/build/yuicompressor-2.4.6.jar www/js/my.full.js > zentaopms/www/js/my.min.js
	# create the restart file for svn.
	touch zentaopms/module/svn/restart
	# touch the front.class.php to make it's mtime to new.
	touch zentaopms/lib/front/front.class.php
	# delee the unused files.
	find zentaopms -name .svn |xargs rm -fr
	find zentaopms -name tests |xargs rm -fr
	# change mode.
	chmod 777 -R zentaopms/tmp/
	chmod 777 -R zentaopms/www/data
	chmod 777 -R zentaopms/config
	chmod 777 zentaopms/module
	chmod a+rx zentaopms/bin/*
	find zentaopms/ -name ext |xargs chmod -R 777
	# zip it.
	zip -r -9 ZenTaoPMS.$(VERSION).zip zentaopms
	rm -fr zentaopms

patchphpdoc:
	sudo cp misc/doc/phpdoc/*.tpl /usr/share/php/data/PhpDocumentor/phpDocumentor/Converters/HTML/frames/templates/phphtmllib/templates/
phpdoc:
	phpdoc -d bin,framework,config,lib,module,www -t api -o HTML:frames:phphtmllib -ti ZenTaoPMSAPI�ο��ֲ� -s on -pp on -i *test*
	phpdoc -d bin,framework,config,lib,module,www -t api.chm -o chm:default:default -ti ZenTaoPMSAPI�ο��ֲ� -s on -pp on -i *test*
doxygen:
	doxygen misc/doc/doxygen/doxygen.conf
build4sae:	
	unzip ZenTaoPMS.$(VERSION).zip
	rm -fr ZenTaoPMS.$(VERSION).zip
	mv zentaopms/www/* zentaopms
	rm -fr zentaopms/data
	# replace the directory of index.php, install.php, upgrade.php.
	sed -e 's/..\/framework/framework/g' zentaopms/index.php |sed -e "s/dirname(//" |sed -e 's/)))/))/' >zentaopms/index.php.new
	sed -e 's/..\/framework/framework/g' zentaopms/install.php |sed -e "s/dirname(//" |sed -e 's/)))/))/' >zentaopms/install.php.new
	sed -e 's/..\/framework/framework/g' zentaopms/upgrade.php |sed -e "s/dirname(//" |sed -e 's/)))/))/' >zentaopms/upgrade.php.new
	mv zentaopms/index.php.new zentaopms/index.php
	mv zentaopms/install.php.new zentaopms/install.php
	mv zentaopms/upgrade.php.new zentaopms/upgrade.php
	# replace the error_log to sae_debug
	sed -e 's/error_log/sae_debug/g' zentaopms/framework/router.class.php | sed -e "s/saveSQL/saveSQL4SAE/" >zentaopms/framework/router.class.php.new
	mv zentaopms/framework/router.class.php.new zentaopms/framework/router.class.php
	cat build/sae/savesql.php >> zentaopms/framework/helper.class.php
	# change the logic of merge model file in helper.class.php.
	sed -e 's/\$$app->getTmpRoot/"saemc:\/\/" . \$$app\-\>getTmpRoot/g' zentaopms/framework/helper.class.php >zentaopms/framework/helper.class.new
	mv zentaopms/framework/helper.class.new zentaopms/framework/helper.class.php
	# touch the my.php.
	touch zentaopms/config/my.php
	# get the extension files.
	svn export https://svn.cnezsoft.com/easysoft/trunk/zentaoext/sae
	mv sae/lib/saestorage zentaopms/lib/
	cp -fr sae/* zentaopms/module/
	# create the package.
	mkdir 10
	mv zentaopms 10/code
	cp build/sae/config.yaml 10/
	zip -r -9 ZenTaoPMS.$(VERSION).sae.zip 10
	rm -fr sae
	rm -fr 10
build4linux:	
	unzip ZenTaoPMS.$(VERSION).zip
	rm -fr ZenTaoPMS.$(VERSION).zip
	sed -e 's/index.php/\/zentao\/index.php/g' zentaopms/www/.htaccess >zentaopms/www/.htaccess.new
	mv zentaopms/www/.htaccess.new zentaopms/www/.htaccess
	# build xmapp.
	cd ./build/linux/ && ./buildxmapp.sh $(xampp)
	mv ./build/linux/lampp ./
