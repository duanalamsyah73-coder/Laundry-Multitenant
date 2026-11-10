<?php
namespace App\Modules\Account;
use App\Modules\ModuleServiceProvider;
final class AccountServiceProvider extends ModuleServiceProvider {
 public function register(): void {}
 protected function moduleAlias(): string { return 'account'; }
}
