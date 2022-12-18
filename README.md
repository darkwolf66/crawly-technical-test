# Crawly Technical Test

## The application can be run by docker via Laravel Sail or directly by docker-compose.yaml

### Adicionar no env
`CRAWLER_URL="http://applicant-test.us-east-1.elasticbeanstalk.com/"`

## Build vue via `yarn run build`

## Application is running in sail, so to upload docker container just run `./vendor/bin/sail up` from the root folder
Obs: Docker Linux or no Windows via WSL2

### To fetch the results the app route is the root "/"
### Result can also be returned via
`php artisan crawly:get-crawler-answer`
### Added unit test for deobfuscator
`php artisan test`


Any doubt, I am available at will.moraes.96@gmail.com
