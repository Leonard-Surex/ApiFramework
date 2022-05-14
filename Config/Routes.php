<?php
    namespace ApiFramework\Config;
    use ApiFramework\Core\Router;
    use ApiFramework\Core\RequestMethod;

    Router::add("", "Home", "index", RequestMethod::All);
    Router::add("user/list", "User", "list", RequestMethod::All);
    Router::add("user/{name}/details", "User", "details", RequestMethod::All);
    Router::add404("Home", "pageNotFound");