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