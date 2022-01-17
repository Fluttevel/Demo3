# ================================================== #
# ===========|   D O C K E R  F I L E   |=========== #
# ================================================== #


FROM php:7.4-cli
COPY . /usr/src/myapp
WORKDIR /usr/src/myapp
CMD [ "php", "./index.php" ]

#FROM ubuntu:16.04
#
#RUN apt-get -y update
#RUN apt-get -y install apache2
#
#RUN echo 'Hello DevOps from AWS ECS!' > /var/www/html/index.html
#
#
#CMD ["/usr/sbin/apache2ctl", "-D","FOREGROUND"]
#EXPOSE 80