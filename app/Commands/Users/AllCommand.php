<?php

namespace App\Commands\Users;

use App\Storage\StorageInterface;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;
use Psr\Log\LoggerInterface as Log;

class AllCommand extends Command
{
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

    public function handle() 
    {
        try {
            $path = $this->argument('path');

            if (!file_exists($path)) {
                $this->error('An error occurred while processing the XML file: Unable to open file.');
                return 1;
            }

            $xml = simplexml_load_file($path);

            if ($xml === false) {
                $errorMessage = 'An error occurred while processing the XML file: Malformed XML.';
                $this->error($errorMessage);
                $this->logger->error($errorMessage);
                return 1;
            }

            foreach ($xml->item as $item) {
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
        } catch (\Exception $e) {
            $errorMessage = 'An error occurred while processing the XML file: ' . $e->getMessage();
            $this->error($errorMessage);
            $this->logger->error($errorMessage);
            return 1;
        }
    }

    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
