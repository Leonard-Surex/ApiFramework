<?php
namespace ApiFramework\Core;

enum RequestMethod: string
{
    case All = "ALL";
    case Get = "GET";
    case Post = "POST";
    case Put = "PUT";
    case Patch = "PATCH";
    case Delete = "DELETE";
    case Head = "HEAD";
    case Connect = "CONNECT";
    case Options = "OPTIONS";
    case Trace = "TRACE";
} 