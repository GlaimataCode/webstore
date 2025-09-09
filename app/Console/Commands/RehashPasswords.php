<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class RehashPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwords:rehash {--dry-run : Show what would be changed without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Rehash passwords that are not using bcrypt algorithm';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();
        $rehashCount = 0;

        $this->info('Checking passwords for all users...');

        foreach ($users as $user) {
            $password = $user->password;

            // Check if password is already hashed with bcrypt
            if (Hash::isHashed($password) && Hash::driver('bcrypt')->isUsingCorrectAlgorithm($password)) {
                $this->line("User {$user->email}: Password is already bcrypt hashed");
                continue;
            }

            $this->warn("User {$user->email}: Password needs rehashing");

            if (!$this->option('dry-run')) {
                // Rehash the password
                $user->password = Hash::make($password);
                $user->save();
                $this->info("User {$user->email}: Password rehashed successfully");
            }

            $rehashCount++;
        }

        if ($this->option('dry-run')) {
            $this->info("Dry run completed. {$rehashCount} users would be rehashed.");
        } else {
            $this->info("Rehashing completed. {$rehashCount} users were rehashed.");
        }

        return Command::SUCCESS;
    }
}
