<p align="center"><a href="#" target="_blank"><img src="public/img/logo.svg" width="400"></a></p>

## About eDokumen
eDokumen adalah suatu web app yang dibangun oleh Tim ICT SMKN 1 Krangkeng untuk kebutuhan penyimpanan dan sharing file digital dari para stakeholder yang ada di SMKN 1 Krangkeng
eDokumen dibuat dengan menggunakan PHP Fremework Laravel 9 dengan requires a minimum PHP versi 8

## Package Used
<ul>
<li>
    <a href="https://jetstream.laravel.com/2.x/installation.html">laravel/jetstream</a>
</li>
<li>
    <a href="https://laravel-livewire.com/docs/2.x/installation">livewire/livewire</a>
</li>
<li>
    <a href="https://github.com/nascent-africa/jetstrap">nascent-africa/jetstrap</a>
</li>
<li>
    <a href="https://spatie.be/docs/laravel-permission/v5/installation-laravel">spatie/laravel-permission</a>
</li>
<li>
    <a href="https://sweetalert2.github.io/">sweetalert2</a>
</li>
<li>
    <a href="https://icons.getbootstrap.com/">Icons Bootstrap 5</a>
</li>
<li>
    <a href="https://github.com/stechstudio/laravel-zipstream">stechstudio/laravel-zipstream</a>
</li>
<li>
    <a href="https://docs.laravel-excel.com/3.1/getting-started/">maatwebsite/excel</a>
</li>
<li>
    <a href="https://github.com/barryvdh/laravel-debugbar">barryvdh/laravel-debugbar</a>
</li>
<li>
    <a href="https://github.com/SimpleSoftwareIO/simple-qrcode">simplesoftwareio/simple-qrcode</a>
</li>

</ul>

## How Install
Instalasi:
1. Install Composer: https://getcomposer.org/Composer-Setup.exe
2. Install Git: https://git-scm.com/download/win
3. Install xampp : https://www.apachefriends.org/xampp-files/8.1.2/xampp-windows-x64-8.1.2-0-VS16-installer.exe
4. buka git bash
<pre>
<code>
-> cd c:/xampp/htdocs
-> git clone https://github.com/ozonerik/eDok.git
-> cd eDok
-> composer install
-> cp .env.example .env
-> php artisan key:generate

// buka file .env setting database:
DB_DATABASE=eDok
DB_USERNAME=root
DB_PASSWORD=

-> php artisan migrate
-> php artisan db:seed

// optional
//reset database gunakan perintah
->php artisan migrate:fresh --seed

-> php artisan route:cache
-> php artisan config:cache
-> php artisan view:cache
-> php artisan storage:link

//akses aplikasi via http://localhost:8000
-> php artisan serve

//untuk update aplikasi gunakan perintah
-> git pull origin master

-> Login: admin@test.id / 12345678 , user@test.id / 12345678

</code>
</pre>

## Contributor
<ul>
<li><a href="https://github.com/smkn1krangkeng">SMK Negeri 1 Krangkeng</a></li>
<li><a href="https://github.com/ict-smkn1krangkeng">Unit ICT SMKN 1 Krangkeng</a></li>
<li><a href="https://github.com/ozonerik">ozonerik</a></li>
</ul>

## License
eDokumen is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
