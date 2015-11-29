The Cat Long!
===================


Proceso de **instalacion** del proyecto Web.

----------
Para descargar el proyecto:

``` bash
$ git clone git@github.com:GNURub/daw2.git
```

o [descargar zip][1]

Requerimientos
-------------

> **Note:**

> - Apache2
> - PHP5
> - El modulo de apache mod_rewrite **Activado!!**

#### <i class="icon-folder-open"></i> Pon la raíz del proyecto en la raíz del servidor Apache

```sequence
/->/var/www/: Del proyecto web, apache root
/var/www/->/var/www/public:
/var/www/->/var/www/app:
/var/www/->/var/www/.htaccess:

```

#### <i class="icon-hdd"></i> Import de SQL script

Para importar la base de datos, simplemente vamos a la terminal.

``` bash
$ mysql -p -u[user] < final.sql
```

> **Tip:** La ruta el script se encuentra en **app**/**sql**/**final.sql**.


----------

> **Note: credenciales app**

> - Username: test
> - Password: 1234567890

  [1]: https://github.com/GNURub/daw2/archive/master.zip
