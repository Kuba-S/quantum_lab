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
# Usage examples
```
./demo.php list

./demo.php find "Kowalski"
./demo.php find "Jan"
./demo.php find "Jan Kowalski"
./demo.php find "Jan K"
./demo.php find "an Kowal"

./demo.php languages php java
./demo.php addPerson Imię Nazwisko język1 język2 

./demo.php removePerson ID

./demo.php addLanguage nazwa

/demo.php removeLanguage nazwa
```
