# About application

Application written in DDD approach with CQRS.

Storage configuration is configured in config.json file.

Routing for cli commands with handlers for them are configured in routing.json.
Application allows to define request mappings, validators and response formatting for each route.

```
"find": {
    "class": "QL\\Domain\\Person\\ReadModel\\FindPersonHandler",
    "method": "findPersonByName",
    "mapTo": "QL\\Domain\\Person\\ReadModel\\FindPersonByNameQuery",
    "formatter": "QL\\Formatter\\PersonCliFormatter",
    "validator" : "QL\\Domain\\Person\\ReadModel\\FindPersonByNameQueryValidator"
}
```
