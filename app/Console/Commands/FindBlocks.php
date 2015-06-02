<?php namespace App\Console\Commands;

use App\Helpers\Flickr;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class FindBlocks extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'block:find';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Search for images to use as blocks on a canvas.';

    /**
     * @var Flickr
     */
    protected $client;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Flickr $client)
	{
		parent::__construct();

        $this->client = $client;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
        $q = $this->argument('q');

        $this->info(sprintf('Search for "%s"', $q));

        $photos = $this->client->search($q);

        $this->info(sprintf('Analyzing the images...', $q));

        foreach($photos as $photo) {
            $url = $photo['url_z'];
            $this->call('block:save', compact('url'));
        }

        $this->info('All done!');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['q', InputArgument::REQUIRED, 'The query string to search for'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
//			['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
