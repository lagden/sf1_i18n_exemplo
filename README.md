Exemplo i18n
============

Internationalization and Localization


## Instalação

    git clone git@github.com:lagden/sf1_i18n_exemplo.git /path/do/exemplo
    cd /path/do/exemplo
    ./bin/setup -f

## Configuração do banco de dados

Copie arquivo, edite-o colocando suas configurações de banco de dados e execute o bash script que irá recriar o banco de dados carregando informações das fixtures.

    cp config/databases.yml.dist config/databases.yml
    vim config/databases.yml
    ./bin/reset

\o/
