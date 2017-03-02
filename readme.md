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

# Lesson 19
- To access input data use `\Request::input` or `request()->input`
- To redirect to home you can use `return redirect('/')` or `return redirect()->home()`. The latter method required naming the route `Route::get('/', 'PostsController@index')->name('home');
- When the field has corresponding field with suffix `confirmation`, the validation `confirmed` checks the fields' equality
- Fetch user name with `Auth::user()->name`. You can chech whether the user is logged in with `Auth::check()`
- To prevent access to all the methods except some use `$this->middleware('auth')->except(['index', 'show']);`
- Fetching user id can be done with `auth()->id()`
- When you have relation to some entities you can use method save to add another entity: `$this->posts()->save($post);`. This will save the `user_id` for us
- The method `attempt` attempts to authenticate user against the date in database `auth()->attempt(request(['email', 'password']))`
- To allow only guests using the methods use middleware `guest`: `$this->middleware('guest')`
- You can resort to mutator to automatically bcrypt password

# Lesson 20
- With eloquent you can create fairly complicated queries: `\App\Post::selectRaw('year(created_at) year, monthname(created_at) month, count(*) published')->groupBy('year', 'month')->get()->toArray()`
- Use Carbon to convert month name to month number: `Carbon::parse($month)->month`
- You can conditionally build eloquent query:
```php
public function scopeFilter($query, $filters)
{
    if ($month = $filters['month']) {
        $query->whereMonth('created_at', Carbon::parse($month)->month);
    }


    if ($year = $filters['year']) {
        $query->whereYear('created_at', $year);
    }
}
```

# Lesson 21
- View composers can bind variables on views loading. You should add them in `AppServiceProvider->boot` method
```php
view()->composer('layouts.sidebar', function($view) {
    $view->with('archives', \App\Post::archives());
});
```

# Lesson 22
- Laravel has phpunit as a dependency. You can use it typing `phpunit`. Make sure you have `vendor/bin` in your `PATH` variable
- Database factories are made with `factory('App\User')->make()`. They are located in `database/factories` directory
- To persist them use `create()` method instead: `factory('App\User')->create()`
- You can take it further and create multiple entities at once: `factory('App\User', 50)->create()`
- You can create your own factories:
```php
$factory->define(App\Post::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'title' => $faker->sentence,
        'body' => $faker->paragraph
    ];
});
```
- You can overrite the default values passing an array in `make`/`create` method:
```php
$second = factory(Post::class)->create([
    'created_at' => \Carbon\Carbon::now()->subMonth()
]);
```
- Assert count (`$this->assertCount(2, $posts);`) asserts the number of instances in collection
- Environment variables overrides used with phpunit are located in `phpunit.xml` file. Eg.
```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="CACHE_DRIVER" value="array"/>
    <env name="SESSION_DRIVER" value="array"/>
    <env name="QUEUE_DRIVER" value="sync"/>
    <env name="DB_DATABASE" value="blog_testing"/>
