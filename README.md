## Setup instructions
1. git clone https://github.com/Luis6810/UsersManagement.git
2. Copy .env.example to a new file called .env (Note that enviroment variables are taken to create the docker containers, it means its a environment for testing purposes)
3. `vendor/bin/sail up ` (Verify no ports are used by the cliente machine, if so, you can change them from   .env file)
4. `vendor/bin/sail php artisan migrate`
5. `vendor/bin/sail php artisan db:seed`
6. `vendor/bin/sail php artisan key:generate`
7. `vendor/bin/sail php artisan jwt:secret`
8. `vendor/bin/sail npm install`
8. `vendor/bin/sail npm run build`

## Running instructions
Once docker container is running with command `vendor/bin/sail up ` or `vendor/bin/sail up -d` if want to run it detach mode, it's time to run the vue fronent with command `vendor/bin/sail npm run dev ` this way everything is ready for our application

## Testing 
For running testing simply `vendor/bin/sail php artisan test`
You can even fileter test with --filter parameter, for example: `vendor/bin/sail php artisan test --filter Auth` this will execute test with coincidences with Auth.


