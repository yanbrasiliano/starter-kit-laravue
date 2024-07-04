#!/usr/bin/env bash

change_group_and_permissions() {
    local dir=$1
    local group=$2

    if [ ! -d "$dir" ]; then
        echo "Diretório $dir não encontrado. Pulando."
        return
    fi

    echo "Alterando o grupo para $group e definindo permissões de escrita para o grupo em $dir"
    chgrp -R $group "$dir"
    if [ $? -ne 0 ]; then
        echo "Erro ao alterar grupo em $dir."
        exit 1
    fi
    echo "Grupo alterado com sucesso em $dir."

    echo "Definindo permissões de escrita para o grupo em $dir"
    chmod -R g+w "$dir"
    if [ $? -ne 0 ]; then
        echo "Erro ao definir permissões em $dir."
        exit 1
    fi
    echo "Permissões definidas com sucesso em $dir."

    echo "Definindo o bit setgid em todos os diretórios dentro de $dir"
    find "$dir" -type d -exec chmod g+s {} +
    if [ $? -ne 0 ]; then
        echo "Erro ao definir bit setgid em $dir."
        exit 1
    fi
    echo "Bit setgid definido com sucesso em $dir."
}

change_group_and_permissions "bootstrap/" "www-data"
change_group_and_permissions "storage/" "www-data"
change_group_and_permissions "storage/logs/" "www-data"
change_group_and_permissions "/var/www/html/storage/framework/cache/data/" "www-data"

echo "Permissões e propriedades de grupo atualizadas com sucesso."