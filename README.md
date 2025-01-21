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

    - dans backend/: 
```bash
    docker build -t symfony-backend:v1 .
```

    - dans frontend/: 
```bash
    docker build -t angular-frontend:v1 .
```