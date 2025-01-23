# MyPinterest

## Création de la VM 

### Initialisation de la vm
```bash
    mkdir mypinterestVM
    cd mypinterestVM
    vagrant init
```

#### Création du vagrantfile
    - Le Vagrantfile configure une machine virtuelle nommée `mypinterestVM`

#### Démarrer le conteneur 
```bash 
    docker-compose up --build  
```

### Mettre à jour le conteneur dans le local 
```bash
    docker cp symfony-backend:/var/www/html/. ./backend
```
### Mettre à jour la base de données avec le AppFixture
```bash
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
```
### Supprimer la version dans le dossier migrations/

### Ensuite faire en sorte que la base de données se remplit
```bash
    php bin/console doctrine:fixtures:load
```