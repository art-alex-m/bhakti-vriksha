-- DATABASE: bhakti_vriksha
-- DATABASE TESTING: bhakti_vriksha_testing
-- USER:     devoted
-- PASSWORD: hare_krshna
--
-- На основе информации страниц
-- http://www.unixmen.com/postgresql-9-4-released-install-centos-7/
-- http://stackoverflow.com/questions/1471571/how-to-configure-postgresql-for-the-first-time
--
-- su -c 'psql -f /tmp/db_user_init.sql' postgres

CREATE ROLE devoted
  LOGIN;
ALTER USER devoted WITH ENCRYPTED PASSWORD 'hare_krshna';

CREATE DATABASE bhakti_vriksha ENCODING 'utf-8';
GRANT ALL PRIVILEGES ON DATABASE bhakti_vriksha TO devoted;
ALTER DATABASE bhakti_vriksha
OWNER TO devoted;

CREATE DATABASE bhakti_vriksha_testing ENCODING 'utf-8';
GRANT ALL PRIVILEGES ON DATABASE bhakti_vriksha_testing TO devoted;
ALTER DATABASE bhakti_vriksha_testing
OWNER TO devoted;
