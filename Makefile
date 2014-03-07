all: translate config cache
translate: data/locales/pt_BR/messages.mo
data/locales/pt_BR/messages.mo: data/locales/pt_BR/messages.po
	msgfmt -o data/locales/pt_BR/messages.mo data/locales/pt_BR/messages.po
config:
	rm -rf data/tmp/*.tmp
cache:
	rm -rf data/cache/*
