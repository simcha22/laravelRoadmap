# Laravel Controllers

### Defining Controllers

```shell
php artisan make:controller UserController
```

```php
<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
 
class UserController extends Controller
{
    /**
     * Show the profile for a given user.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }
}
```
```php
use App\Http\Controllers\UserController;
 
Route::get('/user/{id}', [UserController::class, 'show']);
```
### Single Action Controllers
```shell
php artisan make:controller ProvisionServer --invokable
```
```php
<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
 
class ProvisionServer extends Controller
{
    /**
     * Provision a new web server.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke()
    {
        // ...
    }
}
```
```php
use App\Http\Controllers\ProvisionServer;
 
Route::post('/server', ProvisionServer::class);
```
```php 
```
```php
```
```php
```
```php
```
```php
```
