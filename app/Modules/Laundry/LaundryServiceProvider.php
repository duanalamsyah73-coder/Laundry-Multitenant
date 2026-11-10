<?php
namespace App\Modules\Laundry;
use App\Modules\ModuleServiceProvider;
final class LaundryServiceProvider extends ModuleServiceProvider {
 public function register(): void {}
 protected function moduleAlias(): string { return 'laundry'; }
}
