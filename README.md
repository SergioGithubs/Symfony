"# symfony-ejemplo-4.4" 

# Comprobar dependencías

```bash
symfony check:requirements
```

# Instalación de bundles

## orm doctrine
```bash
composer require symfony/orm-pack
composer require --dev symfony/maker-bundle
```

## Receta para instalar jms/serializer-bundle:
Este es un paquete contribuido, para poder usarlo hay que permitirle a 
Symfony Flex para que lo use, si no lo hemos hecho anteriormente
```bash
composer config extra.symfony.allow-contrib true
```
## Luego ejecutar este comando
```bash
composer require jms/serializer-bundle
```

## Receta para instalar friendsofsymfony/rest-bundle:
```bash
composer require friendsofsymfony/rest-bundle
```

## Receta para instalar el componente Twig de Symfony
```bash
composer req twig
```

## Instalar componente Asset de Symfony
```bash
composer require symfony/asset
```

## Creando las primeras entidades
```bash
php bin/console make:entity
```

## Creando la BBDD
```bash
sudo apt-get install php-sqlite3
php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate 
```

## Arrancando el servidor
symfony server:start


