#Lesson 4
* .env file is a place where you should keep your keys, API keys etc.
* `php artican migrate` runs all the migrations from `database/migrations` creating all the necessary tables in configured schema. It also creates `migrations` table to keep records of all the runned migrations

#Leson 5
* You can retrieve data passed do view via `<?= $name ?>` or `{{ $name }}`
* Pass data using second argument after view name or using `with(argument, value)` method
* Passing data as second argument you can either create new array or use `compact(parameter1, parameter2)` function
* In templates use blade directives (eg. `@foreach($tasks as $task) {{ $task }} @endforeach`) instead of php structures
