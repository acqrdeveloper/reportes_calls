## Requires Installed Technologies
- NodeJS  v7.10.1  https://nodejs.org/download/release/v7.10.1/node-v7.10.1-x64.msi
- Composer  https://getcomposer.org/doc/00-intro.md

### Usage and Deployment
Nota: Se debe aplicar paso a paso cada procedimiento para hacer el deploy correcto del sistema 

##### (1) Back-End
- npm install
- npm install gulp -g --save
- composer install --no-scripts
- composer refresh

##### (2) Front-End
- cd public
- npm install
- gulp

##### (3) Finally
- add file .ENV
- execute php artisan serve or configure vhost with xampp
