#!/bin/bash

mysql -u root -p"${MYSQL_ROOT_PASSWORD}" <<EOF

CREATE USER IF NOT EXISTS '${MYSQL_USER}'@'%' IDENTIFIED BY '${MYSQL_PASSWORD}';

CREATE DATABASE IF NOT EXISTS \`${MYSQL_DATABASE}_teste\`;

GRANT ALL PRIVILEGES ON \`${MYSQL_DATABASE}_teste\`.* TO '${MYSQL_USER}'@'%';

FLUSH PRIVILEGES;

EOF

echo Banco '${MYSQL_DATABASE}_teste' criado com sucesso para uso nos testes de feature.