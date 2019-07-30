# FoxHole-PHP

Foxhole game [warapi](https://github.com/clapfoot/warapi)

#### Composer require command
`composer require ccaglayan/foxhole-php`

## Usage

It is fairly easy to use. I'll throw in an example.

```php
use FoxHolePHP\Client;

$client = new Client();
try{
    $client->getWar(); // Get Active War Details
    $client->getMaps(); // Get Active Maps
    $client->getMapReport(MapName) //Get Selected Map War Detail
    $client->getStaticMapData(MapName) // Get Selected Map Static Data
    $client->getDynamicMapData(MapName) // Get Selected Map Dynamic Data
    
}catch(\FoxHolePHP\FoxHoleException $e) {
    echo 'Error:'.$e->getMessage().'--'.$e->getCode();
    exit;
}
```

## Contributing

Pull requests and issues are open!