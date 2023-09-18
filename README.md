creacion de imagen de Postgres para practica 2 
sudo docker build -t postgrespsw03 .

Levantamiento de contenedor de postgres 
    sudo docker run --name cpostgrespsw03 -e POSTGRES_PASSWORD=postgres -d postgrespsw03

Creación de imagen de php 
    sudo docker build -t phppsw03 .

Levantamiento de volumen para docker de postgres 
    sudo docker run -d -v ./src:/var/www/html/ --name cphppsw03 phppsw03
