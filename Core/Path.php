<?php
    namespace ApiFramework\Core;

    class Path {
        public string $pathStr;

        public string $controller;

        public string $method;

        public RequestMethod $requestMethod;
    }