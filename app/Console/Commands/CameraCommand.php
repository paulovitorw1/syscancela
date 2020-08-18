<?php

namespace App\Console\Commands;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\WebDriverException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Illuminate\Console\Command;

require_once 'vendor/autoload.php';

class CameraCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'camera:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Comando para fazer login nas camera';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $host = 'http://localhost:4444/wd/hub';

        // Adicionando o tipo do navegador e colocando a opção --headless para rodar em background
        $capacidades = DesiredCapabilities::chrome();
        $chromeOption = new ChromeOptions();
        $chromeOption->addArguments(["--headless"]);
        // $capacidades->setCapability(ChromeOptions::CAPABILITY, $chromeOption);
        $driver = RemoteWebDriver::create($host, $capacidades);
        try {
            $driver->get("http://google.com");
            $driver->executeScript(
                "
                    var segundos = 0
                    var newWindow = window.open('http://admin:KFesH0I3@10.50.0.110/video/mjpg.cgi?profileid=3')
                    function esperar(){
                        segundos++
                        if(segundos==10){
                            newWindow.close()
                        }
                    }
                    setInterval(esperar, 100)
                    window.close()
                "
            );
            sleep(11);
            $driver->quit();

        } catch (WebDriverException $e) {
        }

    }
}
