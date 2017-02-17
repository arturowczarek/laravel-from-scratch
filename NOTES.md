#Lesson 4
* .env file is a place where you should keep your keys, API keys etc.
* `php artican migrate` runs all the migrations from `database/migrations` creating all the necessary tables in configured schema. It also creates `migrations` table to keep records of all the runned migrations

#Lesson 5
* You can retrieve data passed do view via `<?= $name ?>` or `{{ $name }}`
* Pass data using second argument after view name or using `with(argument, value)` method
* Passing data as second argument you can either create new array or use `compact(parameter1, parameter2)` function
* In templates use blade directives (eg. `@foreach($tasks as $task) {{ $task }} @endforeach`) instead of php structures

#Lesson 6
* To display all the possible artisan commands use `php artisan`
* `php artisan help [commands]` displays help
* To create new migration use eg. `php artisan make:migration create_tasks_table`. It's not going to create new table
* To create new table in migration add `--create=[tableName]` option
* When you delete migration and receive an error try update the autoloader `composer dump-autoload`
* Methods creating column names correspond to the data type. You can get more information from documentation or reading source code of `Illuminate\Database\Schema\Blueprint`
  * increments
  * integer
  * string
  * text
  * timestamps
* To run migrations use `php artisan migrate`. You can refresh them using subtask `:refresh`
* Returned entities are automatically converted into JSON response
* `dd($someVariable)` allows us to show the variable value
 ## Passing data to url
 * You can pass parameters to url using eg. `Route::get('/tasks/{task}', function ($id)`
 * When `id` corresponds to some real entity you can populate it passing entity in method: `Route::get('/tasks/{task}', function (Task $task)`
 