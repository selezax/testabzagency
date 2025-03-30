#!/usr/bin/env bash

clear
echo "============================================"

PS3='Please enter your choice for start: '
options=("Start as demon"
"Start in console"
"To console"
"Information about running containers"
"Stop"
"Build container"
"Clear Cache Docker"
"CHMOD"
"CHOWN"
"Quit")
COLUMNS=5
select opt in "${options[@]}"
do
    case $opt in
        "Start as demon")
            echo "you chose choice $REPLY which is $opt"
            docker compose up -d
            docker compose ps
            break
            ;;

        "Start in console")
            clear
            echo "you chose choice $REPLY which is $opt"
            docker compose up
            break
            ;;

        "To console")
            clear
            docker compose exec app bash
            break
            ;;

        "Information about running containers")
            echo "you chose choice $REPLY which is $opt"
            docker compose logs
            docker compose ps
            break
            ;;

        "Stop")
            echo "you chose choice $REPLY which is $opt"
            docker compose down
            docker compose ps
            break
            ;;

        "Build container")
            echo "you chose choice $REPLY which is $opt"
            docker compose build
            break
            ;;

        "Clear Cache Docker")
            echo "you chose choice $REPLY which is $opt"
            docker rmi -f $(docker images --filter dangling=true -q)
            docker builder prune
            break
            ;;

        "CHMOD")
            echo "you chose choice $REPLY which is $opt"
            sudo chmod -R 777 storage/logs
            sudo chmod -R 777 storage/framework
            sudo chmod -R 777 storage/app/public
            sudo chmod -R 777 bootstrap/cache
            break
            ;;

        "CHOWN")
            echo "you chose choice $REPLY which is $opt"
            sudo chown -R $USER:$USER .
            break
            ;;

        "Quit")
            break
            ;;
        *) echo "invalid option $REPLY";;
    esac
done
