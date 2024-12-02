
## A query database collection for use with Laravel Pipeline

This package contains a collection of filters that can be used with Laravel Pipeline and is inspires by [l3aro/pipeline-query-collection](https://github.com/l3aro/pipeline-query-collection).

### This package is always expanded when I need additional filters.

Search for the value of the query parameter 'name' in the table column 'name'.

```php
use DartManagement\LaravelQueryPipelines;

// users?name=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name'),
])
->get();

```

Search for the value of the query parameter 'name' in the table column 'name' **or** 'description.

```php
use DartManagement\LaravelQueryPipelines;

// users?name=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name', 'description'),
])
->get();

```

Search for the value of the query parameter 'name' in the table column 'name' **und** 'description.

```php
use DartManagement\LaravelQueryPipelines;

// users?name=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name', 'description')->all(),
])
->get();

```

Search for the value of the query parameter 'not_like_column' in the table column 'name'.

```php
use DartManagement\LaravelQueryPipelines;

// users?not_like_column=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name')->queryParameter('not_like_column'),
])
->get();

```

Search for the value 'Laravel' in the table column 'name'. **No request parameter is required for this.**


```php
use DartManagement\LaravelQueryPipelines;

// users?name=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name')->value('Laravel'),
])
->get();
```

Search for the value 'Laravel' in the table column 'name'. No request parameter is required for this.


```php
use DartManagement\LaravelQueryPipelines;

// users?name=Laravel
$users = Users::query()->filter([
    LikeFilter::columns('name', 'description')->value('Laravel'),
])
->get();
```


Search for the value 'Laravel' in the table column 'name' with selected wildcard direction.


```php
use DartManagement\LaravelQueryPipelines;
use \LaravelQueryPipelines\Enums\WildcardPosition;

$users = Users::query()->filter([
    LikeFilter::columns('name')->wildcard(WildcardPosition::LEFT),
])
->get();
```

## Table of Contents

* [A query database collection for use with Laravel Pipeline](#a-query-database-collection-for-use-with-laravel-pipeline)
* [Table of Contents](#table-of-contents)
* [Installation](#installation)
* [Usage](#usage)
    * [Preparing your model](#preparing-your-model)
* [Testing](#testing)
* [License](#license)

## Installation

Install the package via composer:

```bash
composer require dartmanagement/laravel-query-pipelines
```

## Usage
### Preparing your model
To use this collection with a model, you should implement the following interface and trait:

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Baro\PipelineQueryCollection\Concerns\Filterable;
use Baro\PipelineQueryCollection\Contracts\CanFilterContract;

class YourModel extends Model
{
    use Filterable;
}
```

After setup your model, you can use scope filter on your model like this

```php
YourModel::query()->filter()->get();
```

You can also override the predefined filter lists in your model like this

```php
YourModel::query()->filter([
    // the custom filter and sorting that your model need
])
->paginate();
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT).