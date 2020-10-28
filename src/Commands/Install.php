<?php

namespace Larke\Auth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

use Encore\Admin\Auth\Database\Menu;

/**
 * 安装脚本
 *
 * php artisan larke-auth:install
 */
class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'larke-auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'larke-auth install.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 执行数据库
        $installSqlFile = __DIR__.'/../../database/install.sql';
        $dbPrefix = DB::getConfig('prefix');
        $sqls = file_get_contents($installSqlFile);
        $sqls = str_replace('pre__', $dbPrefix, $sqls);
        DB::unprepared($sqls);
        
        $this->info(__('larke-auth 安装成功'));
    }
}
