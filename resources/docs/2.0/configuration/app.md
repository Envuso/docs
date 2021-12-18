# App Configuration (src/Config/AppConfiguration.ts)

### environment

This is your current environment, usually this is set as "development", "staging", "production"

### appKey

This is used to handle encryption/hashing and such.

### url

This is the base url of your application, for example, the domain where your app is running.

### providers

Service Providers are functionality of the framework, you may not need all of the features and could remove some providers, for example, websockets. You can also write your own providers to extend the
framework.

### exceptionHandler

By default, all exception handling goes through this class, by default most cases are handled, but there may be things you wish to change, which you can do via this class.

### logging

Useful for debugging certain things.
