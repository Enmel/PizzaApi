<?php

/**
* @OA\Post(
*     	path="/api/v1/register",
*     	tags={"users"},
*     	summary="Registrar",
*     	description="Da de alta a un usuario",
*     	operationId="registerUser",
*		@OA\RequestBody(
*       	@OA\MediaType(
*             	mediaType="application/json",
*             	@OA\Schema(
*                 	@OA\Property(
*                     	property="name",
*                     	type="string"
*               	),
*               	@OA\Property(
*               		property="email",
*                   	type="string"
*               	),
*					@OA\Property(
*               		property="password",
*                   	type="password"
*               	),
*					@OA\Property(
*               		property="c_password",
*                   	type="password",
*						description="Confirmacion de password"
*               	),
*               	example={"email": "enmarval@example.com", "name": "Enmanuel Marval", "password": "Linux12345@", "c_password": "Linux12345@"}
*         		)
*     		)
*     	),
*     @OA\Response(
*         response=200,
*         description="successful operation",
*         @OA\JsonContent(
*            type="object",
*            @OA\Property(
*            	property="token",
*               type="string"
*            ),
*         )
*     ),
*	  @OA\Response(
*	  	  response=400,
*		  description="Bad request")
* )
*/

/**
* @OA\Post(
*     	path="/api/v1/login",
*     	tags={"users"},
*     	summary="Login",
*     	description="Retorna el token de autorizacion",
*     	operationId="loginUser",
*		@OA\RequestBody(
*       	@OA\MediaType(
*             	mediaType="application/json",
*             	@OA\Schema(
*               	@OA\Property(
*               		property="email",
*                   	type="string"
*               	),
*					@OA\Property(
*               		property="password",
*                   	type="password"
*               	),
*               	example={"email": "enmarval@example.com", "password": "Linux12345@"}
*         		)
*     		)
*     	),
*     @OA\Response(
*         response=200,
*         description="successful operation",
*         @OA\JsonContent(
*            type="object",
*            @OA\Property(
*            	property="token",
*               type="string"
*            ),
*         )
*     ),
*	  @OA\Response(
*	  	  response=401,
*		  description="Datos incorrectos")
* )
*/

/**
* @OA\Post(
*     	path="/api/v1/getUser",
*     	tags={"users"},
*     	summary="User data",
*     	description="Retorna los datos del usuario",
*     	operationId="showUser",
*		security={
*		    {"TokenBearer": {}},
*		},
*     	@OA\Response(
*         	response=200,
*         	description="successful operation",
*         	@OA\JsonContent(
*            	type="object",
*            	@OA\Property(
*            		property="id",
*               	type="integer"
*            	),
*            	@OA\Property(
*            		property="name",
*               	type="string"
*            	),
*            	@OA\Property(
*            		property="email",
*               	type="string"
*            	),
*            	@OA\Property(
*            		property="email_verified_at",
*               	type="dateTime"
*            	),
*            	@OA\Property(
*            		property="creatde_at",
*               	type="dateTime"
*            	),
*            	@OA\Property(
*            		property="updated_at",
*               	type="dateTime"
*            	),
*         	)
*     	)
* )
*/