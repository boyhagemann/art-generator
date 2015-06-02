<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\Block;
use Image;

class SaveBlock extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'block:save';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Save an image as a block.';

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
	public function fire()
	{
        $url = $this->argument('url');

        /** @var \Intervention\Image\Image $img */
        $img = Image::make($url);

        // Resize the image to 1 pixel, to get the average color :)
        $img->resize(1,1);

        // Get the average colors from the pixelated image
        list($red, $green, $blue) = $img->pickColor(0,0, 'array');
        $hex = $img->pickColor(0,0, 'hex');

        // Save the new or existing block
        $block = Block::firstOrNew(compact('url'));
        $block->red = $red;
        $block->green = $green;
        $block->blue = $blue;
        $block->hex = $hex;
        $block->save();

        $this->info('Block saved with id: ' . $block->getKey());
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['url', InputArgument::REQUIRED, 'The location of the image'],
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
