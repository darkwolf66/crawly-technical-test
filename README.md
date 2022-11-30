# Crawly Technical Test

## A aplicação pode ser rodada pelo docker via Laravel Sail ou diretamente pelo docker-compose.yaml

### Adicionar no env
`CRAWLER_URL="http://applicant-test.us-east-1.elasticbeanstalk.com/"`

## Fazer build do vue via `yarn run build`

## Aplicação está rodando no sail, então pra subir container do docker só rodar `./vendor/bin/sail up` a partir da pasta raiz
Obs: Docker Linux ou no Windows via WSL2

### Para fazer fetch dos resultados a rota do app é a root "/"
### Resultado também pode ser retornado via 
`php artisan crawly:get-crawler-answer`
### Teste unitario para o deobfuscador adicionado
`php artisan test`


Qualquer dúvida fico a disposição will.moraes.96@gmail.com
