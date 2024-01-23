FROM node:lts-alpine3.12
WORKDIR /app
COPY package.json /app
COPY package-lock.json /app
COPY webpack*.js /app
RUN npm install -g npm@8.17.0
RUN npm ci --omit=dev && npm cache clean --force
COPY . /app
EXPOSE 3000
RUN npm run build
CMD [ "node" ]
