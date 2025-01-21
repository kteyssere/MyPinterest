# Étape 1 : Construire l'application Angular
FROM node:18 AS build

# Définir un répertoire de travail absolu
WORKDIR /usr/src/app

# Copier les fichiers package.json et package-lock.json dans le conteneur
COPY package.json package-lock.json ./

# Installer les dépendances Angular
RUN npm install

# Copier le code source dans le conteneur
COPY . .

# Construire l'application Angular pour la production
RUN npm run build --prod

# Étape 2 : Servir l'application avec NGINX
FROM nginx:latest

# Copier les fichiers compilés d'Angular vers NGINX
COPY --from=build /usr/src/app/dist /usr/share/nginx/html

# Exposer le port 80 pour accéder à l'application
EXPOSE 80

# Lancer NGINX
CMD ["nginx", "-g", "daemon off;"]