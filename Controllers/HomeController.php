<?php
    namespace ApiFramework\Controllers;

    class HomeController {
        public function index(array $params) {
            echo "Index method in the HomeController.<br/>";
        }

        public function pageNotFound(array $params) {
            echo "Error 404<br />Page not found.";
        }
    }
