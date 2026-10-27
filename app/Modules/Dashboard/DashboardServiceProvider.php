<?php
namespace App\Modules\Dashboard;
use App\Modules\ModuleServiceProvider;
final class DashboardServiceProvider extends ModuleServiceProvider {
 public function register(): void {}
 protected function moduleAlias(): string { return 'dashboard'; }
}
