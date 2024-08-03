FROM node:16-alpine

RUN apk update && apk add bash

RUN npm install -g ts-node

WORKDIR /usr/src/app

COPY package*.json ./

COPY . .

RUN npm install

ENV NODE_ENV=production

SHELL ["/bin/bash", "-c"]