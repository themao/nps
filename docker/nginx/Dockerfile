FROM ubuntu:14.04

# File Author / Maintainer
MAINTAINER tom

# Update the repository
RUN apt-get update

# Install necessary tools
RUN apt-get install -y vim wget dialog net-tools

# Download and Install Nginx
RUN apt-get install -y nginx
RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

# Remove the default Nginx configuration file
RUN mv  /etc/nginx/nginx.conf /etc/nginx/nginx.conf.orig

# Copy a configuration file from the current directory
ADD nginx.conf /etc/nginx/
ADD sites-available/app.conf /etc/nginx/sites-available/
RUN ln -s /etc/nginx/sites-available/app.conf  /etc/nginx/sites-enabled/1-app
RUN rm /etc/nginx/sites-enabled/default


# Set the default command to execute when creating a new container
RUN usermod -u 1000 www-data

CMD ["nginx", "-g", "daemon off;"]
# Expose ports
#EXPOSE 80
