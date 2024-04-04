# Version 3.0.0

* The `bg_object_routing.adapter` service has been removed. It was an alias for `JMS\ObjectRouting\RouterInterface`, use that service ID instead (or use autowiring).
* The `bg_object_routing.object_router` service has been removed. It was an alias for `JMS\ObjectRouting\ObjectRouter`, use that service ID instead (or use autowiring).
* The `AnnotationDriver` has been removed from the driver chain. Use PHP 8 attributes instead of annotations for object route definitions. 

# Version 2.0.0

* The `bg_object_routing.adapter.symfony_21` service has been removed. If
  you were redefining this service to make the object router use another
  `adapter` implementation (and thus, another Symfony `Router`?), you
  must update your service definition. The recommended approach is to 
  make the `bg_object_routing.adapter` alias point to an 
  `\JMS\ObjectRouting\RouterInterface` implementation of your choice.



