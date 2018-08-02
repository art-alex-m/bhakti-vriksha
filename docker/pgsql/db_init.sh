#!/bin/sh
#
# Команды для развертывания базы данных проекта
#

# Создание базы данных для тестового проекта
# Для развертывания на продакшене следует сменить пароль и закоментировать создание тестовой бд
# в указанном файле db_user_init.sql
su -c 'psql -f /tmp/db_user_init.sql' postgres

# Добавление расширения для генерирования серийных номеров
su -c 'psql -c "create extension if not exists \"uuid-ossp\"" -d bhakti_vriksha' postgres