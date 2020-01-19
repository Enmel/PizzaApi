<?php

/**
* @OA\get(
*     	path="/api/v1/reservations",
*     	tags={"reservations"},
*     	summary="Lista de reservaciones",
*     	description="Muestra una lista de las reservaciones echas por el usuario logeado",
*     	operationId="listReservations",
* 		@OA\Parameter(
*     		name="filter[status]",
*    		in="query",
*     		description="Filtra las reservaciones del usuario por estado. Estos son pending, accepted y rejected",
*			example="pending",
* 		),
* 		@OA\Parameter(
*     		name="filter[seats]",
*    		in="query",
*			required=false,
*     		description="Filtra las reservaciones del usuario por el numero de asientos exacto que se pidio",
*			example=4,
* 		),
* 		@OA\Parameter(
*     		name="filter[date]",
*    		in="query",
*			required=false,
*     		description="Filtra las reservaciones del usuario por fecha",
*           example="2020-01-01",
* 		),
*     	@OA\Response(
*         response=200,
*         description="successful operation",
*         @OA\JsonContent(
*            type="object",
*            @OA\Property(
*            	property="data",
*               type="array",
*             	@OA\Items(
*                 	type="object",
*                 	properties={
*						@OA\Property(
*            				property="id",
*               			type="integer",
*							example="1"
*            			),
*						@OA\Property(
*            				property="user",
*               			type="string",
*							example="Enmanuel Marval"
*            			),
*						@OA\Property(
*            				property="date",
*               			type="dateTime"
*            			),
*						@OA\Property(
*            				property="seats",
*               			type="string",
*							example="4"
*            			),
*						@OA\Property(
*            				property="status",
*               			type="string",
*							enum={"pending", "rejected", "accepted"}
*            			),
*					}	
*             	)
*            ),
*            @OA\Property(
*            	property="links",
*               type="object",
*				properties={
*					@OA\Property(
*            			property="first",
*               		type="string"
*            		),
*					@OA\Property(
*            			property="last",
*               		type="string"
*            		),
*					@OA\Property(
*            			property="next",
*               		type="string"
*            		),
*					@OA\Property(
*            			property="prev",
*               		type="string"
*            		),
*				}
*            ),
*            @OA\Property(
*            	property="meta",
*               type="object",
*				properties={
*					@OA\Property(
*            			property="current_page",
*               		type="integer"
*            		),
*					@OA\Property(
*            			property="from",
*               		type="integer"
*            		),
*					@OA\Property(
*            			property="last_page",
*               		type="integer"
*            		),
*					@OA\Property(
*            			property="path",
*               		type="string"
*            		),
*					@OA\Property(
*            			property="per_page",
*               		type="integer"
*            		),
*					@OA\Property(
*            			property="to",
*               		type="integer"
*            		),
*					@OA\Property(
*            			property="total",
*               		type="integer"
*            		),
*				}
*            ),
*         )
*     ),
*	  @OA\Response(
*	  	  response=400,
*		  description="Bad request")
* )
*/