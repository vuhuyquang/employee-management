FROM centos:7

# update yum
RUN yum -y update
RUN yum -y install yum-utils
RUN yum clean all

RUN yum -y install epel-release
RUN yum -y groupinstall "Development Tools"
RUN yum -y install wget git vim zsh curl

# install remi repo
RUN wget http://rpms.famillecollet.com/enterprise/remi-release-7.rpm
RUN rpm -Uvh remi-release-7*.rpm
RUN yum-config-manager --enable remi-php74

# install Httpd
RUN yum install -y httpd

# install php7
RUN \
  yum -y install \
    php php-common \
    php-mbstring \
    php-mcrypt \
    php-gd \
    php-devel \
    php-xml \
    php-mysqlnd \
    php-pdo \
    php-opcache --nogpgcheck \
    php-bcmath \
  php-intl \
  php-pecl-zip \
  php-pecl-redis

# application directory
# RUN mkdir /app
# WORKDIR /app

# install Redis
RUN yum install -y redis

# install nodejs 
RUN curl --silent --location https://rpm.nodesource.com/setup_10.x | bash -
RUN yum install -y nodejs

# install composer
RUN curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer

# timezone setting
RUN cp /etc/localtime /etc/localtime.org
RUN ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

EXPOSE 8080

CMD ["/sbin/init"]