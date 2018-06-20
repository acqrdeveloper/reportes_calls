#!/bin/bash
#
# Este sript sirver para copiar archivos a distintos servidores
my_directory="$(dirname "$0")"
server_ips=($1)
ruta_local=$2
ruta_remota=$3
archivos=($4)

# recorremos todos los valores del array
for archivo in ${archivos[*]}
do
   for ips in ${server_ips[*]}
      do
      	  echo "Los archivos se copiaron al servidor: " ${ips}
          scp /${ruta_local}/$archivo root@${ips}:/${ruta_remota}/
          echo "-----------------------------------------"
      done
done
