FROM ubuntu:16.04

RUN apt-get -y update
RUN apt-get -y install apache2

RUN echo 'Hello World from AWS ECS!' > /var/www/html/index.html


CMD ["/usr/sbin/apache2ctl", "-D","FOREGROUND"]
EXPOSE 80

#FROM ubuntu:18.04
#
## Install dependencies
#RUN apt-get update
#RUN apt-get -y install apache2
#
## Install apache and write 'Hello World' message
#RUN echo 'Hello World from fargate!' > /var/www/html/index.html
#
## Configure apache
#RUN echo '. /etc/apache2/envvars' > /root/run_apache.sh
#RUN echo 'mkdir -p /var/run/apache2' >> /root/run_apache.sh
#RUN echo 'mkdir -p /var/lock/apache2' >> /root/run_apache.sh
#RUN echo '/usr/sbin/apache2 -D FOREGROUND' >> /root/run_apache.sh
#RUN chmod 755 /root/run_apache.sh
#
#EXPOSE 80
#
#CMD /root/runapache.sh