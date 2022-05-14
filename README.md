# ApiFramework
A lightweight minimalist routing framework for PHP.

Controllers found in the Controllers folder must have the postfix Controller. example: ExampleController
Add methods into your controllers to be used as end points for your service.

Add your endpoint paths into Routes.php found in the Config folder.
Syntax:
Router::add("", "Home", "index", RequestMethod::All);
Router::add("user/{name}/details", "User", "details", RequestMethod::All);
Router::add404("Home", "pageNotFound");

The Router::add method takes 4 parameters. The path, The controller name (with out Controller postfix), the method name to be called when this path is requested, and
optionally the request method type for this call. (POST, GET, etc)

The path can contain variables or wildcard section which is passed into the method call as a parameter contained in an array. Wildcards are wrapped in braces {} and the text inside the braces is what the variable will be labeled when passed into the method.