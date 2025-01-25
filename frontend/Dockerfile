# Utiliser une image Node.js
FROM node:18

# Installer Angular CLI globalement
RUN npm install -g @angular/cli

# Définir le répertoire de travail
WORKDIR /usr/src/app

# Copier les fichiers package.json et package-lock.json
COPY package.json package-lock.json ./

# Installer les dépendances Angular
RUN npm install

# Copier le code source Angular dans le conteneur
COPY . .

# Exposer le port utilisé par `ng serve` (4200 par défaut)
EXPOSE 4200

# Commande pour lancer Angular en mode développement
CMD ["ng", "serve", "--host", "0.0.0.0"]
