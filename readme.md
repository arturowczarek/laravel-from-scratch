#Lesson 4
- .env file is a place where you should keep your keys, API keys etc.
- `php artican migrate` runs all the migrations from `database/migrations` creating all the necessary tables in configured schema. It also creates `migrations` table to keep records of all the runned migrations

#Lesson 5
- You can retrieve data passed do view via `<?= $name ?>` or `{{ $name }}`
- Pass data using second argument after view name or using `with(argument, value)` method
- Passing data as second argument you can either create new array or use `compact(parameter1, parameter2)` function
- In templates use blade directives (eg. `@foreach($tasks as $task) {{ $task }} @endforeach`) instead of php structures

#Lesson 6
- To display all the possible artisan commands use `php artisan`
- `php artisan help [commands]` displays help
- To create new migration use eg. `php artisan make:migration create_tasks_table`. It's not going to create new table
- To create new table in migration add `--create=[tableName]` option
- When you delete migration and receive an error try update the autoloader `composer dump-autoload`
- Methods creating column names correspond to the data type. You can get more information from documentation or reading source code of `Illuminate\Database\Schema\Blueprint`
  - increments
  - integer
  - string
  - text
  - timestamps
- To run migrations use `php artisan migrate`. You can refresh them using subtask `:refresh`
- Returned entities are automatically converted into JSON response
- `dd($someVariable)` allows us to show the variable value
## Passing data to url
- You can pass parameters to url using eg. `Route::get('/tasks/{task}', function ($id)`
- When `id` corresponds to some real entity you can populate it passing entity in method: `Route::get('/tasks/{task}', function (Task $task)`
 
# Lesson 7
- Create model with `php artisan make:model Task`
## Tinker
- To play with php and eloquent use `php artisan tinker`
- `App\Task::all())` - get all entities
- You can use conditionals like `App\Task::where('id', '>', 2)->get();`
- If you don't use `get` method you'll receive `Illuminate\Database\Eloquent\Builder object
- To get only one field from all records use `App\Task::pluck('body')`
- The result is `Illuminate\Database\Eloquent\Collection`. It contains methods like `first`
- Upon creating new entity via `$task = new App\Task;` and setting values using `$task->body = 'Go to the market';` you can save it invoking `$task->save();`


- `php artisan migrate:reset` rolls back all the migrations
- To automatically create migration while creating model use `php artisan make:model Task --migration`
- If you want to specify default value for entity use `$table->boolean('completed')->default(false);`
- You can use static function to facilitate fetching data from database
```php
public static function incomplete()
{
    return static::where('completed', 0)->get();
}
```
- When we want to make constructions like `App\Task::incomplete()->get()->where('id', '>', 1)` we have to resort to local scopes like in
```php
public function scopeIncomplete($query)
{
    return $query->where('completed', 0);
}
```

# Lesson 8
- The method returning all the items is often called `index`
- New controllers are created with `php artisan make:controller TasksController`

# Lesson 9
- Route model binding is the ability to bind model when its id is passed in url. The route name must match parameter name. The laravel will perform `Task::find(id)` and use primary key to find entity
```php
Route::get('/tasks/{task}', 'TasksController@show');
```
```php
public function show (Task $task) {
    return view('tasks.show', compact('task'));
}
```

# Lesson 10
- To specify place where content should be inserted use directive `@yield('content')`
- Instead creating separately model, controller and migration, use `make:model` flags `-m -c`
- To use layout utilize `@section` and `@extends` directives:
```php
@extends('layout)
@section('content')

@endsection
```
- To include some content use `@include('layouts.nav')`
- There is a convention to keep your layout partials in `layout` directory and name the main layout file `master`

# Lesson 11
## REST review
- GET /posts - displays all the posts
- GET /posts/create - displays form for adding new form
- POST /posts - adds new form
- GET /posts/{id}/edit - displays form to edit post with specified id
- GET /posts/{id} - shows the post
- PATCH /posts/{id} - updated the post
- DELETE /posts/{id} - deletes the post


- When you generate controller add the flag `-r` to generate resourceful controller with all the necessary methods
- `request()->all()` gives all the request parameters. You can get only one field with `request('fieldName')` or selected fields with `request(['title', 'body'])`
- Laravel generates a csrf token which has to be passed in field with `{{ csrf_field() }}`. The fields looks like this: ` "_token" => "RatQYPlj5RRjsWyqCiNhw0BcOcTTYz0QjeS55tTW"`

## Creating entities
- One way is to create entities using
```php
$post = new Post;
$post->title = request('title');
$post->body = request('body');
$post->save();
```
- The other is to use:
```php
Post::create([
    'title' => request('title'),
    'body' => request('body')
]);
```
- Remember to fill in fillable field to allow the second option:
```php
class Post extends Model
{
    protected $fillable = ['title', 'body'];
}
```
- The inverse of `$fillable` is `protected $guarded = ['user_id'];`. In specific cases it can be set to empty array
- There is a technique to create your own Model to inherit from containing `$guarder` with empty array:
```php
namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{
    protected $fillable = [];
}

```

# Lesson 12
- You can't rely only on validation on client side
- Use server side validation instead:
```php
$this->validate(request(), [
    'title' => 'required',
    'body' => 'required'
]);
```
- It'll return to previous page with error fields. You can access them:
```php
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
```

#Lesson 13
- You can utilize fields `created_at` and `updated_at` to get post creation and update date
- `created_at` and `updated_at` are instances of carbon library and have many interesting methods
- To get formatted date you can use `toFormattedDateString()`
- The source code of query steps can be found in `Illuminate\Database\Query\Builder`
- The modifier `latest()` works like `orderBy` with field `created_at`

#Lesson 14
- Laravel mix is a npm dependency

# Lesson 15
- `Comment::class` is equivalent of `"\App\Comment"`
- First side of one to many relationship is created using `hasMany` function
```php
public function comments()
{
    return $this->hasMany(Comment::class);
}
```
- The other side is created with `belongsTo`
```php
public function post()
{
    return $this->belongsTo(Post::class);
}
```
- You can access each side via field: `\App\Post::find(1)->comments`

# Lesson 16
- Don't nest your REST urls too much
- Use `back()` helper function to redirect to the previous page
- While creating subentity you can:
  - create it in controller
  - create it in entity using `Subentity::create`
  - create it in entity using `$this->subentities()->create(['field' => 'value'])`

# Lesson 17
- `php artisan make:auth` scaffolds basic authentication mechanism
- It creates authentication routes in `web.php` (`Auth::routes();`)
- Configuration files in `config` directory reference `.env` files which should not be commited into repository
- Changing `DB_CONNECTION` you can change database driver used in `config/database.php` configuration file. The unnecessary properties can be removed
- The list of middleware run during every request is in `Kernel.php` file
- `php artisan down` turns application down for maintanance. It is handled by `CheckForMaintenanceMode` middleware
- Route middleware can be assigned to route groups. It contains middlewares to restrict access to guests, authenticated users etc.
- Route middleware can be used in constructor of a router
- You can adapt autogenerated registration mechanism for your needs
- Instead of smpt mail driver you can use log and see the results in `storate/logs/laravel.log`

#Lesson 18
- You can create new user with tinker
- Create new password using `$user->password = bcrypt('password');`
