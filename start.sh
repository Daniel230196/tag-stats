#!/usr/bin/env bash
if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit
fi


hosts=("api.loc" "app.loc")
for el in ${hosts[@]}; do
    export HOST_REGEX="\(\s\+\)${el}\s*$"
    export ETC_HOSTS="/etc/hosts"
    export HOST_LINE="$(grep -e "${HOST_REGEX}" ${ETC_HOSTS})"
    export IP=127.0.0.1

    if [ -n "${HOST_LINE}" ]; then
        echo "${el} already exists : ${HOST_LINE}"
    else
        echo "Adding ${el} to your ${ETC_HOSTS}";
        echo -e "${IP}\t${el}" >> ${ETC_HOSTS}
        echo -e "${el} was added succesfully \n ${HOST_LINE}";
    fi
done

docker compose down --remove-orphans
docker compose up --build -d
docker compose logs -f