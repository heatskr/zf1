ZF1
===

Zend Framework 1.12 sample application

### Intialize

```console
$ git clone git@github.com:heatskr/zf1.git
$ cd zf1
$ make
```

### Apache 2

Virtual host example

```apache
<VirtualHost zend.local:80>
  ServerName: zend.local
  DocumentRoot: /path/to/zf1/public
  <Directory /path/to/zf1/public>
    Allow from all
  </Directory>
</VirtualHost>
```

