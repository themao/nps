FROM mysql

MAINTAINER Thomas Rödiger <tr@delodi.net>

VOLUME /var/lib/mysql

RUN echo "innodb_use_native_aio=0" >> /etc/mysql/my.cnf
RUN echo "bind-address=0.0.0.0" >> /etc/mysql/my.cnf
RUN mysql | echo "CREATE USER 'root'@'%' IDENTIFIED BY '$MYSQL_ROOT_PASSWORD';GRANT ALL PRIVILEGES ON *.* TO 'root'@'%';FLUSH PRIVILEGES;"
RUN mysql | echo "CREATE DATABASE IF NOT EXISTS $MYSQL_DATABASE CHARACTER SET=utf8;"
