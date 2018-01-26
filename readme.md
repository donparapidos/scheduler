### Installation

Add Provider for Laravel < 5.5
```
MatviiB\Scheduler\SchedulerServiceProvider::class,
```
Publish config and CronTasksList class files:
```
php artisan vendor:publish
```
and choose "Provider: MatviiB\Scheduler\SchedulerServiceProvider" if requested.

Move your commands from App\Console\Kernel schedule function to new CronTasksList file with path app/Console/CronTasksList.php.

Add next line to schedule function instead of list of commands:

```php
<?php
 
namespace App\Console;
 
use MatviiB\Scheduler\Console\Kernel as SchedulerKernel;
 
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
 
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // your commands list
    ];
 
    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //make changes just here
        with(new SchedulerKernel())->schedule($schedule);
    }
```
Paste your commands to app/Console/CronTasksList.php class:
```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class CronTasksList
{
    public function __construct(Schedule $schedule)
    {
        $schedule->command('example:command')->yearly()->withoutOverlapping();
    }
}
```
Create database table:
```sh
 php artisan migrate
 ```
If everything done for now you can run next command, it will show your current commands list
```
php artisan scheduler:show
```
And you will see something like this
```
Scheduler is disabled.
You see standard tasks list.
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command         | description                  | is_active | expression  | w_o | interval |
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command:name    | Description for command:name | 1         | 0 * * * * * | 1   | 1 hour   |
| example:command | Command description          | 1         | * * * * * * | 1   | 1 minute |
+-----------------+------------------------------+-----------+-------------+-----+----------+

```
To use Scheduler you need to copy commands to schedulers table.
 
Note: every scheduler:create execution will soft delete old tasks and create fresh commands data.
```
php artisan scheduler:create
```
To use Scheduler you need enable it by adding to your .env next line:
 ```sh
SCHEDULER_ENABLED=true
```
Lets check status and scheduled tasks:
```
php artisan scheduler:show
```
And you will see something like this:
```
Scheduler is enabled.
You see scheduled tasks list configured with Scheduler.
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command         | description                  | is_active | expression  | w_o | interval |
+-----------------+------------------------------+-----------+-------------+-----+----------+
| command:name    | Description for command:name | 1         | 0 * * * * * | 1   | 1 hour   |
| example:command | Command description          | 1         | * * * * * * | 1   | 1 minute |
+-----------------+------------------------------+-----------+-------------+-----+----------+
```
You can manage your scheduled task on page /scheduler by default. But you also free to configure it yourself.
![laravel scheduler](https://gitlab.com/MatviiB/assets/raw/master/Screenshot.png)
![laravel scheduler](https://gitlab.com/MatviiB/assets/raw/master/Screenshot%20(1).png)
