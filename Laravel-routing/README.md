 # Laravel routing 
 
### Redirects
```php
Route::redirect('/here', '/');

Route::redirect('/here', '/there', 301);

Route::permanentRedirect('/here', '/there');
```

### Route Parameters
- 1
```php
Route::get('/user/{id}', function ($id) {
    return 'User '.$id;
});

Route::get('/posts/{post}/comments/{comment}', function ($postId, $commentId) {
    dd($postId, $commentId);
});
```
- 2
```php
use Illuminate\Http\Request;
 
Route::get('/user/{id}', function (Request $request, $id) {
    return 'User '.$id;
});
```
- 3
```php
Route::get('/user/{name?}', function ($name = 'simcha') {
    return $name;
});
```
- 4
```php
Route::get('/user/{name}', function ($name) {
    //
})->where('name', '[A-Za-z]+');
 
Route::get('/user/{id}', function ($id) {
    //
})->where('id', '[0-9]+');
 
Route::get('/user/{id}/{name}', function ($id, $name) {
    //
})->where(['id' => '[0-9]+', 'name' => '[a-z]+']);
```
```php
// 
Route::get('/user/{id}/{name}', function ($id, $name) {
    //
})->whereNumber('id')->whereAlpha('name');
 
Route::get('/user/{name}', function ($name) {
    //
})->whereAlphaNumeric('name');
 
Route::get('/user/{id}', function ($id) {
    //
})->whereUuid('id');
 
Route::get('/category/{category}', function ($category) {
    //
})->whereIn('category', ['movie', 'song', 'painting']);
```
- 5 
```php
App\Providers\RouteServiceProvider

public function boot()
{
    Route::pattern('id', '[0-9]+');
}
```
- 6
```php
Route::get('/search/{search}', function ($search) {
return $search;
})->where('search', '.*');
```

### Named Routes 

- 1
```php
Route::get('/user/profile', function () {
    //
})->name('profile');
```
- 2
```php
$url = route('profile');

return redirect()->route('profile');
 
return to_route('profile');

Route::get('/user/{id}/profile', function ($id) {
    //
})->name('profile');
 
$url = route('profile', ['id' => 1]);
```
- 3
```php
Route::get('/user/{id}/profile', function ($id) {
    //
})->name('profile');
 
$url = route('profile', ['id' => 1, 'photos' => 'yes']);
 
// /user/1/profile?photos=yes
```
- 4
```php
public function handle($request, Closure $next)
{
if ($request->route()->named('profile')) {
//
}
```

### Route Groups

- 1
```php
Route::middleware('simple')->group(function (){
    Route::get('/simple/user');
    Route::get('/simple/user/b');
});
```
- 2
```php
Route::controller(\App\Http\Controllers\HomeController::class)->group(function(){
    Route::get('/index/user', 'index');
    Route::get('/create/user', 'create');
});
```
- 3
```php
Route::domain('{account}.example.com')->group(function () {
    Route::get('user/{id}', function ($account, $id) {
        //
    });
});
```
- 4
```php
Route::prefix('admin')->group(function () {
    Route::get('/users', function () {
        dd('/admin/users" URL');
    });
});
```
- 5
```php
Route::name('admin.')->group(function () {
    Route::get('/users', function () {
        // Route assigned name "admin.users"...
    })->name('users');
});
```

### Route Model Binding

- 1
```php
use App\Models\User;
 
Route::get('/users/{user}', function (User $user) {
    return $user->email;
});
```
- 2
```php
Route::get('/users/{user}', [\App\Http\Controllers\HomeController::class, 'update'])
->withTrashed();
```
- 3
```php
use App\Models\Post;
 
Route::get('/posts/{post:slug}', function (Post $post) {
    return $post;
});
```
```php
App\Models\Post;

public function getRouteKeyName()
{
    return 'slug';
}
```
- 4
```php
use App\Models\Post;
use App\Models\User;
 
Route::get('/users/{user}/posts/{post:slug}', function (User $user, Post $post) {
    return $post;
});

Route::get('/users/{user}/posts/{post}', function (User $user, Post $post) {
    return $post;
})->scopeBindings();

Route::scopeBindings()->group(function () {
    Route::get('/users/{user}/posts/{post}', function (User $user, Post $post) {
        return $post;
    });
});
```
- 5
```php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
 
Route::get('/users/{user}/posts/{post}', [PostController::class, 'show'])
        ->missing(function (Request $request) {
            return Redirect::route('index');
        });
```
- 6
```php
use App\Enums\Category;
 
Route::get('/categories/{category}', function (Category $category) {
    return $category->value;
});
```
- 7
```php
App\Providers\RouteServiceProvider

public function boot()
{
    // 1
    Route::model('user', User::class);
    
    // 2
    Route::bind('user', function ($value) {
        return User::where('name', $value)->firstOrFail();
    });
}
```
- 8 
```php
public function resolveRouteBinding($value, $field = null)
{
    return $this->where('name', $value)->firstOrFail();
}
// 2
public function resolveChildRouteBinding($childType, $value, $field)
{
    return parent::resolveChildRouteBinding($childType, $value, $field);
}
```
### Fallback Routes
```php
Route::fallback(function () {
    //
});
```
### Rate Limiting 
- 1
```php
protected function configureRateLimiting()
{
    RateLimiter::for('global', function (Request $request) {
        return Limit::perMinute(1000);
    });
}
```
- 2
```php
RateLimiter::for('global', function (Request $request) {
    return Limit::perMinute(1000)->response(function (Request $request, array $headers) {
        return response('Custom response...', 429, $headers);
    });
});
```
- 3
```php
RateLimiter::for('uploads', function (Request $request) {
    return $request->user()->vipCustomer()
                ? Limit::none()
                : Limit::perMinute(100);
});

RateLimiter::for('uploads', function (Request $request) {
    return $request->user()->vipCustomer()
                ? Limit::none()
                : Limit::perMinute(100)->by($request->ip());
});
```
- 4
```php
RateLimiter::for('uploads', function (Request $request) {
    return $request->user()->vipCustomer()
                ? Limit::none()
                : Limit::perMinute(100)->by($request->ip());
});

RateLimiter::for('uploads', function (Request $request) {
    return $request->user()
                ? Limit::perMinute(100)->by($request->user()->id)
                : Limit::perMinute(10)->by($request->ip());
});
```
- 5
```php
RateLimiter::for('login', function (Request $request) {
    return [
        Limit::perMinute(500),
        Limit::perMinute(3)->by($request->input('email')),
    ];
});
```
- 6
```php
Route::middleware(['throttle:uploads'])->group(function () {
    Route::post('/audio', function () {
        //
    });
 
    Route::post('/video', function () {
        //
    });
});
```
