FROM mysql:5.7.21

COPY docker/mysql/init.sql /docker-entrypoint-initdb.d/init.sql

RUN { \
  echo '[mysqld]'; \
  echo 'character-set-server=utf8mb4'; \
  echo 'collation-server=utf8mb4_unicode_520_ci'; \
  echo; \
  echo '[mysql]'; \
  echo 'default-character-set=utf8mb4'; \
} | tee /etc/mysql/conf.d/mysql-utf8mb4.cnf 

EXPOSE 3306
