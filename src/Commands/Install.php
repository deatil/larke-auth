<?php

namespace Larke\Auth\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        
        $sqlData = File::get($installSqlFile);
        if (empty($sqlData)) {
            $this->line("<error>Sql file is empty !</error> ");
            return;
        }
        
        $dbPrefix = DB::getConfig('prefix');
        $sqlContent = str_replace('pre__', $dbPrefix, $sqlData);
        DB::unprepared($sqlContent);
        
        $this->info('Install successfully.');
    }
}
