Assignment Blueprint for backend
===============================

This is a Laravel blueprint for backend development, for creating a multi-tenant application **(single database)** to manage quizzes

## Installation
- clone this repository `git@github.com:mustafa-code/quiz.git`
- cd into the project directory `cd quiz`
- run `cp .env.example .env`
- run `composer install`
- run `php artisan key:generate`
- run migration `php artisan migrate`
- run `npm install`
- run `npm run build`
- serve the application `php artisan serve` or use laravel valet, or any other server
- visit the application in your browser `http://127.0.0.1:8000` 

## Multi-tenancy
This application is multi-tenant, meaning that it can serve multiple clients with a single codebase. To achieve this, we use the [tenancyforlaravel](https://tenancyforlaravel.com/) package. The package is already installed and configured.

## Configure Google Calendar
This application integrate with google calendar to send invitations to tenant users,  to configure the integration with google calendar follow this steps in this [package](https://github.com/spatie/laravel-google-calendar?tab=readme-ov-file#how-to-obtain-the-credentials-to-communicate-with-google-calendar) and remember to store the service account credentials json file in this directory `storage/app/google-calendar/service-account-credentials.json`.

*One more thing, you have to set calender id `GOOGLE_CALENDAR_ID` in you `.env` file with your calender id value.*

## Queue Configuration
This application uses queues for many havy processes.

Remeber to set `QUEUE_CONNECTION` in `.env` to any queue connection but not `sync` to get the benifits of queuing jobs.

### Local queue running:
```
php artisan queue:work --queue=emails,calendar-events,default
```
*No need for any extra configuration.*

### Production queue running:
*To run the queue in the server for `production`, you can user [systemd service](https://tecadmin.net/running-laravel-queue-worker-as-a-systemd-service/), [pm2](https://awangt.medium.com/run-and-monitor-laravel-queue-using-pm2-dc4924372e03) or `any queue manager` to keep the queue running in the background without terminating.*
