<?php

namespace Deployer;

use Symfony\Component\Console\Input\InputOption;

require 'recipe/laravel.php';

// Config
option('b', 'b', InputOption::VALUE_REQUIRED, 'Branch to deploy'); // To shortent --branch parametter

set('repository', 'git@github.com-corp-it.iconic-intl.com:iconic-co/corp-it.iconic-intl.com.git');
set('bin/composer', '/usr/bin/composer');

// set('shared_files', []); // To remove .env from the list
set('copy_dirs', ['public/assets/dist']); // Copy public/assets/dist from previous release in case of deploying PHP Only
add('shared_dirs', []);
add('writable_dirs', ['storage/app/private']); // To allow writing to storage/app/private

// Hosts
host('prod')
    ->set('hostname', 'corp-it.iconic-intl.com')
    ->set('remote_user', 'ubuntu')
    ->set('deploy_path', '/var/www/corp-it.iconic-intl.com')
    ->set('identity_file', '~/.ssh/iconic-2024-10-14.pem')
    ->set('branch', 'master');

// Extra tasks
desc('Build assets');
task('iconic:build:assets', fn () => runLocally('npm run prod'));

desc('Upload assets to public/assets/dist');
task('iconic:upload:assets', fn () => upload('public/assets/dist', '{{release_path}}/public/assets'));

desc('Write .env file');
task('iconic:generate:dotenv', fn () => artisan('env:generate ' . (get('alias') == 'prod' ? 'production' : get('alias')) . ' write')());

desc('Reload httpd');
task('iconic:httpd:reload', fn () => run('sudo apache2ctl restart'));

// Main deploy task
Deployer::get()->tasks->remove('deploy'); // Remove default deploy task

desc('Deploys both PHP and Webpack asset buiding');
task('deploy-all', [
    // 'iconic:build:assets', // This take time, should run first to early detect error
    'deploy:prepare',
    'deploy:vendors',
    // 'iconic:upload:assets',
    // 'iconic:generate:dotenv', // Shoube be before caching
    // 'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:clear', // Can not cache route since createUrlToSwitchToLocale
    'artisan:view:cache',
    'artisan:event:cache',
    // 'artisan:migrate',
    'deploy:publish',
    'iconic:httpd:reload', // Reload httpd to refresh PHP opcache
    // 'artisan:queue:restart', // Should be final step after current symlink created
]);

desc('Deploys both PHP only, save time from skipping Webpack asset buiding');
task('deploy-php', [
    'deploy:prepare',
    'deploy:copy_dirs', // Copy assets from previous deploy. This take time, should run first to early detect error
    'deploy:vendors',
    // 'iconic:generate:dotenv', // Shoube be before caching
    // 'artisan:storage:link',
    'artisan:config:cache',
    'artisan:route:clear', // Can not cache route since createUrlToSwitchToLocale
    'artisan:view:cache',
    'artisan:event:cache',
    // 'artisan:migrate',
    'deploy:publish',
    'iconic:httpd:reload', // Reload httpd to refresh PHP opcache
    // 'artisan:queue:restart', // Should be final step after current symlink created
]);

// Hooks
after('deploy:failed', 'deploy:unlock');
