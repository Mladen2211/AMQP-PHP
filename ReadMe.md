###Services###
To be able to store and read the HTTP API , after starting erlang and rabbitmq with the terminal:

	erl -s (start erlang)
	rabbitmq plugins enable rabbitmq_management (start rabbitmq)
start the RabbitMq service-Start.

Then run the service_B with the comand:
	
	php service_B.php


###HTTP API###

For sending the HTTP API i was using Postman. The API was sent with the POST request, key set as message and value:

{
	"amount": 1123.4,
	"currency": "EUR",
}

After posting the API, i've sent the GET request to service_A to get the changes out of the database.

*If not running locally change the config & DBconn files.*