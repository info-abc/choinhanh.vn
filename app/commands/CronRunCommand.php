<?php
# Cron job command for Laravel 4.2
# Inspired by Laravel 5's new upcoming scheduler (https://laravel-news.com/2014/11/laravel-5-scheduler)
#
# Author: Soren Schwert (GitHub: sisou)
#
# Requirements:
# =============
# PHP 5.4
# Laravel 4.2 ? (not tested with 4.1 or below)
# A desire to put all application logic into version control
#
# Installation:
# =============
# 1. Put this file into your app/commands/ directory and name it 'CronRunCommand.php'.
# 2. In your artisan.php file (found in app/start/), put this line: 'Artisan::add(new CronRunCommand);'.
# 3. On the server's command line, run 'php artisan cron:run'. If you see a message telling you the
#    execution time, it works!
# 4. On your server, configure a cron job to call 'php-cli artisan cron:run >/dev/null 2>&1' and to
#    run every five minutes (*/5 * * * *)
# 5. Observe your laravel.log file (found in app/storage/logs/) for messages starting with 'Cron'.
#
# Usage:
# ======
# 1. Have a look at the example provided in the fire() function.
# 2. Have a look at the available schedules below (starting at line 132).
# 4. Code your schedule inside the fire() function.
# 3. Done. Now go push your cron logic into version control!
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
class CronRunCommand extends Command {
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'cron:run';
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Run the scheduler';
	/**
	 * Current timestamp when command is called.
	 *
	 * @var integer
	 */
	protected $timestamp;
	/**
	 * Hold messages that get logged
	 *
	 * @var array
	 */
	protected $messages = array();
	/**
	 * Specify the time of day that daily tasks get run
	 *
	 * @var string [HH:MM]
	 */
	protected $runAt = '08:00';
	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->timestamp = time();
	}

	public function runFile($viewMobile, $viewPc, $fileMobile, $filePc)
	{
		$viewPath = app_path().'/views/site/htmlpage';

    	$html = View::make($viewMobile)->render();
    	// $filePath = public_path().FOLDER_HTML_CODE.'/index_mobile.php';
    	$filePath = $viewPath.'/'.$fileMobile;
    	file_put_contents($filePath, $html);

    	$html = View::make($viewPc)->render();
    	// $filePath = public_path().FOLDER_HTML_CODE.'/index_pc.php';
    	$filePath = $viewPath.'/'.$filePc;
    	file_put_contents($filePath, $html);
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		//views clear
		echo 'views->clear -- ';
		Artisan::call('views:clear');
		echo 'views:clear->ok -- ';

		$viewPath = app_path().'/views/site/htmlpage';

		echo 'cronjob start';
		// trang chu
		$this->runFile('site.index_mobile', 'site.index_pc', 'index_mobile.blade.php', 'index_pc.blade.php');
		// trang game android
		$this->runFile('site.game.showlistandroid_mobile', 'site.game.showlistandroid_pc', 'page_showlistandroid_mobile.blade.php', 'page_showlistandroid_pc.blade.php');
		// trang game binh chon nhieu
		$this->runFile('site.game.gamevotemany_mobile', 'site.game.gamevotemany_pc', 'page_gamevotemany_mobile.blade.php', 'page_gamevotemany_pc.blade.php');
		// trang game hay nhat
		$this->runFile('site.game.gameplaymany_mobile', 'site.game.gameplaymany_pc', 'page_gameplaymany_mobile.blade.php', 'page_gameplaymany_pc.blade.php');
		// trang game moi nhat
		$this->runFile('site.game.gamenew_mobile', 'site.game.gamenew_pc', 'page_gamenew_mobile.blade.php', 'page_gamenew_pc.blade.php');
		// trang tai game
		$this->runFile('site.game.downloadPage_mobile', 'site.game.downloadPage_pc', 'page_downloadPage_mobile.blade.php', 'page_downloadPage_pc.blade.php');

		// trang the loai game
		$typeGame = Type::all();
		if(count($typeGame) > 0) {
			foreach($typeGame as $key => $value) {
				if (count($value->games) > 0) {
					$type = $value;
			    	$html = View::make('site.game.type_mobile')->with(compact('type'))->render();
			    	$filePath = $viewPath.'/'.'typeGame_game-'.$value->slug.'_mobile.blade.php';
			    	file_put_contents($filePath, $html);

			    	$html = View::make('site.game.type_pc')->with(compact('type'))->render();
			    	$filePath = $viewPath.'/'.'typeGame_game-'.$value->slug.'_pc.blade.php';
			    	file_put_contents($filePath, $html);
				}
			}
		}
		// danh sach tag
		$tagGame = AdminTag::all();
		if(count($tagGame) > 0) {
	        foreach ($tagGame as $key => $value) {
	            if (count($value->games) > 0) {
	                $tag = $value;
			    	$html = View::make('site.tag.tag_mobile')->with(compact('tag'))->render();
			    	$filePath = $viewPath.'/'.'tagGame_game-'.$value->slug.'_mobile.blade.php';
			    	file_put_contents($filePath, $html);

			    	$html = View::make('site.tag.tag_pc')->with(compact('tag'))->render();
			    	$filePath = $viewPath.'/'.'tagGame_game-'.$value->slug.'_pc.blade.php';
			    	file_put_contents($filePath, $html);
	            }
	        }
        }
		// danh sach category
		$categoryParentGame = CategoryParent::where('position', CONTENT)->get();
		if(count($categoryParentGame) > 0) {
			foreach($categoryParentGame as $key => $value) {
				if (count($value->games) > 0) {
					$categoryParent = $value;
			    	$html = View::make('site.game.category_mobile')->with(compact('categoryParent'))->render();
			    	$filePath = $viewPath.'/'.'categoryParent_'.$value->slug.'_mobile.blade.php';
			    	file_put_contents($filePath, $html);

			    	$html = View::make('site.game.category_pc')->with(compact('categoryParent'))->render();
			    	$filePath = $viewPath.'/'.'categoryParent_'.$value->slug.'_pc.blade.php';
			    	file_put_contents($filePath, $html);
				}
			}
		}
		// GAME DETAIL
		// $gamesList = Game::where('parent_id', '!=', '')
		// 				->whereNotNull('parent_id')
		// 				->orderBy('start_date', 'desc')
		// 				// ->skip(500)
		// 				->take(500)
		// 				->get();
		// if(count($gamesList) > 0) {
		// 	foreach($gamesList as $key => $value) {
		// 		$game = $value;
		// 		// chi tiet choi game
		// 		if(in_array($value->parent_id, [GAMEFLASH, GAMEHTML5])) {
		// 			$html = View::make('site.game.onlinemobile_cronjob')->with(compact('game'))->render();
		// 	    	$filePath = $viewPath.'/'.'game_play_'.$value->slug.'_mobile.blade.php';
		// 	    	file_put_contents($filePath, $html);

		// 	    	$html = View::make('site.game.onlineweb_cronjob')->with(compact('game'))->render();
		// 	    	$filePath = $viewPath.'/'.'game_play_'.$value->slug.'_pc.blade.php';
		// 	    	file_put_contents($filePath, $html);
		// 		}
		// 		// chi tiet download game
		//     	else {
		//     		$html = View::make('site.game.downloadmobile_cronjob')->with(compact('game'))->render();
		// 	    	$filePath = $viewPath.'/'.'game_download_'.$value->slug.'_mobile.blade.php';
		// 	    	file_put_contents($filePath, $html);

		// 	    	$html = View::make('site.game.downloadweb_cronjob')->with(compact('game'))->render();
		// 	    	$filePath = $viewPath.'/'.'game_download_'.$value->slug.'_pc.blade.php';
		// 	    	file_put_contents($filePath, $html);
		//     	}
		// 	}
		// }
		// TIN TUC
		// $news = AdminNew::orderBy('id', 'desc')
		// 	// ->skip(100)
		// 	->take(300)->get();
		// if(count($news) > 0) {
		// 	foreach($news as $key => $value) {
		// 		$inputNew = $value;
		// 		// chi tiet tin tuc: /tin-tuc/slug-...
		//     	$html = View::make('site.News.showNews_mobile')->with(compact('inputNew'))->render();
		//     	$filePath = $viewPath.'/'.'news_tin-tuc_'.$value->slug.'_mobile.blade.php';
		//     	file_put_contents($filePath, $html);

		//     	$html = View::make('site.News.showNews_pc')->with(compact('inputNew'))->render();
		//     	$filePath = $viewPath.'/'.'news_tin-tuc_'.$value->slug.'_pc.blade.php';
		//     	file_put_contents($filePath, $html);

		//     	// chi tiet tin tuc: /the-loai/slug-...
		//     	$typeNew = TypeNew::find($value->type_new_id);
		//     	$html = View::make('site.News.showNews_mobile')->with(compact('inputNew', 'typeNew'))->render();
		//     	$filePath = $viewPath.'/'.'news_'.$typeNew->slug.'_'.$value->slug.'_mobile.blade.php';
		//     	file_put_contents($filePath, $html);

		//     	$html = View::make('site.News.showNews_pc')->with(compact('inputNew', 'typeNew'))->render();
		//     	$filePath = $viewPath.'/'.'news_'.$typeNew->slug.'_'.$value->slug.'_pc.blade.php';
		//     	file_put_contents($filePath, $html);
		// 	}
		// }
		// THE LOAI TIN
		// trang tin-tuc
		
		// trang the loai


		/**
		 * EXAMPLES
		 */
		// You can use any of the available schedules and pass it an anonymous function
		// $this->everyFiveMinutes(function()
		// {
			// $this->firePc();
			// $this->fireMobile();
			// In the function, you can use anything that you can use everywhere else in Laravel.
			// Like models:
			// $affectedRows = User::where('logged_in', true)->update(array('logged_in' => false)); // Not really useful, but possible
			// // Or call artisan commands:
			// Artisan::call('auth:clear-reminders');
			// // You can append messages to the cron log like so:
			// $this->messages[] = $affectedRows . ' users logged out';
		// });
		// Another example:
		// Send the admin an email every day
		// $this->dailyAt('09:00', function()
		// {
		// 	// This uses the mailer class
		// 	Mail::send('hello', array(), function($message)
		// 	{
		// 		$message->to('admin@mydomain.com', 'Cron Job')->subject('I am still running!');
		// 	});
		// });
		// $this->finish();
		echo '--->cronjob end ';
	}
	protected function finish()
	{
		// Write execution time and messages to the log
		$executionTime = round(((microtime(true) - $_SERVER['REQUEST_TIME_FLOAT']) * 1000), 3);
		Log::info('Cron: execution time: ' . $executionTime . ' | ' . implode(', ', $this->messages));
	}
	/**
	 * AVAILABLE SCHEDULES
	 */
	protected function everyFiveMinutes(callable $callback)
	{	
		if((int) date('i', $this->timestamp) % 2 === 0) {
			call_user_func($callback);
		}
	}
	protected function everyTenMinutes(callable $callback)
	{
		if((int) date('i', $this->timestamp) % 10 === 0) call_user_func($callback);
	}
	protected function everyFifteenMinutes(callable $callback)
	{
		if((int) date('i', $this->timestamp) % 15 === 0) call_user_func($callback);
	}
	protected function everyThirtyMinutes(callable $callback)
	{
		if((int) date('i', $this->timestamp) % 30 === 0) call_user_func($callback);
	}
	/**
	 * Called every full hour
	 */
	protected function hourly(callable $callback)
	{
		if(date('i', $this->timestamp) === '00') call_user_func($callback);
	}
	/**
	 * Called every hour at the minute specified
	 *
	 * @param  integer $minute
	 */
	protected function hourlyAt($minute, callable $callback)
	{
		if((int) date('i', $this->timestamp) === $minute) call_user_func($callback);
	}
	/**
	 * Called every day
	 */
	protected function daily(callable $callback)
	{
		if(date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	/**
	 * Called every day at the 24h-format time specified
	 *
	 * @param  string $time [HH:MM]
	 */
	protected function dailyAt($time, callable $callback)
	{
		if(date('H:i', $this->timestamp) === $time) call_user_func($callback);
	}
	/**
	 * Called every day at 12:00am and 12:00pm
	 */
	protected function twiceDaily(callable $callback)
	{
		if(date('h:i', $this->timestamp) === '12:00') call_user_func($callback);
	}
	/**
	 * Called every weekday
	 */
	protected function weekdays(callable $callback)
	{
		$days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'];
		if(in_array(date('D', $this->timestamp), $days) && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function mondays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Mon' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function tuesdays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Tue' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function wednesdays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Wed' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function thursdays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Thu' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function fridays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Fri' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function saturdays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Sat' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	protected function sundays(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Sun' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	/**
	 * Called once every week (basically the same as using sundays() above...)
	 */
	protected function weekly(callable $callback)
	{
		if(date('D', $this->timestamp) === 'Sun' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	/**
	 * Called once every week at the specified day and time
	 *
	 * @param  string $day  [Three letter format (Mon, Tue, ...)]
	 * @param  string $time [HH:MM]
	 */
	protected function weeklyOn($day, $time, callable $callback)
	{
		if(date('D', $this->timestamp) === $day && date('H:i', $this->timestamp) === $time) call_user_func($callback);
	}
	/**
	 * Called each month on the 1st
	 */
	protected function monthly(callable $callback)
	{
		if(date('d', $this->timestamp) === '01' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
	/**
	 * Called each year on the 1st of January
	 */
	protected function yearly(callable $callback)
	{
		if(date('m', $this->timestamp) === '01' && date('d', $this->timestamp) === '01' && date('H:i', $this->timestamp) === $this->runAt) call_user_func($callback);
	}
}