# Smoothie Recipe Website School Project
### Programming languages are written in German. (expectation)

PHP smoothie recipe project helps to structure my your learning and get extra motivation.  

## Start: Running the website locally

### Tasks

Administrative functionality for the program, adding/editing recipe, customizing on the front page.


### Modules

The file that auto-loads all the PHP modules are index.php located in the root directory of the program. The PHP modules are located in the page control directory.

```
function autoLoad($name)
{
$pfad = "inc/".$name.".php";
$pfad = "inc" . DIRECTORY_SEPARATOR . str_replace("\\", DIRECTORY_SEPARATOR, $name) . ".php";
if(file_exists($pfad))
{
require_once($pfad);
}
}
spl_autoload_register("autoLoad");
```

Controll.php allows the script to respond differently to different inputs.

```
if(!isset($_GET[“action”]))
{
$_GET[“action”] = “von_uns”;
}
$controller = new seitensteuerung\Seitensteuerung(); // Page Controller
echo $controller->selectPage($_GET[“action”]); // Jump to Page
```

### Page Control

I have the flexibility of switching sites in this case. In Menu, I am able to switch the content of the sites.

```
switch($this->action)
{
case “von_uns”: $this->actionVon_uns(); break;
}
protected function actionVon_uns()
{
$this->content = “<h1></h1>”;
include(“von_uns.php”);
}
```


### Classes

The classes are all located in the classes directory and are used to directly support the modules. The PDO represents a connection between PHP and a database server, an object-oriented way.

### Templates

I create a new directory for templates. The default template used as a template in order to create additional themes.

### Built With 

* [Startbootstrap](https://startbootstrap.com/themes/freelancer/) - The web template used


### Project description

https://medium.com/@zoeandreapeffer/online-recipes-maker-php-mysql-project-184892cde7c1
