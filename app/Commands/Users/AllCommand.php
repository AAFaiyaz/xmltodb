<?php

namespace App\Commands\Users;


use App\Storage\StorageInterface;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Psr\Log\LoggerInterface as Log;



class AllCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'app:all {path : The path to the XML file}';
    protected $description = 'Parse XML file to Database';
    protected $storage;
    protected $logger;

    public function __construct(StorageInterface $storage, Log $logger)
    {
        parent::__construct();

        $this->storage = $storage;

        $this->logger = $logger;

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
   public function handle() 
    {
        try {

        // Get the XML file path from the command argument
            $path = $this->argument('path');
        // Load the XML file
        
            $xml = simplexml_load_file($path);

            if ($xml === false) {
    $errors = libxml_get_errors();
    libxml_clear_errors();

    $errorMessage = "Malformed XML file: {$path}. Error: " . $errors[0]->message;
    $this->logger->error($errorMessage);  // This line logs the error message

    throw new \RuntimeException($errorMessage);
}

            // Loop through each <item> element
            foreach ($xml->item as $item) {
                // Access the fields
                $entity_id = (string) $item->entity_id;
                $CategoryName = (string) $item->CategoryName;
                $sku = (string) $item->sku;
                $name = (string) $item->name;
                $description = (string) $item->description;
                $shortdesc = (string) $item->shortdesc;
                $price = (float) $item->price;
                $link = (string) $item->link;
                $image = (string) $item->image;
                $Brand = (string) $item->Brand;
                $Rating = (int) $item->Rating;
                $CaffeineType = (string) $item->CaffeineType;
                $Count = (int) $item->Count;
                $Flavored = (string) $item->Flavored;
                $Seasonal = (string) $item->Seasonal;
                $Instock = (string) $item->Instock;
                $Facebook = (int) $item->Facebook;
                $IsKCup = (int) $item->IsKCup;

                // Now you can insert this data into your database
                $this->storage->store([
                    'entity_id' => $entity_id,
                    'CategoryName' => $CategoryName,
                    'sku' => $sku,
                    'name' => $name,
                    'description' => $description,
                    'shortdesc' => $shortdesc,
                    'price' => $price,
                    'link' => $link,
                    'image' => $image,
                    'Brand' => $Brand,
                    'Rating' => $Rating,
                    'CaffeineType' => $CaffeineType,
                    'Count' => $Count,
                    'Flavored' => $Flavored,
                    'Seasonal' => $Seasonal,
                    'Instock' => $Instock,
                    'Facebook' => $Facebook,
                    'IsKCup' => $IsKCup
                ]);
        }
        $this->info('Successfully processed the XML file and stored the data in the database.');
        } catch (\RuntimeException $e) {
        $this->error('A runtime exception occurred, please check the log file for more details.');
        $this->logger->error('A runtime exception occurred while processing the XML file: ' . $e->getMessage());
    } catch (\Exception $e) {
        $this->error('An error occurred, please check the log file for more details.');
        $this->logger->error('An error occurred while processing the XML file: ' . $e->getMessage());
    }
}

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
