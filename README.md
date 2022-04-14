# Sum Machine

## Description

This is very simple demo project written in three hours. You can sum integer numbers and get the result via HTTP API. Crazy thing. :)

## Used things

- PHP 8.0
- Lumen framework
- Doctrine 2
- PHPUnit
- PHPStan
- PHP CS Fixer
- Composer

## API Documentation

API uses standard `data/error` answer format.

    POST /reset

Starts a new session. You will get generated session token in answer (token has UUID4 format):

```json5
{
    "data" : {
        "token" : "f1e750a1-c04f-40a6-b822-b66ca3735a50"    
    },
}
```

You should add this token value as `Token` header in every single query described below, otherwise you will get HTTP 403 error.

----

    POST /number

Adds a new number into session stack. Query params format:

    {
        "number": 45 // the number you want to add
    }

You will get renewed amount of elements in answer:

```json5
{
    "data" : {
        "count": 5
    }
}
```

----

    DELETE /number

Removes the last added number from session stack. You will get renewed amount of elements in answer:

```json5
{
    "data" : {
        "count": 4
    }
}
```

If stack doesn't contain any element already, you will get HTTP 400 error.

----

    GET /sum

Yabba-dabba-doo! Returns the sum of all numbers in session stack:

```json5
{
    "data" : {
        "sum": 123
    }
}
```


