<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="ApiPizza",
 *      description="Api para pedidos de comida",
 *      @OA\Contact(
 *          email="enmelm@gmail.com"
 *      ),
 *     	@OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 */

/**
 *  @OA\Server(
 *      url="http://apipizza.test/",
 *      description="Servidor local de pruebas"
 * )
 */


/**
 * @OA\Get(
 *      path="/",
 *      description="Home page",
		security={
		    {"TokenBearer": {}},
		    },
 *     @OA\Response(response="default", description="Pagina inicial de administracion")
 * )
 */


/**
 * @OA\Tag(
 *     name="orders",
 *     description="Pedir comida, y listar las ordenes activas o pendientes",
 * )
 */

/**
* @OA\Tag(
*     name="reservations",
*     description="Crear reservaciones y listar reservaciones pendientes o aceptadas",
* )
*/

/**
* @OA\Tag(
*     name="foods",
*     description="listar recurso de comida",
* )
*/

/**
* @OA\Tag(
*     name="categories",
*     description="listar categorias de la comida",
* )
*/

/**
* @OA\Tag(
*     name="tables",
*     description="listar mesas disponibles",
* )
*/

/**
* @OA\Tag(
*     name="users",
*     description="operaciones sobre usuarios",
* )
*/
