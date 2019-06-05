FROM archlinux/base
RUN pacman -Sy --noconfirm reflector
RUN reflector --country Netherlands --country Germany --age 12 --protocol https --sort rate --save /etc/pacman.d/mirrorlist
RUN pacman -Syu --noconfirm nodejs npm git gpg
RUN chown -R http:http /srv/http
RUN chmod -R 700 /srv/http
USER http
WORKDIR /srv/http
COPY ./src /srv/http/src
COPY ./index.js /srv/http/index.js
COPY ./package.json /srv/http/package.json
COPY ./LICENSE /srv/http/LICENSE
COPY ./README.md /srv/http/README.md
RUN npm set registry https://registry.npmjs.org/
RUN npm install --production
EXPOSE 3000/tcp
ENTRYPOINT npm start