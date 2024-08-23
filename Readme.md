# Scandiweb Test

## Overview

This project is a part of Scandiweb Junior Developer Test Assignment.

## Description

This is a fullstack web application created using PHP for both backend and frontend with Alpine.js for frontend reactivity.



## Functionality

The website contains two pages:

- [Product list](https://scandiweb-test.infinityfreeapp.com/)
- [Add product](https://scandiweb-test.infinityfreeapp.com/add-product)

*1\. Product list page*

This page is responsible for:

- Showing all products
- Deleting products
- Links to the [Add product page](https://scandiweb-test.infinityfreeapp.com/add-product)

*2\. Add product page*

This page is responsible for:

- Adding a new product
- Links to the [Product list page](https://scandiweb-test.infinityfreeapp.com/)

## How it works

### basic workflow

Firstly the application starts at the <SwmPath>[public/index.php](/public/index.php)</SwmPath> file, it starts the session, loads the files and clears flash messages. Then the <SwmPath>[bootstrap/bootstrap.php](/bootstrap/bootstrap.php)</SwmPath>file takes over and bootstraps the entire app by loading the .env file contents using <SwmToken path="/lib/Env.php" pos="16:7:7" line-data="    public static function load(string $path)">`load`</SwmToken>method on the <SwmToken path="/lib/Env.php" pos="7:2:2" line-data="class Env">`Env`</SwmToken> class to insure all environment variables are loaded, then it initializes the router within <SwmPath>[routes/routes.php](/routes/routes.php)</SwmPath> file which instantiate a new <SwmToken path="/app/router/Router.php" pos="15:2:2" line-data="class Router">`Router`</SwmToken> instance and adds all the routes to it, then it's passing the router instance to the <SwmToken path="/lib/Helpers.php" pos="12:2:2" line-data="class Helpers">`Helpers`</SwmToken> class which is used within routing-related methods inside it like <SwmToken path="/lib/Helpers.php" pos="72:7:7" line-data="    public static function redirect(string $to): void">`redirect`</SwmToken> and <SwmToken path="/lib/Helpers.php" pos="61:7:7" line-data="    public static function route(string $name): string|null">`route`</SwmToken> methods lastly it listens to the routes using the <SwmToken path="/app/router/Router.php" pos="126:5:5" line-data="    public function watch()">`watch`</SwmToken> method.

When the user hits an endpoint the <SwmToken path="/app/router/Router.php" pos="126:5:5" line-data="    public function watch()">`watch`</SwmToken> method extracts the uri and the method out of the request then it searches for a matching uri and method inside the <SwmToken path="/app/router/Router.php" pos="22:6:6" line-data="    private array $routes = [];">`routes`</SwmToken> associative array, if it was found it executes the action assigned to the route, if not found it loads 404 page using <SwmToken path="/app/router/Router.php" pos="152:7:7" line-data="    public static function abort(int $statusCode = Http::NOT_FOUND): void">`abort`</SwmToken> method.

The actions are attached to a controller or a class in general, the <SwmToken path="/app/controllers/Controller.php" pos="7:4:4" line-data="abstract class Controller">`Controller`</SwmToken> class is resourceful and includes methods with resourceful names such as: <SwmToken path="/app/controllers/Controller.php" pos="12:7:7" line-data="    public static function index()">`index`</SwmToken>, <SwmToken path="/app/controllers/Controller.php" pos="26:7:7" line-data="    public static function store()">`store`</SwmToken> and so on. In addition to that it includes <SwmToken path="/app/controllers/Controller.php" pos="44:7:7" line-data="    public static function view(string $view, $data = [])">`view`</SwmToken> method that returns the corresponding view from the <SwmPath>[views/](/views/)</SwmPath> folder and passes any additional data  to the view if any.

The [Product list page](https://scandiweb-test.infinityfreeapp.com/) triggers the <SwmToken path="/app/controllers/ProductController.php" pos="26:7:7" line-data="    public static function index()">`index`</SwmToken> method on the <SwmToken path="/app/controllers/ProductController.php" pos="15:2:2" line-data="class ProductController extends Controller">`ProductController`</SwmToken> this method basically queries all the products using the <SwmToken path="/app/models/Product.php" pos="11:2:2" line-data="class Product extends Model">`Product`</SwmToken> model, filters out the null enteries, passes some config to the view, passes out errors as flash messages using <SwmToken path="/app/sessions/Flash.php" pos="29:7:7" line-data="    public static function get(string $key, mixed $default = null): mixed">`get`</SwmToken> method on the <SwmToken path="/app/sessions/Flash.php" pos="8:5:5" line-data=" * Class Flash">`Flash`</SwmToken> class if any and finally renders the page.

The mass delete button in the [Product list page](https://scandiweb-test.infinityfreeapp.com/) triggers the <SwmToken path="/app/controllers/ProductController.php" pos="172:7:7" line-data="    public static function destroy()">`destroy`</SwmToken> method on the <SwmToken path="/app/controllers/ProductController.php" pos="15:2:2" line-data="class ProductController extends Controller">`ProductController`</SwmToken> which validates the comming ids from the frontend then tries to delete them using <SwmToken path="/app/models/Model.php" pos="103:7:7" line-data="    public static function destroy(array $ids): bool|PDOStatement">`destroy`</SwmToken> method of the <SwmToken path="/app/models/Product.php" pos="11:2:2" line-data="class Product extends Model">`Product`</SwmToken> class then it checks for deleted items, if no items were deleted then it passes a flash message to the user using <SwmToken path="/app/sessions/Flash.php" pos="41:7:7" line-data="    public static function set(string $key, mixed $value): void">`set`</SwmToken> method of <SwmToken path="/app/sessions/Flash.php" pos="8:5:5" line-data=" * Class Flash">`Flash`</SwmToken> class then redirects the user back. This approach prevents sync errors because this application is not working on websockets, so it's not updating at real-time, this means if two users were browsing the website at the same time if they both decided to delete the same product at the same time the first request will be successful but the other would cause an error because at the time it was recieved by the server the data was already deleted. If any other errors were present we send a flash message to the user indicating there was an error (with no details).

&nbsp;

The [Add product page](https://scandiweb-test.infinityfreeapp.com/add-product) triggers the <SwmToken path="/app/controllers/ProductController.php" pos="79:7:7" line-data="    public static function create()">`create`</SwmToken> method on the <SwmToken path="/app/controllers/ProductController.php" pos="15:2:2" line-data="class ProductController extends Controller">`ProductController`</SwmToken> which renders the view for creating a new product.

When the user submits the form it triggers client side validation using javascript with the <SwmToken path="/public/assets/js/main.js" pos="62:1:1" line-data="  validate(form) {">`validate`</SwmToken> method which only checks for empty enteries. if the validaiton fails it displays the error messages instantaneously without reloading the page, if not it procceeds to the <SwmToken path="/public/assets/js/main.js" pos="84:3:3" line-data="  async submit(form) {">`submit`</SwmToken> method which sends a post request to the proper endpoint which triggers the <SwmToken path="/app/controllers/ProductController.php" pos="102:7:7" line-data="    public static function store()">`store`</SwmToken> method of the <SwmToken path="/app/controllers/ProductController.php" pos="15:2:2" line-data="class ProductController extends Controller">`ProductController`</SwmToken> class. This method instantiate a new <SwmToken path="/app/forms/AddProductForm.php" pos="16:2:2" line-data="class AddProductForm implements FormInterface">`AddProductForm`</SwmToken> instance then calls the <SwmToken path="/app/forms/AddProductForm.php" pos="44:5:5" line-data="    public function validate(array $formData): void">`validate`</SwmToken> method on it, which validates the data through the <SwmToken path="/lib/Validator.php" pos="5:2:2" line-data="class Validator">`Validator`</SwmToken> class. When validation finishes we check for any errors using <SwmToken path="/app/forms/AddProductForm.php" pos="116:5:5" line-data="    public function hasErrors(): bool">`hasErrors`</SwmToken> method if there is any errors we return them in the <SwmToken path="/app/http/Response.php" pos="12:2:2" line-data="class Response">`Response`</SwmToken>

<SwmMeta version="3.0.0" repo-id="Z2l0aHViJTNBJTNBU2NhbmRpd2ViLXRlc3QlM0ElM0FBaG1lZE9zbWFuMTAx" repo-name="Scandiweb-test"><sup>Powered by [Swimm](https://app.swimm.io/)</sup></SwmMeta>