</php>
```
- Use transaction to roll back the database after running test
```php
use Illuminate\Foundation\Testing\DatabaseTransactions;
class ExampleTest extends TestCase
{
    use DatabaseTransactions;
}
```

# Lesson 23
- Laravel provides dependency injection for constructor and every single action

# Lesson 24
- When we want to access View, Request or App facades, we can use `view()`, `request()` and `app()` functions respectively
- If we want to bind to the container we use `App::bind('App\Billing\Stripe', function () { ... })`, eg:
```php
App::bind('App\Billing\Stripe', function () {
    return new \App\Billing\Stripe(config('services.stripe.key'));
});
```
- To access config file you can use `config('configFileName.key.subKey)`
- Resolving bound service can be done with `App::make` or `resolve()` or `app()`:
```php
$stripe = App::make('App\Billing\Stripe');
$stripe = resolve('App\Billing\Stripe');
$stripe = app('App\Billing\Stripe');
```
- You can register singleton with `App::singleton()` instead of `App::bind()`:
```php
App::singleton('App\Billing\Stripe', function () {
    return new \App\Billing\Stripe(config('services.stripe.key'));
});

$stripe1 = App::make('App\Billing\Stripe');
$stripe2 = resolve('App\Billing\Stripe');
$stripe3 = app('App\Billing\Stripe');
dd($stripe1, $stripe2, $stripe3);
```
- With `App::instance()` you can swap existing instance with new one

# Lesson 25
- Add services registration in `AppServiceProvider`'s `register()` method
- `AppServiceProvider` has `app` property to bind services: `$this->app->singleton()` 
- You can add `$app` as a function parameter when some dependencies are necessary:
```php
$this->app->singleton(Stripe::class, function ($app) {
    $app->make
    return new Stripe(config('services.stripe.key'));
});
```
- Providers in `config/app/providers` are the building blocks of Laravel
- Then the service is not required on every single page load we can defer loading it with field `protected $defer = true;` in our `ServiceProvider`
- If you have anything in your boot method, the `ServiceProvider` can't be deferred
- `php artisan make:provider` will generate service provider for you

Lesson 26
- To prepare new email class use `php artisan make:mail`. Laravel will generate `app/Mail` folder and put new email there
- Newly created email can be sent with `Mail::to($user)->send(new Welcome)`
- Globally the field "from" comes from `mail.php` configuration file
- When some fields in email class are public, they can be used in templates:
```php
class Welcome extends Mailable
{
    use Queueable, SerializesModels;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view('emails.welcome');
    }
}
```
```php
<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>Laravel</title>
</head>
<body>
    <h1>Welcome to Laracasts! {{ $user->name }}</h1>
</body>
</html>
```
- We can also pass some fields to the view using `with` method: `return $this->view('emails.welcome')->with(...)`

# Leson 27
- When the emails should suppport markdown, provide `--markdown` flag when generating them: `php artisan make:mail WelcomeAgain --markdown="emails.welcome-again"`. Such generated email class will reference markdown instead of view method
- There are button components, panel component, table component etc.
- To extract any resources from vendor files use: `php artisan vendor:publish --tag=laravel-mail`.
```
Copied Directory [/vendor/laravel/framework/src/Illuminate/Mail/resources/views] To [/resources/views/vendor/mail]
Publishing complete.
```
- You can create multiple themes. Just create new css file and set the theme name in mail configuration file

# Lesson 28
- Request classes are made with `php artisan make:request RegistrationRequest`
- The `rules` method performs validation:
```php
public function rules()
{
    return [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed'
    ];
}
```
- The `authorize` methods determines if the user is authorized to make the request:
```php
public function authorize()
{
    return true;
}
```
- Every `request(['name', 'email', 'password'])` should be replaced with `$this->only(['name', 'email', 'password'])`

# Lesson 29
- We can access session using `session()` or `request()->session()`
- To retrieve some value, provide key and default value: `session('message', 'Here is a default message')`
- To set some value, provide an array with new values: `session(['message' => 'Something custom']);`
- You can flash something to the session. Such variable will be available for only one request:
`session->flash()`. It can be useful for single use data (like error messages, notifications etc)

# Lesson 30
- To make combined primary key pass array to `primary` method of table blueprint: `$table->primary(['post_id', 'tag_id'])`
- To create many to many relationship use `$this->belongsToMany(Post::class);`
- When we fetch all Posts using `App\Post::all()` none of the tags will be fetched. To do it use `App\Post::with('tags')->get()` instead
- To attach entity to collection use attach method:
```php
$post = App\Post::first();
```
```php
$tag = App\Tag::where('name', 'personal')->first();
```
```php
$post->tags()->attach($tag->id);
// or
$post->tags()->attach($tag);
```
- There is also a detach method: `$post->tags()->detach($tag)`

# Lesson 31
- The method `getRouteKeyName` will perform where condition while binding entity on route name. It is used when the entity is injected into method. It matches the rout key to column name returned from the function
```php
public function getRouteKeyName()
{
    return 'name';
}
```
- Useful technique is to pluck some fields for the needs of composed view:
```php
public function boot()
{
    view()->composer('layouts.sidebar', function ($view) {
        $view->with('tags', \App\Tag::pluck('name'));
    });
}
```
- To fetch all the tags with some non empty collection use `\App\Tag::has('posts')`, eg:
```php
\App\Tag::has('posts')->pluck('name')
```
