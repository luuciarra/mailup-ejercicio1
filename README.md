
# Ejercicio 1: Listado de Productos
## Consideraciones generales:
## URL
{{api_url}} será la url que se utilice para la api.
## Headers
Todos los request deberán incluir los siguientes headers
Accept application/json
## Resultados
Todos los datos vendrán dentro del parámetro `data`
### Paginación
La devolución incluirá un parámetro `meta` con información sobre la paginación:

| Nombre | Description | **Opcional** | **Valor por defecto** |
| --- | --- | --- | --- |
| page | Pagina actual de el request | Si | 1 |
| perPage | Cantidad de registros que se obtendrán en el request | Si | 10 |
| order_column | permite ordenar a través de una columna | Si | id |
| order_direction | permite ordernar de forma ascendente o descendente | Si. opciones: asc,desc | asc |
## Listado
Los listados permiten paginación

#End Points
## List (GET)
Obtiene el listado de productos
>```
>{{app_url}}/api/products
>```

### Headers
|Content-Type|Value|
|---|---|
|Accept|application/json|

### Query Params
|Parametro|Obligatorio|
|---|---|
|search|No|
|order_column|No|
|order_direction|No|
|category|No|
|perPage|No|
|page|No|

#### Ejemplo de respuesta (Código: 200)
>```
>{
>    "data": [
>        {
>            "id": 51,
>            "name": "Nombre del producto",
>            "image": "https://fastly.picsum.photos/id/353/536/354.jpg?hmac=MivqBW0rK4YhndFpU3sWqunj-RYdu41N2j1ngqCDYpI",
>            "brand": "Samsung",
>            "category": "Monitor",
>            "price": "1000.00",
>            "price_string": "$1.000",
>            "discount": 10,
>            "price_sale": "900.00",
>            "price_sale_string": "$900",
>            "has_stock": true
>        },
>        ...
>        {
>            "id": 43,
>            "name": "necessitatibus",
>            "image": "https://via.placeholder.com/640x480.png/00cc44?text=necessitatibus+image+quisquam",
>            "brand": "TCL",
>            "category": "Monitor",
>            "price": "980.88",
>            "price_string": "$980,88",
>            "discount": 28,
>            "price_sale": "706.23",
>            "price_sale_string": "$706,23",
>            "has_stock": true
>        }
>    ],
>    "meta": {
>        "page": 1,
>        "perPage": 10,
>        "search": null,
>        "order_column": "price",
>        "order_direction": "desc",
>        "total": 49,
>        "count": 10,
>        "more_pages": true,
>        "total_pages": 5
>    }
>}
>```

___

## Show (GET)
Obtiene el detalle de un producto
>```
>{{app_url}}/api/products/{product_id}
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/json|

#### Ejemplo de respuesta (Código: 200)
>```
>{
>    "data": {
>        "id": 2,
>        "name": "dolore",
>        "image": "https://via.placeholder.com/640x480.png/001144?text=dolore+image+non",
>        "brand": "Samsung",
>        "category": "Monitor",
>        "description": "Autem ab ipsam numquam quia adipisci.<br><br>Dicta et nobis rerum est et ut eum.<br><br>Praesentium laboriosam rerum vero natus dolorum temporibus.<br><br>Consequatur incidunt sunt a ut aut magni.",
>        "price": 931.63,
>        "price_string": "$931,63",
>        "discount": 37,
>        "price_sale": 586.93,
>        "price_sale_string": "$586,93",
>        "stock": 18,
>        "has_stock": true
>    }
>}
>```

___

## Create (POST)
Crea un producto
>```
>{{app_url}}/api/products
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/json|

#### Ejemplo de respuesta (Código: 200)
>```
>{
>    "data": {
>        "id": 51,
>        "name": "Nombre del producto",
>        "image": "https://fastly.picsum.photos/id/353/536/354.jpg?hmac=MivqBW0rK4YhndFpU3sWqunj-RYdu41N2j1ngqCDYpI",
>        "brand": "Samsung",
>        "category": "Monitor",
>        "description": null,
>        "price": 1000,
>        "price_string": "$1.000",
>        "discount": 10,
>        "price_sale": 900,
>        "price_sale_string": "$900",
>        "stock": 20,
>        "has_stock": true
>    }
>}
>```

___

## Update (PUT)
Actualiza un producto
>```
>{{app_url}}/api/products/{product_id}
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/json|

>```
>{
>    {
>        "data": {
>            "id": 2,
>            "name": "Nombre del producto actualizado",
>            "image": "https://via.placeholder.com/640x480.png/001144?text=dolore+image+non",
>            "brand": "Samsung",
>            "category": "Monitor",
>            "description": "Autem ab ipsam numquam quia adipisci.<br><br>Dicta et nobis rerum est et ut eum.<br><br>Praesentium laboriosam rerum vero natus dolorum temporibus.<br><br>Consequatur incidunt sunt a ut aut magni.",
>            "price": 1000,
>            "price_string": "$1.000",
>            "discount": 10,
>            "price_sale": 900,
>            "price_sale_string": "$900",
>            "stock": 18,
>            "has_stock": true
>        }
>    }
>}
>```

___

## Delete (DELETE)
Elimina un producto
>```
>{{app_url}}/api/products/{product_id}
>```
### Headers

|Content-Type|Value|
|---|---|
|Accept|application/json|

#### Ejemplo de respuesta (Código: 200)
>```
>{
>    "id": 6,
>    "name": "ipsam",
>    "image": "https://via.placeholder.com/640x480.png/004488?text=ipsam+image+assumenda",
>    "brand": "Apple",
>    "category": "Monitor",
>    "description": "Deserunt ut deleniti dolorem autem.<br><br>Illo et corrupti maiores cum sed earum.<br><br>Reiciendis quia et a voluptatem.<br><br>Error modi ipsam error fugit.<br><br>Exercitationem est et et dolorem quis quia sit.",
>    "price": "971.19",
>    "discount": 11,
>    "price_sale": "864.36",
>    "stock": 0,
>    "created_at": "2023-11-19T21:26:57.000000Z",
>    "updated_at": "2023-11-19T21:26:57.000000Z",
>    "deleted_at": null,
>    "hasStock": false
>}
>```