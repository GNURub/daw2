The Cat Long!
===================


Proceso de **instalacion** del proyecto Web.

----------


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
# Foo
$ mysql -p -u[user] < final.sql
```

> **Tip:** La ruta el script se encuentra en **app**/**sql**/**final.sql**.


----------