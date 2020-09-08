FROM docker.io/centos
MAINTAINER tc_huang1995@163.com

# put nginx-1.12.2.tar.gz into /usr/local/src and unpack nginx 来吧nginx 和PHP提前都放进基础镜像的/usr/local/src目录下，方便编译安装
ADD nginx-1.12.2.tar.gz /usr/local/src
ADD php-7.0.0.tar.gz /usr/local/src

# running required command 安装Nginx的一系列乱七八糟的依赖包
RUN yum install -y gcc gcc-c++ glibc make autoconf openssl openssl-devel
RUN yum install -y libxslt-devel -y gd gd-devel GeoIP GeoIP-devel pcre pcre-devel
RUN useradd -M -s /sbin/nologin nginx

# change dir to /usr/local/src/nginx-1.12.2
WORKDIR /usr/local/src/nginx-1.12.2

# execute command to compile nginx
RUN ./configure --user=nginx --group=nginx --prefix=/usr/local/nginx --with-file-aio --with-http_ssl_module --with-http_realip_module --with-http_addition_module --with-http_xslt_module --with-http_image_filter_module --with-http_geoip_module --with-http_sub_module --with-http_dav_module --with-http_flv_module --with-http_mp4_module --with-http_gunzip_module --with-http_gzip_static_module --with-http_auth_request_module --with-http_random_index_module --with-http_secure_link_module --with-http_degradation_module --with-http_stub_status_module && make && make install

#先装个本地Mysql
RUN yum install -y wget
RUN wget http://repo.mysql.com/mysql57-community-release-el7-8.noarch.rpm
RUN rpm -ivh mysql57-community-release-el7-8.noarch.rpm
RUN yum install -y mysql-server


#截止此，开始安装php，宇宙惯例，开始安装一些编译的依赖包
RUN yum -y install epel-release
RUN yum -y install libmcrypt-devel
RUN yum -y install libxml2 libxml2-devel openssl openssl-devel curl-devel libjpeg-devel libpng-devel freetype-devel
WORKDIR /usr/local/src/php-7.0.0
#编译 安装
RUN ./configure --prefix=/usr/local/php7 --with-config-file-path=/usr/local/php7/etc --with-config-file-scan-dir=/usr/local/php7/etc/php.d --with-mcrypt=/usr/include --enable-mysqlnd --with-mysqli --with-pdo-mysql --enable-fpm --with-fpm-user=nginx --with-fpm-group=nginx --with-gd --with-iconv --with-zlib --enable-xml --enable-shmop --enable-sysvsem --enable-inline-optimization --enable-mbregex --enable-mbstring --enable-ftp --enable-gd-native-ttf --with-openssl --enable-pcntl --enable-sockets --with-xmlrpc --enable-zip --enable-soap --without-pear --with-gettext --enable-session --with-curl --with-jpeg-dir --with-freetype-dir --enable-opcache && make && make install

RUN cp php.ini-production /usr/local/php7/etc/php.ini