VERSION=$(shell head -n 1 zentao/VERSION)

all: 7z
7z:
	sudo ./lampp stop
	sudo rm -fr logs/*
	sudo rm -fr var/mysql/*.err
	sudo rm -fr var/mysql/ib*
	sudo mkdir .package
	sudo mv * .package
	sudo mv .package lampp
	sudo mv lampp/Makefile .
	sudo chmod a+rx lampp/start*
	sudo chmod a+rx lampp/start88
	sudo 7z a -sfx ZenTaoPMS.${VERSION}.linux.7z lampp
clean:
	sudo mv lampp lampp.bak
	sudo mv lampp.bak/* .
	sudo rm -fr *.7z
	sudo rm -fr lampp.bak
