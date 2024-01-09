FROM node:20-alpine AS builder

WORKDIR /data

COPY . .

RUN npm install
RUN npm run build

FROM nginx:latest

WORKDIR /usr/share/nginx/html/app

COPY Nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=builder /data/dist /usr/share/nginx/html/app
