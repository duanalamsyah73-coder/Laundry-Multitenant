<?php
namespace App\Modules;
use Illuminate\Support\ServiceProvider;
use ReflectionClass;
abstract class ModuleServiceProvider extends ServiceProvider {
 abstract protected function moduleAlias(): string;
 public function boot(): void {
  $path = dirname((string)(new ReflectionClass($this))->getFileName());
  $this->loadViewsFrom($path.'/resources/views', $this->moduleAlias());
  foreach (glob($path.'/routes/*.php') ?: [] as $routeFile) $this->loadRoutesFrom($routeFile);
 }
}
