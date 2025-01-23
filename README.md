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