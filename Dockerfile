FROM nextcloud:24-apache

RUN apt-get update && \
	apt-get install -y redis git jq moreutils

RUN { \
        echo 'opcache.enable=1' ; \
        echo 'opcache.interned_strings_buffer=${OPCACHE_INTERNED_STRINGS_BUFFER}' ; \
        echo 'opcache.max_accelerated_files=${OPCACHE_MAX_ACCELERATED_FILES}' ; \
        echo 'opcache.memory_consumption=${OPCACHE_MEMORY_CONSUMPTION}' ; \
#        echo 'opcache.save_comments=${OPCACHE_SAVE_COMMENTS}' ; \
        echo 'opcache.revalidate_freq=${OPCACHE_REVALIDATE_FREQ}' ; \
        echo 'opcache.fast_shutdown=${OPCACHE_FAST_SHUTDOWN}' ; \
        echo 'opcache.jit=${OPCACHE_JIT}' ; \
        echo 'opcache.jit_buffer_size=${OPCACHE_JIT_BUFFER_SIZE}' ; \
    } > /usr/local/etc/php/conf.d/opcache-recommended.ini ;

COPY 000-default.conf /etc/apache2/sites-enabled/000-default.conf
COPY .htaccess /usr/src/nextcloud/data/.htaccess

RUN sed -i 's/^port 6379/port 0/g' /etc/redis/redis.conf ; \
	echo unixsocket /var/run/redis/redis-server.sock >> /etc/redis/redis.conf ; \
	echo unixsocketperm 770 >> /etc/redis/redis.conf ; \
	sed -i 's/redis-session.ini/redis-session.ini\nredis-server \&/g' /entrypoint.sh ;

WORKDIR /usr/src/nextcloud

# Perform a fake setup in order to use OCC to pre-install apps
RUN rm /usr/src/nextcloud/config/apps.config.php ; \
    php occ maintenance:install \
    --database-name=fakesetup \
    --database-user=fakesetup \
    --database-pass=fakesetup \
    --admin-user=fakesetup \
    --admin-pass=fakesetup \
    --data-dir=/usr/src/nextcloud/data/fakesetup ; \
\
    rm /usr/src/nextcloud/config/CAN_INSTALL ; \
\
    php occ app:update --all ; \
    echo /usr/src/nextcloud/data/fakesetup/appdata_* > appdata_dir ; \
    mv data/fakesetup/appdata_* data/fakesetup/appdata; \
    curl -s https://apps.nextcloud.com/api/v1/categories.json > data/fakesetup/appdata/appstore/categories.json

WORKDIR /usr/src/nextcloud/data/fakesetup/appdata/appstore

# Add "All Apps" category
#RUN jq '. += [{"id": "all", "translations": {"en": {"description": "All available Nextcloud apps", "name": "All Apps"}}}]' categories.json | sponge categories.json ; \
#    jq '.data[].categories += ["all"]' apps.json | sponge apps.json

# Blacklist apps
RUN appBlacklist="gpxpod unsplash keeweb" ; \
    for app in $appBlacklist ; \
      do \
        jq "del(.data[] | select(.id == \"$app\"))" apps.json | sponge apps.json ; \
    done

# Whitelist apps \
RUN appWhitelist="onlyoffice user_saml contacts calendar" ; \
    jq "del(.data[])" apps.json > apps.json.tmp ; \
\
    for app in $appWhitelist ; \
    do \
      json=$(jq ".data[] | select(.id == \"$app\")" apps.json) ; \
      jq ".data += [$json]" apps.json.tmp | sponge apps.json.tmp ; \
    done ; \
\
    mv apps.json.tmp apps.json

WORKDIR /usr/src/nextcloud

# Restore the original appdata directory in order to proceed with preinstalling apps
RUN mv /usr/src/nextcloud/data/fakesetup/appdata $(cat /usr/src/nextcloud/appdata_dir) ; \
    rm /usr/src/nextcloud/appdata_dir

# Preinstall all apps in apps.json
RUN for app in $(jq '.data[].id' /usr/src/nextcloud/data/fakesetup/appdata_*/appstore/apps.json | sed 's/"//g') ; \
      do \
      php occ app:install $app & \
    done ; \
\
    while [ $(ps -ax | grep 'php occ app:install' | grep -v grep | wc -l) -gt 0 ] ; \
    do \
      sleep 1 ; \
    done

WORKDIR /usr/src/nextcloud/apps
RUN rm -r \
    files_external \
    user_ldap
#    password_policy  # Required for password validation of admin actions like app removals

WORKDIR /usr/src/nextcloud

RUN rm -r \
#    config/CAN_INSTALL \
    data/fakesetup* \
    data/nextcloud.log \
    config/apache-pretty-urls.config.php \
    config/apcu.config.php \
    config/autoconfig.php \
    config/config.php \
    config/config.sample.php \
    config/redis.config.php \
    config/reverse-proxy.config.php \
    config/s3.config.php \
    config/smtp.config.php \
    config/swift.config.php

