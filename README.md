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
    - dans backend/: 
```bash
    docker build -t symfony-backend:v1 .
```
```bash
    docker run -d -p 8080:80 --name backend symfony-backend:v1
```
    - dans frontend/: 
```bash
    docker build -t angular-frontend:v1 .
```
```bash
    docker run -d -p 80:80 --name frontend angular-frontend:v1
```