FROM docker:latest

# Install Docker Compose
RUN apk add --no-cache py-pip
RUN pip install docker-compose

# Set the working directory
WORKDIR /app

# Copy your project files to the container
COPY . /app

# Expose ports
EXPOSE 8080 8081 8082 8083

# Set the entrypoint command
ENTRYPOINT ["docker-compose", "up"]
