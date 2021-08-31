# Response

More info needed here.


## Accessing the response

```typescript
response().notFound('Woopsie, 404');
response().redirect('https://google.com');
response().json({hello : 'world'});
response().validationFailure({email : 'Invalid email.'});
response().header('Location', 'https://google.com');
response().setResponse(
	{message : 'Oh no!'},
	StatusCodes.INTERNAL_SERVER_ERROR
).send();

// or... from a controller method

return {
	hello : 'world!'
};
```

TypeScript

Copy

And again, the same applies with response, the underlying fastify reply can be accessed via  `response().fastifyReply`
