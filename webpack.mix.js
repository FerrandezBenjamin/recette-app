import mix from 'laravel-mix';

mix.js('public/js/app.js', 'public/js')
   .postCss('public/css/app.css', 'public/css')
   .version();