COPY config/* config/
RUN touch data/.ocdata

# objectstore signature patch
#RUN curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/ExpressionBuilder/ExpressionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/ExpressionBuilder/ExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/ExpressionBuilder/MySqlExpressionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/ExpressionBuilder/MySqlExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/ExpressionBuilder/OCIExpressionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/ExpressionBuilder/OCIExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/ExpressionBuilder/PgSqlExpressionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/ExpressionBuilder/PgSqlExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/ExpressionBuilder/SqliteExpressionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/ExpressionBuilder/SqliteExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/FunctionBuilder/FunctionBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/FunctionBuilder/FunctionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/DB/QueryBuilder/QueryBuilder.php -o /usr/src/nextcloud/lib/private/DB/QueryBuilder/QueryBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/Cache/Cache.php -o /usr/src/nextcloud/lib/private/Files/Cache/Cache.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/Cache/CacheEntry.php -o /usr/src/nextcloud/lib/private/Files/Cache/CacheEntry.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/Cache/CacheQueryBuilder.php -o /usr/src/nextcloud/lib/private/Files/Cache/CacheQueryBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/Cache/Propagator.php -o /usr/src/nextcloud/lib/private/Files/Cache/Propagator.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/FileInfo.php -o /usr/src/nextcloud/lib/private/Files/FileInfo.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/private/Files/Storage/Wrapper/Encryption.php -o /usr/src/nextcloud/lib/private/Files/Storage/Wrapper/Encryption.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/public/DB/QueryBuilder/IExpressionBuilder.php -o /usr/src/nextcloud/lib/public/DB/QueryBuilder/IExpressionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/public/DB/QueryBuilder/IFunctionBuilder.php -o /usr/src/nextcloud/lib/public/DB/QueryBuilder/IFunctionBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/public/DB/QueryBuilder/IQueryBuilder.php -o /usr/src/nextcloud/lib/public/DB/QueryBuilder/IQueryBuilder.php & \
#    curl https://raw.githubusercontent.com/nextcloud/server/cb45fe39d9de650f537f255e463affe75029a14f/lib/public/Files/Cache/ICacheEntry.php -o /usr/src/nextcloud/lib/public/Files/Cache/ICacheEntry.php ;

WORKDIR /usr/src/nextcloud/apps

RUN git clone https://github.com/nunimbus/database_encryption ; \
    git clone https://github.com/nunimbus/singleuser ; \
    git clone https://github.com/nunimbus/onlyoffice_saml_patch ; \
    git clone https://github.com/nunimbus/class_overrides ; \
    bash class_overrides/install.sh ; \
    find . -name .git | xargs rm -r ; \
    touch /

WORKDIR /var/www/html
RUN chmod a+rw /usr/src/nextcloud

ENV APACHE_RUN_USER=www-data \
    APACHE_RUN_GROUP=www-data \
    APACHE_LOG_DIR=/var/log/apache2 \
    APACHE_LOCK_DIR=/var/lock/apache2 \
    APACHE_PID_FILE=/var/run/apache2.pid \
    APACHE_RUN_DIR=/var/run/apache2

RUN apt-get autoremove -y git jq moreutils && \
    apt-get clean

######## DEBUG ########
ARG VIM=0 \
    SSH=0 \
    XDEBUG=0

RUN if [ $VIM -eq 1 ] ; \
    then \
      apt-get install -y vim ; \
      { \
        echo ':set mouse-=a'; \
        echo ':set t_BE='; \
        echo ':syntax on'; \
        echo ':set ruler'; \
        echo ':set encoding=utf-8'; \
        echo ':set pastetoggle=<F2>'; \
        echo ':retab!'; \
        echo ':set noexpandtab'; \
        echo ':set tabstop=4'; \
      } > /root/.vimrc 2>1; \
    fi ;

RUN if [ "$SSH" != "0" ] ; \
    then \
      apt-get install -y openssh-server ; \
      mkdir /var/run/sshd ; \
      echo "root:$SSH" | chpasswd ; \
      echo "PermitRootLogin yes" >> /etc/ssh/sshd_config ; \
      sed 's@session\s*required\s*pam_loginuid.so@session optional pam_loginuid.so@g' -i /etc/pam.d/sshd ; \
      sed -i 's/redis-server \&/redis-server \& \/usr\/sbin\/sshd -D \&/g' /entrypoint.sh ; \
    fi ;

RUN if [ $XDEBUG -eq 1 ] ; \
    then \
      pecl install xdebug ; \
      { \
        echo 'zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20200930/xdebug.so' ; \
        echo 'xdebug.mode = debug' ; \
        echo 'xdebug.start_with_request = yes' ; \
        echo 'xdebug.client_port=9000' ; \
      } > /usr/local/etc/php/conf.d/xdebug.ini ; \
      mkdir /usr/src/nextcloud/.vscode ; \
      echo '{"version":"0.2.0","configurations":[{"name":"Listen for XDebug","type":"php","request":"launch","port": 9000,"xdebugSettings":{"max_data":-1},"pathMappings":{"/var/www/html":"${workspaceRoot}/"}},{"name":"Launch currently open script","type":"php","request":"launch","program":"${file}","cwd":"${fileDirname}","port": 9000}]}' > /usr/src/nextcloud/.vscode/launch.json ; \
      echo '{"search.useIgnoreFiles": false}' > /usr/src/nextcloud/.vscode/settings.json ; \
    fi ;
